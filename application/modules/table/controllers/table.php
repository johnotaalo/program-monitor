<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Table extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function load_table($columns = array(), $table_data = array()) {
		$this -> load -> library('table');
		$this -> table -> set_heading($columns);
		$this -> table -> add_row(array('Fred', 'Blue', 'Small'));
		echo $this -> table -> generate();
		die();
	}

}
