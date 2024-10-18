<?php 
// Fire AJAX action for both logged in and non-logged in users
add_action('wp_ajax_get_ajax_member_data', 'get_ajax_member_data');
add_action('wp_ajax_nopriv_get_ajax_member_data', 'get_ajax_member_data');
function get_ajax_member_data () {
  	$member_id = $_REQUEST['member-id'];
  	// The Query
  	$member = array(
        'post_type' => 'team-members',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'post__in' => array($member_id),
        'orderby' => 'date',
        'order' => 'ASC',
    );;
  	$ajaxposts = new WP_Query( $member );
  	$response = '';
 	// The Query
  	if ( $ajaxposts->have_posts() ) { 
    	while ( $ajaxposts->have_posts() ) {
  			$ajaxposts->the_post(); 
  			$image = get_field('featured_image',$member_id);
			$heading = get_the_title();
			$designation = get_field('designation',$member_id);
            $content = get_field('member_description',$member_id);
            $btn = get_field('member_button',$member_id);
            $email = get_field('email_address',$member_id);
            $phone = get_field('phone_number',$member_id);
            $facebook = get_field('facebook_profile_link',$member_id);
            $linkedin = get_field('linkedin_profile_link',$member_id);
            $twitter = get_field('twitter_profile_link',$member_id); ?>
		    <div class="bio-container">
				<div class="image">
					<?php display_image($image); ?>
				</div>
				<div class="content">
					<h3 class="line"><?php echo $heading; ?></h3>
					<span class="designation"><?php echo $designation; ?></span>
                    <div class="">
                    <?php echo $content; ?>
                    <?php if($btn){ ?>
                        <div class="button">
                            <?php require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-secondary.php'; ?>
                        </div>
                    <?php } ?>
                    <?php if($email){ ?>
                        <a href="mailto:<?php echo $email; ?>" class="email"><?php echo $email; ?></a>
                        <?php if($phone){ echo '<span class="seperator"></span>'; }?>
                    <?php } ?>
                    <?php if($phone){ ?>
                        <a href="tel:<?php echo $phone; ?>" class="phone"><?php echo $phone; ?></a>
                    <?php } ?>
                    <?php if(!empty($facebook) || !empty($linkedin) || !empty($twitter)){ ?>
                        <div class="social-profiles">
                            <?php if(!empty($linkedin) && $linkedin != '#'){ ?>
                                <a href="<?php echo $linkedin; ?>" target="_blank">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_808_292)">
                                            <path d="M22.2234 0H1.77187C0.792187 0 0 0.773438 0 1.72969V22.2656C0 23.2219 0.792187 24 1.77187 24H22.2234C23.2031 24 24 23.2219 24 22.2703V1.72969C24 0.773438 23.2031 0 22.2234 0ZM7.12031 20.4516H3.55781V8.99531H7.12031V20.4516ZM5.33906 7.43438C4.19531 7.43438 3.27188 6.51094 3.27188 5.37187C3.27188 4.23281 4.19531 3.30937 5.33906 3.30937C6.47813 3.30937 7.40156 4.23281 7.40156 5.37187C7.40156 6.50625 6.47813 7.43438 5.33906 7.43438ZM20.4516 20.4516H16.8937V14.8828C16.8937 13.5562 16.8703 11.8453 15.0422 11.8453C13.1906 11.8453 12.9094 13.2937 12.9094 14.7891V20.4516H9.35625V8.99531H12.7687V10.5609H12.8156C13.2891 9.66094 14.4516 8.70938 16.1813 8.70938C19.7859 8.70938 20.4516 11.0813 20.4516 14.1656V20.4516Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_808_292">
                                                <rect width="24" height="24" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            <?php }
                            if(!empty($facebook) && $facebook != '#'){ ?>
                                <a href="<?php echo $facebook; ?>" target="_blank">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_808_295)">
                                            <path d="M24.7061 12C24.7061 5.37258 19.3335 0 12.7061 0C6.07863 0 0.706055 5.37258 0.706055 12C0.706055 17.9895 5.09426 22.954 10.8311 23.8542V15.4688H7.78418V12H10.8311V9.35625C10.8311 6.34875 12.6226 4.6875 15.3636 4.6875C16.6761 4.6875 18.0498 4.92188 18.0498 4.92188V7.875H16.5367C15.0461 7.875 14.5811 8.80008 14.5811 9.75V12H17.9092L17.3771 15.4688H14.5811V23.8542C20.3179 22.954 24.7061 17.9895 24.7061 12Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_808_295">
                                                <rect width="24" height="24" fill="white" transform="translate(0.706055)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            <?php } 
                            if(!empty($twitter) && $twitter != '#'){ ?>
                                <a href="<?php echo $twitter; ?>" target="_blank">
                                    <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_808_297)">
                                            <path d="M13.6881 10.1284L22.2504 0H20.2214L12.7868 8.79448L6.84882 0H0L8.97939 13.2987L0 23.92H2.02917L9.88042 14.6328L16.1514 23.92H23.0002L13.6879 10.1284H13.6884H13.6881ZM10.9089 13.4157L9.99906 12.0916L2.76019 1.55433H5.87669L11.7187 10.0582L12.6285 11.3824L20.2224 22.4361H17.1059L10.9091 13.4161V13.4155L10.9089 13.4157Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_808_297">
                                                <rect width="23" height="23.92" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
				</div>
			</div>
		<?php }
    }
  	echo $response;
  	exit; // leave ajax call
}