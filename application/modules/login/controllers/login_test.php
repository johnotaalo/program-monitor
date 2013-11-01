<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login_test extends MX_Controller {
	function __construct() {
		parent::__construct();

		$user_table = "users";
		$access_level_table = "access_level";
		$user_log_table = "userlog";

		$username_column = "username";
		$password_column = "Password";
		$access_level_column = "access_level";
		$active_column = "Active";
		$authentication_column = "Signature";
		$time_updated_column = "Time_Created";

		$access_level_indicator = "indicator";
		$admin_indicator = "admin";
		$temp_indicator = "temp";

		$attempt_limit = 4;
		$normal_expiry = 30;
		$temp_expiry = 14;

		$module_after_login = "home";

	}

	public function index() {
		$data['content_view'] = "login/login_v";
		$data['title'] = "Dashboard | System Login";
		$this -> template($data);
	}

	public function process_credentials() {
		$validated = $this -> form_validation -> run();
		if ($validated) {
			$username = $this -> input -> post("username", TRUE);
			$password = $this -> input -> post("password", TRUE);
			$this -> authenticate_user($username, $password);
		} else {
			$this -> index();
		}
	}

	public function authenticate_user($username, $password) {
		$password = $this -> encrypt_password($password);

		$sql = "SELECT $this->user_table.*,al.*,count(identity.id)+ count(auth.id) as authentication_level
				FROM $user_table
				LEFT JOIN $access_level_table al ON al.id=$user_table.$access_level_column,
					(SELECT * FROM  $user_table
				        WHERE $username_column=:u) as identity
				LEFT JOIN
				        (SELECT * FROM $user_table
				        WHERE $username_column=:u
				        AND $password_column=:p) as auth ON auth.id=identity.id				
				WHERE identity.id=$user_table.id";
		$users = R::getAll($sql, array(':u' => $username, ':p' => $password));

		if ($users[0]['authentication_level'] == 2) {
			$this -> apply_security($users[0]);
		} else {
			$this -> perform_attempts($users[0]);
		}

	}

	public function perform_attempt($users = array()) {
		$error_message = "The username or password you entered is incorrect.";
		$access_level = $users[$access_level_indicator];
		$user_id = $users['id'];
		$username = $users[$username_column];
		$access_type = "denied";

		if ($users['authentication_level'] == 1 && $access_level != $admin_indicator) {
			if (!$this -> session -> userdata($username . '_attempt')) {
				$attempt = 1;
				$this -> session -> set_userdata($username . '_attempt', $attempt);
			} else if ($this -> session -> userdata($username . '_attempt') && $this -> session -> userdata($username . '_attempt') < $attempt_limit) {
				$attempt = $this -> session -> userdata($username . '_attempt');
				$attempt++;
				$this -> session -> set_userdata($username . '_attempt', $attempt);
			} else {
				$this -> deactivate_user($username);
				$this -> write_log($user_id, $access_type);
				$error_message = "This Account has been deactivated.<br/> Contact the administrator for assistance.";
			}
		}
		$this -> session -> set_flashdata('error_message', $error_message);
		redirect("login");
	}

	public function apply_security($users = array()) {
		$active = $users[$active_column];
		$authentication = $users[$authentication_column];
		$time_updated = $users[$time_updated_column];
		$indicator = $users[$access_level_indicator];
		$user_id = $users['id'];
		$expired = $this -> check_if_expired($indicator, $time_updated);
		$link = "login";

		if ($active != 1) {
			$error_message = 'This Account has been deactivated.<br/> Contact the administrator for assistance.';
		} else if ($authentication != 1) {
			$error_message = 'This Account is inactive check your email for the activation link.';
		} else if ($expired) {
			$error_message = 'This Password for this Account has expired.<br/> Please click the <a href="' . base_url() . 'home/change_password/' . $user_id . '">link</a> to change your password';
		} else {
			$this -> set_session_data($users);
			$link = $module_after_login;
		}
		if ($link == "login") {
			$this -> session -> set_flashdata('error_message', $error_message);
		}
		redirect($link);
	}

	public function set_session_data($users = array()) {
		$session_data = array();
		$access_type = "login";
		$user_id = $users['id'];

		foreach ($users as $index => $user) {
			if ($index != $password_column) {
				$session_data[$index] = $user;
			}
		}
		$this -> session -> set_userdata($session_data);
		$this -> write_log($user_id, $access_type);
	}

	public function check_if_expired($indicator, $time_updated) {
		if ($indicator != $admin_indicator) {
			if ($indicator == $temp_indicator) {
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

	public function deactivate_user($username) {
		$sql = "UPDATE $user_table SET $active_column='0' WHERE $username_column=:u";
		R::getAll($sql, array(':u' => $username));
	}

	public function encrypt_password($password) {
		$key = $this -> encrypt -> get_key();
		$encrypted_password = $key . $password;
		$password = md5($encrypted_password);
		return $password;
	}

	public function logout() {
		$user_id = $this -> session -> userdata("id");
		$access_type = "logout";
		$this -> write_log($user_id, $access_type);
		$this -> session -> sess_destroy();
		redirect("login");
	}

	public function write_log($user_id, $access_type) {
		$log = R::dispense($user_log_table);
		$log -> user = $user_id;
		$log -> access_type = $access_type;
		$log -> timestamp = date('Y-m-d H:i:s');
		$log -> ip_address = $this -> input -> ip_address();
		$log -> agent = $this -> input -> user_agent();
		R::store($log);
	}

	public function template($data) {
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

}
