<?php


if( !class_exists( 'ep_sc_tab_slider' ) )
{
    class ep_sc_tab_slider extends aviaShortcodeTemplate
    {
        static protected $flickity_id = 0;

        function shortcode_insert_button()
        {
            $this->config['version']		= '1.0';
            $this->config['self_closing']	= 'no';
            $this->config['base_element']	= 'yes';

			$this->config['name']		= __( 'Tab Slider', 'avia_framework' );
			$this->config['tab']		= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-postslider.png";
			$this->config['order']		= 20;
			$this->config['target']		= 'avia-target-insert';
            $this->config['shortcode'] 	= 'ep_tab_slider';
            $this->config['shortcode_nested'] = array( 'ep_tab_slider_inner' );
			$this->config['tooltip'] 	= __('Tab Slider', 'avia_framework' );
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
                    "type" => "tab_container", "nodescription" => true    
                ),

                array(
                    "type" => "tab",
                    "name" => __("Content", "avia_framework"),
                    "nodescription" => true
                ),

                array(
                    "name" => __("Add/Edit Element", 'avia_framework' ),
                    "desc" => __("Here you can add, remove and edit your Elements.", 'avia_framework' ),
                    "type" 			=> "modal_group",
                    "id" 			=> "content",
                    "modal_title" 	=> __("Edit Element", 'avia_framework' ),
                    'lockable' => true,
                    "std"			=> array(),
                    'subelements' 	=> array(

                        array(
                            "type" 	=> "tab_container", 'nodescription' => true
                        ),

                        array(
                            'type' 	=> 'tab',
                            'name'  => __( 'Content', 'avia_framework' ),
                            'nodescription' => true
                        ),

                        array(
                            "name" 	=> __("Title", 'avia_framework' ),
                            "desc" 	=> __("Title", 'avia_framework' ),
                            "id" 	=> "title",
                            'lockable' => true,
                            "std" 	=> "",
                            "type" 	=> "input"
                        ),

                        array(
                            "name" 	=> __("Subtitle", 'avia_framework' ),
                            "desc" 	=> __("Subtitle", 'avia_framework' ),
                            "id" 	=> "subtitle",
                            'lockable' => true,
                            "std" 	=> "",
                            "type" 	=> "input"
                        ),
                        
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
                            'name' 	=> __( 'Tab Image', 'avia_framework' ),
                            'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
                            'id' 	=> 'id',
                            'fetch' => 'id',
                            'type' 	=> 'image',
                            'title'		=> __( 'Change Image', 'avia_framework' ),
                            'button'	=> __( 'Change Image', 'avia_framework' ),
                            'std' 	=> ''
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
                            'name' 	=> __( 'Tab Image (Tablet)', 'avia_framework' ),
                            'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
                            'id' 	=> 'id_tablet',
                            'fetch' => 'id',
                            'type' 	=> 'image',
                            'title'		=> __( 'Change Image', 'avia_framework' ),
                            'button'	=> __( 'Change Image', 'avia_framework' ),
                            'std' 	=> ''
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
                            'name' 	=> __( 'Tab Image (Mobile)', 'avia_framework' ),
                            'desc' 	=> __( 'Either upload a new, or choose an existing image from your media library', 'avia_framework' ),
                            'id' 	=> 'id_mobile',
                            'fetch' => 'id',
                            'type' 	=> 'image',
                            'title'		=> __( 'Change Image', 'avia_framework' ),
                            'button'	=> __( 'Change Image', 'avia_framework' ),
                            'std' 	=> ''
                        ),

                        array(
                            'type' => 'icon_switcher_close',
                            'nodescription' => 1,
                        ),
                
                        array(
                            'type' => 'icon_switcher_container_close',
                            'nodescription' => 1,
                        ),

                      
                        array(
                            "name" 	=> __("Content", 'avia_framework' ),
                            "desc" 	=> __("Content", 'avia_framework' ),
                            "id" 	=> "content",
                            'lockable' => true,
                            "std" 	=> "",
                            'type' 	=> 'tiny_mce'
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
                            'name' 	=> __( 'Custom CSS Class & ID', 'avia_framework' ),
                            'type' 	=> 'heading',
                            'description_class' => 'av-builder-note av-neutral',
                        ),

                        array(
                            'name' => __( 'Content CSS Class', 'avia_framework' ),
                            'desc' => __( 'Custom CSS Class for this content', 'avia_framework' ),
                            'id'   => 'content_class',
                            'type' 	=> 'input',
                            'lockable' => true,
                            'std' 	=> '',
                        ),

                        array(
                            'name' => __( 'Content ID', 'avia_framework' ),
                            'desc' => __( 'Custom ID for this content', 'avia_framework' ),
                            'id'   => 'content_id',
                            'type' 	=> 'input',
                            'lockable' => true,
                            'std' 	=> '',
                        ),

                        array(
                            'name' => __( 'Control CSS Class', 'avia_framework' ),
                            'desc' => __( 'Custom CSS Class for this control', 'avia_framework' ),
                            'id'   => 'control_class',
                            'type' 	=> 'input',
                            'lockable' => true,
                            'std' 	=> '',
                        ),

                        array(
                            'name' => __( 'Control ID', 'avia_framework' ),
                            'desc' => __( 'Custom ID for this content', 'avia_framework' ),
                            'id'   => 'control_id',
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
							'template_id'	=> 'ep_tab_slider_extra_fields'
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
                    'lockable' => true,
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
                    'lockable' => true,
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
                    'lockable' => true,
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
                    "template_id" => "screen_options_toggle",
                    'lockable'		=> true
                ),

                array(
                    "type" => "template",
                    "template_id" => "developer_options_toggle",
                    "args" => array( "sc" => $this ),
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
                    'type'			=> 'template',
                    'template_id'	=> 'element_template_selection_tab',
                    'args'			=> array( 'sc' => $this )
                ),

                array(
                    "type" => "tab_container_close",
                    "nodescription" => true
                ),
            );

        }

        function editor_sub_element($params)
        {
            $template = $this->update_template("title", "{{title}}");

            $params['innerHtml']  = "";
            $params['innerHtml'] .= "<div class='avia_title_container' {$template}>".$params['args']['title']."</div>";

            return $params;
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
            
            $default = array_merge( $el_atts, $slider_atts );

            $tab_items = ShortcodeHelper::shortcode2array( $content, 1 );

            if( function_exists( 'Avia_Element_Templates' ) && method_exists( $this, 'sync_sc_defaults_array' ) ) {
                $default = $this->sync_sc_defaults_array( $default, 'no_modal_item', 'no_content' );
                $locked = array();
                Avia_Element_Templates()->set_locked_attributes( $atts, $this, $shortcodename, $default, $locked, $content );
                Avia_Element_Templates()->add_template_class( $meta, $atts, $default );

                foreach( $tab_items as $key => &$item ) {
                    $item_def = $this->get_default_modal_group_args();
                    Avia_Element_Templates()->set_locked_attributes( $item['attr'], $this, $this->config['shortcode_nested'][0], $item_def, $locked, $item['content'] );
                }
            }

            $atts = shortcode_atts( $default, $atts, $this->config['shortcode'] );

            self::$flickity_id ++;

            $item_count = count( ShortcodeHelper::shortcode2array( $content, 1 ) );
            $wrapper_data = "";
            $extra_classes_wrapper = " ep-flickity-slider-wrapper";
            $extra_classes = " ep-flickity-slider";
            $flickity_lazy_load = ! empty( $atts['lazy_load'] ) ? true : false;

            extract( $atts );

            if( !empty( $layout ) ) $extra_classes_wrapper .= " ep-controls-{$layout}";
            if( !empty( $breakpoint ) ) $extra_classes_wrapper .= " ep-breakpoint-{$breakpoint}";
            if( !empty( $responsive_behavior ) ) {
                $extra_classes_wrapper .= " ep-mobile-behavior-{$responsive_behavior}";
                if( $responsive_behavior == 'toggle' ) {
                    $atts['watch_css'] = true;
                    $flickity_lazy_load = false; // on toggle (mobile mode), flickity doesn't run so lazy loading there is impossible, set false as default
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
                "asNavFor" => ".ep-tab-slider-" . self::$flickity_id . " .ep-tab-slider-contents"
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

            ob_start();

            ?>
            <div <?php echo $meta['custom_el_id']; ?> class='ep-tab-slider ep-tab-slider-<?php echo self::$flickity_id; ?> <?php echo $extra_classes_wrapper; ?> <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>' <?php echo $wrapper_data; ?> style="--itemCount: <?php echo $item_count; ?>">
                <div class="ep-tab-slider-controls-wrapper">
                    <?php if( ! empty( $before_controls ) ) { ?>
                        <div class="ep-tab-slider-before-controls">
                            <?php echo ShortcodeHelper::avia_apply_autop( ShortcodeHelper::avia_remove_autop( $before_controls ) ); ?>
                        </div>
                    <?php } ?>
                    <div class='<?php echo apply_filters( "avf_{$this->config['shortcode']}_controls_classes", "ep-tab-slider-controls " . $extra_classes, $meta, self::$flickity_id ); ?>' <?php echo $data_controller_flickity; ?>>
                        <?php foreach( $tab_items as $key => $value ) { 

                            extract( $value['attr'] );

                            $tab_slider_control_template = apply_filters( "avf_{$this->config['shortcode']}_control_template", '', $atts, $meta );
                            $tab_slider_control_template = file_exists( $tab_slider_control_template ) ? $tab_slider_control_template : ENFOLD_PLUS_INC . 'avia-shortcodes/tab_slider/control.php';
                            include( $tab_slider_control_template );

                        } ?>
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
                        foreach( $tab_items as $key => $value ) { 
                            extract( $value['attr'] );

                            $tab_slider_slide_template = apply_filters( "avf_{$this->config['shortcode']}_slide_template", '', $atts, $meta );
                            $tab_slider_slide_template = file_exists( $tab_slider_slide_template ) ? $tab_slider_slide_template : ENFOLD_PLUS_INC . 'avia-shortcodes/tab_slider/slide.php';
                            include( $tab_slider_slide_template );

                            $counter++; 
                        } ?>
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