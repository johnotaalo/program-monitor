<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MX_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['content_view'] = "login/login_v";
		$data['title'] = "Dashboard | System Login";
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

	public function authenticate() {
		$validated = $this -> form_validation -> run();
		if ($validated) {
			$username = $this -> input -> post("username", TRUE);
			$password = $this -> input -> post("password", TRUE);
			$status = $this -> check_credentials($username, $password);
		} else {
			$this -> index();
		}
	}

	public function check_credentials($username, $password) {
		$user=R::find('users','username=?',array($username));
		//$user = R::load('users', array('username' => $username,'password' => $password));
		return $user;
	}

}
