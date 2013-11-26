<?php
/**
 * @author Maestro
 */
class Upload extends MY_Controller {

	function __construct() {
		parent::__construct();
		//$this -> load -> model('models_sugar/M_Sugar_ExternalFort_B3');
		$this -> load -> library('PHPexcel');
		ini_set('memory_size', '2048M');
	}

	function index() {
		$dataArr['contentView'] = 'upload/upload_v';

		$dataArr['uploaded'] = '';
		$dataArr['posted'] = 0;
		$this -> load -> view('template_v', $dataArr);
	}

	public function data_upload() {//convert .slk file to xlsx for upload
		$type = "slk";
		$start = 1;
		$config['upload_path'] = '././uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000000000';
		$this -> load -> library('upload', $config);

		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		//die();
		$file_1 = "upload_button";
		$activesheet = 0;
		if ($type == 'slk') {
			//$edata = new Spreadsheet_Excel_Reader();

			// Set output Encoding.
			//$edata -> setOutputEncoding("CP1251");

			if ($_FILES['file_1']['tmp_name']) {
				$excelReader = PHPExcel_IOFactory::createReader('Excel2007');
				$excelReader -> setReadDataOnly(true);
				$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter -> save(str_replace('.php', '.xlsx', __FILE__));

			}

			$objPHPExcel = PHPExcel_IOFactory::load(str_replace('.php', '.xlsx', __FILE__));
		} else {
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);
		}
		$objReader = new PHPExcel_Reader_Excel5();
		$arr = $objPHPExcel -> setActiveSheetIndex($activesheet) -> toArray(null, true, true, true);
		$highestColumm = $objPHPExcel -> setActiveSheetIndex($activesheet) -> getHighestColumn();
		$highestRow = $objPHPExcel -> setActiveSheetIndex($activesheet) -> getHighestRow();
		$data = array();

		for ($row = $start; $row < $highestRow; $row++) {
			//fields you want to save in DB
			$test = $arr[$row]["A"];
			$deviceNo = $arr[$row]["B"];
			$assay = $arr[$row]["C"];
			$sample = $arr[$row]["E"];
			$cd = $arr[$row]["F"];
			$rdate = $arr[$row]["I"];
			$resultDate = date('Y-m-d', strtotime($arr[$row]["I"]));
			$operator = $arr[$row]["H"];

			//create the array with the respective fields
			$data[] = array('testNO' => $test);
			$data[] = array('deviceID' => $deviceNo);
			$data[] = array('asayID' => $assay);
			$data[] = array('sampleNumber' => $sample);
			$data[] = array('cdCount' => $cd);
			$data[] = array('resultDate' => $resultDate);
			$data[] = array('operatorId' => $operator);
		}
		$data = json_encode($data);
		//echo($data);die;
		$dataArr['uploaded'] = $data;

		$dataArr['posted'] = 1;
		$dataArr['contentView'] = 'upload/upload_v';
		$this -> load -> view('template_v', $dataArr);
		
	}

}
?>