<?php
/**
 * Lottie Slider
 * 
 *  */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( ! class_exists( 'ep_sc_lottie_slider' ) )
{
	class ep_sc_lottie_slider extends aviaShortcodeTemplate
	{

		public $column_class;
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	= 'no';
			$this->config['name']		= __('Lottie Slider', 'avia_framework' );
			$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
			$this->config['icon']		= AviaBuilder::$path['imagesURL'] . 'sc-contentslider.png';
			$this->config['order']		= 94;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'ep_lottie_slider';
			$this->config['shortcode_nested'] = array( 'ep_lottie_slider_inner' );
			$this->config['tooltip'] 	= __( 'Creates a Lottie Slider', 'avia_framework' );
			$this->config['preview'] 	= false;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
			$this->config['alb_desc_id']	= 'alb_description';
		}

		function extra_assets() {
			EnfoldPlusHelpers::flickity_assets( false );

			wp_enqueue_script( 'avia-module-ep-lottie-web', ENFOLD_PLUS_LOTTIES_ASSETS . 'js/dist/lottie-web.js', array(), ENFOLD_PLUS_LOTTIES_VERSION, true );

			wp_enqueue_style( 'avia-module-ep-lottie', ENFOLD_PLUS_LOTTIES_ASSETS . 'css/lottie.css', array(), ENFOLD_PLUS_LOTTIES_VERSION, 'all' );
			wp_enqueue_script( 'avia-module-ep-lottie-slider', ENFOLD_PLUS_LOTTIES_ASSETS . 'js/lottie-slider.js', array( 'avia-module-ep-lottie-web' ), ENFOLD_PLUS_LOTTIES_VERSION, true );
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
							'std'			=> array(),
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
					"name" 	=> __( "Which Lottie Animation?", 'avia_framework' ),
					'desc' 	=> __( 'Select the Lottie animation that should be displayed', 'avia_framework' ),
					"id" 	=> "link",
					"type" 	=> "select",
					"subtype" => EnfoldPlusHelpers::get_custom_posts( 'lottie_animation' )
				),
			);
			
			AviaPopupTemplates()->register_dynamic_template( $this->popup_key( 'modal_content_slider_inner' ), $c );
			
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
			$template = $this->update_template( 'link', '{{link}}' );

			$params['innerHtml']  = '';
			$params['innerHtml'] .= "<div class='avia_title_container' {$template}>" . get_the_title( $params['args']['link'] ) . "</div>";

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
			$this->screen_options = AviaHelper::av_mobile_sizes( $atts );

			extract( $this->screen_options ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			$el_atts = array(
				'ep_style' => ''
			);
			$slider_atts = EnfoldPlusHelpers::slider_atts( $atts );

			$atts = shortcode_atts( array_merge( $el_atts, $slider_atts ), $atts, $this->config['shortcode'] );
			extract( $atts );

			$wrapper_data = "";
			$wrapper_data_inner = "";

			$slide_count = count( ShortcodeHelper::shortcode2array( $content, 1 ) );

			$data_flickity = EnfoldPlusHelpers::get_flickity_data( $atts );
			
			$output = "";

			$wrapper_data = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data", $wrapper_data, $meta );
			$wrapper_data_inner = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data_inner", $wrapper_data_inner, $meta );

			ob_start();

			?>
			<div <?php echo $meta['custom_el_id']; ?> class='ep-lottie-slider-wrapper ep-flickity-slider-wrapper <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>' style="--itemCount: <?php echo $slide_count; ?>" <?php echo $wrapper_data; ?>>
				<div class='ep-lottie-slider ep-flickity-slider ep-flickity-slider-single' <?php echo $slide_count > 1 ? $data_flickity : ''; ?> <?php echo $wrapper_data_inner; ?>>
					<?php echo ShortcodeHelper::avia_remove_autop( $content, true ); ?>
				</div>
			</div>
			<?php
			$output .= ob_get_clean();

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
		public function ep_lottie_slider_inner( $atts, $content = '', $shortcodename = '' )
		{
			/**
			 * Fixes a problem when 3-rd party plugins call nested shortcodes without executing main shortcode  (like YOAST in wpseo-filter-shortcodes)
			 */
			if( empty( $this->screen_options ) )
			{
				return '';
			}

			/* TODO: add loop options */
			extract( shortcode_atts( array(
				'link' => ''
			), $atts, 'ep_lottie_slider_inner' ) );

			if( empty( $link ) ) return;

			/* Legacy support for old versions of Lotties */
			if( intval( $link ) == 0 ){
				$link = AviaHelper::get_entry( $link )->ID;	
			}

			$output = '';
			
			ob_start();

			?>
			<div class='ep-flickity-slide'>
				<div class="ep-flickity-slide-inner">
					<div class='ep-lottie-slider-animation'>
						<div class="ep-lottie-animation-inner" data-json="<?php echo wp_get_attachment_url( get_post_meta( $link, "json", true ) ); ?>"></div>
					</div>
				</div>
			</div>
			<?php

			$output .= ob_get_clean();

			return $output;
		}

	}
}

