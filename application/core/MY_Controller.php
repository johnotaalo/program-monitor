<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

class  MY_Controller  extends  MX_Controller {
	var $sub_program_list, $activity_table;
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
		$this -> load -> model('global_model');
		$this -> getSubPrograms();
		$this -> getActivity_Table();
	}

	function getSubPrograms() {
		$results = $this -> global_model -> getSubPrograms();
		$links = '';
		foreach ($results->result() as $sub_program) {
			$links .= '<li><a href="' . base_url() . $sub_program -> sub_program_name . '">' . $sub_program -> sub_program_name . '</a></li>';
		}
		$this -> sub_program_list = $links;
		return $this -> sub_program_list;
		//var_dump($results);
	}

	public function getActivity_Table() {
		$results = $this -> global_model -> getActivities();
		$tmpl = array('table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="table table-condensed table-striped table-bordered table-hover">', 'heading_row_start' => '<tr>', 'heading_row_end' => '</tr>', 'heading_cell_start' => '<th>', 'heading_cell_end' => '</th>', 'row_start' => '<tr>', 'row_end' => '</tr>', 'cell_start' => '<td>', 'cell_end' => '</td>', 'row_alt_start' => '<tr>', 'row_alt_end' => '</tr>', 'cell_alt_start' => '<td>', 'cell_alt_end' => '</td>', 'table_close' => '</table>');

		$this -> table -> set_template($tmpl);

		$activities = $this -> db -> get('activities');
		//set table headers
		$this -> table -> set_heading('Activity', 'Action');
		foreach ($activities->result() as $activity) {
			$activity_action = "<a href='#' class='btn-xs btn-primary activity_update' id='activity_update_".$activity -> activity_id."' >Manual Entry</a><a href='#' class='btn-xs btn-info activity_upload' id='activity_upload_".$activity -> activity_id."' >Upload File</a>";
			$this -> table -> add_row($activity -> activity_name, $activity_action);
		}
		$this -> activity_table = $this -> table -> generate();
		return $this -> activity_table;
	}

}
