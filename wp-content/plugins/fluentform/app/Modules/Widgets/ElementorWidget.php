<?php

namespace FluentForm\App\Modules\Widgets;
use Elementor\Plugin as Elementor;
use FluentForm\App\Modules\Widgets\FluentFormWidget;

class ElementorWidget
{
    private $app = null;

    public function __construct($app)
    {
        $this->app = $app;
        add_action( 'elementor/widgets/widgets_registered', array($this, 'init_widgets') );
    }


    public function init_widgets()
    {
        $this->enqueueAssets();

        $widgets_manager = Elementor::instance()->widgets_manager;

        if ( file_exists( FLUENTFORM_DIR_PATH.'app/Modules/Widgets/FluentFormWidget.php' ) ) {
            require_once FLUENTFORM_DIR_PATH.'app/Modules/Widgets/FluentFormWidget.php';
            $widgets_manager->register_widget_type( new FluentFormWidget() );
        }
    }


    public function enqueueAssets()
    {
        wp_enqueue_style('fluentform-elementor-widget', $this->app->publicUrl('css/fluent-forms-elementor-widget.css'), array(), FLUENTFORM_VERSION );
    }

    public static function getForms()
    {
        $ff_list = wpFluent()->table('fluentform_forms')
            ->select(['id', 'title'])
            ->orderBy('id', 'DESC')
            ->get();


        $forms = array();

        if ($ff_list) {
            $forms[0] = esc_html__('Select a Fluent Form', 'fluentform');
            foreach ($ff_list as $form) {
                $forms[$form->id] = $form->title .' ('.$form->id.')';
            }
        } else {
            $forms[0] = esc_html__('Create a Form First', 'fluentform');
        }

        return $forms;

    }


}
