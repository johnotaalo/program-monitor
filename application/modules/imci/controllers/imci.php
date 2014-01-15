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
		$this -> load -> module('upload');
		$current_module = 'trainings';
		$this -> upload -> data_upload(0, $current_module);
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
		$this -> table -> set_heading('Activity', 'Action');
		foreach ($results->result() as $activity) {
			$activity_action = "<a href='#' class='btn-xs btn-primary activity_update' id='activity_update_" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info activity_upload' id='activity_upload_" . $activity -> activity_id . "' >Upload</a>";
			$this -> table -> add_row($activity -> activity_name, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function imci_cadre() {
		$results = $this -> imci_model -> imci_cadre();

		foreach ($results->result() as $cadre) {
			$dataSource[] = array("cadre" => $cadre -> name, "total" => (int)$cadre -> total);
			
			
		}

		$series = array("argumentField" => 'cadre', "valueField" => 'total', "name" => 'Cadre', 'type' => 'bar');

		$finalData = $dataSource;
		$finalData = json_encode($finalData);
		$resultArraySize = 10;
		$data['argument'] = 'date';
		$data['resultArraySize'] = $resultArraySize;
		$data['container'] = 'chart_line' . rand(0, 1000000);
		$data['title'] = 'UPID Dashboard';
		$data['legendVisible'] = "false";

		$data['yAxis'] = 'Total';
		$data['dataSource'] = $finalData;
		$data['series'] = json_encode($series);
		$this -> load -> view('charts/chart_line', $data);
	}

}
