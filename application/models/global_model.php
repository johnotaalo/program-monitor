<?php

class Global_Model extends CI_Model {
	function __construct() {
		parent::__construct();

	}

	public function getSubPrograms() {
		$subPrograms = $this -> db -> get('subprograms');

		return $subPrograms;
	}

	public function getActivities() {
		$activities = $this -> db -> get('activities');
		return $activities;
	}

}
