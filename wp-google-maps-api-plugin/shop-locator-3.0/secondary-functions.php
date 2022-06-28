<?php

function get_shop_markers(): array
{
    $zoom = 6;

    $map_data = array(
        'markers' => array(),
        'center' => array(47.9854715, 22.2083201),
        'zoom' => $zoom,
    );
    $lats = array();
    $longs = array();

    $map_query = new WP_Query(array('post_type' => 'shop', 'posts_per_page' => -1,));

    if ($map_query->have_posts()) {
        while ($map_query->have_posts()) : $map_query->the_post();
            $meta_coords = get_post_meta(get_the_ID(), 'longitude', true) . ',' . get_post_meta(get_the_ID(), 'width', true);
            if ($meta_coords) {
                $coords = array_map('floatval', array_map('trim', explode(",", $meta_coords)));
                $title = get_the_title();
                $link = sprintf('<a href="%s">%s</a>', get_permalink(), $title);
                $map_data['markers'][] = array(
                    'latlang' => $coords,
                    'title' => $title,
                    'desc' => '<h3 class="marker-title">' . $link . '</h3><div class="marker-desc">' . get_the_excerpt() . '<br><p>' . get_post_meta(get_the_ID(), 'address', true) . '</p></div>',
                );
                $lats[] = $coords[0];
                $longs[] = $coords[1];
            }
        endwhile;
        // Auto calc map center.
        if (!empty($lats)) {
            $map_data['center'] = array(
                (max($lats) + min($lats)) / 2,
                (max($longs) + min($longs)) / 2
            );
        }
    }

    wp_reset_postdata();

    return $map_data;
}