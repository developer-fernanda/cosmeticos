<?php

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;

class MenuProvider extends Provider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function booting()
    {
        $this->app->addAction(
            'admin_menu',
            '\FluentForm\App\Modules\Registerer\Menu@register'
        );

        $this->app->addAction(
            'fluentform_global_settings_component_settings',
            '\FluentForm\App\Modules\Renderer\GlobalSettings\Settings@render'
        );

        $this->app->addAction(
            'fluentform_global_settings_component_reCaptcha',
            '\FluentForm\App\Modules\Renderer\GlobalSettings\Settings@render'
        );

        $this->app->addAction(
            'fluentform_global_settings_component_hCaptcha',
            '\FluentForm\App\Modules\Renderer\GlobalSettings\Settings@render'
        );

        $this->app->addAction(
            'ff_fluentform_form_application_view_editor',
            '\FluentForm\App\Modules\Registerer\Menu@renderEditor'
        );

        $this->app->addAction(
            'ff_fluentform_form_application_view_settings',
            '\FluentForm\App\Modules\Registerer\Menu@renderSettings'
        );

        $this->app->addAction(
            'fluentform_form_settings_container_form_settings',
            '\FluentForm\App\Modules\Registerer\Menu@renderFormSettings'
        );
    }
}
