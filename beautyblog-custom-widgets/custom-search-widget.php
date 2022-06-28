<?php

function custom_search_widget_load() {
    register_widget( 'custom_search_widget' );
}
add_action( 'widgets_init', 'custom_search_widget_load' );

class Custom_Search_Widget extends WP_Widget
{
    function __construct() {
        parent::__construct(
            'custom_search_widget', // Base ID
            'Custom Search Widget' // Name
        );
    }

    // It defines the look of your widget on the front-end.
    function widget($args, $instance) {
        ?>
        <div class="padd16bot">
            <h1><?php _e(esc_attr($instance['title'])); ?></h1>
            <form class="searchbar search-form" role="search" method="get" action="<?php get_template_directory_uri();?>/">
                <fieldset>
                    <div>
                        <span class="input_text screen-reader-text"><input type="text" name="s" class="clearinput search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query(); ?>"/></span>
                        <button type="submit" class="input_submit search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>"><span>Search</span></button>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php
    }

    function form($instance) {
        if( $instance) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'filter_search_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php

    }

    // Will refresh the widget every time you change the settings.
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }
}

