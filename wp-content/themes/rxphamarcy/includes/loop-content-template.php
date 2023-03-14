<?php
/* this is a template for a Post type that would require a custom coded template, this is usable only on Posts Grids */
?>
<div class="ep-item-grid-item ep-posts-grid-item <?php echo $column_class; ?> <?php echo $item_classes; ?> entry entry-<?php echo $post_id; ?> entry-<?php echo get_post_type( $post_id ); ?>" <?php echo $item_style_tag; ?>>
    <div class="ep-item-grid-item-inner column-inner">
        <?php echo $link_before; ?>
        <div class="ep-item-grid-item-media">
            <div class="ep-item-grid-image">
                <?php echo $inner_link_before; ?>
                    <?php echo get_the_post_thumbnail( $post_id ); ?>
                <?php echo $inner_link_after; ?>
            </div>
        </div>
        <div class="ep-item-grid-content-wrapper">
            <?php if( $post_terms ) { ?>
            <div class="ep-item-grid-item-terms">
                <?Php echo $post_terms; ?>
            </div>
            <?php } ?>
            <div class="ep-item-grid-item-date">
                <?php echo $post_date; ?>
            </div>
            <<?php echo $heading_type; ?> class="ep-item-grid-item-title" <?php echo $heading_style; ?>>
                <?php echo $inner_link_before; ?>
                    <?php echo get_the_title( $post_id ); ?>
                <?php echo $inner_link_after; ?>
            </<?php echo $heading_type; ?>>
            <div class="ep-item-grid-item-content">
                <?php echo $post_content; ?>
            </div>
            <?php if( !empty( $button_link ) ) { ?>
                <div class="ep-item-grid-item-button-wrapper">
                    <a href="<?php echo $permalink; ?>" <?php echo $link_attrs; ?> class="avia-button avia-color-<?php echo $button_color; ?> avia-size-medium"><?php echo $link_label; ?></a>
                </div>
            <?php } ?>
        </div>
        <?php echo $link_after; ?>
    </div>
</div>
