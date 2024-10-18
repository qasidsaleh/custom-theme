<?php
    $heading = get_field('heading');
    $small_heading = get_field('subheading');
    $button = get_field('button');
    $intro = get_field('intro');
    $full_width_intro = get_field('full_width_intro');
    $layout = get_field('layout');
    $alignment = get_field('alignment');
    $blocks = get_field('blocks');
?>
<section class="grid-blocks">
    <div class="section-inner">
        <?php 
        if($heading || $intro || $small_heading){ ?>
            <div class="intro <?php if($full_width_intro){echo 'full-width';} ?> reveal-bottom active">
                <?php if($heading){ ?>
                    <h2 class="<?php if($small_heading){echo 'h3';} ?>"><?php echo $heading; ?></h2>
                <?php } 
                if($small_heading){ ?>
                    <span class="h4"><?php echo $small_heading; ?></span>
                <?php } 
                if($intro){ ?>
                    <p><?php echo $intro; ?></p>
                <?php } 
                if($button){ ?>
                    <a href="<?php echo $button['url']; ?>" class="btn btn-secondary white"><?php echo $button['title']; ?></a>
                <?php } ?>
            </div>
        <?php }
        if($blocks){ ?>
            <div class="block-container <?php echo $layout; ?> <?php echo $alignment; ?> reveal-bottom active"> 
                <?php foreach($blocks as $block):
                    $icon = $block['icon'];
                    $heading = $block['heading'];
                    $small_heading = $block['small_heading'];
                    $desc = $block['description'];
                    $btn = $block['button']; ?>
                    <div class="block <?php if($btn){echo 'bottom-spacing';} ?>"> 
                        <?php if($icon){
                            display_image($icon);
                        }
                        if($heading){ ?>
                            <h3 class="<?php if($small_heading){echo 'h4';} ?>"><?php echo $heading; ?></h3>
                        <?php } 
                        if($desc){
                            echo $desc;
                        }
                        if($btn){ ?>
                            <a href="<?php echo $btn['url']; ?>" class="btn btn-secondary white"><?php echo $btn['title']; ?></a>
                        <?php } ?>
                    </div>
                <?php endforeach; ?>
            </div> 
        <?php } ?>
    </div>
</section>