<?php
/**
 * Post Slider
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( !class_exists( 'ep_sc_posts_slider' ) )
{
	class ep_sc_posts_slider extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['version']		= '1.0';
				$this->config['self_closing']	= 'yes';
				$this->config['name']		= __('Posts Slider', 'avia_framework' );
				$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-postslider.png";
				$this->config['order']		= 94;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'ep_posts_slider';
				$this->config['tooltip'] 	= __('Creates a slider of Posts or any Custom Post Type', 'avia_framework' );
				$this->config['disabling_allowed'] = true;
				$this->config['preview'] = false;
				$this->config['id_name']	= 'id';
				$this->config['id_show']	= 'yes';
			}


			function extra_assets(){
				EnfoldPlusHelpers::flickity_assets();
				wp_enqueue_style( 'avia-module-ep-grids' , ENFOLD_PLUS_ASSETS . 'css/ep_grids.css', array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
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
								"name" 	=> __("Select Post Type", 'avia_framework' ),
								"desc" 	=> __("Select which post types should be used. Note that your taxonomy will be ignored if you do not select an assign post type.
											  If yo don't select post type all registered post types will be used", 'avia_framework' ),
								"id" 	=> "post_type",
								"type" 	=> "select",
								"multiple"	=> 6,
								"std" 	=> "",
								"subtype" => AviaHtmlHelper::get_registered_post_type_array()
						   ),
							

					array(
								"name" 	=> __("Select Taxonomy", 'avia_framework' ),
								"desc" 	=> __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework' ),
								"id" 	=> "link",
								"fetchTMPL"	=> true,
								"type" 	=> "linkpicker",
								"subtype"  => array( __('Display Entries from:',  'avia_framework' )=>'taxonomy'),
								"multiple"	=> 6,
								"std" 	=> "category"),
					
					array(	
								"name" 	=> __("Enable another Taxonomy?", 'avia_framework'),
								"desc" 	=> __("Check to enable another dimension for filtering the content shown on the grid.",'avia_framework' ),
								"id" 	=> "enable_link2",
								"std" 	=> "",
								"type" 	=> "checkbox"),
												
								
					array(
								"name" 	=> __("Select Taxonomy 2", 'avia_framework' ),
								"desc" 	=> __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework' ),
								"id" 	=> "link2",
								"fetchTMPL"	=> true,
								"type" 	=> "linkpicker",
								"subtype"  => array( __('Display Entries from:',  'avia_framework' )=>'taxonomy'),
								"multiple"	=> 6,
								"required" => array('enable_link2','not_empty_and','no'),
								"std" 	=> ""),

					array(	
								"name" 	=> __("Enable another Taxonomy?", 'avia_framework'),
								"desc" 	=> __("Check to enable another dimension for filtering the content shown on the grid.",'avia_framework' ),
								"id" 	=> "enable_link3",
								"std" 	=> "",
								"required" => array('enable_link2','not_empty_and','no'),
								"type" 	=> "checkbox"),
													

					array(
								"name" 	=> __("Select Taxonomy 3", 'avia_framework' ),
								"desc" 	=> __("Select which entries should be displayed by selecting a taxonomy", 'avia_framework' ),
								"id" 	=> "link3",
								"fetchTMPL"	=> true,
								"type" 	=> "linkpicker",
								"required" => array('enable_link3','not_empty_and','no'),
								"subtype"  => array( __('Display Entries from:',  'avia_framework' )=>'taxonomy'),
								"multiple"	=> 6,
								"std" 	=> ""),
		
					array(
						"name" 	=> __("Is this FacetWP Template?", 'avia_framework' ),
						"desc" 	=> __("Should this grid behave as a FacetWP Template?", 'avia_framework' ),
						"id" 	=> "facetwp",
						"type" 	=> "checkbox",
						"std" 	=> ""
					),

					array(
							"name" 	=> __("Post Number", 'avia_framework' ),
							"desc" 	=> __("How many items should be displayed per page?", 'avia_framework' ),
							"id" 	=> "items",
							"type" 	=> "select",
							"std" 	=> "12",
							"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),
					

					array(
							"name" => __("Order by",'avia_framework' ),
							"desc" 	=> __("You can order the result by various attributes like creation date, title, author etc", 'avia_framework' ),
							"id"   => "query_orderby",
							"type" 	=> "select",
							"std" 	=> "date",
							"subtype" => array(
								__('Date',  'avia_framework' ) =>'date',
								__('Title',  'avia_framework' ) =>'title',
								__('Author',  'avia_framework' ) =>'author',
								__('Name (Post Slug)',  'avia_framework' ) =>'name',
								__('Last modified',  'avia_framework' ) =>'modified',
								__('Comment Count',  'avia_framework' ) =>'comment_count',
								__('Page Order',  'avia_framework' ) =>'menu_order',
								__('Random',  'avia_framework' ) =>'rand'
							)
						),
						
						array(
			  			  "name" => __("Display order",'avia_framework' ),
						  "desc" 	=> __("Display the results either in ascending or descending order", 'avia_framework' ),
			  			  "id"   => "query_order",
			  			  "type" 	=> "select",
			  			  "std" 	=> "DESC",
			  			  "subtype" => array(
			  				  __('Ascending Order',  'avia_framework' ) =>'ASC',
			  				  __('Descending Order',  'avia_framework' ) =>'DESC')
						),
						
						array(
							'name' => __( 'Include Posts', 'avia_framework' ),
							'desc' => __( 'If you want to include specific Posts in this Post Grid, enter the Post IDs separated by comma, eg. <em>43, 389, 32</em>', 'avia_framework' ),
							'id'   => 'query_post__in',
							'type' 	=> 'input',
							'std' 	=> '',
						),
						  
						array(
							'name' => __( 'Exclude Posts', 'avia_framework' ),
							'desc' => __( 'If you want to exclude specific Posts from this Post Grid, enter the Post IDs separated by comma, eg. <em>43, 389, 32</em>', 'avia_framework' ),
							'id'   => 'query_post__not_in',
							'type' 	=> 'input',
							'std' 	=> '',
						),

						array(
							'name' => __( 'Post Parent', 'avia_framework' ),
							'desc' => __( 'Set a Post Parent ID, this will make the grid include only child posts of this parent, set to 0 to return only top-level posts.', 'avia_framework' ),
							'id'   => 'query_post_parent',
							'type' 	=> 'input',
							'lockable' => true,
							'std' 	=> '',
						),

						array(
							'type' 	=> 'tab_close',
							'nodescription' => true
						),

						array(
							'type' 	=> 'tab',
							'name'  => __( 'Grid Styling', 'avia_framework' ),
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
							'type' 	=> 'tab',
							'name'  => __( 'Item Styling', 'avia_framework' ),
							'nodescription' => true
						),

						array(	
							'type'			=> 'template',
							'template_id'	=> 'ep_post_item_styling'
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
							'nodescription' => true
						),
						
						
						array(
							'type' 	=> 'tab_container_close',
							'nodescription' => true
						)
					

				);

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

				extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

				if( isset( $atts['link'] ) ) {
				    $atts['link'] = explode( ',', $atts['link'], 2 );
				    $atts['taxonomy'] = $atts['link'][0];
				
				    if( isset( $atts['link'][1] ) ) {
				        $atts['categories'] = $atts['link'][1];
				    }
				}
					
				if( isset( $atts['link2'] ) && ! empty( $atts['enable_link2'] ) ) {
				    $atts['link2'] = explode( ',', $atts['link2'], 2 );
				    $atts['taxonomy2'] = $atts['link2'][0];
				
				    if( isset( $atts['link2'][1] ) ) {
				        $atts['categories2'] = $atts['link2'][1];
					}
						
					if( isset( $atts['link3'] ) && ! empty( $atts['enable_link3'] ) ) {
						$atts['link3'] = explode( ',', $atts['link3'], 2 );
						$atts['taxonomy3'] = $atts['link3'][0];
					
						if( isset( $atts['link3'][1] ) ) {
							$atts['categories3'] = $atts['link3'][1];
						}
					}
				}
					
				if( empty( $atts['post_type'] ) ) {
					$atts['post_type'] = get_post_types();
				}

				if( is_string( $atts['post_type'] ) ) $atts['post_type'] = explode( ',', $atts['post_type'] );
				
				do_action( 'ava_ep_post_slider_before', $meta );

				$post_slider = new ep_post_slider( $atts, $meta );
				$post_slider->query_entries();
				return $post_slider->html();

			}
		}
}




if ( !class_exists( 'ep_post_slider' ) )
{
	class ep_post_slider
	{
		protected $atts;
		protected $meta;
		protected $entries;

		function __construct( $atts = array(), $meta = array() )
		{
			$this->screen_options = AviaHelper::av_mobile_sizes( $atts );
			
			$el_atts = array( 
				'ep_style' => '', 
				'facetwp' => ''
			);
			$grid_atts = EnfoldPlusHelpers::grid_atts();
			$post_item_atts = EnfoldPlusHelpers::post_item_atts();
			$query_atts =  EnfoldPlusHelpers::query_atts();
			$column_atts = EnfoldPlusHelpers::columns_atts();
			$slider_atts = EnfoldPlusHelpers::slider_atts();

			$this->atts = shortcode_atts( array_merge( $el_atts, $grid_atts, $post_item_atts, $query_atts, $column_atts, $slider_atts ), $atts, "ep_posts_slider" );				
			$this->meta = $meta;
		}

		//generates the html of the post grid
		public function html()
		{
			if( empty( $this->entries ) || empty( $this->entries->posts ) ) return;

			extract( $this->atts );
			extract( $this->screen_options ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 

			$item_count = count( $this->entries->posts );
			$extra_classes_wrapper = "";
			$extra_classes = "";
			$data_flickity = "";

			if( !empty( $facetwp ) ) {
				$extra_classes_wrapper .= " facetwp-enabled";
				$extra_classes .= " facetwp-template";
			}

			$wrapper_style_arr = array();
			$wrapper_style = "";
			$item_classes = "";
			$item_style_tag = "";
			$heading_style = "";
			$column_class = "";
			$column_class_inner = "";

			if( !empty( $animation ) ) {
				$column_class .= " av-animated-generic " . $animation;
			}

			if( !empty( $media_size ) || !empty( $media_space ) ) {
				$item_classes .= " ep-item-custom-size";
				$media_size = !empty( $media_size ) ? "--epCustomItemSize: {$media_size};" : "";
				$media_space = !empty( $media_space ) ? "--epCustomItemSpace: {$media_space};" : "";
				$item_style_tag = "style='{$media_size}{$media_space}'";
			}

			if( !empty( $color ) || !empty( $size ) ) {
				$custom_color = !empty( $color ) && !empty( $custom_color ) ? "color:{$custom_color};" : "";
				$custom_size = !empty( $size ) && !empty( $custom_size ) ? "font-size:{$custom_size};" : "";
				$heading_style .= "style='{$custom_color}{$custom_size}'";
			}

			if( $content_alignment ) $item_classes .= " ep-item-align-{$content_alignment}";
			if( $vertical_alignment ) $item_classes .= " ep-item-valign-{$vertical_alignment}";
			if( $item_fill ) $item_classes .= " ep-item-fill";
			if( $media_position ) $item_classes .= " ep-item-media-position-{$media_position}";

			$button_color = ! empty( $button_color ) ? $button_color : "theme-color";
			$link_label = ! empty( $link_label ) ? $link_label : "Read more";

			if( $layout !== 'no-grid' ) {
				$extra_classes .= " columns is-multiline is-mobile";
				$extra_classes .= $gap !== "is-gapless" ? " is-variable " . $gap : " " . $gap;
				$extra_classes .= !empty( $grid_alignment ) ? " ep-grid-align-" . $grid_alignment : "";
				$extra_classes .= !empty( $grid_alignment_v ) ? " ep-grid-valign-" . $grid_alignment_v : "";

				$column_class .= " ep-post-grid-item column " . EnfoldPlusHelpers::get_column_class( $columns, $columns_tablet, $columns_mobile );
				$column_class_inner .= " column-inner";
			}

			$wrapper_style_arr[] = "--itemCount: {$item_count};";

			/* Title spacing */
			if( ! empty( $title_space ) ) {
				$wrapper_style_arr[] = "--epItemTitleSpace: {$title_space};";
			}

			/* Content coloring */
			if( !empty( $content_color ) && !empty( $content_custom_color ) ) {
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

			/* Bunch of data that get_post_vars may need */
			$grid_atts = array(
				"shortcode" => "ep_posts_slider",
				"meta" => $this->meta,
				"disable_term_links" => $disable_term_links, 
				"disable_button" => $disable_button, 
				"button_link" => $button_link, 
				"disable_link" => $disable_link, 
				"post_taxonomy" => $post_taxonomy, 
				"post_terms_number" => $post_terms_number,
				"excerpt_length" => $excerpt_length,
				"date_format" => $date_format,
				"sc_base_classes" => "ep-item-grid-item ep-posts-grid-item ep-posts-slider-item {$column_class} {$item_classes}",
				"post_item_custom_class" => $post_item_custom_class
			);

			if( $item_count > 1 ) {
				$extra_classes_wrapper .= " ep-flickity-slider-wrapper";
				$extra_classes .= " ep-flickity-slider";
				$item_classes .= " ep-flickity-slide";
				$data_flickity .= EnfoldPlusHelpers::get_flickity_data( $this->atts );
			}

			$wrapper_data = apply_filters( "avf_ep_posts_slider_wrapper_data", "", $this->meta );

			ob_start();

			?>
			<div <?php echo $this->meta['custom_el_id']; ?> class='ep-posts-slider-wrapper ep-grid-wrapper <?php echo $extra_classes_wrapper; ?> <?php echo $av_display_classes; ?> <?php echo $this->meta['el_class']; ?>' <?php echo $wrapper_style; ?> <?php echo $wrapper_data; ?>>
				<div class='ep-posts-slider ep-grid <?php echo $extra_classes; ?>' <?php echo $data_flickity; ?>>
					<?php
					foreach ( $this->entries->posts as $post ) {	

						$post_id = $post->ID;

						extract( EnfoldPlusHelpers::get_post_vars( $post_id, $grid_atts ) );
						
						$item_classes = $post_classes; // updated naming for variable name standarization in post.php, item_classes, item_style_tag, etc

						do_action( 'ava_ep_post_slider_post_before', $post_type_slug, $post_id, $this->meta );

						$post_template = !empty( $item_template_file ) ? get_stylesheet_directory() . $item_template_file : '';
						$post_template = apply_filters( "avf_ep_post_slider_post_template", $post_template, $post_type_slug, $post_id, $this->meta );
						$post_template = file_exists( $post_template ) ? $post_template : ENFOLD_PLUS_INC . 'avia-shortcodes/posts_grid/post.php';

						include( $post_template );
					}
					?>
				</div>
			</div>
			<?php
			$output = ob_get_clean();

			return $output;

		}

		//fetch new entries
		public function query_entries( $params = array() ) {

			$query = array();
			if( empty( $params ) ) $params = $this->atts;

			$posts_query = EnfoldPlusHelpers::query_posts( $params, $this->meta, "ep_post_slider" );
			if( empty( $posts_query ) || empty( $posts_query->posts ) ) return;

			$this->entries = $posts_query;

		}

	}
}