<?php

class Global_Model extends CI_Model {
	function __construct() {
		parent::__construct();

	}

	public function getTrainings() {
		$trainings = $this -> db -> get('trainings');

		return $trainings;
	}

}
