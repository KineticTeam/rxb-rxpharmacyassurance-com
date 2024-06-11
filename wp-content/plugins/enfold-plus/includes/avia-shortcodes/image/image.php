<?php
/**
 * Image
 * 
 * Shortcode which inserts an image of your choice
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( ! class_exists( 'avia_sc_image' ) )
{
	class avia_sc_image extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';

			$this->config['name']			= __( 'Image', 'avia_framework' );
			$this->config['tab']			= __( 'Media Elements', 'avia_framework' );
			$this->config['icon']			= AviaBuilder::$path['imagesURL'] . 'sc-image.png';
			$this->config['order']			= 100;
			$this->config['target']			= 'avia-target-insert';
			$this->config['shortcode'] 		= 'av_image';
			//$this->config['modal_data']     = array( 'modal_class' => 'mediumscreen' );
			$this->config['tooltip'] 	    = __( 'Inserts an image of your choice', 'avia_framework' );
			$this->config['preview'] 		= 1;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']		= 'id';
			$this->config['id_show']		= 'yes';
		}

		function extra_assets()
		{
			//load css
			wp_enqueue_style( 'avia-module-image' , AviaBuilder::$path['pluginUrlRoot'].'avia-shortcodes/image/image.css' , array( 'avia-layout' ), false );
			wp_enqueue_style( 'avia-module-ep-image' , ENFOLD_PLUS_ASSETS . 'css/ep_image.css' , array( 'avia-module-image' ), ENFOLD_PLUS_VERSION, false );

		}

		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		function popup_elements()
		{
			$this->elements = array(
				
				array(
						'type' 	=> 'tab_container', 
						'nodescription' => true
					),
						
				array(
						'type' 	=> 'tab',
						'name'  => __( 'Content', 'avia_framework' ),
						'nodescription' => true
					),
				
					array(
							'type'			=> 'template',
							'template_id'	=> $this->popup_key( 'content_image' )
						),
				
				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),
				
				array(
						'type' 	=> 'tab',
						'name'  => __( 'Styling', 'avia_framework' ),
						'nodescription' => true
					),
				
					array(
							'type'			=> 'template',
							'template_id'	=> 'toggle_container',
							'templates_include'	=> array( 
													$this->popup_key( 'styling_image_styling' ),
													$this->popup_key( 'styling_image_caption' )
												),
							'nodescription' => true
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
							'type' 	=> 'toggle_container',
							'nodescription' => true
						),
				
						array(
								'type'			=> 'template',
								'template_id'	=> $this->popup_key( 'advanced_animation' ),
							),
				
						array(	
								'type'			=> 'template',
								'template_id'	=> $this->popup_key( 'advanced_link' ),
							),
				
						array(	
								'type'			=> 'template',
								'template_id'	=> $this->popup_key( 'advanced_seo' ),
							),
				
						array(
								'type'			=> 'template',
								'template_id'	=> 'lazy_loading_toggle',
								'std'			=> 'enabled'
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
								"std" 	=> apply_filters( "avf_ep_image_style_std", "" ),
								"subtype" => apply_filters( "avf_ep_image_style_options", array(
									__( 'Default',  'avia_framework' ) => '',
								) ),
							),

						array(
							"name" 	=> __( "Additional Styles", 'avia_framework' ),
							"desc" 	=> __( "Select additional styles for this element", 'avia_framework' ),
							"id" 	=> "ep_extra_styles",
							"type" 	=> "select",
							"multiple" => 5,
							"lockable" => true,
							"std" 	=> apply_filters( "avf_ep_image_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_image_style_options", array() ),
						),

				
					array(
							'type' 	=> 'toggle_container_close',
							'nodescription' => true
						),
				
				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type' 	=> 'tab_container_close',
						'nodescription' => true
					),	
					
				array(	
						'id'	=> 'av_element_hidden_in_editor',
						'type'	=> 'hidden',
						'std'	=> '0'
					),
			);
			
		}
						
		/**
		 * Create and register templates for easier maintainance
		 * 
		 * @since 4.6.4
		 */
		protected function register_dynamic_templates()
		{
			/**
			 * Content Tab
			 * ===========
			 */
						
			$c = array(
						array(
							'name'	=> __( 'Choose Image', 'avia_framework' ),
							'desc'	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
							'id'	=> 'src',
							'type'	=> 'image',
							'title'	=> __( 'Insert Image', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std'	=> AviaBuilder::$path['imagesURL'] . 'placeholder.jpg' 
						),

						array(
							"name" 	=> __("Choose Image (Retina)",'avia_framework' ),
							"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
							"id" 	=> "src_retina",
							"type" 	=> "image",
							"title" => __("Insert Image (Retina)",'avia_framework' ),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""
						),

					
						array(
							"name" 	=> __("Alternate image for Mobile?",'avia_framework' ),
							"desc" 	=> __("You can set an alternate image for mobile here.", 'avia_framework' ),
							"id" 	=> "mobile_image",
							"type" 	=> "checkbox",
							"container_class" 	=> "av_half av_half_first",
							"std" 	=> "",
						),
		

						array(
							"name" 	=> __("Make the swap on Tablet",'avia_framework' ),
							"desc" 	=> __("You can set the alternate image to change at tablet breakpoint (989px)", 'avia_framework' ),
							"id" 	=> "mobile_image_tablet",
							"type" 	=> "checkbox",
							"container_class" => "av_half",
							"required"=> array('mobile_image','not_empty_and',''),
							"std" 	=> ""
						),

						array(
							"name" 	=> __("Choose Image (Mobile)",'avia_framework' ),
							"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
							"id" 	=> "src_mobile",
							"type" 	=> "image",
							"title" => __("Insert Image",'avia_framework' ),
							"required"=> array('mobile_image','not_empty_and',''),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""
						),

						array(
							"name" 	=> __("Choose Image (Mobile Retina)",'avia_framework' ),
							"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
							"id" 	=> "src_retina_mobile",
							"type" 	=> "image",
							"title" => __("Insert Image (Retina)",'avia_framework' ),
							"required"=> array('mobile_image','not_empty_and',''),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""
						),
				
						array(
							'name' 	=> __( 'Copyright Info', 'avia_framework' ),
							'desc' 	=> __( 'Use the media manager to add/edit the copyright info.', 'avia_framework' ),
							'id' 	=> 'copyright',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype' => array(
											__( 'No', 'avia_framework' )									=> '',
											__( 'Yes, always display copyright info', 'avia_framework' )	=> 'always',
											__( 'Yes, display icon and reveal copyright info on hover', 'avia_framework' )	=> 'icon-reveal',
										)
						),
	
						array(
							'name' 	=> __( 'Image Caption', 'avia_framework' ),
							'desc' 	=> __( 'Display a caption overlay?', 'avia_framework' ),
							'id' 	=> 'caption',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype' => array(
											__( 'No', 'avia_framework' )	=> '',
											__( 'Yes', 'avia_framework' )	=> 'yes',
										)
						),
									
						array(
							'name' 		=> __( 'Caption', 'avia_framework' ),
							'desc'		=> __( 'Add your caption text', 'avia_framework' ),
							'id' 		=> 'content',
							'type' 		=> 'textarea',
							'required'	=> array( 'caption', 'equals', 'yes' ),
							'std' 		=> '',
						),

					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'content_image' ), $c );
			
			/**
			 * Styling Tab
			 * ===========
			 */
			
			$c = array(
						
						array(	
							'name' 	=> __( 'Caption custom font size?', 'avia_framework' ),
							'desc' 	=> __( 'Size of your caption in pixel', 'avia_framework' ),
							'id' 	=> 'font_size',
							'type' 	=> 'select',
							'required'	=> array( 'caption', 'equals', 'yes' ),
							'subtype' => AviaHtmlHelper::number_array( 10, 40, 1, array( 'Default' => '' ), 'px' ),
							'std' => ''
						),

						array(
							'name' 	=> __( 'Caption Overlay Opacity', 'avia_framework' ),
							'desc' 	=> __( 'Set the opacity of your overlay: 0.1 is barely visible, 1.0 is opaque ', 'avia_framework' ),
							'id' 	=> 'overlay_opacity',
							'type' 	=> 'select',
							'std' 	=> '0.4',
							'required'	=> array( 'caption', 'equals','yes' ),
							'subtype' => array(   
											__( '0.1', 'avia_framework' )	=> '0.1',
											__( '0.2', 'avia_framework' )	=> '0.2',
											__( '0.3', 'avia_framework' )	=> '0.3',
											__( '0.4', 'avia_framework' )	=> '0.4',
											__( '0.5', 'avia_framework' )	=> '0.5',
											__( '0.6', 'avia_framework' )	=> '0.6',
											__( '0.7', 'avia_framework' )	=> '0.7',
											__( '0.8', 'avia_framework' )	=> '0.8',
											__( '0.9', 'avia_framework' )	=> '0.9',
											__( '1.0', 'avia_framework' )	=> '1',
										)
						),
								  		
						array(
							'name' 	=> __( 'Caption Overlay Background Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a background color for your overlay here.', 'avia_framework' ),
							'id' 	=> 'overlay_color',
							'type' 	=> 'colorpicker',
							'container_class' => 'av_half av_half_first',
							'required'	=> array( 'caption', 'equals', 'yes' ),
							'std' 	=> '#000000',
						),	
									
						array(	
							'name' 	=> __( 'Caption Font Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a font color for your overlay here.', 'avia_framework' ),
							'id' 	=> 'overlay_text_color',
							'type' 	=> 'colorpicker',
							'std' 	=> '#ffffff',
							'container_class' => 'av_half',
							'required'	=> array( 'caption', 'equals', 'yes' ),
						),
				
						
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Image Caption', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_image_caption' ), $template );
			
			
			
			$c = array(
						array(
							'name' 	=> __( 'Image Styling', 'avia_framework' ),
							'desc' 	=> __( 'Choose a styling variaton', 'avia_framework' ),
							'id' 	=> 'styling',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype' => array(
											__( 'Default',  'avia_framework' )	=> '',
											__( 'Circle (image height and width must be equal)',  'avia_framework' )	=> 'circle',
											__( 'No Styling (no border, no border radius etc)',  'avia_framework' )		=> 'no-styling',
											__( 'Full Width Image',  'avia_framework' ) => 'fwd-image'
										)
						),

						array(
							'name' => '',
							'desc'   => '',
							'nodescription' => 1,
							'type' => 'icon_switcher_container',
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Desktop', 'avia_framework'),
							'icon' => 'desktop',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Image Alignment (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Choose here, how to align your image', 'avia_framework' ),
							'id' 	=> 'align',
							'type' 	=> 'select',
							'std' 	=> 'center',
							'subtype'	=> array(
											__('Center',  'avia_framework' )	=> 'center',
											__('Right',  'avia_framework' )		=> 'right',
											__('Left',  'avia_framework' )		=> 'left',
											__('No special alignment', 'avia_framework' )	=> '',
										)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Tablet', 'avia_framework' ),
							'icon' => 'tablet-landscape',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Image Alignment (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Choose here, how to align your image', 'avia_framework' ),
							'id' 	=> 'tablet_align',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Center',  'avia_framework' ) => 'tablet-center',
												__( 'Right',  'avia_framework' ) => 'tablet-right',
												__( 'Left',  'avia_framework' )	=> 'tablet-left',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Mobile', 'avia_framework' ),
							'icon' => 'mobile',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Image Alignment (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Choose here, how to align your image', 'avia_framework' ),
							'id' 	=> 'mobile_align',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Center',  'avia_framework' ) => 'mobile-center',
												__( 'Right',  'avia_framework' ) => 'mobile-right',
												__( 'Left',  'avia_framework' )	=> 'mobile-left',
							)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1
						),
						
						array(
							'type' => 'icon_switcher_container_close',
							'nodescription' => 1
						),

						array(	
							'type'			=> 'template',
							'template_id'	=> 'ep_max_width'
						),

				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Image Styling', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_image_styling' ), $template );
			
			
			
			/**
			 * Advanced Tab
			 * ============
			 */
			
			$c = array(
						array(
							'name' 	=> __( 'Image Fade in Animation', 'avia_framework' ),
							'desc' 	=> __( "Add a small animation to the image when the user first scrolls to the image position. This is only to add some 'spice' to the site and only works in modern browsers", 'avia_framework' ),
							'id' 	=> 'animation',
							'type' 	=> 'select',
							'std' 	=> 'no-animation',
							'subtype' => array(
											__( 'None', 'avia_framework' )	=> 'no-animation',
											__( 'Fade Animations', 'avia_framework')	=> array(
														__( 'Fade in', 'avia_framework' )	=> 'fade-in',
														__( 'Pop up', 'avia_framework' )	=> 'pop-up',
													),
											__( 'Slide Animations', 'avia_framework' ) => array(
														__( 'Top to Bottom', 'avia_framework' ) => 'top-to-bottom',
														__( 'Bottom to Top', 'avia_framework' ) => 'bottom-to-top',
														__( 'Left to Right', 'avia_framework' ) => 'left-to-right',
														__( 'Right to Left', 'avia_framework' ) => 'right-to-left',
													),
											__( 'Rotate',  'avia_framework' ) => array(
														__( 'Full rotation', 'avia_framework' )	=> 'av-rotateIn',
														__( 'Bottom left rotation', 'avia_framework' )	=> 'av-rotateInUpLeft',
														__( 'Bottom right rotation', 'avia_framework' )	=> 'av-rotateInUpRight',
													)
										)
						),
				
						array(
							'name' 	=> __( 'Image Hover effect', 'avia_framework' ),
							'desc' 	=> __( 'Add a mouse hover effect to the image', 'avia_framework' ),
							'id' 	=> 'hover',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype' => array(
											__( 'No', 'avia_framework' )	=> '',
											__( 'Yes, slightly increase the image size', 'avia_framework' )	=> 'av-hover-grow',
											__( 'Yes, slightly zoom the image', 'avia_framework' )			=> 'av-hover-grow av-hide-overflow',
										)
						),
				
						array(
							'name' 	=> __( 'Caption Appearance', 'avia_framework' ),
							'desc' 	=> __( 'When to display the caption?', 'avia_framework' ),
							'id' 	=> 'appearance',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( 'caption', 'equals', 'yes' ),
							'subtype' => array(
											__( 'Always display caption', 'avia_framework' )	=> '',
											__( 'Only display on hover', 'avia_framework' )		=> 'on-hover',
										)
						)
				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Animation', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'advanced_animation' ), $template );
			
			$c = array(
						array(
							'name'	=> __( 'Image Link?', 'avia_framework' ),
							'desc'	=> __( 'Where should your image link to?', 'avia_framework' ),
							'id'	=> 'link',
							'type'	=> 'linkpicker',
							'fetchTMPL'	=> true,
							'subtype'	=> array(
											__( 'No Link', 'avia_framework' )	=> '',
											__( 'Lightbox', 'avia_framework' )	=> 'lightbox',
											__( 'Set Manually', 'avia_framework' )	=> 'manually',
											__( 'Single Entry', 'avia_framework' )	=> 'single',
											__( 'Taxonomy Overview Page',  'avia_framework' )	=> 'taxonomy',
										),
							'std' 	=> ''
						),
				
						array(
							'name'	=> __( 'Open new tab/window', 'avia_framework' ),
							'desc'	=> __( 'Do you want to open the link url in a new tab/window?', 'avia_framework' ),
							'id'	=> 'target',
							'type'	=> 'select',
							'std'	=> '',
							'required'	=> array( 'link', 'not_empty_and', 'lightbox' ),
							'subtype'	=> AviaHtmlHelper::linking_options()
						),

					);
						
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Image Link Settings', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'advanced_link' ), $template );
			
			$c = array(
						array(
							'name' 			=> __( 'Custom Title Attribute', 'avia_framework' ),
							'desc' 			=> __( 'Add a custom title attribute limited to this instance, replaces media gallery settings.', 'avia_framework' ),
							'id' 			=> 'title_attr',
							'type' 			=> 'input',
							'std' 			=> ''
						),

						array(
							'name' 			=> __( 'Custom Alt Attribute', 'avia_framework' ),
							'desc' 			=> __( 'Add a custom alt attribute limited to this instance, replaces media gallery settings.', 'avia_framework' ),
							'id' 			=> 'alt_attr',
							'type' 			=> 'input',
							'std' 			=> ''
						)
					);
			
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'SEO improvements', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'advanced_seo' ), $template );
		}

		/**
		 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
		 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
		 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
		 *
		 *
		 * @param array $params this array holds the default values for $content and $args.
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_element( $params )
		{
			$template = $this->update_template( 'src', "<img src='{{src}}' alt=''/>" );
			$img	  = '';

			if( ! empty( $params['args']['attachment'] ) && ! empty( $params['args']['attachment_size'] ) )
			{
				$img = wp_get_attachment_image( $params['args']['attachment'], $params['args']['attachment_size'] );
			}
			else if( isset( $params['args']['src'] ) && is_numeric( $params['args']['src'] ) )
			{
				$img = wp_get_attachment_image( $params['args']['src'], 'large' );
			}
			else if( ! empty( $params['args']['src'] ) )
			{
				$img = "<img src='" . esc_attr( $params['args']['src'] ) . "' alt=''  />";
			}

			$params['innerHtml']  = "<div class='avia_image avia_image_style avia_hidden_bg_box'>";
			$params['innerHtml'] .=		'<div ' . $this->class_by_arguments( 'align', $params['args'] ) . '>';
			$params['innerHtml'] .=			"<div class='avia_image_container' {$template}>{$img}</div>";
			$params['innerHtml'] .=		'</div>';
			$params['innerHtml'] .= '</div>';
			$params['class'] = '';

			return $params;
		}

		/**
		 * Frontend Shortcode Handler
		 *
		 * @param array $atts array of attributes
		 * @param string $content text within enclosing form of shortcode element
		 * @param string $shortcodename the shortcode found, when == callback name
		 * @return string $output returns the modified html string
		 */
		function shortcode_handler( $atts, $content = '', $shortcodename = '', $meta = '' )
		{
				
			extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			$output = '';
			$class = '';
			$src = '';
			$alt = '';
			$title = '';
			$copyright_text = '';
			$attachment_id = 0;
			$wrapper_styling = '';

			$atts = shortcode_atts( array(	
						'ep_style'			=> '',
						'src'				=> '', 
						'src_retina' 		=> '',
						'src_mobile' 		=> '',
						'src_retina_mobile' => '',
						'mobile_image' 		=> '',
						'mobile_image_tablet' => '',
						'title_attr'		=> '',
						'alt_attr'			=> '',
						'animation'			=> 'no-animation', 
						'lazy_loading'		=> 'disabled',
						'link'				=> '', 
						'attachment'		=> '', 
						'attachment_size'	=> '', 
						'target'			=> '', 
						'styling'			=> '', 
						'caption'			=> '',
						'copyright'			=> '',
						'font_size'			=> '', 
						'appearance'		=> '', 
						'hover'				=> '',
						'align'				=> 'center',
						'tablet_align' 		=> '',
						'mobile_align' 		=> '',
						'max_width' 		=> '',
						'max_width_value' 			=> '',
						'max_width_value_tablet' 	=> '',
						'max_width_value_mobile' 	=> '',
						'overlay_opacity'	=> '0.4', 
						'overlay_color'		=> '#444444', 
						'overlay_text_color'	=> '#ffffff',
					), $atts, $this->config['shortcode'] );

			extract( $atts );

			$img_h = '';
			$img_w = '';
				
			if( ! empty( $attachment ) )
			{
				/**
				 * Allows e.g. WPML to reroute to translated image
				 */
				$posts = get_posts( array(
										'include'			=> $attachment,
										'post_status'		=> 'inherit',
										'post_type'			=> 'attachment',
										'post_mime_type'	=> 'image',
										'order'				=> 'ASC',
										'orderby'			=> 'post__in' 
									)
								);
				
				$explode_attachment_size = explode( ',', $attachment_size );

				if( is_array( $posts ) && ! empty( $posts ) )
				{
					$attachment_entry = $posts[0];
					$attachment_id = $attachment_entry->ID;
					
					if( ! empty( $alt_attr ) )
					{
						$alt = $alt_attr;
					}
					else
					{
						$alt = get_post_meta( $attachment_entry->ID, '_wp_attachment_image_alt', true );
					}
					
					$alt = ! empty( $alt ) ? esc_attr( trim( $alt ) ) : '';
					
					if( ! empty( $title_attr ) )
					{
						$title = $title_attr;
					}
					else
					{
						$title = $attachment_entry->post_title;
					}
					
					$title = ! empty( $title ) ? esc_attr( trim( $title ) ) : '';
					
					if( $copyright !== '') 
					{
						$copyright_text = get_post_meta( $attachment_entry->ID, '_avia_attachment_copyright', true );
						
						/**
						 * Allow to filter the copyright text
						 * 
						 * @since 4.7.4.1
						 * @param string $copyright_text
						 * @param string $shortcodename			context calling the filter
						 * @param int $attachment_entry->ID
						 * @return string
						 */
						$copyright_text = apply_filters( 'avf_attachment_copyright_text', $copyright_text, $shortcodename, $attachment_entry->ID );
					}

					/* Default */
					if( !empty( $explode_attachment_size[0] ) )
					{
						$src = wp_get_attachment_image_src( $attachment_entry->ID, $explode_attachment_size[0] );
				
						$img_h = !empty( $src[2] ) ? $src[2] : "";
						$img_w = !empty( $src[1] ) ? $src[1] : "";
						$src   = !empty( $src[0] ) ? $src[0] : "";
					}

					/* Retina */
					if( !empty( $posts[1] ) && !empty( $src_retina ) ) {
						$retina_attachment_entry = $posts[1];
						if( !empty( $explode_attachment_size[1] ) )
						{
							$src_retina = wp_get_attachment_image_src( $retina_attachment_entry->ID, $explode_attachment_size[1] );
							$src_retina = !empty( $src_retina[0] ) ? $src_retina[0] : "";
						}
					}

					/* Default Mobile */
					if( !empty( $posts[2] ) && !empty( $src_mobile ) ) {
						$default_mobile_attachment_entry = $posts[2];
						if( !empty( $explode_attachment_size[2] ) )
						{
							$src_mobile = wp_get_attachment_image_src( $default_mobile_attachment_entry->ID, $explode_attachment_size[2] );
							$src_mobile = !empty( $src_mobile[0] ) ? $src_mobile[0] : "";
						}
					}

					/* Retina Mobile */
					if( !empty( $posts[3] ) && !empty( $src_retina_mobile ) ) {
						$retina_mobile_attachment_entry = $posts[3];
						if( !empty( $explode_attachment_size[3] ) )
						{
							$src_retina_mobile = wp_get_attachment_image_src( $retina_mobile_attachment_entry->ID, $explode_attachment_size[3] );
							$src_retina_mobile = !empty( $src_retina_mobile[0] ) ? $src_retina_mobile[0] : "";
						}
					}

				}
			}
			else
			{
				$attachment = false;
			}

			if( ! empty( $src ) )
			{
				$class  = $animation == 'no-animation' ? '' : "avia_animated_image avia_animate_when_almost_visible {$animation}";
				$class .= " av-styling-{$styling} {$hover}";

				if( is_numeric( $src ) )
				{
					//$output = wp_get_attachment_image( $src,'large' );
					$img_atts = array( 'class' => "avia_image {$class} " . $this->class_by_arguments( 'align', $atts, true ) );

					if( ! empty( $img_h ) ) 
					{
						$img_atts['height'] = $img_h;
					}
					if( ! empty( $img_w ) ) 
					{
						$img_atts['width'] = $img_w;
					}
					
					if( $lazy_loading != 'enabled' )
					{
						Av_Responsive_Images()->add_attachment_id_to_not_lazy_loading( $src );
					}

					$output = wp_get_attachment_image( $src, 'large', false, $img_atts );
				}
				else
				{
					$link = AviaHelper::get_url( $link, $attachment );
					$blank = AviaHelper::get_link_target( $target );

					$overlay = '';
					$style = '';
					$style .= AviaHelper::style_string( $atts, 'overlay_text_color', 'color' );
					if( $font_size )
					{
						// $style = "style='font-size: {$font_size}px;'";
						$style .= AviaHelper::style_string( $atts, 'font_size', 'font-size', 'px' );
					}
					
					$style = AviaHelper::style_string( $style );

					if( $caption == 'yes' )
					{	
						$caption_style = '';
						$caption_style .= AviaHelper::style_string( $atts, 'overlay_opacity', 'opacity' );
						$caption_style .= AviaHelper::style_string( $atts, 'overlay_color', 'background-color' );
						$caption_style  = AviaHelper::style_string( $caption_style );
						$overlay_bg = "<div class='av-caption-image-overlay-bg' {$caption_style}></div>";

						$content = ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) );
						$overlay = "<div class='av-image-caption-overlay'>{$overlay_bg}<div class='av-image-caption-overlay-position'><div class='av-image-caption-overlay-center' {$style}>{$content}</div></div></div>";
						$class .= ' noHover ';

						if( empty( $appearance ) ) 
						{
							$appearance = 'hover-deactivate';
						}
						
						if( $appearance ) 
						{
							$class .= " av-overlay-{$appearance}";
						}
					}

					$copyright_tag = '';
					if( ! empty( $copyright_text ) )
					{
						$copyright_tag = "<small class='avia-copyright'>{$copyright_text}</small>";
						$class .= ' av-has-copyright';
						if( $copyright != '' ) 
						{
							$class .= ' av-copyright-' . $copyright;
						}
					}

					$markup_url = avia_markup_helper( array( 'context' => 'image_url', 'echo' => false, 'custom_markup' => $meta['custom_markup'] ) );
					$markup = avia_markup_helper( array( 'context' => 'image', 'echo' => false, 'custom_markup' => $meta['custom_markup'] ) );

					$tablet_align = $atts['tablet_align'] ? "ep-image-".$atts['tablet_align'] : "";
					$mobile_align = $atts['mobile_align'] ? "ep-image-".$atts['mobile_align'] : "";

					$before_img_tag = "";
					$after_img_tag = "";
					
					$src_markup_img = "src='{$src}'";

					if( !empty( $src_retina ) ) {
						$src_markup = "srcset='{$src} 1x, {$src_retina} 2x'";
					} else {
						$src_markup = "srcset='{$src}'";
					}

					if( !empty( $mobile_image ) ) {
						if( !empty( $src_retina_mobile ) ) {
							$src_markup_mobile = "srcset='{$src_mobile} 1x, {$src_retina_mobile} 2x'";
						} else {
							$src_markup_mobile = "srcset='{$src_mobile}'";
						}
					}
					
					if( !empty( $src_retina ) || !empty( $mobile_image ) ) {
						ob_start();
						?>
						<picture>
							<?php 
							if( !empty( $mobile_image ) ){ 
								$breakpoint = !empty( $mobile_image_tablet ) ? "989px" : "767px";
							?>
							<source media="(max-width: <?php echo $breakpoint; ?>)" <?php echo $src_markup_mobile; ?>>
							<?php } ?>
							<source <?php echo $src_markup; ?>>
						<?php

						$before_img_tag = ob_get_clean();
						$after_img_tag = "</picture>";
					}
							

					if( !empty( $max_width ) ) {

						if( empty( $max_width_value_tablet ) && empty( $max_width_value_mobile ) ) {
							if( !empty( $max_width_value ) ) $wrapper_styling .= "max-width:{$max_width_value}; ";
						} else {
							if( !empty( $max_width_value ) ) $wrapper_styling .= "--epMaxWidthDesktop:{$max_width_value}; ";
							if( !empty( $max_width_value_tablet ) ) $wrapper_styling .= "--epMaxWidthTablet:{$max_width_value_tablet}; ";
							if( !empty( $max_width_value_mobile ) ) $wrapper_styling .= "--epMaxWidthMobile:{$max_width_value_mobile}; ";
						}
		
					}

					if( !empty( $wrapper_styling ) ) $wrapper_styling = "style='{$wrapper_styling}'";

					$wrapper_data = apply_filters( "avf_ep_image_wrapper_data", "", $meta );

					$output .= "<div {$meta['custom_el_id']} class='avia-image-container {$class} {$tablet_align} {$mobile_align} {$av_display_classes} " . $meta['el_class'] . " " . $this->class_by_arguments( 'align' ,$atts, true ) . "' {$markup} {$wrapper_data} {$wrapper_styling}>";
					$output .= "<div class='avia-image-container-inner'>";

					$output .= "<div class='avia-image-overlay-wrap'>";
					

					if( $link )
					{
						$img_tag = $before_img_tag . "<img class='avia_image' loading='lazy' src='{$src}' alt='{$alt}' title='{$title}' {$markup_url} />" . $after_img_tag;
						$img_tag = Av_Responsive_Images()->prepare_single_image( $img_tag, $attachment_id, $lazy_loading );
						
						$output.= "<a href='{$link}' class='avia_image'  {$blank}>{$overlay}{$img_tag}</a>";
					}
					else
					{
						$hw = '';
						if( ! empty( $img_h ) ) 
						{
							$hw .= 'height="' . $img_h . '"';
						}

						if( ! empty( $img_w ) ) 
						{
							$hw .= ' width="' . $img_w . '"';
						}
						
						$img_tag = $before_img_tag . "<img loading='lazy' class='avia_image' src='{$src}' alt='{$alt}' title='{$title}' {$hw} {$markup_url} />" . $after_img_tag;
						$img_tag = Av_Responsive_Images()->prepare_single_image( $img_tag, $attachment_id, $lazy_loading );
						
						$output.= "{$overlay}{$img_tag}";
					}
					
					$output .= '</div>';
					$output .= $copyright_tag;

					$output .= '</div>';
					$output .= '</div>';
				}
			}

			return Av_Responsive_Images()->make_content_images_responsive( $output );
		}

	}
}

