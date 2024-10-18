<?php
    $enable_bg = get_field('enable_bg');
    $heading = get_field('heading');
    $subheading = get_field('subheading');
    $desc = get_field('description');
    $slider = get_field('slider');
?>
<section class="gallery-slider  <?php if($enable_bg){echo 'bg';} ?>">
    <div class="section-inner">
        <div class="grid-container">
            <?php if($slider){ ?>
                <div class="slider">
                    <div class="swiper-container gallery-top">
                        <div class="swiper-wrapper">
                            <?php foreach($slider as $key=>$item): 
                                $type = $item['videoimage']; ?>
                                <div class="swiper-slide">
                                    <?php if($type == 'video'){
                                        $youtube = $item['youtube_video']; ?>
                                        <div class="video">
                                            <?php if(empty($youtube)){ ?>
                                                <video id="playVideo" class="" loop muted>
                                                    <source src="<?php echo $item['video']; ?>" type="video/webm">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <img src="<?php bloginfo('template_url'); ?>/img/play.svg" class="playbtn" role="presentation" width="90" height="90">
                                            <?php } else {
                                                echo $youtube;
                                            } ?>
                                        </div>
                                    <?php } else { 
                                        display_image($item['image']);
                                    } ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="swiper-container gallery-thumbs">
                        <div class="swiper-wrapper">
                            <?php foreach($slider as $key=>$item): ?>
                                <div class="swiper-slide">
                                    <?php display_image($item['thumbnail']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                    </div>
                    <!-- Arrows -->
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
            <?php } ?>
            <div class="content">
                <?php if($subheading){ ?>
                    <span><?php echo $subheading; ?></span>
                <?php } if($heading){ ?>
                    <h2><?php echo $heading; ?></h2>
                <?php } ?>
                <?php echo $desc; ?>
            </div>
        </div>
    </div>
</section>