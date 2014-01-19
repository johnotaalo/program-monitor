<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Baseline extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('global_model');
		$this -> load -> model('baseline_model');
	}

	public function index() {
		$data['contentView'] = "baseline/index";
		$data['title'] = "Program Monitor :: Baseline";
		$data['brand'] = 'Baseline Assessment';
		$this -> template($data);
	}

	public function upload() {
		$this -> load -> module('upload');
		$current_module = 'trainings';
		$subprogram = 'Baseline';
		$this -> upload -> data_upload(0, $subprogram);
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	public function unavailable_equipment_rank() {
		$results = $this -> baseline_model -> unavailable_equipment_rank();
		//var_dump ($results);die;
		foreach ($results->result() as $rank) {
			$dataSource[] = array("equipment" => $rank -> equipmentname, "total" => (int)$rank -> total_response);
		}

		$series = array("argumentField" => 'equipment', "valueField" => 'total', "name" => 'Unavailability');

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
		$this -> load -> view('charts/chart_pie', $data);
	}

}
