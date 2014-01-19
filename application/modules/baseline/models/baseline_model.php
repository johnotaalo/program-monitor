<?php

class Baseline_Model extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function unavailable_equipment_rank() {
		$query = "SELECT 
    count(ea.equipAvailability) AS total_response,
e.equipmentname
FROM
     mnh_latest.equipments_available ea,mnh_latest.equipment e
WHERE
    ea.facilityID IN (SELECT 
            facilityMFC
        FROM
            facility
        WHERE
            facilityCHSurveyStatus = 'complete')
        AND ea.equipmentID IN (SELECT 
            equipmentCode
        FROM
            mnh_latest.equipment
        WHERE
            equipmentFor = 'ort') AND  ea.equipAvailability='Never Available' AND e.equipmentCode=ea.equipmentID
GROUP BY ea.equipmentID , ea.equipAvailability
ORDER BY count(ea.equipAvailability) DESC
limit 5";

		$rank = $this -> db -> query($query);
		return $rank;
	}

}
