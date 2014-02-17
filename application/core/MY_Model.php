<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

class  MY_Model  extends  CI_Model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
		//$this -> getActivity_Table();

	}

	public function getAllSubPrograms() {
		$subPrograms = $this -> db -> get('subprograms');

		return $subPrograms;
	}

	public function getActivitiesPerProgram($subprogram) {
		$query = 'SELECT 
    *
FROM
    activities a,
    subprograms s
WHERE
    a.activity_classification = s.sub_program_id and
s.sub_program_name = ?;';
		$activities = $this -> db -> query($query, $subprogram);
		return $activities;
	}
	
		public function getActivityOneName($activity) {
		$query = 'SELECT 
    activity_name
FROM
    activities WHERE activity_id=?;';
		$activities = $this -> db -> query($query, $activity);
		return $activities;
	}
	
	public function getSourcePerActivity($activity) {
		$query = "SELECT 
    names_of_participant,
    work_station,
    mfl_code,
    cadre.cadre_name as cadre,
    id_number,
    mobile_number,
    email_address,
    from_unixtime(dates, '%d-%m-%Y') as dates,
    from_unixtime(upload_date, '%d-%m-%Y') as upload_date
FROM
    subprogramlog,
    cadre
WHERE
    activity_id = ?
        AND cadre.cadre_id=subprogramlog.cadre;";

		$source = $this -> db -> query($query, (int)$activity);
		return $source;
	}

}
