<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buses extends CI_Controller {

	function __construct()
	{
		parent::__construct();
    $this->load->model('buses_model');
	}

	function index($route_id)
	{
    $data = array(
      'data' => $this->buses_model->get_bus_locations($route_id),
      'callback' => $this->input->get('callback', NULL),
    );
    
    if ($data['callback']) $this->load->view('jsonp', $data);
    else $this->load->view('json', $data);
	}
}