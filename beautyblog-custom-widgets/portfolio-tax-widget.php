<?php

function portfolio_tax_widget_load()
{
    register_widget('portfolio_tax_widget');
}

add_action('widgets_init', 'portfolio_tax_widget_load');

class Portfolio_Tax_Widget extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'portfolio_tax_widget',
            'description' => __('A list of portfolio categories and tags.'),
            'customize_selective_refresh' => true,
            'show_instance_in_rest' => true,
        );
        parent::__construct('portfolio_tax_widget', __('Portfolio Taxonomy Widget'), $widget_ops);
    }

    public function widget($args, $instance)
    {

        $categories = !empty($instance['categories']) ? '1' : '0';
        $tags = !empty($instance['tags']) ? '1' : '0';

        echo $args['before_widget'];
        get_cats_and_tags($categories, $tags);
        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['categories'] = !empty($new_instance['categories']) ? 1 : 0;
        $instance['tags'] = !empty($new_instance['tags']) ? 1 : 0;

        return $instance;
    }

    public function form($instance)
    {
        $categories = isset($instance['categories']) ? (bool)$instance['categories'] : false;
        $tags = isset($instance['tags']) ? (bool)$instance['tags'] : false;
        ?>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('categories'); ?>"
                   name="<?php echo $this->get_field_name('categories'); ?>"<?php checked($categories); ?> />
            <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Show categories'); ?></label>
            <br/>

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('tags'); ?>"
                   name="<?php echo $this->get_field_name('tags'); ?>"<?php checked($tags); ?> />
            <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Show tags'); ?></label>
        </p>
        <?php
    }

}
