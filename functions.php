<?php
/*
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */
/*------------------------------------*\
	Theme Support
\*------------------------------------*/


if (function_exists('add_theme_support'))
{
	// Add Menu Support
	add_theme_support('menus');

	// Add Thumbnail Theme Support
	add_theme_support('post-thumbnails');
	add_image_size('large', 700, '', true); // Large Thumbnail
	add_image_size('medium', 250, '', true); // Medium Thumbnail
	add_image_size('small', 120, '', true); // Small Thumbnail
	add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
	add_image_size('product-thumb', 325, 325, true); // Product Thumbnails
	add_image_size('footer-feature', 962, 0, true); // Footer Features

	// Enables post and comment RSS feed links to head
	add_theme_support('automatic-feed-links');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

function get_the_post_thumbnail_alt($post_id) {
    return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
}

// Operatic image handler
function display_image($image, $options = []) {
	if ($image) {
		// using WP image src set
		$size = isset( $options['size'] ) ? $options['size'] : 'full';
		$attr = [];
		if ( isset( $options['class'] ) ) $attr['class'] = $options['class'];
		if ( isset($options['decorative']) || empty($image['alt']) ) {
			$attr['alt'] = '';
			$attr['role'] = 'presentation';
		} else {
			$attr['alt'] = esc_attr($image['alt']);
		}
		$attr['loading'] = 'lazy';
		echo wp_get_attachment_image( $image['id'], $size, false, $attr );
	}
}

// Operatic theme navigation
function operatic_theme_nav($location = 'main-menu')
{
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'menu_id' => $location
			)
		);
	}
}

/**************************************************
            Add Class in Menu
**************************************************/
function my_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
  	if ( $depth == 0 && 'footer-menu' == $args->theme_location ) {
    	$item_output = preg_replace('/<a /', '<a class="footer-link" ', $item_output, 1);
  	}
  	if ( $depth == 0 && 'main-menu' == $args->theme_location ) {
    	$item_output = preg_replace('/<a /', '<a class="nav-link" ', $item_output, 1);
  	}
  	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'my_walker_nav_menu_start_el', 10, 4);

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
	if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), '3.5.1'); // jQuery
		wp_enqueue_script('jquery');

		wp_register_script('html5blankscripts2', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '1.0.0'); // Custom scripts
		wp_enqueue_script('html5blankscripts2');

		wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
		wp_enqueue_script('html5blankscripts');

	}
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
	if (is_page('pagenamehere')) {
		wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
		wp_enqueue_script('scriptname'); // Enqueue it!
	}
}


function mind_defer_scripts( $tag, $handle, $src ) {
	$defer = array(
		'jquery',
		'html5blankscripts',
		'html5blankscripts2'
	);
	if ( in_array( $handle, $defer ) ) {
		return '<script src="' . $src . '" defer="defer"></script>' . "\n";
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'mind_defer_scripts', 10, 3 );

// Load HTML5 Blank styles
function html5blank_styles()
{
	wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
	wp_enqueue_style('html5blank');
	// wp_register_style('esa4yrg', 'https://use.typekit.net/esa4yrg.css');
	// wp_enqueue_style('esa4yrg');
	wp_register_style('esa4ygr', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
	wp_enqueue_style('esa4ygr');
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
	register_nav_menus(array(
		'header-menu' => __('Header Menu', 'Header Menu'),
		'footer-menu' => __('Footer Menu', 'Footer Menu'),
	));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
	$args['container'] = false;
	return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
	return is_array($var) ? array() : '';
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
	global $post;
	if (is_home()) {
		$key = array_search('blog', $classes);
		if ($key > -1) {
			unset($classes[$key]);
		}
	} elseif (is_page()) {
		$classes[] = sanitize_html_class($post->post_name);
	} elseif (is_singular()) {
		$classes[] = sanitize_html_class($post->post_name);
	}

	return $classes;
}


// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
	global $wp_widget_factory;
	remove_action('wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style'
	));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
	global $wp_query;
	$big = 999999999;
	echo paginate_links(array(
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
	return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
	return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
	global $post;
	if (function_exists($length_callback)) {
		add_filter('excerpt_length', $length_callback);
	}
	if (function_exists($more_callback)) {
		add_filter('excerpt_more', $more_callback);
	}
	$output = get_the_excerpt();
	$output = apply_filters('wptexturize', $output);
	$output = apply_filters('convert_chars', $output);
	$output = '<p>' . $output . '</p>';
	echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
	global $post;
	return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

function simple_view_article($more)
{
	global $post;
	return '...';
}

// Remove Admin bar
function remove_admin_bar()
{
	return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
	return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
	$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
	return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
	$myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
	$avatar_defaults[$myavatar] = "Custom Gravatar";
	return $avatar_defaults;
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
//add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'simple_view_article'); // ...
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images


// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

// Disable archive pages
add_action('template_redirect', 'operatic_disable_archives');
function operatic_disable_archives(){
	if( is_category() || is_tag() || is_date() || is_author() ) {
		global $wp_query;
		$wp_query->set_404();
	}
}

/*------------------------------------*\
	Custom Options
\*------------------------------------*/

// if( function_exists('acf_add_options_page') ) {

// 	acf_add_options_page(array(
// 		'page_title' 	=> 'Theme Options',
// 		'menu_title'	=> 'Theme Options',
// 		'menu_slug' 	=> 'operatic-theme-options',
// 		'capability'	=> 'edit_posts',
// 		'redirect'		=> false
// 	));

// }

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
	return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
	return '<h2>' . $content . '</h2>';
}

function year_shortcode() {
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'year_shortcode');

/* Remove emoji scripts */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* Recaptcha limiting */
add_action('wp_enqueue_scripts', 'conditionally_load_plugin_js_css');
//* Remove recaptcha except for pages that needed
function conditionally_load_plugin_js_css()
{
	if (!is_page(array(240))) { # Only load CSS and JS on needed Pages
		wp_dequeue_script('contact-form-7'); # Restrict scripts.
		wp_dequeue_script('wpcf7-recaptcha');
		wp_dequeue_script('google-recaptcha');
		wp_dequeue_style('contact-form-7'); # Restrict css.
	}
}


// /**************************************************
//           removing default submit tag
// **************************************************/
// remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
// /**************************************************
// adding action with function which handles our button markup
// **************************************************/
// add_action('wpcf7_init', 'twentysixteen_child_cf7_button');
// /**************************************************
//         adding out submit button tag
// **************************************************/
// if (!function_exists('twentysixteen_child_cf7_button')) {
//   function twentysixteen_child_cf7_button() {
//     wpcf7_add_form_tag('submit', 'twentysixteen_child_cf7_button_handler');
//   }
// }
// /**************************************************
//       out button markup inside handler
// **************************************************/
// if (!function_exists('twentysixteen_child_cf7_button_handler')) {
//   function twentysixteen_child_cf7_button_handler($tag) {
//     $tag = new WPCF7_FormTag($tag);
//     $class = wpcf7_form_controls_class($tag->type);
//     $atts = array();
//     $atts['class'] = $tag->get_class_option($class);
//     $atts['class'] .= ' twentysixteen-child-custom-btn';
//     $atts['id'] = $tag->get_id_option();
//     $atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
//     $value = isset($tag->values[0]) ? $tag->values[0] : '';
//     $atts['type'] = 'Submit';
//     $atts = wpcf7_format_atts($atts);
//     $html = sprintf('<button class="wpcf7-form-control has-spinner wpcf7-submit btn btn-primary"><span>Submit</span></button>', $atts, $value);
//     return $html;
//   }
// }

// Remove <p> and <br/> from Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');



/*************************************
	Change width of editor sidebar
*************************************/
function toast_enqueue_jquery_ui(){
	wp_enqueue_script( 'jquery-ui-resizable');
}
add_action('admin_enqueue_scripts', 'toast_enqueue_jquery_ui');

function toast_resizable_sidebar(){ ?>
	<style>
		.interface-interface-skeleton__sidebar .interface-complementary-area{width:100%;}
		.edit-post-layout:not(.is-sidebar-opened) .interface-interface-skeleton__sidebar{display:none;}
		.is-sidebar-opened .interface-interface-skeleton__sidebar{width:350px;}

		/*UI Styles*/
		.ui-dialog .ui-resizable-n {
			height: 2px;
			top: 0;
		}
		.ui-dialog .ui-resizable-e {
			width: 2px;
			right: 0;
		}
		.ui-dialog .ui-resizable-s {
			height: 2px;
			bottom: 0;
		}
		.ui-dialog .ui-resizable-w {
			width: 2px;
			left: 0;
		}
		.ui-dialog .ui-resizable-se,
		.ui-dialog .ui-resizable-sw,
		.ui-dialog .ui-resizable-ne,
		.ui-dialog .ui-resizable-nw {
			width: 7px;
			height: 7px;
		}
		.ui-dialog .ui-resizable-se {
			right: 0;
			bottom: 0;
		}
		.ui-dialog .ui-resizable-sw {
			left: 0;
			bottom: 0;
		}
		.ui-dialog .ui-resizable-ne {
			right: 0;
			top: 0;
		}
		.ui-dialog .ui-resizable-nw {
			left: 0;
			top: 0;
		}
		.ui-draggable .ui-dialog-titlebar {
			cursor: move;
		}
		.ui-draggable-handle {
			-ms-touch-action: none;
			touch-action: none;
		}
		.ui-resizable {
			position: relative;
		}
		.ui-resizable-handle {
			position: absolute;
			font-size: 0.1px;
			display: block;
			-ms-touch-action: none;
			touch-action: none;
		}
		.ui-resizable-disabled .ui-resizable-handle,
		.ui-resizable-autohide .ui-resizable-handle {
			display: none;
		}
		.ui-resizable-n {
			cursor: n-resize;
			height: 7px;
			width: 100%;
			top: -5px;
			left: 0;
		}
		.ui-resizable-s {
			cursor: s-resize;
			height: 7px;
			width: 100%;
			bottom: -5px;
			left: 0;
		}
		.ui-resizable-e {
			cursor: e-resize;
			width: 7px;
			right: -5px;
			top: 0;
			height: 100%;
		}
		.ui-resizable-w {
			cursor: w-resize;
			width: 7px;
			left: -5px;
			top: 0;
			height: 100%;
		}
		.ui-resizable-se {
			cursor: se-resize;
			width: 12px;
			height: 12px;
			right: 1px;
			bottom: 1px;
		}
		.ui-resizable-sw {
			cursor: sw-resize;
			width: 9px;
			height: 9px;
			left: -5px;
			bottom: -5px;
		}
		.ui-resizable-nw {
			cursor: nw-resize;
			width: 9px;
			height: 9px;
			left: -5px;
			top: -5px;
		}
		.ui-resizable-ne {
			cursor: ne-resize;
			width: 9px;
			height: 9px;
			right: -5px;
			top: -5px;
		}
	</style>

	<script>
		jQuery(window).ready(function(){
    		setTimeout(function(){
        		jQuery('.interface-interface-skeleton__sidebar').width(localStorage.getItem('toast_sidebar_width'))
        		jQuery('.interface-interface-skeleton__sidebar').resizable({
            		handles: 'w',
            		resize: function(event, ui) {
                		jQuery(this).css({'left': 0});
                		localStorage.setItem('toast_sidebar_width', jQuery(this).width());
           				}
        		});
    		}, 500)
		});
	</script>
<?php }
add_action('admin_head', 'toast_resizable_sidebar');


/*------------------------------------*\
	Remove Hash link from navigation
\*------------------------------------*/
function wws_rg_remove_hash_links( $menu ) {
	return str_replace( '<a href="#">', '<a href="javascript:void(0)">', $menu );
}
add_filter( 'wp_nav_menu_items', 'wws_rg_remove_hash_links' );



/*------------------------------------*\
	CUSTOM BLOCK REGISTRATION
\*------------------------------------*/

add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {
    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

		// register a hero block.
		acf_register_block_type(
			array(
				'name' => 'hero',
				'title' => __('Hero'),
				'description' => __('A custom hero block.'),
				'render_template' => 'includes/components/hero/hero.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'hero' ),
			),
		);
		// register a grid content block.
		acf_register_block_type(
			array(
				'name' => 'grid-content',
				'title' => __('Grid Content'),
				'description' => __('A custom grid content block.'),
				'render_template' => 'includes/components/grid-content/grid-content.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'grid-content' ),
			),
		);
		// register a statistics block.
		acf_register_block_type(
			array(
				'name' => 'statistics',
				'title' => __('Statistics'),
				'description' => __('A custom statistics block.'),
				'render_template' => 'includes/components/statistics/statistics.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'statistics' ),
			),
		);
		// register a partners block.
		acf_register_block_type(
			array(
				'name' => 'partners',
				'title' => __('Partners'),
				'description' => __('A custom partners block.'),
				'render_template' => 'includes/components/partners/partners.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'partners' ),
			),
		);
		// register a grid blocks block.
		acf_register_block_type(
			array(
				'name' => 'grid-blocks',
				'title' => __('Grid Blocks'),
				'description' => __('A custom grid blocks block.'),
				'render_template' => 'includes/components/grid-blocks/grid-blocks.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'grid-blocks' ),
			),
		);
		// register a grid blocks block.
		acf_register_block_type(
			array(
				'name' => 'news',
				'title' => __('News'),
				'description' => __('A custom news block.'),
				'render_template' => 'includes/components/news/news.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'news' ),
			),
		);
		// register a icon grid block.
		acf_register_block_type(
			array(
				'name' => 'icons-grid',
				'title' => __('Icons Grid'),
				'description' => __('A custom icons grid block.'),
				'render_template' => 'includes/components/icons-grid/icons-grid.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'icons-grid' ),
			),
		);
		// register a resources block.
		acf_register_block_type(
			array(
				'name' => 'resources',
				'title' => __('Resources'),
				'description' => __('A custom resources block.'),
				'render_template' => 'includes/components/resources/resources.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'resources' ),
			),
		);
		// register a Embeded Iframe block.
		acf_register_block_type(
			array(
				'name' => 'embeded-iframe',
				'title' => __('Embeded Iframe'),
				'description' => __('A custom embeded iframe block.'),
				'render_template' => 'includes/components/embeded-iframe/embeded-iframe.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'embeded-iframe' ),
			),
		);
		// register a Contact block.
		acf_register_block_type(
			array(
				'name' => 'contact',
				'title' => __('Contact'),
				'description' => __('A custom contact block.'),
				'render_template' => 'includes/components/contact/contact.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'contact' ),
			),
		);
		// register a Google Map block.
		acf_register_block_type(
			array(
				'name' => 'google-map',
				'title' => __('Google Map'),
				'description' => __('A custom google map block.'),
				'render_template' => 'includes/components/google-map/google-map.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'google-map' ),
			),
		);
		// register a Team Members block.
		acf_register_block_type(
			array(
				'name' => 'team-members',
				'title' => __('Team Members'),
				'description' => __('A custom team-members block.'),
				'render_template' => 'includes/components/team-members/team-members.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'team-members' ),
			),
		);
		// register a NewPost Listing block.
		acf_register_block_type(
			array(
				'name' => 'post-listing',
				'title' => __('Post Listing'),
				'description' => __('A custom post listing block.'),
				'render_template' => 'includes/components/post-listing/post-listing.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'post-listing' ),
			),
		);
		// register a Simple Content block.
		acf_register_block_type(
			array(
				'name' => 'simple-content',
				'title' => __('Simple Content'),
				'description' => __('A custom simple content block.'),
				'render_template' => 'includes/components/simple-content/simple-content.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'simple-content' ),
			),
		);
		// register a Sitemap block.
		acf_register_block_type(
			array(
				'name' => 'sitemap',
				'title' => __('Sitemap'),
				'description' => __('A custom sitemap block.'),
				'render_template' => 'includes/components/sitemap/sitemap.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'sitemap' ),
			),
		);
		// register a Logos block.
		acf_register_block_type(
			array(
				'name' => 'logos',
				'title' => __('Logos'),
				'description' => __('A custom logos block.'),
				'render_template' => 'includes/components/logos/logos.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'logos' ),
			),
		);
		// register a Gallery Slider block.
		acf_register_block_type(
			array(
				'name' => 'gallery-slider',
				'title' => __('gallery-slider'),
				'description' => __('A custom gallery slider block.'),
				'render_template' => 'includes/components/gallery-slider/gallery-slider.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'gallery-slider' ),
			),
		);
		// register a Form block.
		acf_register_block_type(
			array(
				'name' => 'form-block',
				'title' => __('Form'),
				'description' => __('A form block.'),
				'render_template' => 'includes/components/form/form.php',
				'category' => 'formatting',
				'icon' => 'admin-comments',
				'keywords' => array( 'gallery-slider' ),
			),
		);
	}
}

add_editor_style( 'style.css' );
add_theme_support( 'editor-styles' );

/*********************************
		News CPT
**********************************/
// function NEWS() {
//   register_post_type( 'news',
//     array(
//         'labels' => array(
//             'name' => __( 'News'),
//             'singular_name' => __( 'News')
//         ),
//         'public' => true,
//             'menu_icon' => 'dashicons-admin-post',
//             //'has_archive' => ture,
//             'rewrite' => array('slug' => 'news'),
//         )
//     );
// }
// add_action( 'init', 'NEWS' );
// function NEWS_a() {
//   $labels = array(
//     'name'                => _x( 'News', 'Post Type General Name', 'HAC' ),
//     'singular_name'       => _x( 'News', 'Post Type Singular Name', 'HAC' ),
//     'menu_name'           => __( 'News', 'HAC' ),
//     'parent_item_colon'   => __( 'News', 'HAC' ),
//     'all_items'           => __( 'All News', 'HAC' ),
//     'view_item'           => __( 'View News', 'HAC' ),
//     'add_new_item'        => __( 'Add New News', 'HAC' ),
//     'add_new'             => __( 'Add New', 'HAC' ),
//     'edit_item'           => __( 'Edit News', 'HAC' ),
//     'update_item'         => __( 'Update News', 'HAC' ),
//     'search_items'        => __( 'Search News', 'HAC' ),
//     'not_found'           => __( 'Not Found', 'HAC' ),
//     'not_found_in_trash'  => __( 'Not found in Trash', 'HAC' ),
//   );
//   $args = array(
//     'label'               => __( 'News', 'HAC' ),
//     'description'         => __( 'News', 'HAC' ),
//     'labels'              => $labels,
//     'supports'            => array( 'title', 'editor', 'thumbnail'),
//     'taxonomies'          => array( 'genres' ),
//     'hierarchical'        => true,
//     'public'              => true,
//     'show_ui'             => true,
//     'show_in_menu'        => false,
//     'show_in_nav_menus'   => false,
//     'show_in_admin_bar'   => false,
//     'menu_position'       => 1,
//     'can_export'          => false,
//     'has_archive'         => false,
//     'exclude_from_search' => false,
//     'publicly_queryable'  => false,
//     'query_var'           => false,
//     'capability_type'     => 'page',
//   );
//   register_post_type( 'NEWS', $args );
// }
// add_action( 'init', 'NEWS_a', 0 );

/*********************************
		Teams CPT
**********************************/
function TEAMMEMBERS() {
  register_post_type( 'team-members',
    array(
        'labels' => array(
            'name' => __( 'Team Members'),
            'singular_name' => __( 'Team Members')
        ),
        'public' => true,
            'menu_icon' => 'dashicons-admin-users',
            //'has_archive' => ture,
            'rewrite' => array('slug' => 'team-members'),
        )
    );
}
add_action( 'init', 'TEAMMEMBERS' );
function TEAMMEMBERS_a() {
  $labels = array(
    'name'                => _x( 'Team Members', 'Post Type General Name', 'HAC' ),
    'singular_name'       => _x( 'Team Members', 'Post Type Singular Name', 'HAC' ),
    'menu_name'           => __( 'Team Members', 'HAC' ),
    'parent_item_colon'   => __( 'Team Members', 'HAC' ),
    'all_items'           => __( 'All Team Members', 'HAC' ),
    'view_item'           => __( 'View Team Members', 'HAC' ),
    'add_new_item'        => __( 'Add New Team Members', 'HAC' ),
    'add_new'             => __( 'Add New', 'HAC' ),
    'edit_item'           => __( 'Edit Team Members', 'HAC' ),
    'update_item'         => __( 'Update Team Members', 'HAC' ),
    'search_items'        => __( 'Search Team Members', 'HAC' ),
    'not_found'           => __( 'Not Found', 'HAC' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'HAC' ),
  );
  $args = array(
    'label'               => __( 'Team Members', 'HAC' ),
    'description'         => __( 'Team Members', 'HAC' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail'),
    'taxonomies'          => array( 'genres' ),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => false,
    'show_in_nav_menus'   => false,
    'show_in_admin_bar'   => false,
    'menu_position'       => 1,
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => false,
    'query_var'           => false,
    'capability_type'     => 'page',
  );
  register_post_type( 'TEAMMEMBERS', $args );
}
add_action( 'init', 'TEAMMEMBERS_a', 0 );

/*********************************
		Resources CPT
**********************************/
function RESOURCES() {
  register_post_type( 'resources',
    array(
        'labels' => array(
            'name' => __( 'Resources'),
            'singular_name' => __( 'Resources')
        ),
        'public' => true,
            'menu_icon' => 'dashicons-admin-post',
            //'has_archive' => ture,
            'rewrite' => array('slug' => 'resources'),
        )
    );
}
add_action( 'init', 'RESOURCES' );
function RESOURCES_a() {
  $labels = array(
    'name'                => _x( 'Resources', 'Post Type General Name', 'HAC' ),
    'singular_name'       => _x( 'Resources', 'Post Type Singular Name', 'HAC' ),
    'menu_name'           => __( 'Resources', 'HAC' ),
    'parent_item_colon'   => __( 'Resources', 'HAC' ),
    'all_items'           => __( 'All Resources', 'HAC' ),
    'view_item'           => __( 'View Resources', 'HAC' ),
    'add_new_item'        => __( 'Add New Resources', 'HAC' ),
    'add_new'             => __( 'Add New', 'HAC' ),
    'edit_item'           => __( 'Edit Resources', 'HAC' ),
    'update_item'         => __( 'Update Resources', 'HAC' ),
    'search_items'        => __( 'Search Resources', 'HAC' ),
    'not_found'           => __( 'Not Found', 'HAC' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 'HAC' ),
  );
  $args = array(
    'label'               => __( 'Resources', 'HAC' ),
    'description'         => __( 'Resources', 'HAC' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'thumbnail'),
    'taxonomies'          => array( 'genres' ),
    'hierarchical'        => true,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => false,
    'show_in_nav_menus'   => false,
    'show_in_admin_bar'   => false,
    'menu_position'       => 1,
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => false,
    'publicly_queryable'  => false,
    'query_var'           => false,
    'capability_type'     => 'page',
  );
  register_post_type( 'RESOURCES', $args );
}
add_action( 'init', 'RESOURCES_a', 0 );

/**************************************************
                REMOVE ADMIN MENU
**************************************************/
function remove_menus(){
  // remove_menu_page( 'index.php' );               //Dashboard
  //remove_menu_page( 'edit.php' );
  // remove_menu_page( 'upload.php' );              //Media
  remove_menu_page( 'edit-comments.php' );          //Comments
  // remove_menu_page( 'plugins.php' );             //Plugins
  // remove_menu_page( 'users.php' );               //Users
  //remove_menu_page( 'tools.php' );                  //Tools
  // remove_menu_page( 'options-general.php' );     //Settings
}
add_action( 'admin_menu', 'remove_menus' );


get_template_part( 'includes/components/team-members/team-member-modal' );

//get_template_part( 'includes/components/post-listing/post-listing-data' );

include(ABSPATH . 'wp-content/themes/operatic/includes/components/post-listing/post-listing-data.php');

// translate miscellaneous strings
if ( function_exists('pll_register_string') ) {
	pll_register_string('header-member-login', 'Member Login', 'header');

	pll_register_string('components-download-pdf', 'All News', 'components');
	pll_register_string('components-download-pdf', 'All Resources', 'components');
	pll_register_string('components-download-pdf', 'Download PDF', 'components');
	pll_register_string('components-filter', 'Filter', 'components');
	pll_register_string('components-read-more', 'Read More', 'components');
	pll_register_string('components-show-me', 'Reset', 'components');
	pll_register_string('components-show-me', 'Search news', 'components');
	pll_register_string('components-show-me', 'Search resources', 'components');
	pll_register_string('components-show-me', 'Show me:', 'components');
}
?>
