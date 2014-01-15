<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Bundling extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['contentView'] = "bundling/index";
		$data['brand']='Program Monitor';
		$data['title'] = "Program Monitor :: Home";
		$this -> template($data);
	}
	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	
}
