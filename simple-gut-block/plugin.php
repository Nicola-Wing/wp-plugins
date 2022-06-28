<?php

/**
 * Plugin Name: Colorful Message Box  Plugin
 */

function loadColMessBlock() {
    wp_enqueue_script(
        'colorful-message-block',
        plugin_dir_url(__FILE__) . 'col-block.js',
        array('wp-blocks','wp-editor'),
        true
    );
}

add_action('enqueue_block_editor_assets', 'loadColMessBlock');