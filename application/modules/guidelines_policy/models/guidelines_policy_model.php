<?php
class Guidelines_Policy_Model extends MY_Controller
{
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * [distribution description]
     * @param  [type] $scope
     * @param  [type] $criteria
     * @return [type]
     */
    public function distribution($scope, $criteria, $limit) {
        switch ($limit) {
            case 'all':
                $limit = '';
                break;

            default:
                $limit = 'LIMIT ' . $limit;
                break;
        }
        switch ($scope) {
            case 'region':
                $query = "SELECT 
    sum(allocations) as total, fac_" . $criteria . "  as " . $criteria . "
FROM
    `program-monitor`.subprogramlog s
        JOIN
    facilities f ON f.fac_mfl = s.mfl_code
WHERE
    activity_id = 35 and allocations != ''
GROUP BY f.fac_" . $criteria . " 
ORDER BY total DESC
" . $limit . "
;";
                break;

            case 'source':
                $query = "SELECT 
    sum(allocations) as total, policy_source as source
FROM
    `program-monitor`.subprogramlog s
        JOIN
    facilities f ON f.fac_mfl = s.mfl_code
WHERE
    activity_id = 35 and allocations != ''
GROUP BY policy_source 
ORDER BY total DESC
LIMIT 10
;";
                break;
        }
        
        $result = $this->db->query($query);
        return $result;
    }
    
    public function get_total($activity_id,$criteria) {
        $counties = $this->db->get('counties');

        switch($criteria){
            case 'county':
             foreach ($counties->result_array() as $county) {
            $data[$county['county_name']] = $this->total_distributed_map($activity_id, $county['county_name']);
        }
            break;
            case 'source':
             foreach ($counties->result_array() as $county) {
            $data[$county['county_name']] = $this->total_source_map($activity_id, $county['county_name']);
        }
            break;
        }
        
       
        return $data;
    }
    
    /**
     * [total_distributed description]
     * @param  [type] $activity_id
     * @return [type]
     */
    public function total_distributed_map($activity_id, $county) {
        
        $query = 'SELECT 
    available.total as available,
    total.total as total,
    round((available.total / total.total) * 100, 2) as percentage,
    available.county,
    available.county_fusion_map_id
FROM
    (SELECT 
        count(distinct mfl_code) as total,
            fac_county as county,
            c.county_fusion_map_id as county_fusion_map_id
    FROM
        subprogramlog s
    JOIN facilities f ON f.fac_mfl = s.mfl_code
        AND f.fac_county = "'.$county.'"
    JOIN counties c ON f.fac_county = c.county_name
    WHERE
        activity_id = ? and allocations != ""
    GROUP BY f.fac_county
    ORDER BY total DESC) as available,
    (SELECT 
        count(distinct fac_mfl) as total
    FROM
        facilities f
    WHERE
        f.fac_county = "'.$county.'") as total';
        
        $result = $this->db->query($query, $activity_id);
        return $result->result_array();
    }
    public function total_distributed($activity_id) {
        
        $query = "SELECT 
    SUM(allocations) as total
FROM
    subprogramlog s
WHERE
    s.activity_id = ?;";
        
        $result = $this->db->query($query, $activity_id);
        return $result;
    }

    /**
     * [total_distributed description]
     * @param  [type] $activity_id
     * @return [type]
     */
    public function total_source_map($activity_id, $county) {
        
        $query = 'SELECT 
    available.policy_source,
    available.county,
    available.county_fusion_map_id,
    available.allocations
FROM
    (SELECT 
        sum(allocations) as allocations,
            fac_county as county,
            c.county_fusion_map_id as county_fusion_map_id,
            policy_source
    FROM
        subprogramlog s
    JOIN facilities f ON f.fac_mfl = s.mfl_code
        AND f.fac_county = "'.$county.'"
    JOIN counties c ON f.fac_county = c.county_name
    WHERE
        activity_id = ? and allocations != ""
    GROUP BY s.policy_source
    ORDER BY allocations DESC) as available;';
        
        $result = $this->db->query($query, $activity_id);
        return $result->result_array();
    }

}
