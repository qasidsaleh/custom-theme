<?php get_header(); ?>

	<main id="main-content">
		<section class="hero-container plain">
			<div class="plain">
				<div class="hero-caption">
					<div class="inner">
						<h1><?php echo the_title(); ?></h1>
					</div>
				</div>
			</div>
		</section>
		<section class="grid-content mt-0">
			<div class="section-inner">
				<div class="grid-container col-1 mt-3 mobile-gap reveal-bottom active">
					<div class="content full">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
				<div class="section-inner" style="text-align:center;">
				<?php $pdf_file = get_field('pdf_file',get_the_ID()); ?>
				<a href="<?php echo $pdf_file['url']; ?>" class="btn btn-primary" target="_blank">Download PDF</a>
			</div>
		</section>

		<?php if (false) {?>
		<section class="news bg reveal-bottom active">
			<div class="section-inner">
				 <h2 class="h3">Recent Resources</h2>
				<?php
				$args = array(
					'post_type' => 'resources',
					'posts_per_page' => 3,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
				);
				$posts = new WP_Query($args);
				if( $posts->have_posts() ): ?>
					<div class="recent-news-container">
						<?php while( $posts->have_posts() ) : $posts->the_post();
							$title = get_the_title();
							$desc = get_field('short_description',get_the_ID()); ?>
							<div class="news-block">
								<span class="h3"><?php echo $title; ?></span>
								<?php if($desc){ ?>
									<p><?php echo $desc; ?></p>
								<?php } ?>
								<a href="<?php the_permalink(); ?>" class="simple">Read More</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif;
				wp_reset_postdata();
				$btn['title'] = pll__('All Resources');
				$btn['url'] = get_page_link('236'); ?>
				<div class="button">
					<?php require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-secondary.php'; ?>
				</div>
			</div>
		</section>
		<?php } ?>
	</main>

<?php get_footer(); ?>
