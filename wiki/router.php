<?php
Class Router
{
	public function __construct()
	{
		 $request_uri = explode('/', $_SERVER['REQUEST_URI']);
		 $script_name =  explode('/', $_SERVER['SCRIPT_NAME']);
		 $size = sizeof($script_name);
		 
		 for ($i=0; $i < $size; $i++)
		 {
		 	if ($request_uri[$i] == $script_name[$i])
		 		unset($request_uri[$i]);
		 }

		$request_uri = array_values($request_uri);
		
		if (!empty($request_uri))
		{
			$this->_controller = $request_uri[0];
			
			unset($request_uri[0]);
			$request_uri = array_values($request_uri);
		}
		
		if (!empty($request_uri))
		{
			$this->_parms = $request_uri;
		}
		
	}
	
	public function get_controller()
	{
		return $this->_controller;
	}
	
	public function get_parms()
	{
		return $this->_parms;
	}
	
	private $_controller = '';
	private $_parms = array();
}