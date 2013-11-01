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

	public function access_level($indicator, $time_updated) {
		$normal_expiry = 30;
		$temp_expiry = 14;

		if ($indicator != 'admin') {
			if ($indicator == "temp") {
				$expiry_duration = $temp_expiry;
			} else {
				$expiry_duration = $normal_expiry;
			}
		}

		$today = date('Y-m-d');
		$datetime1 = date_create($today);
		$datetime2 = date_create($time_updated);
		$interval = date_diff($datetime2, $datetime1);
		$period = $interval -> format('%a');

		if ($period >= $expiry_duration) {
			return true;
		} else {
			return false;
		}

	}

	public function attempt() {
		$username = $this -> input -> post("username", TRUE);
		$attempt_limit = 4;
		$message = "The username or password you entered is incorrect.";

		if (!$this -> session -> userdata($username . '_attempt')) {
			$attempt = 1;
			$this -> session -> set_userdata($username . '_attempt', $attempt);
		} else if ($this -> session -> userdata($username . '_attempt') && $this -> session -> userdata($username . '_attempt') < $attempt_limit) {
			$attempt = $this -> session -> userdata($username . '_attempt');
			$attempt++;
			$this -> session -> set_userdata($username . '_attempt', $attempt);
		} else {
			$this -> deactivate_user($username);
			$message = "This Account has been deactivated. Contact the administrator for assistance.";
		}
		return $message;
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

	public function clear_user($credentials) {
		$active = $credentials[0]['Active'];
		$authentication = $credentials[0]['Signature'];
		$time_updated = $credentials[0]['Time_Created'];
		$indicator = $credentials[0]['indicator'];
		$user_id = $credentials[0]['id'];
		$expired = $this -> access_level($indicator, $time_updated);
		$link = "login";

		if ($active != 1) {
			//if account is inactive
			$error_message = 'This Account has been deactivated.<br/> Contact the administrator for assistance.';
		} else if ($authentication != 1) {
			//if account is not authenticated
			$error_message = 'This Account is inactive check your email for the activation link.';
		} else if ($expired) {
			//if time_updated is greater than or equal to password expiry days(30 days)
			$error_message = 'This Password for this Account has expired.<br/> Please click the <a href="' . base_url() . 'home/change_password/' . $user_id . '">link</a> to change your password';
		} else {
			//if all is good
			$this -> user_variables($credentials);
			$link = "home";
		}

		if ($link == "login") {
			$this -> session -> set_flashdata('error_message', $error_message);
		}
		redirect($link);
	}

	public function credentials($username, $password) {
		$password = $this -> encrypt_password($password);

		$sql = "SELECT users.*,al.*,count(identity.id)+ count(auth.id) as total
				FROM users
				LEFT JOIN access_level al ON al.id=users.access_level,
					(SELECT * FROM  `users`
				        WHERE username=:u) as identity
				LEFT JOIN
				        (SELECT * FROM `users`
				        WHERE username=:u
				        AND password=:p) as auth ON auth.id=identity.id				
				WHERE identity.id=users.id";
		$users = R::getAll($sql, array(':u' => $username, ':p' => $password));
		return $users;
	}

	public function deactivate_user($username) {
		$sql = "UPDATE users SET active='0' WHERE username=:u";
		R::getAll($sql, array(':u' => $username));
	}

	public function encrypt_password($password) {
		$key = $this -> encrypt -> get_key();
		$encrypted_password = $this -> encrypt -> encode($password, $key);
		$password = md5($encrypted_password);
		return $password;
	}

	public function user_variables($credentials) {
		$session_data = array();
		foreach ($credentials[0] as $index => $credential) {
			if ($index != "Password") {
				$session_data[$index] = $credential;
			}
		}
		$this -> session -> set_userdata($session_data);
	}

	public function verify($credentials) {
		$error_message = "The username or password you entered is incorrect.";
		$access_level = $credentials[0]['indicator'];

		if ($credentials[0]['total'] == 0) {
			$this -> session -> set_flashdata('error_message', $error_message);
			redirect("login");
		} else if ($credentials[0]['total'] == 1) {
			if ($access_level != "admin") {
				$error_message = $this -> attempt();
			}
			$this -> session -> set_flashdata('error_message', $error_message);
			redirect("login");
		} else {
			$this -> clear_user($credentials);
		}
	}

	public function template($data) {
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

}
