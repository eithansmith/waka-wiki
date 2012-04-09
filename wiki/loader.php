<?php
Class Loader
{
	public function __construct($path = '')
	{
		$this->_path = $path;
	}
	
	public function load($file, $data = FALSE)
	{
		$file_path = "$this->_path/$file.php";
 		
		if ($data)
		{
			foreach($data as $key => $value)
				$$key = $value;
		
			$data = null;
		}
		
		//die($file_path);
        if (file_exists($file_path))
            include_once($file_path);
        else
        {
        	die($file_path . ' not found with load');
        }
	}
	
	private $_path = '';
}