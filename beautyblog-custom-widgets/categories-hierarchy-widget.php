<?php

function show_categories_hierarchical_widget_load() {
    register_widget( 'show_categories_hierarchical_widget' );
}
add_action( 'widgets_init', 'show_categories_hierarchical_widget_load' );

class Show_Categories_Hierarchical_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'show_categories_hierarchical_widget',
            'description'                 => __( 'A list of categories.' ),
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        );
        parent::__construct( 'show_categories_hierarchical_widget', __( 'Show_Categories_Hierarchical_Widget' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Categories widget instance.
     */
    public function widget( $args, $instance ) {

        $default_title = __( 'Categories' );
        $title         = ! empty( $instance['title'] ) ? $instance['title'] : $default_title;

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $count        = ! empty( $instance['count'] ) ? '1' : '0';
        $hierarchical = ! empty( $instance['hierarchical'] ) ? '1' : '0';

        echo $args['before_widget'];
        get_categories_hierarchy($count, $hierarchical, $title);
        echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Categories widget instance.
     */
    public function update( $new_instance, $old_instance ) {
        $instance                 = $old_instance;
        $instance['title']        = sanitize_text_field( $new_instance['title'] );
        $instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
        $instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;

        return $instance;
    }

    /**
     * Outputs the settings form for the Categories widget.
     */
    public function form( $instance ) {
        // Defaults.
        $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts' ); ?></label>
            <br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( 'Show hierarchy' ); ?></label>
        </p>
        <?php
    }

}
