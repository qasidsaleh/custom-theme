<?php
    $enable_bg = get_field('enable_bg_color');
    $top_alignment = get_field('top_alignment');
    $main_heading = get_field('main_heading');
    $heading = get_field('heading');
    $small_heading = get_field('small_heading');
    $sub_heading = get_field('sub_heading');
    $content = get_field('content');
    $btn = get_field('button');
    $primary_btn = get_field('primary_button');
    $btn2 = get_field('button2');
    $primary_btn2 = get_field('primary_button2');
    $video = get_field('video');
    $image = get_field('image');
    $hide_mobile = get_field('hide_image_on_mobile');
    $image_position = get_field('image_position');
    $large_image = get_field('large_image');
    $bg = get_field('enable_background');
    $top_padding = get_field('add_top_padding');
    $bottom_padding = get_field('add_bottom_padding');
    //Video Modal
    $enable_video_modal = get_field('enable_video_modal');
    if($enable_video_modal){
        $video_modal_id = get_field('video_modal_id');
        $video_linkiframe_embedded_code = get_field('video_linkiframe_embedded_code');
    }
    //Modal
    $enable_modal = get_field('enable_modal');
    if($enable_modal){
        $modal_id = get_field('modal_id');
        $modal_image = get_field('modal_image');
        $modal_heading = get_field('modal_heading');
        $modal_content = get_field('modal_content');
        $modal_btn1 = get_field('modal_button1');
        $modal_btn2 = get_field('modal_button2');
    }
?>
<section class="grid-content <?php if($enable_bg){echo 'bg';} ?> <?php if($bg){echo 'bg-enable';} ?> reveal-bottom active">
    <?php if($bg){echo '<div class="reveal-bg-'.$image_position.'">';} ?>
    <div class="section-inner <?php if($bottom_padding){echo 'bottom-padding ';} if($top_padding){echo 'top-padding';} ?>">
        <?php if($main_heading){ ?>
            <div class="main-heading">
                <h2><?php echo $main_heading; ?></h2>
            </div>
        <?php } ?>
        <div class="grid-container <?php if($top_alignment){echo 'top-alignment';} ?> <?php echo $image_position.'-image'; ?> <?php if($large_image){echo 'large-image';} ?>">
            <div class="content <?php if($bg){echo 'bg-enable';} ?>">
                <?php if($sub_heading){
                    if($main_heading){ ?>
                        <h3 class="sub-heading"><?php echo $sub_heading; ?></h3>
                    <?php } else { ?>
                        <h2 class="sub-heading"><?php echo $sub_heading; ?></h2>
                    <?php } ?>
                <?php }
                if($heading){
                    if(empty($sub_heading)){
                        if($main_heading){ ?>
                            <h3 class="h2 <?php if($small_heading){echo 'small';} ?>"><?php echo $heading; ?></h3>
                        <?php } else { ?>
                            <h2 class="h2 <?php if($small_heading){echo 'small';} ?>"><?php echo $heading; ?></h2>
                        <?php }
                    } else {
                        if($main_heading){ ?>
                            <h4 class="h2 <?php if($small_heading){echo 'small';} ?>"><?php echo $heading; ?></h4>
                        <?php } else { ?>
                            <h3 class="h2 <?php if($small_heading){echo 'small';} ?>"><?php echo $heading; ?></h3>
                        <?php }
                    }
                }
                echo $content; ?>
                <div class="button">
                    <?php if($btn){
                        if($primary_btn){
                            require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
                        } else {
                            require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-secondary.php';
                        }
                    } ?>
                    <?php if($btn2){
                        $btn = $btn2;
                        if($enable_modal){
                            $btn['id'] = $modal_id;
                            $btn['class'] = 'modal-btn';
                        }
                        if($primary_btn2){
                            require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
                        } else {
                            require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-secondary.php';
                        }
                    } ?>
                </div>
            </div>
            <div class="image <?php if($hide_mobile){echo 'hide-mobile';} ?>">
                <?php
                    if($enable_video_modal){ ?>
                        <div class="image modal-video-btn" data-id="<?php echo $video_modal_id; ?>">
                            <img src="<?php bloginfo('template_url'); ?>/img/play.svg" class="playbtn" role="presentation" width="90" height="90">
                            <?php display_image($image); ?>
                        </div>
                    <?php } else {
                        if($video){ ?>
                            <div class="image playvideo">
                                <div class="video-thumb">
                                  <img src="<?php bloginfo('template_url'); ?>/img/play.svg" class="playbtn" role="presentation" width="90" height="90">
                                  <?php display_image($image); ?>
                                </div>
                                <?php echo $video; ?>
                            </div>
                        <?php } else {
                            display_image($image);
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php if($bg){echo '</div>';} ?>
</section>
<?php if($enable_modal){ ?>
    <section class="content-modal custom-modal" id="<?php echo $modal_id; ?>">
		<a href="#" class="cross" id="cross">
			<svg xmlns="http://www.w3.org/2000/svg" width="51" height="51" viewBox="0 0 51 51" fill="none">
				<path d="M1.04567 1.96971C1.71541 1.30017 2.62365 0.924044 3.57067 0.924044C4.51768 0.924044 5.42592 1.30017 6.09566 1.96971L24.9992 20.8733L43.9028 1.96971C44.2323 1.6286 44.6264 1.35652 45.0621 1.16935C45.4978 0.982173 45.9664 0.88365 46.4407 0.879529C46.9149 0.875409 47.3852 0.965771 47.8241 1.14535C48.263 1.32492 48.6617 1.59011 48.9971 1.92544C49.3324 2.26077 49.5976 2.65953 49.7772 3.09844C49.9567 3.53736 50.0471 4.00765 50.043 4.48186C50.0389 4.95607 49.9403 5.42471 49.7532 5.86044C49.566 6.29617 49.2939 6.69026 48.9528 7.01971L30.0492 25.9233L48.9528 44.8268C49.6034 45.5004 49.9634 46.4026 49.9552 47.339C49.9471 48.2754 49.5715 49.1712 48.9093 49.8333C48.2471 50.4955 47.3514 50.8711 46.415 50.8793C45.4785 50.8874 44.5764 50.5274 43.9028 49.8769L24.9992 30.9733L6.09566 49.8769C5.42209 50.5274 4.51994 50.8874 3.58352 50.8793C2.6471 50.8711 1.75134 50.4955 1.08917 49.8333C0.426999 49.1712 0.0513949 48.2754 0.0432576 47.339C0.0351204 46.4026 0.395102 45.5004 1.04567 44.8268L19.9492 25.9233L1.04567 7.01971C0.376127 6.34997 0 5.44172 0 4.49471C0 3.54769 0.376127 2.63945 1.04567 1.96971Z" fill="#AE0000"></path>
			</svg>
		</a>
        <div class="content-container">
            <div class="image">
                 <?php display_image($modal_image); ?>
            </div>
            <div class="content">
                <h3 class="line"><?php echo $modal_heading; ?></h3>
                <?php echo $modal_content; ?>
                <?php if($modal_btn1){
                    $btn = $modal_btn1;
                    require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
                }
                if($modal_btn2){
                    $btn = $modal_btn2;
                    require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php';
                } ?>
            </div>
        </div>
	</section>
<?php }
if($enable_video_modal){ ?>
    <section class="video-modal custom-modal" id="<?php echo $video_modal_id; ?>">
		<a href="#" class="videocross" id="videocross">
			<svg xmlns="http://www.w3.org/2000/svg" width="51" height="51" viewBox="0 0 51 51" fill="none">
				<path d="M1.04567 1.96971C1.71541 1.30017 2.62365 0.924044 3.57067 0.924044C4.51768 0.924044 5.42592 1.30017 6.09566 1.96971L24.9992 20.8733L43.9028 1.96971C44.2323 1.6286 44.6264 1.35652 45.0621 1.16935C45.4978 0.982173 45.9664 0.88365 46.4407 0.879529C46.9149 0.875409 47.3852 0.965771 47.8241 1.14535C48.263 1.32492 48.6617 1.59011 48.9971 1.92544C49.3324 2.26077 49.5976 2.65953 49.7772 3.09844C49.9567 3.53736 50.0471 4.00765 50.043 4.48186C50.0389 4.95607 49.9403 5.42471 49.7532 5.86044C49.566 6.29617 49.2939 6.69026 48.9528 7.01971L30.0492 25.9233L48.9528 44.8268C49.6034 45.5004 49.9634 46.4026 49.9552 47.339C49.9471 48.2754 49.5715 49.1712 48.9093 49.8333C48.2471 50.4955 47.3514 50.8711 46.415 50.8793C45.4785 50.8874 44.5764 50.5274 43.9028 49.8769L24.9992 30.9733L6.09566 49.8769C5.42209 50.5274 4.51994 50.8874 3.58352 50.8793C2.6471 50.8711 1.75134 50.4955 1.08917 49.8333C0.426999 49.1712 0.0513949 48.2754 0.0432576 47.339C0.0351204 46.4026 0.395102 45.5004 1.04567 44.8268L19.9492 25.9233L1.04567 7.01971C0.376127 6.34997 0 5.44172 0 4.49471C0 3.54769 0.376127 2.63945 1.04567 1.96971Z" fill="#AE0000"></path>
			</svg>
		</a>
        <div class="content-container">
            <?php echo $video_linkiframe_embedded_code; ?>
        </div>
	</section>
<?php } ?>
