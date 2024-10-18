<?php
    $heading = get_field('post_heading');
    $desc = get_field('post_description');
    $post_type = get_field('post');
	$enable_featured_post_area = get_field('enable_featured_post_area');
	if($enable_featured_post_area){
		$custom_select_6_posts = get_field('custom_select_6_posts');
	}
    $enable_cat_filter = get_field('enable_category_filter');
    $enable_search = get_field('enable_search');
?>
<section class="post-listing <?php echo $post_type; ?>">
    <div class="section-inner">
		<?php if($post_type == 'post' && $enable_featured_post_area){ ?>
			<div class="featured-area">
				<?php
				if($custom_select_6_posts && count($custom_select_6_posts) == '6'){
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 6,
						'post__in' => $custom_select_6_posts,
						'post_status' => 'publish',
						'orderby' => 'post__in'
						// 'order' => 'ASC',
						// 'orderby' => 'menu_order'
					);
				} else {
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 6,
						'post_status' => 'publish',
					);
				}
				$post = new WP_Query($args);
				$count = 1;
				if( $post->have_posts() ): ?>
					<div class="featured-grid">
						<?php while( $post->have_posts() ) : $post->the_post();
						$date = get_the_date();
						$title = get_the_title();
						if($count == 1){
							$desc1 = wp_strip_all_tags( substr(get_the_content(), 0, 450)).'....';
						} else {
							$desc1 = wp_strip_all_tags( substr(get_the_content(), 0, 220)).'....';
						}
						$thumbnail = get_the_post_thumbnail(); ?>
						<div class="featured-post item<?php echo $count; ?>">
							<?php if(empty($thumbnail)){
								display_image(get_field('dummy_image', 'options'));
							} else {
								echo $thumbnail;
							} ?>
							<div class="featured-caption">
								<span class="date"><?php echo $date; ?></span>
								<span class="h3"><?php echo $title; ?></span>
								<p><?php echo $desc1; ?></p>
								<a href="<?php the_permalink(); ?>" class="simple">
                  <?= pll__('Read More') ?>
                </a>
							</div>
						</div>
						<?php $count++;
						endwhile; ?>
					</div>
					<?php wp_reset_postdata();
				endif; ?>
			</div>
		<?php } ?>
    	<div class="listing-container <?php if($enable_cat_filter){echo 'col-2';} ?>">
    		<?php if($enable_cat_filter){ ?>
    			<div class="filter">
    				<div class="filter-head">
    					<span>
    						<svg width="30" height="20" viewBox="0 0 30 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M0 0V3.33333H30V0H0ZM11.6667 20H18.3333V16.6667H11.6667V20ZM25 11.6667H5V8.33333H25V11.6667Z" fill="#1F335E"/>
							</svg>
    						<?= pll__('Filter') ?>
    					</span>
    					<a href="#" id="clearfilter">
                <?= pll__('Reset') ?>
              </a>
    				</div>
    				<div class="filter-body">
    					<span class="shows">
                <?= pll__('Show me:') ?>
              </span>
    					<?php
    						if($post_type == 'post'){
		    					$categories = get_terms(
		                            array(
		                                'taxonomy' => 'category',
		                                'hide_empty' => false,
		                                'parent' => 0,
		                                'exclude' => array(1,41,20),
		                            )
		                        );
		                    } else if ($post_type == 'resources'){
		                    	$categories = get_terms(
		                            array(
		                                'taxonomy' => 'resources-category',
		                                'hide_empty' => false,
		                                'parent' => 0,
		                            )
		                        );
		                    }
                        ?>
                        <form method="post" action="<?php echo get_home_url(); ?>">
                        	<input type="hidden" class="post-type" value="<?php echo $post_type; ?>">
                            <?php foreach($categories as $cat){ ?>
                                <label>
                                    <input type="checkbox" id="category" name="category" data-value="<?php echo $post_type; ?>" value="<?php echo $cat->term_id; ?>" onchange="categoryfunction(this)">
                                    <span class="custom-checkbox"></span>
                                    <span class="txt"><?php echo $cat->name; ?></span>
                                </label>
                            <?php } ?>
                            <button type="submit" class="btn btn-secondary">
                              <?= pll__('Filter') ?>
                            </button>
                        </form>
    				</div>
    			</div>
    		<?php } ?>
    		<div class="post-content">
		        <?php if($heading){ ?>
		         	<h2 class="h3"><?php echo $heading; ?></h2>
		        <?php }
		        echo $desc;
		        if($enable_search){
		        	if($post_type == 'post'){
		        		$search_label = pll__('Search news');
		        	} else if($post_type == 'resources'){
		        		$search_label = pll__('Search resources');
		        	} ?>
		        	<div class="search-form">
		        		<form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
							<label class="screen-reader-text" for="s">Search for:</label>
							<input type="text" value="" name="s" id="searchtext" placeholder="<?php echo $search_label; ?>">
							<input type="submit" id="searchsubmit" value="Search">
						</form>
		        	</div>
		        <?php } ?>
		        <div class="listing-data"></div>
		        <div class="listing">
			        <?php
					if($post_type == 'post'){
						$offset = '6';
					} else {
						$offset = '0';
					}
			        $property_per_page = 6;
					$paged = get_query_var('paged') ?? get_query_var('page') ?? 1;
					if( isset($custom_select_6_posts) && count($custom_select_6_posts) == '6' ){
						$args = array(
							'post_type' => $post_type,
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'posts_per_page' => $property_per_page ? (int)$property_per_page : 1,
							'paged' => $paged,
							'post__not_in' => $custom_select_6_posts,
						);
					} else {
						$args = array(
							'post_type' => $post_type,
							'posts_per_page' => -1,
							'post_status' => 'publish',
							'posts_per_page' => $property_per_page ? (int)$property_per_page : 1,
							'paged' => $paged,
							'offset' => $offset // Exclude the first 6 posts
						);
					}
				    $post = new WP_Query($args);
				    if( $post->have_posts() ): ?>
			    		<?php while( $post->have_posts() ) : $post->the_post();
			    			$date = get_the_date();
			    			$title = get_the_title();
			    			$desc1 = get_field('short_description',get_the_ID());
							$thumbnail = get_the_post_thumbnail();
			    			if($post_type == 'post'){
			    				$desc1 = wp_strip_all_tags( substr(get_the_content(), 0, 445)).'....';
			    			}
			    			$pdf_file = get_field('pdf_file',get_the_ID());
			    			if ($post_type == 'post'){
			    				$link = get_permalink();
			    				$target = '';
			    			} else if ($post_type == 'resources'){
			    				$link = $pdf_file['url'];
			    				$target = '_blanlk';
			    			} ?>
			    			<div class="post-block">
								<div class="thumbnail">
									<?php if(empty($thumbnail)){
										display_image(get_field('dummy_image', 'options'));
									} else {
										echo $thumbnail;
									} ?>
								</div>
								<div class="inner">
									<span class="date"><?php echo $date; ?></span>
									<a href="<?php echo $link; ?>" class="title" <?php if($target){echo 'target="_blank"';} ?>><?php echo $title; ?></a>
									<?php if($desc1){ ?>
										<p><?php echo $desc1; ?></p>
									<?php }
									if($pdf_file){ ?>
										<a href="<?php echo $pdf_file['url']; ?>" class="btn btn-secondary" target="_blank">
											<?= pll__('Download PDF') ?>
										</a>
									<?php
									} else{ ?>
										<a href="<?php the_permalink(); ?>" class="link">
                      <?= pll__('Read More') ?>
                    </a>
									<?php } ?>
								</div>
				    		</div>
			    		<?php endwhile; ?>
			    		<div class="post-pagination">
						    <?php ic_custom_posts_pagination($post, $paged); ?>
						</div>
				    <?php endif;
				    wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
    </div>
</section>
<div class="spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
