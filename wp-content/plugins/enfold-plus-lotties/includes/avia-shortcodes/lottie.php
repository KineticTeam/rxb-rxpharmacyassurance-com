<?php
/**
 * Lottie Element
 */
 
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !class_exists( 'ep_sc_lottie' ) ) 
{
	class ep_sc_lottie extends aviaShortcodeTemplate{
			
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button() {
				$this->config['version']		= '1.0';
				$this->config['self_closing']	=	'yes';
				$this->config['name']		= __('Lottie Element', 'avia_framework' );
				$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-image.png";
				$this->config['order']		= 94;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'ep_lottie';
				$this->config['tooltip'] 	= __('Creates a Lottie Element', 'avia_framework' );
				$this->config['disabling_allowed'] = true;
				$this->config['id_name']	= 'id';
				$this->config['id_show']	= 'yes';	
			}
			 
			function extra_assets() {
				wp_enqueue_script( 'avia-module-ep-lottie-web', ENFOLD_PLUS_LOTTIES_ASSETS . 'js/dist/lottie-web.js', array(), ENFOLD_PLUS_LOTTIES_VERSION, true );

				wp_enqueue_style( 'avia-module-ep-lottie', ENFOLD_PLUS_LOTTIES_ASSETS . 'css/lottie.css', array(), ENFOLD_PLUS_LOTTIES_VERSION, 'all' );
				wp_enqueue_script( 'avia-module-ep-lottie', ENFOLD_PLUS_LOTTIES_ASSETS . 'js/lottie.js', array( 'avia-module-ep-lottie-web' ), ENFOLD_PLUS_LOTTIES_VERSION, true );
			}
            
            
			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements() {
				$this->elements = array(

					array(
						"type" 	=> "tab_container", 'nodescription' => true
					),

					array(
						"type" 	=> "tab",
						"name"  => __("Lottie Settings" , 'avia_framework'),
						'nodescription' => true
					),
					
					array(
						"name" 	=> __( "Which Lottie Animation?", 'avia_framework' ),
						'desc' 	=> __( 'Select the Lottie animation that should be displayed', 'avia_framework' ),
						"id" 	=> "link",
						"type" 	=> "select",
						"subtype" => $this->get_lotties()
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

					array(
						"type" 	=> "tab",
						"name"  => __("Animation Settings" , 'avia_framework'),
						'nodescription' => true
					),
					

					array(
						'name' => __( 'Loop?', 'avia_framework' ),
						'desc' => __( 'Should the Lottie animation loop or play once?', 'avia_framework' ),
						'id'   => 'loop',
						'type' 	=> 'select',
						'std' 	=> 'yes',
						"subtype" => array(
							__( "Yes", 'avia_framework' ) => "yes",
							__( "No", 'avia_framework' ) => "no"
						)
					),


					array(
						'name' => __( 'Animation Type?', 'avia_framework' ),
						'desc' => __( 'What animation type should this Lottie use? SVG is the better, sharper option, but if you notice rendering issues try changing it to canvas', 'avia_framework' ),
						'id'   => 'anim_type',
						'type' 	=> 'select',
						'std' 	=> '',
						"subtype" => array(
							__( "SVG", 'avia_framework' ) => "",
							__( "Canvas", 'avia_framework' ) => "canvas"
						)
					),


					array(
						'name' => __( 'Animation Size?', 'avia_framework' ),
						'desc' => __( 'Should the Lottie animation receive a custom size? by default it will span to the 100% width of its parent container.', 'avia_framework' ),
						'id'   => 'custom_size',
						'type' 	=> 'select',
						'std' 	=> '',
						"subtype" => array(
							__( "Full width", 'avia_framework' ) => "",
							__( "Custom", 'avia_framework' ) => "custom"
						)
					),

					array(
						"name" 	=> __("Custom max width", 'avia_framework' ),
						"desc" 	=> __("Enter a custom max width, can be px/em/%", 'avia_framework' ),
						"id" 	=> "custom_size_w",
						"type" 	=> "input",
						"required" => array( 'custom_size', 'not', '' ),
						"std" 	=> ""
					),


					array(
						'name' => '',
						'desc'   => '',
						'nodescription' => 1,
						"required" => array( 'custom_size', 'not', '' ),
						'type' => 'icon_switcher_container',
					),

					array(
						'type' => 'icon_switcher',
						'name' => __('Desktop', 'avia_framework'),
						'icon' => 'desktop',
						"required" => array( 'custom_size', 'not', '' ),
						'nodescription' => 1,
					),

					array(
						'name' 	=> __( 'Element Position (Desktop)', 'avia_framework' ),
						'desc' 	=> __( 'Choose the alignment of your element here (Desktop)', 'avia_framework' ),
						'id' 	=> 'align',
						'type' 	=> 'select',
						"required" => array( 'custom_size', 'not', '' ),
						'std' 	=> '',
						'subtype'	=> array(
											__( 'No Align', 'avia_framework' ) => '',
											__( 'Align Left', 'avia_framework' )	=> 'left',
											__( 'Align Center', 'avia_framework' )	=> 'center',
											__( 'Align Right', 'avia_framework' )	=> 'right',
										)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array( 'custom_size', 'not', '' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __('Tablet', 'avia_framework' ),
						'icon' => 'tablet-landscape',
						"required" => array( 'custom_size', 'not', '' ),
						'nodescription' => 1,
					),

					array(
						'name' 	=> __( 'Element Position (Tablet)', 'avia_framework' ),
						'desc' 	=> __( 'Choose the alignment of your element here (Tablet)', 'avia_framework' ),
						'id' 	=> 'tablet_align',
						'type' 	=> 'select',
						"required" => array( 'custom_size', 'not', '' ),
						'std' 	=> '',
						'subtype'	=> array(
											__( 'Default', 'avia_framework' ) => '',
											__( 'Align Left', 'avia_framework' )	=> 'tablet-left',
											__( 'Align Center', 'avia_framework' )	=> 'tablet-center',
											__( 'Align Right', 'avia_framework' )	=> 'tablet-right',
										)
					),

					array(
						'type' => 'icon_switcher_close',
						'nodescription' => 1,
						"required" => array( 'custom_size', 'not', '' ),
					),

					array(
						'type' => 'icon_switcher',
						'name' => __('Mobile', 'avia_framework' ),
						'icon' => 'mobile',
						"required" => array( 'custom_size', 'not', '' ),
						'nodescription' => 1,
					),

					array(
						'name' 	=> __( 'Element Position (Mobile)', 'avia_framework' ),
						'desc' 	=> __( 'Choose the alignment of your element here (Mobile)', 'avia_framework' ),
						'id' 	=> 'mobile_align',
						'type' 	=> 'select',
						"required" => array( 'custom_size', 'not', '' ),
						'std' 	=> '',
						'subtype'	=> array(
											__( 'Default', 'avia_framework' ) => '',
											__( 'Align Left', 'avia_framework' )	=> 'mobile-left',
											__( 'Align Center', 'avia_framework' )	=> 'mobile-center',
											__( 'Align Right', 'avia_framework' )	=> 'mobile-right',
										)
					),

					array(
						'type' => 'icon_switcher_close',
						'nodescription' => 1,
						"required" => array( 'custom_size', 'not', '' ),
					),
					
					array(
						'type' => 'icon_switcher_container_close',
						'nodescription' => 1,
						"required" => array( 'custom_size', 'not', '' ),
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

					array(
						"type" 	=> "tab",
						"name"  => __("Link Settings" , 'avia_framework'),
						'nodescription' => true
					),

					array(
						'name' => __( 'Enable Link?', 'avia_framework' ),
						'desc' => __( 'Should the Lottie animation be linked?', 'avia_framework' ),
						'id'   => 'enable_link',
						'type' 	=> 'select',
						'std' 	=> '',
						"subtype" => array(
							__( "Yes", 'avia_framework' ) => "yes",
							__( "No", 'avia_framework' ) => ""
						)
					),

					array(
						"name" 	=> __("Link", 'avia_framework' ),
						"desc" 	=> __("Lottie animation link", 'avia_framework' ),
						"id" 	=> "href",
						"type" 	=> "linkpicker",
						"required"		=> array( 'enable_link', 'not', '' ),
						"fetchTMPL"	=> true,
						"subtype" => array(	
											__('Set Manually', 'avia_framework' ) =>'manually',
											__('Single Entry', 'avia_framework' ) =>'single',
											__('Taxonomy Overview Page',  'avia_framework' )=>'taxonomy',
											),
						"std" 	=> ""
					),

					array(	
						"name" 	=> __("Open Link in new Window?", 'avia_framework' ),
						"desc" 	=> __("Select here if you want to open the linked page in a new window", 'avia_framework' ),
						"id" 	=> "link_target",
						"required"		=> array( 'enable_link', 'not', '' ),
						"type" 	=> "select",
						"std" 	=> "",
						"subtype" => AviaHtmlHelper::linking_options()
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),
	
					array(
						'type' 	=> 'tab',
						'name'  => __( 'Advanced', 'avia_framework' ),
						'nodescription' => true
					),

					array(
						'type'			=> 'template',
						'template_id'	=> 'screen_options_toggle'
					),
			
					array(	
						'type'			=> 'template',
						'template_id'	=> 'developer_options_toggle',
						'args'			=> array( 'sc' => $this )
					),
					
					array(
						"name" 	=> __( "Style", 'avia_framework' ),
						"desc" 	=> __( "Set a pre-defined style for this element", 'avia_framework' ),
						"id" 	=> "ep_style",
						"type" 	=> "select",
						"lockable" => true,
						"std" 	=> apply_filters( "avf_{$this->config['shortcode']}_style_std", "" ),
						"subtype" => apply_filters( "avf_{$this->config['shortcode']}_style_options", array(
							__( 'Default',  'avia_framework' ) => '',
						) )
					),
	
					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),
	
					array(
						'type' 	=> 'tab_container_close',
						'nodescription' => true
					)
                );
            }
			
            

			private function get_lotties() {

				$args = array(
					'posts_per_page'   => -1,
					'post_type'        => 'lottie_animation',
					'post_status'      => 'publish',
				);
			
				$posts_array = get_posts( $args ); 
				$post_type_option = array();
			
				if( !empty( $posts_array ) ) {
					foreach( $posts_array as $post_array ) {	
						$post_type_option[$post_array->post_title] = $post_array->ID;
					}
				}
			
				return $post_type_option;
			}

			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element 
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string 
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "") {

				$this->screen_options = AviaHelper::av_mobile_sizes( $atts );

				extract( $this->screen_options );

				$atts = shortcode_atts( array(
					'ep_style'	=> '',
					'loop'		=> 'yes',
					'anim_type' => '',
					'link'		=> '',
					'enable_link' => '',
					'href' => '',
					'link_target' => '',
					'custom_size' => '',
					'custom_size_w' => '',
					'disable_on_mobile' => '',
					'align' => '',
					'tablet_align' => '',
					'mobile_align' => '',
            	), $atts, $this->config['shortcode'] );

				extract( $atts );

				if( empty( $link ) ) return;

				/* Legacy support for old versions of Lotties */
				if( intval( $link ) == 0 ){
					$link = AviaHelper::get_entry( $link )->ID;	
				}

				$style_tag = "";
				$inner_style_tag = "";
				$alignment_class = "";
				$lottie_mobile = "";
				$wrapper_data = "";

				if( !empty( $custom_size ) ) {

					$mobile_align = $mobile_align ? " ep-block-align-" . $mobile_align : "";
					$tablet_align = $tablet_align ? " ep-block-align-" . $tablet_align : "";

					$align = $align ? " ep-block-align-".$align : "";
					$alignment_class = $align . " " . $tablet_align . " " . $mobile_align;
					$style_tag .= "style='max-width: {$custom_size_w};'";
				}
				

				/* Vertical Ratio */
				$width = get_post_meta( $link, "width", true );
				$height = get_post_meta( $link, "height", true );
				if( !empty( $width ) && !empty( $height ) ) {
					$inner_style_tag .= "style='padding-bottom: " . intval( $height ) / intval( $width ) * 100 . "%;'";
				}
				
				/* Link */
				if( !empty( $enable_link ) ) {
					$href = AviaHelper::get_url( $href );
					$href = ( ( $href == "http://" ) || ( $href == "manually" ) ) ? "" : $href;
		
					$blank = strpos( $link_target, '_blank' ) !== false ? ' target="_blank" ' : "";
					$blank .= strpos( $link_target, 'nofollow' ) !== false ? ' rel="nofollow" ' : "";
				}

				$wrapper_data = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data", $wrapper_data, $meta );
				
				ob_start();
				?>
				<div <?php echo $meta['custom_el_id']; ?> class='ep-lottie-animation <?php echo $av_display_classes; ?> <?php echo $alignment_class; ?> <?php echo $meta['el_class']; ?>' <?php echo $style_tag; ?> <?php echo $wrapper_data; ?>>
					<div class="ep-lottie-animation-inner" <?php echo $inner_style_tag; ?> data-loop="<?php echo $loop == "yes" ? "true" : "false"; ?>" data-json="<?php echo wp_get_attachment_url( get_post_meta( $link, "json", true ) ); ?>" data-animType="<?php echo $anim_type == "" ? "svg" : "canvas"; ?>"></div>
					<?php if( !empty( $enable_link ) ) { ?>
						<a <?php echo $blank; ?> href="<?php echo $href; ?>" title="<?php echo get_the_title( $link ); ?>" class="ep-lottie-animation-link lottie-animation-link"></a>
					<?php } ?>
				</div>
				<?php
				return ob_get_clean();
						
        	}
			
	}
}
