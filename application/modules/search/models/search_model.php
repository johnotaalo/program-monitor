<?php
class Search_Model extends MY_Controller
{
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_data($parameter, $value, $activity_id) {
        switch ($parameter) {
            case 'county':
                $criteria_condition = 'fac_county=?';
                break;

            case 'district':
                $criteria_condition = 'fac_district=?';
                break;

            case 'facility':
                $criteria_condition = 'fac_mfl=?';
                break;
        }
        $data=array();
        
        /*--------------------begin get data----------------------------------------------*/
        $query = 'select 
    count(distinct facilities.fac_mfl) as total
FROM
    facilities,subprogramlog WHERE facilities.' . $criteria_condition . ' AND subprogramlog.activity_id=?';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    $data['facility_data']['facility_number_existing']=$value_['total'];
                }
                
                              
                
            } else {
               
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }
        /*--------------------begin get data----------------------------------------------*/
        $query = 'select 
    count(*) as total
FROM
    subprogramlog JOIN facilities ON (facilities.fac_mfl = subprogramlog.mfl_code AND facilities.' . $criteria_condition . ' AND subprogramlog.activity_id=?)';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    $data['participant_data']['participant_number_trained']=$value_['total'];
                }
                
                              
                
            } else {
               
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }
        $query = 'select 
    count(distinct mfl_code) as total
FROM
    subprogramlog
        JOIN
    facilities ON (subprogramlog.mfl_code = facilities.fac_mfl
        AND facilities.' . $criteria_condition . ') WHERE activity_id=?';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    $data['facility_data']['facility_number_trained']=$value_['total'];
                }
                
                              
                
            } else {
               
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }
            /*--------------------begin get data----------------------------------------------*/
        $query = 'select 
    distinct(mfl_code),facilities.fac_name
FROM
    subprogramlog
        JOIN
    facilities ON (subprogramlog.mfl_code = facilities.fac_mfl
        AND facilities.' . $criteria_condition . ') WHERE activity_id=?';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    $data['facility_data']['facility_list'][]=$value_;
                }
                
              
                
                
            } else {
              
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }
         $query = 'select 
    names_of_participant,facilities.fac_name,cadre.cadre_name as cadre
FROM
    subprogramlog
        JOIN
    facilities ON (subprogramlog.mfl_code = facilities.fac_mfl
        AND facilities.' . $criteria_condition . ') JOIN cadre on (subprogramlog.cadre=cadre.cadre_id) WHERE activity_id=?';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    $data['participant_data']['participant_list'][]=$value_;
                }
                
              
                
                
            } else {
              
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }

         $query = 'select 
    count(distinct facilities.fac_mfl) as total,(CASE
                WHEN fac_ownership = "Private Practice - General Practitioner" THEN "Private"
                WHEN fac_ownership = "Private Practice - Nurse / Midwife" THEN "Private"
                WHEN fac_ownership = "Private Enterprise (Institution)" THEN "Private"
                WHEN fac_ownership = "Private Practice - Clinical Officer" THEN "Private"
                WHEN fac_ownership = "Christian Health Association of Kenya" THEN "Private"
                WHEN fac_ownership = "Other Faith Based" THEN "Private"
                WHEN fac_ownership = "FBO" THEN "Private"
                WHEN fac_ownership = "Kenya Episcopal Conference-Catholic Secretariat" THEN "Private"
                ELSE "Public"
            END) as facilityOwner
FROM
    subprogramlog
        JOIN
    facilities ON (subprogramlog.mfl_code = facilities.fac_mfl AND facilities.' . $criteria_condition . ')  WHERE activity_id=?
GROUP BY facilityOwner';
        
        try {
            
            $result = $this->db->query($query, array($value, $activity_id));
            $result = $result->result_array();
            
            
            //echo($this->db->last_query());die;
            if ( $result !== NULL) {
                
                foreach ( $result as $value_) {
                    switch($value_['facilityOwner']){
                        case 'Public':
                            $data['participant_data']['public'][]=$value_['total'];
                        break;
                        case 'Private':
                        $data['participant_data']['private'][]=$value_['total'];
                        break;
                    }
                    
                }
                
              
                
                
            } else {
              
            }
        }
        catch(exception $ex) {
            
            //ignore
            //die($ex->getMessage());//exit;
            
            
        }

        return $data;
    }
    }
    