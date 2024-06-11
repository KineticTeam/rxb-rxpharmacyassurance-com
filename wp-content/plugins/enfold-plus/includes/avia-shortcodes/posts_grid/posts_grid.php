<?php
/**
 * Post Grid
 * 
 * Creates a Post Grid
 * Test here - https://enfold.test/post-grid-test/,
 * process of updating EP to 1.0, check duplicate IDs and classes in auto section
 * also check fwd container functionality, copy from portfolio
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( !class_exists( 'ep_sc_posts_grid' ) )
{
	class ep_sc_posts_grid extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['version']		= '1.0';
				$this->config['self_closing']	= 'yes';
				$this->config['base_element']	= 'yes';

				$this->config['name']		= __('Posts Grid', 'avia_framework' );
				$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-portfolio.png";
				$this->config['order']		= 38;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'ep_posts_grid';
				$this->config['tooltip'] 	= __( 'Creates a grid of Posts or any Custom Post Type', 'avia_framework' );
				$this->config['disabling_allowed'] = true;
				$this->config['preview'] = true;
				$this->config['id_name']	= 'id';
				$this->config['id_show']	= 'yes';
			}


			function admin_assets()
			{
				add_action( 'wp_ajax_ep_post_grid_more', array( 'ep_post_grid', 'load_more' ) );
				add_action( 'wp_ajax_nopriv_ep_post_grid_more', array( 'ep_post_grid', 'load_more' ) );
			}


			function extra_assets()
			{
				wp_enqueue_style( 'avia-module-ep-bulma-grid' , ENFOLD_PLUS_ASSETS . 'css/dist/bulma_grid.css', array( 'avia-layout' ), ENFOLD_PLUS_VERSION, 'all' );

				wp_enqueue_style( 'avia-module-ep-grids' , ENFOLD_PLUS_ASSETS . 'css/ep_grids.css', array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
				wp_enqueue_style( 'avia-module-ep-post-grid' , ENFOLD_PLUS_ASSETS . 'css/ep_posts_grid.css' , array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
				wp_enqueue_script( 'avia-module-ep-post-grid', ENFOLD_PLUS_ASSETS . 'js/ep_posts_grid.js', array( 'avia-module-ep-shortcodes-sc' ), ENFOLD_PLUS_VERSION, true );
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
								'lockable' => true,
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
								'lockable' => true,
			                    "std" 	=> "category"),
					
					array(	
								"name" 	=> __("Enable another Taxonomy?", 'avia_framework'),
								"desc" 	=> __("Check to enable another dimension for filtering the content shown on the grid.",'avia_framework' ),
								"id" 	=> "enable_link2",
								'lockable' => true,
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
								'lockable' => true,
								"std" 	=> ""),

					array(	
								"name" 	=> __("Enable another Taxonomy?", 'avia_framework'),
								"desc" 	=> __("Check to enable another dimension for filtering the content shown on the grid.",'avia_framework' ),
								"id" 	=> "enable_link3",
								'lockable' => true,
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
								'lockable' => true,
								"std" 	=> ""),
		
					array(
						"name" 	=> __("Is this FacetWP Template?", 'avia_framework' ),
						"desc" 	=> __("Should this grid behave as a FacetWP Template?", 'avia_framework' ),
						"id" 	=> "facetwp",
						"type" 	=> "checkbox",
						'lockable' => true,
						"std" 	=> ""
					),

					

					array(
							"name" 	=> __("Post Number", 'avia_framework' ),
							"desc" 	=> __("How many items should be displayed per page?", 'avia_framework' ),
							"id" 	=> "items",
							"type" 	=> "select",
							'lockable' => true,
							"std" 	=> "12",
							"subtype" => AviaHtmlHelper::number_array(1,100,1, array('All'=>'-1'))),


					
					array(
							"name" 	=> __("Pagination", 'avia_framework' ),
							"desc" 	=> __("Pick which type of pagination to use, or none at all", 'avia_framework' ),
							"id" 	=> "paginate",
							"type" 	=> "select",
							'lockable' => true,
							"std" 	=> "no",
							"subtype" => array(
								__( 'Yes, add a Load More button',  'avia_framework' ) => 'yes',
								__( 'Yes, add 1/2/3 pagination links',  'avia_framework' ) => 'yes-links',
								__( 'No',  'avia_framework' ) => 'no',
							)
						),
					

					array(
            			    "name" => __("Order by",'avia_framework' ),
							"desc" 	=> __("You can order the result by various attributes like creation date, title, author etc", 'avia_framework' ),
            			    "id"   => "query_orderby",
            			    "type" 	=> "select",
							'lockable' => true,
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
							'lockable' => true,
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
							'lockable' => true,
							'std' 	=> '',
						),

						array(
							'name' => __( 'Exclude Posts', 'avia_framework' ),
							'desc' => __( 'If you want to exclude specific Posts from this Post Grid, enter the Post IDs separated by comma, eg. <em>43, 389, 32</em>', 'avia_framework' ),
							'id'   => 'query_post__not_in',
							'type' 	=> 'input',
							'lockable' => true,
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
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "") {

				$default = ep_post_grid::get_defaults();
			
				if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
					$locked = array();
					Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
					Avia_Element_Templates()->add_template_class( $meta, $atts, $default );
				}

				extract( AviaHelper::av_mobile_sizes( $atts ) ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 
				
				$atts = array_merge( $default, $atts );

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
				
				do_action( 'ava_ep_post_grid_before', $meta );

				$grid = new ep_post_grid( $atts, $meta );
				$grid->query_entries();
				return $grid->html();

			}
		}
}




if ( !class_exists( 'ep_post_grid' ) )
{
	class ep_post_grid
	{
		protected $atts;
		protected $meta;
		protected $entries;

		function __construct( $atts = array(), $meta = array() )
		{
			$this->screen_options = AviaHelper::av_mobile_sizes( $atts );

			$this->atts = shortcode_atts( ep_post_grid::get_defaults(), $atts, 'ep_posts_grid' );
			$this->meta = $meta;

		}

		static public function get_defaults(){
			$el_atts = array(
				'ep_style' => '', 
				'action' => false,
				'offset' => 0,
				'paginate' => 'no',
				'facetwp' => '',
			);

			$grid_atts = EnfoldPlusHelpers::grid_atts();
			$post_item_atts = EnfoldPlusHelpers::post_item_atts();
			$query_atts =  EnfoldPlusHelpers::query_atts();
			$column_atts = EnfoldPlusHelpers::columns_atts();

			$default = array_merge( $el_atts, $grid_atts, $post_item_atts, $query_atts, $column_atts );

			return $default;
		}

		//generates the html of the post grid
		public function html()
		{
			if( empty( $this->entries ) || empty( $this->entries->posts ) ) return;
	
			extract( $this->atts );
			extract( $this->screen_options ); //return $av_font_classes, $av_title_font_classes and $av_display_classes 
			
			$output				= "";
			$load_more_class 	= "";
			$extra_classes		= "";
			
			// FacetWP only kicks in when pagination is not "Load More".
			if( !empty( $facetwp ) ) {
				$extra_classes .= " facetwp-template";
				$paginate = "no";
			}

			if( $paginate == "yes" ) {
				$extra_classes .= " ep-posts-load-more";
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
				"shortcode" => "ep_posts_grid",
				"meta" => $this->meta,
				"disable_term_links" => $disable_term_links, 
				"disable_button" => $disable_button, 
				"button_link" => $button_link, 
				"disable_link" => $disable_link, 
				"post_taxonomy" => $post_taxonomy, 
				"post_terms_number" => $post_terms_number,
				"excerpt_length" => $excerpt_length,
				"date_format" => $date_format,
				"sc_base_classes" => "ep-item-grid-item ep-posts-grid-item {$column_class} {$item_classes}",
				"post_item_custom_class" => $post_item_custom_class
			);

			$items = "";

			foreach ( $this->entries->posts as $post ) {	
				$post_id = $post->ID;
				
				extract( EnfoldPlusHelpers::get_post_vars( $post_id, $grid_atts ) );

				$item_classes = $post_classes; // updated naming for variable name standarization in post.php, item_classes, item_style_tag, etc

				do_action( 'ava_ep_post_grid_post_before', $post_type_slug, $post_id, $this->meta );

				$post_template = !empty( $item_template_file ) ? get_stylesheet_directory() . $item_template_file : '';
				$post_template = apply_filters( "avf_ep_post_grid_post_template", $post_template, $post_type_slug, $post_id, $this->meta );
				$post_template = file_exists( $post_template ) ? $post_template : ENFOLD_PLUS_INC . 'avia-shortcodes/posts_grid/post.php';

				/* Rendering */
				ob_start();
				include( $post_template );
				$items .= ob_get_clean();
			}

			if( isset( $this->atts['action'] ) && $this->atts['action'] == 'ep_post_grid_more' ) {
				return $items;
			}

			$wrapper_data = apply_filters( "avf_ep_posts_grid_wrapper_data", "", $this->meta );
			
			$output .= "";
			$output .= "<div " . $this->meta['custom_el_id'] . " class='ep-posts-grid-container ep-grid-wrapper {$av_display_classes} " . $this->meta['el_class'] . "' " . $wrapper_style . " {$wrapper_data}>";
			$output .= "<div class='ep-posts-grid ep-grid {$extra_classes} {$load_more_class}'>";
			$output .= $items;
			$output .= "</div>";

			
			if( $paginate == "yes"  && $this->entries->max_num_pages > 1 ) {
				$output .= $this->load_more_button();
			}

			if ( $paginate == 'yes-links' && $this->entries->max_num_pages > 1 ) {
				$output .= $this->pagination_links();
			}

			$output .= "</div>";


			return $output;

		}

		public function query_entries( $params = array() ) {
			$query = array();
			if( empty( $params ) ) $params = $this->atts;

			if( $params['paginate'] == 'yes-links') {
				$page = avia_get_current_pagination_number( 'avia-element-paging' );
				$params['offset'] = $params['offset'] + ( ( $page - 1 ) * $params['items'] );
			}

			$posts_query = EnfoldPlusHelpers::query_posts( $params, $this->meta, "ep_post_grid" );
			if( empty( $posts_query ) || empty( $posts_query->posts ) ) return;

			$this->entries = $posts_query;

		}

		static function load_more() {
			if( check_ajax_referer( 'ep-postgrid-nonce', 'avno' ) );
			
			//increase the post items by one to fetch an additional item. this item is later removed by the javascript but it tells the script if there are more items to load or not
			$_POST['items'] = empty( $_POST['items'] ) ? 1 : $_POST['items'] + 1;
		
			$grid  	= new ep_post_grid( $_POST );
			$ajax 	= true;
			
			$grid->query_entries( array() );
			
			$output = $grid->html();
					
			echo '{post-grid-loaded}' . $output;
			exit();
		}

		protected function load_more_button() {

			$data_string  = AviaHelper::create_data_string( $this->atts );
			$data_string .= " data-avno='" . wp_create_nonce( 'ep-postgrid-nonce' ) . "'";
			 
			$extra_classes = apply_filters( "avf_ep_posts_grid_load_more_classes", "avia-button avia-color-primary avia-size-medium", $this->meta, $this->atts );
			$load_more_button_label = apply_filters( "avf_ep_posts_grid_load_more_label", __( 'Load More', 'avia_framework' ), $this->meta, $this->atts );
			$load_more_button_loading_label = __( 'Loading...', 'avia_framework' );

			$data_string = apply_filters( "avf_ep_posts_grid_load_more_data_string", $data_string, $this->meta, $this->atts );

			$output  = "";
			$output .= "<div class='ajax-load-more-wrapper'><div class='ajax-load-more $extra_classes' {$data_string} data-button-label='{$load_more_button_label}' data-loading-label='{$load_more_button_loading_label}'><span class='avia_iconbox_title'>{$load_more_button_label}</span></div></div>";
			
			return $output;
		}	

		protected function pagination_links() {
			return avia_pagination( $this->entries, 'nav', '', avia_get_current_pagination_number( 'avia-element-paging' ) );
		}

	}
}