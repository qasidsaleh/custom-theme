<?php
    $heading = get_field('heading');
    $iframe = get_field('iframe');
?>
<section class="embeded-iframe">
    <div class="section-inner">
        <?php if($heading){ ?>
            <h2><?php echo $heading; ?></h2>
        <?php } ?>
        <div class="iframe">
            <?php echo $iframe; ?>
        </div>
    </div>
</section>