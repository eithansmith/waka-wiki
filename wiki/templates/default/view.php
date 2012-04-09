<div class="content">

	<div class="title"><?php echo $page_display; ?></div>
	
	<?php include_once 'message.php'; ?>
	
	<div class="element">
		Category: <a href="<?php echo $base_url . 'viewall/' . $category; ?>"><?php echo $category_display; ?></a>
	</div>
	
	<div class="element">
		<?php echo $text_translated; ?>
	</div>
	
	<div class="element last-modified">
		Revision <?php echo $rev; ?>. Page last modified on <?php echo $modified_display; ?>
	</div>
	
	<div class="element float">
		<form action="<?php echo $base_url . 'edit/' . $name; ?>" method="POST">
			<input type="submit" id="edit" name="edit" value="Edit" />
		</form>
	</div>
	
	<div class="clear"></div>	
	
</div>

<div class="clear"></div>