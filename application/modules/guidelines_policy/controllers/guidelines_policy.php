<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Guidelines_Policy extends MY_Controller
{
    
    function __construct() {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->model('guidelines_policy_model');
    }
    
    /**
     * [index description]
     * @return [type]
     */
    public function index() {
        $data['contentView'] = "guidelines_policy/index";
        $data['title'] = "Program Monitor :: Guidelines and Policy";
        $data['brand'] = 'Guidelines and Policy';
        $data_to_export = $this->db->get('activities');
        $data_to_export = $data_to_export->result_array();
        $data['data_to_export'] = $data_to_export;
        $data['activity_table'] = $this->load_activity_list();
        $data['IMCI_guidelines_total'] = $this->total_distributed(35);
        $data['Diarrhoea_guidelines_total'] = $this->total_distributed(34);
        $data['ORT_guidelines_total'] = $this->total_distributed(36);
        $data['IMCI_policy_map_county'] = $this->runMap_County(35);
        $data['IMCI_policy_map_source'] = $this->runMap_Source(35);
        $data['facility_list'] = $this->facility_list();
        $data['department_list'] = $this->department_list();
        $data['cadre_list'] = $this->cadre_list();
        $this->template($data);
    }
    
    /**
     * [upload description]
     * @return [type]
     */
    public function upload() {
        $this->load->module('upload');
        $activity_id = $_POST['activity_id'];
        $this->upload->data_upload(0, $activity_id, 'subprogramlog');
        redirect('guidelines_policy');
    }
    
    /**
     * [total_distributed description]
     * @param  [type] $activity_id
     * @return [type]
     */
    public function total_distributed($activity_id) {
        $results = $this->guidelines_policy_model->total_distributed($activity_id);
        $results = $results->result_array();
        
        return (int)$results[0]['total'];
    }
    
    /**
     * [manual_entry description]
     * @return [type]
     */
    public function manual_entry() {
        
        $data = $this->input->post();
        $activity_id = $data['activity_id_man'];
        unset($data['activity_id_man']);
        
        //echo '<pre>'; print_r($data);echo '</pre>';
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
        redirect('guidelines_policy');
    }
    
    /**
     * [template description]
     * @param  [type] $data
     * @return [type]
     */
    public function template($data) {
        $data['show_menu'] = 0;
        $data['show_sidemenu'] = 0;
        $this->load->module('template');
        $this->template->index($data);
    }
    
    /**
     * [load_activity_list description]
     * @return [type]
     */
    public function load_activity_list() {
        $results = $this->global_model->getActivities('Guidelines and Policy');
        
        //echo'<pre>'; print_r($results->result_array()); echo '</pre>';
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
            $activity_action = "<a href='#' class='btn-xs btn-primary guidelines_policy_manual_update' id='" . $activity->activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info guidelines_policy_activity_upload' id='" . $activity->activity_id . "' >Upload</a>
            <a href='#' class='btn-xs  guidelines_policy_activity_source' id='" . $activity->activity_id . "' >View Source Data</a>";
            $this->table->add_row($activity->activity_name, $last_updated, $recent_dataset, $activity_action);
        }
        $activity_table = $this->table->generate();
        return $activity_table;
    }
    
    /**
     * [load_activity_name description]
     * @param  [type] $activity_id
     * @return [type]
     */
    public function load_activity_name($activity_id) {
        $activityName = $this->global_model->getActivityName($activity_id);
        $activityName = $activityName->result_array();
        echo $activityName[0]['activity_name'];
    }
    
    /**
     * [load_activity_source description]
     * @param  [type] $activity
     * @return [type]
     */
    public function load_activity_source($activity) {
        $results = $this->global_model->getSource($activity);
        
        //echo '<pre>';print_r($results->result_array());echo '</pre>';
        $tmpl = array('table_open' => '<div class=""><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover dataTable">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');
        
        $this->table->set_template($tmpl);
        
        //set table headers
        $this->table->set_heading('Names Of Participant', 'Work Station', 'MFL Code', 'Cadre', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date');
        foreach ($results->result() as $activity) {
            $this->table->add_row($activity->names_of_participant, $activity->work_station, $activity->mfl_code, $activity->cadre, $activity->id_number, $activity->mobile_number, $activity->email_address, $activity->dates, $activity->upload_date);
        }
        $activity_table = $this->table->generate();
        echo $activity_table;
    }
    
    /**
     * [load_activity_source_pdf description]
     * @param  [type] $activity
     * @return [type]
     */
    public function load_activity_source_pdf($activity) {
        $results = $this->global_model->getSource($activity);
        
        //echo '<pre>';print_r($results->result_array());echo '</pre>';
        $tmpl = array('table_open' => '<table class="data-table">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');
        
        $this->table->set_template($tmpl);
        
        //set table headers
        $this->table->set_heading('Names Of Participant', 'Work Station', 'MFL Code', 'Cadre', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date');
        foreach ($results->result() as $activity) {
            $this->table->add_row($activity->names_of_participant, $activity->work_station, $activity->mfl_code, $activity->cadre, $activity->id_number, $activity->mobile_number, $activity->email_address, $activity->dates, $activity->upload_date);
        }
        $activity_table = $this->table->generate();
        return $activity_table;
    }
    
    /**
     * [guidelines_policy_cadre description]
     * @return [type]
     */
    public function guidelines_policy_cadre() {
        $results = $this->guidelines_policy_model->guidelines_policy_cadre();
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
        $data['argument'] = 'date';
        $data['resultArraySize'] = $resultArraySize;
        $data['container'] = 'chart_line' . rand(0, 1000000);
        $data['title'] = 'UPID Dashboard';
        $data['legendVisible'] = "false";
        $data['label'] = 'false';
        
        $data['argument'] = json_encode('facility type');
        $data['type'] = json_encode('stackedbar');
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($columns);
        $this->load->view('guidelines_policy/charts/chart_grouped', $data);
    }
    
    /**
     * [guidelines_policy_frequency description]
     * @return [type]
     */
    public function guidelines_policy_frequency() {
        $dataSource = $series = $columns = $seriesData = array();
        $results = $this->global_model->getActivities('Guidelines and Policy');
        $results = $results->result_array();
        
        foreach ($results as $activity) {
            if ($activity['activity_name'] == 'Train an expanded pool of TOTs') {
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
        $data['title'] = 'UPID Dashboard';
        $data['legendVisible'] = "false";
        
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($series);
        $this->load->view('guidelines_policy/charts/chart_line', $data);
    }
    
    /**
     * [testIP description]
     * @return [type]
     */
    public function testIP() {
    }
    
    /**
     * [export_PDF description]
     * @param  [type] $activity_id
     * @return [type]
     */
    public function export_PDF($activity_id) {
        $activityName = $this->global_model->getActivityName($activity_id);
        $activityName = $activityName->result_array();
        $filename = $activityName[0]['activity_name'];
        
        $data = $this->load_activity_source_pdf($activity_id);
        $this->load->module('export');
        
        $this->export->loadPDF($data, $filename);
    }
    
    /**
     * [make_table description]
     * @param  [type] $activity_id
     * @return [type]
     */
    private function make_table($activity_id) {
        $results = $this->global_model->getSource($activity_id);
        
        $results = $results->result_array();
        
        foreach ($results[0] as $key => $value) {
            $resultData['title'][] = strtoupper(str_replace("_", " ", $key));
        }
        $resultData['data'] = $results;
        return $resultData;
    }
    
    /**
     * [export_Excel description]
     * @param  [type] $activity_id
     * @return [type]
     */
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
    public function showUpload() {
        $this->load->view('forms/upload_training');
    }
    
    /**
     * [distribution description]
     * @param  [type] $scope
     * @param  [type] $criteria
     * @return [type]
     */
    public function distribution($scope, $criteria,$limit) {
        $result = $this->guidelines_policy_model->distribution($scope, $criteria,$limit);
        $result = $result->result_array();
        $dataSource=array();
        //print_r($result);
       
        switch ($scope) {
            case 'region':
                $title = $criteria;
                foreach ($result as $val) {
                    $dataSource[] = array($criteria => $val[$criteria], "total" => (int)$val['total']);
                }
                $series = array("argumentField" => $criteria, "valueField" => 'total', "name" => 'Participants', "type" => 'doughnut');
                break;

            case 'source':
                $title = $scope;
                foreach ($result as $val) {
                    $dataSource[] = array($criteria => $val['source'], "total" => (int)$val['total']);
                }
                $series = array("argumentField" => $scope, "valueField" => 'total', "name" => 'Participants', "type" => 'doughnut');
                break;
        }
        
        $finalData = $dataSource;
        $finalData = json_encode($finalData);
        $resultArraySize = 10;
        $data['argument'] = 'date';
        $data['resultArraySize'] = $resultArraySize;
        $data['container'] = 'chart_' . rand(0, 1000000);
        $data['title'] = json_encode('Distribution by ' . ucwords($title));
        $data['yAxis'] = 'Total';
        $data['dataSource'] = $finalData;
        $data['series'] = json_encode($series);
        $this->load->view('charts/chart_pie', $data);
    }

    public function runMap_County($activity_id) {
        $counties = $this -> guidelines_policy_model -> get_total($activity_id,'county');

        //echo '<pre>'; var_dump($counties['Baringo'])  ;
        //echo '</pre>';die;
        $map = array();
        $datas = array();
        $status = '';
        if(sizeof($counties['Baringo'])>0){
        foreach ($counties as $county) {
            //var_dump($county);
            $countyMap = (int)$county[0]['county_fusion_map_id'];
            $countyName = $county[0]['county'];
            $percentage = $county[0]['percentage'];
            $available = $county[0]['available'];
            $total = $county[0]['total'];

            //echo $percentage.',';

            switch($percentage) {
                case ($percentage==0) :
                    $status = '#ffffff';
                    break;
                case ($percentage<20) :
                    $status = '#ea6a6a';
                    break;
                case ($percentage<40) :
                    $status = '#b88957';
                    break;
                case ($percentage<60) :
                    $status = '#d2d169';
                    break;
                case ($percentage<80) :
                    $status = '#8cb359';
                    break;
                case ($percentage<=100) :
                    $status = '#5c8851';#7ada33';
                    break;
                #case ($percentage===100) :
                #   $status = '#13b00b';
                #   break;
                default :
                    $status = '#ffffff';
                    break;
            }
            /*
            $map = array( "baseFontColor" => "000000","canvasBorderColor"=>"ffffff","hoverColor"=>"aaaaaa","fillcolor" => "F7F7F7", "numbersuffix" => "M", "includevalueinlabels" => "1", "labelsepchar" => ":", "baseFontSize" => "9","borderColor"=>'333333',"showBevel"=>"0",'showShadow'=>"0");
        $styles = array("showBorder"=>0);
        $color_range = array("color"=>array(array("minvalue"=> "100", "maxvalue"=> "100", "displayvalue"=> "Targeted", "color"=> "FFCC99" )));
        $finalMap = array('map'=>$map,'colorrange'=>$color_range,'data'=>$datas,'styles'=>$styles);
        $finalMap = json_encode($finalMap);
        //echo $finalMap;die;
        return $finalMap;
             */
            $datas[] = array('id' => $countyMap,'value'=>$countyName,'color'=>$status ,'tooltext'=>$countyName.' {br} '.$available.' / '.$total,"baseFontColor" => "000000","link"=>"Javascript:runPolicyMap('".$countyName.",".$total.",".$available."')");
        }
    }
        $map = array( "baseFontColor" => "000000","canvasBorderColor"=>"ffffff","hoverColor"=>"a46658","fillcolor" => "F7F7F7", "numbersuffix" => "M", "includevalueinlabels" => "1", "labelsepchar" => ":", "baseFontSize" => "9","borderColor"=>'333333',"showBevel"=>"0",'showShadow'=>"0");
        $styles = array("showBorder"=>0);
        $finalMap = array('map'=>$map,'data'=>$datas,'styles'=>$styles);
        $finalMap = json_encode($finalMap);
        return $finalMap;
    }

    public function runMap_Source($activity_id) {
        $counties = $this -> guidelines_policy_model -> get_total($activity_id,'source');

       
        $map = array();
        $datas = array();
        $status = '';

        if(sizeof($counties['Baringo'])>0){
        foreach ($counties as $county) {
           $size = sizeof($county);
            $countyMap = (int)$county[ $size-1]['county_fusion_map_id'];
            $countyName = $county[ $size-1]['county'];
            $source = $county[ $size-1]['policy_source'];
            $allocation = $county[ $size-1]['allocations'];

      

            //echo $percentage.',';

            switch($source) {
                case ($source=='MOH') :
                    $status = '#5f8b95';
                    break;
                case ($source=='PRIVATE') :
                    $status = '#af8a53';
                    break;
                case ($source=='FBO') :
                    $status = '#ba4d51';
                    break;
                default :
                    $status = '#ffffff';
                    break;
            }
            $datas[] = array('id' => $countyMap,'value'=>$countyName,'color'=>$status ,'tooltext'=>$countyName.' {br} Minority Supplier : '.$source.' ( '.$allocation.' ) ',"baseFontColor" => "000000","link"=>"Javascript:runPolicyMapSource('".json_encode($county)."')");
        }
    }
        $map = array( "baseFontColor" => "000000","canvasBorderColor"=>"ffffff","hoverColor"=>"eb9294","fillcolor" => "F7F7F7", "numbersuffix" => "M", "includevalueinlabels" => "1", "labelsepchar" => ":", "baseFontSize" => "9","borderColor"=>'333333',"showBevel"=>"0",'showShadow'=>"0");
        $styles = array("showBorder"=>0);
        $finalMap = array('map'=>$map,'data'=>$datas,'styles'=>$styles);
        $finalMap = json_encode($finalMap);
        return $finalMap;
    }
}
