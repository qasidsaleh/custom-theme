<!-- To add this to your own template, set the $title and $url, and add the following code: -->
<!-- '/wp-content/themes/operatic/includes/buttons/btn-secondary.php'; -->

<a href="<?php echo $btn['url']; ?>"
	class="btn btn-secondary white"
	<?php if(!empty($btn['target'])){echo 'target="_blank"';} ?>>
	<?php echo $btn['title']; ?>
</a>
