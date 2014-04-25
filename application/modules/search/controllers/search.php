<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller
{
    
    function __construct() {
        parent::__construct();
        $this->load->model('global_model');
        $this->load->model('search_model');
        $this->load->helper('file');
    }
    
    public function index() {
        $data['contentView'] = "search/index";
        $data['title'] = "Program Monitor :: Search";
        $data['brand'] = 'Search';
        $this->load->view('index');
    }
    public function write_facilities() {
        
        $facility = $this->db->get('facility');
        $facility = $facility->result_array();
        
        foreach ($facility as $fac) {
            $facArray[] = array('facility' => $fac['facilityName']);
        }
        $data = json_encode($facArray);
        
        write_file('assets/data/facilities.json', $data);
    }

    public function write_districts() {
        
        $facility = $this->db->get('districts');
        $facility = $facility->result_array();
        
        foreach ($facility as $fac) {
            $facArray[] = array('district' => $fac['district_name']);
        }
        $data = json_encode($facArray);
        
        write_file('assets/data/districts.json', $data);
    }

    public function write_counties() {
        
        $facility = $this->db->get('counties');
        $facility = $facility->result_array();
        
        foreach ($facility as $fac) {
            $facArray[] = array('county' => $fac['county_name']);
        }
        $data = json_encode($facArray);
        
        write_file('assets/data/counties.json', $data);
    }

    public function get_data_hcw($parameter,$value){
        $value = urldecode($value);
        $data = $this->search_model->get_data($parameter,$value,10);
        echo json_encode($data);
    }
    public function get_data_tot($parameter,$value){
        $value = urldecode($value);
        $data = $this->search_model->get_data($parameter,$value,8);
        echo json_encode($data);
    }
}
