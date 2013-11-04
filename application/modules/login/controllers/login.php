<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Login extends MX_Controller {

	var $user_table = "users";
	var $access_level_table = "access_level";
	var $user_log_table = "userlog";

	var $username_column = "username";
	var $password_column = "Password";
	var $access_level_column = "access_level";
	var $active_column = "Active";
	var $authentication_column = "Signature";
	var $time_updated_column = "Time_Created";
	var $email_column = "Email_Address";

	var $access_level_indicator = "indicator";
	var $admin_indicator = "admin";
	var $temp_indicator = "temp";

	var $attempt_limit = 4;
	var $normal_expiry = 30;
	var $temp_expiry = 14;
	var $password_min_length = 8;
	var $alpha_password_pool = "abcdefghijklmnopqrstuvwxyz";
	var $numeric_password_pool = "0123456789";
	var $email_sender = "webadt.chai@gmail.com";
	var $email_sender_title = "NASCOP SYSTEM";

	var $module_after_login = "home";

	function __construct() {
		parent::__construct();

		ini_set("SMTP", "ssl://smtp.gmail.com");
		ini_set("smtp_port", "465");

		$config['mailtype'] = "html";
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = stripslashes($this -> email_sender);
		$config['smtp_pass'] = stripslashes('WebAdt_052013');

		$this -> load -> library('email', $config);

	}

	public function index() {
		$data['content_view'] = "login/login_v";
		$data['title'] = "Dashboard | System Login";
		$this -> template($data);
	}

	public function recovery() {
		$data['content_view'] = "login/recovery_v";
		$data['title'] = "Dashboard | Password Recovery";
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

	public function recover_credentials() {
		$validated = $this -> form_validation -> run();
		if ($validated) {
			$email_address = $this -> input -> post("email_address", TRUE);
			$this -> validate_email($email_address);
		} else {
			$this -> recovery();
		}
	}

	public function validate_email($email_address) {
		$user_table = $this -> user_table;
		$email_column = $this -> email_column;

		$sql = "SELECT *
				FROM $user_table		
				WHERE $user_table.$email_column=:e";
		$users = R::getAll($sql, array(':e' => $email_address));
		if ($users) {
			$error_message = 'Check your email to reset this account.';
			$this -> reset_account($email_address);
		} else {
			$error_message = 'This Credentials are invalid.';
		}
		$this -> session -> set_flashdata('error_message', $error_message);
		redirect("login/recovery");
	}

	public function reset_account($email_address) {
		$characters = strtoupper($this -> alpha_password_pool);
		$characters .= strtolower($this -> alpha_password_pool);
		$characters .= $this -> numeric_password_pool;
		$password = "";

		$string = '';
		for ($i = 0; $i < $this -> password_min_length; $i++) {
			$password .= $characters[rand(0, strlen($characters) - 1)];
		}
		$message=$this -> send_mail($email_address, $subject, $message);
	}

	public function send_mail($email_address, $subject, $message) {
		$this -> email -> from($this -> email_sender, $this -> email_sender_title);
		$this -> email -> to($email_address);
		$this -> email -> subject($subject);
		$this -> email -> set_newline("\r\n");
		$this -> email -> message($message);

		if ($this -> email -> send()) {
			$data['error_message'] = 'Email address was sent to <b>' . $email_address . '</b> <br/>';
			$this -> email -> clear(TRUE);
		} else {
			$data['error_message'] = $this -> email -> print_debugger();
		}
		
		return $data['error_message'];
	}

	public function authenticate_user($username, $password) {
		$password = $this -> encrypt_password($password);
		$user_table = $this -> user_table;
		$access_level_table = $this -> access_level_table;
		$username_column = $this -> username_column;
		$password_column = $this -> password_column;
		$access_level_column = $this -> access_level_column;

		$sql = "SELECT $user_table.*,al.*,count(identity.id)+ count(auth.id) as authentication_level
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
		$access_level_indicator = $this -> access_level_indicator;
		$access_level = $users[$access_level_indicator];
		$user_id = $users['id'];
		$username_column = $this -> username_column;
		$username = $users[$username_column];
		$access_type = "denied";
		$admin_indicator = $this -> admin_indicator;

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
		$active = $users[$this -> active_column];
		$authentication = $users[$this -> authentication_column];
		$time_updated = $users[$this -> time_updated_column];
		$indicator = $users[$this -> access_level_indicator];
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
			$link = $this -> module_after_login;
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
			if ($index != $this -> password_column) {
				$session_data[$index] = $user;
			}
		}
		$this -> session -> set_userdata($session_data);
		$this -> write_log($user_id, $access_type);
	}

	public function check_if_expired($indicator, $time_updated) {
		if ($indicator != $this -> admin_indicator) {
			if ($indicator == $this -> temp_indicator) {
				$expiry_duration = $this -> temp_expiry;
			} else {
				$expiry_duration = $this -> normal_expiry;
			}
		}

		$today = date('Y-m-d');
		$datetime1 = date_create($today);
		$datetime2 = date_create($this -> time_updated);
		$interval = date_diff($datetime2, $datetime1);
		$period = $interval -> format('%a');

		if ($period >= $expiry_duration) {
			return true;
		} else {
			return false;
		}
	}

	public function deactivate_user($username) {
		$active_column = $this -> active_column;
		$username_column = $this -> username_column;
		$user_table = $this -> user_table;

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
		$log = R::dispense($this -> user_log_table);
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
