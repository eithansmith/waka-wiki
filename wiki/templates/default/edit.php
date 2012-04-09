<div class="content">

	<div class="title">Edit "<?php echo $page_display; ?>"</div>
	
	<?php include_once 'message.php'; ?>
	
	<form action="<?php echo $base_url . 'update/' . $name; ?>" method="POST">
		<div class="element">
			<label for="name">Name</label><br/>
			<input type="text" id="name" name="name" value="<?php echo $page_display; ?>" />
		</div>
		
		<div class="element">
			<label for="category">Category</label><br/>
			<select class="jec" name="category" id="category">
				<?php foreach($wiki_categories as $wiki_category): ?>
					<option value="<?php echo $wiki_category; ?>" <?php if ($wiki_category == $category) echo 'selected="selected"'; ?>)>
						<?php echo $wiki_category; ?>
					</option>
				<?php endforeach; ?>
			</select>
			(Select from the drop-down or type to create a new one)
		</div>
		
		<div class="element">
			<label for="text">Text</label><br/>
			<textarea name="text" id="text" class="markItUp" cols="80" rows="20"><?php echo $text; ?></textarea>
		</div>
		
		<div class="element">
			<label for="rev">Revision</label><br/>
			<input type="text" id="rev" name="rev" value="<?php echo $rev; ?>" />
			(This will be incremented after the save)
		</div>
		
		<?php if ($password_required): ?>
			<div class="element">
				<label for="password">Password</label><br/>
				<input type="password" id="password" name="password" value="" />
			</div>
		<?php endif; ?>
		
		<div class="element float">
			<input type="submit" id="save" name="save" value="Save" />
		</div>		
	</form>
	
	<div class="element float">
		<form action="<?php echo $base_url . 'delete/' . $name; ?>" method="POST">
			<input type="submit" id="delete" name="delete" value="Delete" />
		</form>
	</div>
	
	<div class="element float">
		<form action="<?php echo $base_url . 'view/' . $name; ?>" method="POST">
			<input type="submit" id="cancel" name="cancel" value="Cancel" />
		</form>
	</div>
	
	<div class="clear"></div>	
	
</div>

<div class="clear"></div>