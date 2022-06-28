<?php

require('secondary-functions.php');

function my_shop_locator_show_map()
{
    wp_enqueue_script('mapjs');
    wp_enqueue_script('google-maps');
    return '<div id="map" style="height: 100vh; width: 100%;"></div>';
}

add_shortcode('show_map', 'my_shop_locator_show_map');