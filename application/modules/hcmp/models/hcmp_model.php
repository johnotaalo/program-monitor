<?php

class Hcmp_Model extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function hcmp_log($month) {
		$query = "SELECT 
    count(*) as total,
    STR_TO_DATE(start_time_of_event, '%Y-%m-%d') as log_time
FROM
    kemsa2.log
WHERE
    start_time_of_event LIKE '2013-09%'
        AND end_time_of_event LIKE '2013-09%'
GROUP BY log_time;";

		$log = $this -> db -> query($query, array($month, $month));
		return $log;
	}

}
