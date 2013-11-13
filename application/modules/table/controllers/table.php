<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Table extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function load_table($columns = array(), $table_data = array(), $set_options = 1) {
		$this -> load -> library('table');
		array_unshift($columns, "#");
		$tmpl = array('table_open' => '<table id="dyn_table" class="table table-striped table-bordered table-condensed dataTables">');
		$this -> table -> set_template($tmpl);
		$this -> table -> set_heading($columns);
		$options = '<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#view">View</button>';
		$counter = 1;

		foreach ($table_data as $table) {
			array_unshift($table, $counter);
			if ($set_options == 1) {
				$table['options'] = $options;
			}
			$this -> table -> add_row($table);
			$counter++;
		}
		return $this -> table -> generate();
	}

}
