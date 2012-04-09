<?php

Class Wiki
{
	public function __construct($config_parms)
	{
		session_start();
			
		$this->_set_config_parms($config_parms);
		
		require_once 'loader.php';
		$this->_loader = new Loader($this->_template);
	}
	
	public function view($page = '')
	{	
		$data = $this->_load_wiki_page_data($page);
		$data['wiki_categories'] = $this->_get_categories();
		
		$this->_loader->load('header', $data);
		$this->_loader->load('menu', $data);
		$this->_loader->load('view', $data);
		$this->_loader->load('footer');
		exit;
	}
	
	public function viewall($category = '')
	{	
		$config = $this->_get_config_parms();
		$config['wiki_categories'] = $this->_get_categories();
		
		$data['all_wiki'] = $this->_load_all_wiki_page_data($category);
		
		$this->_loader->load('header', $config);
		$this->_loader->load('menu', $config);
		$this->_loader->load('viewall', $data);
		$this->_loader->load('footer');
		exit;
	}
	
	public function edit($page = '')
	{
		$data = $this->_load_wiki_page_data($page);
		$data['wiki_categories'] = $this->_get_categories();
		
		if ($this->_save_state)
		{
			$data['text'] = $this->_save_state['text'];
		
			$data['page_display'] = str_replace('_', ' ', $this->_save_state['name']);
			$data['page_display'] = ucwords($data['page_display']);
		}
			
		$this->_loader->load('header', $data);
		$this->_loader->load('menu', $data);
		$this->_loader->load('edit', $data);
		$this->_loader->load('footer');
		exit;
	}
	
	public function update($page = '')
	{
		$data = $this->_load_wiki_page_data($page);
		
		if (!$this->_post())
			$this->display_error("No post data found");
			
		$name = $this->_post('name');
		$name_display = $name;
		$name = str_replace(' ', '_', $name);
		$name = strtolower($name);
		
		$category = $this->_post('category');
		$category = str_replace(' ', '_', $category);
		$category = strtolower($category);
		
		$text = $this->_post('text');
		$password = $this->_post('password');
		
		$rev = $this->_post('rev') + 1;
		$created = $data['created'];
		$modified = time();
		
		if (!$this->_authenticate($password))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('Password entered is incorrect');
			$this->edit($page);
		}
		
		if (!$this->_post('name'))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('A name is required', 'warning');
			$this->edit($page);
		}
		
		if (!$this->_post('category'))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('A category is required', 'warning');
			$this->edit($page);
		}
		
		if ($name != $page)
		{
			if ($page == $this->_default_page)
			{
				$this->_save_state = $this->_post();
				$this->_save_state['name'] = $this->_default_page;
				$this->_set_message('You cannot rename the default wiki page.');
				$this->edit($page);
			}
			else
				$this->_delete_file("wiki/pages/$page.waka");
		}
		
		$file = array(
			'name' => $name,
			'category' => $category,
			'rev' => $rev,
			'created' => $created,
			'modified' => $modified,
			'text' => $text
		);
		
		$json = json_encode($file, TRUE);
		
		file_put_contents("wiki/pages/$name.waka", $json);
		
		$this->_set_message("Wiki page $name_display updated.", 'success');
		$this->view($name);	
	}
	
	public function newpage()
	{
		$data = $this->_get_config_parms();
		$data['wiki_categories'] = $this->_get_categories();
		
		if ($this->_save_state)
		{
			$data['text'] = $this->_save_state['text'];
		
			$data['page_display'] = str_replace('_', ' ', $this->_save_state['name']);
			$data['page_display'] = ucwords($data['page_display']);
		}
		else
		{
			$data['text'] = '';
			$data['page_display'] = '';
		}
			
		$this->_loader->load('header', $data);
		$this->_loader->load('menu', $data);
		$this->_loader->load('newpage', $data);
		$this->_loader->load('footer');
		exit;
	}
	
	public function create()
	{
		if (!$this->_post())
			$this->display_error("No post data found");
		
		$data = array();
			
		$name = $this->_post('name');
		$name_display = $name;
		$name = str_replace(' ', '_', $name);
		$name = strtolower($name);
		
		$category = $this->_post('category');
		$category_display = $category;
		$category = str_replace(' ', '_', $category);
		$category = strtolower($category);
		
		$text = $this->_post('text');
		$password = $this->_post('password');
		
		$rev = 0;
		$created = time();
		$modified = $created;
		
		if (!$this->_authenticate($password))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('Password entered is incorrect');
			$this->newpage();
		}
		
		if (!$this->_post('name'))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('A name is required', 'warning');
			$this->newpage();
		}
		
		if (!$this->_post('category'))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('A category is required', 'warning');
			$this->newpage();
		}
		
		
		if (@file_get_contents("wiki/pages/$name.waka"))
		{
			$this->_save_state = $this->_post();
			$this->_set_message("File $name_display already exists.");
			$this->newpage();
		}	
		
		$file = array(
			'name' => $name,
			'category' => $category,
			'rev' => $rev,
			'created' => $created,
			'modified' => $modified,
			'text' => $text
		);
		
		$json = json_encode($file, TRUE);
		
		file_put_contents("wiki/pages/$name.waka", $json);
		
		$this->_set_message("Wiki page $name_display created.", 'success');
		$this->view($name);	
	}
	
	public function delete($page = '')
	{
		if (!$this->_post())
			$this->display_error("No post data found");
		
		$data = $this->_load_wiki_page_data($page);
		
		$password = $this->_post('password');
		if (!$this->_authenticate($password))
		{
			$this->_save_state = $this->_post();
			$this->_set_message('Password entered is incorrect');
			$this->edit($page);
		}
		
		if ($page == $this->_default_page)
		{
			$this->_set_message('You cannot delete the default wiki page.');
			$this->edit($page);
		}
		
		$this->_delete_file("wiki/pages/$page.waka");
		
		$this->_set_message("Wiki page {$data['page_display']} deleted.", 'warning');
		$this->view();	
	}
	
	public function display_error($message = 'An error occurred')
	{
		$data = $this->_get_config_parms();
		$this->_set_message($message, 'error');
		
		$this->_loader->load('header', $data);
		$this->_loader->load('menu', $data);
		$this->_loader->load('blank', $data);
		$this->_loader->load('footer');
		exit;
	}
	
	private function _load_wiki_page_data($page = '')
	{
		if ($page == '')
			$page = $this->_default_page;
		
		$file = @file_get_contents("wiki/pages/$page.waka");
		if (!$file)
			$this->display_error("Wiki page \"$page\" not found");
		
		$json = json_decode($file, TRUE);
		$config = $this->_get_config_parms();
		
		$data = array_merge($json, $config);
		
		$data['created_display'] = date('F j, Y, g:i a', $data['created']);
		$data['modified_display'] = date('F j, Y, g:i a', $data['modified']);
		
		$data['page_display'] = str_replace('_', ' ', $page);
		$data['page_display'] = ucwords($data['page_display']);
		
		$data['category_display'] = str_replace('_', ' ', $data['category']);
		$data['category_display'] = ucwords($data['category_display']);
		
		if ($this->_authenticate(''))
			$data['password_required'] = FALSE;
		else
			$data['password_required'] = TRUE;
			
		$data['text_translated'] = $this->_decode_wiki_text($data['text']);
		
		return $data;
	}
	
	private function _load_all_wiki_page_data($category = '')
	{
		$all_wiki = array();
		
		$files = scandir('wiki/pages/');
		foreach($files as $file) 
		{
			$data = @file_get_contents("wiki/pages/$file");
			if ($data)
			{
				$json = json_decode($data, TRUE);
				$config = $this->_get_config_parms();
				$data = array_merge($json, $config);
				
				$data['created_display'] = date('F j, Y, g:i a', $data['created']);
				$data['modified_display'] = date('F j, Y, g:i a', $data['modified']);
				
				$data['page_display'] = str_replace('_', ' ', $data['name']);
				$data['page_display'] = ucwords($data['page_display']);
				
				$data['category_display'] = str_replace('_', ' ', $data['category']);
				$data['category_display'] = ucwords($data['category_display']);
				
				if ($category == '' || $category == $data['category'])
					$all_wiki[] = $data;
			}
		}
		
		return $all_wiki;
	}
	
	private function _get_categories()
	{
		$categories = array();
		
		$files = scandir('wiki/pages/');
		foreach($files as $file) 
		{
			$data = @file_get_contents("wiki/pages/$file");
			if ($data)
			{
				$json = json_decode($data, TRUE);
				if (array_key_exists('category', $json))
				{
					$category = $json['category'];
					$category_display = str_replace('_', ' ', $category);
					$category_display = ucwords($category_display);
					
					$categories[$category] = $category_display;
				}
			}
		}
		
		return $categories;
	}
	
	private function _post($item = '', $sanitize = TRUE)
	{
		if ($item == '')
		{
			if(is_array($_POST))
			{
				$post = array();
				foreach($_POST as $key => $value)
				{
					if ($sanitize)
						$post[$key] = $this->_santitize_string($value);
					else
						$post[$key] = $value;
				}
				return $post;
			}
			else
				return FALSE;
		}
		else
		{
			if (is_array($_POST) && isset($_POST[$item]))
			{
				if ($sanitize)
					return $this->_santitize_string($_POST[$item]);
				else
					return $_POST[$item];
			}
			else
				return FALSE;
		}
	}
	
	private function _santitize_string($string)
	{
		$string = stripslashes($string);
		$string = htmlentities($string);
		$string = strip_tags($string);
		$string = trim($string);
		return $string;
	}
	
	private function _set_message($message, $message_class = 'error')
	{
		$_SESSION['message'] = $message;
		$_SESSION['message_class'] = $message_class;
	}
	
	private function _set_config_parms($config_parms)
	{
		$this->_wiki_title = $config_parms['wiki_title'];
		$this->_password = crypt($config_parms['password'], $this->_salt);
		$this->_template = $config_parms['template'];
		$this->_default_page = $config_parms['default_page'];
		$this->_base_url = $config_parms['base_url'];
		$this->_header_logo = $config_parms['header_logo'];
		
		$this->_default_page_display = str_replace('_', ' ', $config_parms['default_page']);
		$this->_default_page_display = ucwords($this->_default_page_display);
	}
	
	private function _get_config_parms()
	{
		$data['wiki_title'] = $this->_wiki_title;
		$data['template'] = $this->_template;
		$data['default_page'] = $this->_default_page;
		$data['default_page_display'] = $this->_default_page_display;
		$data['base_url'] = $this->_base_url;
		$data['header_logo'] = $this->_header_logo;
		
		if ($this->_authenticate(''))
			$data['password_required'] = FALSE;
		else
			$data['password_required'] = TRUE;
		
		return $data;
	}
	
	private function _authenticate($password)
	{
		$password = crypt($password, $this->_salt);
		if ($password == $this->_password)
			return TRUE;
		else
			return FALSE;
	}
	
	private function _decode_wiki_text($text)
	{
		$text .= "\n";
		
		$text = preg_replace("/======(.*)======/Um", '<h5>$1</h5>', $text);
		$text = preg_replace("/=====(.*)=====/Um", '<h4>$1</h4>', $text);
		$text = preg_replace("/====(.*)====/Um", '<h3>$1</h3>', $text);
		$text = preg_replace("/===(.*)===/Um", '<h2>$1</h2>', $text);
		$text = preg_replace("/==(.*)==/Um", '<h1>$1</h1>', $text);
		
		$text = preg_replace("/''''(.*)''''/Um", '<s>$1</s>', $text);
		$text = preg_replace("/'''(.*)'''/Um", '<b>$1</b>', $text);
		$text = preg_replace("/''(.*)''/Um", '<i>$1</i>', $text);
		
		$text = preg_replace('/\[\[Image:(.*?)\|(.*?)\]\]/', '<img src="$1" alt="$2" title="$2" />', $text);
 		$text = preg_replace('/\[(.*?) (.*?)\]/', '<a target="_blank" href="$1" title="$2">$2</a>', $text);
 		
		$text = preg_replace('/\*\* (.*?)\n/', '<ul><li>$1</li></ul>', $text);
 		$text = preg_replace('/<\/ul><ul>/', '', $text);

 		$text = preg_replace('/## (.*?)\n/', '<ol><li>$1</li></ol>', $text);
 		$text = preg_replace('/<\/ol><ol>/', '', $text);
 		
 		$text = nl2br($text);
		
		return $text;
	}
	
	private function _delete_file($file)
	{
		while(is_file($file) == TRUE)
        {
        	chmod($file, 0666);
        	unlink($file);
        }
	}
	
	private $_wiki_title = '';
	private $_password = '';
	private $_salt = '54XCc22hR3d197d'; // feel free to change this
	private $_template = '';
	private $_default_page = '';
	private $_default_page_display = '';
	private $_base_url = '';
	private $_data = array();
	private $_loader = '';
	private $_save_state = FALSE;
	private $_header_logo = '';
}