<div class="<?php echo $item_classes; ?>" <?php echo $item_style_tag; ?>>
    <div class="ep-item-grid-item-inner <?php echo $column_class_inner; ?>">
        <?php echo $link_before; ?>
        <?php do_action( 'ava_ep_post_grid_post_item_before', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
        <?php if( empty( $disable_image ) && $post_image ) { ?>
        <div class="ep-item-grid-item-media">
            <div class="ep-item-grid-image">
                <?php echo $inner_link_before; ?>
                    <?php echo $post_image; ?>
                <?php echo $inner_link_after; ?>
            </div>
        </div>
        <?php } ?>
        <div class="ep-item-grid-content-wrapper">
            <?php do_action( 'ava_ep_post_grid_post_item_inner_before', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>

            <?php if( empty( $disable_tax ) && $post_terms ) { ?>
            <div class="ep-item-grid-item-terms">
                <?php echo $post_terms; ?>
            </div>
            <?php } ?>

            <?php do_action( 'ava_ep_post_grid_post_space_1', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>

            <?php if( empty( $disable_date ) ) { ?>
            <div class="ep-item-grid-item-date">
                <?php echo $post_date; ?>
            </div>
            <?php } ?>

            <?php do_action( 'ava_ep_post_grid_post_space_2', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>

            <?php if( empty( $disable_title ) ) { ?>
            <div class="ep-item-grid-item-title-wrapper">
            <?php do_action( 'ava_ep_post_grid_post_title_before', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
            <<?php echo $heading_type; ?> class="ep-item-grid-item-title" <?php echo $heading_style; ?>>
                <?php echo $inner_link_before; ?>
                    <?php echo $post_title; ?>
                <?php echo $inner_link_after; ?>
            </<?php echo $heading_type; ?>>
            <?php do_action( 'ava_ep_post_grid_post_title_after', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
            </div>
            <?php } ?>

            <?php do_action( 'ava_ep_post_grid_post_space_3', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>

            <?php if( empty( $disable_content ) ) { ?>
            <div class="ep-item-grid-item-content">
                <?php do_action( 'ava_ep_post_grid_post_content_before', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
                <?php echo $post_content; ?>
                <?php do_action( 'ava_ep_post_grid_post_content_after', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
            </div>
            <?php } ?>

            <?php do_action( 'ava_ep_post_grid_post_space_4', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>

            <?php if( empty( $disable_button ) && empty( $disable_link ) && ! empty( $button_link ) ) { ?>
                <div class="ep-item-grid-item-button-wrapper">
                    <?php do_action( 'ava_ep_post_grid_post_button_before', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
                    <a href="<?php echo $permalink; ?>" <?php echo $link_attrs; ?> class="avia-button avia-color-<?php echo apply_filters( 'avf_ep_post_grid_post_item_button_color', $button_color, $post_type_slug, $post_id, $this->meta, $this->atts ); ?> avia-size-medium">
                        <span class="avia_iconbox_title"><?php echo apply_filters( 'avf_ep_post_grid_post_item_link_label', $link_label, $post_type_slug, $post_id, $this->meta, $this->atts ); ?></span>
                    </a>
                    <?php do_action( 'ava_ep_post_grid_post_button_after', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
                </div>
            <?php } ?>
            
            <?php do_action( 'ava_ep_post_grid_post_item_inner_after', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
        </div>
        <?php do_action( 'ava_ep_post_grid_post_item_after', $post_type_slug, $post_id, $this->meta, $this->atts ); ?>
        <?php echo $link_after; ?>
    </div>
</div>
