<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

class  MY_Controller  extends  MX_Controller {
	var $sub_program_list, $activity_table, $hcmp;
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
		$this -> load -> model('global_model');
		$this -> getSubPrograms();
		//$this -> getActivity_Table();

	}

	function getSubPrograms() {
		$results = $this -> global_model -> getSubPrograms();
		$links = '';
		foreach ($results->result() as $sub_program) {
			$links .= '<li><a href="' . base_url() . $sub_program -> sub_program_name . '">' . $sub_program -> sub_program_name . '</a></li>';
		}
		$this -> sub_program_list = $links;
		return $this -> sub_program_list;
		//var_dump($results);
	}

	public function getActivity_Table($subprogram) {
		
	}

}
