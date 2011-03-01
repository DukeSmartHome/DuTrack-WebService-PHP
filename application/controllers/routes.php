<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('routes_model');
	}

	function index($route_id = NULL)
	{
		if (!$route_id) {
			$model_data = $this->_get_all_routes();
		} else {
			$model_data = $this->_get_route($route_id);
		}
		
		$data = array(
			'data' => $model_data,
			'callback' => $this->input->get('callback', NULL),
		);
		
		if ($data['callback']) $this->load->view('jsonp', $data);
		else $this->load->view('json', $data);
	}
	
  function _get_all_routes() {
    $all_routes = $this->routes_model->get_routes();
    $routes_data = array();
		foreach ($all_routes as $route) {
		  $routes_data[] = $route->name;
		}
		
		return $routes_data;
	}
	
	function _get_route($route_id) {
		$route = $this->routes_model->get_route($route_id);
		return $route;
	}
}