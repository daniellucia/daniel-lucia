<?php


class Hero_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'hero_widget',
            'Hero Widget',
            array('description' => 'Hero Widget')
        );
    }

    public function widget($args, $instance)
    {

        $title = !empty($instance['title']) ? $instance['title'] : '';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : '';

        echo $args['before_widget'];
        
        echo '<h2>' . esc_html($subtitle) . '</h2>';
        echo '<h1>' . esc_html($title) . '</h1>';
        
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('subtitle'); ?>">Subtítulo:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['subtitle'] = (!empty($new_instance['subtitle'])) ? strip_tags($new_instance['subtitle']) : '';
        return $instance;
    }
}

function register_hero_widget()
{
    register_widget('Hero_Widget');
}

add_action('widgets_init', 'register_hero_widget');
