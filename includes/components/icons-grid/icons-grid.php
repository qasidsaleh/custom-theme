<?php
    $grid_items = get_field('grid_items');
?>
<section class="icons-grid">
    <div class="section-inner">
        <div class="icon-grid col-2 reveal-bottom active">
            <?php foreach($grid_items as $key=>$item): ?>
                <?php if($item['link']): ?> 
                    <a href="<?php echo $item['link']['url']; ?>" class="grid-item linked">
                <?php else: ?> 
                    <div class="grid-item"> 
                <?php endif;?>
                    <?php display_image($item['icon']); ?>
                    <div class="grid-caption">
                        <?php echo $item['heading'] ? '<h3>' . $item['heading'] . '</h3>' : ''; ?>
                        <?php echo $item['description'] ? '<p>' . $item['description'] . '</p>' : ''; ?>
                    </div>
                <?php if($item['link']): ?> 
                    </a>
                <?php else: ?> 
                    </div> 
                <?php endif;?>
            <?php endforeach; ?>
        </div>
    </div>
</section>