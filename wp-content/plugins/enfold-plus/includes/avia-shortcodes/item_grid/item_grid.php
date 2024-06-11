<?php
/**
 * Item Grid
 * 
 * Creates a Item grid Grid
 * 
 * Update procedure:
 * S&R ep-logo --> ep-item
 * S&R ep_logo -- > ep_item
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( !class_exists( 'ep_sc_item_grid' ) )
{
	class ep_sc_item_grid extends aviaShortcodeTemplate
	{
	
			public $el_meta;
			public $column_class;
			public $column_class_inner;
			public $flickity_lazy_load;
			public $item_styling;
			public $item_index;

			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['version']		= '1.0';
				$this->config['self_closing']	= 'no';
				$this->config['base_element']	= 'yes';

				$this->config['name']		= __( 'Item Grid/Slider', 'avia_framework' );
				$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-partner.png";
				$this->config['order']		= 94;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'ep_item_grid';
				$this->config['shortcode_nested'] = array( 'ep_item_grid_inner' );
				$this->config['tooltip'] 	= __('Creates a Item Grid', 'avia_framework' );
				$this->config['preview'] 	= true;
				$this->config['disabling_allowed'] = true;
				$this->config['id_name']		= 'id';
				$this->config['id_show']		= 'yes';	
			}
			
			function extra_assets(){
				EnfoldPlusHelpers::flickity_assets(); // bulma gets included here

				wp_enqueue_style( 'avia-module-ep-grids' , ENFOLD_PLUS_ASSETS . 'css/ep_grids.css', array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
				wp_enqueue_style( 'avia-module-ep-item-grid' , ENFOLD_PLUS_ASSETS . 'css/ep_item_grid.css', array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
				wp_enqueue_script( 'avia-module-ep-item-grid', ENFOLD_PLUS_ASSETS . 'js/ep_item_grid.js', array( 'avia-module-ep-shortcodes-sc' ), ENFOLD_PLUS_VERSION, true );
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
							"type" 	=> "tab_container", 'nodescription' => true
						),
						
						array(
							"type" 	=> "tab",
							"name"  => __("Content" , 'avia_framework'),
							'nodescription' => true
						),
						
						array(
							"name" => __("Add/Edit Element", 'avia_framework' ),
							"desc" => __("Here you can add, remove and edit your Elements.", 'avia_framework' ),
							"type" 			=> "modal_group",
							"id" 			=> "content",
							'container_class'	=> 'avia-element-fullwidth avia-multi-img',
							'modal_title'	=> __( 'Edit Form Element', 'avia_framework' ),
							'add_label'		=> __( 'Add single item', 'avia_framework' ),
							'lockable' => true,
							"std"			=> array(
								array(
									'title'		=> __( 'Item 1', 'avia_framework' ),
									'id'		=> '',
									'content'	=> __( 'Enter content here', 'avia_framework' )
								),
							),
							'creator'	=> array(
								'name'	=> __( 'Add items', 'avia_framework' ),
								'desc'	=> __( 'Here you can add new items to the item grid element.', 'avia_framework' ),
								'id'	=> 'id',
								'type'	=> 'multi_image',
								'title'		=> __( 'Add multiple items', 'avia_framework' ),
								'button'	=> __( 'Insert items', 'avia_framework' ),
								'std'	=> ""
							),

							'subelements' 	=> array(								

								array(
									"type" 	=> "tab_container", 'nodescription' => true
								),
								
								array(
									"type" 	=> "tab",
									"name"  => __("Content" , 'avia_framework'),
									'nodescription' => true
								),

								array(
									'name' => __( 'Type', 'avia_framework' ),
									'desc' => __( 'Item Type', 'avia_framework' ),
									'id'   => 'type',
									'type' 	=> 'select',
									'lockable' => true,
									'std' 	=> '',
									'subtype'	=> array(	
													__( 'Image', 'avia_framework' )	=> '',
													__( 'Icon', 'avia_framework' )	=> 'icon',
													__( 'Both (one after the other)', 'avia_framework' ) => 'both',
												)
								),

								array(
									'name' => '',
									'desc'   => '',
									'nodescription' => 1,
									'type' => 'icon_switcher_container',
									"required" => array( "type", "not", "icon" ),
								),
						
								array(
									'type' => 'icon_switcher',
									'name' => __( 'Desktop', 'avia_framework' ),
									'icon' => 'desktop',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),

								array(
									'name' 	=> __( 'Choose an Image', 'avia_framework' ),
									'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
									'id' 	=> 'id',
									'fetch' => 'id',
									'type' 	=> 'image',
									"required" => array( "type", "not", "icon" ),
									'title'		=> __( 'Change Image', 'avia_framework' ),
									'button'	=> __( 'Change Image', 'avia_framework' ),
									'lockable' => true,
									'std' 	=> ''
								),

								array(
									'type' => 'icon_switcher_close',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),
								
								array(
									'type' => 'icon_switcher',
									'name' => __( 'Tablet', 'avia_framework' ),
									'icon' => 'tablet-landscape',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),

								array(
									'name' 	=> __( 'Choose another Image (Tablet)', 'avia_framework' ),
									'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
									'id' 	=> 'id_tablet',
									'fetch' => 'id',
									'type' 	=> 'image',
									"required" => array( "type", "not", "icon" ),
									'title'		=> __( 'Change Image', 'avia_framework' ),
									'button'	=> __( 'Change Image', 'avia_framework' ),
									'lockable' => true,
									'std' 	=> ''
								),
								
								array(
									'type' => 'icon_switcher_close',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),
						
								array(
									'type' => 'icon_switcher',
									'name' => __( 'Mobile', 'avia_framework' ),
									'icon' => 'mobile',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),

								array(
									'name' 	=> __( 'Choose another Image (Mobile)', 'avia_framework' ),
									'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
									'id' 	=> 'id_mobile',
									'fetch' => 'id',
									'type' 	=> 'image',
									"required" => array( "type", "not", "icon" ),
									'title'		=> __( 'Change Image', 'avia_framework' ),
									'button'	=> __( 'Change Image', 'avia_framework' ),
									'lockable' => true,
									'std' 	=> ''
								),

								array(
									'type' => 'icon_switcher_close',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),
						
								array(
									'type' => 'icon_switcher_container_close',
									'nodescription' => 1,
									"required" => array( "type", "not", "icon" ),
								),

								array(
									'name'  => __( 'Font Icon', 'avia_framework' ),
									'desc'  => __( 'Select an Icon below', 'avia_framework' ),
									'id'    => 'icon',
									'type'  => 'iconfont',
									"required" => array( "type", "not", "" ),
									'lockable' => true,
									'std'   => ''
								),

								array(
									'name' => __( 'Title', 'avia_framework' ),
									'desc' => __( 'Title', 'avia_framework' ),
									'id'   => 'title',
									'type' 	=> 'input',
									'lockable' => true,
									'std' 	=> '',
								),

								array(
									'name' => __( 'Subtitle', 'avia_framework' ),
									'desc' => __( 'Subtitle', 'avia_framework' ),
									'id'   => 'subtitle',
									'type' 	=> 'input',
									'lockable' => true,
									'std' 	=> '',
								),

								array(
									'name' => __( 'Content', 'avia_framework' ),
									'desc' => __( 'Content below', 'avia_framework' ),
									'id'   => 'content',
									'type' 	=> 'tiny_mce',
									'lockable' => true,
									'std' 	=> '',
								),

								array(
									'type' 	=> 'tab_close',
									'nodescription' => true
								),

								array(
									"type" 	=> "tab",
									"name"  => __( "Styling" , 'avia_framework' ),
									'nodescription' => true
								),

								array(	
									'type'			=> 'template',
									'template_id'	=> 'ep_item_styling_inner'
								),

								array(
									'type' 	=> 'tab_close',
									'nodescription' => true
								),

								array(
									"type" 	=> "tab",
									"name"  => __("Advanced" , 'avia_framework'),
									'nodescription' => true
								),

								array(	
									'type'			=> 'template',
									'template_id'	=> 'linkpicker_toggle',
									'name'			=> __( 'Link?', 'avia_framework' ),
									'desc'			=> __( 'Where should it link to?', 'avia_framework' ),
									'subtypes'		=> array( 'no', 'manually', 'single', 'taxonomy' ),
									'target_id'		=> 'link_target',
									'lockable' => true,
								),

								array(
									'name' 	=> __( 'Custom CSS Class & ID', 'avia_framework' ),
									'type' 	=> 'heading',
									'description_class' => 'av-builder-note av-neutral',
								),

								array(
									'name' => __( 'Custom CSS Class', 'avia_framework' ),
									'desc' => __( 'Custom CSS Class for this item', 'avia_framework' ),
									'id'   => 'custom_class',
									'type' 	=> 'input',
									'lockable' => true,
									'std' 	=> '',
								),

								array(
									'name' => __( 'Custom ID', 'avia_framework' ),
									'desc' => __( 'Custom ID for this item', 'avia_framework' ),
									'id'   => 'custom_id',
									'type' 	=> 'input',
									'lockable' => true,
									'std' 	=> '',
								),

								array(
									'type' 	=> 'tab_close',
									'nodescription' => true
								),

								array(
									"type" 	=> "tab",
									"name"  => __( "Extra fields" , 'avia_framework' ),
									'nodescription' => true
								),
		
								array(	
									'type'			=> 'template',
									'template_id'	=> 'ep_item_grid_extra_fields'
								),
		
								array(
									'type' 	=> 'tab_close',
									'nodescription' => true
								),
		
								array(
									'type' 	=> 'tab_container_close',
									'nodescription' => true
								)

							)
					),

					array(
						'name' => __( 'Type', 'avia_framework' ),
						'desc' => __( 'Select the type for your Logo/Grid element', 'avia_framework' ),
						'id'   => 'type',
						'type' 	=> 'select',
						'lockable' => true,
						'std' 	=> '',
						'subtype'	=> array(	
										__( 'Grid', 'avia_framework' )	=> '',
										__( 'Slider', 'avia_framework' )	=> 'slider',
									)
					),

					array(
						"name" 	=> __("Pagination", 'avia_framework' ),
						"desc" 	=> __("Should a 'load more' pagination be displayed?", 'avia_framework' ),
						"id" 	=> "paginate",
						"type" 	=> "select",
						'lockable' => true,
						"std" 	=> "",
						"required" => array( "type", "not", "slider" ),
						"subtype" => array(
							__('Yes',  'avia_framework' ) => 'yes',
							__('No',  'avia_framework' ) => ''
						)
					),

					array(
						"name" 	=> __("Paginate by # Items?", 'avia_framework' ),
						"desc" 	=> __("Set the number of items to separate as Pages (default 4)", 'avia_framework' ),
						"id" 	=> "paginate_num",
						"type"  => "input",
						'lockable' => true,
						"std" 	=> "",
						"required" => array( "paginate", "equals", "yes" ),
					),

					array(
						"name" 	=> __("Load More Label", 'avia_framework' ),
						"desc" 	=> __("Set the label for the load more label (default 'Load more')", 'avia_framework' ),
						"id" 	=> "load_more_label",
						"type"  => "input",
						'lockable' => true,
						"std" 	=> "",
						"required" => array( "paginate", "equals", "yes" ),
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

					array(
						"type" 	=> "tab",
						"name"  => __( "Grid Styling" , 'avia_framework' ),
						'nodescription' => true
					),

					array(	
						'type'			=> 'template',
						'template_id'	=> 'ep_grid_styling'
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

					array(
						"type" 	=> "tab",
						"name"  => __( "Item Styling" , 'avia_framework' ),
						'nodescription' => true
					),

					array(	
						'type'			=> 'template',
						'template_id'	=> 'ep_item_styling'
					),

					array(
						'type' 	=> 'tab_close',
						'nodescription' => true
					),

					array(
						'type' 	=> 'tab',
						'name'  => __( 'Flickity', 'avia_framework' ),
						'nodescription' => true
					),
					
										
					array(
						'name' 	=> __( 'Flickity Options', 'avia_framework' ),
						'desc' 	=> __( 'None of these options will work, please switch Type to "Slider" in the previous tab in order to get this functionality.', 'avia_framework' ),
						'type' 	=> 'heading',
						'description_class' => 'av-builder-note av-notice',
						'required' => array( 'type', 'not', 'slider' ),
					),
					
					array(	
						'type'			=> 'template',
						'template_id'	=> 'ep_flickity_options'
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
						'template_id'	=> 'screen_options_toggle',
						'lockable'		=> true
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
						) ),
					),

						array(
							"name" 	=> __( "Additional Styles", 'avia_framework' ),
							"desc" 	=> __( "Select additional styles for this element", 'avia_framework' ),
							"id" 	=> "ep_extra_styles",
							"type" 	=> "select",
							"multiple" => 5,
							"lockable" => true,
							"std" 	=> apply_filters( "avf_{$this->config['shortcode']}_style_std", "" ),
							"subtype" => apply_filters( "avf_{$this->config['shortcode']}_style_options", array() ),
						),

					
					array(
						'type' 	=> 'tab_close',
						'nodescription' => true,
					),

					array(	
						'type'			=> 'template',
						'template_id'	=> 'element_template_selection_tab',
						'args'			=> array( 'sc' => $this )
					),

					array(
						'type' 	=> 'tab_container_close',
						'nodescription' => true
					)
					
				);


			}
			
			/**
			 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
			 * Works in the same way as Editor Element
			 * @param array $params this array holds the default values for $content and $args.
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_sub_element( $params )
			{
				$img_template 	= $this->update_template( 'img_fakeArg', '{{img_fakeArg}}' );
				$template		= $this->update_template( 'title', '{{title}}' );
				$content		= $this->update_template( 'content', '{{content}}' );
				$thumbnail = isset( $params['args']['id'] ) ? wp_get_attachment_image( $params['args']['id'] ) : '';
				
				extract( av_backend_icon( $params ) );

				$params['innerHtml']  = '';
				$params['innerHtml'] .= "<div class='avia_title_container ep_item_grid_item'>";
				$params['innerHtml'] .=	 '<div ' . $this->class_by_arguments( 'type' ,$params['args'] ) . '>';
				if( !empty( $params['args']['type'] ) ) {
					$params['innerHtml'] .=			'<span ' . $this->class_by_arguments( 'font', $font ) . '>';
					$params['innerHtml'] .=				"<span data-update_with='icon_fakeArg' class='avia_tab_icon'>{$display_char}</span>";
					$params['innerHtml'] .=			'</span>';
				}
				if( empty( $params['args']['type'] ) || $params['args']['type'] == 'both' ) {
					$params['innerHtml'] .=		"<span class='avia_slideshow_image' {$img_template} >{$thumbnail}</span>";
				}
				$params['innerHtml'] .=		"<span {$template} >{$params['args']['title']}</span>";
				$params['innerHtml'] .=	'</div>';
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
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
				$this->el_meta = $meta;
				$this->screen_options = AviaHelper::av_mobile_sizes( $atts );
				$this->item_index = 1;
					
				extract( $this->screen_options ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

				$el_atts = array( 
					'ep_style' => '',
					'type' => '', 
					'paginate' => '', 
					'paginate_num' => '4', 
					'load_more_label' => ''
				);

				$grid_atts = EnfoldPlusHelpers::grid_atts();
				$item_atts = EnfoldPlusHelpers::item_atts();
				$column_atts = EnfoldPlusHelpers::columns_atts();
				$slider_atts = EnfoldPlusHelpers::slider_atts();
				
				$default = array_merge( $el_atts, $grid_atts, $item_atts, $column_atts, $slider_atts );

				if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
					$default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );
					$locked = array();
					Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
					Avia_Element_Templates()->add_template_class( $meta, $atts, $default );
				}

				$atts = shortcode_atts( $default, $atts, $this->config['shortcode'] );

				extract( $atts );

				/* Variable declaration */
				$item_count = count( ShortcodeHelper::shortcode2array( $content, 1 ) );
				$wrapper_style_arr = array();
				$wrapper_style = "";
				$extra_classes_wrapper = "";
				$extra_classes = "";
				$extra_column_class = "";
				$data_flickity = "";
				$wrapper_data = "";
				$item_styling = EnfoldPlusHelpers::item_atts();

				/* Item Styling */
				/**
				 * TODO: style params like size and space should be moved to wrapper style by default and only overwritten in item if set individually, this is done on new styling params like title space, content coloring and size
				 */
				if( $media_size ) $item_styling['media_size'] = $media_size;
				if( $media_position ) $item_styling['media_position'] = $media_position;
				if( $media_space ) $item_styling['media_space'] = $media_space;
				if( $heading_type ) $item_styling['heading_type'] = $heading_type;
				if( $content_alignment ) $item_styling['content_alignment'] = $content_alignment;
				if( $vertical_alignment ) $item_styling['vertical_alignment'] = $vertical_alignment;
				if( $item_fill ) $item_styling['item_fill'] = $item_fill;
				if( $button_link ) $item_styling['button_link'] = $button_link;
				if( $button_color ) $item_styling['button_color'] = $button_color;
				if( $link_label ) $item_styling['link_label'] = $link_label;
				if( $color ) $item_styling['color'] = $color;
				if( $custom_color ) $item_styling['custom_color'] = $custom_color;
				if( $icon_color ) $item_styling['icon_color'] = $icon_color;
				if( $icon_custom_color ) $item_styling['icon_custom_color'] = $icon_custom_color;
				if( $size ) $item_styling['size'] = $size;
				if( $custom_size ) $item_styling['custom_size'] = $custom_size;
				if( $animation ) $item_styling['animation'] = $animation;
				if( $item_template_option ) $item_styling['item_template_option'] = $item_template_option;
				if( $item_template_file ) $item_styling['item_template_file'] = $item_template_file;

				/* Item Count */
				$wrapper_style_arr[] = "--itemCount: {$item_count};";


				/* Slider activation */
				if( $type == "slider" && $item_count > 1 ) {
					$wrapper_data = apply_filters( "avf_ep_item_slider_wrapper_data", $wrapper_data, $meta );
					$extra_classes_wrapper .= " ep-flickity-slider-wrapper";
					$extra_classes .= " ep-flickity-slider";
					$extra_column_class .= " ep-flickity-slide";
					$data_flickity .= EnfoldPlusHelpers::get_flickity_data( $atts );
				} 

				/* Pagination activation */
				if( $type !== "slider" && $paginate == "yes" ) {
					$paginate_num = !empty( $paginate_num ) ? $paginate_num : 4;
					$extra_classes_wrapper .= " ep-item-grid-paged";
					$wrapper_data .= "data-pages='{$paginate_num}'";
					$load_more_label = !empty( $load_more_label ) ? $load_more_label : __( 'Load More', 'avia_framework' );
					$load_more_classes = apply_filters( "avf_ep_item_grid_load_more_classes", "avia-button avia-color-primary avia-size-medium" );
				}

				/**
				 * TODO: create a helper function that groups all of these item param processing to share this between item grid/post grid and post slider
				 */
				/* Title spacing */
				if( ! empty( $title_space ) ) {
					$wrapper_style_arr[] = "--epItemTitleSpace: {$title_space};";
				}

				/* Content coloring */
				if( ! empty( $content_color ) && !empty( $content_custom_color ) ) {
					$wrapper_style_arr[] = "--epColorDesktop: {$content_custom_color};";
				}

				/* Content sizing */
				if( ! empty( $content_size ) ) {
					$wrapper_style_arr[] = "--epItemContentSize: {$content_custom_size};";
				}

				/* Item Grid Style concatenation */
				if( ! empty( $wrapper_style_arr ) ) {
					$wrapper_style = "style='" . implode( "", $wrapper_style_arr ). "'";
				}

				/* Passing to object properties */
				$this->flickity_lazy_load = ! empty( $atts['lazy_load'] ) ? true : false;
				$this->item_styling = $item_styling;
				$this->column_class = $extra_column_class;

				if( $layout !== 'no-grid' ) {
					/* Extra classes for element */
					$extra_classes .= " columns is-multiline is-mobile";
					$extra_classes .= $gap !== "is-gapless" ? " is-variable " . $gap : " " . $gap;
					$extra_classes .= $type !== "slider" && !empty( $grid_alignment ) ? " ep-grid-align-" . $grid_alignment : "";
					$extra_classes .= !empty( $grid_alignment_v ) ? " ep-grid-valign-" . $grid_alignment_v : "";

					$this->column_class .= " column " . EnfoldPlusHelpers::get_column_class( $columns, $columns_tablet, $columns_mobile );
					$this->column_class_inner = "column-inner"; // not sure if this is used.
				} else {
					if( $type == "slider" ){
						$extra_classes .= " ep-flickity-slider-single";
					}
				}

				/* Filter added here in case you neeed to hook into the markup of this item grid wrapper node, eg. to load a file via Enfold Fast lazy loading API */
				$wrapper_data = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data", $wrapper_data, $meta );

				ob_start();

				?>

				<div <?php echo $meta['custom_el_id']; ?> class='ep-item-grid-wrapper ep-grid-wrapper <?php echo $extra_classes_wrapper; ?> <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>' <?php echo $wrapper_style; ?> <?php echo $wrapper_data; ?>>
					<div class="ep-item-grid ep-grid <?php echo $extra_classes; ?>" <?php echo $data_flickity; ?>>
						<?php echo ShortcodeHelper::avia_remove_autop( $content, true ); ?>
					</div>
					<?php if( $type !== "slider" && $paginate == "yes" ) { ?>
					<div class='ep-item-grid-load-more-wrapper'>
						<button class="ep-item-grid-load-more <?php echo $load_more_classes; ?>"><?php echo $load_more_label; ?></button>
					</div>
					<?php } ?>
				</div>

				<?php
				$output = ob_get_clean();

				return $output;
			}
			

			function ep_item_grid_inner( $atts, $content = "", $shortcodename = "" )
			{
				/**
				 * Fixes a problem when 3-rd party plugins call nested shortcodes without executing main shortcode  (like YOAST in wpseo-filter-shortcodes)
				 */
				if( empty( $this->screen_options ) )
				{
					return '';
				}
				
				$el_atts = apply_filters( 'avf_ep_item_grid_item_default_options', array(
					"id" => "",
					"id_tablet" => "",
					"id_mobile" => "",
					"link" => "",
					"link_target" => "",
					"type" => "",
					"icon"	=> "",
					"font" => "",
					"title" => "",
					"subtitle" => "",
					"custom_class" => "",
					"custom_id" => "",
					"override_styling" => ""
				) );
				
				$item_atts = EnfoldPlusHelpers::item_atts();

				$default = array_merge( $el_atts, $item_atts );

				if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
					$default = $this->sync_sc_defaults_array( $default, 'modal_item', 'no_content' );
					$locked = array();
					Avia_Element_Templates()->set_locked_attributes( $atts, $this, $this->config['shortcode_nested'][0], $default, $locked, $content );
				}
				
				$atts = shortcode_atts( $default, $atts, $this->config['shortcode_nested'][0] );
				
				extract( $atts );

				$item_id = !empty( $custom_id ) ? "id='" . $custom_id . "'" : "";
				$item_index = $this->item_index;
				$item_classes = "ep-item-" . $item_index;
				$link_before = "";
				$link_after = "";
				$inner_link_before = "";
				$inner_link_after = "";
				$item_media = "";
				$item_style_tag_arr = array();
				$item_style_tag = "";
				$icon_style = "";
				$heading_style = "";
				$blank = "";
				$src = $id; // standardized variable name

				/* Animation, non overridable at the moment */
				$animation = $this->item_styling['animation'];

				$heading_type =  $override_styling == 'yes' && ! empty( $heading_type ) ? $heading_type : $this->item_styling['heading_type'];

 				// use grid setting only if item setting is empty, extend this to other opts
				$media_size = ! empty( $media_size ) ? $media_size : $this->item_styling['media_size'];
				$media_position = ! empty( $media_position ) ? $media_position : $this->item_styling['media_position'];
				$media_space = ! empty( $media_space ) ? $media_space : $this->item_styling['media_space'];
				$content_alignment = ! empty( $content_alignment ) ? $content_alignment : $this->item_styling['content_alignment'];
				$vertical_alignment = ! empty( $vertical_alignment ) ? $vertical_alignment : $this->item_styling['vertical_alignment'];
				$item_fill = ! empty( $item_fill ) ? ( $item_fill !== 'no' ? true : false ) : $this->item_styling['item_fill'];
				$button_link = ! empty( $button_link ) ? ( $button_link !== 'no' ? true : false ) : $this->item_styling['button_link'];
				$button_color = ! empty( $button_color ) ? $button_color : $this->item_styling['button_color'];
				$color = ! empty( $color ) ? $color : $this->item_styling['color'];
				$custom_color = ! empty( $custom_color ) ? $custom_color : $this->item_styling['custom_color'];
				$icon_color = ! empty( $icon_color ) ? $icon_color : $this->item_styling['icon_color'];
				$icon_custom_color = ! empty( $icon_custom_color ) ? $icon_custom_color : $this->item_styling['icon_custom_color'];
				$size = ! empty( $size ) ? $size : $this->item_styling['size'];
				$custom_size = ! empty( $custom_size ) ? $custom_size : $this->item_styling['custom_size'];
				$item_template_option = ! empty( $item_template_option ) ? $item_template_option : $this->item_styling['item_template_option'];
				$item_template_file = ! empty( $item_template_file ) ? $item_template_file : $this->item_styling['item_template_file'];
				$link_label = ! empty( $link_label ) ? $link_label : ( ! empty( $this->item_styling['link_label'] ) ? $this->item_styling['link_label'] : "Read more" );

				if( !empty( $animation ) ) {
					$item_classes .= " av-animated-generic " . $animation;
				}

				if( !empty( $media_size ) || !empty( $media_space ) ) {
					if( !empty( $media_size ) ) $item_classes .= " ep-item-custom-size";
					$media_size = !empty( $media_size ) ? "--epCustomItemSize: {$media_size};" : "";
					$media_space = !empty( $media_space ) ? "--epCustomItemSpace: {$media_space};" : "";
					$item_style_tag_arr[] = $media_size;
					$item_style_tag_arr[] = $media_space;
				}

				if( !empty( $color ) || !empty( $size ) ) {
					$custom_color = !empty( $color ) && !empty( $custom_color ) ? "color:{$custom_color};" : "";
					$custom_size = !empty( $size ) && !empty( $custom_size ) ? "font-size:{$custom_size};" : "";
					$heading_style .= "style='{$custom_color}{$custom_size}'";
				}
				
				if( ! empty( $title_space ) ) {
					$item_style_tag_arr[] = "--epItemTitleSpace: {$title_space};";
				}

				if( !empty( $content_color ) && !empty( $content_custom_color ) ) {
					$item_style_tag_arr[] = "--epColorDesktop: {$content_custom_color};";
				}

				if( ! empty( $content_size ) ) {
					$item_style_tag_arr[] = "--epItemContentSize: {$content_custom_size};";
				}

				if( !empty( $icon_color ) ) {
					$icon_custom_color = !empty( $icon_color ) && !empty( $icon_custom_color ) ? "color:{$icon_custom_color};" : "";
					$icon_style .= "style='{$icon_custom_color}'";
				}

				/* Item Style concatenation */
				if( ! empty( $item_style_tag_arr ) ) {
					$item_style_tag = "style='" . implode( "", $item_style_tag_arr ). "'";
				}

				if( $content_alignment ) $item_classes .= " ep-item-align-{$content_alignment}";
				if( $vertical_alignment ) $item_classes .= " ep-item-valign-{$vertical_alignment}";
				if( $item_fill ) $item_classes .= " ep-item-fill";
				if( $media_position ) $item_classes .= " ep-item-media-position-{$media_position}";

				$item_classes = apply_filters( "avf_ep_item_grid_item_classes", $item_classes, $atts, $this->el_meta );
				
				if( ! empty( $link ) ) {

					$blank .= ( strpos( $link_target, '_blank' ) !== false || $link_target == 'yes' ) ? ' target="_blank" ' : '';
					$blank .= strpos( $link_target, 'nofollow' ) !== false ? ' rel="nofollow" ' : '';

					if( empty( $button_link ) ) {
						$link_before .= '<a class="noHover ep-link-wrapper" href="' . AviaHelper::get_url( $link ) . '" ' . $blank . '>';
						$link_after .= '</a>';
					} else {
						$inner_link_before .= '<a class="noHover" href="' . AviaHelper::get_url( $link ) . '" ' . $blank . '>';
						$inner_link_after .= '</a>';
					}
				}

				$item_icon =  "<div class='ep-item-grid-icon' " . av_icon( $icon, $font ) . " " . $icon_style . "></div>";
				$item_image = !empty( $src ) ? "<div class='ep-item-grid-image'>" . $inner_link_before . EnfoldPlusHelpers::get_responsive_image( $atts, array( "desktop" => "id", "tablet" => "id_tablet", "mobile" => "id_mobile" ), ( $this->item_index == 1 ? false : $this->flickity_lazy_load ) ) . $inner_link_after .  "</div>" : "";

				switch( $type ){
					case 'both':
						$item_media .= $item_image;
						$item_media .= $item_icon;
						break;

					case 'icon':
						$item_media .= $item_icon;
						break;
	
					default:
						$item_media .= $item_image;
				}				
				
				$output = "";
				
				ob_start();

				$item_template = $item_template_option == 'file' ? ABSPATH . $item_template_file : '';

				$item_template = apply_filters( "avf_ep_item_grid_item_template", $item_template, $atts, $this->el_meta );

				$item_template = file_exists( $item_template ) ? $item_template : ENFOLD_PLUS_INC . 'avia-shortcodes/item_grid/item.php';
				
				include( $item_template );
				
				$this->item_index++;
				
				$output = ob_get_clean();

				return $output;
			}

	}
}