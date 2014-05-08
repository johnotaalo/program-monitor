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
		//$this -> load -> library('MPDF');
		ini_set('memory_size', '2048M');
	}

	function index() {
		$dataArr['contentView'] = 'upload/upload_v';

		$dataArr['uploaded'] = '';
		$dataArr['posted'] = 0;
		$this -> load -> view('template_v', $dataArr);
	}

	#Load PDF
	public function loadPDF($data, $filename) {
		$stylesheet = ('
<style>table.data-table {border: 0px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #fff;text-align: center;background-color:#DDD;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}

tbody tr:nth-child(even){
	background:#eee;
}
table{
	font-size:16px;
}
th{
	background:#dfa487;
	text-align:left;
}
textarea{
	border:#fff;
}
.shaded{
	background:#bbb;
}
tr, th, td{
	margin:0 0 0 0;
	border:none;
}
label,textarea{
	display:block;
}
table{
	width:1000px;
}
.bordered{
	border:2px solid #666;
}
</style>
		');
		$html = ($data);
		$this -> load -> library('mpdf');
	$this -> mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
	$this -> mpdf -> SetHTMLFooter('<span></span><b style="margin-left:900px">{PAGENO} of {nb}</b>');

		$this -> mpdf -> simpleTables = true;
	//	$this -> mpdf -> WriteHTML($stylesheet, 1);
		$this -> mpdf -> WriteHTML($stylesheet.$html);
		$report_name = $filename . ".pdf";
		$this -> mpdf -> Output($report_name, 'I');
	}

	#Load PDF
	public function loadCSV() {
		$data = json_decode($_POST['json']);
		var_dump($data);
		//$data = json_decode($data);

		//echo '<pre>';print_r($data);echo '</pre>';

	}

	public function loadExcel($data, $filename) {
		$objPHPExcel = new PHPExcel();
		$objPHPExcel -> getProperties() -> setCreator("Maarten Balliauw");
		$objPHPExcel -> getProperties() -> setLastModifiedBy("Maarten Balliauw");
		$objPHPExcel -> getProperties() -> setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel -> getProperties() -> setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel -> getProperties() -> setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

		// Add some data
		//	echo date('H:i:s') . " Add some data\n";
		$objPHPExcel -> setActiveSheetIndex(0);

		$rowExec = 1;

		//Looping through the cells
		$column = 0;
		foreach ($data['title'] as $cell) {
			//echo $column . $rowExec; die;
			$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($column, $rowExec, $cell);
			$objPHPExcel -> getActiveSheet() -> getStyle(PHPExcel_Cell::stringFromColumnIndex($column) . $rowExec) -> getFont() -> setBold(true) -> setSize(14);
			$objPHPExcel -> getActiveSheet() -> getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column)) -> setAutoSize(true);

			$column++;
		}
		$rowExec = 2;
		foreach ($data['data'] as $rowset) {

			//Looping through the cells per facility
			$column = 0;
			foreach ($rowset as $cell) {
				$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($column, $rowExec, $cell);
				$column++;
			}
			$rowExec++;
		}

		//die ;

		// Rename sheet
		//	echo date('H:i:s') . " Rename sheet\n";
		$objPHPExcel -> getActiveSheet() -> setTitle('Simple');

		// Save Excel 2007 file
		//echo date('H:i:s') . " Write to Excel2007 format\n";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');

		// It will be called file.xls
		header('Content-Disposition: attachment; filename=' . $filename . '.xlsx');

		// Write file to the browser
		$objWriter -> save('php://output');
		// Echo done
		//echo date('H:i:s') . " Done writing file.\r\n";
	}

}
