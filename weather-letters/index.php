<?php
/**
 * Plugin Name: Sending emails every 3 days
 */

register_activation_hook(__FILE__, 'my_activation');
function my_activation() {
    wp_clear_scheduled_hook( 'scheduled_weather_event' );
    wp_schedule_event( time(), 'three_days', 'scheduled_weather_event');
}

if( defined('DOING_CRON') && DOING_CRON ){

    add_action('scheduled_weather_event', 'do_this_every_min');

    function do_this_every_min() {
        $response = get_transient( 'weather_info' );
        if( false === $response ) {
            // Transient expired, refresh the data.
            $get_weather = wp_remote_get('https://api.openweathermap.org/data/2.5/weather?q=Alaska,usa&APPID=6e4e575972857d0de96943b833df597a');
            set_transient ('weather_info', $get_weather, 12 * 60 * 60); // For test - 5
            $response = get_transient( 'weather_info' );
        }

        if( is_wp_error( $response ) ) {
            return false;
        }
        $json = wp_remote_retrieve_body( $response );
        $data = json_decode( $json, true );
        $out = '';
        if( ! empty( $data ) ) {
            $out .= 'The weather in <span>'. $data['name'] . '</span> is:';
            $out .= '<ul>';
            $out .= '<li>Temperature: <span>' . round(doubleval($data['main']['temp']) - doubleval(273.15)) . ' &deg;C</span></li>';
            $out .= '<li>Humidity: <span>'. $data['main']['humidity'] . ' % </span></li>';
            $out .= '</ul>';
        }
        wp_mail('colahola111@gmail.com','Weather forecast', $out );
        remove_filter( 'wp_mail_content_type','change_mail_content_type' );
    }
}

register_deactivation_hook( __FILE__, 'my_deactivation');
function my_deactivation() {
    wp_clear_scheduled_hook('scheduled_weather_event');
}

// Registering interval
add_filter( 'cron_schedules', 'cron_add_three_days' );
function cron_add_three_days( $schedules ) {
    $schedules['three_days'] = array(
        /*'interval' => 10,*/ // For test
        'interval' => 60 * 60 * 24 * 3,
        'display' => 'Every 3 days'
    );
    return $schedules;
}

function change_mail_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','change_mail_content_type' );
