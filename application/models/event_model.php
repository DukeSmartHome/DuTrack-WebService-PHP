<?php

class Event_model extends CI_Model {
  
  function __construct()
  {
  	// Call the Model constructor
    parent::__construct();
  }
  
  function add_record($event) 
  {
    if (sizeof($event) > 0) {
      $this->db->insert('data', $event);
    }
    return;
  }
  
  /*
  function get_records()
  {
    $query = $this->db->get('events');
    return print_r($query->result());
  }

  
  
  function update_record($data) 
  {
    $this->db->where('id', 12);
    $this->db->update('data', $data);
  }
  
  function delete_row()
  {
    $this->db->where('id', $this->uri->segment(3));
    $this->db->delete('data');
  }
   * 
   */
  
}