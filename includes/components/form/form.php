<?php
	$heading = get_field('heading');
	$form = get_field('form');
?>

<section class="form form-block">
	<div class="section-inner">
		<h2><?= $heading ?></h2>
		<?= $form ?>
	</div>
</section>
