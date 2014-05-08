<?php
ini_set('MAX_EXECUTION_TIME', -1);
/**
 * @author Maestro
 */
class Upload extends MY_Controller
{
    var $actualTables;
    function __construct() {
        parent::__construct();
        
        //$this -> load -> model('models_sugar/M_Sugar_ExternalFort_B3');
        $this->load->library('PHPexcel');
        ini_set('memory_size', '2048M');
    }
    
    function index() {
        $dataArr['contentView'] = 'upload/upload_v';
        
        $dataArr['uploaded'] = '';
        $dataArr['posted'] = 0;
        $this->load->view('template_v', $dataArr);
    }
    
    public function data_upload($activesheet = 0, $activity_id, $insert_table) {
         //convert .slk file to xlsx for upload
        
        //get activity ID
        
        $type = "";
        $start = 1;
        $config['upload_path'] = '././uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000000000';
        $this->load->library('upload', $config);
        
        //die();
        $file_1 = "upload_button";
        
        if ($type == 'slk') {
            
            //$edata = new Spreadsheet_Excel_Reader();
            
            // Set output Encoding.
            //$edata -> setOutputEncoding("CP1251");
            
            if ($_FILES['file_1']['tmp_name']) {
                $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
                $excelReader->setReadDataOnly(true);
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
            }
            
            $objPHPExcel = PHPExcel_IOFactory::load(str_replace('.php', '.xlsx', __FILE__));
        } else {
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);
        }
        
        $sheetCount = $objPHPExcel->getSheetCount();

        $objReader = new PHPExcel_Reader_Excel5();
        $sheetName[0] = '';
        if ($sheetCount > 1) {
            $sheetName = $objReader->listWorksheetNames($_FILES['file_1']['tmp_name']);
        }
        // print_r( $sheetName);die;
        for ($x = 0; $x < $sheetCount; $x++) {
            
            $arr = $objPHPExcel->setActiveSheetIndex($x)->toArray(null, true, true, true);
            $highestColumm = $objPHPExcel->setActiveSheetIndex($x)->getHighestColumn();
            $highestRow = $objPHPExcel->setActiveSheetIndex($x)->getHighestRow();
            $data = array();
            $mytab = "";
            
            //echo $highestColumm;
            $data = $this->getData($arr, $start, $highestColumm, $highestRow);
            
            //echo '<pre>';print_r($data);echo '</pre>';die;
            //$data =json_encode($data);
            //echo($data);die;
            $data = $this->formatData($data);
            
            //echo '<pre>';print_r($data);echo '</pre>';die;
            
            //$this -> createTables();
            
            $this->createAndSetProperties($data, $activity_id, $insert_table,$sheetName[$x]);
            
            //echo $activity_id;die;
            $data = $this->makeTable($data);
        }
        $dataArr['uploaded'] = $data;
        
        $dataArr['posted'] = 1;
        $dataArr['contentView'] = 'upload/upload_v';
    }
    
    public function data_uploadSpecific() {
        
        //convert .slk file to xlsx for upload
        $type = "";
        $start = 1;
        $config['upload_path'] = '././uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000000000';
        $this->load->library('upload', $config);
        
        //die();
        $file_1 = "upload_button";
        $activesheet = 0;
        if ($type == 'slk') {
            
            //$edata = new Spreadsheet_Excel_Reader();
            
            // Set output Encoding.
            //$edata -> setOutputEncoding("CP1251");
            
            if ($_FILES['file_1']['tmp_name']) {
                $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
                $excelReader->setReadDataOnly(true);
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);
                
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
            }
            
            $objPHPExcel = PHPExcel_IOFactory::load(str_replace('.php', '.xlsx', __FILE__));
        } else {
            $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file_1']['tmp_name']);
        }
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $arr = $objPHPExcel->setActiveSheetIndex($activesheet)->toArray(null, true, true, true);
        $highestColumm = $objPHPExcel->setActiveSheetIndex($activesheet)->getHighestColumn();
        $highestRow = $objPHPExcel->setActiveSheetIndex($activesheet)->getHighestRow();
        $data = array();
        $mytab = "";
        
        //echo $highestColumm;
        $data = $this->getDataSpecific($arr, '23', '149', 'C');
        
        //die;
        //$this -> createTables();
        //$this -> createAndSetProperties($data);
        //$data = $this -> makeTable($data);
        $this->db->insert_batch('activities', $data);
        $dataArr['uploaded'] = $data;
        
        $dataArr['posted'] = 1;
        $dataArr['contentView'] = 'upload/upload_v';
        $this->load->view('template_v', $dataArr);
    }
    
    public function upload_commit() {
        
        $size = $this->input->post('size');
        for ($i = 1; $i <= $size; $i++) {
            $data['testNO'][$i] = $this->input->post('testNO' . $i);
            $data['deviceID'][$i] = $this->input->post('deviceID' . $i);
            $data['asayID'][$i] = $this->input->post('asayID' . $i);
            $data['sampleNumber'][$i] = $this->input->post('sampleNumber' . $i);
            $data['cdCount'][$i] = $this->input->post('cdCount' . $i);
            $data['resultDate'][$i] = $this->input->post('resultDate' . $i);
            $data['operatorId'][$i] = $this->input->post('operatorId' . $i);
        }
        
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        //save to DB
        //$this->db->insert_batch("test",$data);
        
        
    }
    
    public function getData($arr, $start, $highestColumn, $highestRow) {
        
        //possible columns
        for ($col = $start; $col < PHPExcel_Cell::columnIndexFromString($highestColumn) + 1; $col++) {
            
            for ($row = $start; $row <= $highestRow; $row++) {
                $colString = PHPExcel_Cell::stringFromColumnIndex($col - 1);
                $title = $arr[$start][$colString];
                if ($title != " ") {
                    
                    //fields you want to save in DB
                    $data[$title][] = $arr[$row][$colString];
                }
            }
        }
        
        return $data;
    }
    
    public function getDataSpecific($arr, $start, $end, $colString) {
        $data = array();
        
        //possible columns
        for ($row = $start; $row < $end; $row++) {
            
            if ($arr[$row][$colString] != "") {
                $data[] = array('activity_name' => $arr[$row][$colString], 'activity_start' => strtotime('2013-09-01'), 'activity_end' => strtotime('2013-12-01'));
            }
        }
        
        return $data;
    }
    
    public function formatData($data) {
        $rows = array();
        
        //var_dump($data);
        foreach ($data as $key => $value) {
            
            //echo sizeof($value);
            $title[] = $key;
            
            //$rowCounter = 0;
            for ($rowCounter = 1; $rowCounter < sizeof($value); $rowCounter++) {
                if ($value[$rowCounter] != NULL) {
                    $rows['data'][$rowCounter][$key] = $value[$rowCounter];
                }
            }
        }
        
        //echo
        $rows['title'] = $title;
        
        return $rows;
    }
    
    public function makeTable($data) {
        $tableTitle = "<thead>";
        $tableTitle.= '<tr>';
        foreach ($data['title'] as $title) {
            $tableTitle.= '<th width="100px">' . $title . '</th>';
        }
        $tableTitle.= '</tr>';
        $tableTitle.= '</thead>';
        
        $tableData = '<tbody>';
        
        $j = 0;
        foreach ($data['data'] as $key => $data) {
            $tableData.= '<tr>';
            foreach ($data as $dataKey => $dataVal) {
                $tableData.= '<td>' . $dataVal . '</td>';
            }
            $tableData.= '</tr>';
        }
        $tableData.= '</tbody>';
        
        $table = $tableTitle . $tableData;
        return $table;
    }
    
    /**
     * Initializes Tables in the Database
     */
    public function createAndSetProperties($data, $activity_id, $insert_table, $source = '') {
        $dataTables = array($insert_table);
        $title = $data['title'];
        
        //add to title
        $title[] = 'UPLOAD DATE';
        $title[] = 'ACTIVITY ID';
        $title[] = 'POLICY SOURCE';
        $rowCounter = 0;
        $tableObj = array();
        foreach ($dataTables as $table) {
            
            foreach ($data['data'] as $data1) {
                $currentTable = R::dispense($table);
                
                //convert date to timestamp
                $data1 = $this->formatDate($data1, 'DATES');
                
                //set update time
                $data1['UPLOAD DATE'] = time();
                
                $data1 = $this->addIfNotExists($data1, 'cadre', 'cadre_name', 'CADRE', 'cadre_id');
                
                //set activity id
                $data1['ACTIVITY ID'] = $activity_id;
                $data1['POLICY SOURCE'] = $source;
                
                //link FacilityName to MFC
                
                //remove excess columns
                unset($data1['county']);
                unset($data1['district']);
                foreach ($title as $val) {
                    $valN = strtolower($val);
                    $valN = str_replace("/", " ", $valN);
                    $valN = str_replace("-", " ", $valN);
                    $valN = str_replace(" ", "_", $valN);
                    
                    if (array_key_exists($val, $data1)) {
                        $currentTable->setAttr($valN, $data1[$val]);
                    }
                }
                
                R::store($currentTable);
            }
        }
    }
    
    public function checkifExists($array, $table, $column, $key) {
        $this->db->like($column, $array[$key]);
        $this->db->from($table);
        $count = $this->db->count_all_results();
        return $count;
    }
    
    public function addIfNotExists($array, $table, $column, $key, $id) {
        
        //link Department Name to Department ID
        if (array_key_exists($key, $array)) {
            
            $count = $this->checkifExists($array, $table, $column, $key);
            
            //echo $count;die;
            if ($count > 0) {
                $results = $this->db->get_where($table, array($column => $array[$key]));
                foreach ($results->result_array() as $field) {
                    $array[$key] = $field[$id];
                }
            } else {
                $data = array($column => $array[$key]);
                $this->db->insert($table, $data);
                $results = $this->db->get_where($table, array($column => $array[$key]));
                foreach ($results->result_array() as $field) {
                    $array[$key] = $field[$id];
                }
            }
        } else {
        }
        return $array;
        
        //echo '<pre>';print_r($array); echo '</pre>';
        
    }
    
    public function formatDate($array, $key) {
        if (array_key_exists($key, $array)) {
            
            //convert date to timestamp
            $newDate = str_replace('/', '-', $array[$key]);
            $newDate = strtotime($newDate);
            $array[$key] = $newDate;
        }
        return $array;
    }
    
    /**
     * Reading the contents of a CSV
     */
    public function readCSV() {
        $row = 1;
        if (($handle = fopen(base_url() . 'test.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                
                //echo "<p> $num fields in line $row: <br /></p>\n";
                
                for ($c = 0; $c < $num; $c++) {
                    
                    $oldData[$row][] = $data[$c];
                }
                $row++;
            }
            fclose($handle);
        }
        $newData = array();
        foreach ($oldData as $key => $value) {
            if ($value[2] != "") {
                
                //exit ;
                
            } else {
                if ($value[0] == "" || $value[1] == "") {
                } else {
                    $newData[] = $value;
                }
            }
            
            //echo '<pre>';
            //print_r($newData);
            //echo '</pre>';
            
            
        }
    }
}
