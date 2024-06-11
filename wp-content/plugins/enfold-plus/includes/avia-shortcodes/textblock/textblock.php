<?php
/**
 * Textblock
 * 
 * Shortcode which creates a text element wrapped in a div
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( ! class_exists( 'avia_sc_text' ) )
{
	class avia_sc_text extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';

			$this->config['name']			= __( 'Text Block', 'avia_framework' );
			$this->config['tab']			= __( 'Content Elements', 'avia_framework' );
			$this->config['icon']			= AviaBuilder::$path['imagesURL'] . 'sc-text_block.png';
			$this->config['order']			= 100;
			$this->config['target']			= 'avia-target-insert';
			$this->config['shortcode'] 		= 'av_textblock';
			$this->config['tinyMCE'] 	    = array('disable' => true);
			$this->config['tooltip'] 	    = __( 'Creates a simple text block', 'avia_framework' );
			$this->config['preview'] 		= 'large';
			$this->config['id_name']		= 'id';
			$this->config['id_show']		= 'yes';
		}

		function extra_assets()
		{
			//load css
			wp_enqueue_style( 'avia-module-ep-textblock' , ENFOLD_PLUS_ASSETS . 'css/ep_textblock.css' , array( 'avia-layout' ), ENFOLD_PLUS_VERSION, false );
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
							'name' 	=> __( 'Content','avia_framework' ),
							'desc' 	=> __( 'Enter some content for this textblock','avia_framework' ),
							'id' 	=> 'content',
							'type' 	=> 'tiny_mce',
							'std' 	=> __( 'Click here to add your own text', 'avia_framework' )
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
													$this->popup_key( 'styling_font_sizes' ),
													$this->popup_key( 'styling_font_colors' ),
													$this->popup_key( 'styling_alignment' ),
													$this->popup_key( 'styling_animation' ),
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
								"std" 	=> apply_filters( "avf_ep_textblock_style_std", "" ),
								"subtype" => apply_filters( "avf_ep_textblock_style_options", array(
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
							"std" 	=> apply_filters( "avf_ep_textblock_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_textblock_style_options", array() ),
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
			 * Styling Tab
			 * ===========
			 */
			
			$c = array(
						array(
							'type'			=> 'template',
							'template_id'	=> 'font_sizes_icon_switcher',
							'subtype'		=> array(
												'default'	=> AviaHtmlHelper::number_array( 8, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '' ), 'px' ),
												'medium'	=> AviaHtmlHelper::number_array( 8, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'small'		=> AviaHtmlHelper::number_array( 8, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'mini'		=> AviaHtmlHelper::number_array( 8, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' )
											)
							),

						array(
							"name" 	=> __( "Line Height", 'avia_framework' ),
							"desc" 	=> __( "Size a custom line of height (number or px/em accepted, eg. 1.3 or 16px)", 'avia_framework' ),
							"id" 	=> "line_height",
							"type" 	=> "input",
							"std" => ""
							),
				
					);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Size', 'avia_framework' ),
								'content'		=> $c 
							)
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_font_sizes' ), $template );
			
			
			$c = array(
						array(
							'name'	=> __( 'Font Colors', 'avia_framework' ),
							'desc'	=> __( 'Either use the themes default colors or apply some custom ones', 'avia_framework' ),
							'id'	=> 'font_color',
							'type'	=> 'select',
							'std'	=> '',
							'subtype'	=> array( 
											__( 'Default', 'avia_framework' )	=> '',
											__( 'Define Custom Colors', 'avia_framework' )	=> 'custom'
										),
						),
				
						array(	
							'name'	=> __( 'Custom Font Color', 'avia_framework' ),
							'desc'	=> __( 'Select a custom font color. Leave empty to use the default', 'avia_framework' ),
							'id'	=> 'color',
							'type'	=> 'colorpicker',
							'std'	=> '',
							'required'	=> array( 'font_color', 'equals', 'custom' )
						),	
					);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Colors', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_font_colors' ), $template );


			$c = array(
						
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
							'name' 	=> __( 'Text Alignment (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Desktop), overrides WYSIWYG.', 'avia_framework' ),
							'id' 	=> 'alignment',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Align Left', 'avia_framework' )	=> 'left',
												__( 'Align Center', 'avia_framework' )	=> 'center',
												__( 'Align Right', 'avia_framework' )	=> 'right',
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
							'name' 	=> __( 'Text Alignment (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Tablet), overrides WYSIWYG.', 'avia_framework' ),
							'id' 	=> 'tablet_alignment',
							'type' 	=> 'select',
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
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Mobile', 'avia_framework' ),
							'icon' => 'mobile',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Text Alignment (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Mobile), overrides WYSIWYG.', 'avia_framework' ),
							'id' 	=> 'mobile_alignment',
							'type' 	=> 'select',
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
							'nodescription' => 1
						),
						
						array(
							'type' => 'icon_switcher_container_close',
							'nodescription' => 1
						),

						array(
							"name" 	=> __( "Remove margins from paragraphs", 'avia_framework' ),
							"desc" 	=> __( "If checked default paragraph's margins in this textblock will be removed", 'avia_framework' ),
							"id" 	=> "remove_margins",
							"type" 	=> "checkbox",
							"std" 	=> "",
						),


						array(	
							'type'			=> 'template',
							'template_id'	=> 'ep_max_width'
						),

						array(
							'name' => '',
							'desc'   => '',
							'nodescription' => 1,
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'type' => 'icon_switcher_container',
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Desktop', 'avia_framework'),
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'icon' => 'desktop',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Text block alignment', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Desktop).', 'avia_framework' ),
							'id' 	=> 'block_alignment',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' )	=> '',
												__( 'Align Left', 'avia_framework' )	=> 'left',
												__( 'Align Center', 'avia_framework' )	=> 'center',
												__( 'Align Right', 'avia_framework' )	=> 'right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1
						),
						
						array(
							'type' => 'icon_switcher',
							'name' => __('Tablet', 'avia_framework'),
							'icon' => 'tablet-landscape',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1,
						),
						
						array(
							'name' 	=> __( 'Text block alignment', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Tablet).', 'avia_framework' ),
							'id' 	=> 'block_alignment_tablet',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' )	=> '',
												__( 'Align Left', 'avia_framework' )	=> 'left',
												__( 'Align Center', 'avia_framework' )	=> 'center',
												__( 'Align Right', 'avia_framework' )	=> 'right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Mobile', 'avia_framework'),
							'icon' => 'mobile',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1,
						),
						
						array(
							'name' 	=> __( 'Text block alignment', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your text here (Mobile).', 'avia_framework' ),
							'id' 	=> 'block_alignment_mobile',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' )	=> '',
												__( 'Align Left', 'avia_framework' )	=> 'left',
												__( 'Align Center', 'avia_framework' )	=> 'center',
												__( 'Align Right', 'avia_framework' )	=> 'right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher_container_close',
							'required'	=> array( "max_width", "not_empty_and", "" ),
							'nodescription' => 1
						),



					);

			$template = array(
				array(	
					'type'			=> 'template',
					'template_id'	=> 'toggle',
					'title'			=> __( 'Layout', 'avia_framework' ),
					'content'		=> $c 
				),
			);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_alignment' ), $template );

			$c = array(
				array(	
					'type'			=> 'template',
					'template_id'	=> 'ep_animation'
				),
			);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Animation', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_animation' ), $template );
			
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
			$params['class'] = '';
			$params['innerHtml'] = "<div class='avia_textblock avia_textblock_style' data-update_with='content'>" . stripslashes( wpautop( trim( html_entity_decode( $params['content'] ) ) ) ) . "</div>";
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
			extract( AviaHelper::av_mobile_sizes( $atts) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			extract( shortcode_atts( array( 
							'ep_style'	=> '',
							'font_color' => '',
							'color'	=> '',
							'size'	=> '',
							'alignment' => '',
							'mobile_alignment' => '',
							'tablet_alignment' => '',
							'remove_margins' => '',
							'line_height' => '',
							'animation' => '',
							'max_width' => '',
							'max_width_value' => '',
							'max_width_value_tablet' => '',
							'max_width_value_mobile' => '',
							'block_alignment' => '',
							'block_alignment_tablet' => '',
							'block_alignment_mobile' => '',
						), $atts, $this->config['shortcode'] ) );

			$custom_class = ! empty( $meta['custom_class'] ) ? $meta['custom_class'] : '';
			$custom_class .= ' ' . $meta['ep_class'];
			$output = '';
			$markup = avia_markup_helper(array('context' => 'entry','echo'=>false, 'custom_markup'=>$meta['custom_markup']));
			$markup_text = avia_markup_helper(array('context' => 'entry_content','echo'=>false, 'custom_markup'=>$meta['custom_markup']));

			$alignment = $alignment ? "ep-text-align-" . $alignment : "";
			$tablet_alignment = $tablet_alignment ? "ep-text-align-" . $tablet_alignment : "";
			$mobile_alignment = $mobile_alignment ? "ep-text-align-" . $mobile_alignment : "";

			$extra_styling = '';

			if( $size ) {
				$extra_styling .= "font-size:{$size}px; ";
			}

			if( $font_color == 'custom' ) {
				$custom_class  .= ' av_inherit_color';
				$extra_styling .= !empty($color) ? "color:{$color}; " : '';
			}

			if( !empty( $animation ) ) {
				$custom_class .= " av-animated-generic " . $animation;
			}

			if( !empty( $line_height ) ) {
				if ($line_height > 10) {
					$line_height = $line_height."px";
				}
				$extra_styling .= "line-height:{$line_height}; ";
			}

			if( !empty( $remove_margins ) ) {
				$custom_class .= " ep-textblock-remove-margins";
			}

			if( !empty( $max_width ) ) {

				if( empty( $max_width_value_tablet ) && empty( $max_width_value_mobile ) ) {
					if( !empty( $max_width_value ) ) $extra_styling .= "max-width:{$max_width_value}; ";
				} else {
					if( !empty( $max_width_value ) ) $extra_styling .= "--epMaxWidthDesktop:{$max_width_value}; ";
					if( !empty( $max_width_value_tablet ) ) $extra_styling .= "--epMaxWidthTablet:{$max_width_value_tablet}; ";
					if( !empty( $max_width_value_mobile ) ) $extra_styling .= "--epMaxWidthMobile:{$max_width_value_mobile}; ";
				}

				$custom_class .= !empty( $block_alignment ) ? " ep-block-align-" . $block_alignment : ""; 
				$custom_class .= !empty( $block_alignment_tablet ) ? " ep-block-align-tablet-" . $block_alignment_tablet : ""; 
				$custom_class .= !empty( $block_alignment_mobile ) ? " ep-block-align-mobile-" . $block_alignment_mobile : ""; 

			}

			if( $extra_styling ) $extra_styling = " style='{$extra_styling}'" ;

			$wrapper_data = apply_filters( "avf_ep_textblock_wrapper_data", "", $meta );

			$output .= '<section class="av_textblock_section ' . $av_display_classes .  '" ' . $meta['custom_el_id'] . $markup . ' ' . $wrapper_data . '>';
			$output .=		"<div class='avia_textblock {$custom_class} {$av_font_classes} {$alignment} {$tablet_alignment} {$mobile_alignment}' {$extra_styling} {$markup_text}>" . ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) ) . '</div>';
			$output .= '</section>';

			return $output;
		}

	}
}










