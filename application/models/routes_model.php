<?php

class Routes_model extends CI_Model {
  
  function __construct()
  {
  	// Call the Model constructor
    parent::__construct();
  }
  
  /**
   * Return the names of all the routes
   * If $active is true, return only active routes
   */
  function get_routes($active = False)
  {
  	$this->db->select('name');
  	$query = $this->db->get('routes');
  	return $query->result();
  }
  
  /**
   * Return detailed information regarding each route including:
   * name
   * category
   * path
   * stops
   * *nubmer of active buses
   */
  function get_route($route_id)
  { 
  	$this->db->select('id, name, category');
    $this->db->where('name', $route_id);
    $query = $this->db->get('routes');
    $result = $query->result_array();
    
    
    $route = NULL;
    if (sizeof($result) > 0) {
      $route = $result[0];
      
      // fetch stops
      $this->db->select('long, lat, isStop');
      $this->db->where('routeId', $route['id']);
      //$this->db->order_by('id', 'asc'); 
      $query = $this->db->get('route_coordinates');
      $coordinates_result = $query->result_array();
      
      if (sizeof($coordinates_result) > 0) {
        $coords = $coordinates_result;
        $compressed_coords = array();

        foreach ($coords as $coord) {
          $compressed_coord[] = array(
                                (float) $coord['lat'],
                                (float) $coord['long'], 
                                (integer) $coord['isStop'],
                                ); 
        }
      }
      $route['coords'] = $compressed_coord;
    }
    return $route;
  }
}