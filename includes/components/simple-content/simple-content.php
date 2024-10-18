<?php
	$enable_bg = get_field('enable_bg');
	$container = get_field('add_container');
	$alignment = get_field('alignment');
	$layout = get_field('simple_content_layout');
	$bottom_padding = get_field('add_padding_bottom_simple_content');
	$main_heading = get_field('simple_main_heading');
	$heading1 = get_field('simple_content_heading');
	$subheading1 = get_field('simple_content_subheading');
	$content1 = get_field('simple_content_editor');
	$image1 = get_field('simple_content_image');
	$btn1 = get_field('simple_content_button');
	if($layout == 'col-2'){
		$heading2 = get_field('column2_heading');
		$subheading2 = get_field('column2_subheading');
		$content2 = get_field('column2_content');
		$image2 = get_field('column2_image');
		$btn2 = get_field('column2_button');
	}
?>
<section class="simple-content <?php if($enable_bg){echo 'bg';} ?> <?php if($container){echo 'container';} ?> <?php if($bottom_padding){echo 'bottom-padding';} ?>">
	<div class="section-inner reveal-bottom active">
		<?php if($main_heading){ ?>
			<h2 class="main-heading h3"><?php echo $main_heading; ?></h2>
		<?php } ?>
		<div class="content-container <?php echo $layout; ?> <?php echo $alignment; ?>">
			<div class="content-block">
				<?php if($image1){
					display_image($image1);
				}
				if($subheading1){ ?>
					<span><?php echo $subheading1; ?></span>
				<?php }
				if($heading1){
					if($main_heading){ ?>
						<h3 class="h4"><?php echo $heading1; ?></h3>
					<?php } else { ?>
						<h2 class="h3"><?php echo $heading1; ?></h2>
					<?php }
				}
				echo $content1;
				if($btn1){
					$btn = $btn1;
					require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
				} ?>
			</div>
			<?php if($layout == 'col-2'){ ?>
				<div class="content-block">
					<?php
					if($image2){
						display_image($image2);
					}
					if($subheading2){ ?>
						<span><?php echo $subheading2; ?></span>
					<?php }
					if($heading2){
						if($main_heading){ ?>
							<h3 class="h4"><?php echo $heading2; ?></h3>
						<?php } else { ?>
							<h2 class="h3"><?php echo $heading2; ?></h2>
						<?php }
					}
					echo $content2;
					if($btn2){
						$btn = $btn2;
						require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
					} ?>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
