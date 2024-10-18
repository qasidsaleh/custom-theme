<?php
	$heading = get_field('testimonials_heading');
	$desc = get_field('description');
?>
<section class="sitemap">
	<div class="sitemap-container section-inner">
		<!-- Get All Pages -->
        <h2>Pages</h2>
        <ul>
            <?php
                $args = array(
                    'post_type' => array('page'),
                    'post_status' => 'publish',
                    'post__not_in' => array(427),
                    'posts_per_page' => -1,
                    'orderby' => 'permalink',
                    'order'   => 'ASC',
                );
                $loop = new WP_Query( $args );
                $pages_1 = [];
                while ( $loop->have_posts() ) :
                    $loop->the_post();
                    array_push($pages_1, get_the_permalink());
                endwhile;
                sort($pages_1);
                for($x = 0; $x < count($pages_1); $x++){ ?>
                    <li><a href="<?php echo $pages_1[$x]; ?>"><?php echo $pages_1[$x]; ?></a></li>
                <?php }
                wp_reset_postdata();
            ?>
        </ul>
        <h3>News/Events</h3>
        <ul>
            <?php
                $args = array(
                    'post_type' => array('post'),
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'orderby' => 'permalink',
                    'order'   => 'ASC',
                );
                $loop = new WP_Query( $args );
                $news = [];
                while ( $loop->have_posts() ) :
                    $loop->the_post();
                    array_push($news, get_the_permalink());
                endwhile;
                sort($news);
                for($x = 0; $x < count($news); $x++){ ?>
                    <li><a href="<?php echo $news[$x]; ?>"><?php echo $news[$x]; ?></a></li>
                <?php }
                wp_reset_postdata();
            ?>
        </ul>
	</div>
</section>