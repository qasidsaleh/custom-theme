<?php
	$heading = get_field('team_heading');
	$desc = get_field('team_description');
	$cat = get_field('category'); //member category id
	$cat_slug = $cat->slug;
?>
<section class="team-members">
	<div class="section-inner">
		<div class="intro">
			<?php if($heading){ ?>
				<h2 class="h3"><?php echo $heading; ?></h2>
			<?php } 
			echo $desc; ?>
		</div>
		<?php
			$args = array(
		        'post_type' => 'team-members',
		        'posts_per_page' => -1,
	            'post_status' => 'publish',
	            'orderby' => 'date',
	            'order' => 'ASC',
	            'tax_query' => array(
		            array(
		                'taxonomy' => 'members-category',
		                'field' => 'term_id',
		                'terms' => $cat->term_id,
		            )
		        )
		    );
		    $members = new WP_Query($args);
		    if( $members->have_posts() ): ?>
		    	<div class="members-container reveal-bottom active">
		    		<?php while( $members->have_posts() ) : $members->the_post();
		    			$thumbnail = get_field('featured_image',get_the_ID());
		    			$title = get_the_title();
		    			$designation = get_field('designation',get_the_ID());
		    			$hotels_heading = get_field('hotels_heading',get_the_ID());
		    			$hotels = get_field('hotels',get_the_ID()); ?>
		    			<a href="javascript:void(0)" class="member-block <?php if($cat_slug == 'team-member' || $cat_slug == 'team-member-fr'){echo 'modal';} ?>" data-id="<?php echo get_the_ID(); ?>" title="Read More">
		    				<?php display_image($thumbnail); ?>
		    				<div class="member-caption">
			    				<strong><?php echo $title; ?></strong>
			    				<span><?php echo $designation; ?></span>
			    				<?php if($cat_slug != 'team-member'){ ?>
				    				<div class="hotels">
				    					<strong><?php echo $hotels_heading; ?></strong>
				    					<span><?php echo $hotels; ?></span>
				    				</div>
				    			<?php } ?>
			    			</div>
			    		</a>
		    		<?php endwhile; ?>
		    	</div>
		    <?php endif;
		    wp_reset_postdata(); 
		?>
	</div>
</section>
<?php if($cat_slug == 'team-member' || $cat_slug == 'team-member-fr'){ ?>
	<section class="member-bio custom-modal">
		<a href="#" id="biocross">
			<svg xmlns="http://www.w3.org/2000/svg" width="51" height="51" viewBox="0 0 51 51" fill="none">
				<path d="M1.04567 1.96971C1.71541 1.30017 2.62365 0.924044 3.57067 0.924044C4.51768 0.924044 5.42592 1.30017 6.09566 1.96971L24.9992 20.8733L43.9028 1.96971C44.2323 1.6286 44.6264 1.35652 45.0621 1.16935C45.4978 0.982173 45.9664 0.88365 46.4407 0.879529C46.9149 0.875409 47.3852 0.965771 47.8241 1.14535C48.263 1.32492 48.6617 1.59011 48.9971 1.92544C49.3324 2.26077 49.5976 2.65953 49.7772 3.09844C49.9567 3.53736 50.0471 4.00765 50.043 4.48186C50.0389 4.95607 49.9403 5.42471 49.7532 5.86044C49.566 6.29617 49.2939 6.69026 48.9528 7.01971L30.0492 25.9233L48.9528 44.8268C49.6034 45.5004 49.9634 46.4026 49.9552 47.339C49.9471 48.2754 49.5715 49.1712 48.9093 49.8333C48.2471 50.4955 47.3514 50.8711 46.415 50.8793C45.4785 50.8874 44.5764 50.5274 43.9028 49.8769L24.9992 30.9733L6.09566 49.8769C5.42209 50.5274 4.51994 50.8874 3.58352 50.8793C2.6471 50.8711 1.75134 50.4955 1.08917 49.8333C0.426999 49.1712 0.0513949 48.2754 0.0432576 47.339C0.0351204 46.4026 0.395102 45.5004 1.04567 44.8268L19.9492 25.9233L1.04567 7.01971C0.376127 6.34997 0 5.44172 0 4.49471C0 3.54769 0.376127 2.63945 1.04567 1.96971Z" fill="#AE0000"/>
			</svg>
		</a>
		<div id="memberdata"></div>
	</section>
<?php } ?>