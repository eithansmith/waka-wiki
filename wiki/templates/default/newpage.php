<div class="content">

	<div class="title">Create New Page</div>
	
	<?php include_once 'message.php'; ?>
	
	<form action="<?php echo $base_url . 'create'; ?>" method="POST">
		<div class="element">
			<label for="name">Name</label><br/>
			<input type="text" id="name" name="name" value="<?php echo $page_display; ?>" />
		</div>
		
		<div class="element">
			<label for="category">Category</label><br/>
			<select class="jec" name="category" id="category">
				<?php foreach($wiki_categories as $wiki_category): ?>
					<option value="<?php echo $wiki_category; ?>">
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
		
		<?php if ($password_required): ?>
			<div class="element">
				<label for="password">Password</label><br/>
				<input type="password" id="password" name="password" value="" />
			</div>
		<?php endif; ?>
		
		<div class="element float">
			<input type="submit" id="create" name="create" value="Create" />
		</div>		
	</form>
	
	<div class="element float">
		<form action="<?php echo $base_url; ?>" method="POST">
			<input type="submit" id="cancel" name="cancel" value="Cancel" />
		</form>
	</div>
	
	<div class="clear"></div>	
	
</div>

<div class="clear"></div>