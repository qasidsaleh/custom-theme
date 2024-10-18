<?php 
    $heading = get_field('heading');
    $logos = get_field('list');
?>
<section class="logos">
    <div class="section-inner">
        <div class="logos-container">
            <?php if($heading){ ?>
                <h2><?php echo $heading; ?></h2>
            <?php } ?>
            <div class="logos-grid">
                <?php foreach($logos as $key=>$logo): ?>
                    <div class="logo-item">
                        <a href="<?php echo $logo['link']; ?>" <?php if($logo['link']){echo 'target="_blank"';} ?>><?php display_image($logo['logo']); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>  
        </div>
    </div>
</section>