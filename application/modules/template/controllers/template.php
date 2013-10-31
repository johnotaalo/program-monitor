<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Template extends MX_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index($data) {
		$this -> load -> view('template_v', $data);
	}

}
