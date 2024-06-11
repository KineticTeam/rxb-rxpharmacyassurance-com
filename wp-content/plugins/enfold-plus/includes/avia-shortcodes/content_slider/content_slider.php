<?php
/**
 * Content Slider
 * 
 *  */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( ! class_exists( 'ep_sc_content_slider' ) )
{
	class ep_sc_content_slider extends aviaShortcodeTemplate
	{

		public $el_meta;
		public $column_class;
		public $item_index;
		public $flickity_lazy_load;

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';
			$this->config['base_element']	= 'yes';

			$this->config['name']		= __('Content Slider', 'avia_framework' );
			$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-contentslider.png';
			$this->config['order']		= 94;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'ep_content_slider';
			$this->config['shortcode_nested'] = array( 'ep_content_slider_inner' );
			$this->config['tooltip'] 	= __( 'Creates a Content Slider', 'avia_framework' );
			$this->config['preview'] 	= false;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
		}

		function extra_assets() {
			EnfoldPlusHelpers::flickity_assets();
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
							'template_id'	=> $this->popup_key( 'content_slider_inner' )
						),

						array(
							'name' => __( 'Layout', 'avia_framework' ),
							'desc' => __( 'Set the slider layout', 'avia_framework' ),
							'id'   => 'layout',
							'type' 	=> 'select',
							'lockable' => true,
							'std' 	=> '',
							'subtype'	=> array(	
											__( 'Multiple items per slide (Columns)', 'avia_framework' )	=> '',
											__( 'Single item per slide', 'avia_framework' )	=> 'single',
										)
						),

						array(	
							'type'			=> 'template',
							'template_id'	=> 'columns_count_icon_switcher',
							'heading'		=> array(),
							"required" => array( "layout", "not", "single" ),
							'id_sizes'		=>	array(
								'default'	=> 'columns',
								'medium'	=> 'columns_tablet',
								'small' 	=> 'columns_mobile',
							),
		
							'subtype' => array(
								'default' => array(
									__( '1 Columns', 'avia_framework' )	=> '1',
									__( '2 Columns', 'avia_framework' )	=> '2',
									__( '3 Columns', 'avia_framework' )	=> '3',
									__( '4 Columns', 'avia_framework' )	=> '4',
									__( '5 Columns', 'avia_framework' )	=> '5',
									__( '6 Columns', 'avia_framework' )	=> '6',
								),
								'medium'=> array(
									__( 'Default', 'avia_framework' )	=> '',
									__( '1 Columns', 'avia_framework' )	=> '1',
									__( '2 Columns', 'avia_framework' )	=> '2',
									__( '3 Columns', 'avia_framework' )	=> '3',
									__( '4 Columns', 'avia_framework' )	=> '4',
									__( '5 Columns', 'avia_framework' )	=> '5',
									__( '6 Columns', 'avia_framework' )	=> '6',
								),
								'small'=> array(
									__( 'Default', 'avia_framework' )	=> '',
									__( '1 Columns', 'avia_framework' )	=> '1',
									__( '2 Columns', 'avia_framework' )	=> '2',
									__( '3 Columns', 'avia_framework' )	=> '3',
									__( '4 Columns', 'avia_framework' )	=> '4',
									__( '5 Columns', 'avia_framework' )	=> '5',
									__( '6 Columns', 'avia_framework' )	=> '6',
								),
							),
							'lockable' => true,
							'std' => array(
								'default'	=> '4',
								'medium'	=> '1',
								'small'	    => '1',
							)
						),


					array(
						"name" 	=> __( "Gap", 'avia_framework' ),
						"desc" 	=> __( "Should this grid have gaps. If so which value?", 'avia_framework' ),
						"id" 	=> "gap",
						"type" 	=> "select",
						'lockable' => true,
						"std" 	=> "is-3",
						"required" => array( "layout", "not", "single" ),
						"subtype" => array(
							__( 'No gap',  'avia_framework' ) => 'is-gapless',
							__( 'Small gap',  'avia_framework' ) =>'is-1',
							__( 'Default gap',  'avia_framework' ) =>'is-3',
							__( 'Large gap',  'avia_framework' ) =>'is-6',
							__( 'Huge gap',  'avia_framework' ) =>'is-8'
						)
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
							'type' 	=> 'toggle_container',
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
			
			$this->register_modal_group_templates();
			
			/**
			 * Content Tab
			 * ===========
			 */
			
			$c = array(
						array(
							'name'			=> __( 'Add/Edit Slides', 'avia_framework' ),
							'desc'			=> __( 'Here you can add, remove and edit your Slides.', 'avia_framework' ),
							'type'			=> 'modal_group',
							'id'			=> 'content',
							'modal_title'	=> __( 'Edit Slides', 'avia_framework' ),
							'editable_item'	=> true,
							'lockable'		=> true,
							'std'			=> array(
													array( 
														'title'		=> __( 'Title', 'avia_framework' ),
													),
												),
							'subelements'	=> $this->create_modal()
						)
				
				);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'content_slider_inner' ), $c );
			
		}
		
		/**
		 * Creates the modal popup for a single entry
		 * 
		 * @since 4.6.4
		 * @return array
		 */
		protected function create_modal()
		{
			$elements = array(
				
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
							'template_id'	=> $this->popup_key( 'modal_content_slider_inner' )
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
						'template_id'	=> $this->popup_key( 'modal_content_slider_inner_link' )
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
			
			return $elements;
		}
		
		/**
		 * Register all templates for the modal group popup
		 * 
		 * @since 4.6.4
		 */
		protected function register_modal_group_templates()
		{
			/**
			 * Content Tab
			 * ===========
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
							'name' 	=> __( 'Image', 'avia_framework' ),
							'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
							'id' 	=> 'src',
							'type' 	=> 'image',
							'fetch' => 'id',
							'title'		=> __( 'Insert Image', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'std' 	=> '',
							'lockable'	=> true
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
							'name' 	=> __( 'Choose another Image (Tablet)', 'avia_framework' ),
							'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
							'id' 	=> 'src_tablet',
							'fetch' => 'id',
							'type' 	=> 'image',
							'title'		=> __( 'Insert Image', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'lockable' => true,
							'std' 	=> ''
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
							'name' 	=> __( 'Choose another Image (Mobile)', 'avia_framework' ),
							'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
							'id' 	=> 'src_mobile',
							'fetch' => 'id',
							'type' 	=> 'image',
							'title'		=> __( 'Insert Image', 'avia_framework' ),
							'button'	=> __( 'Insert', 'avia_framework' ),
							'lockable' => true,
							'std' 	=> ''
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
							'name' 	=> __( 'Title', 'avia_framework' ),
							'desc' 	=> __( 'Enter a title', 'avia_framework' ),
							'id' 	=> 'title',
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'input'
						),

						array(
							'name' 	=> __( 'Subtitle', 'avia_framework' ),
							'desc' 	=> __( 'Can be used for a job description', 'avia_framework' ),
							'id' 	=> 'subtitle',
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'input'
						),

						array(
							'name' 	=> __( 'Content', 'avia_framework' ),
							'desc' 	=> __( 'Enter the content here', 'avia_framework' ),
							'id' 	=> 'content',
							'std' 	=> '',
							'lockable'	=> true,
							'type' 	=> 'tiny_mce'
						),
				
				);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'modal_content_slider_inner' ), $c );


			$c = array(

				array(	
					'type'			=> 'template',
					'template_id'	=> 'linkpicker_toggle',
					'name'			=> __( 'Link?', 'avia_framework' ),
					'desc'			=> __( 'Where should it link to?', 'avia_framework' ),
					'lockable'		=> true,
					'subtypes'		=> array( 'no', 'manually', 'single', 'taxonomy' ),
					'target_id'		=> 'link_target'
				),

				array(
					'name' => __( 'Link label', 'avia_framework' ),
					'desc' => __( 'Link label (usable by specific templates)', 'avia_framework' ),
					'id'   => 'link_label',
					'type' 	=> 'input',
					'required' => array( 'link', 'not', '' ),
					'lockable' => true,
					'std' 	=> '',
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
				
			);

			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'modal_content_slider_inner_link' ), $c );
		}

		/**
		 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
		 * Works in the same way as Editor Element
		 * 
		 * @param array $params this array holds the default values for $content and $args.
		 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
		 */
		function editor_sub_element( $params )
		{	
			$img_template	= $this->update_template( 'img_fakeArg', '{{img_fakeArg}}' );
			$template		= $this->update_template( 'title', '{{title}}' );
			$content		= $this->update_template( 'content', '{{content}}' );
			$thumbnail = isset( $params['args']['src'] ) ? wp_get_attachment_image( $params['args']['src'] ) : '';


			$params['innerHtml']  = '';
			$params['innerHtml'] .=		"<div class='avia_title_container'>";
			$params['innerHtml'] .=			'<div>';
			$params['innerHtml'] .=				"<span class='avia_slideshow_image' {$img_template} >{$thumbnail}</span>";
			$params['innerHtml'] .=				"<div class='avia_slideshow_content'>";
			$params['innerHtml'] .=					"<h4 class='avia_title_container_inner' {$template}>{$params['args']['title']}</h4>";
			$params['innerHtml'] .=					"<p class='avia_content_container' {$content}>" . stripslashes($params['content']) . '</p>';
			$params['innerHtml'] .=				'</div>';
			$params['innerHtml'] .=			'</div>';
			$params['innerHtml'] .=		'</div>';

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
			$this->el_meta = $meta;
			$this->screen_options = AviaHelper::av_mobile_sizes( $atts );
			$this->item_index = 1;

			extract( $this->screen_options ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			$el_atts = array( 
				'ep_style' => '', 
				"layout" => "" 
			);
			$column_atts = EnfoldPlusHelpers::columns_atts( $atts );
			$slider_atts = EnfoldPlusHelpers::slider_atts( $atts );

			$default = array_merge( $el_atts, $column_atts, $slider_atts );

			if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
				$default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );
				$locked = array();
				Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
				Avia_Element_Templates()->add_template_class( $meta, $atts, $default );
			}

			$atts = shortcode_atts( $default, $atts, $this->config['shortcode'] );

			extract( $atts );

			$item_count = count( ShortcodeHelper::shortcode2array( $content, 1 ) );
			$extra_classes_wrapper = "";
			$extra_classes = "";
			$data_flickity = "";
			$wrapper_data = "";

			$this->column_class = "ep-flickity-slide";
			$this->flickity_lazy_load = ! empty( $atts['lazy_load'] ) ? true : false;

			if( $layout !== "single" ){
				$this->column_class .= " column " . EnfoldPlusHelpers::get_column_class( $columns, $columns_tablet, $columns_mobile );
				$extra_classes .= " columns is-multiline is-mobile";
				$extra_classes .= $gap !== "is-gapless" ? " is-variable " . $gap : " " . $gap;
			} else {
				$extra_classes .= "ep-flickity-slider-single";
			}

			if( $item_count > 1 ) {
				$extra_classes_wrapper .= " ep-flickity-slider-wrapper";
				$extra_classes .= " ep-flickity-slider";
				$data_flickity .= EnfoldPlusHelpers::get_flickity_data( $atts );
			}

			$wrapper_data = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data", $wrapper_data, $meta );

			ob_start();

			?>
			<div <?php echo $meta['custom_el_id']; ?> class='ep-content-slider-wrapper <?php echo $extra_classes_wrapper; ?> <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>' style="--itemCount: <?php echo $item_count; ?>" <?php echo $wrapper_data; ?>>
				<div class='ep-content-slider <?php echo $extra_classes; ?>' <?php echo $data_flickity; ?>>
					<?php echo ShortcodeHelper::avia_remove_autop( $content, true ); ?>
				</div>
			</div>
			<?php
			$output = ob_get_clean();

			return $output;
		}


		/**
		 * Shortcode handler
		 * 
		 * @param array $atts
		 * @param string $content
		 * @param string $shortcodename
		 * @return string
		 */
		public function ep_content_slider_inner( $atts, $content = '', $shortcodename = '' )
		{
			/**
			 * Fixes a problem when 3-rd party plugins call nested shortcodes without executing main shortcode  (like YOAST in wpseo-filter-shortcodes)
			 */
			if( empty( $this->screen_options ) )
			{
				return '';
			}
			
			$default = array(
				'src' => '',  
				'src_tablet' => '',  
				'src_mobile' => '',  
				'title'			=> '',  
				'subtitle'		=> '',  
				'link' 			=> '',
				'link_target' 	=> '',
				'link_label' 	=> '',
				'custom_class'  => '',
				'custom_id'		=> '',
			);

			if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
				$default = $this->sync_sc_defaults_array( $default, 'modal_item', 'no_content' );
				$locked = array();
				Avia_Element_Templates()->set_locked_attributes( $atts, $this, $this->config['shortcode_nested'][0], $default, $locked, $content );
			}

			$atts = shortcode_atts( $default, $atts, $this->config['shortcode_nested'][0] );

			extract( $atts );

			$item_id = !empty( $custom_id ) ? "id='" . $custom_id . "'" : "";
			$item_index = $this->item_index;
			$slide_classes = "ep-item-" . $item_index;

			$output = '';
			$link_before = '';
			$link_after = '';

			if( ! empty( $link ) ) {

				$link_before .= '<a class="noHover ep-link-wrapper" href="' . AviaHelper::get_url( $link ) . '"';

				$blank = ( strpos( $link_target, '_blank' ) !== false || $link_target == 'yes' ) ? ' target="_blank" ' : '';
				$blank .= strpos( $link_target, 'nofollow' ) !== false ? ' rel="nofollow" ' : '';

				$link_before .= $blank;
				$link_before .= '>';

				$link_after = '</a>';
			}

			ob_start();

			$item_template = "";
			
			$item_template = apply_filters( "avf_ep_content_slider_slide_template", $item_template, $atts, $this->el_meta );
				
			$item_template = file_exists( $item_template ) ? $item_template : ENFOLD_PLUS_INC . 'avia-shortcodes/content_slider/slide.php';
			
			include( $item_template );

			$this->item_index++;

			$output .= ob_get_clean();

			return $output;
		}

	}
}
