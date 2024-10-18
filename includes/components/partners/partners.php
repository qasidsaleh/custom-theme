<?php
    $enable_bg = get_field('enable_bg_partner');
    $remove_bottom_spacing = get_field('remove_partner_bottom_spacing');
    $heading = get_field('heading');
    $col = get_field('number_of_columns');
    $logos = get_field('logos');
    $btn = get_field('button');
?>
<section class="partners <?php if($remove_bottom_spacing){echo 'remove-bottom-space';} ?> <?php if($enable_bg){echo 'enable-bg';} ?> reveal-bottom active">
    <div class="section-inner">
        <?php if($heading){ ?>
            <h2 class="h3"><?php echo $heading; ?></h2>
        <?php } ?>
         <div class="partners-container <?php echo $col; ?>">
            <?php if($logos){
                foreach($logos as $logo): ?>
                    <a href="<?php echo $logo['link']; ?>" aria-label="Read More about partner">
                        <?php display_image($logo['logo']); ?>
                    </a>
                <?php endforeach;
            } ?>
         </div>
         <?php if($btn){ ?>
            <div class="button">
                <?php require ABSPATH . '/wp-content/themes/operatic/includes/buttons/btn-primary.php'; ?>
            </div>
        <?php } ?>
    </div>
</section>