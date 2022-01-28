<?php

namespace FluentForm\App\Modules\Widgets;

class SidebarWidgets extends \WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'fluentform_widget',
            esc_html__('WP Fluent Forms Widget', 'fluentform'),
            array('description' => esc_html__('Add your form by WP Fluent Forms', 'fluentform'),)
        );
    }

    public function widget($args, $instance)
    {
        $selectedForm = empty($instance['allforms']) ? '' : intval($instance['allforms']);

        if(!$selectedForm) {
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        if ($selectedForm != '') {
            $shortcode = "[fluentform id='$selectedForm']";
            echo do_shortcode($shortcode);
        }

        echo $args['after_widget'];

    }

    public function form($instance)
    {
        $selectedForm = empty($instance['allforms']) ? '' : $instance['allforms'];
       
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'fluentform');
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <?php
        $forms = wpFluent()->table('fluentform_forms')
            ->select(array('id', 'title'))
            ->orderBy('id', 'DESC')
            ->get();
        ?>
        
        <label for="<?php echo $this->get_field_id('allforms'); ?>">Select a form:
            <select style="margin-bottom: 12px;" class='widefat' id="<?php echo $this->get_field_id('allforms'); ?>"
                    name="<?php echo $this->get_field_name('allforms'); ?>" type="text"
            >
                <?php
                foreach ($forms as $item) {
                    ?>
                    <option <?php if ($item->id == $selectedForm) {
                        echo 'selected';
                    } ?> value='<?php echo $item->id; ?>'>
                        <?php echo $item->title; ?> (<?php echo $item->id; ?>)
                    </option>
                    <?php
                }
                ?>
            </select>
        </label>
            <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['allforms'] = intval($new_instance['allforms']);
        return $instance;
    }
}
