<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Morbidity extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('global_model');
		$this -> load -> model('morbidity_model');
	}

	public function index() {
		$data['contentView'] = "morbidity/index";
		$data['title'] = "Program Monitor :: Morbidity";
		$data['brand'] = 'Morbidity';
		$data['activity_table'] = $this -> load_activity_list();
		$data['maps']=$this->runMap();
		$data['tot_number'] = $this -> trainers_trained();
		$data['latest_training']=$this->latest_training();
		$this -> template($data);
	}

	public function upload() {
		//var_dump($_POST);die;
		$this -> load -> module('upload');
		//$activity_id = $_POST['activity_id'];
		$this -> upload -> data_upload(0, $activity_id,'log_morbidity');
		redirect('morbidity');
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

		$this -> db -> insert_batch('log_morbidity', $results1);
		redirect('morbidity');
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}
	public function runMap() {
		$counties = $this -> global_model -> runMap();
		//echo '<pre>';	print_r($counties)	;
		//echo '</pre>';die;
		$map = array();
		$datas = array();
		$status = '';
		foreach ($counties as $county) {
			//var_dump($county);
			$countyMap = (int)$county['county_fusion_map_id'];
			$countyName = $county['county_name'];
			$under5 = $county['under_five'];
			$women = $county['women_of_reproductive_age'];

			//echo $percentage.',';

			/*switch($percentage) {
				case ($percentage==0) :
					$status = '#ffffff';
					break;
				case ($percentage<20) :
					$status = '#e93939';
					break;
				case ($percentage<40) :
					$status = '#da8a33';
					break;
				case ($percentage<60) :
					$status = '#dad833';
					break;
				case ($percentage<80) :
					$status = '#91da33';
					break;
				case ($percentage<=100) :
					$status = '#7ada33';
					break;
				#case ($percentage===100) :
				#	$status = '#13b00b';
				#	break;
				default :
					$status = '#ffffff';
					break;
			}*/
			$datas[] = array('id' => $countyMap,'value'=>$countyName,'color'=>'FFCC99' ,'tooltext'=>$countyName.' {br} Under 5:  '.$under5.' {br} Women of Reproductive Age: '.$women,"baseFontColor" => "000000","link"=>"Javascript:run('".$countyName.",".$under5.",".$women."')");
		}
		$map = array( "baseFontColor" => "000000","canvasBorderColor"=>"ffffff","hoverColor"=>"aaaaaa","fillcolor" => "F7F7F7", "numbersuffix" => "M", "includevalueinlabels" => "1", "labelsepchar" => ":", "baseFontSize" => "9","borderColor"=>'333333',"showBevel"=>"0",'showShadow'=>"0");
		$styles = array("showBorder"=>0);
		$finalMap = array('map'=>$map,'data'=>$datas,'styles'=>$styles);
		$finalMap = json_encode($finalMap);
		return $finalMap;
	}

	public function load_activity_list() {
		$results = $this -> global_model -> getActivities('Morbidity');
		$tmpl = array('table_open' => '<div class="table-container"><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');

		$this -> table -> set_template($tmpl);

		//set table headers
		$this -> table -> set_heading('Activity', 'Last Updated', 'Recent Dataset Date', 'Action');
		foreach ($results->result() as $activity) {

			$this -> db -> select_max('upload_date');
			$logs = $this -> db -> get_where('log_morbidity', array('activity_id' => $activity -> activity_id));
			foreach ($logs->result() as $log) {
				if ($log -> upload_date == NULL) {
					$last_updated = 'Not Uploaded';
				} else {
					$last_updated = date("d-M-Y H:i", $log -> upload_date);
				}
			}
			$this -> db -> select_max('dates');
			$datasets = $this -> db -> get_where('log_morbidity', array('activity_id' => $activity -> activity_id));
			foreach ($datasets->result() as $dataset) {
				if ($log -> upload_date == NULL) {
					$recent_dataset = 'No Recent Data';
				} else {
					$recent_dataset = date("d-M-Y", $dataset -> dates);
				}
			}
			$activity_action = "<a href='#' class='btn-xs btn-primary morbidity_manual_update' id='" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info morbidity_activity_upload' id='" . $activity -> activity_id . "' >Upload</a>
			<a href='#' class='btn-xs  morbidity_activity_source' id='" . $activity -> activity_id . "' >View Source Data</a>";
			$this -> table -> add_row($activity -> activity_name, $last_updated, $recent_dataset, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function load_activity_source($activity) {
		$results = $this -> global_model -> getSource($activity);
		
		$tmpl = array('table_open' => '<div class="table-container"><table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table></div>');

		$this -> table -> set_template($tmpl);

		//set table headers
		$this -> table -> set_heading('Name Of Participant', 'Work Station', 'MFL Code','Cadre','ID Number','Mobile Number','Email Address', 'Dates','Upload Date');
		foreach ($results->result() as $activity) {
		$this -> table -> add_row($activity -> name_of_participant,$activity -> work_station,$activity -> mfl_code,
		$activity -> cadre,$activity -> id_number,$activity -> mobile_number,
		$activity -> email_address,$activity -> dates,$activity -> upload_date);
		}
		$activity_table = $this -> table -> generate();
		echo $activity_table;
	}

	

	

	public function testIP() {

	}

}
