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
    facility_name,
    mfl_code,
    designation,
    departments.department_name as department,
    training_location,
    job_title.job_title_name as job_title,
    id_number,
    mobile_number,
    email_address,
    from_unixtime(dates, '%d-%m-%Y') as dates,
    training_location,
    from_unixtime(upload_date, '%d-%m-%Y') as upload_date
FROM
    subprogramlog,
    job_title,
    departments
WHERE
    activity_id = ?
        AND job_title.job_title_id = subprogramlog.job_title
        AND departments.department_id = subprogramlog.department;";

		$source = $this -> db -> query($query, (int)$activity);
		return $source;
	}
	
	public function training_data($columns,$group_order,$training) {
		$query = "SELECT 
    $columns
FROM
    subprogramlog
        JOIN
    activities ON activities.activity_id = subprogramlog.activity_id
        JOIN
    subprograms ON subprograms.sub_program_id = activities.activity_classification
        JOIN
    facility ON (subprogramlog.mfl_code = facility.facilityMFC
        OR subprogramlog.facility_name = facility.facilityName)
WHERE
    sub_program_name = ?
$group_order;";
$facility_county = $this -> db -> query($query,$training);

//var_dump ($facility_county);die;
		return $facility_county;
	}

}
