<div class="menu">
	<div class="element">
		<h3>Contents</h3><br/>
		<ul class="menulist">
			<li>
				<a href="<?php echo $base_url . 'view/' . $default_page; ?>">
					<?php echo $default_page_display; ?>
				</a>
			</li>
			<li>
				<a href="<?php echo $base_url . 'viewall/'; ?>">All Pages</a>
			</li>
		</ul>
	</div>
	<div class="element">
		<h3>Categories</h3><br/>
		<ul class="menulist">
			<?php foreach($wiki_categories as $key => $value): ?>
				<li>
					<a href="<?php echo $base_url . 'viewall/' . $key; ?>"><?php echo $value; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	
	<div class="element float">
		<form action="<?php echo $base_url . 'newpage'; ?>" method="POST">
			<input type="submit" id="new" name="new" value="New Page" />
		</form>
	</div>
</div>