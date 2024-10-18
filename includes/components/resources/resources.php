<?php
    $bottom_space = get_field('add_bottom_spacing');
    $heading = get_field('heading');
    $desc = get_field('description');
    $btn = get_field('button');
    $category = get_field('category');
?>
<section class="resources bg <?php if($bottom_space){echo 'bottom-space';} ?>">
    <div class="section-inner">
        <div class="intro reveal-bottom active">
            <?php if($heading){ ?>
                <h2><?php echo $heading; ?></h2>
            <?php } 
            if($desc){ ?>
                <p><?php echo $desc; ?></p>
            <?php } ?>
        </div>
        <?php 
        if($category){
            $tax_query = array( 'relation' => 'OR' );
            $x = 0;
            foreach($category as $cat){
                $tax_query[] = array(
                    'taxonomy' => 'resources-category',
                    'field'    => 'term_id',
                    'terms'    => $cat->term_id,
                );
                $x++;
            }
            $args = array(
                'post_type' => 'resources',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'tax_query' => $tax_query,
            );
            $resources = new WP_Query($args);
            $post_count = $resources->found_posts;
            if( $resources->have_posts() ): ?>
                <div class="resource-slider reveal-bottom active">
                    <div class="swiper resource-swiper">
                        <div class="swiper-wrapper">
                            <?php while( $resources->have_posts() ) : $resources->the_post();
                                $heading = get_the_title();
                                $desc = get_the_content();
                                $file = get_field('pdf_file',get_the_ID());
                                $thumbnail = get_the_post_thumbnail(); ?>
                                <div class="swiper-slide <?php if($post_count == 1){echo 'mobile-full-width';}?> <?php if($thumbnail){echo 'col-2';} ?>">
                                    <div class="slide-content">
                                        <span class="h3"><?php echo $heading; ?></span>
                                        <p><?php echo $desc; ?></p>
                                        <a href="<?php echo $file['url']; ?>" download="" class="btn btn-secondary">Download</a>
                                    </div>
                                    <?php if($thumbnail){ ?>
                                        <div class="slide-image">
                                            <?php echo $thumbnail; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php if($post_count > 1){ ?>
                            <!-- <div class="swiper-pagination"></div> -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        <?php } ?>
                    </div>
                    <?php if($post_count > 1){ ?>
                        <div class="custom-nav">
                            <a href="#" class="prev" title="previous">
                               <img src="<?php bloginfo('template_url'); ?>/img/arrow-left.svg" alt="">
                            </a>
                            <a href="#" class="next" title="next">
                                <img src="<?php bloginfo('template_url'); ?>/img/arrow-right.svg" alt="">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php endif;
            wp_reset_postdata();
        }
        if($btn){ ?>
            <div class="button">
                <?php $btn['class'] = 'white'; 
                require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php'; ?>
            </div>
        <?php } ?>
    </div>
</section>