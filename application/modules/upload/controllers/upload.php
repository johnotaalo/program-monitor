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
		$type = "";
		$start = 1;
		$config['upload_path'] = '././uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000000000';
		$this -> load -> library('upload', $config);

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
		$mytab = "";

		//echo $highestColumm;
		$data = $this -> getData($arr, $start, $highestColumm, $highestRow);
		//$data =json_encode($data);
		//echo($data);die;
		$data = $this->formatData($data);
			
		$dataArr['uploaded'] = $data;

		$dataArr['posted'] = 1;
		$dataArr['contentView'] = 'upload/upload_v';
		$this -> load -> view('template_v', $dataArr);

	}

	public function upload_commit() {

		$size = $this -> input -> post('size');
		for ($i = 1; $i <= $size; $i++) {
			$data['testNO'][$i] = $this -> input -> post('testNO' . $i);
			$data['deviceID'][$i] = $this -> input -> post('deviceID' . $i);
			$data['asayID'][$i] = $this -> input -> post('asayID' . $i);
			$data['sampleNumber'][$i] = $this -> input -> post('sampleNumber' . $i);
			$data['cdCount'][$i] = $this -> input -> post('cdCount' . $i);
			$data['resultDate'][$i] = $this -> input -> post('resultDate' . $i);
			$data['operatorId'][$i] = $this -> input -> post('operatorId' . $i);

		}
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		//save to DB
		//$this->db->insert_batch("test",$data);

	}

	public function getData($arr, $start, $highestColumn, $highestRow) {

		//possible columns
		for ($col = $start; $col < PHPExcel_Cell::columnIndexFromString($highestColumn) + 1; $col++) {

			for ($row = $start; $row < $highestRow; $row++) {
				$colString = PHPExcel_Cell::stringFromColumnIndex($col - 1);
				$title = $title = $arr[$start][$colString];
				//fields you want to save in DB
				$data[$title][] = $arr[$row + 1][$colString];

			}
		}

		return $data;
	}

	public function formatData($data) {
		$rows = array();

		foreach ($data as $key => $value) {
			$title[] = $key;
			$rowCounter = 0;
			for ($rowCounter = 0; $rowCounter < sizeof($value); $rowCounter++) {
				$rows[$rowCounter][$key] = $value[$rowCounter];
			}

		}
		return $rows;
		
	}

}
