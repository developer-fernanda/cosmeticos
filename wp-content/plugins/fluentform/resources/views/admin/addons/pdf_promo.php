<div class="add_on_modules">
    <div style="margin-bottom: 0px" class="modules_header">
        <div class="module_title">
            Fluent Forms PDF Modules
        </div>
        <p>
            Generate PDF from your form submissions. You can create PDF templates and download / send via email too.
        </p>
    </div>
    <div style="padding: 45px 20px;display: block;" class="modules_body">
        <?php if(!$is_installed): ?>
        <div style="text-align: center" class="install_wrapper">
            <h2>PDF Module is not installed yet. Please install now (it's free)</h2>
            <a class="button-primary" href="<?php echo $install_url; ?>">Install Fluent Forms PDF Addon</a>
        </div>
        <?php else:
            do_action('fluentform_addons_page_render_fluentform_pdf_settings');
        endif; ?>

    </div>
</div>
