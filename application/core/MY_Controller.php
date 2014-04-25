<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */

class MY_Controller extends MX_Controller
{
    var $sub_program_list, $activity_table, $hcmp;
    function __construct() {
        parent::__construct();
        date_default_timezone_set('Africa/Nairobi');
        $this->load->model('global_model');
        $this->getSubPrograms();
        
        //$this -> getActivity_Table();
        
        
    }
    
    function getSubPrograms() {
        $results = $this->global_model->getSubPrograms();
        $links = '';
        foreach ($results->result() as $sub_program) {
            $links.= '<li><a href="' . base_url() . $sub_program->sub_program_name . '">' . $sub_program->sub_program_name . '</a></li>';
        }
        $this->sub_program_list = $links;
        return $this->sub_program_list;
        
        //var_dump($results);
        
        
    }
    
    public function getActivity_Table($subprogram) {
    }
    
    public function facility_list() {
        $facility = $this->db->get('facility');
        $facility = $facility->result_array();
        $option = '<option value="0" selected="selected">Please Select Facility</option>';
        
        foreach ($facility as $fac) {
            $option.= '<option value="' . $fac['facilityMFC'] . '">' . $fac['facilityName'] . '</option>';
        }
        
        return $option;
    }
    
    public function department_list() {
        $facility = $this->db->get('departments');
        $facility = $facility->result_array();
        $option = '<option value="n/a" selected="selected">Please Select Department</option>';
        
        foreach ($facility as $fac) {
            $option.= '<option value="' . $fac['department_id'] . '">' . $fac['department_name'] . '</option>';
        }
        
        return $option;
    }
    
    public function cadre_list() {
        $facility = $this->db->get('cadre');
        $facility = $facility->result_array();
        $option = '<option value="n/a" selected="selected">Please Select Job Title</option>';
        
        foreach ($facility as $fac) {
            $option.= '<option value="' . $fac['cadre_id'] . '">' . $fac['cadre_name'] . '</option>';
        }
        
        return $option;
    }
    
    /**
     * IMCI Training Functions
     */
    function training_data($columns, $group_order, $training) {
        $training_data = $this->global_model->getTrainingData($columns, $group_order, $training);
        return $training_data;
    }
    
    public function trained($activity) {
        $this->db->like('activity_id', $activity);
        $this->db->from('subprogramlog');
        $tot = $this->db->count_all_results();
        return $tot;
    }
    public function latest_training($activity) {
        $this->db->select_max('dates');
        $result = $this->db->get_where('subprogramlog', array('activity_id' => $activity));
        $result = $result->result_array();
        $latest_training = date('d-M-Y', $result[0]['dates']);
       
        $latest_training = ($latest_training == '01-Jan-1970' ? 'N/A' : $latest_training);
        return $latest_training;
    }
    public function total_facilities_trained($activity_id) {
        $query = 'select count(distinct mfl_code) as total FROM subprogramlog WHERE activity_id=?';
        $result = $this->db->query($query,$activity_id);
        $result = $result->result_array();
        return $result[0]['total'];
    }
    public function specific_facilities_trained($county,$activity_id) {
        $query = 'select 
    count(distinct mfl_code) as total
FROM
    subprogramlog
        JOIN
    facility ON (subprogramlog.mfl_code = facility.facilityMFC
        AND facility.facilityCounty = ?) WHERE activity_id=?';
        $result = $this->db->query($query, array($county,$activity_id));
        $result = $result->result_array();
        return $result[0]['total'];
    }
    public function region_trained($county,$activity_id) {
        $query = 'select 
    count(mfl_code) as total
FROM
    subprogramlog
        JOIN
    facility ON (subprogramlog.mfl_code = facility.facilityMFC
        AND facility.facilityCounty = ?) WHERE activity_id=?';
        $result = $this->db->query($query, array($county,$activity_id));
        $result = $result->result_array();
        return $result[0]['total'];
    }
    
    public function facility_type_trained($county, $cat,$activity_id) {
        switch ($cat) {
            case 'HCW':
                $distinct = '';
                
            case 'TOT':
                $distinct='';
                break;
            case "Facility":
                $distinct = 'distinct';
                break;
        }
        $query = 'select 
    count(' . $distinct . ' facility.facilityMFC) as total,(CASE
                WHEN facilityOwnedBy = "Private Practice - General Practitioner" THEN "Private"
                WHEN facilityOwnedBy = "Private Practice - Nurse / Midwife" THEN "Private"
                WHEN facilityOwnedBy = "Private Enterprise (Institution)" THEN "Private"
                WHEN facilityOwnedBy = "Private Practice - Clinical Officer" THEN "Private"
                WHEN facilityOwnedBy = "Christian Health Association of Kenya" THEN "Private"
                WHEN facilityOwnedBy = "Other Faith Based" THEN "Private"
                WHEN facilityOwnedBy = "FBO" THEN "Private"
                WHEN facilityOwnedBy = "Kenya Episcopal Conference-Catholic Secretariat" THEN "Private"
                ELSE "Public"
            END) as facilityOwner
FROM
    subprogramlog
        JOIN
    facility ON (subprogramlog.mfl_code = facility.facilityMFC AND facilityCounty=?) WHERE activity_id=?
GROUP BY facilityOwner';
        $result = $this->db->query($query, array($county,$activity_id));
        $result = $result->result_array();
        $data['Private'] = $data['Public'] = 0;
        foreach ($result as $arr) {
            $data[$arr['facilityOwner']] = (int)$arr['total'];
        }
        return $data;
    }
}
