<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Bundling extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['contentView'] = "bundling/index";
		$data['brand']='Bundling';
		$data['title'] = "Program Monitor :: Bundling";
		$this -> template($data);
	}
	public function load_activity_list() {
		$results = $this -> global_model -> getActivities('Bundling');
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
			$activity_action = "<a href='#' class='btn-xs btn-primary imci_manual_update' id='" . $activity -> activity_id . "' >Manual Entry</a><a href='#' class='btn-xs btn-info imci_activity_upload' id='" . $activity -> activity_id . "' >Upload</a>
			<a href='#' class='btn-xs  imci_activity_source' id='" . $activity -> activity_id . "' >View Source Data</a>";
			$this -> table -> add_row($activity -> activity_name, $last_updated, $recent_dataset, $activity_action);
		}
		$activity_table = $this -> table -> generate();
		return $activity_table;
	}
	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	
}
