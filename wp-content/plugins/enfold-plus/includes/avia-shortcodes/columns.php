<?php
/**
 * COLUMNS
 * 
 * Shortcode which creates columns for better content separation
 */

 // Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

if ( !class_exists( 'avia_sc_columns' ) )
{
	class avia_sc_columns extends aviaShortcodeTemplate
	{

			public $extra_style = '';
			static $row_count = 0;
			static $extraClass = "";
			static $calculated_size = 0;
			static $first_atts  = array(); 
			static $size_array = array(	'av_one_full' 		=> 1.0, 
										'av_one_half' 		=> 0.5, 
										'av_one_third' 		=> 0.33, 
										'av_one_fourth' 	=> 0.25, 
										'av_one_fifth' 		=> 0.2, 
										'av_one_sixth'		=> 0.16,
										'av_two_third' 		=> 0.66, 
										'av_three_fourth' 	=> 0.75, 
										'av_two_fifth' 		=> 0.4, 
										'av_three_fifth' 	=> 0.6, 
										'av_four_fifth' 	=> 0.8,
										'av_five_sixth' 	=> 0.83
									);

			
			/**
			 * This constructor is implicity called by all derived classes
			 * To avoid duplicating code we put this in the constructor
			 * 
			 * @since 4.2.1
			 * @param AviaBuilder $builder
			 */
			public function __construct( $builder ) 
			{
				parent::__construct( $builder );

				$this->config['version']			= '1.0';
				$this->config['type']				= 'layout';
				$this->config['self_closing']		= 'no';
				$this->config['contains_content']	= 'yes';
				$this->config['contains_text']		= 'no';
				$this->config['first_in_row']		= 'first';
			}
			
			/**
			 * Returns the width of the column. As this is the base class for all columns we only need to implement it here.
			 * 
			 * @since 4.2.1
			 * @return float
			 */
			public function get_element_width()
			{
				return isset( avia_sc_columns::$size_array[ $this->config['shortcode'] ] ) ? avia_sc_columns::$size_array[ $this->config['shortcode'] ] : 1.0;
			}


			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= '1/1';
				$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-full.png';
				$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
				$this->config['order']		= 100;
				$this->config['target']		= 'avia-section-drop';
				$this->config['shortcode'] 	= 'av_one_full';
				$this->config['html_renderer'] 	= false;
				$this->config['tooltip'] 	= __( 'Creates a single full width column', 'avia_framework' );
				$this->config['drag-level'] = 2;
				$this->config['drop-level'] = 2;
				$this->config['tinyMCE'] 	= array( 
													'instantInsert' => '[av_one_full first]Add Content here[/av_one_full]' 
												);
				$this->config['id_name']	= 'id';
				$this->config['id_show']	= 'yes';
				$this->config['aria_label']	= 'yes';
			}

			function extra_assets() {
				wp_enqueue_style( 'avia-module-ep-column' , ENFOLD_PLUS_ASSETS . 'css/ep_columns.css' , array( 'avia-layout' ), ENFOLD_PLUS_VERSION, false );
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
					
					array( /*stores the "first" variable that removes margin from the first column*/
						"id"    => 0,
						"std"   => '',
						"type"  => "hidden"
					),
					
					array(
						"type" 	=> "tab_container", 'nodescription' => true
					),
						
					array(
						"type" 	=> "tab",
						"name"  => __( "Row Settings" , 'avia_framework' ),
						'nodescription' => true,
					),
					
					array(
						'name' 	=> __( 'Row Settings', 'avia_framework' ),
						'desc' 	=> __( 'Row Settings apply to all columns in this row but can only be set in the first column', 'avia_framework' ),
						'type' 	=> 'heading',
						'description_class' => 'av-builder-note av-notice',
						'required' => array( '0', 'equals', '' ),
					),
					
					array(
						'name' 	=> __( 'Row Settings', 'avia_framework' ),
						'desc' 	=> __( 'These setting apply to all columns in this row and can only be set in the first column.', 'avia_framework' )
								 .'<br/><strong>'
								 . __( 'Please note:', 'avia_framework' )
								 .'</strong> '
								 . __( 'If you move another column into first position you will need to re-apply these settings.', 'avia_framework' ),
						'type' 	=> 'heading',
						'description_class' => 'av-builder-note av-notice',
						'required' => array( '0', 'not', '' ),
					),

					array(
						'type'			=> 'template',
						'template_id'	=> 'toggle_container',
						'templates_include'	=> array( 
												$this->popup_key( 'layout_row_settings' ),
												$this->popup_key( 'layout_row_spacing' ),
												$this->popup_key( 'layout_row_borders' ),
												$this->popup_key( 'layout_row_padding' ),
												$this->popup_key( 'layout_row_box_shadow' ),
												$this->popup_key( 'layout_row_background' ),
												$this->popup_key( 'layout_row_screen_options' ),
												$this->popup_key( 'layout_row_advanced' ),
											),
						'nodescription' => true,
					),
					
					array(
						"type"			=> "tab_close",
						'nodescription' => true
					),
					
					array(
						"type" 	=> "tab",
						"name"  => __( "Styling" , 'avia_framework' ),
						'nodescription' => true
					),

					array(
						'type'			=> 'template',
						'template_id'	=> 'toggle_container',
						'templates_include'	=> array( 
												$this->popup_key( 'styling_borders' ),
												$this->popup_key( 'styling_padding' ),
												$this->popup_key( 'styling_box_shadow' ),
												$this->popup_key( 'styling_background' ),
												$this->popup_key( 'layout_highlight' )
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
						'template_id'	=> $this->popup_key( 'layout_column_link' ),
					),
					
					array(	
						'type'			=> 'template',
						'template_id'	=> 'columns_visibility_toggle'
					),

					array(	
						'type'			=> 'template',
						'template_id'	=> 'toggle',
						'title'			=> __( 'Responsive Spacing', 'avia_framework' ),
						'content'		=> array(
							array(
								"name" 	=> __( "Remove bottom margin on this column when stacks",'avia_framework' ),
								"desc" 	=> __( "If enabled will remove bottom margin on this column when stacks",'avia_framework' ),
								"id" 	=> "remove_margins",
								"type" 	=> "checkbox",
								"std" 	=> "",
							),
						)
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
						"std" 	=> apply_filters( "avf_ep_column_style_std", "" ),
						"subtype" => apply_filters( "avf_ep_column_style_options", array(
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
							"std" 	=> apply_filters( "avf_ep_column_style_std", "" ),
							"subtype" => apply_filters( "avf_ep_column_style_options", array() ),
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
			protected function register_dynamic_templates() {
				
				/**
				 * Row Settings
				 */
				$c = array(
						
					array(
						"name" 	=> __( "Equal Height Columns",'avia_framework' ),
						"desc" 	=> __( "Columns in this row can either have a height based on their content or all be of equal height based on the largest column ", 'avia_framework' ),
						"id" 	=> "min_height",
						"type" 	=> "select",
						"std" 	=> "av-equal-height-column",
						"required" => array('0','not','' ),
						"subtype" => array(
							__( 'Individual height','avia_framework' )=>'',
							__( 'Equal height','avia_framework' ) =>'av-equal-height-column',
							)
						),


					array(
						"name" 	=> __( "Vertical Alignment",'avia_framework' ),
						"desc" 	=> __( "If a column is larger than its content, were do you want to align the content vertically?", 'avia_framework' ),
						"id" 	=> "vertical_alignment",
						"type" 	=> "select",
						"std" 	=> "av-align-top",
						"required" => array( 'min_height', 'not', '' ),
						"subtype" => array(
							__( 'Top','avia_framework' )=>'av-align-top',
							__( 'Middle','avia_framework' ) =>'av-align-middle',
							__( 'Bottom','avia_framework' ) =>'av-align-bottom',
							)
					),

					array(
						"name" 	=> __( "Space between columns",'avia_framework' ),
						"desc" 	=> __( "You can remove the default space between columns here.", 'avia_framework' ),
						"id" 	=> "space",
						"type" 	=> "select",
						"std" 	=> "",
						"required" => array('0','not','' ),
						"subtype" => array(
							__( 'Space between columns','avia_framework' )=>'',
							__( 'No space between columns','avia_framework' ) =>'no_margin',
							__( 'Custom Space','avia_framework' ) =>'custom_space',
							)
					),


					array(
						"name" 	=> __( "Custom Space",'avia_framework' ),
						"desc" 	=> __( "Input a px/%/em value (this setting only works if equal height columns is enabled)", 'avia_framework' ),
						"id" 	=> "custom_space",
						"type" 	=> "input",
						"required" => array('space','equals','custom_space' ),
						"std" 	=> ""
					),

				);
				
				$template = array(
					array(	
						'type'			=> 'template',
						'template_id'	=> 'toggle',
						'title'			=> __( 'Row Layout', 'avia_framework' ),
						'content'		=> $c
					),
				);
				
				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_settings' ), $template );


				/**
				 * Row Spacing Tab
				 */
				$c = array(
					

					array(
						"name" 	=> __( "Custom top and bottom margin",'avia_framework' ),
						"desc" 	=> __( "If checked allows you to set a custom top and bottom margin. Otherwise the margin is calculated by the theme based on surrounding elements",'avia_framework' ),
						"required" => array('0','not','' ),
						"id" 	=> "custom_margin",
						"type" 	=> "checkbox",
						"std" 	=> "",
					),
					
					array(
						'name' => '',
						'desc'   => '',
						'nodescription' => 1,
						"required" => array('custom_margin','not','' ),
						'type' => 'icon_switcher_container',
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Desktop', 'avia_framework' ),
						'icon' => 'desktop',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Custom top and bottom margin", 'avia_framework' ),
						"desc" 	=> __( "Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;", 'avia_framework' ),
						"id" 	=> "margin",
						"type" 	=> "multi_input",
						"required" => array('custom_margin','not','' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
									'top' 	=> __( 'Margin-Top','avia_framework' ), 
									'bottom'=> __( 'Margin-Bottom','avia_framework' ),
								)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Tablet', 'avia_framework' ),
						'icon' => 'tablet-landscape',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Custom top and bottom margin (Tablet)", 'avia_framework' ),
						"desc" 	=> __( "Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;", 'avia_framework' ),
						"id" 	=> "margin_tablet",
						"type" 	=> "multi_input",
						"required" => array('custom_margin','not','' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
									'top' 	=> __( 'Margin-Top','avia_framework' ), 
									'bottom'=> __( 'Margin-Bottom','avia_framework' ),
								)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Mobile', 'avia_framework' ),
						'icon' => 'mobile',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Custom top and bottom margin (Mobile)", 'avia_framework' ),
						"desc" 	=> __( "Set a custom top or bottom margin. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;", 'avia_framework' ),
						"id" 	=> "margin_mobile",
						"type" 	=> "multi_input",
						"required" => array('custom_margin','not','' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
									'top' 	=> __( 'Margin-Top','avia_framework' ), 
									'bottom'=> __( 'Margin-Bottom','avia_framework' ),
								)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1
					),
					
					array(
						'type' => 'icon_switcher_container_close',
						"required" => array('custom_margin','not','' ),
						'nodescription' => 1
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Margins', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_spacing' ), $template );

				/**
				 * Row Borders
				 */
				$c = array(

					array(
						"name" 	=> __( "Border",'avia_framework' ),
						"desc" 	=> __( "Set the border of the column here", 'avia_framework' ),
						"id" 	=> "row_border",
						"type" 	=> "select",
						"required" => array( 'min_height', 'not', '' ),
						"std" 	=> "",
						"subtype" => AviaHtmlHelper::number_array(1,40,1, array( __( "None", 'avia_framework' )=>'') , 'px' ),
					),
						
					array(	
							"name" 	=> __( "Border Color", 'avia_framework' ),
							"desc" 	=> __( "Set a border color for this column", 'avia_framework' ),
							"id" 	=> "row_border_color",
							"type" 	=> "colorpicker",
							"rgba" 	=> true,
							"required" => array( 'row_border','not','' ),
							"std" 	=> "",
						),
						
					array(	
							"name" 	=> __( "Border Radius", 'avia_framework' ),
							"desc" 	=> __( "Set the border radius of the column", 'avia_framework' ),
							"id" 	=> "row_radius",
							"type" 	=> "multi_input",
							"std" 	=> "",
							"required" => array( 'min_height', 'not', '' ),
							"sync" 	=> true,
							"multi" => array(	'top' 	=> __( 'Top-Left-Radius','avia_framework' ), 
												'right'	=> __( 'Top-Right-Radius','avia_framework' ), 
												'bottom'=> __( 'Bottom-Right-Radius','avia_framework' ),
												'left'	=> __( 'Bottom-Left-Radius','avia_framework' ),
												)
						),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Row Borders', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_borders' ), $template );


				/**
				 * Row Padding
				 */
				$c = array(

					array(
						'name' => '',
						'desc'   => '',
						'nodescription' => 1,
						"required" => array( 'min_height', 'not', '' ),
						'type' => 'icon_switcher_container',
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Desktop', 'avia_framework' ),
						'icon' => 'desktop',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Inner Padding", 'avia_framework' ),
						"desc" 	=> __( "Set the distance from the row content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;", 'avia_framework' ),
						"id" 	=> "row_padding",
						"type" 	=> "multi_input",
						"required" => array( 'min_height', 'not', '' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
										'top' 	=> __( 'Padding-Top','avia_framework' ), 
										'right'	=> __( 'Padding-Right','avia_framework' ), 
										'bottom'=> __( 'Padding-Bottom','avia_framework' ),
										'left'	=> __( 'Padding-Left','avia_framework' ), 
									)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Tablet', 'avia_framework' ),
						'icon' => 'tablet-landscape',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Inner Padding (Tablet)", 'avia_framework' ),
						"desc" 	=> __( "Set the distance from the row content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;. Leave empty if you want to use the default value.", 'avia_framework' ),
						"id" 	=> "row_padding_tablet",
						"type" 	=> "multi_input",
						"required" => array( 'min_height', 'not', '' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
										'top' 	=> __( 'Padding-Top','avia_framework' ), 
										'right'	=> __( 'Padding-Right','avia_framework' ), 
										'bottom'=> __( 'Padding-Bottom','avia_framework' ),
										'left'	=> __( 'Padding-Left','avia_framework' ), 
										)
					),


					array(
						'type' => 'icon_switcher_close',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						"required" => array( 'min_height', 'not', '' ),
						'name' => __( 'Mobile', 'avia_framework' ),
						'icon' => 'mobile',
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Inner Padding (Mobile)", 'avia_framework' ),
						"desc" 	=> __( "Set the distance from the row content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;. Leave empty if you want to use the default value.", 'avia_framework' ),
						"id" 	=> "row_padding_mobile",
						"type" 	=> "multi_input",
						"required" => array( 'min_height', 'not', '' ),
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	
										'top' 	=> __( 'Padding-Top','avia_framework' ), 
										'right'	=> __( 'Padding-Right','avia_framework' ), 
										'bottom'=> __( 'Padding-Bottom','avia_framework' ),
										'left'	=> __( 'Padding-Left','avia_framework' ), 
									)
					),

					array(
						'type' => 'icon_switcher_close',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher_container_close',
						"required" => array( 'min_height', 'not', '' ),
						'nodescription' => 1
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Row Padding', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_padding' ), $template );


				/**
				 * Row Box Shadow
				 */
				$c = array(

					array(
						"name" 	=> __( "Row Box-Shadow",'avia_framework' ),
						"desc" 	=> __( "Add a box-shadow to the row",'avia_framework' ),
						"required" => array( 'min_height', 'not', '' ),
						"id" 	=> "row_boxshadow",
						"type" 	=> "checkbox",
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Row Box-Shadow Color", 'avia_framework' ),
						"desc" 	=> __( "Set a color for the box-shadow", 'avia_framework' ),
						"id" 	=> "row_boxshadow_color",
						"type" 	=> "colorpicker",
						"rgba" 	=> true,
						"required" => array( 'row_boxshadow','not','' ),
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Row Box-Shadow Width",'avia_framework' ),
						"desc" 	=> __( "Set the width of the box-shadow", 'avia_framework' ),
						"id" 	=> "row_boxshadow_width",
						"type" 	=> "select",
						"std" 	=> "10",
						"required" => array( 'row_boxshadow','not','' ),
						"subtype" => AviaHtmlHelper::number_array(1,40,1, array() , 'px' ),
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Row Box Shadow', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_box_shadow' ), $template );


				/**
				 * Row Background Tab
				 */
				$c = array(

					array(
						"name" 	=> __( "Row Background",'avia_framework' ),
						"desc" 	=> __( "Select the type of background for the row.", 'avia_framework' ),
						"id" 	=> "row_background",
						"type" 	=> "select",
						"std" 	=> "bg_color",
						"required" => array( 'min_height', 'not', '' ),
						"subtype" => array(
							__( 'Background Color','avia_framework' )=>'bg_color',
							__( 'Background Gradient','avia_framework' ) =>'bg_gradient',
						)
					),

					array(
						"name" 	=> __( "Custom Background Color", 'avia_framework' ),
						"desc" 	=> __( "Select a custom background color for the row here. Leave empty for default color", 'avia_framework' ),
						"id" 	=> "row_background_color",
						"type" 	=> "colorpicker",
						"required" => array( 'row_background','equals','bg_color' ),
						"rgba" 	=> true,
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Background Gradient Color 1", 'avia_framework' ),
						"desc" 	=> __( "Select the first color for the gradient.", 'avia_framework' ),
						"id" 	=> "row_background_gradient_color1",
						"type" 	=> "colorpicker",
						"container_class" => 'av_third av_third_first',
						"required" => array( 'row_background','equals','bg_gradient' ),
						"rgba" 	=> true,
						"std" 	=> "",
					),
					array(
						"name" 	=> __( "Background Gradient Color 2", 'avia_framework' ),
						"desc" 	=> __( "Select the second color for the gradient.", 'avia_framework' ),
						"id" 	=> "row_background_gradient_color2",
						"type" 	=> "colorpicker",
						"container_class" => 'av_third',
						"required" => array( 'row_background','equals','bg_gradient' ),
						"rgba" 	=> true,
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Background Gradient Direction",'avia_framework' ),
						"desc" 	=> __( "Define the gradient direction", 'avia_framework' ),
						"id" 	=> "row_background_gradient_direction",
						"type" 	=> "select",
						"container_class" => 'av_third',
						"std" 	=> "vertical",
						"required" => array( 'row_background','equals','bg_gradient' ),
						"subtype" => array(
							__( 'Vertical','avia_framework' )=>'vertical',
							__( 'Horizontal','avia_framework' ) =>'horizontal',
							__( 'Radial','avia_framework' ) =>'radial',
							__( 'Diagonal Top Left to Bottom Right','avia_framework' ) =>'diagonal_tb',
							__( 'Diagonal Bottom Left to Top Right','avia_framework' ) =>'diagonal_bt',
						)
					),
						
					array(
						"name" 	=> __( "Custom Background Image",'avia_framework' ),
						"desc" 	=> __( "Either upload a new, or choose an existing image from your media library. Leave empty if you don't want to use a background image ",'avia_framework' ),
						"id" 	=> "row_src",
						"type" 	=> "image",
						"required" => array( 'min_height', 'not', '' ),
						"title" => __( "Insert Image",'avia_framework' ),
						"button" => __( "Insert",'avia_framework' ),
						"std" 	=> ""
					),
					
					
					array(
						"name" 	=> __( "Background Attachment",'avia_framework' ),
						"desc" 	=> __( "Background can either scroll with the page or be fixed", 'avia_framework' ),
						"id" 	=> "row_background_attachment",
						"type" 	=> "select",
						"std" 	=> "scroll",
						"required" => array( 'row_src','not','' ),
						"subtype" => array(
							__( 'Scroll','avia_framework' )=>'scroll',
							__( 'Fixed','avia_framework' ) =>'fixed',
							)
						),

					
					array(
						"name" 	=> __( "Background Image Position",'avia_framework' ),
						"id" 	=> "row_background_position",
						"type" 	=> "select",
						"std" 	=> "top left",
						"required" => array( 'row_src','not','' ),
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
						"name" 	=> __( "Background Repeat",'avia_framework' ),
						"id" 	=> "row_background_repeat",
						"type" 	=> "select",
						"std" 	=> "stretch",
						"required" => array( 'row_src','not','' ),
						"subtype" => array(  
							__( 'No Repeat', 'avia_framework' )          => 'no-repeat',
							__( 'Repeat', 'avia_framework' )             => 'repeat',
							__( 'Tile Horizontally', 'avia_framework' )  => 'repeat-x',
							__( 'Tile Vertically', 'avia_framework' )    => 'repeat-y',
							__( 'Stretch to fit (stretches image to cover the element)', 'avia_framework' )             => 'stretch',
							__( 'Scale to fit (scales image so the whole image is always visible)', 'avia_framework' )	=> 'contain'
						)
				  	),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Row Background', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_background' ), $template );

				/**
				 * Row Screen Options
				 */
				$c = array(
					array(	
						'name' 	=> __( 'Fullwidth Break Point', 'avia_framework' ),
						'desc' 	=> __( 'The columns in this row will switch to fullwidth at this screen width ', 'avia_framework' ),
						'id' 	=> 'mobile_breaking',
						'type' 	=> 'select',
						'std' 	=> 'av-break-at-tablet',
						'required'	=> array( '0', 'not', '' ),
						'subtype'	=> array(	
											__( 'On mobile devices (at a screen width of 767px or lower)', 'avia_framework' )	=> '',
											__( 'On tablets (at a screen width of 989px or lower)', 'avia_framework' )			=> 'av-break-at-tablet',
										)
					),

					array(
						"name" 	=> __( "Reverse order of columns when stacked",'avia_framework' ),
						"desc" 	=> __( "If enabled this will reverse the order of columns when stacked",'avia_framework' ),
						"required" => array( 'min_height', 'not', '' ),
						"id" 	=> "reverse_order",
						"type" 	=> "checkbox",
						"std" 	=> "",
					),

				);
		
				$template = array(
					array(	
						'type'			=> 'template',
						'template_id'	=> 'toggle',
						'title'			=> __( 'Row Screen Options', 'avia_framework' ),
						'content'		=> $c
					),
				);
				
				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_screen_options' ), $template );


				/**
				 * Row Advanced
				 */
				$c = array(

					array(
						"name" 	=> __( "Row CSS Class",'avia_framework' ),
						"id" 	=> "row_class",
						"desc"	=> __( "Add a custom css class for the element here. Make sure to only use allowed characters (latin characters, underscores, dashes and numbers)", 'avia_framework' ),
						"type" 	=> "input",
						"std" 	=> "",
						"required" => array( 'min_height', 'not', '' )
					),


					array(
						"name" 	=> __( "Row ID",'avia_framework' ),
						"id" 	=> "row_id",
						"desc"	=> __( "Add a custom ID for the element here. Make sure to only use allowed characters (latin characters, underscores, dashes and numbers)", 'avia_framework' ),
						"type" 	=> "input",
						"std" 	=> "",
						"required" => array( 'min_height', 'not', '' )
					),

					array(
						"name" 	=> __( "Offset last column to the right",'avia_framework' ),
						"desc" 	=> __( "You can set the last column of this row to be a bit offset to the right", 'avia_framework' ),
						"id" 	=> "offset_left",
						'container_class' 	=> 'av_half av_half_first',
						"required" => array( 'min_height', 'not', '' ),
						"type" 	=> "checkbox",
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Offset first column to the left",'avia_framework' ),
						"desc" 	=> __( "You can set the first column of this row to be a bit offset to the left", 'avia_framework' ),
						"id" 	=> "offset_right",
						'container_class' 	=> 'av_half',
						"required" => array( 'min_height', 'not', '' ),
						"type" 	=> "checkbox",
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Make the offset column be fullwidth on breakpoint?",'avia_framework' ),
						"desc" 	=> __( "If checked the offset column will be fullwidth on mobile breakpoint.", 'avia_framework' ),
						"id" 	=> "offset_fwd_mobile",
						"required" => array( 'min_height', 'not', '' ),
						"type" 	=> "checkbox",
						"std" 	=> "",
					),
					
					array(
						"name" 	=> __( "Make this Row a Container?",'avia_framework' ),
						"desc" 	=> __( "You can set this Row as a Container, only use when parent Section is set to full width and need this row to be 'contained'.", 'avia_framework' ),
						"id" 	=> "row_container",
						"type" 	=> "checkbox",
						"required" => array( 'min_height', 'not', '' ),
						"std" 	=> "",
					),

					array(
						"name" 	=> __( "Row Style", 'avia_framework' ),
						"desc" 	=> __( "Set a pre-defined style for this element", 'avia_framework' ),
						"id" 	=> "ep_row_style",
						"type" 	=> "select",
						"required" => array( 'min_height', 'not', '' ),
						"lockable" => true,
						"std" 	=> apply_filters( "avf_ep_row_style_std", "" ),
						"subtype" => apply_filters( "avf_ep_row_style_options", array(
							__( 'Default',  'avia_framework' ) => '',
						) ),
					),

					array(
						"name" 	=> __( "Additional Row Styles", 'avia_framework' ),
						"desc" 	=> __( "Select more additional row styles for this element", 'avia_framework' ),
						"id" 	=> "ep_extra_row_styles",
						"type" 	=> "select",
						"multiple" => 5,
						"lockable" => true,
						"std" 	=> apply_filters( "avf_ep_row_style_std", "" ),
						"subtype" => apply_filters( "avf_ep_row_style_options", array() ),
					),

				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Row Advanced', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_row_advanced' ), $template );


				/**
				 * Borders
				 */
				$c = array(
					array(
						'name' 	=> __( 'Border','avia_framework' ),
						'desc' 	=> __( 'Set the border of the column here', 'avia_framework' ),
						'id' 	=> 'border',
						'type' 	=> 'select',
						'std' 	=> '',
						'subtype' => AviaHtmlHelper::number_array( 1, 40, 1, array( __( 'None', 'avia_framework' ) => '' ) , 'px' )
					),
					
					array(	
						'name' 	=> __( 'Border Color', 'avia_framework' ),
						'desc' 	=> __( 'Set a border color for this column', 'avia_framework' ),
						'id' 	=> 'border_color',
						'type' 	=> 'colorpicker',
						'rgba' 	=> true,
						'required' => array( 'border', 'not', '' ),
						'std' 	=> ''
					),
					
					array(	
						'name' 	=> __( 'Border Radius', 'avia_framework' ),
						'desc' 	=> __( 'Set the border radius of the column', 'avia_framework' ),
						'id' 	=> 'radius',
						'type' 	=> 'multi_input',
						'std' 	=> '0px',
						'sync' 	=> true,
						'multi' => array(	
										'top'		=> __( 'Top-Left-Radius', 'avia_framework' ), 
										'right'		=> __( 'Top-Right-Radius', 'avia_framework' ), 
										'bottom'	=> __( 'Bottom-Right-Radius', 'avia_framework' ),
										'left'		=> __( 'Bottom-Left-Radius', 'avia_framework' )
									)
					)
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Borders', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_borders' ), $template );


				/**
				 * Padding
				 */
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
							"name" 	=> __( "Inner Padding", 'avia_framework' ),
							"desc" 	=> __( "Set the distance from the column content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;", 'avia_framework' ),
							"id" 	=> "padding",
							"type" 	=> "multi_input",
							"std" 	=> "",
							"sync" 	=> true,
							"multi" => array(	
								'top' 	=> __( 'Padding-Top','avia_framework' ), 
								'right'	=> __( 'Padding-Right','avia_framework' ), 
								'bottom'=> __( 'Padding-Bottom','avia_framework' ),
								'left'	=> __( 'Padding-Left','avia_framework' ), 
							)
					),

					array(
						'type' => 'icon_switcher_close',
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Tablet', 'avia_framework' ),
						'icon' => 'tablet-landscape',
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Inner Padding (Tablet)", 'avia_framework' ),
						"desc" 	=> __( "Set the distance from the column content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;. Leave empty if you want to use the default value.", 'avia_framework' ),
						"id" 	=> "padding_tablet",
						"type" 	=> "multi_input",
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	'top' 	=> __( 'Padding-Top','avia_framework' ), 
											'right'	=> __( 'Padding-Right','avia_framework' ), 
											'bottom'=> __( 'Padding-Bottom','avia_framework' ),
											'left'	=> __( 'Padding-Left','avia_framework' ), 
											)
					),

					array(
						'type' => 'icon_switcher_close',
						'nodescription' => 1
					),

					array(
						'type' => 'icon_switcher',
						'name' => __( 'Mobile', 'avia_framework' ),
						'icon' => 'mobile',
						'nodescription' => 1,
					),

					array(	
						"name" 	=> __( "Inner Padding", 'avia_framework' ),
						"desc" 	=> __( "Set the distance from the column content to the border here. Both pixel and &percnt; based values are accepted. eg: 30px, 5&percnt;. Leave empty if you want to use the default value.", 'avia_framework' ),
						"id" 	=> "padding_mobile",
						"type" 	=> "multi_input",
						"std" 	=> "",
						"sync" 	=> true,
						"multi" => array(	'top' 	=> __( 'Padding-Top','avia_framework' ), 
											'right'	=> __( 'Padding-Right','avia_framework' ), 
											'bottom'=> __( 'Padding-Bottom','avia_framework' ),
											'left'	=> __( 'Padding-Left','avia_framework' ), 
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
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Padding', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_padding' ), $template );

				/**
				 * Box Shadow
				 */
				$c = array(
					array(
						'name' 	=> __( 'Column Box-Shadow', 'avia_framework' ),
						'desc' 	=> __( 'Add a box-shadow to the column','avia_framework' ),
						'id' 	=> 'column_boxshadow',
						'type' 	=> 'checkbox',
						'std' 	=> '',
					),

					 array(
						'name' 	=> __( 'Column Box-Shadow Color', 'avia_framework' ),
						'desc' 	=> __( 'Set a color for the box-shadow', 'avia_framework' ),
						'id' 	=> 'column_boxshadow_color',
						'type' 	=> 'colorpicker',
						'rgba' 	=> true,
						'required' => array( 'column_boxshadow', 'not', '' ),
						'std' 	=> '',
					 ),

					 array(
						'name' 	=> __( 'Column Box-Shadow Width', 'avia_framework' ),
						'desc' 	=> __( 'Set the width of the box-shadow', 'avia_framework' ),
						'id' 	=> 'column_boxshadow_width',
						'type' 	=> 'select',
						'std' 	=> '10',
						'required' => array( 'column_boxshadow', 'not', '' ),
						'subtype' => AviaHtmlHelper::number_array( 1, 40, 1, array(), 'px' ),
					 ),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Box Shadow', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_box_shadow' ), $template );


				/**
				 * Background
				 */
				$c = array(
					array(
						'name' 	=> __( 'Background', 'avia_framework' ),
						'desc' 	=> __( 'Select the type of background for the column.', 'avia_framework' ),
						'id' 	=> 'background',
						'type' 	=> 'select',
						'std' 	=> 'bg_color',
						'subtype' => array(
										__( 'Background Color', 'avia_framework' )		=> 'bg_color',
										__( 'Background Gradient', 'avia_framework' )	=> 'bg_gradient',
									)
					),

					array(
						'name' 	=> __( 'Custom Background Color', 'avia_framework' ),
						'desc' 	=> __( 'Select a custom background color for this cell here. Leave empty for default color', 'avia_framework' ),
						'id' 	=> 'background_color',
						'type' 	=> 'colorpicker',
						'required' => array( 'background', 'equals', 'bg_color' ),
						'rgba' 	=> true,
						'std' 	=> '',
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
					),

					array(
						'name' 	=> __( 'Background Gradient Direction', 'avia_framework' ),
						'desc' 	=> __( 'Define the gradient direction', 'avia_framework' ),
						'id' 	=> 'background_gradient_direction',
						'type' 	=> 'select',
						'container_class' => 'av_third',
						'std'	=> 'vertical',
						'required'	=> array( 'background', 'equals', 'bg_gradient' ),
						'subtype'	=> array(
										__( 'Vertical','avia_framework' )	=> 'vertical',
										__( 'Horizontal','avia_framework' )	=> 'horizontal',
										__( 'Radial','avia_framework' )		=> 'radial',
										__( 'Diagonal Top Left to Bottom Right', 'avia_framework' )	=> 'diagonal_tb',
										__( 'Diagonal Bottom Left to Top Right', 'avia_framework' )	=> 'diagonal_bt',
									)
					),
					
					array(
						'name' 	=> __( 'Custom Background Image', 'avia_framework' ),
						'desc' 	=> __( "Either upload a new, or choose an existing image from your media library. Leave empty if you don't want to use a background image", 'avia_framework' ),
						'id' 	=> 'src',
						'type' 	=> 'image',
						'title' => __( 'Insert Image', 'avia_framework' ),
						'button' => __( 'Insert', 'avia_framework' ),
						'std' 	=> ''
					),

					array(
						"name" 	=> __( "Background Attachment",'avia_framework' ),
						"desc" 	=> __( "Background can either scroll with the page or be fixed", 'avia_framework' ),
						'required'	=> array( 'src', 'not','' ),
						"id" 	=> "background_attachment",
						"type" 	=> "select",
						"std" 	=> "scroll",
						"subtype" => array(
							__( 'Scroll','avia_framework' )=>'scroll',
							__( 'Fixed','avia_framework' ) =>'fixed',
							)
						),

					array(
						'type'			=> 'template',
						'template_id'	=> 'background_image_position'
					),
					
					array(
						"name" 	=> "Set background as overlay?",
						"desc" 	=> "Set background image as a separate div overlay",
						"id" 	=> "background_overlay",
						"type" 	=> "checkbox",
						"std" 	=> "",
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Background', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'styling_background' ), $template );


				/**
				 * Highlight
				 */
				$c = array(
					array(
						'name' 	=> __( 'Highlight Column', 'avia_framework' ),
						'desc' 	=> __( 'Hightlight this column by making it slightly bigger', 'avia_framework' ),
						'id' 	=> 'highlight',
						'type' 	=> 'checkbox',
						'std' 	=> '',
					),

					array(
						'name' 	=> __( 'Highlight - Column Scaling', 'avia_framework' ),
						'desc' 	=> __( 'How much should the highlighted column be increased in size?', 'avia_framework' ),
						'id' 	=> 'highlight_size',
						'type' 	=> 'select',
						'required'		=> array( 'highlight', 'not', '' ),
						'std' 	=> '',
						'subtype' => AviaHtmlHelper::number_array( 1.1, 1.6, 0.1, array() ),
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Highlight', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_highlight' ), $template );


				/**
				 * Animation
				 */
				$c = array(
					array(	
						'type'			=> 'template',
						'template_id'	=> 'ep_animation'
					),
				);

				$template = array(
					array(
						'type'		=> 'template',
						'template_id'	=> 'toggle',
						'title'	=> __( 'Animation', 'avia_framework' ),
						'content' 	=> $c
					),
				);

				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'advanced_animation' ), $template );


				/**
				 * Column Link
				 */
				$c = array(
					array(	
						'type'			=> 'template',
						'template_id'	=> 'linkpicker_toggle',
						'name'			=> __( 'Column Link', 'avia_framework' ),
						'desc'			=> __( 'Select where this column should link to', 'avia_framework' ),
						'subtypes'		=> array( 'no', 'manually', 'single', 'taxonomy' ),
						'no_toggle'		=> true
					),
				
					array(
						'name'			=> __( 'Hover Effect', 'avia_framework' ),
						'desc'			=> __( 'Choose if you want to have a hover effect on the column', 'avia_framework' ),
						'id'			=> 'link_hover',
						'type'			=> 'select',
						'required'		=> array( 'link', 'not', '' ),
						'std'			=> '',
						'subtype'		=> array(
											__( 'No', 'avia_framework' )			=> '',
											__( 'Yes', 'avia_framework' )			=> 'opacity80'
										),
						'std'			=> ''
					),
					
					array(
						'name' 			=> __( 'Title Attribut', 'avia_framework' ),
						'desc' 			=> __( 'Add a title attribut for screen reader', 'avia_framework' ),
						'id' 			=> 'title_attr',
						'container_class' => 'av_half av_half_first',
						'required'		=> array( 'link', 'not', '' ),
						'type' 			=> 'input',
						'std' 			=> ''
					),


					array(
						'name' 			=> __( 'Alt Attribut', 'avia_framework' ),
						'desc' 			=> __( 'Add an alt attribut for screen reader','avia_framework' ),
						'id' 			=> 'alt_attr',
						'required'		=> array( 'link', 'not', '' ),
						'container_class' => 'av_half',
						'type' 			=> 'input',
						'std' 			=> ''
					)
				);
			
				$template = array(
					array(	
						'type'			=> 'template',
						'template_id'	=> 'toggle',
						'title'			=> __( 'Column Link', 'avia_framework' ),
						'content'		=> $c
					),
				);
			
				AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'layout_column_link' ), $template );

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
			public function editor_element( $params )
			{
				extract( $params );
				
				if( empty( $data ) || ! is_array( $data ) ) 
				{
					$data = array();
				}
				
				$name 		= $this->config['shortcode'];
				$drag 		= $this->config['drag-level'];
				$drop 		= $this->config['drop-level'];
				
				$size = array('av_one_full' => '1/1', 'av_one_half' => '1/2', 'av_one_third' => '1/3', 'av_one_fourth' => '1/4', 'av_one_fifth' => '1/5', 'av_one_sixth' => '1/6', 'av_two_third' => '2/3', 'av_three_fourth' => '3/4', 'av_two_fifth' => '2/5', 'av_three_fifth' => '3/5', 'av_four_fifth' => '4/5', 'av_five_sixth' => '5/6' );
				
				
				$data['shortcodehandler'] 	= $this->config['shortcode'];
				$data['modal_title'] 		= __( 'Edit Column','avia_framework' );
				$data['modal_ajax_hook'] 	= $this->config['shortcode'];
				$data['dragdrop-level']		= $this->config['drag-level'];
				$data['allowed-shortcodes'] = $this->config['shortcode'];
				$data['closing_tag']		= $this->is_self_closing() ? 'no' : 'yes';
				
				if(!empty($this->config['modal_on_load']))
				{
					$data['modal_on_load'] 	= $this->config['modal_on_load'];
				}
	
				$dataString  = AviaHelper::create_data_string($data);

				// add background color or gradient to indicator
				$el_bg = "";

				if( empty( $args['background'] ) || ( $args['background'] == 'bg_color' ) )
				{
					$el_bg = !empty($args['background_color']) ? " style='background:".$args['background_color'].";'" : "";
				}
				else {
					if ($args['background_gradient_color1'] && $args['background_gradient_color2']) 
					{
						$el_bg = "style='background:linear-gradient(".$args['background_gradient_color1'].",".$args['background_gradient_color2'].");'";
					}
				}
				
				$extraClass = isset($args[0]) ? $args[0] == 'first' ? ' avia-first-col' : "" : "";

				$output  = "<div class='avia_layout_column avia_layout_column_no_cell avia_pop_class avia-no-visual-updates ".$name.$extraClass." av_drag' {$dataString} data-width='{$name}'>";
				$output .= "<div class='avia_sorthandle menu-item-handle'>";

				$output .= "<a class='avia-smaller avia-change-col-size' href='#smaller' title='".__( 'Decrease Column Size','avia_framework' )."'>-</a>";
				$output .= "<span class='avia-col-size'>".$size[$name]."</span>";
				$output .= "<a class='avia-bigger avia-change-col-size'  href='#bigger' title='".__( 'Increase Column Size','avia_framework' )."'>+</a>";
				$output .= "<a class='avia-delete'  href='#delete' title='".__( 'Delete Column','avia_framework' )."'>x</a>";
				$output .= "<a class='avia-save-element'  href='#save-element' title='".__( 'Save Element as Template','avia_framework' )."'>+</a>";
				//$output .= "<a class='avia-new-target'  href='#new-target' title='".__( 'Move Element','avia_framework' )."'>+</a>";
				$output .= "<a class='avia-clone'  href='#clone' title='".__( 'Clone Column','avia_framework' )."' >".__( 'Clone Column','avia_framework' )."</a><span class='avia-element-bg-color' ".$el_bg."></span>";
				
				if(!empty($this->config['popup_editor']))
				{
					$output .= "    <a class='avia-edit-element'  href='#edit-element' title='".__( 'Edit Cell','avia_framework' )."'>edit</a>";
				}
				
				$output .= "</div>";
				$output .= "<div class='avia_inner_shortcode avia_connect_sort av_drop ' data-dragdrop-level='{$drop}'>";
				$output .= "<textarea data-name='text-shortcode' cols='20' rows='4'>".ShortcodeHelper::create_shortcode_by_array($name, $content, $args)."</textarea>";
				if($content)
				{
					$content = $this->builder->do_shortcode_backend($content);
				}
				$output .= $content;
				$output .= "</div>";
				$output .= "<div class='avia-layout-element-bg' ".$this->get_bg_string($args)."></div>";
				$output .= "</div>";

				return $output;
			}
			
			function get_bg_string($args)
			{
				$style = "";
			
				
				if(!empty($args['attachment']))
				{

					$explode_attachment = explode(',',$args['attachment']);
					$explode_attachment_size = explode(',',$args['attachment_size']);

					$image = false;
					$src = wp_get_attachment_image_src($explode_attachment[1], $explode_attachment_size[1]);
					if(!empty($src[0])) $image = $src[0];
					
					
					if($image)
					{
						$bg 	= !empty($args['background_color']) ? 		$args['background_color'] : "transparent"; $bg = "transparent";
						$pos 	= !empty($args['background_position'])  ? 	$args['background_position'] : "center center";
						$repeat = !empty($args['background_repeat']) ?		$args['background_repeat'] : "no-repeat";
						$extra	= "";
						
						if($repeat == "stretch")
						{
							$repeat = "no-repeat";
							$extra = "background-size: cover;";
						}
						
						if($repeat == "contain")
						{
							$repeat = "no-repeat";
							$extra = "background-size: contain;";
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
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
				global $avia_config;

				$avia_config['current_column'] = $shortcodename;


				$first = '';
				if (isset($atts[0]) && trim($atts[0]) == 'first')  $first = 'first';
				
				$atts = shortcode_atts( array(
								'ep_style'								=> '',
								'ep_row_style'							=> '',
								'padding'								=> '',
								'padding_tablet'						=> '',
								'padding_mobile'						=> '',
								'background'		                	=> '',
								'background_color'	            		=> '',
								'background_gradient_color1'			=> '',
								'background_gradient_color2'	   		=> '',
								'background_gradient_direction'	   		=> '',
								'background_position' 					=> '',
								'background_repeat' 					=> '',
								'background_attachment' 				=> '',
								'background_overlay'					=> '',
								'row_padding'							=> '',
								'row_padding_tablet' 					=> '',
								'row_padding_mobile'					=> '',
								'row_background'		                => '',
								'row_background_color'	            	=> '',
								'row_background_gradient_color1'		=> '',
								'row_background_gradient_color2'	   	=> '',
								'row_background_gradient_direction'	   	=> '',
								'row_background_position' 				=> '',
								'row_background_repeat' 				=> '',
								'row_background_attachment' 			=> '',
								'row_id'								=> '',
								'row_class'								=> '',
								'fetch_image'							=> '',
								'row_fetch_image'						=> '',
								'attachment_size'						=> '',
								'attachment'							=> '',
								'radius'								=> '',
								'row_radius'							=> '',
								'space'									=> '',
								'row_border'							=> '',
								'row_border_color'						=> '',
								'row_border_style'						=> 'solid',
								'border'								=> '',
								'border_color'							=> '',
								'border_style'							=> 'solid',
								'column_boxshadow'						=> '',
								'column_boxshadow_color'				=> 'rgba(0,0,0,0.1)',
								'column_boxshadow_width'				=> '10px',
								'row_container'							=> '',
								'offset_right'							=> '',
								'offset_left'							=> '',
								'offset_fwd_mobile'						=> '',
								'row_boxshadow'							=> '',
								'row_boxshadow_color'   				=> 'rgba(0,0,0,0.1)',
								'row_boxshadow_width'   				=> '10px',
								'margin'								=> '',
								'margin_tablet'							=> '',
								'margin_mobile'							=> '',
								'custom_space'							=> '',
								'custom_margin'							=> '',
								'min_height'							=> '',
								'vertical_alignment'					=> 'av-align-top',
								'animation'								=> '',
								'link'									=> '',
								'linktarget'							=> '',
								'link_hover'							=> '',
								'title_attr'							=> '',
								'alt_attr'								=> '',
								'mobile_display'						=> '',
								'mobile_breaking'						=> 'av-break-at-mobile',
								'reverse_order'							=> '',
								'remove_margins'						=> '',
								'highlight' 							=> '',
								'highlight_size'						=> '',

							), $atts, $this->config['shortcode'] );
				
				
				if( $first )
				{
					avia_sc_columns::$first_atts = $atts;
					avia_sc_columns::$row_count++;
				}
				
				
				$extraClass	 = "";
				$extraRowclass = "";
				$outer_style = "";
				$overlay_outer_style = "";
				$inner_style = "";
				$row_style = "";
				$output		 = "";
				$extra_table_class = "";
				$anim_class  = empty($atts['animation']) ? "" : " av-animated-generic ".$atts['animation']." ";
				$extraClass .= $anim_class;
				$extraClass .= empty($atts['mobile_display']) ? "" : " ".$atts['mobile_display']." ";
			
				$explode_attachment = explode(',',$atts['attachment']);
				$explode_attachment_size = explode(',',$atts['attachment_size']);
				
				if(!empty($explode_attachment[0]) && !empty($explode_attachment_size[0]))
				{
					$src = wp_get_attachment_image_src($explode_attachment[0], $explode_attachment_size[0]);
					if(!empty($src[0])) $atts['row_fetch_image'] = $src[0];
				}

				if(!empty($explode_attachment[1]) && !empty($explode_attachment_size[1]))
				{
					$src = wp_get_attachment_image_src($explode_attachment[1], $explode_attachment_size[1]);
					if(!empty($src[0])) $atts['fetch_image'] = $src[0];
				}
				
				
				if($atts['background_repeat'] == "stretch")
				{
					$extraClass .= " avia-full-stretch";
					$atts['background_repeat'] = "no-repeat";
				}
				
				if($atts['background_repeat'] == "contain")
				{
					$extraClass .= " avia-full-contain";
					$atts['background_repeat'] = "no-repeat";
				}

				
				if($atts['row_background_repeat'] == "stretch")
				{
					$extraRowclass .= " avia-full-stretch";
					$atts['row_background_repeat'] = "no-repeat";
				}
				
				if($atts['row_background_repeat'] == "contain")
				{
					$extraRowclass .= " avia-full-contain";
					$atts['row_background_repeat'] = "no-repeat";
				}

				
				if( !empty( avia_sc_columns::$first_atts['space'] ) )
				{
					$extraClass .= " ".avia_sc_columns::$first_atts['space'];
				}
				
				if( !empty( avia_sc_columns::$first_atts['mobile_breaking'] ) )
				{
					$extraClass .= " ".avia_sc_columns::$first_atts['mobile_breaking'];
					$extra_table_class = " av-break-at-tablet-table";
				}
				
				
				if( !empty( avia_sc_columns::$first_atts['min_height'] ) )
				{
					$extraClass .= " flex_column_table_cell";
					$extraClass .= " ".avia_sc_columns::$first_atts['min_height']." ".avia_sc_columns::$first_atts['vertical_alignment'];
				}
				else
				{
					$extraClass .= " flex_column_div";
				}

				$margins = "";

				if( !empty( avia_sc_columns::$first_atts['custom_margin'] ) ) {

					/** TODO: declutter this */
					$explode_margin = explode(',',avia_sc_columns::$first_atts['margin']);
					if( count( $explode_margin) <= 1 ) {
						$explode_margin[1] = $explode_margin[0];
					}
					
					$atts['margin-top'] = $explode_margin[0];
					$atts['margin-bottom'] = $explode_margin[1];


					$explode_margin = explode(',',avia_sc_columns::$first_atts['margin_tablet']);
					if( count( $explode_margin) <= 1 ) {
						$explode_margin[1] = $explode_margin[0];
					}
					
					$atts['margin-top-tablet'] = $explode_margin[0];
					$atts['margin-bottom-tablet'] = $explode_margin[1];

					$explode_margin = explode(',',avia_sc_columns::$first_atts['margin_mobile']);
					if( count( $explode_margin) <= 1 ) {
						$explode_margin[1] = $explode_margin[0];
					}
					
					$atts['margin-top-mobile'] = $explode_margin[0];
					$atts['margin-bottom-mobile'] = $explode_margin[1];

					if( $atts['margin_tablet'] == '' && $atts['margin_mobile'] == "" ) {

						$margins .= AviaHelper::style_string($atts, 'margin-top');
						$margins .= AviaHelper::style_string($atts, 'margin-bottom');
						
						if( !empty( avia_sc_columns::$first_atts['min_height'] ) ) {
							$row_style .= $margins;
						} else {
							$outer_style .= $margins;
						}

					} else {

						$id = "";

						$selector = !empty( avia_sc_columns::$first_atts['min_height'] ) ? "flex-column-table-" . avia_sc_columns::$row_count . " " . avia_sc_columns::$first_atts['row_class'] : $meta["el_class"]; 

						if( !empty( avia_sc_columns::$first_atts['min_height'] ) && !empty( avia_sc_columns::$first_atts['row_id'] ) ){
							$id = avia_sc_columns::$first_atts['row_id'];
						}

						$selector = EnfoldPlusHelpers::selector_generator( $selector, $id );
						$style_content = EnfoldPlusHelpers::build_responsive_style_tag( $selector, $atts, 'margin-top', 'margin-top-tablet', 'margin-top-mobile', 'margin-top' );
						$style_content .= EnfoldPlusHelpers::build_responsive_style_tag( $selector, $atts, 'margin-bottom', 'margin-bottom-tablet', 'margin-bottom-mobile', 'margin-bottom' );
						$this->extra_style .= $style_content;
	
					}

				}


				

				if( $atts['padding_tablet'] == '' && $atts['padding_mobile'] == "" ) {

					$atts['padding'] = EnfoldPlusHelpers::attribute_exploder( $atts['padding'] );

					if( $atts['padding'] == "0px" || $atts['padding'] == "0" || $atts['padding'] == "0%" ) {
						$extraClass .= " av-zero-column-padding";
						$atts['padding'] = "";
					}

				} else {

					$column_id = $meta['custom_id_val'] ? $meta['custom_id_val'] : "";

					$atts['padding'] = EnfoldPlusHelpers::attribute_exploder( $atts['padding'] );
					$atts['padding_tablet'] = EnfoldPlusHelpers::attribute_exploder( $atts['padding_tablet'] );
					$atts['padding_mobile'] = EnfoldPlusHelpers::attribute_exploder( $atts['padding_mobile'] );
					
					$style_content = EnfoldPlusHelpers::build_responsive_style_tag( EnfoldPlusHelpers::selector_generator( $meta["el_class"], $column_id ), $atts, 'padding', 'padding_tablet', 'padding_mobile', 'padding' );
					$this->extra_style .= $style_content;

					$atts['padding'] = "";

				}
				


				if( $atts['row_padding_tablet'] == '' && $atts['row_padding_mobile'] == "" ) {

					$atts['row_padding'] = EnfoldPlusHelpers::attribute_exploder( $atts['row_padding'] );
					
					if( $atts['row_padding'] == "0px" || $atts['row_padding'] == "0" || $atts['row_padding'] == "0%" ) {
						$atts['row_padding'] = "";
					}

				} else {
					
					$atts['row_padding'] = EnfoldPlusHelpers::attribute_exploder( $atts['row_padding'] );
					$atts['row_padding_tablet'] = EnfoldPlusHelpers::attribute_exploder( $atts['row_padding_tablet'] );
					$atts['row_padding_mobile'] = EnfoldPlusHelpers::attribute_exploder( $atts['row_padding_mobile'] );
					
					$style_content = EnfoldPlusHelpers::build_responsive_style_tag( "#top .flex-column-table-".avia_sc_columns::$row_count, $atts, 'row_padding', 'row_padding_tablet', 'row_padding_mobile', 'padding' );
					$this->extra_style .= $style_content;

					$atts['row_padding'] = "";

				}
								
				$atts['radius'] = EnfoldPlusHelpers::attribute_exploder( $atts['radius'] );

				if( $atts['radius'] == "0px" || $atts['radius'] == "0" || $atts['radius'] == "0%" ) {
					$atts['radius'] = "";
				}
				
				$atts['row_radius'] = EnfoldPlusHelpers::attribute_exploder( $atts['row_radius'] );				

				if( $atts['row_radius'] == "0px" || $atts['row_radius'] == "0" || $atts['row_radius'] == "0%" ) {
					$atts['row_radius'] = "";
				}


				// background image, color and gradient
				$bg_image = "";
				$row_bg_image = "";
				
				if(!empty($atts['fetch_image']))
				{
					if( !empty( $atts['background_overlay'] ) ){
						$overlay_outer_style .= $atts['background_repeat'] ? "background-repeat: {$atts['background_repeat']};" : "";
						$overlay_outer_style .= $atts['background_attachment'] ? "background-attachment: {$atts['background_attachment']};" : "";
						$overlay_outer_style .= $atts['background_position'] ? "background-position: {$atts['background_position']};" : "";
					} else {
						$outer_style .= $atts['background_repeat'] ? "background-repeat: {$atts['background_repeat']};" : "";
						$outer_style .= $atts['background_attachment'] ? "background-attachment: {$atts['background_attachment']};" : "";
						$outer_style .= $atts['background_position'] ? "background-position: {$atts['background_position']};" : "";
					}

					$bg_image .= "url({$atts['fetch_image']})";
				}

				if(!empty($atts['row_fetch_image']))
				{
					$row_style .= $atts['row_background_repeat'] ? "background-repeat: {$atts['row_background_repeat']};" : "";
					$row_style .= $atts['row_background_attachment'] ? "background-attachment: {$atts['row_background_attachment']};" : "";
					$row_style .= $atts['row_background_position'] ? "background-position: {$atts['row_background_position']};" : "";

					$row_bg_image .= "url({$atts['row_fetch_image']})";
				}



				$row_has_bg_color_or_gradient = false;

				if ($atts['row_background'] == 'bg_color')
				{
					$row_bg_string = "";

					if ($atts['row_background_color'])
					{
						$row_bg_string .= $atts['row_background_color'];
						$row_has_bg_color_or_gradient = true;

						if( $row_bg_image ) {
							$row_style .= "--epBGImg: {$row_bg_image};";
						}
	
					}

					$atts['row_background_string'] = $row_bg_string;

					$row_style .= AviaHelper::style_string( $atts, 'row_background_string', 'background-color' );


				}
				// assemble gradient declaration
				else {
					if ( $atts['row_background_gradient_color1'] && $atts['row_background_gradient_color2'])
					{
						$row_has_bg_color_or_gradient = true;
						$row_gradient_val = '';

						// add image string if available
						if($row_bg_image)
						{
							$row_gradient_val .= $row_bg_image . ', ';
						}

						switch ($atts['row_background_gradient_direction']) 
						{
							case 'vertical':
								$row_gradient_val .= 'linear-gradient(';
								break;
							case 'horizontal':
								$row_gradient_val .= 'linear-gradient(to right,';
								break;
							case 'radial':
								$row_gradient_val .= 'radial-gradient(';
								break;
							case 'diagonal_tb':
								$row_gradient_val .= 'linear-gradient(to bottom right,';
								break;
							case 'diagonal_bt':
								$row_gradient_val .= 'linear-gradient(45deg,';
								break;
						}

						$row_gradient_val .= $atts['row_background_gradient_color1'].','.$atts['row_background_gradient_color2'].')';

						// fallback background color for IE9
						if ($atts['row_background_color'] == "") 
						{
							$row_style .= AviaHelper::style_string($atts, 'row_background_gradient_color1', 'background-color');
						}

						$atts['row_background_string'] = $row_gradient_val;
						$bg_property = $row_bg_image ? '--epBGImg' : 'background';
						$row_style .= AviaHelper::style_string($atts, 'row_background_string', $bg_property);
					}
				}

				if ( !$row_has_bg_color_or_gradient ) 
				{
					$atts['row_background_string'] = $row_bg_image;
					$bg_property = $row_bg_image ? '--epBGImg' : 'background';
					$row_style .= AviaHelper::style_string($atts, 'row_background_string', $bg_property);
				}



				$has_bg_color_or_gradient = false;


				if ($atts['background'] == 'bg_color')
				{
					$bg_string = "";

					if ($atts['background_color']) {
						$bg_string .= $atts['background_color'];
						$has_bg_color_or_gradient = true;

						if( $bg_image ) {
							if( !empty( $atts['background_overlay'] ) ) {
								$overlay_outer_style .= "--epBGImg: {$bg_image};";
							} else {
								$outer_style .= "--epBGImg: {$bg_image};";
							}
						}
					}
					
					$atts['background_string'] = $bg_string;
					
					if( !empty( $atts['background_overlay'] ) ) {
						$overlay_outer_style .= AviaHelper::style_string( $atts, 'background_string', 'background-color' );	
					} else {
						$outer_style .= AviaHelper::style_string( $atts, 'background_string', 'background-color' );	
					}
				}

				// assemble gradient declaration
				else {
					if ( $atts['background_gradient_color1'] && $atts['background_gradient_color2'])
					{
						$has_bg_color_or_gradient = true;
						$gradient_val = '';

						// add image string if available
						if($bg_image)
						{
							$gradient_val .= $bg_image.', ';
						}

						switch ($atts['background_gradient_direction']) 
						{
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

						// fallback background color for IE9
						if ($atts['background_color'] == "") 
						{
							$outer_style .= AviaHelper::style_string($atts, 'background_gradient_color1', 'background-color');
						}

						$atts['background_string'] = $gradient_val;
						$bg_property = $bg_image ? '--epBGImg' : 'background';

						if( !empty( $atts['background_overlay'] ) ){
							$overlay_outer_style .= AviaHelper::style_string($atts, 'background_string', $bg_property );	
						} else {
							$outer_style .= AviaHelper::style_string($atts, 'background_string', $bg_property );	
						}
	
					}
				}

				if ( !$has_bg_color_or_gradient ) 
				{
					$atts['background_string'] = $bg_image;
					$bg_property = $bg_image ? '--epBGImg' : 'background';
					if( !empty( $atts['background_overlay'] ) ){
						$overlay_outer_style .= AviaHelper::style_string($atts, 'background_string', $bg_property );	
					} else {
						$outer_style .= AviaHelper::style_string($atts, 'background_string', $bg_property );	
					}

				}


				if(!empty($atts['border']))
				{
					$outer_style .= AviaHelper::style_string($atts, 'border', 'border-width', 'px');
					$outer_style .= AviaHelper::style_string($atts, 'border_color', 'border-color');
					$outer_style .= AviaHelper::style_string($atts, 'border_style', 'border-style');
				}


				if(!empty($atts['row_border']))
				{
					$row_style .= AviaHelper::style_string($atts, 'row_border', 'border-width', 'px');
					$row_style .= AviaHelper::style_string($atts, 'row_border_color', 'border-color');
					$row_style .= AviaHelper::style_string($atts, 'row_border_style', 'border-style');
				}

				if (!empty($atts['column_boxshadow']))
				{
					if (array_key_exists('column_boxshadow_width',$atts) && array_key_exists('column_boxshadow_color',$atts)) 
					{
						if ($atts['column_boxshadow_width'] !== '' && $atts['column_boxshadow_color'] !== '') 
						{
							$outer_style .= 'box-shadow: 0 0 '.$atts['column_boxshadow_width'].'px 0 '.$atts['column_boxshadow_color'].'; ';
						}
					}
				}
				

				if (!empty($atts['row_boxshadow']))
				{
					if (array_key_exists('row_boxshadow_width',$atts) && array_key_exists('row_boxshadow_color',$atts)) 
					{
						if ($atts['row_boxshadow_width'] !== '' && $atts['row_boxshadow_color'] !== '') 
						{
							$row_style .= 'box-shadow: 0 0 '.$atts['row_boxshadow_width'].'px 0 '.$atts['row_boxshadow_color'].'; ';
						}
					}
				}



				if (!empty($atts['highlight']) )
				{
					if ( array_key_exists('highlight_size',$atts)) 
					{
						$highlight_size = $atts['highlight_size'];
						$outer_style .= "-webkit-transform: scale({$highlight_size}); -ms-transform: scale({$highlight_size}); transform: scale({$highlight_size}); z-index: 4;";
					}
				}


				$outer_style .= AviaHelper::style_string($atts, 'padding');
				if( !empty( $atts['background_overlay'] ) ){
					$overlay_outer_style  = AviaHelper::style_string($overlay_outer_style);
				} else {
					// $outer_style .= AviaHelper::style_string($atts, 'background_color', 'background-color');
				}
				$outer_style .= AviaHelper::style_string($atts, 'radius', 'border-radius');
				$outer_style  = AviaHelper::style_string($outer_style);

				$row_style .= AviaHelper::style_string($atts, 'row_padding', 'padding');
				// $row_style .= AviaHelper::style_string($atts, 'row_background_color', 'background-color');
				$row_style .= AviaHelper::style_string($atts, 'row_radius', 'border-radius');				
				$row_style  = AviaHelper::style_string($row_style);

				if( $first )
				{	
					avia_sc_columns::$calculated_size = 0;
					
					if(!empty($meta['siblings']['prev']['tag']) &&
					in_array($meta['siblings']['prev']['tag'], array('av_one_full','av_one_half', 'av_one_third', 'av_two_third', 'av_three_fourth' , 'av_one_fourth' , 'av_one_fifth', 'av_one_sixth', 'av_textblock')))
					{
						avia_sc_columns::$extraClass = "column-top-margin";
					}
					else
					{
						avia_sc_columns::$extraClass = "";
					}
				}
				
				
				if( !empty( avia_sc_columns::$first_atts['reverse_order'] ) ){
					$extraRowclass .= " reverse-order";
				}

				
				if( !empty( avia_sc_columns::$first_atts['row_container'] ) ){
					$extraRowclass .= " container";
				}

				if( !empty( avia_sc_columns::$first_atts['offset_right'] ) ){
					$extraRowclass .= " offset-right";
				}

				if( !empty( avia_sc_columns::$first_atts['offset_left'] ) ){
					$extraRowclass .= " offset-left";
				}

				
				if( !empty( avia_sc_columns::$first_atts['offset_fwd_mobile'] ) ){
					$extraRowclass .= " offset-fwd-mobile";
				}


				if(!empty( avia_sc_columns::$first_atts['min_height'] ) && avia_sc_columns::$calculated_size == 0)
				{
					$row_id = !empty( avia_sc_columns::$first_atts['row_id'] ) ? "id='".avia_sc_columns::$first_atts['row_id']."'" : "";
					$row_wrapper_data = apply_filters( "avf_ep_row_wrapper_data", "", $meta );
					$data_lazy_bg = $row_bg_image ? 'data-lazy-bg' : '';

					if( ! current_theme_supports( "ep-bg-lazy-load" ) ) {
						$extraRowclass .= " ep-lazy-loaded";
					}
					
					$output .= "<div {$row_id} {$data_lazy_bg} class='flex_column_table " . $extraRowclass . " ".avia_sc_columns::$first_atts['row_class']." ". $meta['row_class'] . " " . avia_sc_columns::$first_atts['min_height']."-flextable ".avia_sc_columns::$first_atts['mobile_breaking']."-flextable flex-column-table-".avia_sc_columns::$row_count." ' {$row_style} {$row_wrapper_data}>";
				}	
				
				if(!$first && avia_sc_columns::$first_atts['space'] !== 'no_margin' && !empty( avia_sc_columns::$first_atts['min_height'] ))
				{
					$custom_space_styling = "";

					if( avia_sc_columns::$first_atts['space'] == 'custom_space' && !empty(avia_sc_columns::$first_atts['custom_space']) )
					{
						$custom_space_styling = "style='width: ".avia_sc_columns::$first_atts['custom_space']."'";
					} 

					$output .= "<div class='av-flex-placeholder' {$custom_space_styling}></div>";
				}
				
				avia_sc_columns::$calculated_size += avia_sc_columns::$size_array[ $this->config['shortcode'] ];
				
				$link = aviaHelper::get_url( $atts['link'] );
				$link_data = '';
				$screen_reader_link = "";
				if( ! empty( $link ) )
				{
					$extraClass .= ' avia-link-column av-column-link';
					if( ! empty( $atts['link_hover'] ) )
					{
						$extraClass .= ' avia-link-column-hover';
					}
					
					$screen_reader = '';
					
					$link_data .= ' data-link-column-url="' . esc_attr( $link ) . '" ';
					
					if( ( strpos( $atts['linktarget'], '_blank' ) !== false ) )
					{
						$link_data .=  ' data-link-column-target="_blank" ';
						$screen_reader .= ' target="_blank" ';
					}
						
					//	we add this, but currently not supported in js
					if( strpos( $atts['linktarget'], 'nofollow' ) !== false )
					{
						$link_data .= ' data-link-column-rel="nofollow" ';
						$screen_reader .= ' rel="nofollow" ';
					}
					if( ! empty( $atts['title_attr'] ) )
					{
						$screen_reader .= ' title="' . esc_attr( $atts['title_attr'] ) . '"';
					}
					
					if( ! empty( $atts['alt_attr'] ) )
					{
						$screen_reader .= ' alt="' . esc_attr( $atts['alt_attr'] ) . '"';
					}

					/**
					 * Add an invisible link also for screen readers
					 */				
					$screen_reader_link .=	'<a class="av-screen-reader-only" href=' . esc_attr( $link ) . " {$screen_reader}" . '>';
					$screen_reader_link .=		aviaHelper::get_screen_reader_url_text( $atts['link'] );
					$screen_reader_link .=	'</a>';
				}
				



				if( !empty( $atts['remove_margins'] ) ){
					$extraClass .= " no-margins-on-breakpoint";
				}

				if( !empty( $atts['background_overlay'] ) ){
					$extraClass .= " background-overlay-enabled";
				}

				$aria_label = ! empty( $meta['aria_label'] ) ? " aria-label='{$meta['aria_label']}' " : '';
				
				$wrapper_data = apply_filters( "avf_ep_column_wrapper_data", "", $meta );

				$column_data_lazy_bg = empty( $atts['background_overlay'] ) ? ( $bg_image ? 'data-lazy-bg' : '' ) : '';
				$column_overlay_data_lazy_bg = !empty( $atts['background_overlay'] ) ? ( $bg_image ? 'data-lazy-bg' : '' ) : '';

				$lazy_loaded_class = "";
				if( ! current_theme_supports( "ep-bg-lazy-load" ) ) {
					$lazy_loaded_class = "ep-lazy-loaded";
				}

				$output  .= '<div ' . $column_data_lazy_bg . ' class="flex_column ' . $shortcodename . ' ' . $extraClass . ' ' . $lazy_loaded_class . ' ' . $first . ' ' . $meta['el_class'] . ' ' . avia_sc_columns::$extraClass . '" ' . $outer_style . $link_data . $meta['custom_el_id'] . $aria_label . $wrapper_data . '>';
				if( !empty( $atts['background_overlay'] ) ){
					$output  .= '<div ' . $column_overlay_data_lazy_bg . ' class="flex-column-overlay ' . $lazy_loaded_class . '" '. $overlay_outer_style .'></div>';
				}
				$output .= '<div class="flex-column-inner">';
				$output .= $screen_reader_link;
				//if the user uses the column shortcode without the layout builder make sure that paragraphs are applied to the text
				$content =  (empty($avia_config['conditionals']['is_builder_template'])) ? ShortcodeHelper::avia_apply_autop(ShortcodeHelper::avia_remove_autop($content)) : ShortcodeHelper::avia_remove_autop($content, true);

				$output .= trim( $content );

				$output .= '</div>';

				$output .= '</div>';
				
				
				
				$force_close = false;
				
				if( isset($meta['siblings']) && isset($meta['siblings']['next']) && isset( $meta['siblings']['next']['tag'] ) )
				{
					if(!array_key_exists($meta['siblings']['next']['tag'], avia_sc_columns::$size_array))
					{
						$force_close = true;
					}
				}
				
				/**
				 * check if row will break into next column 
				 */
				if( ( false === $force_close ) && ! empty( avia_sc_columns::$first_atts['min_height'] ) && ( 'av-equal-height-column' ==  avia_sc_columns::$first_atts['min_height'] ) )
				{
					if( ! isset( $meta['siblings']['next']['tag'] ) )
					{
						$force_close = true;
					}
					else if( ( avia_sc_columns::$calculated_size + avia_sc_columns::$size_array[ $meta['siblings']['next']['tag'] ] ) > 1.0 )
					{
						$force_close = true;
					}
				}
				

				if( !empty( avia_sc_columns::$first_atts['min_height']) && (avia_sc_columns::$calculated_size >= 0.95 || $force_close) )
				{
					$output .= "</div><!--close column table wrapper. Autoclose: {$force_close} -->";
					avia_sc_columns::$calculated_size = 0;
				}

				unset($avia_config['current_column']);

				if( $this->extra_style !== "" ) {
					add_action( 'wp_footer', array( $this, 'print_extra_style' ) );
				}

				return $output;
			}

			/**
			 * Handler printed in footer
			*/
			public function print_extra_style() {
				echo "<style>";
				echo $this->extra_style;
				echo "</style>";
			}
			
	}
}


if ( ! class_exists( 'avia_sc_columns_one_half' ) )
{
	class avia_sc_columns_one_half extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '1/2';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-half.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 90;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_one_half';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 50&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array( 
												'name' => '1/2 + 1/2', 
												'instantInsert' => '[av_one_half first]Add Content here[/av_one_half]\n\n\n[av_one_half]Add Content here[/av_one_half]' 
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}


if ( ! class_exists( 'avia_sc_columns_one_third' ) )
{
	class avia_sc_columns_one_third extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '1/3';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-third.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 80;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_one_third';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 33&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '1/3 + 1/3 + 1/3',
												'instantInsert'	=> '[av_one_third first]Add Content here[/av_one_third]\n\n\n[av_one_third]Add Content here[/av_one_third]\n\n\n[av_one_third]Add Content here[/av_one_third]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_two_third' ) )
{
	class avia_sc_columns_two_third extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '2/3';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-two_third.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 70;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_two_third';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 67&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '2/3 + 1/3',
												'instantInsert'	=> '[av_two_third first]Add 2/3 Content here[/av_two_third]\n\n\n[av_one_third]Add 1/3 Content here[/av_one_third]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_one_fourth' ) )
{
	class avia_sc_columns_one_fourth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '1/4';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-fourth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 60;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_one_fourth';
			$this->config['tooltip'] 	= __( 'Creates a single column with 25&percnt; width', 'avia_framework' );
			$this->config['html_renderer'] 	= false;
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '1/4 + 1/4 + 1/4 + 1/4',
												'instantInsert'	=> '[av_one_fourth first]Add Content here[/av_one_fourth]\n\n\n[av_one_fourth]Add Content here[/av_one_fourth]\n\n\n[av_one_fourth]Add Content here[/av_one_fourth]\n\n\n[av_one_fourth]Add Content here[/av_one_fourth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_three_fourth' ) )
{
	class avia_sc_columns_three_fourth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '3/4';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-three_fourth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 50;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_three_fourth';
			$this->config['tooltip'] 	= __( 'Creates a single column with 75&percnt; width', 'avia_framework' );
			$this->config['html_renderer'] 	= false;
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '3/4 + 1/4',
												'instantInsert'	=> '[av_three_fourth first]Add 3/4 Content here[/av_three_fourth]\n\n\n[av_one_fourth]Add 1/4 Content here[/av_one_fourth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_one_fifth' ) )
{
	class avia_sc_columns_one_fifth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '1/5';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-fifth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 40;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_one_fifth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 20&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '1/5 + 1/5 + 1/5 + 1/5 + 1/5',
												'instantInsert'	=> '[av_one_fifth first]1/5[/av_one_fifth]\n\n\n[av_one_fifth]2/5[/av_one_fifth]\n\n\n[av_one_fifth]3/5[/av_one_fifth]\n\n\n[av_one_fifth]4/5[/av_one_fifth]\n\n\n[av_one_fifth]5/5[/av_one_fifth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_one_sixth' ) )
{
	class avia_sc_columns_one_sixth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '1/6';
			$this->config['icon']		= ENFOLD_PLUS_ASSETS . 'img/sc-sixth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 39;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_one_sixth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 16.66&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
				'name'			=> '1/6 + 1/6 + 1/6 + 1/6 + 1/6',
				'instantInsert'	=> '[av_one_sixth first]1/6[/av_one_sixth]\n\n\n[av_one_sixth]2/6[/av_one_sixth]\n\n\n[av_one_sixth]3/6[/av_one_sixth]\n\n\n[av_one_sixth]4/6[/av_one_sixth]\n\n\n[av_one_sixth]5/6[/av_one_sixth]\n\n\n[av_one_sixth]6/6[/av_one_sixth]'
			);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_two_fifth' ) )
{
	class avia_sc_columns_two_fifth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '2/5';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-two_fifth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 38;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_two_fifth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 40&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '2/5',
												'instantInsert'	=> '[av_two_fifth first]2/5[/av_two_fifth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_three_fifth' ) )
{
	class avia_sc_columns_three_fifth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '3/5';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-three_fifth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 37;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_three_fifth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 60&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '3/5',
												'instantInsert'	=> '[av_three_fifth first]3/5[/av_three_fifth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

if ( ! class_exists( 'avia_sc_columns_four_fifth' ) )
{
	class avia_sc_columns_four_fifth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '4/5';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-four_fifth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 36;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_four_fifth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 80&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '4/5',
												'instantInsert'	=> '[av_four_fifth first]4/5[/av_four_fifth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}


if ( ! class_exists( 'avia_sc_columns_five_sixth' ) )
{
	class avia_sc_columns_five_sixth extends avia_sc_columns
	{

		function shortcode_insert_button()
		{
			$this->config['name']		= '5/6';
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-four_fifth.png';
			$this->config['tab']		= __( 'Layout Elements', 'avia_framework' );
			$this->config['order']		= 35;
			$this->config['target']		= 'avia-section-drop';
			$this->config['shortcode'] 	= 'av_five_sixth';
			$this->config['html_renderer'] 	= false;
			$this->config['tooltip'] 	= __( 'Creates a single column with 80&percnt; width', 'avia_framework' );
			$this->config['drag-level'] = 2;
			$this->config['drop-level'] = 2;
			$this->config['tinyMCE'] 	= array(
												'name'			=> '5/6',
												'instantInsert'	=> '[av_five_sixth first]5/6[/av_five_sixth]'
											);
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['aria_label']	= 'yes';
		}
	}
}

