<?php
$control_id = !empty( $control_id ) ? "id='" . $control_id . "'" : "";
$control_class = isset( $control_class ) ? $control_class : "";
?>
<div <?php echo $control_id; ?> class="ep-tab-control ep-flickity-slide <?php echo $control_class; ?>">
	<?php do_action( 'ava_ep_tab_slider_control_before_inner', $value['attr'], $meta ); ?>
	<div class="ep-tab-control-inner">
		<?php do_action( 'ava_ep_tab_slider_control_before_title', $value['attr'], $meta ); ?>
		<?php 
			echo $title; 
			if( $subtitle ) echo "<div class='ep-tab-subtitle'>" . $subtitle . "</div>";
		?>
		<?php do_action( 'ava_ep_tab_slider_control_after_title', $value['attr'], $meta ); ?>
	</div>
	<?php do_action( 'ava_ep_tab_slider_control_after_inner', $value['attr'], $meta ); ?>
</div>