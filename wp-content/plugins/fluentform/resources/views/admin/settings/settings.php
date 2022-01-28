<?php do_action('fluentform_before_global_settings_option_render'); ?>

<div class="ff_global_settings_option" id="ff_global_settings_option_app">
    <component
        :settings_key="settings_key"
        :is="component"
        :current_component="component"
        :app="App"
    ></component>
</div>

<?php do_action('fluentform_after_global_settings_option_render'); ?>
