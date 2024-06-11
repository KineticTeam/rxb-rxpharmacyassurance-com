<?php
$content_id = !empty( $content_id ) ? "id='" . $content_id . "'" : "";
$content_class = isset( $content_class ) ? $content_class : "";
?>
<div <?php echo $content_id; ?> class="ep-tab-content ep-flickity-slide <?php echo $content_class; ?>">
    <?php do_action( 'ava_ep_tab_slider_slide_before_inner', $value['attr'], $meta ); ?>
    <div class="ep-tab-content-inner">
        <?php do_action( 'ava_ep_tab_slider_slide_before_contents', $value['attr'], $meta ); ?>
        <?php if( !empty( $responsive_behavior ) && $responsive_behavior == 'toggle' ) { ?>
        <input type="radio" class="ep-tab-slider-toggle" id="ep-tab-slider-<?php echo self::$flickity_id; ?>-item-<?php echo $counter; ?>" name="ep-tab-slider-<?php echo self::$flickity_id; ?>" <?php if( $counter == 0 ) echo "checked"; ?>>
        <label class="ep-tab-title" for="ep-tab-slider-<?php echo self::$flickity_id; ?>-item-<?php echo $counter; ?>">
            <?php 
                do_action( 'ava_ep_tab_slider_slide_before_title', $value['attr'], $meta );
                echo $title;
                if( $subtitle ) echo "<div class='ep-tab-subtitle'>" . $subtitle . "</div>";
                do_action( 'ava_ep_tab_slider_slide_after_title', $value['attr'], $meta );
            ?>
        </label>
        <?php } else { ?>
        <div class="ep-tab-title">
            <?php 
                do_action( 'ava_ep_tab_slider_slide_before_title', $value['attr'], $meta );
                echo $title;
                if( $subtitle ) echo "<div class='ep-tab-subtitle'>" . $subtitle . "</div>";
                do_action( 'ava_ep_tab_slider_slide_after_title', $value['attr'], $meta );
            ?>
        </div>
        <?php } ?>
        <div class="ep-tab-content-content">
            <?php do_action( 'ava_ep_tab_slider_slide_before_content', $value['attr'], $meta ); ?>
            <?php if( !empty( $id ) ) { ?>
                <?php do_action( 'ava_ep_tab_slider_slide_before_image', $value['attr'], $meta ); ?>
                <div class='ep-flickity-image'>
                    <?php echo EnfoldPlusHelpers::get_responsive_image( $value['attr'], array( 
                        "desktop" => "id", 
                        "tablet" => "id_tablet", 
                        "mobile" => "id_mobile" 
                    ), ( $counter == 0 ? false : $flickity_lazy_load ) ); ?>
                </div>
                <?php do_action( 'ava_ep_tab_slider_slide_after_image', $value['attr'], $meta ); ?>
            <?php } ?>
            <div class="ep-tab-content-content-inner">
                <?php do_action( 'ava_ep_tab_slider_slide_before_inner_content', $value['attr'], $meta ); ?>
                <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $value['content'] ) ); ?>
                <?php do_action( 'ava_ep_tab_slider_slide_after_inner_content', $value['attr'], $meta ); ?>
            </div>
            <?php do_action( 'ava_ep_tab_slider_slide_after_content', $value['attr'], $meta ); ?>
        </div>     
        <?php do_action( 'ava_ep_tab_slider_slide_after_contents', $value['attr'], $meta ); ?>                                  
    </div>
    <?php do_action( 'ava_ep_tab_slider_slide_after_inner', $value['attr'], $meta ); ?>
</div>