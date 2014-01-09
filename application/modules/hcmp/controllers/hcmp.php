<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class HCMP extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['contentView'] = "hcmp/index";
		$data['title'] = "Program Monitor :: HCMP";
		$data['brand']='HCMP';
		$this -> template($data);
	}
	
	public function upload(){
		$this->load->module('upload');
		$current_module = 'trainings';
		$this->upload->data_upload(0,$current_module);
	}
	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	
}
