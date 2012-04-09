<?php if (array_key_exists('message', $_SESSION) && array_key_exists('message_class', $_SESSION)): ?>
	<div class="<?php echo $_SESSION['message_class']; ?>">
		<?php echo $_SESSION['message']; ?>
	</div>
	<?php unset($_SESSION['message_class']); ?>
	<?php unset($_SESSION['message']); ?>
<?php endif; ?>
	