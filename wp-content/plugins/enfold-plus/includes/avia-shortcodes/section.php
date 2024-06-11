<?php
/**
 * Color Section
 * 
 * Shortcode creates a section with unique background image and colors for better content sepearation
 */

 // Don't load directly
if ( ! defined('ABSPATH') ) { die('-1'); }



if ( ! class_exists( 'avia_sc_section' ) )
{
	class avia_sc_section extends aviaShortcodeTemplate
	{

		static $section_count = 0;
		static $add_to_closing = '';
		static $close_overlay = '';

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['is_fullwidth']	= 'yes';
			$this->config['type']			= 'layout';
			$this->config['self_closing']	= 'no';
			$this->config['contains_text']	= 'no';
			$this->config['base_element']	= 'yes';

			$this->config['name']		= __( 'Color Section', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-section.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 20;
			$this->config['shortcode'] 	= 'av_section';
			$this->config['html_renderer'] 	= false;
			$this->config['tinyMCE'] 	= array( 'disable' => 'true' );
			$this->config['tooltip'] 	= __('Creates a section with unique background image and colors', 'avia_framework' );
			$this->config['drag-level'] = 1;
			$this->config['drop-level'] = 1;
			$this->config['preview']	= false;

			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'always';				//	we use original code - not $meta
			$this->config['aria_label']	= 'yes';
		}

		function extra_assets() {
			wp_enqueue_style( 'avia-module-ep-section' , ENFOLD_PLUS_ASSETS . 'css/ep_section.css' , array( 'avia-layout' ), ENFOLD_PLUS_VERSION, false );
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
						'name'  => __( 'Layout' , 'avia_framework' ),
						'nodescription' => true
					),
				
					array(
							'type'			=> 'template',
							'template_id'	=> 'toggle_container',
							'templates_include'	=> array(
													$this->popup_key( 'layout_section_height' ),
													$this->popup_key( 'layout_margin_padding' )
												),
							'nodescription' => true
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
													$this->popup_key( 'styling_background_colors' ),
													$this->popup_key( 'styling_background_image' ),
													$this->popup_key( 'styling_background_video' ),
													$this->popup_key( 'styling_background_overlay' ),
													$this->popup_key( 'styling_borders' ),
													$this->popup_key( 'styling_arrow' )
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

						/* EP >> */
						array(
							"name" 	=> __( "Style", 'avia_framework' ),
							"desc" 	=> __( "Set a pre-defined style for this element", 'avia_framework' ),
							"id" 	=> "ep_style",
							"type" 	=> "select",
							"lockable" => true,
							"std" 	=> apply_filters( "avf_ep_section_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_section_style_options", array(
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
							"std" 	=> apply_filters( "avf_ep_section_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_section_style_options", array() ),
						),

						array(	
							'type'			=> 'template',
							'template_id'	=> 'toggle',
							'title'			=> __( 'Z-index', 'avia_framework' ),
							'content'		=> array(
								array(	
									"name" 	=> __("Z-index", 'avia_framework' ),
									"desc" 	=> __("Apply a custom z-index value, useful when horizontally offsetting a section against a section below.", 'avia_framework' ),
									"id" 	=> "z_index",
									"type" 	=> "input",
									"std" => "",
									'lockable'	=> true
								),
							)
						),
						/* << EP */
				
					array(
							'type' 	=> 'toggle_container_close',
							'nodescription' => true
						),
				
				array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

				array(
						'type'			=> 'template',
						'template_id'	=> 'element_template_selection_tab',
						'args'			=> array( 'sc' => $this )
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
			global $avia_config;
			
			/**
			 * Layout Tab
			 * ===========
			 */
			
			$c = array(
						array(
							'name' 	=> __( 'Section Minimum Height','avia_framework' ),
							'id' 	=> 'min_height',
							'desc'  => __( 'Define a minimum height for the section. Content within the section will be centered vertically within the section', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype' => array(   
											__( 'No minimum height, use content within section to define Section height', 'avia_framework' )	=> '',
											__( 'At least 100&percnt; of Browser Window height', 'avia_framework' )					=> '100',
											__( 'At least 75&percnt; of Browser Window height', 'avia_framework' )					=> '75',
											__( 'At least 50&percnt; of Browser Window height', 'avia_framework' )					=> '50',
											__( 'At least 25&percnt; of Browser Window height', 'avia_framework' )					=> '25',
											__( 'Custom height in &percnt; based on browser windows height', 'avia_framework' )		=> 'percent',
											__( 'Custom height in pixel', 'avia_framework' )										=> 'custom',
										)
						),
											
						array(	
							'name' 	=> __( 'Section minimum custom height in &percnt;', 'avia_framework' ),
							'desc' 	=> __( 'Define a minimum height for the section in &percnt; based on the browser windows height', 'avia_framework' ),
							'id' 	=> 'min_height_pc',
							'required'	=> array( 'min_height', 'equals', 'percent' ),
							'std' 	=> '25',
							'lockable'	=> true,
							'type' 	=> 'select',
							'subtype' => AviaHtmlHelper::number_array( 1, 99, 1 )
						),
											    
						array(	
							'name' 	=> __( 'Section custom height', 'avia_framework' ),
							'desc' 	=> __( 'Define a minimum height for the section. Use a pixel value. eg: 500px', 'avia_framework' ) ,
							'id' 	=> 'min_height_px',
							'required'	=> array( 'min_height', 'equals', 'custom' ),
							'std' 	=> '500px',
							'lockable'	=> true,
							'type' 	=> 'input'),
						
						/* EP >> */
						array(
							"name" 	=> __("Section container width",'avia_framework' ),
							"id" 	=> "custom_container",
							"desc"  => __("Use default container width for this section or set a custom one",'avia_framework' ),
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(   __('Default','avia_framework' )	=>'',
												  __('Full Width','avia_framework' )	=> 'fwd',
												  __('Custom','avia_framework' )	=> 'custom',
											  )),

						array(	
							"name" 	=> __("Custom container width", 'avia_framework' ),
							"id" 	=> "custom_container_width",
							"required"=> array('custom_container','equals','custom'),
							"std" 	=> "1100px",
							'lockable'	=> true,
							"type" 	=> "input"),
						/* << EP */
				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Section Height', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_section_height' ), $template );
			
			$c = array(

						array(
							'name' => '',
							'desc'   => '',
							'nodescription' => 1,
							'type' => 'icon_switcher_container',
						),
				
						array(
							'type' => 'icon_switcher',
							'name' => __( 'Desktop', 'avia_framework' ),
							'icon' => 'desktop',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Section Padding (Desktop)', 'avia_framework' ),
							'id' 	=> 'padding',
							'desc'  => __( 'Define the sections top and bottom padding', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> 'default',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'No Padding', 'avia_framework' )		=> 'no-padding',
											__( 'Small Padding', 'avia_framework' )		=> 'small',
											__( 'Default Padding', 'avia_framework' )	=> 'default',
											__( 'Large Padding', 'avia_framework' )		=> 'large',
											__( 'Huge Padding', 'avia_framework' )		=> 'huge',
										)
						),

						array(
							'name' 	=> __( 'Custom top and bottom padding (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom padding. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_padding',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'padding','not','no-padding' ),
							'multi'		=> array(
												'top'		=> __( 'Padding-Top', 'avia_framework' ),
												'bottom'	=> __( 'Padding-Bottom', 'avia_framework' ),
											)
						),
												    
						array(
							'name' 	=> __( 'Custom top and bottom margin (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'If checked allows you to set a custom top and bottom margin. Otherwise the margin is calculated by the theme based on surrounding elements', 'avia_framework' ),
							'id' 	=> 'margin',
							'type' 	=> 'checkbox',
							'std' 	=> '',
							'lockable'	=> true,
						),

						array(
							'name' 	=> __( 'Custom top and bottom margin (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_margin',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '0px',
							'lockable'	=> true,
							'required' => array( 'margin', 'not','' ),
							'multi'		=> array(
												'top'		=> __( 'Margin-Top', 'avia_framework' ),
												'bottom'	=> __( 'Margin-Bottom', 'avia_framework' ),
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
						),
			
						array(
							'type' => 'icon_switcher',
							'name' => __( 'Tablet', 'avia_framework' ),
							'icon' => 'tablet-landscape',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Section Padding (Tablet)', 'avia_framework' ),
							'id' 	=> 'padding_tablet',
							'desc'  => __( 'Define the sections top and bottom padding', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Inherit', 'avia_framework' )		=> '',
											__( 'No Padding', 'avia_framework' )		=> 'no-padding',
											__( 'Small Padding', 'avia_framework' )		=> 'small',
											__( 'Default Padding', 'avia_framework' )	=> 'default',
											__( 'Large Padding', 'avia_framework' )		=> 'large',
											__( 'Huge Padding', 'avia_framework' )		=> 'huge',
										)
						),

						array(
							'name' 	=> __( 'Custom top and bottom padding (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom padding. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_padding_tablet',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'padding_tablet','not','no-padding' ),
							'multi'		=> array(
												'top'		=> __( 'Padding-Top', 'avia_framework' ),
												'bottom'	=> __( 'Padding-Bottom', 'avia_framework' ),
											)
						),
												    
						array(
							'name' 	=> __( 'Custom top and bottom margin (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'If checked allows you to set a custom top and bottom margin. Otherwise the margin is calculated by the theme based on surrounding elements', 'avia_framework' ),
							'id' 	=> 'margin_tablet',
							'type' 	=> 'checkbox',
							'std' 	=> '',
							'lockable'	=> true,
						),

						array(
							'name' 	=> __( 'Custom top and bottom margin (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_margin_tablet',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'margin_tablet', 'not','' ),
							'multi'		=> array(
												'top'		=> __( 'Margin-Top', 'avia_framework' ),
												'bottom'	=> __( 'Margin-Bottom', 'avia_framework' ),
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
						),

						array(
							'type' => 'icon_switcher',
							'name' => __( 'Mobile', 'avia_framework' ),
							'icon' => 'mobile',
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Section Padding (Mobile)', 'avia_framework' ),
							'id' 	=> 'padding_mobile',
							'desc'  => __( 'Define the sections top and bottom padding', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Inherit', 'avia_framework' )		=> '',
											__( 'No Padding', 'avia_framework' )		=> 'no-padding',
											__( 'Small Padding', 'avia_framework' )		=> 'small',
											__( 'Default Padding', 'avia_framework' )	=> 'default',
											__( 'Large Padding', 'avia_framework' )		=> 'large',
											__( 'Huge Padding', 'avia_framework' )		=> 'huge',
										)
						),

						array(
							'name' 	=> __( 'Custom top and bottom padding (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom padding. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_padding_mobile',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'padding_mobile','not','no-padding' ),
							'multi'		=> array(
												'top'		=> __( 'Padding-Top', 'avia_framework' ),
												'bottom'	=> __( 'Padding-Bottom', 'avia_framework' ),
											)
						),
												    
						array(
							'name' 	=> __( 'Custom top and bottom margin (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'If checked allows you to set a custom top and bottom margin. Otherwise the margin is calculated by the theme based on surrounding elements', 'avia_framework' ),
							'id' 	=> 'margin_mobile',
							'type' 	=> 'checkbox',
							'std' 	=> '',
							'lockable'	=> true,
						),

						array(
							'name' 	=> __( 'Custom top and bottom margin (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;', 'avia_framework' ),
							'id' 	=> 'custom_margin_mobile',
							'type' 	=> 'multi_input',
							'sync' 	=> true,
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'margin_mobile', 'not','' ),
							'multi'		=> array(
												'top'		=> __( 'Margin-Top', 'avia_framework' ),
												'bottom'	=> __( 'Margin-Bottom', 'avia_framework' ),
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
						),
						
						array(
							'type' => 'icon_switcher_container_close',
							'nodescription' => 1,
						),

									
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Margin and Padding', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_margin_padding' ), $template );
			
			/**
			 * Styling Tab
			 * ===========
			 */
			
			$c = array(
						array(
							'name' 	=> __( 'Section Colors', 'avia_framework' ),
							'id' 	=> 'color',
							'desc'  => __( 'The section will use the color scheme you select. Color schemes are defined on your styling page', 'avia_framework' ) .
									   '<br/><a target="_blank" href="' . admin_url('admin.php?page=avia#goto_styling') . '">' . __( '(Show Styling Page)', 'avia_framework' ) . '</a>',
							'type' 	=> 'select',
							'std' 	=> 'main_color',
							'lockable'	=> true,
							'subtype' =>  array_flip( $avia_config['color_sets'] )
						),
								
						array(
							'name' 	=> __( 'Background', 'avia_framework' ),
							'desc' 	=> __( 'Select the type of background for the column.', 'avia_framework' ),
							'id' 	=> 'background',
							'type' 	=> 'select',
							'std' 	=> 'bg_color',
							'lockable'	=> true,
							'subtype' => array(
											__( 'Background Color', 'avia_framework' )		=> 'bg_color',
											__( 'Background Gradient', 'avia_framework' )	=> 'bg_gradient',
										)
						),
								
						array(
							'name' 	=> __( 'Custom Background Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom background color for this cell here. Leave empty for default color', 'avia_framework' ),
							'id' 	=> 'custom_bg',
							'type' 	=> 'colorpicker',
							'required' => array( 'background', 'equals', 'bg_color' ),
							'rgba' 	=> true,
							'std' 	=> '',
							'lockable'	=> true
						),
								
						array(
							'name' 	=> __( 'Background Gradient Color 1', 'avia_framework' ),
							'desc' 	=> __( 'Select the first color for the gradient.', 'avia_framework' ),
							'id' 	=> 'background_gradient_color1',
							'type' 	=> 'colorpicker',
							'container_class' => 'av_third av_third_first',
							'required' => array( 'background', 'equals', 'bg_gradient' ),
							'rgba' 	=> true,
							'std' 	=> '',
							'lockable'	=> true
						),
				
						array(
							'name' 	=> __( 'Background Gradient Color 2', 'avia_framework' ),
							'desc' 	=> __( 'Select the second color for the gradient.', 'avia_framework' ),
							'id' 	=> 'background_gradient_color2',
							'type' 	=> 'colorpicker',
							'container_class' => 'av_third',
							'required' => array( 'background', 'equals', 'bg_gradient' ),
							'rgba' 	=> true,
							'std' 	=> '',
							'lockable'	=> true
						),
								
						array(
							'name' 	=> __( 'Background Gradient Direction','avia_framework' ),
							'desc' 	=> __( 'Define the gradient direction', 'avia_framework' ),
							'id' 	=> 'background_gradient_direction',
							'type' 	=> 'select',
							'container_class' => 'av_third',
							'std' 	=> 'vertical',
							'lockable'	=> true,
							'required' => array( 'background', 'equals', 'bg_gradient' ),
							'subtype' => array(
											__( 'Vertical', 'avia_framework' )	=> 'vertical',
											__( 'Horizontal', 'avia_framework' )	=> 'horizontal',
											__( 'Radial', 'avia_framework' )		=> 'radial',
											__( 'Diagonal Top Left to Bottom Right', 'avia_framework' )	=> 'diagonal_tb',
											__( 'Diagonal Bottom Left to Top Right', 'avia_framework' )	=> 'diagonal_bt',
										)
						)
				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Background Colors', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_background_colors' ), $template );
			
			$c = array(
						array(
							'name' 	=> __( 'Custom Background Image', 'avia_framework' ),
							'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library. Leave empty if you want to use the background image of the color scheme defined above', 'avia_framework' ),
							'id' 	=> 'src',
							'type' 	=> 'image',
							'title' => __( 'Insert Image', 'avia_framework' ),
							'button' => __( 'Insert', 'avia_framework' ),
							'std' 	=> '',
							'lockable'	=> true
						),
									
						array(
							'name' 	=> __( 'Background Attachment', 'avia_framework' ),
							'desc' 	=> __( 'Background can either scroll with the page, be fixed or scroll with a parallax motion', 'avia_framework' ),
							'id' 	=> 'attach',
							'type' 	=> 'select',
							'std' 	=> 'scroll',
							'lockable'	=> true,
							'required' => array('src','not',''),
							'subtype' => array(
											__( 'Scroll', 'avia_framework' )	=> 'scroll',
											__( 'Fixed', 'avia_framework' )		=> 'fixed',
											__( 'Parallax', 'avia_framework' )	=> 'parallax'
										)
						),
				
						array(
							'type'			=> 'template',
							'template_id'	=> 'background_image_position',
							'args'			=> array(
													'id_pos'		=> 'position',
													'id_repeat'		=> 'repeat'
												)
						),

						/* EP >> */
						array(
							"name" 	=> __("Alternate Background Image for Mobile?",'avia_framework' ),
							"desc" 	=> __("You can set an alternate image for mobile here.", 'avia_framework' ),
							"id" 	=> "mobile_image",
							"type" 	=> "checkbox",
							"container_class" 	=> "av_half av_half_first",
							"std" 	=> "",
							'lockable'	=> true
						),
					
			
						array(
								"name" 	=> __("Make the swap at Tablet breakpoint",'avia_framework' ),
								"desc" 	=> __("You can set the alternate image to change at tablet breakpoint (989px)", 'avia_framework' ),
								"id" 	=> "mobile_image_tablet",
								"type" 	=> "checkbox",
								"container_class" => "av_half",
								"required"=> array('mobile_image','not_empty_and',''),
								"std" 	=> "",
								'lockable'	=> true
						),
			
						array(
								"name" 	=> __("Insert Image (Mobile)",'avia_framework' ),
								"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
								"id" 	=> "src_mobile",
								"type" 	=> "image",
								"title" => __("Insert Image",'avia_framework' ),
								"required"=> array('mobile_image','not_empty_and',''),
								"button" => __("Insert",'avia_framework' ),
								"std" 	=> "",
								'lockable'	=> true
						)
						/* << EP */

				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Background Image', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_background_image' ), $template );
			
			$c = array(
						array(	
							'name' 	=> __( 'Background Video', 'avia_framework' ),
							'desc' 	=> __( 'You can also place a video as background for your section. Enter the URL to the Video. Currently supported are Youtube, Vimeo and direct linking of web-video files (mp4, webm, ogv)', 'avia_framework' ) . '<br/><br/>' .
								__( 'Working examples Youtube & Vimeo:', 'avia_framework' ) . '<br/>
								<strong>http://vimeo.com/1084537</strong><br/> 
								<strong>http://www.youtube.com/watch?v=5guMumPFBag</strong><br/><br/>',
							'id' 	=> 'video',
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'input'
						),
													
						array(	
							'name' 	=> __( 'Video Aspect Ratio', 'avia_framework' ),
							'desc' 	=> __( 'In order to calculate the correct height and width for the video slide you need to enter a aspect ratio (width:height). usually: 16:9 or 4:3.', 'avia_framework' ) . '<br/>' . __( 'If left empty 16:9 will be used', 'avia_framework' ) ,
							'id' 	=> 'video_ratio',
							'required'=> array( 'video', 'not', '' ),
							'std' 	=> '16:9',
							'lockable'	=> true,
							'type' 	=> 'input'
						),
												
						array(	
							'name' 	=> __( 'Hide video on Mobile Devices?', 'avia_framework' ),
							'desc' 	=> __( 'You can choose to hide the video entirely on Mobile devices and instead display the Section Background image', 'avia_framework' ) . '<br/><small>' . __( "Most mobile devices can't autoplay videos to prevent bandwidth problems for the user", 'avia_framework' ) . '</small>' ,
							'id' 	=> 'video_mobile_disabled',
							'required'=> array( 'video', 'not', '' ),
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'checkbox'
						),

				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Background Video', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_background_video' ), $template );
			
			$c = array(
						array(	
							'name' 	=> __( 'Enable Overlay?', 'avia_framework' ),
							'desc' 	=> __( 'Check if you want to display a transparent color and/or pattern overlay above your section background image/video', 'avia_framework' ),
							'id' 	=> 'overlay_enable',
							'type' 	=> 'checkbox',
							'std' 	=> '',
							'lockable'	=> true,
						),
						
						array(
							'name' => '',
							'desc'   => '',
							'nodescription' => 1,
							'type' => 'icon_switcher_container',
							'required' => array( 'overlay_enable', 'not', '' ),
						),
				
						array(
							'type' => 'icon_switcher',
							'name' => __( 'Desktop', 'avia_framework' ),
							'icon' => 'desktop',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' ),
						),

						array(
							'name' 	=> __( 'Overlay Opacity (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Set the opacity of your overlay: 0.1 is barely visible, 1.0 is opaque ', 'avia_framework' ),
							'id' 	=> 'overlay_opacity',
							'type' 	=> 'select',
							'std' 	=> '0.5',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array(   
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
							'name' 	=> __( 'Overlay Color (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom color for your overlay here. Leave empty if you want no color overlay', 'avia_framework' ),
							'id' 	=> 'overlay_color',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' )							
						),
										  	
						array(
							'name'		=> __( 'Background Image (Desktop)', 'avia_framework' ),
							'desc'		=> __( 'Select an existing or upload a new background image', 'avia_framework' ),
							'id'		=> 'overlay_pattern',
							'type'		=> 'select',
							'std'		=> '',
							'folder'	=> 'images/background-images/',
							'folderlabel'	=> '',
							'group'		=> __( 'Select predefined pattern', 'avia_framework' ),
							'exclude'	=> array( 'fullsize-', 'gradient' ),
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array( 
												__( 'No Background Image', 'avia_framework' )	=> '',
												__( 'Upload custom image', 'avia_framework' )	=> 'custom'
											)
						),

						array(
							'name'		=> __( 'Custom Pattern (Desktop)', 'avia_framework' ),
							'desc'		=> __( 'Upload your own seamless pattern', 'avia_framework' ),
							'id'		=> 'overlay_custom_pattern',
							'type'		=> 'image',
							'fetch'		=> 'url',
							'secondary_img'	=> true,
							'title'		=> __( 'Insert Pattern', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std'		=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_pattern', 'equals', 'custom' )
						),

						array(
							'name' 	=> __( 'Background Attachment (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Background can either scroll with the page, be fixed or scroll.', 'avia_framework' ),
							'id' 	=> 'overlay_attach',
							'type' 	=> 'select',
							'std' 	=> 'scroll',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Scroll', 'avia_framework' )	=> 'scroll',
											__( 'Fixed', 'avia_framework' )		=> 'fixed'
										)
						),
						
						array(
							"name" 	=> __( "Background Image Position (Desktop)",'avia_framework' ),
							"id" 	=> "overlay_position",
							"type" 	=> "select",
							"std" 	=> "top left",
							'lockable'	=> true,
							"subtype" => array(
											__( 'Top Left', 'avia_framework' )       => 'top left',
											__( 'Top Center', 'avia_framework' )     => 'top center',
											__( 'Top Right', 'avia_framework' )      => 'top right',
											__( 'Bottom Left', 'avia_framework' )    => 'bottom left',
											__( 'Bottom Center', 'avia_framework' )  => 'bottom center',
											__( 'Bottom Right', 'avia_framework' )   => 'bottom right',
											__( 'Center Left', 'avia_framework' )    => 'center left',
											__( 'Center Center', 'avia_framework' )  => 'center center',
											__( 'Center Right', 'avia_framework' )   => 'center right'
										)
						),

						array(
							'name' 	=> __( 'Background Repeat (Desktop)', 'avia_framework' ),
							"id" 	=> "overlay_repeat",
							"type" 	=> "select",
							"std" 	=> "repeat",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'No Repeat','avia_framework' )          =>'no-repeat',
											__( 'Repeat','avia_framework' )             =>'repeat',
											__( 'Tile Horizontally','avia_framework' )  =>'repeat-x',
											__( 'Tile Vertically','avia_framework' )    =>'repeat-y',
										)
						),

						array(
							'name' 	=> __( 'Background Size (Desktop)', 'avia_framework' ),
							"id" 	=> "overlay_size",
							"type" 	=> "select",
							"std" 	=> "stretch",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'Auto','avia_framework' ) => 'auto',
											__( 'Stretch to fit (stretches image to cover the element)','avia_framework' )     =>'stretch',
											__( 'Scale to fit (scales image so the whole image is always visible)','avia_framework' )     =>'contain',
											__( 'Custom' ) => 'custom',
										)
						),

						array(
							'name'  => __( 'Custom Background Size (Desktop)', 'avia_framework' ),
							'id'    => 'overlay_size_custom',
							'type' 	=> 'input',
							"required" => array( "overlay_size", "equals", "custom" ),
							'lockable' => true,
							'std'   => ''
						),


						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' )
						),
			
						array(
							'type' => 'icon_switcher',
							'name' => __( 'Tablet', 'avia_framework' ),
							'icon' => 'tablet-landscape',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' )
						),

						array(
							'name' 	=> __( 'Overlay Opacity (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Set the opacity of your overlay: 0.1 is barely visible, 1.0 is opaque ', 'avia_framework' ),
							'id' 	=> 'overlay_opacity_tablet',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array(   
											__( 'Inherit', 'avia_framework' )	=> '',
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
							'name' 	=> __( 'Overlay Color (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom color for your overlay here. Leave empty if you want no color overlay', 'avia_framework' ),
							'id' 	=> 'overlay_color_tablet',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' )							
						),
										  	
						array(
							'name'		=> __( 'Background Image (Tablet)', 'avia_framework' ),
							'desc'		=> __( 'Select an existing or upload a new background image', 'avia_framework' ),
							'id'		=> 'overlay_pattern_tablet',
							'type'		=> 'select',
							'std'		=> '',
							'folder'	=> 'images/background-images/',
							'folderlabel'	=> '',
							'group'		=> __( 'Select predefined pattern', 'avia_framework' ),
							'exclude'	=> array( 'fullsize-', 'gradient' ),
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array( 
												__( 'Inherit', 'avia_framework' )	=> '',
												__( 'No Background Image', 'avia_framework' )	=> 'none',
												__( 'Upload custom image', 'avia_framework' )	=> 'custom'
											)
						),

						array(
							'name'		=> __( 'Custom Pattern (Tablet)', 'avia_framework' ),
							'desc'		=> __( 'Upload your own seamless pattern', 'avia_framework' ),
							'id'		=> 'overlay_custom_pattern_tablet',
							'type'		=> 'image',
							'fetch'		=> 'url',
							'secondary_img'	=> true,
							'title'		=> __( 'Insert Pattern', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std'		=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_pattern_tablet', 'equals', 'custom' )
						),

						array(
							'name' 	=> __( 'Background Attachment (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Background can either scroll with the page, be fixed or scroll.', 'avia_framework' ),
							'id' 	=> 'overlay_attach_tablet',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Inherit', 'avia_framework' )	=> '',
											__( 'Scroll', 'avia_framework' )	=> 'scroll',
											__( 'Fixed', 'avia_framework' )		=> 'fixed'
										)
						),
						
						array(
							"name" 	=> __( "Background Image Position (Tablet)",'avia_framework' ),
							"id" 	=> "overlay_position_tablet",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(
											__( 'Inherit', 'avia_framework' )	=> '',
											__( 'Top Left', 'avia_framework' )       => 'top left',
											__( 'Top Center', 'avia_framework' )     => 'top center',
											__( 'Top Right', 'avia_framework' )      => 'top right',
											__( 'Bottom Left', 'avia_framework' )    => 'bottom left',
											__( 'Bottom Center', 'avia_framework' )  => 'bottom center',
											__( 'Bottom Right', 'avia_framework' )   => 'bottom right',
											__( 'Center Left', 'avia_framework' )    => 'center left',
											__( 'Center Center', 'avia_framework' )  => 'center center',
											__( 'Center Right', 'avia_framework' )   => 'center right'
										)
						),
	
						array(
							'name' 	=> __( 'Background Repeat (Tablet)', 'avia_framework' ),
							"id" 	=> "overlay_repeat_tablet",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'Inherit','avia_framework' ) => '',
											__( 'No Repeat','avia_framework' )          =>'no-repeat',
											__( 'Repeat','avia_framework' )             =>'repeat',
											__( 'Tile Horizontally','avia_framework' )  =>'repeat-x',
											__( 'Tile Vertically','avia_framework' )    =>'repeat-y',
										)
						),

						array(
							'name' 	=> __( 'Background Size (Tablet)', 'avia_framework' ),
							"id" 	=> "overlay_size_tablet",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'Inherit','avia_framework' ) => '',
											__( 'Auto','avia_framework' ) => 'auto',
											__( 'Stretch to fit (stretches image to cover the element)','avia_framework' )     =>'stretch',
											__( 'Scale to fit (scales image so the whole image is always visible)','avia_framework' )     =>'contain',
											__( 'Custom' ) => 'custom',
										)
						),

						array(
							'name'  => __( 'Custom Background Size (Tablet)', 'avia_framework' ),
							'id'    => 'overlay_size_custom_tablet',
							'type' 	=> 'input',
							"required" => array( "overlay_size_tablet", "equals", "custom" ),
							'lockable' => true,
							'std'   => ''
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' )
						),

						array(
							'type' => 'icon_switcher',
							'name' => __( 'Mobile', 'avia_framework' ),
							'icon' => 'mobile',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' ),
						),
				
						array(
							'name' 	=> __( 'Overlay Opacity (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Set the opacity of your overlay: 0.1 is barely visible, 1.0 is opaque ', 'avia_framework' ),
							'id' 	=> 'overlay_opacity_mobile',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array(   
											__( 'Inherit', 'avia_framework' )	=> '',
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
							'name' 	=> __( 'Overlay Color (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom color for your overlay here. Leave empty if you want no color overlay', 'avia_framework' ),
							'id' 	=> 'overlay_color_mobile',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' )							
						),
										  	
						array(
							'name'		=> __( 'Background Image (Mobile)', 'avia_framework' ),
							'desc'		=> __( 'Select an existing or upload a new background image', 'avia_framework' ),
							'id'		=> 'overlay_pattern_mobile',
							'type'		=> 'select',
							'std'		=> '',
							'folder'	=> 'images/background-images/',
							'folderlabel'	=> '',
							'group'		=> __( 'Select predefined pattern', 'avia_framework' ),
							'exclude'	=> array( 'fullsize-', 'gradient' ),
							'lockable'	=> true,
							'required'	=> array( 'overlay_enable', 'not', '' ),
							'subtype'	=> array( 
												__( 'Inherit', 'avia_framework' )	=> '',
												__( 'No Background Image', 'avia_framework' )	=> 'none',
												__( 'Upload custom image', 'avia_framework' )	=> 'custom'
											)
						),

						array(
							'name'		=> __( 'Custom Pattern (Mobile)', 'avia_framework' ),
							'desc'		=> __( 'Upload your own seamless pattern', 'avia_framework' ),
							'id'		=> 'overlay_custom_pattern_mobile',
							'type'		=> 'image',
							'fetch'		=> 'url',
							'secondary_img'	=> true,
							'title'		=> __( 'Insert Pattern', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std'		=> '',
							'lockable'	=> true,
							'required'	=> array( 'overlay_pattern_mobile', 'equals', 'custom' )
						),

						array(
							'name' 	=> __( 'Background Attachment (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Background can either scroll with the page, be fixed or scroll.', 'avia_framework' ),
							'id' 	=> 'overlay_attach_mobile',
							'type' 	=> 'select',
							'std' 	=> '',
							'lockable'	=> true,
							'subtype'	=> array(
											__( 'Inherit', 'avia_framework' )	=> '',
											__( 'Scroll', 'avia_framework' )	=> 'scroll',
											__( 'Fixed', 'avia_framework' )		=> 'fixed'
										)
						),
						
						array(
							"name" 	=> __( "Background Image Position (Mobile)",'avia_framework' ),
							"id" 	=> "overlay_position_mobile",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(
											__( 'Inherit', 'avia_framework' )	=> '',
											__( 'Top Left', 'avia_framework' )       => 'top left',
											__( 'Top Center', 'avia_framework' )     => 'top center',
											__( 'Top Right', 'avia_framework' )      => 'top right',
											__( 'Bottom Left', 'avia_framework' )    => 'bottom left',
											__( 'Bottom Center', 'avia_framework' )  => 'bottom center',
											__( 'Bottom Right', 'avia_framework' )   => 'bottom right',
											__( 'Center Left', 'avia_framework' )    => 'center left',
											__( 'Center Center', 'avia_framework' )  => 'center center',
											__( 'Center Right', 'avia_framework' )   => 'center right'
										)
						),
	
						array(
							'name' 	=> __( 'Background Repeat (Mobile)', 'avia_framework' ),
							"id" 	=> "overlay_repeat_mobile",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'Inherit', 'avia_framework' )	=> '',
											__( 'No Repeat','avia_framework' )          =>'no-repeat',
											__( 'Repeat','avia_framework' )             =>'repeat',
											__( 'Tile Horizontally','avia_framework' )  =>'repeat-x',
											__( 'Tile Vertically','avia_framework' )    =>'repeat-y',
										)
						),

						array(
							'name' 	=> __( 'Background Size (Mobile)', 'avia_framework' ),
							"id" 	=> "overlay_size_mobile",
							"type" 	=> "select",
							"std" 	=> "",
							'lockable'	=> true,
							"subtype" => array(	
											__( 'Inherit','avia_framework' )     =>'',
											__( 'Auto','avia_framework' )  => 'auto',
											__( 'Stretch to fit (stretches image to cover the element)','avia_framework' )     =>'stretch',
											__( 'Scale to fit (scales image so the whole image is always visible)','avia_framework' )     =>'contain',
											__( 'Custom' ) => 'custom',
										)
						),

						array(
							'name'  => __( 'Custom Background Size (Mobile)', 'avia_framework' ),
							'id'    => 'overlay_size_custom_mobile',
							'type' 	=> 'input',
							"required" => array( "overlay_size_mobile", "equals", "custom" ),
							'lockable' => true,
							'std'   => ''
						),

						array(
							'type' => 'icon_switcher_close',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' )
						),
						
						array(
							'type' => 'icon_switcher_container_close',
							'nodescription' => 1,
							'required' => array( 'overlay_enable', 'not', '' )
						),


				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Background Overlay', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_background_overlay' ), $template );
			
			$c = array(
						array(
							'name' 	=> __( 'Section Top Border Styling', 'avia_framework' ),
							'id' 	=> 'shadow',
							'desc'  => __( 'Choose a border styling for the top of your section', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> 'no-border-styling',
							'lockable'	=> true,
							'subtype' => array( 
											__( 'Display a simple 1px top border', 'avia_framework' )	=> 'no-shadow',  
											__( 'Display a small styling shadow at the top of the section', 'avia_framework' )	=> 'shadow',
											__( 'No border styling', 'avia_framework' )	=> 'no-border-styling',
										)
						),

						array(
							'name' 	=> __( 'Section Bottom Border Styling', 'avia_framework' ),
							'id' 	=> 'bottom_border',
							'desc'  => __( 'Choose a border styling for the bottom of your section', 'avia_framework' ),
							'type' 	=> 'select',
							'std' 	=> 'no-border-styling',
							'lockable'	=> true,
							'subtype' => array(   
											__( 'No border styling', 'avia_framework' )	=> 'no-border-styling',
											__( 'Display a small arrow that points down to the next section', 'avia_framework' )	=> 'border-extra-arrow-down',
											__( 'Diagonal section border', 'avia_framework' )	=> 'border-extra-diagonal',
										)
						),

						array(
							'name' 		=> __( 'Diagonal Border: Color', 'avia_framework' ),
							'desc' 		=> __( 'Select a custom background color for your Section border here.', 'avia_framework' ),
							'id' 		=> 'bottom_border_diagonal_color',
							'type' 		=> 'colorpicker',
							'container_class' 	=> 'av_third av_third_first',
							'required' => array( 'bottom_border', 'contains', 'diagonal' ),
							'std' 		=> '#333333',
							'lockable'	=> true,
						),
											
						array(
							'name' 	=> __( 'Diagonal Border: Direction','avia_framework' ),
							'desc' 	=> __( 'Set the direction of the diagonal border', 'avia_framework' ),
							'id' 	=> 'bottom_border_diagonal_direction',
							'type' 	=> 'select',
							'std' 	=> 'scroll',
							'lockable'	=> true,
							'container_class' 	=> 'av_third',
							'required' => array( 'bottom_border', 'contains', 'diagonal' ),
							'subtype' => array(
											__( 'Slanting from left to right', 'avia_framework' )	=> '',
											__( 'Slanting from right to left', 'avia_framework' )	=> 'border-extra-diagonal-inverse'
										)
						),

						array(
							'name' 	=> __( 'Diagonal Border Box Style', 'avia_framework' ),
							'desc' 	=> __( 'Set the style shadow of the border', 'avia_framework' ),
							'id' 	=> 'bottom_border_style',
							'type' 	=> 'select',
							'std' 	=> 'scroll',
							'lockable'	=> true,
							'container_class' 	=> 'av_third',
							'required' => array( 'bottom_border', 'contains', 'diagonal' ),
							'subtype' => array(
											__( 'Minimal', 'avia_framework' )	=> '',
											__( 'Box shadow', 'avia_framework' )	=> 'diagonal-box-shadow'
										)
						)
				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Borders', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_borders' ), $template );
			
			$c = array(
						array(
							'name' 	=> __( 'Display a scroll down arrow', 'avia_framework' ),
							'desc' 	=> __( 'Check if you want to show a button at the bottom of the section that takes the user to the next section by scrolling down', 'avia_framework' ) ,
							'id' 	=> 'scroll_down',
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'checkbox'
						),

						array(
							'name' 	=> __( 'Custom Arrow Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom arrow color. Leave empty if you want to use the default arrow color and style', 'avia_framework' ),
							'id' 	=> 'custom_arrow_bg',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'lockable'	=> true,
							'required' => array( 'scroll_down', 'not', '' ),
						)		
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Scroll Down Arrow', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_arrow' ), $template );
			
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
			extract( $params );

			$name = $this->config['shortcode'];
			$data['shortcodehandler'] 	= $this->config['shortcode'];
			$data['modal_title'] 		= $this->config['name'];
			$data['modal_ajax_hook'] 	= $this->config['shortcode'];
			$data['dragdrop-level'] 	= $this->config['drag-level'];
			$data['allowed-shortcodes']	= $this->config['shortcode'];
			$data['preview'] 			= ! empty( $this->config['preview'] ) ? $this->config['preview'] : 0;

			$title_id = ! empty( $args['id'] ) ? ': ' . ucfirst( $args['id'] ) : '';

			// add background color or gradient to indicator
			$el_bg = '';

			if( empty( $args['background'] ) || ( $args['background'] == 'bg_color' ) )
			{
				$el_bg = ! empty( $args['custom_bg'] ) ? " style='background:{$args['custom_bg']};'" : '';
			}
			else 
			{
				if( $args['background_gradient_color1'] && $args['background_gradient_color2'] ) 
				{
					$el_bg = "style='background:linear-gradient({$args['background_gradient_color1']},{$args['background_gradient_color2']});'";
				}
			}



			$hidden_el_active = ! empty( $args['av_element_hidden_in_editor'] ) ? 'av-layout-element-closed' : '';

			if( ! empty( $this->config['modal_on_load'] ) )
			{
				$data['modal_on_load'] 	= $this->config['modal_on_load'];
			}

			$dataString  = AviaHelper::create_data_string( $data );

			$output  = "<div class='avia_layout_section {$hidden_el_active} avia_pop_class avia-no-visual-updates {$name} av_drag' {$dataString}>";

			$output .=		"<div class='avia_sorthandle menu-item-handle'>";
			$output .=			"<span class='avia-element-title'><span class='avia-element-bg-color' {$el_bg}></span>{$this->config['name']}<span class='avia-element-title-id'>{$title_id}</span></span>";
			//$output .=		"<a class='avia-new-target'  href='#new-target' title='".__('Move Section','avia_framework' )."'>+</a>";
			$output .=			"<a class='avia-delete'  href='#delete' title='" . __( 'Delete Section', 'avia_framework' ) . "'>x</a>";
			$output .=			"<a class='avia-toggle-visibility'  href='#toggle' title='" . __( 'Show/Hide Section', 'avia_framework' ) . "'></a>";

			if( ! empty( $this->config['popup_editor'] ) )
			{
				$output .=		"<a class='avia-edit-element'  href='#edit-element' title='" . __( 'Edit Section', 'avia_framework' ) . "'>edit</a>";
			}
			
			$output .=			"<a class='avia-save-element'  href='#save-element' title='" . __( 'Save Element as Template','avia_framework' ) . "'>+</a>";
			$output .= "        <a class='avia-clone'  href='#clone' title='" . __('Clone Section','avia_framework' ) . "' >" . __('Clone Section','avia_framework' ) . '</a>';
			$output .=		'</div>';
			$output .=		"<div class='avia_inner_shortcode avia_connect_sort av_drop' data-dragdrop-level='{$this->config['drop-level']}'>";
			$output .=			"<textarea data-name='text-shortcode' cols='20' rows='4'>" . ShortcodeHelper::create_shortcode_by_array( $name, $content, $args ) . '</textarea>';
			if( $content )
			{
				$content = $this->builder->do_shortcode_backend( $content );
			}
			$output .=			$content;
			$output .=		'</div>';
				
			$output .=		"<div class='avia-layout-element-bg' " . $this->get_bg_string($args) . '></div>';


			$output .=		"<a class='avia-layout-element-hidden' href='#'>" . __( 'Section content hidden. Click here to show it', 'avia_framework' ) . '</a>';

			$output .= '</div>';

			return $output;
		}
			
			
		/**
		 * 
		 * @param array $args
		 * @return string
		 */
		function get_bg_string( $args )
		{
				$style = '';
			
				if( ! empty( $args['attachment'] ) )
				{
					$image = false;
					$src = wp_get_attachment_image_src( $args['attachment'], $args['attachment_size'] );
					if( ! empty($src[0] ) ) 
					{
						$image = $src[0];
					}
					
					if( $image )
					{
						$bg 	= ! empty( $args['custom_bg'] ) ? 	$args['custom_bg'] : 'transparent'; $bg = 'transparent';
						$pos 	= ! empty( $args['position'] )  ? 	$args['position'] : 'center center';
						$repeat = ! empty( $args['repeat'] ) ?		$args['repeat'] : 'no-repeat';
						$extra	= '';
						
						if( $repeat == 'stretch' )
						{
							$repeat = 'no-repeat';
							$extra = 'background-size: cover;';
						}
						
						if( $repeat == 'contain' )
						{
							$repeat = 'no-repeat';
							$extra = 'background-size: contain;';
						}
						
						$style = "style='background: $bg url($image) $repeat $pos; $extra'";
					}
				}
				
				return $style;
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
				global $avia_config;
				
				extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

				avia_sc_section::$section_count ++;
				
				$default = array(
					'ep_style'			=> '',
					'src'				=> '', 
					'position'			=> 'top left', 
					'repeat'			=> 'no-repeat', 
					'attach'			=> 'scroll', 
					'color'				=> 'main_color',
					'background'		=> '',
					'custom_bg'			=> '',
					'background_gradient_color1'		=> '',
					'background_gradient_color2'		=> '',
					'background_gradient_direction'		=> '',
					'padding'			=> 'default' ,
					'custom_padding' 	=> '',
					'margin'			=> '',
					'custom_margin'		=> '',
					'padding_tablet'		=> '',
					'custom_padding_tablet' => '',
					'margin_tablet'			=> '',
					'custom_margin_tablet'	=> '',
					'padding_mobile'		=> '' ,
					'custom_padding_mobile' => '',
					'margin_mobile'			=> '',
					'custom_margin_mobile'	=> '',
					'shadow'			=> 'shadow', 
					'id'				=> '', 
					'min_height'		=> '', 
					'min_height_pc'		=> 25,
					'min_height_px'		=> '', 
					'video'				=> '', 
					'video_ratio'		=>' 16:9', 
					'video_mobile_disabled'	=>'',
					'custom_markup'		=> '',
					'attachment'		=> '',
					'attachment_size'	=> '',
					'bottom_border'		=> '',
					/* Section overlay */
					'overlay_enable'	=> '',
					'overlay_opacity'	=> '',
					'overlay_color'		=> '',
					'overlay_pattern'	=> '',
					'overlay_custom_pattern' => '',	
					'overlay_attach' => 'scroll',
					'overlay_position' => 'top left',
					'overlay_repeat' => 'repeat',
					'overlay_size' => 'auto',
					'overlay_size_custom' => '',
					/* Section overlay tablet */
					'overlay_opacity_tablet'	=> '',
					'overlay_color_tablet'		=> '',
					'overlay_pattern_tablet'	=> '',
					'overlay_custom_pattern_tablet'	=> '',
					'overlay_attach_tablet' => '',
					'overlay_position_tablet' => '',
					'overlay_repeat_tablet' => '',
					'overlay_size_tablet' => '',
					'overlay_size_custom_tablet' => '',
					/* Section overlay mobile */
					'overlay_opacity_mobile'	=> '',
					'overlay_color_mobile'		=> '',
					'overlay_pattern_mobile'	=> '',
					'overlay_custom_pattern_mobile'	=> '',
					'overlay_attach_mobile' => '',
					'overlay_position_mobile' => '',
					'overlay_repeat_mobile' => '',
					'overlay_size_mobile' => '',
					'overlay_size_custom_mobile' => '',
					'scroll_down'		=> '',
					'bottom_border_diagonal_color'		=> '',
					'bottom_border_diagonal_direction'	=> '',
					'bottom_border_style'				=> '',
					'custom_arrow_bg'					=> '',
					'mobile_image' => '',
					'mobile_image_tablet' => '',
					'src_mobile' => '',
					'z_index' => '',
					'custom_container' => '', 
					'custom_container_width' => '',
				);

				if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
					$default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );
					//	we skip $content override as we only allow styling of section to be locked
					$locked = array();
					Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked );
					Avia_Element_Templates()->add_template_class( $meta, $atts, $default );
				}

				$atts = shortcode_atts( $default, $atts, $this->config['shortcode'] );		    							
			    							
				if( 'percent' == $atts['min_height'] )
				{
					$atts['min_height'] = $atts['min_height_pc'];
				}
				
				extract( $atts );
								
				$section_padding_class = "avia-section-{$padding}";
				if( ! empty( $padding_tablet ) ) $section_padding_class .= " avia-section-tablet-{$padding_tablet}";
				if( ! empty( $padding_mobile ) ) $section_padding_class .= " avia-section-mobile-{$padding_mobile}";

				$output      = '';
			    $class       = "avia-section {$color} {$section_padding_class} avia-{$shadow} ";
			    $background  = '';
				$src		 = '';
				$params	= array();
				
				$params['id'] = AviaHelper::save_string( $id, '-', 'av_section_' . avia_sc_section::$section_count );
				$params['custom_markup'] = $meta['custom_markup'];
				$params['aria_label'] = $meta['aria_label'];
				$params['attach'] = '';

				if( ! empty( $attachment ) && ! empty( $attachment_size ) ) {
					/**
					 * Allows e.g. WPML to reroute to translated image
					 */
					$posts = get_posts( array(
											'include'			=> $attachment,
											'post_status'		=> 'inherit',
											'post_type'			=> 'attachment',
											'post_mime_type'	=> 'image',
											'order'				=> 'ASC',
											'orderby'			=> 'post__in' )
										);
					/* EP >> */
					$explode_attachment_size = explode( ',', $attachment_size);
					
					if( is_array( $posts ) && ! empty( $posts ) ) {
						$attachment_entry = $posts[0];
	                	
						/* Default */
						if( !empty( $explode_attachment_size[0] ) ) {
							$src = wp_get_attachment_image_src( $attachment_entry->ID, $attachment_size );
							$src = !empty($src[0]) ? $src[0] : "";
						}

						/* Mobile */
						if( !empty( $explode_attachment_size[1] ) ) {
							$mobile_attachment_entry = $posts[1];
							if( !empty( $explode_attachment_size[1] ) ) {
								$src_mobile = wp_get_attachment_image_src( $mobile_attachment_entry->ID, $explode_attachment_size[1] );
								$src_mobile = !empty( $src_mobile[0] ) ? $src_mobile[0] : "";
							}
						}
					}
					/* << EP */

				} else {
					$attachment = false;
				}


                // background gradient

                $gradient_val = '';

                if( $atts['background'] == 'bg_gradient' ) {
                    if ( $atts['background_gradient_color1'] && $atts['background_gradient_color2'] ) {

                        switch ( $atts['background_gradient_direction'] ) {
                            case 'vertical':
                                $gradient_val .= 'linear-gradient(';
                                break;
                            case 'horizontal':
                                $gradient_val .= 'linear-gradient(to right,';
                                break;
                            case 'radial':
                                $gradient_val .= 'radial-gradient(';
                                break;
                            case 'diagonal_tb':
                                $gradient_val .= 'linear-gradient(to bottom right,';
                                break;
                            case 'diagonal_bt':
                                $gradient_val .= 'linear-gradient(45deg,';
                                break;
                        }

                        $gradient_val .= $atts['background_gradient_color1'].','.$atts['background_gradient_color2'].')';

                        // Fallback background color for IE9
                        if( $custom_bg == '' ) {
							$background .= "background-color: {$atts['background_gradient_color1']};";
						}
                    }
                }

				
				if( $custom_bg != '' ) {
			        $background .= "background-color: {$custom_bg}; ";
			    }


				/*set background image*/
				if( $src != '' ) {

					/* Only add data-lazy-bg if not first section */
					$params['data'] = avia_sc_section::$section_count !== 1 ? 'data-lazy-bg' : '';

					/* Auto add ep-lazy-loaded class if first section or if ep-bg-lazy-load is not a theme support (added by epf) */
					if( avia_sc_section::$section_count == 1 || ! current_theme_supports( "ep-bg-lazy-load" ) ) {
						$class .= " ep-lazy-loaded";
					}

					if( $repeat == 'stretch' ) {
						$background .= 'background-repeat: no-repeat; ';
						$class .= ' avia-full-stretch';
					} else if( $repeat == 'contain' ) {
						$background .= 'background-repeat: no-repeat; ';
						$class .= ' avia-full-contain';
					} else {
						$background .= "background-repeat: {$repeat}; ";
					}
					
					/* EP >> */
					$gradient_val = $gradient_val !== '' ? ", {$gradient_val}" : "";

					if( empty( $mobile_image ) ) { 
						$background .= "--epBGImg: url({$src}){$gradient_val};";
					} else {
						$background .= "--epBGImgDesktop: url({$src}){$gradient_val};";

						if( empty( $mobile_image_tablet ) ) {
							$background .= "--epBGImgTablet: var(--epBGImgDesktop); --epBGImgMobile: url({$src_mobile}){$gradient_val};";
						} else {
							$background .= "--epBGImgTablet: url({$src_mobile}){$gradient_val};--epBGImgMobile: var(--epBGImgTablet);";
						}												
					}
					/* << EP */

					 
					$background .= ';';
				    $background .= $attach == 'parallax' ? 'background-attachment: scroll; ' : "background-attachment: {$attach}; ";
				    $background .= "background-position: {$position}; ";
				     
				     
				     
				    if( $attach == 'parallax' ) {
						$attachment_class = '';
						if($repeat == 'stretch' || $repeat == 'no-repeat' ){ $attachment_class .= ' avia-full-stretch'; }
						if($repeat == 'contain'  ){ $attachment_class .= ' avia-full-contain'; }
					
						$class .= ' av-parallax-section';
						$speed = apply_filters( 'avf_parallax_speed', '0.3', $params['id'] ); 
						$params['attach'] .= "<div class='av-parallax' data-avia-parallax-ratio='{$speed}' >";
						$params['attach'] .= "<div class='av-parallax-inner {$color} {$attachment_class}' style = '{$background}' >";
						$params['attach'] .= '</div>';
						$params['attach'] .= '</div>';
						$background = '';
					}
					
					$params['data'] .= " data-section-bg-repeat='{$repeat}'";
					
				} else if( ! empty( $gradient_val ) ) {
					$attach = 'scroll';
					if( $gradient_val !== '' ) {
                        $background .= "background-image: {$gradient_val};";
                    }
				}
				
				
				if( $custom_bg != '' && $background == '' ) {
			        $background .= "background-color: {$custom_bg}; ";
			    }

				/* Margin and Custom Margin */
				$custom_margin_style = "";
				$has_responsive_margin = false;
				$margin_top_prop = 'margin-top';
				$margin_bottom_prop = 'margin-bottom';

				if( ( ! empty( $margin_tablet ) || ! empty( $custom_margin_tablet ) ) || ( ! empty( $margin_mobile ) || ! empty( $custom_margin_mobile ) ) ) {
					$has_responsive_margin = true;
					$margin_top_prop = '--epMarginTopDesktop';
					$margin_bottom_prop = '--epMarginBottomDesktop';
				}

                if( ! empty( $margin ) ){ 
                    $explode_custom_margin = explode( ',', $custom_margin );
                    if( count( $explode_custom_margin ) > 1 ) {
                        $atts[$margin_top_prop] = $explode_custom_margin['0'];
                        $atts[$margin_bottom_prop] = $explode_custom_margin['1'];
                    } else {
                        $atts[$margin_top_prop] = $custom_margin;
                        $atts[$margin_bottom_prop] = $custom_margin;
                    }
                }

				if( $has_responsive_margin ){

					if( ! empty( $margin_tablet ) ){ 
						$explode_custom_margin_tablet = explode( ',', $custom_margin_tablet );
						if( count( $explode_custom_margin_tablet ) > 1 ) {
							$atts['--epMarginTopTablet'] = $explode_custom_margin_tablet['0'];
							$atts['--epMarginBottomTablet'] = $explode_custom_margin_tablet['1'];
						} else {
							$atts['--epMarginTopTablet'] = $custom_margin_tablet;
							$atts['--epMarginBottomTablet'] = $custom_margin_tablet;
						}
					}


					if( ! empty( $margin_mobile ) ){ 
						$explode_custom_margin_mobile = explode( ',', $custom_margin_mobile );
						if( count( $explode_custom_margin_mobile ) > 1 ) {
							$atts['--epMarginTopMobile'] = $explode_custom_margin_mobile['0'];
							$atts['--epMarginBottomMobile'] = $explode_custom_margin_mobile['1'];
						} else {
							$atts['--epMarginTopMobile'] = $custom_margin_mobile;
							$atts['--epMarginBottomMobile'] = $custom_margin_mobile;
						}
					}

				}

                $custom_margin_style .= AviaHelper::style_string( $atts, $margin_top_prop );
                $custom_margin_style .= AviaHelper::style_string( $atts, $margin_bottom_prop );
				$custom_margin_style .= AviaHelper::style_string( $atts, '--epMarginTopTablet' );
				$custom_margin_style .= AviaHelper::style_string( $atts, '--epMarginBottomTablet' );
				$custom_margin_style .= AviaHelper::style_string( $atts, '--epMarginTopMobile' );
				$custom_margin_style .= AviaHelper::style_string( $atts, '--epMarginBottomMobile' );
				
				/* EP >> */
				/* z-index style */
				$z_index_style = "";
				if ( ! empty( $atts['z_index'] ) ){
					$atts['z-index'] = $atts['z_index'];
					$z_index_style .= AviaHelper::style_string( $atts, 'z-index' );
					$class .= " has-z-index";
				}
				
                /* Padding and Custom Padding */
				$custom_padding_style = "";
				$has_responsive_padding = false;
				$padding_top_prop = 'padding-top';
				$padding_bottom_prop = 'padding-bottom';

				if( ( ! empty( $padding_tablet ) || ! empty( $custom_padding_tablet ) ) || ( ! empty( $padding_mobile ) || ! empty( $custom_padding_mobile ) ) ) {
					$has_responsive_padding = true;
					$padding_top_prop = '--epPaddingTopDesktop';
					$padding_bottom_prop = '--epPaddingBottomDesktop';
				}

				if ( $padding !== 'no-padding' && ! empty( $custom_padding ) ){
					$explode_custom_padding = explode( ',', $custom_padding );
					if( count( $explode_custom_padding ) > 1 ) {
						$atts[$padding_top_prop] = $explode_custom_padding['0'];
						$atts[$padding_bottom_prop] = $explode_custom_padding['1'];
					} else {
						$atts[$padding_top_prop] = $custom_padding;
						$atts[$padding_bottom_prop] = $custom_padding;
					}
				}

				if( $has_responsive_padding ){
					if ( $padding_tablet !== 'no-padding' && ! empty( $custom_padding_tablet ) ){
						$explode_custom_padding_tablet = explode( ',', $custom_padding_tablet );
						if( count( $explode_custom_padding_tablet ) > 1 ) {
							$atts['--epPaddingTopTablet'] = $explode_custom_padding_tablet['0'];
							$atts['--epPaddingBottomTablet'] = $explode_custom_padding_tablet['1'];
						} else {
							$atts['--epPaddingTopTablet'] = $custom_padding_tablet;
							$atts['--epPaddingBottomTablet'] = $custom_padding_tablet;
						}
					}

					if ( $padding_mobile !== 'no-padding' && ! empty( $custom_padding_mobile ) ){
						$explode_custom_padding_mobile = explode( ',', $custom_padding_mobile );
						if( count( $explode_custom_padding_mobile ) > 1 ) {
							$atts['--epPaddingTopMobile'] = $explode_custom_padding_mobile['0'];
							$atts['--epPaddingBottomMobile'] = $explode_custom_padding_mobile['1'];
						} else {
							$atts['--epPaddingTopMobile'] = $custom_padding_mobile;
							$atts['--epPaddingBottomMobile'] = $custom_padding_mobile;
						}
					}
				}

				$custom_padding_style .= AviaHelper::style_string( $atts, $padding_top_prop );
				$custom_padding_style .= AviaHelper::style_string( $atts, $padding_bottom_prop );
				$custom_padding_style .= AviaHelper::style_string( $atts, '--epPaddingTopTablet' );
				$custom_padding_style .= AviaHelper::style_string( $atts, '--epPaddingBottomTablet' );
				$custom_padding_style .= AviaHelper::style_string( $atts, '--epPaddingTopMobile' );
				$custom_padding_style .= AviaHelper::style_string( $atts, '--epPaddingBottomMobile' );

                /*check/create overlay*/

				/**
				 * If overlay_repeat is == 'contain' or 'stretch' assign overlay_size to that value as a fallback, compat
				 * 
				 * responsive model:
				 * 
				 *  if no mobile && no tablet >>
				 * 		set normal (all screen) property in style
				 *  else
				 * 		set desktop property as variable
				 * 		if mobile
				 * 			set mobile property as variable
				 * 		if tablet
				 * 			set tablet property as variable
				 */

				/* Backwards compat thing, if repeat is set to old options value, do the corresponding re-'setting' */
				if( $overlay_repeat == 'contain' || $overlay_repeat == 'stretch' ) {
					$overlay_size = $overlay_repeat;
					$overlay_repeat = "no-repeat";
				}
				if( $overlay_repeat_tablet == 'contain' || $overlay_repeat_tablet == 'stretch' ) {
					$overlay_size_tablet = $overlay_repeat_tablet;
					$overlay_repeat_tablet = "no-repeat";
				}
				if( $overlay_repeat_mobile == 'contain' || $overlay_repeat_mobile == 'stretch' ) {
					$overlay_size_mobile = $overlay_repeat_mobile;
					$overlay_repeat_mobile = "no-repeat";
				}

				$overlay 	= '';
				$pre_wrap 	= "<div class='av-section-color-overlay-wrap'>" ;
				if( ! empty( $overlay_enable ) ) {
					$overlay_src = '';
					$overlay_src_tablet = '';
					$overlay_src_mobile = '';
					$overlay_class = '';

					if( empty( $overlay_opacity_tablet ) && empty( $overlay_opacity_mobile ) ) {
						$overlay .= "opacity: {$overlay_opacity}; ";
					} else {
						$overlay .= "--epOpacityDesktop: {$overlay_opacity}; ";
						if( ! empty( $overlay_opacity_tablet ) ) {
							$overlay .= "--epOpacityTablet: {$overlay_opacity_tablet}; ";
						}
						if( ! empty( $overlay_opacity_mobile ) ) {
							$overlay .= "--epOpacityMobile: {$overlay_opacity_mobile}; ";
						}
					}
					
					if( empty( $overlay_color_tablet ) && empty( $overlay_color_mobile ) ) {
						if( ! empty( $overlay_color ) )  {
							$overlay .= "background-color: {$overlay_color}; ";
						}
					} else {
						if( ! empty( $overlay_color ) )  {
							$overlay .= "--epBGColorDesktop: {$overlay_color}; ";
						}
						if( ! empty( $overlay_color_tablet ) ) {
							$overlay .= "--epBGColorTablet: {$overlay_color_tablet}; ";
						}
						if( ! empty( $overlay_color_mobile ) ) {
							$overlay .= "--epBGColorMobile: {$overlay_color_mobile}; ";
						}
					}
					
					/**
					 * Sets overlay src for all screens, predefined or custom
					 */
					if( ! empty( $overlay_pattern ) ) {
						if( $overlay_pattern == 'custom' ) {
							$overlay_src = $overlay_custom_pattern;
						} else {
							$overlay_src = str_replace( '{{AVIA_BASE_URL}}', AVIA_BASE_URL, $overlay_pattern );
						}
					}

					if( ! empty( $overlay_pattern_tablet ) ) {
						if( $overlay_pattern_tablet == 'custom' ) {
							$overlay_src_tablet = $overlay_custom_pattern_tablet;
						} else {
							$overlay_src_tablet = str_replace( '{{AVIA_BASE_URL}}', AVIA_BASE_URL, $overlay_pattern_tablet );
						}
					}

					if( ! empty( $overlay_pattern_mobile ) ) {
						if( $overlay_pattern_mobile == 'custom' ) {
							$overlay_src_mobile = $overlay_custom_pattern_mobile;
						} else {
							$overlay_src_mobile = str_replace( '{{AVIA_BASE_URL}}', AVIA_BASE_URL, $overlay_pattern_mobile );
						}
					}

					/**
					 * Overlay Repeat
					 */
					if( empty( $overlay_repeat_tablet ) && empty( $overlay_repeat_mobile ) ) {
						if( $overlay_repeat ) $overlay .= "background-repeat: {$overlay_repeat}; ";
					} else {
						if( $overlay_repeat ) $overlay .= "--epBGRepeatDesktop: {$overlay_repeat};";
						if( $overlay_repeat_tablet ) $overlay .= "--epBGRepeatTablet: {$overlay_repeat_tablet};";
						if( $overlay_repeat_mobile ) $overlay .= "--epBGRepeatMobile: {$overlay_repeat_mobile};";
					}

					/**
					 * Overlay Size
					 */
					if( empty( $overlay_size_tablet ) && empty( $overlay_size_mobile ) ) {
						if( $overlay_size == 'stretch' ) {
							$overlay_class .= " avia-full-stretch";
						} else if( $overlay_size == "contain" ) {
							$overlay_class .= " avia-full-contain";
						} else if( $overlay_size == "custom" ) {
							$overlay .= "background-size: {$overlay_size_custom} !important; ";
						}
					} else {
						/* convert overlay option value from 'stretch' to 'cover' */
						$overlay_size = $overlay_size == 'stretch' ? 'cover' : $overlay_size;
						$overlay_size_tablet = $overlay_size_tablet == 'stretch' ? 'cover' : $overlay_size_tablet;
						$overlay_size_mobile  = $overlay_size_mobile == 'stretch' ? 'cover' : $overlay_size_mobile;

						$overlay .= "--epBGSizeDesktop: " . ( $overlay_size == "custom" ? $overlay_size_custom : $overlay_size ) . ";";
						if( $overlay_size_tablet ) {
							$overlay .= "--epBGSizeTablet: " . ( $overlay_size_tablet == "custom" ? $overlay_size_custom_tablet : $overlay_size_tablet ) . ";";
						}

						if( $overlay_size_mobile ) {
							$overlay .= "--epBGSizeMobile: " . ( $overlay_size_mobile == "custom" ? $overlay_size_custom_mobile : $overlay_size_mobile ) . ";";
						}
					}
					
					/**
					 * Overlay attach
					 */
					if( empty( $overlay_attach_tablet ) && empty( $overlay_attach_mobile ) ) {
						if( $overlay_attach ) $overlay .= "background-attachment: {$overlay_attach}; ";
					} else {
						if( $overlay_attach ) $overlay .= "--epBGAttachDesktop: {$overlay_attach}; ";
						if( $overlay_attach_tablet ) $overlay .= "--epBGAttachTablet: {$overlay_attach_tablet}; ";
						if( $overlay_attach_mobile ) $overlay .= "--epBGAttachMobile: {$overlay_attach_mobile}; ";
					}

					/**
					 * Overlay position
					 */
					if( empty( $overlay_position_tablet ) && empty( $overlay_position_mobile ) ) {
						if( $overlay_position ) $overlay .= "background-position: {$overlay_position}; ";
					} else {
						if( $overlay_position ) $overlay .= "--epBGPosDesktop: {$overlay_position}; ";
						if( $overlay_position_tablet ) $overlay .= "--epBGPosTablet: {$overlay_position_tablet}; ";
						if( $overlay_position_mobile ) $overlay .= "--epBGPosMobile: {$overlay_position_mobile}; ";
					}
					

					/**
					 * Overlay background image setting
					 */
					$overlay_has_responsive_bg = false;
					if( ! empty( $overlay_src ) )  {
						if( empty( $overlay_src_tablet ) && empty( $overlay_src_mobile ) ) {
							$overlay .= "--epBGImg: url({$overlay_src});";
						} else {
							$overlay_has_responsive_bg = true;
							$overlay .= "--epBGImgDesktop: url({$overlay_src});";
						}
					}
					
					if( ! empty( $overlay_src_tablet ) ) {
						$overlay .= $overlay_src_tablet == 'none' ? "--epBGImgTablet: {$overlay_src_tablet};" : "--epBGImgTablet: url({$overlay_src_tablet});";
					} else {
						if( $overlay_has_responsive_bg ) $overlay .= "--epBGImgTablet: var(--epBGImgDesktop);";
					}
					
					if( ! empty( $overlay_src_mobile ) ) {
						$overlay .= $overlay_src_mobile == 'none' ? "--epBGImgMobile: {$overlay_src_mobile};" : "--epBGImgMobile: url({$overlay_src_mobile});";
					} else {
						if( $overlay_has_responsive_bg ) $overlay .= "--epBGImgMobile: var(--epBGImgTablet);";
					}

					
					/* Only add data-lazy-bg if not first section */
					$data_lazy_bg = avia_sc_section::$section_count !== 1 ? 'data-lazy-bg' : '';

					/* Auto add ep-lazy-loaded class if first section or if ep-bg-lazy-load is not a theme support (added by epf) */
					if( avia_sc_section::$section_count == 1 || ! current_theme_supports( "ep-bg-lazy-load" ) ) {
						$overlay_class .= " ep-lazy-loaded";
					}

					$overlay = "<div class='av-section-color-overlay {$overlay_class}' style='{$overlay}' {$data_lazy_bg}></div>";
					$class .= ' av-section-color-overlay-active';
					
					$params['attach'] .= $pre_wrap . $overlay;
					
				}
				/* << EP */

				
				if( ! empty( $scroll_down ) )
				{	
					$arrow_style = '';
					$arrow_class = '';
					
					if( ! $overlay )
					{
						$params['attach'] .= $pre_wrap;	
					}
					
					if( ! empty( $custom_arrow_bg ) )
					{
						$arrow_style = "style='color: {$custom_arrow_bg};'";
						$arrow_class = " av-custom-scroll-down-color";
					}
					
					$params['attach'] .= "<a href='#next-section' title='' class='scroll-down-link {$arrow_class}' {$arrow_style} " . av_icon_string( 'scrolldown' ) . '></a>';
				}
			    
			    
			    
				$class .= " avia-bg-style-{$attach}";
			    $params['class'] = $class . ' ' . $meta['el_class'] . ' ' . $av_display_classes;
			    $params['bg'] = $background;
                $params['custom_margin'] = $custom_margin_style;
				$params['min_height'] = $min_height;
				$params['min_height_px'] = $min_height_px;
				$params['video'] = $video;
				$params['video_ratio'] = $video_ratio;
				$params['video_mobile_disabled'] = $video_mobile_disabled;
				/* EP >> */
				$params['z_index'] = $z_index_style;
				$params['custom_padding'] = $custom_padding_style;
				$params['custom_container'] = $custom_container;
				$params['custom_container_width'] = $custom_container_width;
				/* << EP */
				

			    if( isset( $meta['index'] ) && $meta['index'] >= 0 )
			    {
			    	if( $meta['index'] == 0 ) 
			    	{
			    		$params['main_container'] = true;
			    	}
			    	
			    	if( $meta['index'] == 0 || ( isset( $meta['siblings']['prev']['tag'] ) && in_array( $meta['siblings']['prev']['tag'], AviaBuilder::$full_el_no_section ) ) )
			    	{
			    		$params['close'] = false;
			    	}
			    }
			    
			    if( $bottom_border == 'border-extra-arrow-down' )
			    {
				    $params['class'] .= ' av-arrow-down-section';
			    }
			    
				$avia_config['layout_container'] = 'section';
				
				$output .= avia_new_section( $params, $meta );
				$output .=  ShortcodeHelper::avia_remove_autop( $content, true ) ;
				
				/*set extra arrow element*/
				if( strpos( $bottom_border, 'border-extra' ) !== false )
				{
					$backgroundEl = '';
					$backgroundElColor = ! empty( $custom_bg ) ? $custom_bg : $avia_config['backend_colors']['color_set'][ $color ]['bg'];
					
					if( strpos( $bottom_border, 'diagonal') !== false )
					{
						// bottom_border_diagonal_direction // bottom_border_diagonal_color
						$backgroundElColor = '#333333';
						if( isset( $bottom_border_diagonal_color ) ) 
						{
							$backgroundElColor = $bottom_border_diagonal_color;
						}
						
						$bottom_border .= ' ' . $bottom_border_diagonal_direction . ' ' . $bottom_border_style;
					}
					
					if( $backgroundElColor ) 
					{
						$backgroundEl = " style='background-color:{$backgroundElColor};' ";
					}
					
					avia_sc_section::$add_to_closing = "<div class='av-extra-border-element {$bottom_border}'><div class='av-extra-border-outer'><div class='av-extra-border-inner' {$backgroundEl}></div></div></div>";
				}
				else
				{
					avia_sc_section::$add_to_closing = '';
				}
				
				
				//next section needs an extra closing tag if overlay with wrapper was added:
				if( $overlay || ! empty( $scroll_down ) ) 
				{ 
					avia_sc_section::$close_overlay = '</div>';
				}
				else
				{
					avia_sc_section::$close_overlay = '';
				}
				
				//if the next tag is a section dont create a new section from this shortcode
				if( ! empty( $meta['siblings']['next']['tag'] ) && in_array( $meta['siblings']['next']['tag'], AviaBuilder::$full_el ) )
				{
				    $skipSecond = true;
				}

				//if there is no next element dont create a new section. if we got a sidebar always create a next section at the bottom
				if( empty( $meta['siblings']['next']['tag'] ) && ! avia_has_sidebar() )
				{
				    $skipSecond = true;
				}

				if( empty( $skipSecond ) )
				{
					$new_params['id'] = 'after_section_' . avia_sc_section::$section_count;
					$output .= avia_new_section( $new_params );
				}
				
				unset($avia_config['layout_container']);
				return $output;
			}
	}
}



if( ! function_exists( 'avia_new_section' ) )
{
	function avia_new_section( $params = array(), $meta = array() )
	{
		global $avia_section_markup, $avia_config;
		
	    $defaults = array(	
						'class'				=> 'main_color', 
						'bg'				=> '',
						'custom_margin'		=> '',
						'close'				=> true,
						'open'				=> true, 
						'open_structure'	=> true, 
						'open_color_wrap'	=> true, 
						'data'				=> '', 
						'style'				=> '', 
						'id'				=> '', 
						'main_container'	=> false, 
						'min_height'		=> '',
						'min_height_px'		=> '',
						'video'				=> '',
						'video_ratio'		=> '16:9',
						'video_mobile_disabled'	=> '',
						'attach'			=> '',
						'before_new'		=> '',
						'custom_markup'		=> '',
						'aria_label'		=> '',			//	set to true to force id as label
						/* EP >> */
						'custom_padding' => '',
						'z_index' => '',
						'custom_container' => '', 
	    				'custom_container_width' => '', 
						/* << EP */
					);
	    
	    
	    
	    $defaults = array_merge( $defaults, $params );
		
	    extract( $defaults );

	    $post_class = '';
	    $output     = '';
	    $bg_slider  = '';
	    $container_style = '';
		$id_val = $id;
		/* EP >> */
		$content_style = "";
		/* << EP */
		
	    $id =  ! empty( $id_val ) ? "id='{$id_val}'" : '';
				
		if( ! empty( $aria_label ) || ! empty( $id_val ) )
		{
			if( true === $aria_label )
			{
				$label = $id_val;
			}
			else if ( ! empty( $aria_label ) )
			{
				$label = $aria_label;
			}
			else
			{
				$label = '';
			}
			
			$aria_label = ! empty( $label ) ? "aria-label='{$label}'" : '';
		}
		else 
		{
			$aria_label = '';
		}
		
	
	    //close old content structure. only necessary when previous element was a section. other fullwidth elements dont need this
	    if( $close ) 
	    {
	    	$cm = avia_section_close_markup();
			
			$output .= "</div></div>{$cm}</div>" . avia_sc_section::$add_to_closing . avia_sc_section::$close_overlay . '</div>';
			avia_sc_section::$add_to_closing = '';
	    	avia_sc_section::$close_overlay = '';
		}
		
	    //start new
	    if( $open )
	    {	
	        if( function_exists('avia_get_the_id') ) 
			{
				$post_class = 'post-entry-' . avia_get_the_id();
			}
	
	        if( $open_color_wrap )
	        {
				if( ! empty( $min_height ) || ! empty( $custom_container ) ) {
	        		$container_style 	= "style=";
				}
				
	        	if( ! empty( $min_height ) ) 
	        	{
					$class .= " av-minimum-height av-minimum-height-{$min_height} ";
					
					if( is_numeric( $min_height ) )
					{
						$data .= " data-av_minimum_height_pc='{$min_height}'";
					}
					
	        		if( $min_height == 'custom' && $min_height_px != '' )
	        		{
	        			$min_height_px 		= (int) $min_height_px;
	        			$container_style 	.= "height:{$min_height_px}px;";
	        		}
				}
				
				/* EP >> */
				if( !empty( $custom_container_width ) && $custom_container == 'custom' ) {
	        		$container_style .= "--containerWidth:{$custom_container_width};max-width:{$custom_container_width};";
	        	}

	        	if( $custom_container == 'fwd' ) {
					$class 	.= " avia-section-fwd";
	        	}

				if( !empty( $custom_padding ) ) {
					$content_style = AviaHelper::style_string( $custom_padding );
				}
				/* << EP */

				if( ! empty( $video ) )
				{
					$slide = array(
								'shortcode'	=> 'av_slide',
								'content'	=> '',
								'attr'		=> array(
													'id'				=> '',
													'video'				=> $video ,
													'slide_type'		=> 'video',
													'video_mute'		=> true,
													'video_loop'		=> true,
													'video_ratio'		=> $video_ratio,
													'video_controls'	=> 'disabled',
													'video_section_bg'	=> true,
													'video_format'		=> '',
													'video_mobile'		=> '',
													'video_mobile_disabled'	=> $video_mobile_disabled
												)
								);

					$sc_class = Avia_Builder()->get_shortcode_class( 'av_slideshow' );

					$video_atts = array();
					$video_content = array( $slide );

					$bg_slider = $sc_class->get_avia_slideshow_object( $video_atts, $video_content, 'av_slideshow', array() );
					if( $bg_slider instanceof avia_slideshow )
					{
						$bg_slider->set_extra_class( 'av-section-video-bg' );
						$bg_slider_html = $bg_slider->html();
					}

					$class .= ' av-section-with-video-bg';
					$class .= ! empty( $video_mobile_disabled ) ? ' av-section-mobile-video-disabled' : '';
					$data .= " data-section-video-ratio='{$video_ratio}'";
				}

	        	$output .= $before_new;

	        	
	        	//fix version 4.5.1 by Kriesi
	        	//we cant just overwrite style since it might be passed by a function. eg the menu element passes z-index. need to merge the style strings
				
				/* EP >> */
				$extra_style = "{$bg} {$custom_margin} {$z_index}";
				/* << EP */
	        	$style = trim($style);
	        	if( empty( $style ) ) 
	        	{
		        	$style = "style='{$extra_style}' ";
		        }
		        else
		        {
			        $style = str_replace( "style='", "style='{$extra_style} ", $style );
			        $style = str_replace( 'style="', 'style="' . $extra_style . ' ', $style );
		        }
	        	
	        	
	        	if( $class == 'main_color' ) 
				{
					$class .= ' av_default_container_wrap';
				}
	        	
				$wrapper_data = apply_filters( "avf_ep_section_wrapper_data", "", $meta );

	        	$output .= "<div {$id} {$aria_label} class='{$class} container_wrap " . avia_layout_class( 'main' , false ) . "' {$style} {$data} {$wrapper_data}>";
	        	$output .= ! empty( $bg_slider ) ? $bg_slider->html() : '';
	        	$output .= $attach;
				
	        	$output .= apply_filters( 'avf_section_container_add', '', $defaults );
	        }
	
			
			//this applies only for sections. other fullwidth elements dont need the container for centering
	        if( $open_structure )
	        {
	        	if( ! empty( $main_container ) )
	        	{
					$markup = 'main ' . avia_markup_helper( array( 'context' => 'content', 'echo' => false, 'custom_markup' => $custom_markup ) );
					$avia_section_markup = 'main';
				}
				else
				{
					$markup = 'div';
				}
				
		        $output .= "<div class='container' {$container_style}>";
		        $output .= "<{$markup} class='template-page content  " . avia_layout_class( 'content', false ) . " units' {$content_style}>";
		        $output .= "<div class='post-entry post-entry-type-page {$post_class}'>";
		        $output .= "<div class='entry-content-wrapper clearfix'>";
	        }
	    }
	    return $output;
	
	}
}



if( ! function_exists( 'avia_section_close_markup' ) )
{
	function avia_section_close_markup()
	{
		global $avia_section_markup, $avia_config;
		
		if( ! empty( $avia_section_markup ) )
		{
			$avia_section_markup = false;
			$close_markup = '</main><!-- close content main element -->';
			
		}
		else
		{
			$close_markup = '</div><!-- close content main div -->'; 
		}
		
		return $close_markup;
	}
}

if( ! function_exists( 'avia_section_after_element_content' ) )
{
	function avia_section_after_element_content( $meta, $second_id = '', $skipSecond = false, $extra = '' )
	{
		$output = '</div>'; //close section
		$output .= $extra;
					
		//if the next tag is a section dont create a new section from this shortcode
		if( ! empty($meta['siblings']['next']['tag'] ) && in_array( $meta['siblings']['next']['tag'], AviaBuilder::$full_el ) )
		{ 
			$skipSecond = true; 
		}
	
		//if there is no next element dont create a new section.
		if( empty( $meta['siblings']['next']['tag'] ) ) 
		{ 
			$skipSecond = true; 
		}
		
		if( empty( $skipSecond ) ) 
		{ 
			$output .= avia_new_section(array('close'=>false, 'id' => $second_id)); 
		}
		
		return $output;
	}
}

