<?php do_action('fluentform_global_menu'); ?>
<div class="ff_form_wrap">
    <div class="ff_form_wrap_area">
        <?php do_action('fluentform_before_all_forms_render'); ?>
        <div class="ff_all_forms" id="ff_all_forms_app">
            <ff_all_forms_table></ff_all_forms_table>
        </div>
        <?php do_action('fluentform_after_all_forms_render'); ?>
    </div>
</div>
<?php
$notices = apply_filters('fluentform_dashboard_notices', []);

if ($notices) {
    echo '<div class="ff_global_notices">';
    foreach ($notices as $noticeKey => $notice) :
        ?>
        <div class="ff_global_notice ff_notice_<?php echo $notice['type']; ?>">
            <?php echo $notice['message']; ?>
        </div>
    <?php
    endforeach;
    echo '</div>';
}