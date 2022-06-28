<?php

function custom_recent_posts_widget_load() {
    register_widget( 'custom_recent_posts_widget' );
}
add_action( 'widgets_init', 'custom_recent_posts_widget_load' );

class Custom_Recent_Posts_Widget extends WP_Widget
{
    function __construct() {
        parent::__construct(
            'recent_posts_widget', // Base ID
            'Custom Recent Posts Widget' // Name
        );
    }

    // It defines the look of your WordPress custom widget on the front-end.
    function widget($args, $instance) {
        ?>
        <input name="countofposts" id="countofposts" value="<?php echo $instance['countOfPosts']; ?>" readonly hidden/>
        <?php
        get_custom_recent_posts($instance['countOfPosts']);
    }

    function form($instance) {
        if( $instance) {
            $title = esc_attr($instance['title']);
            $countOfPosts = esc_attr($instance['countOfPosts']);
        } else {
            $title = '';
            $countOfPosts = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'filter_search_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('countOfPosts'); ?>"><?php _e('Number of Posts:', 'filter_search_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('countOfPosts'); ?>"  name="<?php echo $this->get_field_name('countOfPosts'); ?>" type="number" value="<?php echo $countOfPosts;?>">
        </p>
        <?php

    }

    // Will refresh the widget every time you change the settings.
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['countOfPosts'] = strip_tags($new_instance['countOfPosts']);

        return $instance;
    }
}

