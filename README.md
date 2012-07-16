waka-wiki 
=========
a dead-simple, database-free, PHP wiki.

![waka-wiki](http://s10.postimage.org/utrg19k8p/waka-wiki.png)

### Instructions
> Edit the following config.php parms.  Waka-wiki requires PHP and an Apache server with mod_rewrite enabled.
  ```php
    $config_parms = array(
        'wiki_title' 	=> 	'Waka Wiki',		 			// wiki title
	    'header_logo'	=>	'logo.png',						// wiki logo (from image dir), if blank it is not used
	    'default_page' 	=>	'main', 						// default page
	    'base_url' 		=>	'http://localhost/waka-wiki/',	// base url of your waka-wiki directory
	    'password'		=>	'password',						// admin password, if blank password not required
	    'template' 		=> 	'wiki/templates/default' 		// path to template folder from waka-wiki dir
	  );
  ```

#### Legals
> This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

> This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

> The GNU General Public License is available online at
  http://www.fsf.org/licensing/licenses/gpl.txt .
