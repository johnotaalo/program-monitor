<?php
/**
 * @author Maestro
 */
class Export extends MY_Controller {
	var $actualTables;
	function __construct() {
		parent::__construct();
		//$this -> load -> model('models_sugar/M_Sugar_ExternalFort_B3');
		$this -> load -> library('PHPexcel');
		$this -> load -> library('MPDF');
		ini_set('memory_size', '2048M');
	}

	function index() {
		$dataArr['contentView'] = 'upload/upload_v';

		$dataArr['uploaded'] = '';
		$dataArr['posted'] = 0;
		$this -> load -> view('template_v', $dataArr);
	}

	#Load PDF
	public function loadPDF($data) {
		$stylesheet = ('
		th{
			padding:5px;
			text-align:left;
		}
		tr.tableRow:nth-child(even){
			background:#DDD;
		}
		h3 em {
			color:red;
		}
		');
		$html = ($data);
		$this -> load -> library('mpdf');
		$this -> mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
		$this -> mpdf -> SetTitle('Maternal Newborn and Child Health Assessment');
		$this -> mpdf -> SetHTMLHeader('<em>Child Health Assessment Tool</em>');
		$this -> mpdf -> SetHTMLFooter('<em>Child Health Assessment Tool</em>');
		$this -> mpdf -> simpleTables = true;
		$this -> mpdf -> WriteHTML($stylesheet, 1);
		$this -> mpdf -> WriteHTML($html, 2);
		$report_name = 'CH Assessment Tool_Facility List' . ".pdf";
		$this -> mpdf -> Output($report_name, 'D');

	}

	public function loadExcel($data) {
		$objPHPExcel = new PHPExcel();
		$data = $data -> result_array();
		// Set properties
		echo date('H:i:s') . " Set properties\n";
		$objPHPExcel -> getProperties() -> setCreator("Maarten Balliauw");
		$objPHPExcel -> getProperties() -> setLastModifiedBy("Maarten Balliauw");
		$objPHPExcel -> getProperties() -> setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel -> getProperties() -> setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel -> getProperties() -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

		// Add some data
		echo date('H:i:s') . " Add some data\n";
		$objPHPExcel -> setActiveSheetIndex(0);

		$rowExec = 1;
		//Looping through the Counties
		//Looping Through a County
		foreach ($data as $row) {
			foreach ($row as $rowset) {

				//Looping through the cells per facility
				$column = 0;
				foreach ($rowset as $cell) {
					$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($column, $rowExec, $cell);
					$column++;
				}
				$rowExec++;
			}
		}

		//die ;

		// Rename sheet
		echo date('H:i:s') . " Rename sheet\n";
		$objPHPExcel -> getActiveSheet() -> setTitle('Simple');

		// Save Excel 2007 file
		echo date('H:i:s') . " Write to Excel2007 format\n";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

		// We'll be outputting an excel file
		//		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		//		header('Content-Disposition: attachment; filename="file.xls"');

		// Write file to the browser
		$objWriter -> save('php://output');
		// Echo done
		echo date('H:i:s') . " Done writing file.\r\n";
	}

}
