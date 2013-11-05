<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Template extends MX_Controller {

	var $banner_title = "Ministry of Health ";
	var $banner_subtitle = "ARV Drugs Supply Chain Management Tool";
	var $firm_name = "NASCOP";
	var $default_home_controller = "home";

	function __construct() {
		parent::__construct();
	}

	public function index($data) {
		$data['banner_title'] = $this -> banner_title;
		$data['banner_subtitle'] = $this -> banner_subtitle;
		$data['firm_name'] = $this -> firm_name;
		$data['default_home_controller'] = $this -> default_home_controller;
		$this -> load -> view('template_v', $data);
	}

}
