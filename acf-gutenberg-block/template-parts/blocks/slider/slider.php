<?php

/**
 * Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'wrapper';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if( have_rows('slides') ): ?>
    <div id="top_slide" class="flexslider">
        <ul class="slides">
            <?php while( have_rows('slides') ){
                the_row();
                $image = get_sub_field('image');
                $title = get_sub_field('title');
                $desc = get_sub_field('description');
                ?>
                <li>
                    <!--<div>-->
                        <?php echo wp_get_attachment_image( $image['id'], 'full' ); ?>
                    <!--</div>-->
                    <p class="flex-caption">
                        <strong><?php echo __($title); ?></strong>
                        <span><?php echo __($desc); ?></span>
                    </p>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <?php else: ?>
        <p>Please add some slides.</p>
    <?php endif; ?>
</div>