<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

class  MY_Controller  extends  MX_Controller {
	var $training_list;
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
		$this -> load -> model('global_model');
		$this -> getTrainings();
	}

	function getTrainings() {
		$results = $this -> global_model -> getTrainings();
		$options = '<option>Please Choose Training</option>';
		foreach ($results->result() as $training) {
			$options .= '<option>' . $training -> training_name . '</option>';
		}
		$this -> training_list = $options;
		return $this -> training_list;
		//var_dump($results);
	}

}
