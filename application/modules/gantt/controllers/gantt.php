<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
require ('gantti.php');
class Gantt extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		date_default_timezone_set('UTC');
		setlocale(LC_ALL, 'en_US');
		//$query = "SELECT * FROM activities";
		$values = $this -> db -> get('activities')->result_array();
		//var_dump($values);die;
		$data = array();
		foreach ($values as $val) {
			$data[] = array('label' => $val['activity_name'], 'start' => $val['activity_start'], 'end' => $val['activity_end']);
		}
		/*	$data[] = array('label' => 'Project 1', 'start' => '2012-04-20', 'end' => '2012-05-12');
		 $data[] = array('label' => 'Project 2', 'start' => '2012-04-22', 'end' => '2012-05-22', 'class' => 'important', );
		 $data[] = array('label' => 'Project 3', 'start' => '2012-05-25', 'end' => '2013-06-20', 'class' => 'urgent', );
		 $data[] = array('label' => 'Project 3', 'start' => '2012-05-25', 'end' => '2013-06-20', 'class' => 'urgent', );
		 $data[] = array('label' => 'Project 3', 'start' => '2012-05-25', 'end' => '2013-06-20', 'class' => 'urgent', );
		 $data[] = array('label' => 'Project 3', 'start' => '2012-05-25', 'end' => '2013-06-20', 'class' => 'urgent', );
		 */
		$gantti = new Gantti($data, array('title' => 'Demo', 'cellwidth' => 25, 'cellheight' => 35));

		$datas['gantt'] = $gantti;
		//$gantti = new Gantti();
		$datas['contentView'] = "gantt/gantt_v";
		$datas['title'] = "Dashboard | System Backup";
		$this -> load -> view('template_v', $datas);
	}

}
