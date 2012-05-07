<!DOCTYPE html>
<html>
<head>
	<title><?php echo $wiki_title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>wiki/templates/default/css/default.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>wiki/markitup/skins/markitup/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>wiki/markitup/sets/wiki/style.css" />

	<script type="text/javascript" src="<?php echo $base_url; ?>wiki/markitup/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>wiki/markitup/jquery.markitup.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>wiki/markitup/sets/wiki/set.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>wiki/markitup/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?php echo $base_url; ?>wiki/markitup/jquery.jec-1.3.3.js"></script>

	<script>
		$(document).ready(function() {
	    	$('.markItUp').markItUp(mySettings);
	    	$('#delete').click(function(){
	            var answer = confirm('Are you should you want to delete this page?');
	            return answer;
	        });
	        $('.tablesorter').tablesorter({sortList: [[1,0], [0,0]]});
	        $('.jec').jec();
		});
	</script>
</head>
<body>

<?php if ($header_logo != ''): ?>
	<div id="header-logo">
		<a href="<?php echo $base_url . 'view/' . $default_page; ?>">
			<img src="<?php echo $base_url . 'wiki/images/' . $header_logo; ?>" />
		</a>
	</div>
<?php endif; ?>

<a href="<?php echo $base_url . 'view/' . $default_page; ?>" class="no-link">
	<div id="wiki-title">	
			<h1><?php echo $wiki_title; ?></h1>
	</div>
</a>

<div class="clear"></div>