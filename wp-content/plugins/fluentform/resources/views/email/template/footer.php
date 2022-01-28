<?php
/**
 * Email Footer
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$poweredBy = apply_filters('fluentform_email_template_footer_credit','Powered by <a href="https://wordpress.org/plugins/fluentform/">FluentForm</a>.', $form, $notification);
if(defined('FLUENTFORMPRO')) {
    $poweredBy = '';
}
?>
</div></td></tr></table></td></tr></table></td></tr></table>
<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer"><tr><td valign="top"><table border="0" cellpadding="10" cellspacing="0" width="100%"><tr><td class="fluent_credit" colspan="2" valign="middle" id="credit">
<span><?php echo $footerText; ?> <?php echo $poweredBy; ?></span>
<?php do_action( 'fluentform_email_template_after_footer', $form, $notification );?>
</td></tr></table></td></tr></table></td></tr></table></div></body></html>