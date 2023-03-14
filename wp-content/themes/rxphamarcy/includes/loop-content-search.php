<?php 

$link_data = enfold_child_custom_link( $post_id );
$permalink = $link_data['link'];
$link_attr = $link_data['attrs'];

$post_id = get_the_ID();
$title = get_the_title( $post_id );
$post_type = get_post_type( $post_id );
$post_content = get_the_excerpt( $post_id ) ? avia_backend_truncate( get_the_excerpt( $post_id ), 120, " ", "...", true) : avia_backend_truncate( strip_tags( get_post_field( 'post_content', $post_id ) ), 120, " ", "...", true );

?>

<div class="entry-search entry-<?php echo $post_id; ?> <?php echo $column_class; ?> ">
  <div class="entry-wrapper-inner">
    <h6 class='entry-type'><?php echo str_replace( '_', ' ', $post_type ) ?></h6>
    <h4 class="entry-title"><a href="<?php echo $permalink ?>" <?php echo $link_attr; ?>><?php echo $title; ?></a></h4>
    <div class="entry-content">
        <?php echo $post_content; ?>
    </div>
    <a href="<?php echo $permalink ?>" <?php echo $link_attr; ?> class="avia-button avia-color-primary-borderless">Read More</a>
  </div>
</div>