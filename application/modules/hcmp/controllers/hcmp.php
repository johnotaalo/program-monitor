<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HCMP extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('global_model');
		$this -> load -> model('hcmp_model');
	}

	public function index() {
		$data['contentView'] = "hcmp/index";
		$data['title'] = "Program Monitor :: HCMP";
		$data['brand'] = 'HCMP';
		$data['activity_table'] = $this -> load_activity_list();
		$this -> template($data);
	}

	public function upload() {
		$this -> load -> module('upload');
		$current_module = 'trainings';
		$subprogram = 'HCMP';
		$this -> upload -> data_upload(0, $subprogram);
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	public function load_upload_form() {
		$this -> load -> view('hcmp/forms/upload_training');
	}

	public function load_activity_list() {
		$results = $this -> global_model -> getActivities('HCMP');
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
					$last_updated = date("d-m-Y H:i", $log -> upload_date);
				}
			}
			$this -> db -> select_max('dates');
			$datasets = $this -> db -> get_where('subprogramlog', array('activity_id' => $activity -> activity_id));
			foreach ($datasets->result() as $dataset) {
				if ($log -> upload_date == NULL) {
					$recent_dataset = 'No Recent Data';
				} else {
					$recent_dataset = date("d-m-Y", $dataset -> dates);
				}
			}
			$activity_action = "<a href='#' class='btn-xs btn-primary imci_activity_update' id='" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info imci_activity_upload' id='" . $activity -> activity_id . "' >Upload</a>";
			$this -> table -> add_row($activity -> activity_name, $last_updated, $recent_dataset, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}

	public function hcmp_log($month) {
		$results = $this -> hcmp_model -> hcmp_log($month);

		foreach ($results->result() as $log) {
			$dataSource[] = array("date" => $log -> log_time, "total" => (int)$log -> total);
		}

		$series = array("argumentField" => 'date', "valueField" => 'total', "name" => 'Access', 'type' => 'line');

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

	public function hcmp_lead_time() {
		$results = $this -> hcmp_model -> hcmp_lead_time();
		$start = 0;
		foreach ($results->result() as $lead_time) {
			$ranges[] = array("startValue" => (int)$start, "endValue" => (int)$lead_time -> order_approval, "color" => "#92000A");
			$ranges[] = array("startValue" => (int)$lead_time -> order_approval, "endValue" => (int)$lead_time -> order_approval + $lead_time -> approval_delivery, "color" => "#E6E200");
			$ranges[] = array("startValue" => (int)$lead_time -> order_approval + $lead_time -> approval_delivery, "endValue" => (int)$lead_time -> order_approval + $lead_time -> approval_delivery + $lead_time -> delivery_update, "color" => "#77DD77");

			$endValue = round((int)$lead_time -> order_approval + $lead_time -> approval_delivery + $lead_time -> delivery_update, -1);
			$value = $endValue;
		}
		$ranges = json_encode($ranges);
		$data['ranges'] = $ranges;
		$data['value'] = $value;
		$data['endValue'] = $endValue;
		$data['container'] = 'chart_line' . rand(0, 1000000);
		$this -> load -> view('charts/chart_linear_gauge', $data);
	}

}
