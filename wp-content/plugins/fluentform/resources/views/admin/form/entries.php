<div class="ff_form_entries" id="ff_form_entries_app">
    <router-view
        :form_id="<?php echo $form_id; ?>"
        :has_pdf="<?php echo $has_pdf; ?>"
    />
</div>
