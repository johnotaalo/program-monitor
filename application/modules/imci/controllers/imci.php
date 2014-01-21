<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class IMCI extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('global_model');
		$this -> load -> model('imci_model');
	}

	public function index() {
		$data['contentView'] = "imci/index";
		$data['title'] = "Program Monitor :: IMCI";
		$data['brand'] = 'IMCI';
		$data['activity_table'] = $this -> load_activity_list();
		$this -> template($data);
	}

	public function upload() {
		//var_dump($_POST);die;
		$this -> load -> module('upload');
		$activity_id = $_POST['activity_id'];
		$this -> upload -> data_upload(0, $activity_id);
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	public function load_activity_list() {
		$results = $this -> global_model -> getActivities('IMCI');
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
			$activity_action = "<a href='#' class='btn-xs btn-primary imci_manual_update' id='" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info imci_activity_upload' id='" . $activity -> activity_id . "' >Upload</a>";
			$this -> table -> add_row($activity -> activity_name, $last_updated, $recent_dataset, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function imci_cadre() {
		$results = $this -> imci_model -> imci_cadre();
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
			$columns[] = $ser; ;
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
		$this -> load -> view('charts/chart_grouped', $data);
	}

}
