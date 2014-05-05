<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class IMCI extends MY_Controller
{
    
    function __construct() {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->model('imci_model');
        $this->load->module('guidelines_policy');
    }
    
    public function index() {

        $data['contentView'] = "imci/index";
        $data['title'] = "Program Monitor :: IMCI Training";
        $data['brand'] = 'IMCI';
        $data_to_export = $this->db->get('activities');
        $data_to_export = $data_to_export->result_array();
        $data['data_to_export'] = $data_to_export;
        $data['activity_table'] = $this->load_activity_list();
        $data['facility_list'] = $this->facility_list();
        $data['department_list'] = $this->department_list();
        $data['cadre_list'] = $this->cadre_list();
        $data['cadre_list'] = $this->cadre_list();
        $data['HCW_number'] = $this->total(10);
        $data['TOT_number'] = $this->total(8);
        $data['latest_HCW_training'] = $this->latest_training(10);
        $data['latest_TOT_training'] = $this->latest_training(8);
        $data['HCW_mini'] = $this->getHCWData('HCW mini');
        $data['HCW_progress'] = $this->getHCWData('HCW Progress');
        $data['HCW_table'] = $this->getHCWData('HCW Table');
        $data['HCW_Facility_progress'] = $this->getHCWData('Facility Progress');
        $data['HCW_Facility_table'] = $this->getHCWData('Facility Table');
        
        $data['TOT_mini'] = $this->getTOTData('TOT mini');
        $data['TOT_progress'] = $this->getTOTData('TOT Progress');
        $data['TOT_table'] = $this->getTOTData('TOT Table');
        $data['TOT_Facility_progress'] = $this->getTOTData('Facility Progress');
        $data['TOT_Facility_table'] = $this->getTOTData('Facility Table');
        
        $data['IMCI_guidelines_total'] = $this->guidelines_policy -> total_distributed(35);
        $data['Diarrhoea_guidelines_total'] = $this->guidelines_policy -> total_distributed(34);
        $data['ORT_guidelines_total'] = $this->guidelines_policy -> total_distributed(36);
        
        $this->template($data);
    }
    
    public function showUpload() {
        $this->load->view('forms/upload_training');
    }
    public function upload() {
        
        //var_dump($_POST);die;
        $this->load->module('upload');
        $activity_id = $_POST['activity_id'];
        $this->upload->data_upload(0, $activity_id, 'subprogramlog');
        redirect('imci');
    }
    
    public function manual_entry() {
        
        $data = $this->input->post();
        $activity_id = $data['activity_id_man'];
        unset($data['activity_id_man']);
        
        //  echo '<pre>'; print_r($data);echo '</pre>';
        foreach ($data as $key => $column) {
            foreach ($column as $col => $val) {
                $results[$col][$key] = $val;
                $results[$col]['upload_date'] = time();
                $results[$col]['activity_id'] = $activity_id;
            }
        }
        
        $results1 = array();
        foreach ($results as $key => $row) {
            foreach ($row as $col => $val) {
                if ($col == 'dates') {
                    $results1[$key][$col] = strtotime($val);
                } else {
                    $results1[$key][$col] = $val;
                }
            }
        }
        
        $this->db->insert_batch('subprogramlog', $results1);
        redirect('imci');
    }
    
    public function template($data) {
        $data['show_menu'] = 0;
        $data['show_sidemenu'] = 0;
        $this->load->module('template');
        $this->template->index($data);
    }
    
    public function load_activity_list() {
        $results = $this->global_model->getActivities('IMCI Training');
        $tmpl = array('table_open' => '<div class="table-container"><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');
        
        $this->table->set_template($tmpl);
        
        //set table headers
        $this->table->set_heading('Activity', 'Last Updated', 'Recent Dataset Date', 'Action');
        foreach ($results->result() as $activity) {
            
            $this->db->select_max('upload_date');
            $logs = $this->db->get_where('subprogramlog', array('activity_id' => $activity->activity_id));
            foreach ($logs->result() as $log) {
                if ($log->upload_date == NULL) {
                    $last_updated = 'Not Uploaded';
                } else {
                    $last_updated = date("d-M-Y H:i", $log->upload_date);
                }
            }
            $this->db->select_max('dates');
            $datasets = $this->db->get_where('subprogramlog', array('activity_id' => $activity->activity_id));
            foreach ($datasets->result() as $dataset) {
                if ($dataset->dates == NULL) {
                    $recent_dataset = 'No Recent Data';
                } else {
                    $recent_dataset = date("d-M-Y", $dataset->dates);
                }
            }
            $activity_action = "<a href='#' class='btn-xs btn-primary imci_manual_update' id='" . $activity->activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info imci_activity_upload' id='" . $activity->activity_id . "' >Upload</a>
            <a href='#' class='btn-xs  imci_activity_source' id='" . $activity->activity_id . "' >View Source Data</a>";
            $this->table->add_row($activity->activity_name, $last_updated, $recent_dataset, $activity_action);
        }
        $activity_table = $this->table->generate();
        return $activity_table;
    }
    
    public function load_activity_name($activity_id) {
        $activityName = $this->global_model->getActivityName($activity_id);
        $activityName = $activityName->result_array();
        echo $activityName[0]['activity_name'];
    }
    
    public function load_activity_source($activity) {
        $results = $this->global_model->getSource($activity);
        
        //echo '<pre>';print_r($results->result_array());echo '</pre>';
        $tmpl = array('table_open' => '<div class=""><table border="0" cellpadding="4" cellspacing="0" class="dataTable">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');
        
        $this->table->set_template($tmpl);
        
        //set table headers
        $this->table->set_heading('Names Of Participant', 'Facility Name', 'MFL Code', 'Department', 'Job Title', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date', 'Training Location');
        foreach ($results->result() as $activity) {
            $this->table->add_row($activity->names_of_participant, $activity->facility_name, $activity->mfl_code, $activity->department, $activity->cadre, $activity->id_number, $activity->mobile_number, $activity->email_address, $activity->dates, $activity->upload_date, $activity->training_location);
        }
        $activity_table = $this->table->generate();
        echo $activity_table;
    }
    
    public function load_activity_source_pdf($activity) {
        $results = $this->global_model->getSource($activity);
        
        //echo '<pre>';print_r($results->result_array());echo '</pre>';
        $tmpl = array('table_open' => '<table class="data-table">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');
        
        $this->table->set_template($tmpl);
        
        ///set table headers
        $this->table->set_heading('Names Of Participant', 'Facility Name', 'MFL Code', 'Department', 'Job Title', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date', 'Training Location');
        foreach ($results->result() as $activity) {
            $this->table->add_row($activity->names_of_participant, $activity->facility_name, $activity->mfl_code, $activity->department, $activity->cadre, $activity->id_number, $activity->mobile_number, $activity->email_address, $activity->dates, $activity->upload_date, $activity->training_location);
        }
        $activity_table = $this->table->generate();
        return $activity_table;
    }
    
    public function imci_cadre() {
        $results = $this->imci_model->imci_cadre();
        
        //var_dump($results);die;
        $dataSource = $series = $columns = $seriesData = array();
        
        foreach ($results->result() as $cadre) {
            $dataSource[$cadre->facility_type][] = array("cadre" => $cadre->cadre, "total" => (int)$cadre->total);
            $series[$cadre->cadre] = array("valueField" => $cadre->cadre, "name" => $cadre->cadre);
        }
        unset($dataSource['Nursing Home']);
        unset($dataSource['Other Hospital']);
        unset($dataSource['VCT Centre (Stand-Alone)']);
        unset($dataSource['']);
        unset($dataSource['']);
        
        //echo '<pre>';
        //print_r($dataSource);
        //echo '</pre>';die;
        $count = 0;
        foreach ($dataSource as $key => $value) {
            $seriesData[$count]['facility type'] = $key;
            foreach ($value as $val) {
                $seriesData[$count][$val['cadre']] = $val['total'];
            }
            
            //$series[] = array("valueField" => $key, "name" => $key);
            $count++;
        }
        foreach ($series as $ser) {
            $columns[] = $ser;;
        }
        
        //echo '<pre>';
        //print_r(json_encode($seriesData));
        //echo '</pre>';
        //die ;
        //$series = array("argumentField" => 'facility type', "valueField" => 'total', "name" => 'Cadre', 'type' => 'bar');
        
        $finalData = $seriesData;
        $finalData = json_encode($finalData);
        $resultArraySize = 10;
        
        //$data['argument'] = 'date';
        $data['resultArraySize'] = $resultArraySize;
        $data['container'] = 'chart_line' . rand(0, 1000000);
        $data['title'] = json_encode('Training by Cadre');
        $data['legendVisible'] = "false";
        $data['label'] = 'false';
        
        $data['argument'] = json_encode('facility type');
        $data['type'] = json_encode('stackedbar');
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($columns);
        $this->load->view('imci/charts/chart_grouped', $data);
    }
    
    public function imci_frequency($activity_name) {
        $activity_name = urldecode($activity_name);
        $dataSource = $series = $columns = $seriesData = array();
        $results = $this->global_model->getActivities('IMCI Training');
        $results = $results->result_array();
        
        foreach ($results as $activity) {
            if ($activity['activity_name'] == $activity_name) {
                $query = "SELECT 
    dates, COUNT(*) as total
FROM
    `program-monitor`.subprogramlog
    WHERE activity_id='" . $activity['activity_id'] . "'
GROUP BY dates";
                $logs = $this->db->query($query);
                
                //$logs = $this -> db -> get_where('subprogramlog', array('activity_id' => $activity -> activity_id));
                foreach ($logs->result() as $log) {
                    $dataSource[] = array("date" => date("d-M-Y", $log->dates), "total" => (int)$log->total);
                }
            }
        }
        $series = array("argumentField" => 'date', "valueField" => 'total', "name" => 'Training', 'type' => 'line');
        
        $finalData = $dataSource;
        $finalData = json_encode($finalData);
        $resultArraySize = 10;
        $data['argument'] = 'date';
        $data['resultArraySize'] = $resultArraySize;
        $data['container'] = 'chart_frequency' . rand(0, 1000000);
        
        //echo $data['container'];
        $data['title'] = json_encode('Training Frequency');
        $data['legendVisible'] = "false";
        
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($series);
        $this->load->view('imci/charts/chart_line', $data);
    }
    
    public function imci_training_county() {
        $dataSource = $series = $columns = $seriesData = array();
        
        //Assign variables for query
        $columns = 'COUNT(*) as total,facility.facilityCounty as county';
        $group_order = 'GROUP BY facility.facilityCounty ORDER BY facility.facilityCounty';
        $activity = 'IMCI Training';
        
        //Run Query to get RESULTS
        $results = $this->training_data($columns, $group_order, $activity);
        
        foreach ($results->result() as $county) {
            $dataSource[] = array("county" => $county->county, "total" => (int)$county->total);
        }
        
        $series = array("argumentField" => 'county', "valueField" => 'total', "name" => 'Participants', "type" => 'doughnut');
        
        $finalData = $dataSource;
        $finalData = json_encode($finalData);
        $resultArraySize = 10;
        $data['argument'] = 'date';
        $data['resultArraySize'] = $resultArraySize;
        $data['container'] = 'chart_' . rand(0, 1000000);
        $data['title'] = json_encode('Training by County');
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($series);
        $this->load->view('charts/chart_pie', $data);
    }
    
    public function testIP() {
    }
    
    public function export_PDF($activity_id) {
        $activityName = $this->global_model->getActivityName($activity_id);
        $activityName = $activityName->result_array();
        $filename = $activityName[0]['activity_name'];
        
        $data = $this->load_activity_source_pdf($activity_id);
        $this->load->module('export');
        
        $this->export->loadPDF($data, $filename);
    }
    
    private function make_table($activity_id) {
        $results = $this->global_model->getSource($activity_id);
        
        $results = $results->result_array();
        
        foreach ($results[0] as $key => $value) {
            $resultData['title'][] = strtoupper(str_replace("_", " ", $key));
        }
        $resultData['data'] = $results;
        return $resultData;
    }
    
    public function export_Excel($activity_id) {
        $activityName = $this->global_model->getActivityName($activity_id);
        $activityName = $activityName->result_array();
        $resultData = $this->make_table($activity_id);
        $this->load->module('export');
        $filename = $activityName[0]['activity_name'];
        $this->export->loadExcel($resultData, $filename);
        
        /*foreach ($results as $result) {
        foreach ($result as $key => $value) {
        $resultData['title'][] = strtoupper(str_replace("_", " ", $key));
        }
        }*/
    }
    
    public function getHCWData($choice) {
        
        //Variables
        $HCW_target = 1500;
        $HCW_total_trained = $this->total(10);
        $HCW_ratio = round(($HCW_total_trained / $HCW_target) * 100, 2);
        
        $HCW_nairobi_target = 750;
        $HCW_nairobi_total = $this->region_trained('Nairobi', 10);
        $HCW_nairobi_ratio = round(($HCW_nairobi_total / $HCW_nairobi_target) * 100, 2);
        $HCW_nairobi_data = $this->facility_type_trained('Nairobi', 'HCW', 10);
        
        //var_dump($HCW_nairobi_data);die;
        
        $HCW_coast_target = 750;
        $HCW_coast_total = $this->region_trained('Taita Taveta', 10) + $this->region_trained('Lamu', 10) + $this->region_trained('Kilifi', 10);
        $HCW_coast_ratio = round(($HCW_coast_total / $HCW_coast_target) * 100, 2);
        $HCW_coast_data = $this->facility_type_trained('Taita Taveta', 'HCW', 10) + $this->facility_type_trained('Lamu', 'HCW', 10) + $this->facility_type_trained('Kilifi', 'HCW', 10);
        
        $Facility_target = 815;
        $Facility_total_trained = $this->total_facilities_trained(10);
        $Facility_ratio = round(($Facility_total_trained / $Facility_target) * 100, 2);
        
        $Facility_nairobi_target = 273;
        $Facility_nairobi_total = $this->specific_facilities_trained('Nairobi', 10);
        $Facility_nairobi_ratio = round(($Facility_nairobi_total / $Facility_nairobi_target) * 100, 2);
        $Facility_nairobi_data = $this->facility_type_trained('Nairobi', 'Facility', 10);
        
        $Facility_coast_target = 541;
        $Facility_coast_total = $this->specific_facilities_trained('Taita Taveta', 10) + $this->specific_facilities_trained('Lamu', 10) + $this->specific_facilities_trained('Kilifi', 10);
        $Facility_coast_ratio = round(($Facility_coast_total / $Facility_coast_target) * 100, 2);
        $Facility_coast_data = $this->facility_type_trained('Taita Taveta', 'Facility', 10) + $this->facility_type_trained('Lamu', 'Facility', 10) + $this->facility_type_trained('Kilifi', 'Facility', 10);
        
        switch ($choice) {
            case 'HCW mini':
                $data = '<div class="summary"><span class="text">Total HCWs Targeted</span><span class="digit">' . $HCW_target . '</span></div>
            <div class="summary"><span class="text">Total HCWs Trained</span><span class="digit">' . $HCW_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $HCW_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $HCW_ratio . '%;">
                        ' . $HCW_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total Facilities Targeted</span><span class="digit">' . $Facility_target . '</span></div>
            <div class="summary"><span class="text">Total Facilities trained</span><span class="digit">' . $Facility_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_ratio . '%;">
                        ' . $Facility_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'HCW Progress':
                $data = '<div class="summary"><span class="text">Total HCWs Targeted</span><span class="digit">' . $HCW_target . '</span></div>
            <div class="summary"><span class="text">Total HCWs Trained</span><span class="digit">' . $HCW_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $HCW_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $HCW_ratio . '%;">
                        ' . $HCW_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total HCWs Trained(Feb-Mar2014)</span><span class="digit"></span></div>
            <div class="summary">Nairobi
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $HCW_nairobi_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $HCW_nairobi_ratio . '%;">
                        ' . $HCW_nairobi_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary">Coast
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $HCW_coast_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $HCW_coast_ratio . '%;">
                        ' . $HCW_coast_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'HCW Table':
                $data = '<table>
            <thead><th>Region</th><th>Target</th><th>Trained</th><th>Facility type</th><th>Target</th><th>Trained</th></thead>
            <tbody>
                <tr><td rowspan="2">Nairobi</td><td rowspan="2">' . $HCW_nairobi_target . '</td><td rowspan="2">' . $HCW_nairobi_total . '</td><td>Private</td><td>250</td><td>' . $HCW_nairobi_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $HCW_nairobi_data['Public'] . '</td></tr>
                <tr><td rowspan="2">Coast</td><td rowspan="2">' . $HCW_coast_target . '</td><td rowspan="2">' . $HCW_coast_total . '</td><td>Private</td><td>250</td><td>' . $HCW_coast_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $HCW_coast_data['Public'] . '</td></tr>
            </tbody>
            <tfoot></tfoot>
            </table>';
                break;

            case 'Facility Progress':
                $data = '<div class="summary"><span class="text">Total Facilities Targeted</span><span class="digit">' . $Facility_target . '</span></div>
            <div class="summary"><span class="text">Total Facilities trained</span><span class="digit">' . $Facility_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_ratio . '%;">
                        ' . $Facility_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total HCWs Trained(Feb-Mar2014)</span><span class="digit"></span></div>
            <div class="summary">Nairobi
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_nairobi_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_nairobi_ratio . '%;">
                        ' . $Facility_nairobi_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary">Coast
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_coast_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_coast_ratio . '%;">
                        ' . $Facility_coast_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'Facility Table':
                $data = '<table>
            <thead><th>Region</th><th>Target</th><th>Trained</th><th>Facility type</th><th>Target</th><th>Trained</th></thead>
            <tbody>
                <tr><td rowspan="2">Nairobi</td><td rowspan="2">' . $Facility_nairobi_target . '</td><td rowspan="2">' . $Facility_nairobi_total . '</td><td>Private</td><td>250</td><td>' . $Facility_nairobi_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $Facility_nairobi_data['Public'] . '</td></tr>
                <tr><td rowspan="2">Coast</td><td rowspan="2">' . $Facility_coast_target . '</td><td rowspan="2">' . $Facility_coast_total . '</td><td>Private</td><td>250</td><td>' . $Facility_coast_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $Facility_coast_data['Public'] . '</td></tr>
            </tbody>
            <tfoot></tfoot>
            </table>';
                break;
        }
        return $data;
    }
    
    public function getTOTData($choice) {
        
        //Variables
        $TOT_target = 200;
        $TOT_total_trained = $this->total(8);
        $TOT_ratio = round(($TOT_total_trained / $TOT_target) * 100, 2);
        
        $TOT_nairobi_target = 100;
        $TOT_nairobi_total = $this->region_trained('Nairobi', 8);
        $TOT_nairobi_ratio = round(($TOT_nairobi_total / $TOT_nairobi_target) * 100, 2);
        $TOT_nairobi_data = $this->facility_type_trained('Nairobi', 'TOT', 8);
        
        //var_dump($TOT_nairobi_data);die;
        
        $TOT_coast_target = 100;
        $TOT_coast_total = $this->region_trained('Taita Taveta', 8) + $this->region_trained('Lamu', 8) + $this->region_trained('Kilifi', 8);
        $TOT_coast_ratio = round(($TOT_coast_total / $TOT_coast_target) * 100, 2);
        $TOT_coast_data = $this->facility_type_trained('Taita Taveta', 'TOT', 8) + $this->facility_type_trained('Lamu', 'TOT', 8) + $this->facility_type_trained('Kilifi', 'TOT', 8);
        
        $Facility_target = 200;
        $Facility_total_trained = $this->total_facilities_trained(8);
        $Facility_ratio = round(($Facility_total_trained / $Facility_target) * 100, 2);
        
        $Facility_nairobi_target = 100;
        $Facility_nairobi_total = $this->specific_facilities_trained('Nairobi', 8);
        $Facility_nairobi_ratio = round(($Facility_nairobi_total / $Facility_nairobi_target) * 100, 2);
        $Facility_nairobi_data = $this->facility_type_trained('Nairobi', 'Facility', 8);
        
        $Facility_coast_target = 100;
        $Facility_coast_total = $this->specific_facilities_trained('Taita Taveta', 8) + $this->specific_facilities_trained('Lamu', 8) + $this->specific_facilities_trained('Kilifi', 8);
        $Facility_coast_ratio = round(($Facility_coast_total / $Facility_coast_target) * 100, 2);
        $Facility_coast_data = $this->facility_type_trained('Taita Taveta', 'Facility', 8) + $this->facility_type_trained('Lamu', 'Facility', 8) + $this->facility_type_trained('Kilifi', 'Facility', 8);
        
        switch ($choice) {
            case 'TOT mini':
                $data = '<div class="summary"><span class="text">Total TOTs Targeted</span><span class="digit">' . $TOT_target . '</span></div>
            <div class="summary"><span class="text">Total TOTs Trained</span><span class="digit">' . $TOT_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $TOT_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $TOT_ratio . '%;">
                        ' . $TOT_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total Facilities Targeted</span><span class="digit">' . $Facility_target . '</span></div>
            <div class="summary"><span class="text">Total Facilities trained</span><span class="digit">' . $Facility_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_ratio . '%;">
                        ' . $Facility_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'TOT Progress':
                $data = '<div class="summary"><span class="text">Total TOTs Targeted</span><span class="digit">' . $TOT_target . '</span></div>
            <div class="summary"><span class="text">Total TOTs Trained</span><span class="digit">' . $TOT_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $TOT_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $TOT_ratio . '%;">
                        ' . $TOT_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total TOTs Trained(Feb-Mar2014)</span><span class="digit"></span></div>
            <div class="summary">Nairobi
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $TOT_nairobi_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $TOT_nairobi_ratio . '%;">
                        ' . $TOT_nairobi_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary">Coast
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $TOT_coast_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $TOT_coast_ratio . '%;">
                        ' . $TOT_coast_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'TOT Table':
                $data = '<table>
            <thead><th>Region</th><th>Target</th><th>Trained</th><th>Facility type</th><th>Target</th><th>Trained</th></thead>
            <tbody>
                <tr><td rowspan="2">Nairobi</td><td rowspan="2">' . $TOT_nairobi_target . '</td><td rowspan="2">' . $TOT_nairobi_total . '</td><td>Private</td><td>250</td><td>' . $TOT_nairobi_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $TOT_nairobi_data['Public'] . '</td></tr>
                <tr><td rowspan="2">Coast</td><td rowspan="2">' . $TOT_coast_target . '</td><td rowspan="2">' . $TOT_coast_total . '</td><td>Private</td><td>250</td><td>' . $TOT_coast_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $TOT_coast_data['Public'] . '</td></tr>
            </tbody>
            <tfoot></tfoot>
            </table>';
                break;

            case 'Facility Progress':
                $data = '<div class="summary"><span class="text">Total Facilities Targeted</span><span class="digit">' . $Facility_target . '</span></div>
            <div class="summary"><span class="text">Total Facilities trained</span><span class="digit">' . $Facility_total_trained . '</span></div>
            <div class="summary">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_ratio . '%;">
                        ' . $Facility_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary"><span class="text">Total TOTs Trained(Feb-Mar2014)</span><span class="digit"></span></div>
            <div class="summary">Nairobi
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_nairobi_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_nairobi_ratio . '%;">
                        ' . $Facility_nairobi_ratio . '%
                     </div>
                </div>
            </div>
            <div class="summary">Coast
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="' . $Facility_coast_ratio . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $Facility_coast_ratio . '%;">
                        ' . $Facility_coast_ratio . '%
                     </div>
                </div>
            </div>';
                break;

            case 'Facility Table':
                $data = '<table>
            <thead><th>Region</th><th>Target</th><th>Trained</th><th>Facility type</th><th>Target</th><th>Trained</th></thead>
            <tbody>
                <tr><td rowspan="2">Nairobi</td><td rowspan="2">' . $Facility_nairobi_target . '</td><td rowspan="2">' . $Facility_nairobi_total . '</td><td>Private</td><td>250</td><td>' . $Facility_nairobi_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $Facility_nairobi_data['Public'] . '</td></tr>
                <tr><td rowspan="2">Coast</td><td rowspan="2">' . $Facility_coast_target . '</td><td rowspan="2">' . $Facility_coast_total . '</td><td>Private</td><td>250</td><td>' . $Facility_coast_data['Private'] . '</td></tr>
                <tr><td>Public</td><td>500</td><td>' . $Facility_coast_data['Public'] . '</td></tr>
            </tbody>
            <tfoot></tfoot>
            </table>';
                break;
        }
        return $data;
    }
}
