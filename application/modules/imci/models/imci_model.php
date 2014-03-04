<?php

class Imci_Model extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function imci_job_title() {
		$query = "SELECT 
    count(*) as total,f.facilityType as facility_type,c.job_title_name as job_title
FROM
    subprogramlog s,
    facility f,job_title c
WHERE
	c.job_title_id=s.job_title AND
    s.mfl_code = f.facilityMFC
GROUP BY facilityType,s.job_title;";

		$job_title = $this -> db -> query($query);
		return $job_title;
	}

	

}
