<?php

class Latest_WooCommerce_Products_Widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'latest_woocommerce_products_widget',
            'Últimos Productos de WooCommerce',
            array('description' => 'Muestra una lista de los productos más recientes de WooCommerce.')
        );
    }

    public function widget($args_widgets, $instance)
    {

        if (!(bool)get_theme_mod('active_shop')) {
            return;
        }
        
        $title = !empty($instance['title']) ? $instance['title'] : 'Últimos Productos';
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 3;


        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $products = new WP_Query($args);

        if ($products->have_posts()) {

            echo $args_widgets['before_widget'];
            echo $args_widgets['before_title'] . esc_html($title) . $args_widgets['after_title'];
            echo '<ul>';
            while ($products->have_posts()) {
                $products->the_post();

                $product = wc_get_product(get_the_ID());
                echo '<li>';
                echo $product->get_image(array(56, 56));
                echo '<div>';
                echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                echo '<p>'.$product->get_short_description().'</p>';
                echo '<p><a href="' . get_permalink() . '" class="button-link">' . __('Ver plugin', 'daniel-lucia') . '</a></p>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ul>';
            wp_reset_postdata();

            echo $args_widgets['after_widget'];
        }
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : 'Últimos Productos';
        $limit = isset($instance['limit']) ? absint($instance['limit']) : 3;
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">Límite de Productos:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $limit; ?>">
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : 'Últimos Productos';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 3;
        return $instance;
    }
}

function register_latest_woocommerce_products_widget()
{
    register_widget('Latest_WooCommerce_Products_Widget');
}

add_action('widgets_init', 'register_latest_woocommerce_products_widget');
