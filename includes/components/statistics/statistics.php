<?php
    $data_blocks = get_field('data_blocks');
    $num_of_items = count($data_blocks);
?>
<section class="statistics">
    <div class="section-inner">
         <div class="data-container-<?php echo $num_of_items; ?> data-container">
            <?php foreach($data_blocks as $block): ?>
                <div class="data-item">
                    <div class="data-value">
                        <div class="data-value-num">
                            <span class="symbol"><?php echo $block['symbol']; ?></span>
                            <span class="increment-stat" data-value="<?php echo $block['data_value']; ?>">0</span>
                            <span class="abbreviation"><?php echo $block['money_abbreviations']; ?></span>
                        </div>
                    </div>
                    <div class="data-title"><?php echo $block['data_title']; ?></div>
                </div>
            <?php endforeach; ?>
         </div>
    </div>
</section>