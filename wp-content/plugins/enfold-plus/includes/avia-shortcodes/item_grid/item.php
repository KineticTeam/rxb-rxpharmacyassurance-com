<?php
$content = ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) );
$button_color = ! empty( $button_color ) ? $button_color : "theme-color";
?>
<div <?php echo $item_id; ?> class='ep-item-grid-item <?php echo $this->column_class; ?> <?php echo $item_classes; ?> <?php echo $custom_class; ?>' <?php echo $item_style_tag; ?>>
	<div class='ep-item-grid-item-inner <?php echo $this->column_class_inner; ?>'>
		<?php echo $link_before; ?>
		<?php do_action( 'ava_ep_item_grid_item_before', $atts, $this->el_meta ); ?>
			<?php if( !empty( $item_media ) ) { ?>
			<div class="ep-item-grid-item-media">
				<?php echo $item_media; ?>
			</div>
			<?php } ?>
			<?php if( !empty( $title ) || !empty( $subtitle ) || !empty( $content ) ) { ?>
			<div class="ep-item-grid-content-wrapper">
				<?php do_action( 'ava_ep_item_grid_post_item_inner_before', $atts, $this->el_meta ); ?>
				<div class="ep-item-grid-item-title-wrapper">
				<?php do_action( 'ava_ep_item_grid_post_title_before', $atts, $this->el_meta ); ?>
				<?php if( !empty( $subtitle ) ) { ?>
					<div class="ep-item-grid-item-subtitle"><?php echo $subtitle; ?></div>
				<?php } ?>
				<?php if( !empty( $title ) ) { ?>
					<<?php echo $heading_type; ?> class="ep-item-grid-item-title" <?php echo $heading_style; ?>>
						<?php echo $inner_link_before; ?>
							<?php echo $title; ?>
						<?php echo $inner_link_after; ?>
					</<?php echo $heading_type; ?>>
				<?php } ?>
				<?php do_action( 'ava_ep_item_grid_post_title_after', $atts, $this->el_meta ); ?>
				</div>
				<?php if( !empty( $content ) ) { ?>
					<div class='ep-item-grid-item-content'>
						<?php echo $content; ?>
					</div>
				<?php } ?>
				<?php if( !empty( $button_link ) ) { ?>
					<div class="ep-item-grid-item-button-wrapper">
						<?php do_action( 'ava_ep_item_grid_post_button_before', $atts, $this->el_meta ); ?>
						<a href="<?php echo AviaHelper::get_url( $link ); ?>" <?php echo $blank; ?> class="avia-button avia-color-<?php echo $button_color; ?> avia-size-medium">
							<span class="avia_iconbox_title"><?php echo $link_label; ?></span>
						</a>
						<?php do_action( 'ava_ep_item_grid_post_button_after', $atts, $this->el_meta ); ?>
					</div>
				<?php } ?>
				<?php do_action( 'ava_ep_item_grid_post_item_inner_after', $atts, $this->el_meta ); ?>
			</div>
			<?php } ?>
		<?php do_action( 'ava_ep_item_grid_item_after', $atts, $this->el_meta ); ?>
		<?php echo $link_after; ?>
	</div>
</div>