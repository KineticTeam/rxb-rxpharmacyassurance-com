<?php
/**
 * Special Heading
 * 
 * Creates a special Heading
 */
 
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) { die( '-1' ); }



if ( ! class_exists( 'avia_sc_heading' ) ) 
{
	class avia_sc_heading extends aviaShortcodeTemplate
	{
			
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';

			$this->config['name']		= __( 'Special Heading', 'avia_framework' );
			$this->config['tab']		= __( 'Content Elements', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-heading.png';
			$this->config['order']		= 93;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_heading';
			$this->config['modal_data'] = array('modal_class' => 'mediumscreen');
			$this->config['tooltip'] 	= __( 'Creates a special Heading', 'avia_framework' );
			$this->config['preview'] 	= true;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
		}

		function extra_assets()
		{
			//load css
			wp_enqueue_style( 'avia-module-heading', AviaBuilder::$path['pluginUrlRoot'] . 'avia-shortcodes/heading/heading.css', array( 'avia-layout' ), false );
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
							'template_id'	=> $this->popup_key( 'content_heading' )
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
													$this->popup_key( 'styling_fonts' ),
													$this->popup_key( 'styling_styles' ),
													$this->popup_key( 'styling_colors' ),
													$this->popup_key( 'styling_spacing' ),
													$this->popup_key( 'styling_animation' )
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
								'template_id'	=> $this->popup_key( 'advanced_link' )
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
								"std" 	=> apply_filters( "avf_ep_heading_style_std", "" ),
								"subtype" => apply_filters( "avf_ep_heading_style_options", array(
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
							"std" 	=> apply_filters( "avf_ep_heading_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_heading_style_options", array() ),
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
					)

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
							'name' 	=> __( 'Heading Text', 'avia_framework' ),
							'id' 	=> 'heading',
							'container_class' => 'avia-element-fullwidth',
							'std' 	=> __( 'Hello', 'avia_framework' ),
							'type' 	=> 'input'
						),
				
						array(	
							'name' 	=> __( 'Heading Tag', 'avia_framework' ),
							'desc' 	=> __( 'Select which kind of heading you want this tag to be.', 'avia_framework' ),
							'id' 	=> 'tag',
							'type' 	=> 'select',
							'std' 	=> 'h3',
							'subtype'	=> array( 'H1'=>'h1', 'H2'=>'h2', 'H3'=>'h3', 'H4'=>'h4', 'H5'=>'h5', 'H6'=>'h6', 'Div' => 'div', 'Span' => 'span' )
						), 

						array(	
							'name' 	=> __( 'Heading Tag Appearance', 'avia_framework' ),
							'desc' 	=> __( 'You can set a custom appearance for this heading tag here, select which heading tag you want this heading to look like (theme CSS needs to support this).', 'avia_framework' ),
							'id' 	=> 'tag_appearance',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype'	=> array( 'Default' => '', 'H1'=>'h1', 'H2'=>'h2', 'H3'=>'h3', 'H4'=>'h4', 'H5'=>'h5', 'H6'=>'h6' )
						), 
				
						array(	
							'name' 	=> __( 'Heading Style', 'avia_framework' ),
							'desc' 	=> __( 'Select a heading style', 'avia_framework' ),
							'id' 	=> 'style',
							'type' 	=> 'select',
							"std" 	=> apply_filters( "avf_av_heading_style_std", "blockquote modern-quote" ),
							"subtype" => apply_filters( "avf_av_heading_style_options", array( 
								__( 'Default Style', 'avia_framework' )								=> '',  
								__( 'Heading Style Modern (left)', 'avia_framework' )				=> 'blockquote modern-quote' , 
								__( 'Heading Style Modern (centered)', 'avia_framework' )			=> 'blockquote modern-quote modern-centered',
								__( 'Heading Style Modern (right)', 'avia_framework' )				=> 'blockquote modern-quote modern-right',
								__( 'Heading Style Classic (left, italic)', 'avia_framework' )		=> 'blockquote classic-quote classic-quote-left',
								__( 'Heading Style Classic (centered, italic)', 'avia_framework' )	=> 'blockquote classic-quote',
								__( 'Heading Style Classic (right, italic)', 'avia_framework' )		=> 'blockquote classic-quote classic-quote-right'
						) ) ),

						array(
							'name' => '',
							'desc'   => '',
							'nodescription' => 1,
							'required'	=> array( 'style', 'not', '' ),
							'type' => 'icon_switcher_container',
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Desktop', 'avia_framework'),
							'icon' => 'desktop',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Heading Alignment (Desktop)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your heading here (Desktop), Note: this will override the above setting (Heading Style).', 'avia_framework' ),
							'id' 	=> 'alignment',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( 'style', 'not', '' ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Align Left', 'avia_framework' )	=> 'left',
												__( 'Align Center', 'avia_framework' )	=> 'center',
												__( 'Align Right', 'avia_framework' )	=> 'right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Tablet', 'avia_framework' ),
							'icon' => 'tablet-landscape',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Heading Alignment (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your heading here (Tablet), Note: this will override the above setting (Heading Style).', 'avia_framework' ),
							'id' 	=> 'tablet_alignment',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( 'style', 'not', '' ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Align Left', 'avia_framework' )	=> 'tablet-left',
												__( 'Align Center', 'avia_framework' )	=> 'tablet-center',
												__( 'Align Right', 'avia_framework' )	=> 'tablet-right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1
						),

						array(
							'type' => 'icon_switcher',
							'name' => __('Mobile', 'avia_framework' ),
							'icon' => 'mobile',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1,
						),

						array(
							'name' 	=> __( 'Heading Alignment (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Choose the alignment of your heading here (Mobile), Note: this will override the above setting (Heading Style).', 'avia_framework' ),
							'id' 	=> 'mobile_alignment',
							'type' 	=> 'select',
							'std' 	=> '',
							'required'	=> array( 'style', 'not', '' ),
							'subtype'	=> array(
												__( 'Default', 'avia_framework' ) => '',
												__( 'Align Left', 'avia_framework' )	=> 'mobile-left',
												__( 'Align Center', 'avia_framework' )	=> 'mobile-center',
												__( 'Align Right', 'avia_framework' )	=> 'mobile-right',
											)
						),

						array(
							'type' => 'icon_switcher_close',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1
						),
						
						array(
							'type' => 'icon_switcher_container_close',
							'required'	=> array( 'style', 'not', '' ),
							'nodescription' => 1
						),
				
						array(	
							'name' 	=> __( 'Subheading', 'avia_framework' ),
							'desc' 	=> __( 'Add an extra descriptive subheading above or below the actual heading', 'avia_framework' ),
							'id' 	=> 'subheading_active',
							'type' 	=> 'select',
							'std' 	=> '',
				            'required'	=> array( 'style', 'not', '' ),
							'subtype'	=> array( 
												__( 'No Subheading', 'avia_framework' )				=> '',  
												__( 'Display subheading outside tag, above text', 'avia_framework' )	=> 'subheading_above',  
												__( 'Display subheading outside tag, below text', 'avia_framework' )	=> 'subheading_below',
												__( 'Display subheading inside tag, above text', 'avia_framework' )		=> 'subheading_above_inside',
												__( 'Display subheading inside tag, below text', 'avia_framework' )		=> 'subheading_below_inside'
											),
							),  							  
							  
						array(
							'name' 	=> __( 'Subheading Text','avia_framework' ),
							'desc' 	=> __( 'Add your subheading here','avia_framework' ),
							'id' 	=> 'content',
							'type' 	=> 'textarea',
							'required' => array( 'subheading_active', 'not', '' ),
							'std' 	=> ''
						),   
				
				);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'content_heading' ), $c );
			
			/**
			 * Styling Tab
			 * ===========
			 */
			
			$font_size_array = array( 
						__( 'Default Size', 'avia_framework' ) => '',
						__( 'Flexible font size (adjusts to screen width)' , 'avia_framework' )	=> AviaHtmlHelper::number_array( 3, 12, 0.5, array(), 'vw', '', 'vw' ),
						__( 'Fixed font size' , 'avia_framework' )								=> AviaHtmlHelper::number_array( 11, 350, 1, array(), 'px', '', '' ),
					);

				
			
			$c = array(
						array(
							'name'			=> __( 'Heading Font Sizes', 'avia_framework' ),
							'desc'			=> __( 'Select a custom font size for the heading.', 'avia_framework' ),
							'type'			=> 'template',
							'template_id'	=> 'font_sizes_icon_switcher',
							'required'		=> array( 'style', 'not', '' ),
							'subtype'		=> array(
												'default'	=> $font_size_array,
												'medium'	=> AviaHtmlHelper::number_array( 10, 200, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'small'		=> AviaHtmlHelper::number_array( 10, 200, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'mini'		=> AviaHtmlHelper::number_array( 10, 200, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' )
											),
							'id_sizes'		=> array(
												'default'	=> 'size',
												'medium'	=> 'av-medium-font-size-title',
												'small'		=> 'av-small-font-size-title',
												'mini'		=> 'av-mini-font-size-title'
											)
						),
				
						array(
							'name'			=> __( 'Subheading Font Sizes', 'avia_framework' ),
							'desc'			=> __( 'Select a custom font size for the Subheading.', 'avia_framework' ),
							'type'			=> 'template',
							'template_id'	=> 'font_sizes_icon_switcher',
							'required'		=> array( 'subheading_active', 'not', '' ),
							'subtype'		=> array(
												'default'	=> AviaHtmlHelper::number_array( 10, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '' ), 'px' ),
												'medium'	=> AviaHtmlHelper::number_array( 10, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'small'		=> AviaHtmlHelper::number_array( 10, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' ),
												'mini'		=> AviaHtmlHelper::number_array( 10, 120, 1, array( __( 'Use Default', 'avia_framework' ) => '', __( 'Hidden', 'avia_framework' ) => 'hidden' ), 'px' )
											),
							'id_sizes'		=> array(
												'default'	=> 'subheading_size',
												'medium'	=> 'av-medium-font-size',
												'small'		=> 'av-small-font-size',
												'mini'		=> 'av-mini-font-size'
											)
						),
				
	
				
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Sizes', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_fonts' ), $template );

			$c = array(
				
				array(	
					"name" 	=> __("Heading Weight", 'avia_framework' ),
					"desc" 	=> __("Font weight for the heading (eg. 300, 400, bold)", 'avia_framework' ),
					"id" 	=> "weight",
					"type" 	=> "input",
					"required" => array( 'style', 'not', '' ),
					"std" => ""
				),


				array(	
					"name" 	=> __("Heading Text Transform", 'avia_framework' ),
					"desc" 	=> __("Text transform for the heading", 'avia_framework' ),
					"id" 	=> "text_transform",
					"type" 	=> "select",
					"subtype" => array( "Default" => "", "None" => "none", "Uppercase" => "uppercase", "Lowercase" => "lowercase", "Capitelize" => "capitalize" ),
					"required" => array( 'style', 'not', '' ),
					"std" => ""
				),

				array(	
					"name" 	=> __("Heading Line height", 'avia_framework' ),
					"desc" 	=> __("Line height for the heading", 'avia_framework' ),
					"id" 	=> "loh",
					"type" 	=> "input",
					"required" => array( 'style', 'not', '' ),
					"std" => ""
				),
		
				array(	
					"name" 	=> __("Heading Letter Spacing", 'avia_framework' ),
					"desc" 	=> __("Letter spacing (text separation) for the heading", 'avia_framework' ),
					"id" 	=> "text_sep",
					"type" 	=> "input",
					"required" => array( 'style', 'not', '' ),
					"std" => ""
				),

				/* Subehading Styles */
				array(	
					"name" 	=> __("Subheading Weight", 'avia_framework' ),
					"desc" 	=> __("Font weight for the heading (eg. 300, 400, bold)", 'avia_framework' ),
					"id" 	=> "subheading_weight",
					"type" 	=> "input",
					"required" => array( 'subheading_active', 'not', '' ),
					"std" => ""
				),


				array(	
					"name" 	=> __("Subheading Text Transform", 'avia_framework' ),
					"desc" 	=> __("Text transform for the heading", 'avia_framework' ),
					"id" 	=> "subheading_text_transform",
					"type" 	=> "select",
					"subtype" => array( "Default" => "", "None" => "none", "Uppercase" => "uppercase", "Lowercase" => "lowercase", "Capitelize" => "capitalize" ),
					"required" => array( 'subheading_active', 'not', '' ),
					"std" => ""
				),

				array(	
					"name" 	=> __("Subheading Line height", 'avia_framework' ),
					"desc" 	=> __("Line height for the heading", 'avia_framework' ),
					"id" 	=> "subheading_loh",
					"type" 	=> "input",
					"required" => array( 'subheading_active', 'not', '' ),
					"std" => ""
				),
		
				array(	
					"name" 	=> __("Subheading Letter Spacing", 'avia_framework' ),
					"desc" 	=> __("Letter spacing (text separation) for the heading", 'avia_framework' ),
					"id" 	=> "subheading_text_sep",
					"type" 	=> "input",
					"required" => array( 'subheading_active', 'not', '' ),
					"std" => ""
				),
				
			);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Font Styles', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_styles' ), $template );
			
			$c = array(
						array(	
							'name' 	=> __( 'Heading Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a heading color', 'avia_framework' ),
							'id' 	=> 'color',
							'type' 	=> 'select',
							'std' 	=> '',
							'subtype'	=> apply_filters( "avf_ep_heading_color_options", array( 
												__( 'Default Color', 'avia_framework' )	=> '', 
												__( 'Meta Color', 'avia_framework' )	=> 'meta-heading', 
												__( 'Custom Color', 'avia_framework' )	=> 'custom-color-heading'
											) )
							), 
					
						array(	
							'name' 	=> __( 'Custom Font Color', 'avia_framework' ),
							'desc' 	=> __( 'Select a custom font color for your Heading here', 'avia_framework' ),
							'id' 	=> 'custom_font',
							'type' 	=> 'colorpicker',
							'std' 	=> '',
							'required' => array( 'color', 'equals', 'custom-color-heading' )
						),

						array(	
							"name" 	=> __("Custom Subheading Font Color", 'avia_framework' ),
							"desc" 	=> __("Select a custom font color for your Heading here", 'avia_framework' ),
							"id" 	=> "custom_subheading_font",
							"type" 	=> "colorpicker",
							"std" 	=> "",
							"required" => array( 'color', 'equals' ,'custom-color-heading' )
						),
						
				);
			
			$template = array(
							array(	
								'type'			=> 'template',
								'template_id'	=> 'toggle',
								'title'			=> __( 'Colors', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_colors' ), $template );
			
			
			$c = array(
						array(	
							'name' 	=> __( 'Margin', 'avia_framework' ),
							'desc' 	=> __( 'Set the distance from the content to other elements here. Leave empty for default value. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt; ', 'avia_framework' ),
							'id' 	=> 'margin',
							'type' 	=> 'multi_input',
							'std' 	=> ',,,,', 
							'sync' 	=> true,
							'multi' => array(	
											'top'		=> __( 'Margin-Top', 'avia_framework' ), 
											'right'		=> __( 'Margin-Right', 'avia_framework' ), 
											'bottom'	=> __( 'Margin-Bottom', 'avia_framework' ),
											'left'		=> __( 'Margin-Left', 'avia_framework' ), 
										)
						),
						
						array(	
							'name' 	=> __( 'Padding Bottom', 'avia_framework' ),
							'desc' 	=> __( 'Bottom Padding in pixel', 'avia_framework' ),
							'id' 	=> 'padding',
							'type' 	=> 'select',
							'subtype'	=> AviaHtmlHelper::number_array( 0, 120, 1 ),
							'std'	=> '0'
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
							'name' 	=> __( 'Heading alignment', 'avia_framework' ),
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
							'name' 	=> __( 'Heading alignment', 'avia_framework' ),
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
							'name' 	=> __( 'Heading alignment', 'avia_framework' ),
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
								'title'			=> __( 'Spacing & Layout', 'avia_framework' ),
								'content'		=> $c 
							),
					);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_spacing' ), $template );


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
			
			/**
			 * Advanced Tab
			 * ===========
			 */
			
			$c = array(
						array(	
							'type'			=> 'template',
							'template_id'	=> 'linkpicker_toggle',
							'name'			=> __( 'Header Text Link?', 'avia_framework' ),
							'desc'			=> __( 'Do you want to apply a link to the header text?', 'avia_framework' ),
							'subtypes'		=> array( 'no', 'manually', 'single', 'taxonomy' ),
							'target_id'		=> 'link_target'
						),
						
				);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'advanced_link' ), $c );
			
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
			/**
			 * Fix a bug in 4.7 and 4.7.1 renaming option id (no longer backwards comp.) - can be removed in a future version again
			 */
			if( isset( $params['args']['linktarget'] ) )
			{
				$params['args']['link_target'] = $params['args']['linktarget'];
			}
			
			$params['args'] = shortcode_atts( array(
									'ep_style'					=> '',
									'heading'					=> '',
									'tag'						=> 'h3', 
									'tag_appearance'			=> '',
									'link'						=> '',
									'link_target'				=> '',
									'style'						=> 'blockquote modern-quote',
									'size'						=> '',
									'weight'					=> '', 
									'text_transform' 			=> '',
									'loh' 						=> '', 
									'text_sep' 					=> '', 
									'alignment'					=> '', 
									'tablet_alignment' 			=> '',
									'mobile_alignment' 			=> '',
									'subheading_active'			=> '', 
									'subheading_size'			=> '', 
									'subheading_weight' 		=> '', 
									'subheading_text_transform' => '', 
									'subheading_loh' 			=> '', 
									'subheading_text_sep' 		=> '',
									'margin'					=> '',
									'padding'					=> '5',
									'max_width' 				=> '',
									'max_width_value' 			=> '',
									'max_width_value_tablet' 	=> '',
									'max_width_value_mobile' 	=> '',
									'block_alignment' 			=> '',
									'block_alignment_tablet' 	=> '',
									'block_alignment_mobile' 	=> '',
									'animation'					=> '', 
									'color'						=> '', 
									'custom_font'				=> '', 
									'custom_subheading_font' 	=> '',
									'custom_class'				=> '', 
									'id'						=> '',
									'admin_preview_bg'			=> '',
									'av-desktop-hide'			=> '',
									'av-medium-hide'			=> '',
									'av-small-hide'				=> '',
									'av-mini-hide'				=> '',
									'av-medium-font-size-title'	=> '',
									'av-small-font-size-title'	=> '',
									'av-mini-font-size-title'	=> '',
									'av-medium-font-size'		=> '',
									'av-small-font-size'		=> '',
									'av-mini-font-size'			=> ''
						), $params['args'], $this->config['shortcode'] );
			
			
			$templateNAME  	= $this->update_template( 'name', '{{name}}' );

			$content = stripslashes( wpautop( trim( html_entity_decode( $params['content'] ) ) ) );

			$params['class'] = '';
			$params['innerHtml']  = "<div class='avia_textblock avia_textblock_style avia-special-heading' >";

			$params['innerHtml'] .= 	'<div ' . $this->class_by_arguments( 'tag, style, color, subheading_active', $params['args'] ) . '>';
			$params['innerHtml'] .= 		"<div class='av-subheading-top av-subheading' data-update_with='content'>{$content}</div>";
			$params['innerHtml'] .= 		"<div data-update_with='heading'>";
			$params['innerHtml'] .=				stripslashes( trim( htmlspecialchars_decode( $params['args']['heading'] ) ) );
			$params['innerHtml'] .= 		'</div>';
			$params['innerHtml'] .= 		"<div class='av-subheading-bottom av-subheading' data-update_with='content'>{$content}</div>";
			$params['innerHtml'] .= 	'</div>';
			$params['innerHtml'] .= '</div>';
			
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
			/**
			 * Fix a bug in 4.7 and 4.7.1 renaming option id (no longer backwards comp.) - can be removed in a future version again
			 */
			if( isset( $atts['linktarget'] ) )
			{
				$atts['link_target'] = $atts['linktarget'];
			}
			
			extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			$atts = shortcode_atts( array(
							'ep_style'		=> '',
							'heading'		=> '',
							'tag'			=> 'h3', 
							'tag_appearance'=> '',
							'link_apply'	=> null,		//	backwards comp. < version 1.0
							'link'			=> '',
							'link_target'	=> '',
							'style'			=> 'blockquote modern-quote',
							'size'			=> '',
							'weight' => '', 
							'text_transform' => '',
							'loh' => '', 
							'text_sep' => '', 
							'alignment' 		=> '', 
							'tablet_alignment' => '',
							'mobile_alignment' => '',
							'subheading_active' => '', 
							'subheading_size'	=> '', 
							'subheading_weight' => '', 
							'subheading_text_transform' => '', 
							'subheading_loh' => '', 
							'subheading_text_sep' => '',
							'margin'		=> '',
							'padding'		=> '5', 
							'max_width' 				=> '',
							'max_width_value' 			=> '',
							'max_width_value_tablet' 	=> '',
							'max_width_value_mobile' 	=> '',
							'block_alignment' 			=> '',
							'block_alignment_tablet' 	=> '',
							'block_alignment_mobile' 	=> '',
							'animation'	=> '',
							'color'			=> '', 
							'custom_font'	=> '', 
							'custom_subheading_font' => ''
					), $atts, $this->config['shortcode'] );
			
			//	backwards comp. < version 1.0
			if( ! is_null( $atts['link_apply'] ) )
			{
				if( empty( $atts['link_apply'] ) )
				{
					$atts['link'] = '';
					$atts['link_target'] = '';
				}
			}
			
			$atts['link'] = trim( $atts['link'] );
			if( ( 'manually,http://' == $atts['link'] ) || ( 'manually,https://' == $atts['link'] ) )
			{
				$atts['link'] = '';
				$atts['link_target'] = '';
			}

			extract( $atts );
				
			$output  = '';
			$styling = '';
			$heading_styling = "";
			$subheading_styling = "";
			$subheading = '';
			$border_styling = '';
			$before = '';
			$after = '';
			$before_inside = '';
			$after_inside = '';
			$class = $meta['el_class'];
			$subheading_extra = '';
			$link_before = '';
			$link_after = '';
			$subheading_size = empty( $subheading_size ) ? apply_filters( 'avf_ep_subheading_default_size', '15' ) : $subheading_size;
			$anim_class  = empty($atts['animation']) ? "" : " av-animated-generic ".$atts['animation']." ";
			$class .= $anim_class;

			/*margin calc*/
			$margin_calc = AviaHelper::multi_value_result_lockable( $margin , 'margin' );

			if( $heading )
			{
				// add seo markup
				$markup = avia_markup_helper( array( 'context' => 'entry_title', 'echo' => false, 'custom_markup' => $meta['custom_markup'] ) );

				// filter heading for & symbol and convert them					
				$heading = apply_filters( 'avia_ampersand', wptexturize( $heading ) );

				//if the heading contains a strong tag make apply a custom class that makes the rest of the font appear smaller for a better effect
				if( strpos( $heading, '<strong>' ) !== false ) 
				{
					$class .= ' av-thin-font';
				}

				//apply the padding bottom styling
				// $styling .= $theme_ver >= 4.8 ? "padding-bottom:{$padding}px; {$margin_calc['set_values_only']}" : "padding-bottom:{$padding}px; {$margin_calc['complement']}";

				if( $color == "custom-color-heading" ) 
				{
					if( $custom_font )
					{
						$styling .= "color:{$custom_font};";
						$border_styling = "style='border-color:{$custom_font}'";
					}
					if( $custom_subheading_font )
					{
						$subheading_styling .= "color:{$custom_subheading_font};";
					}
					else
					{
						$subheading_extra .= "av_custom_color";
					}
				}

				if( !empty( $style ) ) 
				{
					if( !empty( $loh ) )
					{
						$heading_styling .= "line-height:{$loh};";
					}

					if( !empty( $weight ) )
					{
						$heading_styling .= "font-weight:{$weight};";
					}

					if( !empty( $text_sep ) )
					{
						$heading_styling .= "letter-spacing:{$text_sep};";
					}

					if( !empty( $text_transform ) )
					{
						$heading_styling .= "text-transform:{$text_transform};";
					}
					
					if( !empty( $size ) ) 
					{ 
						if( is_numeric( $size ) ) 
						{
							$size .= 'px';
						}

						$styling .= "font-size:{$size};"; 
						$class .= ' av-inherit-size';
					}

				}

				if( !empty( $style ) && !empty( $subheading_active ) && !empty( $content ) )
				{
					if( !empty( $subheading_loh ) )
					{
						$subheading_styling .= "line-height:{$subheading_loh};";
					}

					if( !empty( $subheading_weight ) )
					{
						$subheading_styling .= "font-weight:{$subheading_weight};";
					}

					if( !empty( $subheading_text_sep ) )
					{
						$subheading_styling .= "letter-spacing:{$subheading_text_sep};";
					}

					if( !empty( $subheading_text_transform ) ) 
					{
						$subheading_styling .= "text-transform:{$subheading_text_transform};";
					}

					if( !empty( $subheading_size ) )
					{ 
						if( is_numeric( $subheading_size ) ) 
						{
							$subheading_size .= "px";
						}

						$subheading_styling .= "font-size:{$subheading_size};";
					}
				}

				
				if( !empty( $max_width ) ) {

					if( empty( $max_width_value_tablet ) && empty( $max_width_value_mobile ) ) {
						if( !empty( $max_width_value ) ) $styling .= "max-width:{$max_width_value}; ";
					} else {
						if( !empty( $max_width_value ) ) $styling .= "--epMaxWidthDesktop:{$max_width_value}; ";
						if( !empty( $max_width_value_tablet ) ) $styling .= "--epMaxWidthTablet:{$max_width_value_tablet}; ";
						if( !empty( $max_width_value_mobile ) ) $styling .= "--epMaxWidthMobile:{$max_width_value_mobile}; ";
					}
	
					$class .= !empty( $block_alignment ) ? " ep-block-align-" . $block_alignment : ""; 
					$class .= !empty( $block_alignment_tablet ) ? " ep-block-align-tablet-" . $block_alignment_tablet : ""; 
					$class .= !empty( $block_alignment_mobile ) ? " ep-block-align-mobile-" . $block_alignment_mobile : ""; 
	
				}


				//finish up the styling string
				if( !empty( $styling ) ) $styling = "style='{$styling}'";
				if( !empty( $heading_styling ) ) $heading_styling = "style='{$heading_styling}'";
				if( !empty( $subheading_styling ) ) $subheading_styling = "style='{$subheading_styling}'";

				$alignment = $alignment ? "ep-text-align-" . $alignment : "";
				$tablet_alignment = $tablet_alignment ? "ep-text-align-" . $tablet_alignment : "";
				$mobile_alignment = $mobile_alignment ? "ep-text-align-" . $mobile_alignment : "";
	
				//check if we need to apply a link
				if( ! empty( $link ) )
				{
					$class .= ' av-linked-heading';

					$link_before .= '<a href="' . AviaHelper::get_url( $link ) . '"';

					$blank = ( strpos( $link_target, '_blank' ) !== false || $link_target == 'yes' ) ? ' target="_blank" ' : '';
					$blank .= strpos( $link_target, 'nofollow' ) !== false ? ' rel="nofollow" ' : '';

					$link_before .= $blank;
					$link_before .= '>';

					$link_after = '</a>';
				}
	        		
				//check if we got a subheading
				if( ! empty( $style ) && ! empty( $subheading_active ) && ! empty( $content ) )
				{

					if( strpos( $subheading_active, 'inside' ) !== false ) {
						$subheading_active_class = str_replace( '_', '-', $subheading_active );
						$content = "<span class='av-subheading av-subheading-inner av-{$subheading_active_class} {$subheading_extra} {$av_font_classes}' {$subheading_styling}>" . trim( strip_tags( $content, '<span>' ) ) . '</span>';
						// $heading = "<span class='ep-heading-inner-tag'>" . $heading  . "</span>"; // Should inner tag be also wrapped in a span? add opt for it if so..
					} else {
						$content = "<div class='av-subheading av-{$subheading_active} {$subheading_extra} {$av_font_classes}' {$subheading_styling}>" . ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $content ) ) . '</div>';
					}

					if( $subheading_active == 'subheading_above' ) {
						$before = $content;
					}

					if( $subheading_active == 'subheading_below' ) {
						$after = $content;
					}

					if( $subheading_active == 'subheading_above_inside' ) {
						$before_inside = $content;
					}

					if( $subheading_active == 'subheading_below_inside' ) {
						$after_inside = $content;
					}

				}

				//html markup
				$wrapper_data = apply_filters( "avf_ep_heading_wrapper_data", "", $meta );

				$output .= "<div {$meta['custom_el_id']} {$styling} class='av-special-heading av-special-heading-{$tag} {$tag_appearance} {$color} {$style} {$class} {$alignment} {$tablet_alignment} {$mobile_alignment} {$av_display_classes}' {$wrapper_data}>";
				$output .= 		$before;
				$output .= 		"<{$tag} class='av-special-heading-tag {$av_title_font_classes}' {$heading_styling} $markup >";
				$output .= 			"{$link_before}{$before_inside}{$heading}{$after_inside}{$link_after}";
				$output .= 		"</{$tag}>";
				$output .= 		$after;

				/* Kill unused heading border */
				if( ! current_theme_supports( "ep-disable-unused-heading" ) ){ 
					$output .= 		"<div class='special-heading-border'><div class='special-heading-inner-border' {$border_styling}></div></div>";
				}

				$output .= '</div>';
			}

			return $output;
		}
	}
}
