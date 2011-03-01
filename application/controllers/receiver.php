<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiver extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('welcome_message');
	}
	
	function event() 
	{
		$event = _map_post_data_for_model();
		$event = _post_process_event($event);
		// use model to write converted event data to database
	    $this->event_model->add_record($event);
	}
	
	function _post_process_event($event)
	{
		list($event['latitude'], $event['longitude']) =
			_convert_lat_lng_to_decimal($event['latitude'], 
										$event['longitude']);
		
		$event['timestamp'] = _convert_to_unix_timestamp($event['timestamp']);
	}
	
	/**
	 * convert longitude and latitude to from degrees to decimal
	 * formula found at 
	 * http://en.wikipedia.org/wiki/Geographic_coordinate_conversion
	 */
	function _convert_lat_lng_to_decimal($lat, $lng)
	{
		// get direction and assign correct sign to be used in next operation
		if (substr($lat, -1) == 'N') $lat_dir = 1;
		else $lat_dir = -1;
		
		if (substr($lng, -1) == 'E') $lng_dir = 1;
		$lng_dir = -1;
		
		// convert latitude
		$degrees = (float) substr($lat, 0, 2);
		$minutes = (float) substr($lat, 2, 9);
		$latitude_decimal = $lat_dir * ($degrees + $lat_dir * $minutes/60);
		
		// convert longitutde
		$degrees = (float) substr($lng, 0, 3);
		$minutes = (float) substr($lng, 3, 10);
		$longitude_decimal = $lng_dir * ($degress + $lng_dir * $minutes/60);
		
		return array($latitude_decimal, $longitude_decimal);
	}
	
	/**
	 * convert proriatory GMT timestamp to unix format
	 * sample format: 062620.240211
	 */
	function _convert_to_unix_timestamp($timestamp)
	{
		list($time, $date) = explode('.', $timestamp);
		
		// breakdown time
		$hour = substr($time, 0, 2);
		$minute = substr($time, 2, 2);
		$second = substr($time, 4, 2);
		
		// breakdown date
		$day = substr($date, 0, 2);
		$month = substr($date, 2, 2);
		$year = substr($date, 4, 2);
		
		return gmmktime($hour, $minute, $second, $day, $month, $year);
	}
	
	/**
	 * Returns array of post variables from tracker with keys as database
	 * columns names 
	 */
	function _map_post_data_for_model()
	{
		// create map the abbreviate post data to database
		$post_data_map = array(
	        'id'	=> 'device_id',
	        'h'		=> 'heading',
	        'la'	=> 'latitude',
	        'lo'   	=> 'longitude',
	        's'   	=> 'speed',
	        't'   	=> 'timestamp',
      	);
      	
		// create new array with full column names as keys to to be passed in
		// to model
      	$event = array();
      	foreach ($post_data_map as $key => $value) {
	    	$event[$value] =  $this->input->post($key);
		}
		
		return $event;
	}
	
	/**
	 * DISABLE ON PRODUCTION SITE - Used to test reciever 
	 */
	function test_form()
	{
		$this->load->helper('form');
		$this->load->view('receiver_form');
	}
}
