<?php
/**
 *Plugin Name: Shop Locator 3.0
 */

require 'shortcode.php';

add_action('init', 'shop_locator_create_post_type');

function shop_locator_create_post_type()
{
    register_post_type('shop',
        array(
            'labels' => array(
                'name' => 'shop',
                'singular_name' => 'Shop',
            ),
            'menu_position' => 5,
            'supports' => array('title', 'editor', 'thumbnail'),
            'public' => true,
            'has_archive' => false,
        )
    );
}

add_action('add_meta_boxes', 'shop_locator_add_custom_box');

function shop_locator_add_custom_box()
{
    $screens = array('shop', 'page');
    add_meta_box('shop_meta_box',
        'Shop Address',
        'shop_locator_meta_box_callback',
        $screens,
    );
}

function shop_locator_meta_box_callback($shop, $meta)
{
    $screens = $meta['args'];

    // Используем nonce для верификации
    wp_nonce_field(plugin_basename(__FILE__), 'shop_locator');

    $longitude = get_post_meta($shop->ID, 'longitude', true);
    $width = get_post_meta($shop->ID, 'width', true);
    $address = get_post_meta($shop->ID, 'address', true);
    ?>
    <label><?= _e('Address'); ?></label>
    <input type="textarea" name="address" id="address" value="<?php echo $address; ?>"/>
    <label><?= _e('Longitude'); ?></label>
    <input type="textarea" name="longitude" id="lat" value="<?php echo $longitude; ?>"/>
    <label><?= _e('Latitude'); ?></label>
    <input type="textarea" name="width" id="lng" value="<?php echo $width; ?>"/>
    <?php
}

add_action('save_post', 'shop_locator_save_shop_data');

function shop_locator_save_shop_data($shop_id)
{
    if (!isset($_POST['longitude']) || !isset($_POST['width']) || !isset($_POST['address']))
        return;

    // Check the 'nonce' of our page in cause of save_post could be called from other place.z может быть вызван с другого места.
    if (!wp_verify_nonce($_POST['shop_locator'], plugin_basename(__FILE__)))
        return;

    // If AUTOSAVE than nothing to do.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // Check the rights of user.
    if (!current_user_can('edit_post', $shop_id))
        return;

    // All is OK. Clean the value of input.
    $longitude = sanitize_text_field($_POST['longitude']);
    $width = sanitize_text_field($_POST['width']);
    $address = sanitize_text_field($_POST['address']);

    // Update the values in db.
    update_post_meta($shop_id, 'longitude', $longitude);
    update_post_meta($shop_id, 'width', $width);
    update_post_meta($shop_id, 'address', $address);
}

add_action('wp_enqueue_scripts', 'add_scripts');

function add_scripts()
{
    wp_register_script('mapjs', plugins_url('/index.js', __FILE__), array(), '1.0.0', true);
    wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC0BecFsnL0G7qZ4PD8oxh7lgbKXAGSrvo&callback=initMap', array(), '', true);
    wp_localize_script('mapjs', 'map_data', get_shop_markers());
}

add_action('template_redirect', 'connect_single_map_script');

function connect_single_map_script()
{
    wp_register_script('single-shop-script', get_theme_file_uri('./single-shop.js'), array('jquery'), '1.0.0', true);
    wp_register_script('google-maps-shop', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC0BecFsnL0G7qZ4PD8oxh7lgbKXAGSrvo&callback=initSingleMap', array(), '', true);
}


