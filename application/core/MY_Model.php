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
    cadre.cadre_name as cadre,
    id_number,
    mobile_number,
    email_address,
    from_unixtime(dates, '%d-%m-%Y') as dates,
    training_location,
    from_unixtime(upload_date, '%d-%m-%Y') as upload_date
FROM
    subprogramlog,
    cadre,
    departments
WHERE
    activity_id = ?
        AND cadre.cadre_id = subprogramlog.cadre
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
/**
	 * Run County Maps
	 */
	public function runMap() {
		$myData = array();
		$this->db->select('*');
		$this->db->from('counties');
		$this->db->join('county_data','counties.county_id = county_data.county_id');
		$counties = $this -> db->get();
		$counties = $counties->result_array();
		foreach ($counties as $county) {
			$countyName = $county['county_name'];
			//$countyName=str_replace("'","", $countyName);
			$myData[$countyName] = $county;
		}

		return $myData;
	}
}
