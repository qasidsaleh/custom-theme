<?php
// Load AJax post data
add_action('wp_ajax_get_ajax_post', 'get_ajax_post');
add_action('wp_ajax_nopriv_get_ajax_post', 'get_ajax_post');

function get_ajax_post() {
    $categories = $_REQUEST['cat-val'];
    $post_type = $_REQUEST['post-type'];
    $paged = $_REQUEST['page'];
    $property_per_page = 6;
    $search_val = $_REQUEST['search-val'];
    $tax_query = array( 'relation' => 'AND' );
    if(!empty($categories)){
        $x = 0;
        while($x < count($categories)){
            if ($post_type == 'post'){
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $categories[$x],
                );
            } else if ($post_type == 'resources'){
                $tax_query[] = array(
                    'taxonomy' => 'resources-category',
                    'field'    => 'term_id',
                    'terms'    => $categories[$x],
                );
            }
            $x++;
        }
    }
    $args = array(
        'post_type' => $post_type,
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'tax_query' => $tax_query,
        'posts_per_page' => $property_per_page ? (int)$property_per_page : 6,
        'paged' => $paged,
        's' => $search_val,
    );
    $ajaxpost = new WP_Query( $args );
    $response = '';
    if ( $ajaxpost->have_posts() ) {
        while ( $ajaxpost->have_posts() ) {
            $ajaxpost->the_post();
            $date = get_the_date();
            $title = get_the_title();
            $desc = get_field('short_description',get_the_ID());
            $thumbnail = get_the_post_thumbnail();
            if($post_type == 'post'){
                $desc = wp_strip_all_tags( substr(get_the_content(), 0, 445)).'....';
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
                    <?php if($desc){ ?>
                        <p><?php echo $desc; ?></p>
                    <?php }
                    if($pdf_file){ ?>
                        <a href="<?php echo $pdf_file['url']; ?>" class="btn btn-secondary" target="_blank">
                            <?= pll__('Download PDF') ?>
                        </a>
                    <?php } else{ ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn-secondary">
                          <?= pll__('Read More') ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="post-pagination">
            <?php ic_custom_posts_pagination($ajaxpost, $paged); ?>
        </div>
    <?php }
    else {
        echo '<span class="no-found">no result found!</span>';
    } ?>
    <!-- Pagination script for ajax posts -->
    <script type="text/javascript">
        jQuery( ".page-numbers" ).click( function () {
            var post = jQuery(".post-type").val();
            var cat_val = [];
            jQuery.each(jQuery("input[name='category']:checked"), function(){
                cat_val.push(jQuery(this).val());
            });
            var curent_page = jQuery(".page-numbers.current").text();
            var page = jQuery(this).text();
            if(jQuery(this).hasClass("next")){
                page = parseInt(curent_page) + parseInt(1);
            }
            if(jQuery(this).hasClass("prev")){
                page = parseInt(curent_page) - parseInt(1);
            }
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                    'cat-val' : cat_val,
                    'post-type' : post,
                    page : page,
                    action : 'get_ajax_post',
                },
                beforeSend: function (xhr) {
                    jQuery("body").addClass("overlay");
                    jQuery(".spinner").addClass("show");
                },
                success: function( response ) {
                    jQuery("body").removeClass("overlay");
                    jQuery(".spinner").removeClass("show");
                    jQuery('.listing').remove();
                    jQuery('.listing-data').html( response );
                }
            });
            jQuery('.page-numbers').removeClass('current');
            jQuery(this).addClass('current');
            return false;
        });
    </script>
    <?php echo $response;
    //die();
    exit;
}

//Custom Pagination
if (!function_exists('ic_custom_posts_pagination')) :
    function ic_custom_posts_pagination($the_query=NULL, $paged=1){

        global $wp_query;
        $the_query = !empty($the_query) ? $the_query : $wp_query;

        if ($the_query->max_num_pages > 1) {
            $big = 999999999; // need an unlikely integer
            $items = paginate_links(apply_filters('adimans_posts_pagination_paginate_links', array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'prev_next' => TRUE,
                'current' => max(1, $paged),
                'total' => $the_query->max_num_pages,
                'type' => 'array',
                'prev_text' => ' <i class="fas fa-angle-double-left"></i> ',
                'next_text' => ' <i class="fas fa-angle-double-right"></i> ',
                'end_size' => 1,
                'mid_size' => 1
            )));

            $pagination = "<div class=\"ic-pagination\"><ul><li>";
            $pagination .= join("</li><li>", (array)$items);
            $pagination .= "</li></ul></div>";

            echo apply_filters('ic_posts_pagination', $pagination, $items, $the_query);
        }
    }
endif; ?>
