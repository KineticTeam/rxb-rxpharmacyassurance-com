<?php

if ( !defined('ABSPATH') ){ die(); }
	
global $avia_config;

get_header();

do_action( 'ava_after_main_title' );

if( have_posts() ) :
	while( have_posts() ) : the_post();

        $post_id = $post->ID;
        $post_title =  get_the_title();
		$hide_featured = get_field( 'hide_featured_image', $post_id );
		$has_thumb = has_post_thumbnail( $post_id );
		//$post_date = get_the_date( get_option( 'date_format' ), $post_id );
		$post_date = enfold_child_format_date( $post_id, get_the_date( get_option( 'date_format' ), $post_id ) );
		$post_type = get_post_type( $post_id );
		$hero_thumb = wp_get_attachment_url( 314 );
		$is_featured = get_field( 'is_featured' , $post_id );
		$taxonomy = '';
		$go_back = '';
		$has_thumb_class = '';

		if( $has_thumb ){
			if( !($hide_featured) ){
				$has_thumb_class = 'has-thumb';
			}
		}

		if( $post_type == 'post' ){

			$taxonomy = 'category';
			$go_back = get_permalink( 498 );

		}else if( $post_type == 'resources' ){

			$taxonomy = 'resource_type';
			
			if( has_term( 'video', 'resource_type', $post_id )){

				$go_back = get_permalink( 1043 );

			}else if( has_term( 'download', 'resource_type', $post_id )){
                
                $go_back = get_permalink( 1059 );

            }

		}else if( $post_type == 'news-press' ){

			$taxonomy = 'news_and_press_type';
			$go_back = get_permalink( 480 );

		}
	
		$terms = get_the_terms( $post_id, $taxonomy );
		$term = !empty( $terms ) ? $terms[0]->name : '';
		$slug = !empty( $terms ) ? $terms[0]->slug : '';

		if ( $post_type == 'news-press'){

			$term = 'News';

		}

		if( $post_type == 'webinar'){
			$term = 'Webinar';
		}
		

?>
    <div class="main" class="all_colors">
        <div class="single-hero-section avia-section main_color avia-no-border-styling avia-full-contain avia-builder-el-0  el_before_av_section avia-builder-el-first container_wrap fullsize single-<?php echo $slug; ?>-hero <?php echo $has_thumb_class ?>" style="background-image: url('<?php echo $hero_thumb; ?>')">
            <div class='container single-partner-container'>
                <div class='content'>
                    <div class="entry-content-wrapper">
						<div class="single-meta">
							<span class="single-date"><?php echo $post_date; ?></span>
							<span class="single-term"><?php if( $is_featured ){ ?> Featured <?php } ?><?php echo $term; ?></span>
						</div>
                        <h1 class="single-post-title"><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-content-section avia-section avia-no-border-styling container_wrap main_color single-<?php echo $slug; ?>-section <?php echo $has_thumb_class ?>">
            <div class="container">
                <div class="content">
                    <div class="entry-content-wrapper">
						<?php if( $has_thumb ){
							if( !($hide_featured) ){ ?>
								<div class="single-thumb-wrapper">
									<div class="single-thumb">
										<?php the_post_thumbnail() ?>
									</div>
								</div>
							<?php }
						} ?>
						<?php the_content(); ?>
						<div class="single-footer-buttons">
							<div class="single-back-button">
								<a href="<?php echo $go_back; ?>">Back to <?php echo $term; ?></a>
							</div>
							<div class="single-social-share">
							<?php echo do_shortcode("[av_social_share title='Share this entry' buttons='' btn_action='' yelp_link='' facebook_profile='' twitter_profile='' whatsapp_profile='' pinterest_profile='' reddit_profile='' linkedin_profile='' tumblr_profile='' vk_profile='' mail_profile='' yelp_profile='' five_100_px_profile='' behance_profile='' dribbble_profile='' flickr_profile='' instagram_profile='' skype_profile='' soundcloud_profile='' vimeo_profile='' xing_profile='' youtube_profile='' style='' alignment='' alb_description='' id='' custom_class='' template_class='' av_uid='' sc_version='1.0' admin_preview_bg='']"); ?>
							</div>
						</div>
						<?php if( has_term( "", "post_author", $post_id )){ ?>
							<div class="post-authors">
								<?php foreach( get_the_terms( $post_id, "post_author") as $author ) {  // $authors nunca es declarado
									$author_id = $author->term_id;
									$image = get_field( 'image', "post_author_{$author_id}" );
									$title = get_field( 'title', "post_author_{$author_id}" );
								?>
								<div class="single-post-author">
									<?php if (!empty( $image ) ) {  ?>
										<div class="author-thumb"> 
											<?php echo wp_get_attachment_image( $image, 'full', array( 'srcset' => '' ) ); ?>
										</div>
									<?php } ?>
									<div class="author-meta">
										<h6>About the Author</h6>
										<h4 class="single-author-name"><?php echo $author->name; ?></h4>
										<h4 class="single-author-title"><?php echo $title; ?></h4>
										<div><?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $author->description ) ); ?></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

endwhile;
endif;

get_footer();