<?php
// Register a slider block.
add_action('acf/init', 'slider_register_blocks');
function slider_register_blocks() {

    // check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'slider',
            'title'             => __('Slider'),
            'description'       => __('A custom slider block.'),
            'render_template'   => 'template-parts/blocks/slider/slider.php',
            'category'          => 'formatting',
            'icon' 				=> 'images-alt2',
            'keywords'			=> array( 'slider', 'custom', 'block' ),
            'mode'              => 'auto',
            'align'				=> 'full',
            'enqueue_assets' 	=> function(){
                wp_enqueue_script( 'block-slider', get_template_directory_uri() . '/template-parts/blocks/slider/slider.js', array(), '1.0.0', true );
            },
        ));
    }
}