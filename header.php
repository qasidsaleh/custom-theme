<?php
	$logo = get_field('header_logo','options');
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>

		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php wp_head(); ?>

		<?php echo get_field('header_script', 'option'); ?>

		<div class="nav-shortcuts" title="skip links">
			<a href="#main-content">skip to content</a>
			<a href="#footer">skip to footer</a>
		</div>

		<?php if ( is_admin_bar_showing() ) { ?>
			<style>
				body{
					min-height: calc(100vh - 32px);
				}
			</style>
		<?php } ?>
	</head>
	<body <?php body_class(); ?>>
		<?php echo get_field('top_body_script', 'option'); ?>
		<?php
			$current_lang = pll_current_language();
			$lang_class = 'lang-' . $current_lang;
		?>
		<header id="header" class="<?php echo $lang_class; ?>">
			<div id="topbar" class="topbar">
				<div class="section-inner">
					<div class="custom-select eng">
					  	<button
					    	class="select-button"
					    	role="combobox"
					    	aria-labelledby="select button"
					    	aria-haspopup="listbox"
					    	aria-expanded="false"
					    	aria-controls="select-dropdown"
					  	>
					    	<span class="selected-value">en</span>
					    	<span class="arrow">
					    		<img src="<?php bloginfo('template_url'); ?>/img/dropdown-arrow.svg" width="14" height="9" alt="arrow">
					    	</span>
					  	</button>
					  	<ul class="select-dropdown" role="listbox" id="select-dropdown">
					    	<li role="option">
					      		<input type="radio" id="eng" name="language" />
					      		<label for="eng">en</label>
					    	</li>
					    	<?php
								$langs_array = pll_the_languages( array( 'dropdown' => 1, 'hide_current' => 1, 'raw' => 1 ) );
								if($langs_array):
									foreach ($langs_array as $lang): ?>
										<li role="option">
								      		<a href="<?php echo $lang['url']; ?>"><?php echo $lang['slug']; ?></a>
								    	</li>
									<?php endforeach;
								endif;
							?>
					  	</ul>
					</div>
					<a href="<?php echo get_field('header_button_link','options'); ?>" class="btn btn-secondary">
						<span><?= pll__('Member Login') ?></span>
						<svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_808_153)">
								<path d="M10.6167 5.97549V4.4066C10.6167 1.97417 8.61667 -0.00341797 6.15667 -0.00341797C3.69667 -0.00341797 1.7 1.97747 1.7 4.4099V5.93264C0.73 6.12051 0 6.92803 0 7.89045V12.9992C0 14.1396 0.85 14.9999 1.97667 14.9999H9.86667C11.04 14.9999 12 14.1034 12 12.9992V7.89045C12 6.96099 11.4367 6.21939 10.6167 5.97549ZM8.95 5.88979H3.36667V4.4066C3.36667 2.88386 4.62 1.64457 6.16 1.64457C7.7 1.64457 8.95333 2.88386 8.95333 4.4066V5.88979H8.95Z" fill="#F5F1F2"/>
							</g>
							<defs>
								<clipPath id="clip0_808_153">
									<rect width="12" height="15" fill="white"/>
								</clipPath>
							</defs>
						</svg>
					</a>
				</div>
			</div>
			<div class="header-container">
				<div class="section-inner">
					<div class="header-inner">
						<div class="logo">
							<a href="<?php echo home_url(); ?>" aria-label="link to homepaga">
								<?php display_image($logo); ?>
							</a>
						</div>
						<div class="header-right">
							<nav class="main-nav">
								<?php
					                echo str_replace( '<li class="', '<li class="',
					                    wp_nav_menu( array(
					                    'container'       => true,
					                    'theme_location' => 'header-menu',
					                    'items_wrap'      => '<ul id="main-menu">%3$s</ul>',
					                    'menu_class' => ''
					                )));
					            ?>
							</nav>
						</div>
						<button class="hamburger mobile-buttons" aria-controls="primary-navigation"  aria-label="Primary Navigation" aria-expanded="false">
							<svg fill="var(--button-color)" viewBox="0 0 100 100" width="250">
								<rect class="line top" width="80" height="4" x="10" y="28" rx="5"></rect>
								<rect class="line middle" width="80" height="4" x="10" y="48" rx="5"></rect>
								<rect class="line bottom" width="80" height="4" x="10" y="68" rx="5"></rect>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</header>
