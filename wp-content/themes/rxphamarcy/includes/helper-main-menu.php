<?php
global $post;
$header_class = $post && get_post_meta( $post->ID, "header_color", true ) ? get_post_meta( $post->ID, "header_color", true ) : ""; 
$header_class = apply_filters( 'avf_header_class_filter', $header_class );
?>

<div id="header" class="header <?php echo $header_class; ?>">
    <?php if( avia_get_option( 'announcement_banner' )){ ?>
		<div class="announcement-banner">
			<div class="announcement-banner-inner">
				<?php if( avia_get_option( 'announcement_banner' ) ){ ?>
					<i class="icon-temp"></i><?php echo avia_get_option( 'announcement_banner' ); ?>
				<?php } ?>
				<?php if( avia_get_option( 'announcement_banner_link' ) && avia_get_option( 'announcement_banner_label' )){ ?>
					<a class="banner-button" target="_blank" href="<?php echo avia_get_option( 'announcement_banner_link' ); ?>"><?php echo avia_get_option( 'announcement_banner_label' ); ?></a>
				<?php } ?>
				<button class="close-bar" onClick="(function(){ document.getElementById('header').classList.remove('has-bar') })()">X</button>
			</div>
		</div>
	<?php } ?>
	<div class="header-inner">
		<div class="header-logo">
			<?php echo do_shortcode("[logo]"); ?>
		</div>
		<div class="header-menu">
			<?php
				$args = array(
					'theme_location'	=> 'avia',
					'menu_id' 			=> '',
					'menu_class'		=> 'main-menu',
					'container_class'	=> '',
					'fallback_cb' 		=> 'avia_fallback_menu',
					'walker' 			=> new avia_responsive_mega_menu()
				);
				wp_nav_menu( $args );
			?>
		</div>
		<button class="hamburger-toggle">
			<div class="burger-box"></div>
		</button>
	</div>
	<div class="hamburger-overlay"></div>
	<div class="hamburger-content">
		<div class="hamburger-content-inner">
			<?php
				$args = array(
					'theme_location'	=> 'avia',
					'menu_id' 			=> '',
					'menu_class'		=> 'main-menu',
					'container_class'	=> '',
					'fallback_cb' 		=> 'avia_fallback_menu',
					'walker' 			=> new avia_responsive_mega_menu()
				);
				wp_nav_menu( $args );
			?>
			<?php echo do_shortcode("[ep_social_profiles alignment='center']"); ?>
		</div>
	</div>
</div>