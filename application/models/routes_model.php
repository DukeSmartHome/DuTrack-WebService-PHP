<?php

class Routes_model extends CI_Model {
  
  function __construct()
  {
  	// Call the Model constructor
    parent::__construct();
  }
  
  function get_routes($route_id = NULL)
  {
  	if ($route_id) {
  		return _get_route($route_id);
  	} else {
  		$this->db->select('name');
  		$query = $this->db->get('routes');
    	return $query->result();
  	}
  }
  
  function _get_route($route_id)
  {
  	
  }
}