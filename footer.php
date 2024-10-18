	<?php 
		$footer_logo = get_field('footer_logo','options');
		$phone_number = get_field('phone_number','options');
		$email = get_field('email_address','options');
		$address = get_field('address','options');
		$fb_link = get_field('facebook_link','options');
		$twitter_link = get_field('twitter_link','options');
		$instagram_link = get_field('instagram_link','options');
		$linkedin_link = get_field('linkedin_link','options');
		$youtube_link = get_field('youtube_link','options');
	?>
	<footer id="footer">
		<div class="footer-container section-inner">
			<a href="<?php echo get_home_url(); ?>" class="footer-logo" title="<?php bloginfo('name'); ?>">
				<?php display_image($footer_logo); ?>
			</a>
			<div class="footer-menu">
				<?php
	                echo str_replace( '<li class="', '<li class="',
	                    wp_nav_menu( array(
	                    'container'       => false,
	                    'theme_location' => 'footer-menu',
	                    'items_wrap'      => '<ul>%3$s</ul>',
	                    'menu_class' => ''
	                )));
	            ?>
			</div>
			<div class="footer-content">
				<div class="company-info">
					<?php if($phone_number){ ?>
						<a href="tel:<?php echo $phone_number; ?>" title="Phone Number"><?php echo $phone_number; ?></a>
					<?php }
					if($email){ ?>
						<a href="tel:<?php echo $email; ?>" title="Email"><?php echo $email; ?></a>
					<?php }
					if($address){ ?>
						<span><?php echo $address; ?></span>
					<?php } ?>
				</div>
				<div class="social">
					<?php if($twitter_link){ ?>
						<a href="<?php echo $twitter_link; ?>" target="_blank" title="Twitter Link">
						<svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M4.67589 0.871582H0.347656L5.47944 7.6146L0.675938 13.2712H2.8953L6.52835 8.99294L9.75434 13.2319H14.0826L8.80169 6.29288L8.81104 6.30485L13.358 0.950353H11.1386L7.76197 4.92668L4.67589 0.871582ZM2.73677 2.0525H4.0842L11.6935 12.0509H10.346L2.73677 2.0525Z" fill="#BD1B2D"/>
</svg>


						</a>
					<?php } 
					if($instagram_link){ ?>
						<a href="<?php echo $instagram_link; ?>" target="_blank" title="Instagram Link">
						<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.0991 11.6989H2.47952C1.4266 11.6989 0.566406 10.8387 0.566406 9.78583V2.16629C0.566406 1.11337 1.4266 0.253174 2.47952 0.253174H10.0991C11.152 0.253174 12.0122 1.11337 12.0122 2.16629V9.78583C12.0122 10.8434 11.1567 11.6989 10.0991 11.6989Z" fill="#BD1B2D"/>
<path d="M6.29329 8.91618C5.50831 8.91618 4.77032 8.61064 4.21566 8.05598C3.661 7.50132 3.35547 6.76334 3.35547 5.97835C3.35547 5.19337 3.661 4.45538 4.21566 3.90072C4.77032 3.34606 5.50831 3.04053 6.29329 3.04053C7.07828 3.04053 7.81626 3.34606 8.37092 3.90072C8.92559 4.45538 9.23112 5.19337 9.23112 5.97835C9.23112 6.76334 8.92559 7.50132 8.37092 8.05598C7.81156 8.61064 7.07828 8.91618 6.29329 8.91618ZM6.29329 3.6657C5.01945 3.6657 3.98064 4.69981 3.98064 5.97835C3.98064 7.25219 5.01475 8.29101 6.29329 8.29101C7.56713 8.29101 8.60595 7.25689 8.60595 5.97835C8.60125 4.70451 7.56713 3.6657 6.29329 3.6657Z" fill="white"/>
<path d="M9.80236 2.94407C10.1139 2.94407 10.3664 2.69153 10.3664 2.37999C10.3664 2.06846 10.1139 1.81592 9.80236 1.81592C9.49083 1.81592 9.23828 2.06846 9.23828 2.37999C9.23828 2.69153 9.49083 2.94407 9.80236 2.94407Z" fill="white"/>
</svg>

						</a>
					<?php } 
					if($linkedin_link){ ?>
						<a href="<?php echo $linkedin_link; ?>" target="_blank" title="LinkedIn Link">
						<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3.5637 4.69019H0.773438V13.5882H3.5637V4.69019Z" fill="#BD1B2D"/>
<path d="M11.1095 4.49741C11.0066 4.48455 10.8973 4.47812 10.788 4.47169C9.22575 4.4074 8.34496 5.3332 8.03636 5.73181C7.95278 5.84111 7.9142 5.9054 7.9142 5.9054V4.716H5.24609V13.614H7.9142H8.03636C8.03636 12.7075 8.03636 11.8074 8.03636 10.9009C8.03636 10.4123 8.03636 9.92364 8.03636 9.43502C8.03636 8.83067 7.99136 8.18776 8.29353 7.63485C8.55069 7.17195 9.01359 6.9405 9.53435 6.9405C11.0774 6.9405 11.1095 8.33563 11.1095 8.46421C11.1095 8.47064 11.1095 8.47707 11.1095 8.47707V13.6526H13.8998V7.84701C13.8998 5.86039 12.8904 4.69028 11.1095 4.49741Z" fill="#BD1B2D"/>
<path d="M2.16703 3.53962C3.06181 3.53962 3.78718 2.81426 3.78718 1.91947C3.78718 1.02468 3.06181 0.299316 2.16703 0.299316C1.27224 0.299316 0.546875 1.02468 0.546875 1.91947C0.546875 2.81426 1.27224 3.53962 2.16703 3.53962Z" fill="#BD1B2D"/>
</svg>

						</a>
					<?php }
					if($youtube_link){ ?>
						<a href="<?php echo $youtube_link; ?>" target="_blank" title="LinkedIn Link">
						<svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.8529 11.508H3.4062C1.8746 11.508 0.640625 10.1535 0.640625 8.48742V3.08285C0.640625 1.41001 1.8808 0.0622559 3.4062 0.0622559H14.8529C16.3845 0.0622559 17.6185 1.41678 17.6185 3.08285V8.48742C17.6247 10.1603 16.3845 11.508 14.8529 11.508Z" fill="#BD1B2D"/>
<path d="M12.1317 5.70037L7.31641 2.92358V8.47715L12.1317 5.70037Z" fill="white"/>
</svg>

						</a>
					<?php }
					if($fb_link){ ?>
						<a href="<?php echo $fb_link; ?>" target="_blank" title="Facebook Link">
						<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.67009 8.06246V13.6527H3.10213V8.06246H0.96875V5.79574H3.10213V4.97103C3.10213 1.90923 4.38117 0.299316 7.08741 0.299316C7.91706 0.299316 8.12447 0.432653 8.5788 0.541297V2.78332C8.07015 2.69443 7.92694 2.64505 7.39853 2.64505C6.77135 2.64505 6.43554 2.82283 6.12936 3.17346C5.82318 3.52408 5.67009 4.1315 5.67009 5.00066V5.80068H8.5788L7.79854 8.0674H5.67009V8.06246Z" fill="#BD1B2D"/>
</svg>

						</a>
					<?php } ?>
				</div>
			</div>
			<div class="copyrights">
				<p>An <a href="https://operaticagency.com/" target="_blank" title="Operatic Agency">Operatic Agency</a> Production</p>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
	<?php echo get_field('footer_script', 'option'); ?>
</body>
</html>