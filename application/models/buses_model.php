<?php

class Buses_model extends CI_Model {
  
  function __construct()
  {
  	// Call the Model constructor
    parent::__construct();
  }
  
  /**
   * Return the names of all the routes
   * If $active is true, return only active routes
   */
  function get_bus_locations($route_id)
  {
  	$this->db->select('a.vehicle_id, m.device_id');
    $this->db->from('vehicle_assignments a');
    $this->db->where('route', $route_id);
    $this->db->join('vehicle_mappings m', 'a.vehicle_id = m.vehicle_id');
    
    $locations = array();
    
  	$bus_query = $this->db->get();
  	
    foreach ($bus_query->result_array() as $bus) {
      $this->db->_reset_select();
      
      $this->db->select_max('timestamp');
      $this->db->from('data');
      $this->db->where('device_id', $bus['device_id']);
      $max_timestamp_for_device = $this->db->_compile_select();
      
      $this->db->_reset_select();
      
      $this->db->select('latitude, longitude, speed, heading');
      $this->db->where('device_id', $bus['device_id']);
      $this->db->where("timestamp = ($max_timestamp_for_device)");
      $this->db->limit(1);
      $location_query = $this->db->get('data');
      
      $location = $location_query->row_array();
      
      if (sizeof($location) > 0) {
        $locations[$bus['vehicle_id']] = array_values($location);
      }
    }
    return $locations;
  }

}