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
		$dataArr['contentView'] = 'upload/upload_v';
		$this -> load -> view('template_v', $dataArr);
	}

	public function data_upload($file, $activesheet, $type, $start) {

		//convert .slk file to xlsx for upload
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
			$data[0] = array('testNO' => $test);
			$data[1] = array('deviceID' => $deviceNo);
			$data[2] = array('asayID' => $assay);
			$data[3] = array('sampleNumber' => $sample);
			$data[4] = array('errorID' => $error);
			$data[5] = array('cdCount' => $cd);
			$data[6] = array('resultDate' => $resultDate);
			$data[7] = array('resultTime' => $resultTime);
			$data[8] = array('operatorId' => $operator);
			$data[9] = array('barcode' => $barcode);
			$data[10] = array('expiryDate' => $expire);
			$data[11] = array('volume' => $volume);
			$data[12] = array('uploadDate' => date("Y-m-d"));
			$data[13] = array('device' => $device);
			$data[14] = array('reagent' => $reagent);

		}
		//$this -> load -> database();
		$this -> db -> insert_batch('test', $data);
		echo "data saved! Thanks";

	}

}
?>