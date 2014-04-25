<?php

class Global_Model extends MY_Model {
	function __construct() {
		parent::__construct();

	}

	public function getSubPrograms() {
		$subPrograms = $this -> getAllSubPrograms();

		return $subPrograms;
	}

	public function getActivities($subprogram) {
		$activities = $this -> getActivitiesPerProgram($subprogram);
		return $activities;
	}
	
	public function getActivityName($activity) {
		$activities = $this -> getActivityOneName($activity);
		return $activities;
	}
	
	public function getSource($activity) {
		$activities = $this -> getSourcePerActivity($activity);
		return $activities;
	}
	public function getTrainingData($columns,$group_order,$training){
		$training_data = $this->training_data($columns, $group_order, $training);
		return $training_data;
	}
	public function countyMap(){
		$map = $this->runMap();
		return $map;
	}

}
