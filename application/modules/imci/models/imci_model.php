<?php

class Imci_Model extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function imci_cadre() {
		$query = "SELECT 
    count(cadre) as total,cadre_name as name
FROM
    subprogramlog,
    cadre
WHERE
    subprogramlog.cadre = cadre.cadre_id
GROUP BY cadre;";

		$cadre = $this -> db -> query($query);
		return $cadre;
	}

}
