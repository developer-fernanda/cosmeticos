<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Imagetoolbar" content="No"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e('Preview Form', 'fluentform') ?></title>
    <?php
    wp_head();
    ?>
    <style type="text/css">

    </style>
</head>
<body>
<div class="ff_preview_text">
    Design Mode
</div>
<div id="ff_preview_top">
    <div id="ff_preview_header">
        <div class="ff_preview_title">
            <ul>
                <li class="ff_form_name">
                    <?php echo $form->id .' - '. $form->title;  ?>
                </li>
                <li>
                    <a href="<?php echo admin_url('admin.php?page=fluent_forms&form_id=' . $form_id . '&route=editor') ?>">Edit Fields</a>
                </li>
            </ul>
        </div>
        <label for="ff_preview_only"><input id="ff_preview_only" type="checkbox" /> Preview Only</label>
        <div class="ff_preview_action">
           [fluentform id="<?php echo $form_id; ?>"]
        </div>
    </div>
    <div class="ff_preview_body">
        <div class="ff_form_preview_wrapper">
            <?php echo do_shortcode('[fluentform id="' . $form_id . '"]'); ?>
        </div>
        <div class="ff_form_styler_wrapper">
            <?php if(defined('FLUENTFORMPRO')): ?>
            <?php do_action('fluentform_form_styler', $form_id); ?>
            <?php elseif(apply_filters('fluentform_show_preview_promo', true)): ?>
                <div class="ff_styler_promo">
                    <div class="ff_promo_header">
                        Advanced Form Styler (Pro)
                    </div>
                    <div class="ff_promo_body">
                        <p><a target="_blank" href="https://wpmanageninja.com/docs/fluent-form/fluent-forms-styles/">Advanced Form styler</a> is available in Pro version of Fluent Forms.
                            You can style every element of the forms including input fields, form container, succes / error messages and many more.</p>
                        <h4>Other Features</h4>
                        <ul>
                            <li>Stripe & PayPal Integration</li>
                            <li>Advanced Form Styler</li>
                            <li>Advanced Form Fields</li>
                            <li>Payment Processing</li>
                            <li>20+ CRM integrations</li>
                            <li>Calculated Fields for quotation form</li>
                            <li>Multi-Step Forms</li>
                            <li>Conditional Logics</li>
                            <li>File Upload Feature</li>
                            <li>SMS Notifications</li>
                            <li>Visual Data Reporting</li>
                        </ul>
                        <p style="text-align: center">
                            <a target="_blank" rel="nofollow" class="ff_upgrade_btn" href="<?php echo fluentform_upgrade_url(); ?>">Upgrade to Pro</a>
                        </p>


                        <?php
                        $addOns = (new \FluentForm\App\Modules\AddOnModule())->getPremiumAddOns();
                        ?>

                        <h4>Integrations available in Fluent Forms Pro</h4>
                        <ul class="ff_addons">
                            <?php foreach ($addOns as $addOn): ?>
                                <li><img title="<?php echo $addOn['title']; ?>" src="<?php echo $addOn['logo']; ?>" /></li>
                            <?php endforeach; ?>
                        </ul>

                        <p style="text-align: center">
                            <a target="_blank" rel="nofollow" class="ff_upgrade_btn" href="<?php echo fluentform_upgrade_url(); ?>">Upgrade to Pro</a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="ff_preview_footer">
        <p>You are seeing preview version of WP Fluent Forms. This form is only accessible for Admin users. Other users
            may not access this page. To use this for in a page please use the following shortcode: [fluentform
            id='<?php echo $form_id ?>']</p>
    </div>
</div>
<?php
wp_footer();
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#ff_preview_only').on('change', function () {
            var isChecked = $(this).is(':checked');
            if(isChecked) {
                $('.ff_preview_body').addClass('ff_preview_only');
                $('.ff_preview_text').html('Preview Mode');
            } else {
                $('.ff_preview_body').removeClass('ff_preview_only');
                $('.ff_preview_text').html('Design Mode');
            }
        });
    });
</script>

</body>
</html>