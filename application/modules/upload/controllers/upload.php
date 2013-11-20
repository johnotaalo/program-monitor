<?php
/**
 * @author Maestro
 */
class Upload extends MY_Controller {

	function __construct() {
		parent::__construct();
		//$this -> load -> model('models_sugar/M_Sugar_ExternalFort_B3');
		$this -> load -> library('PHPexcel');
	}

	function index() {
		$dataArr['contentView']='upload/upload_v';
		$this -> load -> view('template_v',$dataArr);
	}

	public function data_upload($file_1,$start,$type) {		//convert .slk file to xlsx for upload
		if ($type == 'slk') {
			$edata = new Spreadsheet_Excel_Reader();

			// Set output Encoding.
			$edata -> setOutputEncoding("CP1251");

			if ($_FILES[$file_1]['tmp_name']) {
				$excelReader = PHPExcel_IOFactory::createReader('Excel2007');
				$excelReader -> setReadDataOnly(true);
				$objPHPExcel = PHPExcel_IOFactory::load($_FILES[$file_1]['tmp_name']);

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter -> save(str_replace('.php', '.xlsx', __FILE__));

			}

			$objPHPExcel = PHPExcel_IOFactory::load(str_replace('.php', '.xlsx', __FILE__));
		} else {
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES[$file_1]['tmp_name']);
		}
		$objReader = new PHPExcel_Reader_Excel5();
		$arr = $objPHPExcel -> setActiveSheetIndex($activesheet) -> toArray(null, true, true, true);
		$highestColumm = $objPHPExcel -> setActiveSheetIndex(1) -> getHighestColumn();
		$highestRow = $objPHPExcel -> setActiveSheetIndex(1) -> getHighestRow();
		$data = array();

		for ($i = $start; $i < $highestRow; $i++) {
			//fields you want to save in DB
			$test = $arr[$row]["A"];
			$deviceNo = $arr[$row]["B"];
			$assay = $arr[$row]["C"];
			$sample = $arr[$row]["E"];
			$cd = $arr[$row]["F"];
			$rdate = $arr[$row]["I"];
			$resultDate = date('Y-m-d', strtotime($arr[$row]["I"]));
			$resultTime = convertresulttime(time($arr[$row]["J"]));
			$operator = $arr[$row]["H"];
			$barcode = checkQAQC($arr[$row]["K"]);
			$expire = checkQAQC($arr[$row]["L"]);
			$volume = checkQAQC($arr[$row]["M"]);
			$device = checkQAQC($arr[$row]["N"]);
			$reagent = checkQAQC($arr[$row]["O"]);
			$error = getErrorId(substr($arr[$row]["G"], -3));
			
			//create the array with the respective fields
			$data[] = array('testNO' => $test);
			$data[] = array('deviceID' => $deviceNo);
			$data[] = array('asayID' => $assay);
			$data[] = array('sampleNumber' => $sample);
			$data[] = array('errorID' => $error);
			$data[] = array('cdCount' => $cd);
			$data[] = array('resultDate' => $resultDate);
			$data[] = array('resultTime' => $resultTime);
			$data[] = array('operatorId' => $operator);
			$data[] = array('barcode' => $barcode);
			$data[] = array('expiryDate' => $expire);
			$data[] = array('volume' => $volume);
			$data[] = array('uploadDate' => date("Y-m-d"));
			$data[] = array('device' =>$device);
			$data[] = array('reagent' => $reagent);

		}
          var_dump($data);
		//$this -> load -> database();
		$this -> db -> insert_batch('test', $data);
		//$this -> load -> database();
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

}
?>