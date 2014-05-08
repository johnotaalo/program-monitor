<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IMCI_Mentorship extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('global_model');
		$this -> load -> model('imci_mentorship_model');
	}

	public function index() {
		$data['contentView'] = "imci_mentorship/index";
		$data['title'] = "Program Monitor :: IMCI Mentorship";
		$data['brand'] = 'IMCI Mentorship';
		$data_to_export = $this -> db -> get('activities');
		$data_to_export = $data_to_export -> result_array();
		$data['data_to_export'] = $data_to_export;
		$data['activity_table'] = $this -> load_activity_list();
		$this -> template($data);
	}
public function showUpload() {
        $this->load->view('forms/upload_training');
    }
	public function upload() {
		//var_dump($_POST);die;
		$this -> load -> module('upload');
		$activity_id = $_POST['activity_id'];
		$this -> upload -> data_upload(0, $activity_id);
	}

	public function manual_entry() {

		$data = $this -> input -> post();
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

		$this -> db -> insert_batch('subprogramlog', $results1);
		redirect('imci_mentorship');
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	public function load_activity_list() {
		$results = $this -> global_model -> getActivities('IMCI Mentorship');
		$tmpl = array('table_open' => '<div class="table-container"><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');

		$this -> table -> set_template($tmpl);

		//set table headers
		$this -> table -> set_heading('Activity', 'Last Updated', 'Recent Dataset Date', 'Action');
		foreach ($results->result() as $activity) {

			$this -> db -> select_max('upload_date');
			$logs = $this -> db -> get_where('subprogramlog', array('activity_id' => $activity -> activity_id));
			foreach ($logs->result() as $log) {
				if ($log -> upload_date == NULL) {
					$last_updated = 'Not Uploaded';
				} else {
					$last_updated = date("d-M-Y H:i", $log -> upload_date);
				}
			}
			$this -> db -> select_max('dates');
			$datasets = $this -> db -> get_where('subprogramlog', array('activity_id' => $activity -> activity_id));
			foreach ($datasets->result() as $dataset) {
				if ($log -> upload_date == NULL) {
					$recent_dataset = 'No Recent Data';
				} else {
					$recent_dataset = date("d-M-Y", $dataset -> dates);
				}
			}
			$activity_action = "<a href='#' class='btn-xs btn-primary imci_mentorship_manual_update' id='" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info imci_mentorship_activity_upload' id='" . $activity -> activity_id . "' >Upload</a>
			<a href='#' class='btn-xs  imci_mentorship_activity_source' id='" . $activity -> activity_id . "' >View Source Data</a>";
			$this -> table -> add_row($activity -> activity_name, $last_updated, $recent_dataset, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function load_activity_name($activity_id) {
		$activityName = $this -> global_model -> getActivityName($activity_id);
		$activityName = $activityName -> result_array();
		echo $activityName[0]['activity_name'];
	}

	public function load_activity_source($activity) {
		$results = $this -> global_model -> getSource($activity);
		//echo '<pre>';print_r($results->result_array());echo '</pre>';
		$tmpl = array('table_open' => '<div class=""><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover dataTable">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');

		$this -> table -> set_template($tmpl);

		//set table headers
		$this -> table -> set_heading('Names Of Participant', 'Work Station', 'MFL Code', 'Cadre', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date');
		foreach ($results->result() as $activity) {
			$this -> table -> add_row($activity -> names_of_participant, $activity -> work_station, $activity -> mfl_code, $activity -> cadre, $activity -> id_number, $activity -> mobile_number, $activity -> email_address, $activity -> dates, $activity -> upload_date);
		}
		$activity_table = $this -> table -> generate();
		echo $activity_table;
	}

	public function load_activity_source_pdf($activity) {
		$results = $this -> global_model -> getSource($activity);
		//echo '<pre>';print_r($results->result_array());echo '</pre>';
		$tmpl = array('table_open' => '<table class="data-table">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

		$this -> table -> set_template($tmpl);

		//set table headers
		$this -> table -> set_heading('Names Of Participant', 'Work Station', 'MFL Code', 'Cadre', 'ID Number', 'Mobile Number', 'Email Address', 'Dates', 'Upload Date');
		foreach ($results->result() as $activity) {
			$this -> table -> add_row($activity -> names_of_participant, $activity -> work_station, $activity -> mfl_code, $activity -> cadre, $activity -> id_number, $activity -> mobile_number, $activity -> email_address, $activity -> dates, $activity -> upload_date);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function imci_mentorship_cadre() {
		$results = $this -> imci_mentorship_model -> imci_mentorship_cadre();
		$dataSource = $series = $columns = $seriesData = array();

		foreach ($results->result() as $cadre) {
			$dataSource[$cadre -> facility_type][] = array("cadre" => $cadre -> cadre, "total" => (int)$cadre -> total);
			$series[$cadre -> cadre] = array("valueField" => $cadre -> cadre, "name" => $cadre -> cadre);
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
			$columns[] = $ser;
			;
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
		$this -> load -> view('imci_mentorship/charts/chart_grouped', $data);
	}

	public function imci_mentorship_frequency() {
		$dataSource = $series = $columns = $seriesData = array();
		$results = $this -> global_model -> getActivities('IMCI Mentorship');
		$results = $results -> result_array();

		foreach ($results as $activity) {
			if ($activity['activity_name'] == 'Train an expanded pool of TOTs') {
				$query = "SELECT 
    dates, COUNT(*) as total
FROM
    `program-monitor`.subprogramlog
    WHERE activity_id='" . $activity['activity_id'] . "'
GROUP BY dates";
				$logs = $this -> db -> query($query);
				//$logs = $this -> db -> get_where('subprogramlog', array('activity_id' => $activity -> activity_id));
				foreach ($logs->result() as $log) {
					$dataSource[] = array("date" => date("d-M-Y", $log -> dates), "total" => (int)$log -> total);
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
		$this -> load -> view('imci_mentorship/charts/chart_line', $data);
	}

	public function testIP() {

	}

	public function export_PDF($activity_id) {
		$activityName = $this -> global_model -> getActivityName($activity_id);
		$activityName = $activityName -> result_array();
		$filename = $activityName[0]['activity_name'];

		$data = $this -> load_activity_source_pdf($activity_id);
		$this -> load -> module('export');

		$this -> export -> loadPDF($data, $filename);
	}

	private function make_table($activity_id) {
		$results = $this -> global_model -> getSource($activity_id);

		$results = $results -> result_array();

		foreach ($results[0] as $key => $value) {
			$resultData['title'][] = strtoupper(str_replace("_", " ", $key));
		}
		$resultData['data'] = $results;
		return $resultData;

	}

	public function export_Excel($activity_id) {
		$activityName = $this -> global_model -> getActivityName($activity_id);
		$activityName = $activityName -> result_array();
		$resultData = $this -> make_table($activity_id);
		$this -> load -> module('export');
		$filename = $activityName[0]['activity_name'];
		$this -> export -> loadExcel($resultData, $filename);
		/*foreach ($results as $result) {
		 foreach ($result as $key => $value) {
		 $resultData['title'][] = strtoupper(str_replace("_", " ", $key));
		 }
		 }*/

	}

	public function generate_form(){
		$filename = 'Mentorship Form';
		$data='<table>
	<thead>
	<tr>
			<th colspan="2" style="font-size:22px">Follow up Support supervision checklist on IMCI after training </th>
		</tr>
		<tr>
			<th colspan="2" >Facility Information</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><label for="">Name of the health centre/facility</label><input type="text"></td>
			<td><label for="">Date of supervision</label><input type="text"></td>
		</tr>
		<tr>
			<td><label for="">Facility type</label><input type="text"></td>
			<td><label for="">Name of Supervisor</label><input type="text"></td>
		</tr>
		<tr>
			<td><label for="">Level of Care</label><input type="text"></td>
			<td><label for="">MFL Code</label><input type="text"></td>
		</tr>
		<tr>
			<td><label for="">Municipality/Ward</label><input type="text"></td>
			<td><label for="">Designation</label><input type="text"></td>
		</tr>
		<tr>
			<td><label for="">Sub County</label><input type="text"></td>
			<td><label for="">County</label><input type="text"></td>
		</tr>

	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<thead>
	<tr colspan="3">
		1. Health services organization  
	</tr>
	<tr>
		<th>1.1 Has IMCI corner/room been established? </th>
		<th>Yes</th>
		<th>No</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><label for="">1.1.1 Is there any available seating area for mother and child?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.1.2 Enough space to see patient?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.1.3 Chair and Table for health worker?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.1.4 Chair/seat for caregiver?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.1.5 Updated wall chart on the wall?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.1.6 Waiting space for mother/caregiver and children?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>

	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<tr>
			<th colspan="2">If any problem is found related to IMCI corner, what actions are needed to be taken? Develop and ensure</th>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
	<tr>
		<th>1.2 Oral rehydration therapy (ORT) corner? </th>
		<th>Yes</th>
		<th>No</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><label for="">1.2.1 Adequate space for giving ORT?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.2.2 Table (for mixing ORS solution and demonstrations), chairs for caretakers?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.2.3 Supplies (cup, spoon, measuring /mixing utensils)?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.2.4 Source of safe drinking water?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td><label for="">1.2.5 Functioning ORT: Children with some dehydration receive ORS solution at facility?</label></td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		
	</tbody>
	
</table>
<p style="margin-top:50px"></p>
<table>
	<tr>
			<th colspan="2">If any problem is found related to ORT corner, what actions are needed to be taken? Develop and ensure</th>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
	<tr>
		<th colspan="7">2.	Clinical staff trained on IMCI </th>
	</tr>
	<tr>
		<th>Clinical Staff</th>
		<th>Total post (BSP wise)</th>
		<th>Available staff against post</th>
		<th>Number of Clinical Staff trained in IMCI</th>
		<th>% of available clinical staff trained in IMCI</th>
		<th>% of staff who received refresher training on Updated Module</th>
		<th>Number of Clinical Staff supported by follow-up after Training</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td><label for="">Doctor</label></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
	</tr>
	<tr>
		<td><label for="">Nurse</label></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
	</tr>
	<tr>
		<td><label for="">R.C.O</label></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
		<td><input style="width:100px" type="text"></td>
	</tr>

	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<tr>
			<th colspan="2">If any problem related to IMCI training and staff is found, discuss with respective officer-in-charge of health
centre and make a plan. Develop and ensure support plan also. </th>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
	<tr>
		<th colspan="2">3. Quality of IMCI case management </th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td colspan="2">Name of Provider</td>
	</tr>
	<tr>
		<td>First Name<input type="text"></td>
		<td>Surname<input type="text"></td>
		
	</tr>
	<tr>
		<td>National ID<input type="text"></td>
		<td>Phone Number<input type="text"></td>
	</tr>
	<tr>
		<td>Year, Month when trained <input type="text"></td>
		<td><p><b>Key coordinator of the training(Select one)</b></p>
		<p><input type="radio">MOH/KPA/CHAI</p>
		<p><input type="radio">MOH only</p>
		<p><input type="radio">Other</p>
		<p>(If other, indicate the name of the coordinator/partner)<input type="text"></p>
		</td>
	</tr>
	<tr>
		<td><label for="">Designation</label></td>
		<td><input style="width:100px" type="text"></td>
	</tr>
	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<thead>
	<tr>
			<th>Question</th>
			<th>Yes</th>
			<th>No</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>
				1.	Is the HCW still working in the original facility they were when they got trained? 
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="radio">
			</td>
		</tr>
		<tr>
			<td colspan="3">
				If No to question 1 indicate whether the HCW: 
			</td>
		</tr>		
		<tr>
			<td>
				Transferred to another facility in the same county
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="radio">
			</td>
		</tr>
		<tr>
			<td colspan="3">If Yes, indicate name of the facility…………………………………………</td>
		</tr>
		<tr>
			<td>
				Transferred to another facility in another county
			</td>
			<td>
				<input type="radio">
			</td>
			<td>
				<input type="radio">
			</td>
		</tr>
		<tr>
			<td colspan="3">If  Yes, indicate the name of the county……………………………………and facility………………………………</td>
		</tr>
		</tbody>
</table>
<table>
	<thead>
	<tr>
		<th></th>
		<th></th>
		<th colspan="2">Case 1</th>
		<th colspan="2">Case 2</th>
		<th colspan="2">Case 3</th>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th>Yes</th>
		<th>No</th>
		<th>Yes</th>
		<th>No</th>
		<th>Yes</th>
		<th>No</th>
	</tr>

	</thead>
	<tbody>
	<tr>
		<th colspan="8">3.1 Consultation observation (observe three patient consultations if possible): write N/A if not applicable </th>
	</tr>
	<tr>
		<td rowspan="4">3.1.1</td>
		<td colspan="7">Did provider follow IMCI protocol during</td>
		
		
	</tr>
	<tr>
		<td>Assessment( General danger signs and other signs)</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>  Classification</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>Treatment  </td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.2</td>
		<td>Did provider use IMCI case recording form/register?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.3</td>
		<td>Did she do rapid test for malaria/ microscopy correctly? (Applicable only if the child with fever)</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.4</td>
		<td>Did she do tourniquet for Dengue correctly? (Applicable only if the child with fever less than 7 days)</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.5</td>
		<td>Did provider inform caregiver about illness of her child?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.6</td>
		<td>Did provider instruct caregiver how to give medicine to child?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.7</td>
		<td>Did provider give first dose of medicine at health centre?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.8</td>
		<td>Did provider counsel about child’s feeding?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.9</td>
		<td>Did provider explain how to take care of child?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.10</td>
		<td>Did provider ask caregiver for feedback</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.11</td>
		<td>Did he/she explain when to return?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.1.12</td>
		<td>Did he/she use mother’s card?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.13</td>
		<td>Duration of consultation (minutes)?</td>
		<td colspan="7"><input type="number"></td>
	</tr>
	<tr>
		<th colspan="8">3.2 Interview with the caregiver/mother</th>
	</tr>
	<tr>
		<td>3.2.1</td>
		<td>Was mother/caregiver satisfied?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.2.2</td>
		<td>Who advices mother/caregiver to seek care from this centre?</td>
		<td colspan="6"><input type="text"></td>
	</tr>
	<tr>
		<td>3.2.3</td>
		<td>Did mother/caregiver explain correctly how to give medicine?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.2.4</td>
		<td>Did he/she explain correctly how to take care of child at home?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
	<tr>
		<td>3.2.5</td>
		<td>Did he/she explain when to return to health centre immediately?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>
		<tr>
		<td>3.2.6</td>
		<td>Did s/he explain when to return to health centre for follow-up?</td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
		<td><input type="radio"></td>
	</tr>

	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<tr>
			<td colspan="2" class="bordered">
				Scoring of skills of provider: give 1 point for each YES answer (please discard 3.1.13 and 3.2.2). If the child has
malaria (3.1.3) or Dengue ( 3.1.4) then total score will be 54, otherwise it will be 48, however, it depends on total
observational session). Do not count N/A as point.

<p> Score:                  ----------X 100= .........%</p>

			 </td>
		</tr>
			<tr>
			<td colspan="2" class="bordered">
				Share your findings from observational sessions with provider.  Praise for the things done well and discuss on 
the identified weakness, show how it could be done. Ask provider, does s/he have any problem regarding
assessment, classification, treatment, counselling, follow-up etc. If s/he has, try to solve the problem instantly.
Note down the decisions which have been taken to improve the skills and continue the practices:

			 </td>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
	<tr>
		<th colspan="7">4. Qualty of records (Document review) </th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td><label for="">4.1 Did they send monthly report of last month</label></td>
		<td>Yes<input type="radio"></td>
		<td>No<input type="radio"></td>
	</tr>
	<tr>
		<td><label for="">4.2 Ask to show report and look for following data</label></td>
		<td>Yes<input type="text"></td>
		<td>No<input type="text"></td>
	</tr>
	<tr>
		<td rowspan="2"><label for="">4.3 Total IMCI patients in last month</label></td>
		<td>Male<input type="text"></td>
		<td>Female<input type="text"></td>
		<td>Total<input type="text"></td>
	</tr>
	<tr>
		<td>First Visit<input type="text"></td>
		<td>Follow-Up<input type="text"></td>
		<td>Caseload<input type="text">/provider/day</td>
	</tr>
	<tr>
		<td><label for="">4.4 Individual patient record or register maintained? </label></td>
		<td>Yes<input type="radio"></td>
		<td>No<input type="radio"></td>
	</tr>
	<tr>
		<td colspan="3"><label for="">4.5 Ask to show report and look for following data</label></td>
	</tr>
	</tbody>
	<tfoot></tfoot>
</table>
<table>
	<thead>
		<tr>
			<th width="300">Indicators  2 mo – 5 yr</th>
			<th colspan="7">Assess the register book ( tick mark when it
is correct  and cross when it is wrong, write
N/A when it is not applicable and make % of
correct )
</th>
		</tr>
		<tr>
			<th>Assessment</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>Sum Yes</th>
			<th>%</th>
		</tr>
		<tbody>
			<tr>
				<td>1) Weight and Temperature correctly charted  </td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>2) General Danger Signs</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>3) Feeding assessment if under two yrs, anemia or very low weight</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>4) Rapid Test for malaria  </td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>5) Microscopy for malaria according to IMCI protocol</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<th colspan="8">Classification</th>
			</tr>
			<tr>
				<td>6) Correct Classification(s)</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<th colspan="8">Treatment and Counselling</th>
			</tr>
			<tr>
				<td>7) ORT given appropriately according to plan</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>8) Children with diarrhoea treated with Zinc</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>9) Antibiotic prescribed correctly</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>10) No antibiotic needed; none given</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>11) Anti-malarial prescribed correctly</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>12) Needed Vitamin A supplementation given</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>13) Needed de-worming medication given</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>14) Appropriate counseling in feeding problems given </td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<td>15) Appropriate follow up arranged</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
			<tr>
				<th colspan="8">Referrals</th>
			</tr>
			<tr>
				<td>16) Necessary referral made, including referral note and pre-treatment</td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
				<td><input style="width:100px" type="text"></td>
			</tr>
		</tbody>
		<tfoot></tfoot>
	</thead>
</table>
<table>
	<tr>
			<th colspan="2">Ask them, what problems do they encounter in filling up the IMCI register, HMIS? And try to solve the problems. </th>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
		<th>5. Infection control at IMCI corner/room</th>
		<th>Yes</th>
		<th>No</th>
	</thead>
	<tbody>
		<tr>
			<td>5.1 Do they use disposable syringes during IM/IV injection?</td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td>5.2 Safety precaution to give injection (using gloves, cleaning surface with alcohol and discarding syringes after use)?</td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td>5.3 Source of water for hand wash?  </td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td>5.4 Soap and/or disinfectant (like chlorhexidine or alcohol) for washing hand?</td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
		<tr>
			<td>5.5 Safe disposal box with cover?</td>
			<td><input type="radio"></td>
			<td><input type="radio"></td>
		</tr>
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
<table>
	<tr>
			<th colspan="2">If any problems related to the IMCI corner are found, what actions are needed to be taken? Develop and ensure
support plan also.
 </th>
		</tr>
		<tr>
			<td><label for="">Action/s to be taken by supervisor:</label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> Action/s to be taken by supervisee:</label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
</table>
<table>
	<thead>
		<tr>
			<th colspan="5">6. Job aid and supplies ( make a tick mark when correct)  and write N/A where not feasible</th>
		</tr>
		<tr>
			<th>Logistics</th>
			<th>Available</th>
			<th>Adequate enough in stock for one month</th>
			<th>Functioning</th>
			<th>Remark</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>IMCI case recording form</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Mother’s card </td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Referral slip</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Chart booklet </td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>ARI timer(functioning)</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Thermometer</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>MUAC Tape</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Weight machine</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Nebuliser Machine</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Spacer</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Microscope for malaria test</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>RDT strips and reagent for malaria</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Ambubag</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>BP Cuff for Tourniquet test </td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>IMCI reporting format (HMIS)</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Suction Machine</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>NG tube</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Cup, Spoons for ORT</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Disposable Syringes</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Insulin Syringes</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Absorbent clean cloth/ soft but strong tissue for ear wicking</td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<th colspan="5">Medicine</th>
		</tr>
		<tr>
			<td>ORS packet</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Capsule Vitamin A ( 100000 i.u.)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Capsule Vitamin A ( 200000 i.u.)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Amoxicillin</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Amoxicillin</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab.Paed Cotrimoxazole (120mg) </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Cotrimoxazole (480mg)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Cotrimoxazole  </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Ciprofloxacin (100mg) </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Ciprofloxacin (250mg) </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Erythromicyn</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Erythromicyn</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Inj. Cholarmphenicol</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Coartem (140mg)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Quinine (300mg)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Inj. Quinine ( 150mg/2ml)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Inj. Quinine( 300mg/2ml )</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Inj Diazepam ( 10 mg/2ml )</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab.Zinc</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Iron – folic acid </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Iron</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab/Cap. Multivitamin</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Albendazole</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Cholramphenicol eye ointment</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tetracycline eye ointment </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Paracetamol 500mg</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Tab. Paracetamol 100mg</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Paracetamol  </td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Syrp. Salbutamol</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Inhaler Salbutamol</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>Gention Violet (0.25%)</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>10% Dextrose</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>IV fluid: Ringer lactate Solution</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>
		<tr>
			<td>IV fluid: 9% Normal Saline</td>
			<td><input style="width:100px" type="text"></td>
			<td><input style="width:100px" type="text"></td>
			<td class="shaded"></td>
			<td><input style="width:100px" type="text"></td>
		</tr>

	</tbody>
	<tfoot></tfoot>
</table>
<p style="margin-top:150px"></p>
<table>
	<tr>
			<th colspan="2">If you found any gaps regarding drugs and logistics, discuss and make an activity and support plan to address
the problems.
 </th>
		</tr>
		<tr class="bordered">
			<td><label for=""><b>Action/s to be taken by supervisor:</b></label> </br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
			<td><label for=""> <b>Action/s to be taken by supervisee:</b></label></br>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>

		<tr>
			<th colspan="2">Supervision:</th>
		</tr>
		<tr>
			<td><label for="">Did anybody visit this centre for IMCI supervision in
last three months (quarter)?
</label></td>
			<td>
				Yes<input type="radio">No<input type="radio">
			</td>
		</tr>
		<tr>
			<td><label for="">Ask them to give you the last supervision report?</label></td>
			<td>
				Date<input type="date">
				Supervisor Designation<input type="text">
			</td>
		</tr>
		<tr>
			<td><label for="">Progress of the last decision/s which was/were taken during last visit?</label></td>
			<td>
				<textarea style="height:50px;width:500px"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				Signature of Supervisee:<input type="text">
Date:<input type="text">


			</td>
			<td>
				Signature of Supervisor:<input type="text">
Date:<input type="text">
</td>
		</tr>
		<tr>
			<th colspan="2">Assessment outcomes for each of the HCW assessed:</th>
		</tr>
<tr>
<td colspan="2">
	<p><input type="radio">	Practicing IMCI</p>
<p><input type="radio">	Partially practicing IMCI (capture reasons) </p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Has some knowledge gaps (specify the gaps)…………………………………….……</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Others (specify)…………………………………………..</p>
<p><input type="radio">	Not practicing IMCI (capture reasons) </p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Could not be traced</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Transferred to another county</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Transferred to a non-pardiatric unit</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio">	Other (specify) …………………………………………..</p>
<p>Certificatied:<input type="radio">YES <input type="radio">NO</p>
</td>
	

</tr>

</table>
<p style="margin-top:50px"></p>
<table style="border:2px solid #666">
<tr>
		<td><i>Please leave a copy of signed report to respective facility before leaving and send one copy to district within 7 days of visit </i></td>
		</tr>
</table>

';
$this -> load -> module('export');

		$this -> export -> loadPDF($data, $filename);
	}

}
