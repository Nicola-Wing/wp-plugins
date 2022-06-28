<?php
/**
 * Plugin Name: Beauty Blog Custom Widgets
 */

require_once ('categories-hierarchy-widget.php');
require_once ('recent-posts-widget.php');
require_once ('custom-search-widget.php');
require_once('portfolio-tax-widget.php');


function get_categories_hierarchy($count, $hierarchy, $title)
{
    $start = '<div class="box third">
        <div class="padd16bot">
        <h1>' . __($title) . '</h1>
        <ul class="menu categories page_text">';
    $cat_list = wp_list_categories(array(
        'orderby' => 'name',
        'order' => 'asc',
        'hide_empty' => false,
        'style' => 'list',
        'show_count' => $count,
        'hierarchical' => $hierarchy,
        'title_li' => '',
        'echo' => 0,
    ));

    $cat_list = preg_replace('/<\/a> \(([0-9]+)\)/', ' (\\1)</a>', $cat_list);

    echo $start. $cat_list . '</ul></div></div>';
}

function get_custom_recent_posts($count)
{
    $recent_posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $count,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'category__not_in' => 84,
    ));
    if ($recent_posts->have_posts()) {
        echo '<div class="box second">
                <div class="padd16bot">
                    <h1>' . __("Recent Posts") . '</h1>
                        <ul class="recent_posts">';
        while ($recent_posts->have_posts()) {
            $recent_posts->the_post();
            get_template_part('template-parts/content/loop/single', 'recent-post');
            wp_reset_postdata();
        }
        echo '</ul></div></div>';
    } else {
        echo '<p>' . _e("Posts not found.") . '</p>';
    }
    ?>
    <?php
}

function get_custom_search_results(){
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $news = new WP_Query(array(
        'post_type' => array('post', 'portfolio'),
        's' => $_GET['s'],
        'posts_per_page' => 3,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
    if ($news->have_posts()) {
        while ($news->have_posts()) {
            $news->the_post();
            if (get_post_type() == 'post') {
                get_template_part('template-parts/content/loop/content', 'single');
            }
            if (get_post_type() == 'portfolio') { ?>
                <article class="article">
                    <div class="portfolio_items_container">
                        <ul class="portfolio_items columns">
                            <?php get_template_part('template-parts/content/loop/content', 'archive-portfolio'); ?>
                        </ul>
                    </div>
                </article>
                <?php
            }
        }
        cq_pagination($news->max_num_pages);
        wp_reset_postdata();
    } else {
        echo '<p>' . _e("Posts not found.") . '</p>';
    }
}

function get_cats_and_tags($cats, $tags)
{
    if($cats) {
        $cur_terms = get_the_terms( get_the_ID(), 'portfolio_cats' );
        if( is_array( $cur_terms ) ){
            foreach( $cur_terms as $cur_term ){
                echo '<a href="'. get_term_link( $cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a>, ';
            }
        }
    }
    if($tags) {
        the_tags('<br>Tags: ', ' &bull; ', '');
    }
}

function breadcrumbs(){
    ?>
    <div class="breadcrumbs">
        <div class="inside">
            <a href="<?php echo home_url(); ?>" class="first"><span><?php echo __("The Same"); ?></span></a>
            <?php
            if(!is_archive() && !is_search()) {
                echo '<a href="#" class="next"><span>' . __(get_the_title()) . '</span></a>';
            } if(is_archive() && get_post_type() != null) {
                echo '<a href="#" class="next"><span>' . __(get_post_type_object(get_post_type())->labels->singular_name) . '</span></a>';
            } if(is_search()) {
                echo '<a href="#" class="next"><span>Search</span></a>';
            }
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if($term) {
                echo '<a href="' . esc_url(get_term_link($term)) . '" class="last"><span>' . __($term->name) . '</span></a> ';
            }
            ?>

        </div>
    </div>
<?php
}

