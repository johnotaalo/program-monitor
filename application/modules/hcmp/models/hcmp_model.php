<?php

class Hcmp_Model extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function hcmp_log($month) {
		$query = "SELECT 
    count(*) as total,
    DATE_FORMAT(log.start_time_of_event, '%Y-%m') as log_time
FROM
    kemsa2.log,
    kemsa2.access_level,
    kemsa2.user
WHERE
    access_level.type = 1
        and user.usertype_id = access_level.id
        AND log.user_id = user.id
        AND start_time_of_event LIKE '2013%'
        AND end_time_of_event LIKE '2013%'
GROUP BY log_time;";

		$log = $this -> db -> query($query, array($month, $month));
		return $log;
	}

	public function hcmp_lead_time() {
		$query = "SELECT 
    ifnull(CEIL(AVG(DATEDIFF(o.`approvalDate`, o.`orderDate`))
                    ),0) AS order_approval,
    ifnull(CEIL(AVG(DATEDIFF(o.`deliverDate`, o.`approvalDate`))),
                    0) AS approval_delivery,
    ifnull(CEIL(AVG(DATEDIFF(o.`dispatch_update_date`,
                            o.`deliverDate`))),0) AS delivery_update,
    ifnull(CEIL(AVG(DATEDIFF(o.`dispatch_update_date`, o.`orderDate`))
                    ),0) AS t_a_t
FROM
    kemsa2.ordertbl o,
    kemsa2.facilities f,
    kemsa2.districts d,
    kemsa2.counties c
WHERE
    f.district = d.id AND d.county = c.id
        AND c.id = '1';";

		$lead_time = $this -> db -> query($query);
		return $lead_time;
	}

	public function hcmp_sensitization() {
		$query = "SELECT 
   county,count(*) as total
FROM
    subprogramlog,
    activities,
    subprograms
WHERE
    activities.activity_id = subprogramlog.activity_id
        AND activities.activity_classification = subprograms.sub_program_id AND activity_name='County Sensitization'
GROUP BY county;";
		$sensitization = $this -> db -> query($query);
		return $sensitization;
	}

}
