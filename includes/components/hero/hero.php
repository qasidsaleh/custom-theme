<?php
    $h1 = get_field('h1');
    $subheading = get_field('subheading');
    $description = get_field('description');
    $hero_type = get_field('hero_type');
    $bg_image = get_field('background_image'); 
    if(empty($bg_image)){
        $bg_image['url'] = '/wp-content/themes/operatic/img/hero-bg3.png';
    }
    $image = get_field('image');
    $video = get_field('video');
    $button = get_field('button');
?>
<section class="hero-container <?php echo $hero_type; ?>">
    <div class="<?php echo $hero_type; ?>" style="--bg-image: url('<?php echo $bg_image['url']; ?>');">
        <div class="hero-caption">
            <div class="inner">
                <?php if ($subheading): ?>
                    <h1><?php echo $subheading; ?></h1>
                    <span class="h1"><?php echo $h1; ?></span>
                <?php 
                else: ?>
                    <h1><?php echo $h1; ?></h1>
                <?php endif; ?>
                <p><?php echo $description; ?></p>
                <?php if ($button): ?>
                    <div class="button-row">
                        <a href="<?php echo $button['url']; ?>" class="btn btn-secondary red"><?php echo $button['title']; ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if($hero_type === 'image'): ?>
            <div class="img-container">
                <?php display_image($image); ?>
            </div>
        <?php endif;
        if($hero_type === 'video'): ?>
            <div class="video-container">
                <video autoplay loop muted>
                    <source src="<?php echo $video['url']; ?>" type="video/webm">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif; ?>
    </div>
</section>