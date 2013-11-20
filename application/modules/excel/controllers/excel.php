<?php
/**
 * @author Maestro
 */
class Excel extends MY_Controller {

	function __construct() {
		parent::__construct();
		//$this -> load -> model('models_sugar/M_Sugar_ExternalFort_B3');
		$this -> load -> library('PHPexcel');
	}

	public function data_upload() {

		$objPHPExcel = PHPExcel_IOFactory::load("./assets/files/monitoring.xlsx");
		$objReader = new PHPExcel_Reader_Excel5();

		$arr = $objPHPExcel -> setActiveSheetIndex(0) -> toArray(null, true, true, true);
		$highestColumm = $objPHPExcel -> setActiveSheetIndex(1) -> getHighestColumn();
		$highestRow = $objPHPExcel -> setActiveSheetIndex(1) -> getHighestRow();
		$data = array();
		for ($i = 14; $i < 42; $i++) {
			$input = $arr[$i]['E'];
			if($input!=""){
				$data[] = array('indicator_name' => $input);
			}
			
		}
		//$this -> load -> database();
		$this->db->insert_batch('indicators',$data);
		/*for ($i = 2; $i <= $highestRow; $i++) {
		 for ($j = 2; $j <= $highestColumm; $j++) {
		 }

		 $inspectionRegistry = $arr[$i]['B'];
		 $factoryName = $arr[$i]['C'];
		 $dates = $arr[$i]['D'];
		 $areasVisited = $arr[$i]['E'];
		 $nonCompliances = $arr[$i]['F'];
		 $suggestionsForImprovement = $arr[$i]['G'];
		 $publicHealthOfficer = $arr[$i]['H'];
		 $receivedBy = $arr[$i]['I'];
		 $inspectorDate = $arr[$i]['J'];
		 $receivedDate = $arr[$i]['L'];
		 $supervisorName = $arr[$i]['N'];
		 $supervisorDate = $arr[$i]['M'];

		 $data = array('inspectionRegistry' => $inspectionRegistry, 'factoryName' => $factoryName, 'dates' => $dates, 'areasVisited' => $areasVisited, 'nonCompliances' => $nonCompliances, 'suggestionsForImprovement' => $suggestionsForImprovement, 'publicHealthOfficer' => $publicHealthOfficer, 'receivedBy' => $receivedBy, 'inspectorDate' => $inspectorDate, 'receivedDate' => $receivedDate, 'supervisorName' => $supervisorName, 'supervisorDate' => $supervisorDate);
		 //                                echo '<pre>';
		 //                                json_encode($data);
		 //                                var_dump($data);
		 //                                $this->M_Sugar_ExternalFort_B3->excelupload($data);
		 $this -> load -> database();
		 $this -> db -> query("INSERT INTO `fortification`.`sugar_externalfortb3` (`sugar_externalfortB3ID`, `inspectionRegistry`, `factoryName`, `dates`, `areasVisited`, `nonCompliances`, `suggestionsForImprovement`, `publicHealthOfficer`, `receivedBy`, `inspectorDate`, `receivedDate`, `supervisorName`, `supervisorDate`) VALUES (NULL, '$inspectionRegistry', '$factoryName', '$dates','$areasVisited', '$nonCompliances', '$suggestionsForImprovement','$publicHealthOfficer','$receivedBy', '$inspectorDate','$receivedDate','$supervisorName','$supervisorDate');");
		 }*/
		echo "data saved! Thanks";

	}

	function index() {
		$this -> load -> view('phpexcelview');
	}

}
?>