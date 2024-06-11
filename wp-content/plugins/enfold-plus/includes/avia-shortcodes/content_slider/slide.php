<div <?php echo $item_id; ?> class='<?php echo $this->column_class; ?> <?php echo $slide_classes; ?> <?php echo $custom_class; ?>'>
	<div class="ep-flickity-slide-inner">
		<?php echo $link_before; ?>
		<?php do_action( 'ava_ep_content_slider_slide_before', $atts, $this->el_meta ); ?>
		<?php if( !empty( $src ) ) { ?><div class='ep-flickity-image'><?php echo EnfoldPlusHelpers::get_responsive_image( $atts, array( "desktop" => "src", "tablet" => "src_tablet", "mobile" => "src_mobile" ), ( $this->item_index == 1 ? false : $this->flickity_lazy_load ) ); ?></div><?php } ?>
		<?php if( !empty( $subtitle ) || !empty( $title ) || !empty( $content ) ) { ?>
		<div class='ep-flickity-content'>
			<?php if( !empty( $subtitle ) ) { ?>
				<div class='ep-flickity-subtitle'><?php echo $subtitle; ?></div>
			<?php } ?>
			<?php if( !empty( $title ) ) { ?><h4 class="ep-flickity-title"><?php echo $title; ?></h4><?php } ?>
			<?php if( !empty( $content ) ) { ?>
				<div class='ep-flickity-inner-content'>
					<?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) ); ?>
				</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php do_action( 'ava_ep_content_slider_slide_after', $atts, $this->el_meta ); ?>
		<?php echo $link_after; ?>
	</div>
</div>