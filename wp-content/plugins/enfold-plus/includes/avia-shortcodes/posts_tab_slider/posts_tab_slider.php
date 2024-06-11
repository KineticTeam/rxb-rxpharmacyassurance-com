<?php


if( !class_exists( 'ep_sc_posts_tab_slider' ) )
{
    class ep_sc_posts_tab_slider extends aviaShortcodeTemplate
    {
        static protected $flickity_id = 0;

        function shortcode_insert_button()
        {
            $this->config['version']		= '1.0';
            $this->config['self_closing']	= 'no';
			$this->config['name']		= __( 'Posts Tab Slider', 'avia_framework' );
			$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-postslider.png";
			$this->config['order']		= 20;
			$this->config['target']		= 'avia-target-insert';
            $this->config['shortcode'] 	= 'ep_posts_tab_slider';
			$this->config['tooltip'] 	= __('Posts Tab Slider', 'avia_framework' );
			$this->config['preview'] 	= false;
			$this->config['disabling_allowed'] = true;
			$this->config['id_name']		= 'id';
			$this->config['id_show']		= 'yes';
        }

		function extra_assets() {
			EnfoldPlusHelpers::flickity_assets();
            wp_enqueue_style( 'avia-module-ep-tab-slider' , ENFOLD_PLUS_ASSETS . 'css/ep_tab_slider.css' , array(), ENFOLD_PLUS_VERSION, 'all' );
		}

        function popup_elements()
        {
            $this->elements = array(


                array(
                    'name' 	=> __( 'Experimental Element', 'avia_framework' ),
                    'desc' 	=> __( 'This element is experimental, custom development is required to get a good result.', 'avia_framework' ),
                    'type' 	=> 'heading',
                    'description_class' => 'av-builder-note av-notice',
                ),
                
                array(
                    "type" => "tab_container", "nodescription" => true    
                ),

                array(
                    "type" => "tab",
                    "name" => __("Content", "avia_framework"),
                    "nodescription" => true
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
                    "name" 	=> __("Before Controls Content", 'avia_framework' ),
                    "id" 	=> "before_controls",
                    'lockable' => true,
                    "std" 	=> "",
                    'type' 	=> 'tiny_mce'
                ),

                array(
                    "name" 	=> __("After Controls Content", 'avia_framework' ),
                    "id" 	=> "after_controls",
                    'lockable' => true,
                    "std" 	=> "",
                    'type' 	=> 'tiny_mce'
                ),

                array(
                    "name" 	=> __("Before Content", 'avia_framework' ),
                    "id" 	=> "before_content",
                    'lockable' => true,
                    "std" 	=> "",
                    'type' 	=> 'tiny_mce'
                ),

                array(
                    "name" 	=> __("After Content", 'avia_framework' ),
                    "id" 	=> "after_content",
                    'lockable' => true,
                    "std" 	=> "",
                    'type' 	=> 'tiny_mce'
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
                    'name' 	=> __( 'Layout', 'avia_framework' ),
                    'desc' 	=> __( 'Tab slider layout', 'avia_framework' ),
                    'id' 	=> 'layout',
                    'type' 	=> 'select',
                    'std' 	=> '',
                    'subtype'	=> array( 
                        'Controls above / content below (default)' => '', 
                        'Controls below / content above' => 'below',
                        'Controls left / content right' => 'left',
                        'Controls right / content left' => 'right'
                    )
                ),

                array(
                    'name' 	=> __( 'Responsive breakpoint', 'avia_framework' ),
                    'desc' 	=> __( 'Set the breakpoint at which this tab slider should stack', 'avia_framework' ),
                    'id' 	=> 'breakpoint',
                    'type' 	=> 'select',
                    'std' 	=> '',
                    'subtype'	=> array( 
                        'Mobile - 767px (default)' => '', 
                        'Tablet - 1023px' => 'tablet',
                    )
                ),

                array(
                    'name' 	=> __( 'Responsive behaviour', 'avia_framework' ),
                    'desc' 	=> __( 'Set the responsive behaviour for this slider', 'avia_framework' ),
                    'id' 	=> 'responsive_behavior',
                    'type' 	=> 'select',
                    'std' 	=> '',
                    'subtype'	=> array( 
                        'Stacked (default)' => '',
                        'Make contents a slider' => 'slider', 
                        'Make contents act like a toggle' => 'toggle',
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
                    "type" => "tab",
                    "name" => __("Advanced", "avia_framework"),
                    "nodescription" => true                    
                ),

                array(
                    "type" => "template",
                    "template_id" => "screen_options_toggle"
                ),

                array(
                    "type" => "template",
                    "template_id" => "developer_options_toggle",
                    "args" => array("sc" => $this),
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
                    "type" => "tab_close",
                    "nodescription" => true
                ),

                array(
                    "type" => "tab_container_close",
                    "nodescription" => true
                ),
            );

        }
        

        function shortcode_handler( $atts, $content = "", $shortcodename = "", $meta = "")
        {
            $this->screen_options = AviaHelper::av_mobile_sizes( $atts );

            extract( $this->screen_options );

            $el_atts = array( 
                'ep_style' => '',
                'before_controls' => '',
                'after_controls' => '',
                'before_content' => '',
                'after_content' => '',
                'layout' => '',
                'breakpoint' => '',
                'responsive_behavior' => '', 
            );
            
            $slider_atts = EnfoldPlusHelpers::slider_atts(); 
			$query_atts =  EnfoldPlusHelpers::query_atts();

            $atts = shortcode_atts( array_merge( $el_atts, $slider_atts, $query_atts ), $atts, $this->config['shortcode'] );

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

            extract( $atts );

            $posts_query = EnfoldPlusHelpers::query_posts( $atts, $meta, $this->config['shortcode'] );
            
            self::$flickity_id ++;

            $wrapper_data = "";
            $extra_classes_wrapper = " ep-flickity-slider-wrapper";
            $extra_classes = " ep-flickity-slider";

            if( !empty( $layout ) ) $extra_classes_wrapper .= " ep-controls-{$layout}";
            if( !empty( $breakpoint ) ) $extra_classes_wrapper .= " ep-breakpoint-{$breakpoint}";
            if( !empty( $responsive_behavior ) ) {
                $extra_classes_wrapper .= " ep-mobile-behavior-{$responsive_behavior}";
                if( $responsive_behavior == 'toggle' ) {
                    $atts['watch_css'] = true;
                }
            }

            $data_flickity = apply_filters( "avf_{$this->config['shortcode']}_data_flickity", EnfoldPlusHelpers::get_flickity_data( $atts ), $meta, self::$flickity_id );
            $wrapper_data = apply_filters( "avf_{$this->config['shortcode']}_wrapper_data", $wrapper_data, $meta );

            /**
             * Controller flickity slider options processing
             */
            $controller_flickity_options = apply_filters( "avf_{$this->config['shortcode']}_controls_data_flickity_arr", array(
                "draggable" => false,
                "prevNextButtons" => false,
                "pageDots" => false,
                "asNavFor" => ".ep-posts-tab-slider-" . self::$flickity_id . " .ep-tab-slider-contents"
            ), $meta, self::$flickity_id );

            $data_controller_flickity_val = json_encode( $controller_flickity_options );
            
            /**
             * Make controller flickity slider be responsive IF content flickity slider is responsive
             */
            $data_controller_flickity = "";
            if( strpos( $data_flickity, 'ep-flickity' ) !== false ){
                $data_controller_flickity = "data-ep-flickity='{$data_controller_flickity_val}'";

                if( strpos( $data_flickity, 'ep-flickity-tablet' ) !== false ){
                    $data_controller_flickity .= "data-ep-flickity-tablet='{$data_controller_flickity_val}'";
                }

                if( strpos( $data_flickity, 'ep-flickity-mobile' ) !== false ){
                    $data_controller_flickity .= "data-ep-flickity-mobile='{$data_controller_flickity_val}'";
                }

            } else {
                $data_controller_flickity = "data-flickity='{$data_controller_flickity_val}'";
            }

            $data_controller_flickity = apply_filters( "avf_{$this->config['shortcode']}_data_controller_flickity", $data_controller_flickity, $meta, self::$flickity_id );

            if( empty( $posts_query ) || empty( $posts_query->posts ) ) return;

            $item_count = count( $posts_query->posts );
            $post_item_custom_class = "";
            $item_classes = "";
			$item_style_tag = "";
			$heading_style = "";
			$heading_type = "h4";
			$button_link = "yes";
			$link_label = "Read more";
			$button_color = "theme-color";

            /* Bunch of data that get_post_vars may need */
            $grid_atts = array(
                "shortcode" => $this->config['shortcode'],
				"meta" => $meta,
				"disable_term_links" => false, 
				"disable_button" => false, 
				"button_link" => $button_link,
                "sc_base_classes" => "",
				"post_item_custom_class" => ""
			);

            /** Declare $this->meta equal to $meta to avoid errors when post.php file is included, since there are hooks looking for that */
            $this->meta = $meta;

            ob_start();

            ?>
            <div <?php echo $meta['custom_el_id']; ?> class='ep-tab-slider ep-posts-tab-slider ep-posts-tab-slider-<?php echo self::$flickity_id; ?> <?php echo $extra_classes_wrapper; ?> <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>' <?php echo $wrapper_data; ?> style="--itemCount: <?php echo $item_count; ?>">
                <div class="ep-tab-slider-controls-wrapper">
                    <?php if( ! empty( $before_controls ) ) { ?>
                        <div class="ep-tab-slider-before-controls">
                            <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $before_controls ) ); ?>
                        </div>
                    <?php } ?>
                    <div class='<?php echo apply_filters( "avf_{$this->config['shortcode']}_controls_classes", "ep-tab-slider-controls " . $extra_classes, $meta, self::$flickity_id ); ?>' <?php echo $data_controller_flickity; ?>>
                        <?php
                        $column_class = "ep-tab-control ep-flickity-slide";
                        $column_class_inner = "";

                        foreach ( $posts_query->posts as $post ) {
                            $post_id = $post->ID;
				
                            extract( EnfoldPlusHelpers::get_post_vars( $post_id, $grid_atts ) );
                            
                            $post_template = apply_filters( "avf_{$this->config['shortcode']}_control_template", '', $post_type_slug, $post_id, $meta );
                            $post_template = file_exists( $post_template ) ? $post_template : ENFOLD_PLUS_INC . 'avia-shortcodes/posts_grid/post.php';
            
                            /* Rendering */
                            include( $post_template );
                        }
                        ?>
                    </div>
                    <?php if( ! empty( $after_controls ) ) { ?>
                        <div class="ep-tab-slider-after-controls">
                            <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $after_controls ) ); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="ep-tab-slider-contents-wrapper">
                    <?php if( ! empty( $before_content ) ) { ?>
                        <div class="ep-tab-slider-before-content">
                            <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $before_content ) ); ?>
                        </div>
                    <?php } ?>
                    <div class="<?php echo apply_filters( "avf_{$this->config['shortcode']}_contents_classes", "ep-tab-slider-contents ep-flickity-slider-single" . $extra_classes, $meta, self::$flickity_id ); ?>" <?php echo $data_flickity; ?>>
                        <?php
                        $counter = 0;
                        $column_class = "ep-tab-content ep-flickity-slide";
                        foreach ( $posts_query->posts as $post ) {
                            $post_id = $post->ID;
				
                            extract( EnfoldPlusHelpers::get_post_vars( $post_id, $grid_atts ) );
            
                            $post_template = apply_filters( "avf_{$this->config['shortcode']}_content_template", '', $post_type_slug, $post_id, $meta );
                            $post_template = file_exists( $post_template ) ? $post_template : ENFOLD_PLUS_INC . 'avia-shortcodes/posts_grid/post.php';
            
                            /* Rendering */
                            include( $post_template );
                            $counter++;
                        }
                        ?>
                    </div>
                    <?php if( ! empty( $after_content ) ) { ?>
                        <div class="ep-tab-slider-after-content">
                            <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $after_content ) ); ?>
                        </div>
                    <?php } ?>
                </div>
			</div>
            <?php

            $output = ob_get_clean();

            return $output;
        }
    }
}

?>