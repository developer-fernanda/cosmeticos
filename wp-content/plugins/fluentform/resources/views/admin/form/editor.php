<div>
	<?php do_action('fluentform_before_editor_start'); ?>
	<div id="ff_form_editor_app">
		<ff_form_editor v-if="!loading" :form="form" :form_saving="form_saving" :save_form="saveForm"></ff_form_editor>
	</div>
	<?php do_action('fluentform_after_editor_start'); ?>
</div>