<?php
    $heading = get_field('contact_heading');
    $desc = get_field('contact_description');
    $email_heading = get_field('email_heading');
    $info_heading = get_field('info_heading');

    $address = get_field('address','options');
    $email = get_field('email_address','options');
    $email2 = get_field('email_address2','options');
    $phone = get_field('phone_number','options');

    $form = get_field('form');
?>
<section class="contact-block">
    <div class="section-inner">
        <div class="contact-container">
            <div class="contact-info">
                <?php if($heading){ ?>
                    <h2><?php echo $heading; ?></h2>
                <?php }
                if($desc){ ?>
                    <p><?php echo $desc; ?></p>
                <?php } ?>
                <div class="inner">
                    <div class="address">
                        <?php if($email_heading){ ?>
                            <h3><?php echo $email_heading; ?></h3>
                        <?php } ?>
                        <span><?php echo $address; ?></span>
                    </div>
                    <div class="phone">
                        <?php if($info_heading){ ?>
                            <h3><?php echo $info_heading; ?></h3>
                        <?php }
                        if($email){ ?>
                            <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                        <?php }
                        if($email2){ ?>
                            <a href="mailto:<?php echo $email2; ?>"><?php echo $email2; ?></a>
                        <?php }
                        if($phone){ ?>
                            <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form contact-form">
                <?= do_shortcode($form); ?>
            </div>
        </div>
    </div>
</section>
