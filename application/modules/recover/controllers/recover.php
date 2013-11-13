<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Recover extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['backup_files'] = $this -> checkdir();
		$data['content_view'] = "recover/recover_v";
		$data['title'] = "Dashboard | System Recovery";
		$this -> template($data);
	}

	public function checkdir() {
		$back_folder = "backup_db";
		$dir = './' . $back_folder;
		$backup_files = array();
		$backup_headings = array('Filename', 'Options');
		$options = '<button class="btn btn-primary btn-sm recover" >Recover</button>';

		if (is_dir($dir)) {
			$files = scandir($dir, 1);
			foreach ($files as $object) {
				if ($object != "." && $object != "..") {
					$backup_files[] = $object;
				}
			}
		} else {
			mkdir($dir);
		}
		$this -> load -> module('table');
		return $this -> table -> load_table($backup_headings, $backup_files, $options);
	}

	public function start_recovery() {
		$file_name = $this -> input -> post("file_name", TRUE);
		return $file_name;
	}

	public function template($data) {
		$data['show_menu'] = 0;
		$data['show_sidemenu'] = 0;
		$this -> load -> module('template');
		$this -> template -> index($data);
	}

}
