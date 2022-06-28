<?php
/**
 * Template Name: For shop
 * Template Post Type: shop
 */

wp_enqueue_script('single-shop-script');
wp_enqueue_script('google-maps-shop');

get_header();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            global $post;
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content/content', 'single');
                ?>
                <input id="lat" value="<?= get_post_meta($post->ID, 'longitude', true); ?>" hidden/>
                <input id="lng" value="<?= get_post_meta($post->ID, 'width', true); ?>" hidden/>
                <input id="address" value="<?= get_post_meta($post->ID, 'address', true); ?>" hidden/>
                <input id="title" value="<?= get_the_title(); ?>" hidden/>
                <input id="content" value="<?= get_the_content(); ?>" hidden/>
                <?php
                echo '<div id="shop" style="height: 100vh;"></div>';
            endwhile;
            ?>
        </main>
    </div>
<?php
get_footer();