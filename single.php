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
				<div class="featured-image">
					<?php if(empty($thumbnail)){
						// display_image(get_field('dummy_image', 'options'));
					} else {
						echo $thumbnail;
					} ?>
				</div>
	    		<div class="grid-container col-1 mt-3 mobile-gap reveal-bottom active">
				    <div class="content full">
		                <?php the_content(); ?>
		            </div>
		        </div>
		    </div>
		</section>
		<?php
			$heading = get_field('heading');
			$btn = get_field('button');
			$enable_bg = get_field('enable_bg');
		?>
		<section class="news <?php if($enable_bg){echo 'bg';} ?> reveal-bottom active">
			<div class="section-inner reveal-bottom active">
				<?php if($heading){ ?>
					<h2 class="h3">Recent News</h2>
				<?php }
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 4,
					'post_status' => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
				);
				$news = new WP_Query($args);
				$count = 1;
				if( $news->have_posts() ): ?>
					<div class="recent-news-container">
						<?php while( $news->have_posts() ) : $news->the_post();
							$title = get_the_title();
							$desc = get_the_content();
							$thumbnail = get_the_post_thumbnail(); ?>
							<?php if($count == 1){ ?>
								<div class="col">
									<div class="news-block">
										<?php if($thumbnail){
											echo $thumbnail;
										} else {
											display_image(get_field('dummy_image','options'));
										} ?>
										<span class="h3"><?php echo $title; ?></span>
										<?php if($desc){ ?>
											<p><?php echo wp_strip_all_tags( substr($desc, 0, 400)); ?>....</p>
										<?php } ?>
										<a href="<?php the_permalink(); ?>" class="simple">Read More</a>
									</div>
								</div>
								<div class="col grid">
							<?php } else { ?>
								<div class="news-block grid">
									<div class="inner">
										<span class="h3"><?php echo $title; ?></span>
										<?php if($desc){ ?>
											<p><?php echo wp_strip_all_tags( substr($desc, 0, 160)); ?>....</p>
										<?php } ?>
										<a href="<?php the_permalink(); ?>" class="simple">Read More</a>
									</div>
									<?php if($thumbnail){
										echo $thumbnail;
									} else {
										display_image(get_field('dummy_image','options'));
									} ?>
								</div>
							<?php }
							if($count == 4){ ?>
								</div>
							<?php }
						$count++;
						endwhile; ?>
					</div>
				<?php endif;
				wp_reset_postdata();
				$btn['title'] = pll__('All News');
				$btn['url'] = '/news-and-events/'; ?>
				<div class="button">
					<?php require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php'; ?>
				</div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
