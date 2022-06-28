<?php
/**
 * Template Name: For maps
 */

get_header();


?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php

            global $post;

            $shops = new WP_Query();
            $shops->query('post_type=shop');

            if ($shops->found_posts > 0) {
                $listItem = '<ul>';
                while ($shops->have_posts()) {
                    $shops->the_post();
                    $listItem .= '<li><a href="' . get_permalink() . '">';
                    $listItem .= get_the_title() . '</a></li>';
                }
                $listItem .= '</ul>';
                echo $listItem;
                wp_reset_postdata();
            }
            echo '<br>';
            echo do_shortcode('[show_map]');

            ?>

        </main>
    </div>
<?php
get_footer();
