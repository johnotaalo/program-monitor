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
		$this -> template($data);
	}

	public function attempt() {
		$username = $this -> input -> post("username", TRUE);

		if (!$this -> session -> userdata($username . '_attempt')) {
			$attempt = 1;
			$this -> session -> set_userdata($username . '_attempt', $attempt);
			$attempt = $this -> session -> userdata($username . '_attempt');
		}
		echo $username . " attempt no: ".$attempt;
	}

	public function authenticate() {
		$validated = $this -> form_validation -> run();
		if ($validated) {
			$username = $this -> input -> post("username", TRUE);
			$password = $this -> input -> post("password", TRUE);
			$credentials = $this -> credentials($username, $password);
			$this -> verify($credentials);
		} else {
			$this -> index();
		}
	}

	public function credentials($username, $password) {
		$users = R::find('users', 'username=? and password=?', array($username, $password));
		return $users;
	}

	public function verify($credentials) {
		if ($credentials == null) {
			$this -> form_validation -> set_message('all_errors', 'The username or password you entered is incorrect.');
			$this -> attempt();
			//$this -> index();
		} else {
			$active = $credentials[1]['active'];
			$authentication = $credentials[1]['authentication'];
			$time_updated = $credentials[1]['time_updated'];

			if ($active != 1) {
				//if account is inactive
				$this -> form_validation -> set_message('all_errors', 'This Account has been deactivated. Contact the administrator for assistance.');
			} else if ($authentication != 1) {
				//if account is not authenticated
				$this -> form_validation -> set_message('all_errors', 'This Account is inactive check your email for the activation link.');
			} else if ($time_updated) {
				//if time_updated is greater than or equal to password expiry days(30 days)
				$this -> form_validation -> set_message('all_errors', 'This Password for this Account has expired.Please click the link to change your password');
			} else {
				//if all is good
			}
		}
	}

	public function template($data) {
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

}
