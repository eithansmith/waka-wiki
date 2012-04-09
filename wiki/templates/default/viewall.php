<div class="content">

	<div class="title">View All Pages</div>
	
	<?php include_once 'message.php'; ?>
	
	<div class="element">
		<table class="tablesorter">
			<thead>
				<tr>
					<th>Page</th>
					<th>Category</th>
					<th>Revision</th>
					<th>Created</th>
					<th>Last Modified</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($all_wiki as $page): ?>
					<tr>
						<td>
							<a href="<?php echo $page['base_url'] . 'view/' . $page['name']; ?>">
								<?php echo $page['page_display']; ?>
							</a>
						</td>
						<td>
							<a href="<?php echo $page['base_url'] . 'viewall/' . $page['category']; ?>">
								<?php echo $page['category_display']; ?>
							</a>
						</td>
						<td><?php echo $page['rev']; ?>
						<td><?php echo $page['created_display']; ?></td>
						<td><?php echo $page['modified_display']; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
</div>

<div class="clear"></div>