<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('routes_model');
	}

	function index()
	{
		$all_routes = $this->routes_model->get_routes();
		$routes_data = array();
		foreach ($all_routes as $route) {
			$routes_data[] = $route->name;
		}
		
		$data = array(
			'data' => $routes_data,
			'callback' => $this->input->get('callback', NULL),
		);
		
		if ($data['callback']) $this->load->view('jsonp', $data);
		else $this->load->view('json', $data);
	}
}