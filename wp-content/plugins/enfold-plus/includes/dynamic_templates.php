<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'ava_popup_register_dynamic_templates', 'enfold_plus_dynamic_templates' );

function enfold_plus_dynamic_templates( $template_class ) {
	

	/**
	 * EP onClick JavaScript for Buttons
	 */
	$template = array(
		array(
			'name'	=> __( 'Enable onClick','avia_framework' ),
			'desc'	=> __( 'Enable onClick', 'avia_framework' ),
			'id'	=> 'enable_onclick',
			'type'	=> 'select',
			'std'	=> '',
			'subtype'	=> array(
				__( 'Yes', 'avia_framework' )	=> 'yes',
				__( 'No', 'avia_framework' )	=> '',
			)
		),
		array(	
			'name' 	=> __( 'onClick value', 'avia_framework' ),
			'desc' 	=> __( 'onClick value' ),
			'id' 	=> 'onclick',
			'type' 	=> 'input',
			'std' 	=> '',
			'required'	=> array( 'enable_onclick', 'equals', 'yes' )
		),	
	);

	$template_class->register_dynamic_template( 'ep_onclick', $template );

	/**
	 * EP Animation Template
	 */
	$template = array( 
		array(
			'name'	=> __( 'Animation','avia_framework' ),
			'desc'	=> __( 'Set an animation for this element. The animation will be shown once the element appears first on screen. Animations only work in modern browsers and only on desktop computers to keep page rendering as fast as possible.', 'avia_framework' ),
			'id'	=> 'animation',
			'type'	=> 'select',
			'std'	=> '',
			'subtype'	=> array(
				__( 'None', 'avia_framework' ) => '',
				__( 'Fade Animations', 'avia_framework' ) => array(
					__('Fade in', 'avia_framework' )	=> 'fade-in',
					__('Pop up', 'avia_framework' )		=> 'pop-up',
				),
				__( 'Slide Animations', 'avia_framework' ) => array(
					__( 'Top to Bottom', 'avia_framework' )	=> 'top-to-bottom',
					__( 'Bottom to Top', 'avia_framework' )	=> 'bottom-to-top',
					__( 'Left to Right', 'avia_framework' )	=> 'left-to-right',
					__( 'Right to Left', 'avia_framework' )	=> 'right-to-left',
				),
				__( 'Rotate',  'avia_framework' ) => array(
					__( 'Full rotation', 'avia_framework' )			=> 'av-rotateIn',
					__( 'Bottom left rotation', 'avia_framework' )	=> 'av-rotateInUpLeft',
					__( 'Bottom right rotation', 'avia_framework' )	=> 'av-rotateInUpRight',
				)	
			)
		)
	);

	$template_class->register_dynamic_template( 'ep_animation', $template );

	/**
	 * EP Button Colors Template
	 */
	$template = array(
		array(
			"name" 	=> __("Button Color", 'avia_framework' ),
			"desc" 	=> __("Choose a color for your button here", 'avia_framework' ),
			"id" 	=> "color",
			"type" 	=> "select",
			"std" 	=> apply_filters( "avf_ep_buttons_color_std", "theme-color" ),
			"subtype" => apply_filters( "avf_ep_buttons_color_options", array(
				__('Translucent Buttons', 'avia_framework') => array(
					__('Light Transparent', 'avia_framework') => 'light',
					__('Dark Transparent', 'avia_framework') => 'dark',
				),
				__('Colored Buttons', 'avia_framework') => array(
					__('Theme Color', 'avia_framework') => 'theme-color',
					__('Theme Color Highlight', 'avia_framework') => 'theme-color-highlight',
					__('Theme Color Subtle', 'avia_framework') => 'theme-color-subtle',
					__('Blue', 'avia_framework') => 'blue',
					__('Red', 'avia_framework') => 'red',
					__('Green', 'avia_framework') => 'green',
					__('Orange', 'avia_framework') => 'orange',
					__('Aqua', 'avia_framework') => 'aqua',
					__('Teal', 'avia_framework') => 'teal',
					__('Purple', 'avia_framework') => 'purple',
					__('Pink', 'avia_framework') => 'pink',
					__('Silver', 'avia_framework') => 'silver',
					__('Grey', 'avia_framework') => 'grey',
					__('Black', 'avia_framework') => 'black',
					__('Custom Color', 'avia_framework') => 'custom',
				)
			) )
		),

		array(	
			'name' 	=> __( 'Custom Background Color', 'avia_framework' ),
			'desc' 	=> __( 'Select a custom background color for your Button here', 'avia_framework' ),
			'id' 	=> 'custom_bg',
			'type' 	=> 'colorpicker',
			'std' 	=> '#444444',
			'required'	=> array( 'color', 'equals', 'custom' )
		),	
		
		array(	
			'name' 	=> __( 'Custom Font Color', 'avia_framework' ),
			'desc' 	=> __( 'Select a custom font color for your Button here', 'avia_framework' ),
			'id' 	=> 'custom_font',
			'type' 	=> 'colorpicker',
			'std' 	=> '#ffffff',
			'required'	=> array( 'color', 'equals', 'custom')
		),	
	);

	$template_class->register_dynamic_template( 'ep_button_colors', $template );

	/**
	 * EP Button Size
	 */
	$template = array(
		array(	
			'name' 	=> __( 'Button Size', 'avia_framework' ),
			'desc' 	=> __( 'Choose the size of your button here', 'avia_framework' ),
			'id' 	=> 'size',
			'type' 	=> 'select',
			"std" 	=> apply_filters( "avf_ep_buttons_size_std", "medium" ),
			"subtype" => apply_filters( "avf_ep_buttons_size_options", array(
								__( 'Small', 'avia_framework' )		=> 'small',
								__( 'Medium', 'avia_framework' )	=> 'medium',
								__( 'Large', 'avia_framework' )		=> 'large',
								__( 'X Large', 'avia_framework' )	=> 'x-large',
						) )
		),
	);

	$template_class->register_dynamic_template( 'ep_button_size', $template );
	

	/**
	 * EP Flickity Options
	 */
	$template = array(

		/* draggable */
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
			'name' => __( 'draggable', 'avia_framework' ),
			'id'   => 'draggable',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> '',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'draggable', 'avia_framework' ),
			'id'   => 'draggable_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'draggable', 'avia_framework' ),
			'id'   => 'draggable_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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

		/* freeScroll */
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
			'name' => __( 'freeScroll', 'avia_framework' ),
			'id'   => 'freescroll',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
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
			'name' => __( 'freeScroll', 'avia_framework' ),
			'id'   => 'freescroll_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'freeScroll', 'avia_framework' ),
			'id'   => 'freescroll_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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

		/* wrapAround */
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
			'name' => __( 'wrapAround', 'avia_framework' ),
			'id'   => 'wrap_around',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> 'yes',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
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
			'name' => __( 'wrapAround', 'avia_framework' ),
			'id'   => 'wrap_around_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'wrapAround', 'avia_framework' ),
			'id'   => 'wrap_around_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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

		/* prevNextButtons */
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
			'name' => __( 'prevNextButtons', 'avia_framework' ),
			'id'   => 'prev_next_buttons',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> '',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'prevNextButtons', 'avia_framework' ),
			'id'   => 'prev_next_buttons_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'prevNextButtons', 'avia_framework' ),
			'id'   => 'prev_next_buttons_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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

		/* pageDots */
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
			'name' => __( 'pageDots', 'avia_framework' ),
			'id'   => 'page_dots',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> '',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'pageDots', 'avia_framework' ),
			'id'   => 'page_dots_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'pageDots', 'avia_framework' ),
			'id'   => 'page_dots_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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

		/* adaptiveHeight */
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
			'name' => __( 'adaptiveHeight', 'avia_framework' ),
			'id'   => 'adaptive_height',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
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
			'name' => __( 'adaptiveHeight', 'avia_framework' ),
			'id'   => 'adaptive_height_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'adaptiveHeight', 'avia_framework' ),
			'id'   => 'adaptive_height_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'autoPlay', 'avia_framework' ),
			'id'   => 'autoplay',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
						)
		),
		
		array(
			'name' => __( 'autoPlaySpeed', 'avia_framework' ),
			'id'   => 'autoplay_speed',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
			'required' => array( 'autoplay', 'equals', 'yes' ),
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
			'name' => __( 'autoPlay', 'avia_framework' ),
			'id'   => 'autoplay_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
						)
		),

		array(
			'name' => __( 'autoPlaySpeed', 'avia_framework' ),
			'id'   => 'autoplay_tablet_speed',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
			'required' => array( 'autoplay_tablet', 'equals', 'yes' ),
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
			'name' => __( 'autoPlay', 'avia_framework' ),
			'id'   => 'autoplay_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
						)
		),

		array(
			'name' => __( 'autoPlaySpeed', 'avia_framework' ),
			'id'   => 'autoplay_mobile_speed',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
			'required' => array( 'autoplay_mobile', 'equals', 'yes' ),
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
			'name' => __( 'pauseAutoPlayOnHover', 'avia_framework' ),
			'id'   => 'pause_autoplay_on_hover',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'required' => array( 'autoplay', 'equals', 'yes' ),
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> '',
							__( 'No', 'avia_framework' )	=> 'no',
						)
		),

		/* Slider animation */
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
			'name' => __( 'animation', 'avia_framework' ),
			'id'   => 'fade',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Slide', 'avia_framework' )	=> '',
							__( 'Fade', 'avia_framework' )	=> 'yes',
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
			'name' => __( 'animation', 'avia_framework' ),
			'id'   => 'fade_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Slide', 'avia_framework' )	=> 'no',
							__( 'Fade', 'avia_framework' )	=> 'yes',
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
			'name' => __( 'animation', 'avia_framework' ),
			'id'   => 'fade_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Slide', 'avia_framework' )	=> 'no',
							__( 'Fade', 'avia_framework' )	=> 'yes',
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
			'name' => __( 'cellAlign', 'avia_framework' ),
			'id'   => 'cell_align',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Left', 'avia_framework' )	=> 'left',
							__( 'Center', 'avia_framework' ) => '',
							__( 'Right', 'avia_framework' )	=> 'right',
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
			'name' => __( 'cellAlign', 'avia_framework' ),
			'id'   => 'cell_align_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Left', 'avia_framework' )	=> 'left',
							__( 'Center', 'avia_framework' ) => 'center',
							__( 'Right', 'avia_framework' )	=> 'right',
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
			'name' => __( 'cellAlign', 'avia_framework' ),
			'id'   => 'cell_align_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Left', 'avia_framework' )	=> 'left',
							__( 'Center', 'avia_framework' ) => 'center',
							__( 'Right', 'avia_framework' )	=> 'right',
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
			'name' => __( 'groupCells', 'avia_framework' ),
			'id'   => 'group_cells',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> 'true',
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
			'name' => __( 'groupCells (Tablet)', 'avia_framework' ),
			'id'   => 'group_cells_tablet',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
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
			'name' => __( 'groupCells (Mobile)', 'avia_framework' ),
			'id'   => 'group_cells_mobile',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
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
			'name' => __( 'contain', 'avia_framework' ),
			'id'   => 'contain',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
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
			'name' => __( 'contain (Tablet)', 'avia_framework' ),
			'id'   => 'contain_tablet',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'contain (Mobile)', 'avia_framework' ),
			'id'   => 'contain_mobile',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Default', 'avia_framework' )	=> '',
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> 'no',
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
			'name' => __( 'initialIndex', 'avia_framework' ),
			'id'   => 'initial_index',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
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
			'name' => __( 'initialIndex (Tablet)', 'avia_framework' ),
			'id'   => 'initial_index_tablet',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
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
			'name' => __( 'initialIndex (Mobile)', 'avia_framework' ),
			'id'   => 'initial_index_mobile',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
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
			'name' => __( 'watchCSS', 'avia_framework' ),
			'id'   => 'watch_css',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
						)
		),

		array(
			'name' => __( 'lazyLoad', 'avia_framework' ),
			'id'   => 'lazy_load',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
						)
		),

		array(
			'name' => __( 'selectedAttraction', 'avia_framework' ),
			'id'   => 'selected_attraction',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
		),

		array(
			'name' => __( 'friction', 'avia_framework' ),
			'id'   => 'friction',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
		),

		array(
			'name' => __( 'asNavFor', 'avia_framework' ),
			'id'   => 'as_nav_for',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
		),

		array(
			'name' => __( 'sync', 'avia_framework' ),
			'id'   => 'sync',
			'type' 	=> 'input',
			'lockable' => true,
			'std' 	=> '',
		),

		array(
			'name' => __( 'hash', 'avia_framework' ),
			'id'   => 'hash',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
						)
		),

		array(
			'name' => __( 'imagesLoaded', 'avia_framework' ),
			'id'   => 'images_loaded',
			'type' 	=> 'select',
			'lockable' => true,
			'std' 	=> '',
			'subtype'	=> array(	
							__( 'Yes', 'avia_framework' )	=> 'yes',
							__( 'No', 'avia_framework' )	=> '',
						)
		),
		
	);

	$template_class->register_dynamic_template( 'ep_flickity_options', $template );


	/**
	* EP Grid Options
	*/
	$template = array(

		array(
			'type' 	=> 'toggle_container',
			'nodescription' => true
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Grid Layout', 'avia_framework' ),
			'content'		=> array(

									array(
										'name' => __( 'Layout', 'avia_framework' ),
										'desc' => __( 'Set the grid layout', 'avia_framework' ),
										'id'   => 'layout',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype'	=> array(	
														__( 'Default (Grid layout)', 'avia_framework' )	=> '',
														__( 'No grid', 'avia_framework' )	=> 'no-grid',
													)
									),

									array(	
										'type'			=> 'template',
										'template_id'	=> 'columns_count_icon_switcher',
										'heading'		=> array(),
										"required" => array( "layout", "not", "no-grid" ),
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
										"name" 	=> __("Gap", 'avia_framework' ),
										"desc" 	=> __("Should this grid have gaps. If so which value?", 'avia_framework' ),
										"id" 	=> "gap",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "is-3",
										"required" => array( "layout", "not", "no-grid" ),
										"subtype" => array(
											__('No gap',  'avia_framework' ) => 'is-gapless',
											__('Small gap',  'avia_framework' ) =>'is-1',
											__('Default gap',  'avia_framework' ) =>'is-3',
											__('Large gap',  'avia_framework' ) =>'is-6',
											__('Huge gap',  'avia_framework' ) =>'is-8'
										)
									),

									array(
										"name" 	=> __("Grid Alignment (Horizontal)", 'avia_framework' ),
										"desc" 	=> __("What should be the grid alignment Horizontally?", 'avia_framework' ),
										"id" 	=> "grid_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"required" => array( "layout", "not", "no-grid" ),
										"subtype" => array(
											__('Left',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Right',  'avia_framework' ) => 'right',
										)
									),

									array(
										"name" 	=> __("Grid Alignment (Vertical)", 'avia_framework' ),
										"desc" 	=> __("What should be the grid alignment Vertically?", 'avia_framework' ),
										"id" 	=> "grid_alignment_v",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"required" => array( "layout", "not", "no-grid" ),
										"subtype" => array(
											__('Top',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Bottom',  'avia_framework' ) => 'bottom',
										)
									)
								)
		),

		array(
			'type' 	=> 'toggle_container_close',
			'nodescription' => true
		)
	);

	$template_class->register_dynamic_template( 'ep_grid_styling', $template );

	/**
	* EP Item Grid / Posts Grid Options
	*/
	$template = array(

		array(
			'type' 	=> 'toggle_container',
			'nodescription' => true
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Media & Spacing', 'avia_framework' ),
			'content'		=> array(
									array(
										"name" 	=> __("Media Size", 'avia_framework' ),
										"desc" 	=> __("Set a custom media size (if applicable), leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_size",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Space between Media and Content", 'avia_framework' ),
										"desc" 	=> __("Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __( "Space between Title and Content", 'avia_framework' ),
										"desc" 	=> __( "Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "title_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Media Position", 'avia_framework' ),
										"desc" 	=> __("How should the media be positioned?", 'avia_framework' ),
										"id" 	=> "media_position",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Stacked',  'avia_framework' ) => '',
											__('Left side',  'avia_framework' ) => 'left-side',
											__('Right side',  'avia_framework' ) => 'right-side',
										)
									),
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Contents', 'avia_framework' ),
			'content'		=> array(
									array(
										'name' => __( 'Heading Type', 'avia_framework' ),
										'desc' => __( 'Choose a heading type', 'avia_framework' ),
										'id'   => 'heading_type',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> 'h4',
										'subtype'	=> array(	
														'H1' => 'h1',
														'H2' => 'h2',
														'H3' => 'h3',
														'H4' => 'h4',
														'H5' => 'h5',
														'H6' => 'h6',
														'Div' => 'div'
													)
									),

									array(
										"name" 	=> __("Item Alignment (Horizontal)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Horizontally?", 'avia_framework' ),
										"id" 	=> "content_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Left',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Right',  'avia_framework' ) => 'right',
										)
									),
									
									array(
										"name" 	=> __("Item Alignment (Vertical)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Vertically?", 'avia_framework' ),
										"id" 	=> "vertical_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Top',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Bottom',  'avia_framework' ) => 'bottom',
										)
									),

									array(
										'name' 	=> __( 'Make items fill vertical space', 'avia_framework' ),
										"desc" 	=> __("The item grid items will try to fill its parent vertical space", 'avia_framework' ),
										'id' 	=> 'item_fill',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										'name' 	=> __( 'Alternate linking', 'avia_framework' ),
										"desc" 	=> __( "Enabling this will unlink the whole item and instead will create individual links on the image, title and (will add) a read more button below the content. Terms (if applicable), will be linked to their respective archive views.", 'avia_framework' ),
										'id' 	=> 'button_link',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										"name" 	=> __( "Button Color", 'avia_framework' ),
										"desc" 	=> __( "Choose a color for your button here", 'avia_framework' ),
										"id" 	=> "button_color",
										"type" 	=> "select",
										"required"	=> array( "button_link", "not_empty_and", "" ),
										'lockable' => true,
										"std" 	=> apply_filters( "avf_ep_buttons_color_std", "theme-color" ),
										"subtype" => apply_filters( "avf_ep_buttons_color_options", array(
											__('Translucent Buttons', 'avia_framework') => array(
												__('Light Transparent', 'avia_framework') => 'light',
												__('Dark Transparent', 'avia_framework') => 'dark',
											),
											__('Colored Buttons', 'avia_framework') => array(
												__('Theme Color', 'avia_framework') => 'theme-color',
												__('Theme Color Highlight', 'avia_framework') => 'theme-color-highlight',
												__('Theme Color Subtle', 'avia_framework') => 'theme-color-subtle',
												__('Blue', 'avia_framework') => 'blue',
												__('Red', 'avia_framework') => 'red',
												__('Green', 'avia_framework') => 'green',
												__('Orange', 'avia_framework') => 'orange',
												__('Aqua', 'avia_framework') => 'aqua',
												__('Teal', 'avia_framework') => 'teal',
												__('Purple', 'avia_framework') => 'purple',
												__('Pink', 'avia_framework') => 'pink',
												__('Silver', 'avia_framework') => 'silver',
												__('Grey', 'avia_framework') => 'grey',
												__('Black', 'avia_framework') => 'black'
											)
										) )
									),

									array(
										"name" 	=> __( "Button Label", 'avia_framework' ),
										"desc" 	=> __( "Set a custom button label here, if leave empty, default will be used.", 'avia_framework' ),
										"id" 	=> "link_label",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
										"required"	=> array( "button_link", "not_empty_and", "" )
									),

								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Size & Coloring', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Heading Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading color', 'avia_framework' ),
										'id' 	=> 'color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font color for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Content Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a content color', 'avia_framework' ),
										'id' 	=> 'content_color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 

									array(	
										'name' 	=> __( 'Content Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Content Custom Font Color here', 'avia_framework' ),
										'id' 	=> 'content_custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Icon Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a icon custom color', 'avia_framework' ),
										'id' 	=> 'icon_color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Icon Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Icon custom font color for your Heading here', 'avia_framework' ),
										'id' 	=> 'icon_custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'icon_color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Heading Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading size', 'avia_framework' ),
										'id' 	=> 'size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font size for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'size', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Content Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom size', 'avia_framework' ),
										'id' 	=> 'content_size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Content Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom font size for your content here', 'avia_framework' ),
										'id' 	=> 'content_custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_size', 'equals', 'custom' )
									),

								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Animation', 'avia_framework' ),
			'content'		=> array(
									array(	
										'type'			=> 'template',
										'template_id'	=> 'ep_animation'
									),
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Template', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Item Template', 'avia_framework' ),
										'desc' 	=> __( 'Choose here if you want to use the default item template, a custom coded one located in your child theme or plugin. <strong>Note:</strong> none of the styling options above will work on a file/custom template.', 'avia_framework' ),
										'id' 	=> 'item_template_option',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default', 'avia_framework' ) => '', 
															__( 'File', 'avia_framework' ) => 'file'
														)
									), 

									array(	
										'name' 	=> __( 'Item Template File', 'avia_framework' ),
										'desc' 	=> __( 'Input the path value of your template file starting from the root of the child theme (eg. /includes/item-grid-custom.php). This will not work if you\'re already hooking this item grid via PHP (`avf_ep_item_grid_item_template`).', 'avia_framework' ),
										'id' 	=> 'item_template_file',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'item_template_option', 'equals', 'file' )
									)	
								)
		),

		array(
			'type' 	=> 'toggle_container_close',
			'nodescription' => true
		),

	);

	$template_class->register_dynamic_template( 'ep_item_styling', $template );

	/**
	* EP Item Grid Inner Options
	*/

	$template = array(

		array(
			'type' 	=> 'toggle_container',
			'nodescription' => true
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Media & Spacing', 'avia_framework' ),
			'content'		=> array(
									array(
										"name" 	=> __("Media Size", 'avia_framework' ),
										"desc" 	=> __("Set a custom media size (if applicable), leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_size",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Space between Media and Content", 'avia_framework' ),
										"desc" 	=> __("Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __( "Space between Title and Content", 'avia_framework' ),
										"desc" 	=> __( "Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "title_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Media Position", 'avia_framework' ),
										"desc" 	=> __("How should the media be positioned?", 'avia_framework' ),
										"id" 	=> "media_position",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Default',  'avia_framework' ) => '',
											__('Stacked',  'avia_framework' ) => 'stacked',
											__('Left side',  'avia_framework' ) => 'left-side',
											__('Right side',  'avia_framework' ) => 'right-side',
										)
									),
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Contents', 'avia_framework' ),
			'content'		=> array(

									array(
										"name" 	=> __("Override Heading Type", 'avia_framework' ),
										"desc" 	=> __("Set if you want to override Heading Type", 'avia_framework' ),
										"id" 	=> "override_styling",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__( 'No',  'avia_framework' ) => '',
											__( 'Yes',  'avia_framework' ) => 'yes',
										)
									),
									
									array(
										'name' => __( 'Heading Type', 'avia_framework' ),
										'desc' => __( 'Choose a heading type', 'avia_framework' ),
										'id'   => 'heading_type',
										'required' => array( 'override_styling', 'equals', 'yes' ),
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> 'h4',
										'subtype'	=> array(
														__( 'Default', 'avia_framework' ) => '',
														'H1' => 'h1',
														'H2' => 'h2',
														'H3' => 'h3',
														'H4' => 'h4',
														'H5' => 'h5',
														'H6' => 'h6',
														'Div' => 'div'
													)
									),

									array(
										"name" 	=> __("Item Alignment (Horizontal)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Horizontally?", 'avia_framework' ),
										"id" 	=> "content_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Default',  'avia_framework' ) => '',
											__('Left',  'avia_framework' ) => 'left',
											__('Center',  'avia_framework' ) => 'center',
											__('Right',  'avia_framework' ) => 'right',
										)
									),
									
									array(
										"name" 	=> __("Item Alignment (Vertical)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Vertically?", 'avia_framework' ),
										"id" 	=> "vertical_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Default',  'avia_framework' ) => '',
											__('Top',  'avia_framework' ) => 'top',
											__('Center',  'avia_framework' ) => 'center',
											__('Bottom',  'avia_framework' ) => 'bottom',
										)
									),

									array(
										'name' 	=> __( 'Make items fill vertical space', 'avia_framework' ),
										"desc" 	=> __( "The item grid items will try to fill its parent vertical space", 'avia_framework' ),
										'id' 	=> 'item_fill',
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__( 'Default',  'avia_framework' ) => '',
											__( 'No',  'avia_framework' ) => 'no',
											__( 'Yes',  'avia_framework' ) => 'yes',
										)
									),

									array(
										'name' 	=> __( 'Alternate linking', 'avia_framework' ),
										"desc" 	=> __( "Enabling this will unlink the whole item and instead will create individual links on the image, title and (will add) a read more button below the content. Terms (if applicable), will be linked to their respective archive views.", 'avia_framework' ),
										'id' 	=> 'button_link',
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__( 'Default',  'avia_framework' ) => '',
											__( 'No',  'avia_framework' ) => 'no',
											__( 'Yes',  'avia_framework' ) => 'yes',
										)
									),

									array(
										"name" 	=> __( "Button Color", 'avia_framework' ),
										"desc" 	=> __( "Choose a color for your button here", 'avia_framework' ),
										"id" 	=> "button_color",
										"type" 	=> "select",
										"required"	=> array( "button_link", "not", "no" ),
										'lockable' => true,
										"std" 	=> apply_filters( "avf_ep_buttons_color_std", "theme-color" ),
										"subtype" => array_merge( array( __('Default',  'avia_framework' ) => '' ), apply_filters( "avf_ep_buttons_color_options", array(
											__('Translucent Buttons', 'avia_framework') => array(
												__('Light Transparent', 'avia_framework') => 'light',
												__('Dark Transparent', 'avia_framework') => 'dark',
											),
											__('Colored Buttons', 'avia_framework') => array(
												__('Theme Color', 'avia_framework') => 'theme-color',
												__('Theme Color Highlight', 'avia_framework') => 'theme-color-highlight',
												__('Theme Color Subtle', 'avia_framework') => 'theme-color-subtle',
												__('Blue', 'avia_framework') => 'blue',
												__('Red', 'avia_framework') => 'red',
												__('Green', 'avia_framework') => 'green',
												__('Orange', 'avia_framework') => 'orange',
												__('Aqua', 'avia_framework') => 'aqua',
												__('Teal', 'avia_framework') => 'teal',
												__('Purple', 'avia_framework') => 'purple',
												__('Pink', 'avia_framework') => 'pink',
												__('Silver', 'avia_framework') => 'silver',
												__('Grey', 'avia_framework') => 'grey',
												__('Black', 'avia_framework') => 'black'
											)
										) ) )
									),

									array(
										"name" 	=> __( "Button Label", 'avia_framework' ),
										"desc" 	=> __( "Set a custom button label here, if leave empty, default will be used.", 'avia_framework' ),
										"id" 	=> "link_label",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
										"required"	=> array( "button_link", "not", "no" ),
									),

								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Size & Coloring', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Heading Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading color', 'avia_framework' ),
										'id' 	=> 'color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font color for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Content Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a content color', 'avia_framework' ),
										'id' 	=> 'content_color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 

									array(	
										'name' 	=> __( 'Content Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Content Custom Font Color here', 'avia_framework' ),
										'id' 	=> 'content_custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Icon Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a icon custom color', 'avia_framework' ),
										'id' 	=> 'icon_color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Icon Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Icon custom font color for your Heading here', 'avia_framework' ),
										'id' 	=> 'icon_custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'icon_color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Heading Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading size', 'avia_framework' ),
										'id' 	=> 'size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font size for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'size', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Content Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom size', 'avia_framework' ),
										'id' 	=> 'content_size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Content Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom font size for your content here', 'avia_framework' ),
										'id' 	=> 'content_custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_size', 'equals', 'custom' )
									),
									
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Template', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Item Template', 'avia_framework' ),
										'desc' 	=> __( 'Choose here if you want to use the default item template, a custom coded one located in your child theme or plugin. <strong>Note:</strong> none of the styling options above will work on a file/custom template.', 'avia_framework' ),
										'id' 	=> 'item_template_option',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default', 'avia_framework' ) => '', 
															__( 'File', 'avia_framework' ) => 'file'
														)
									), 

									array(	
										'name' 	=> __( 'Item Template File', 'avia_framework' ),
										'desc' 	=> __( 'Input the path value of your template file starting from the root of the child theme (eg. /includes/item-grid-custom.php). This will not work if you\'re already hooking this item grid via PHP (`avf_ep_item_grid_item_template`).', 'avia_framework' ),
										'id' 	=> 'item_template_file',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'item_template_option', 'equals', 'file' )
									)	
								)
		),

		array(
			'type' 	=> 'toggle_container_close',
			'nodescription' => true
		),

	);

	$template_class->register_dynamic_template( 'ep_item_styling_inner', $template );

	/* EP Post Grid Item */
	$template = array(

		array(
			'type' 	=> 'toggle_container',
			'nodescription' => true
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Media & Spacing', 'avia_framework' ),
			'content'		=> array(
									array(
										"name" 	=> __("Media Size", 'avia_framework' ),
										"desc" 	=> __("Set a custom media size (if applicable), leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_size",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Space between Media and Content", 'avia_framework' ),
										"desc" 	=> __("Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "media_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __( "Space between Title and Content", 'avia_framework' ),
										"desc" 	=> __( "Set a custom space, leave empty to use default", 'avia_framework' ),
										"id" 	=> "title_space",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __("Media Position", 'avia_framework' ),
										"desc" 	=> __("How should the media be positioned?", 'avia_framework' ),
										"id" 	=> "media_position",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Stacked',  'avia_framework' ) => '',
											__('Left side',  'avia_framework' ) => 'left-side',
											__('Right side',  'avia_framework' ) => 'right-side',
										)
									),
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Contents', 'avia_framework' ),
			'content'		=> array(
									array(
										'name' => __( 'Heading Type', 'avia_framework' ),
										'desc' => __( 'Choose a heading type', 'avia_framework' ),
										'id'   => 'heading_type',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> 'h4',
										'subtype'	=> array(	
														'H1' => 'h1',
														'H2' => 'h2',
														'H3' => 'h3',
														'H4' => 'h4',
														'H5' => 'h5',
														'H6' => 'h6',
														'Div' => 'div'
													)
									),

									array(
										"name" 	=> __("Item Alignment (Horizontal)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Horizontally?", 'avia_framework' ),
										"id" 	=> "content_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Left',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Right',  'avia_framework' ) => 'right',
										)
									),
									
									array(
										"name" 	=> __("Item Alignment (Vertical)", 'avia_framework' ),
										"desc" 	=> __("What should be the item alignment Vertically?", 'avia_framework' ),
										"id" 	=> "vertical_alignment",
										"type" 	=> "select",
										'lockable' => true,
										"std" 	=> "",
										"subtype" => array(
											__('Top',  'avia_framework' ) => '',
											__('Center',  'avia_framework' ) => 'center',
											__('Bottom',  'avia_framework' ) => 'bottom',
										)
									),

									array(
										'name' 	=> __( 'Make items fill vertical space', 'avia_framework' ),
										"desc" 	=> __("The item grid items will try to fill its parent vertical space", 'avia_framework' ),
										'id' 	=> 'item_fill',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										'name' 	=> __( 'Alternate linking', 'avia_framework' ),
										"desc" 	=> __( "Enabling this will unlink the whole item and instead will create individual links on the image, title and (will add) a read more button below the content. Terms (if applicable), will be linked to their respective archive views.", 'avia_framework' ),
										'id' 	=> 'button_link',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										"name" 	=> __( "Button Color", 'avia_framework' ),
										"desc" 	=> __( "Choose a color for your button here", 'avia_framework' ),
										"id" 	=> "button_color",
										"type" 	=> "select",
										"required"	=> array( "button_link", "not_empty_and", "" ),
										'lockable' => true,
										"std" 	=> apply_filters( "avf_ep_buttons_color_std", "theme-color" ),
										"subtype" => apply_filters( "avf_ep_buttons_color_options", array(
											__('Translucent Buttons', 'avia_framework') => array(
												__('Light Transparent', 'avia_framework') => 'light',
												__('Dark Transparent', 'avia_framework') => 'dark',
											),
											__('Colored Buttons', 'avia_framework') => array(
												__('Theme Color', 'avia_framework') => 'theme-color',
												__('Theme Color Highlight', 'avia_framework') => 'theme-color-highlight',
												__('Theme Color Subtle', 'avia_framework') => 'theme-color-subtle',
												__('Blue', 'avia_framework') => 'blue',
												__('Red', 'avia_framework') => 'red',
												__('Green', 'avia_framework') => 'green',
												__('Orange', 'avia_framework') => 'orange',
												__('Aqua', 'avia_framework') => 'aqua',
												__('Teal', 'avia_framework') => 'teal',
												__('Purple', 'avia_framework') => 'purple',
												__('Pink', 'avia_framework') => 'pink',
												__('Silver', 'avia_framework') => 'silver',
												__('Grey', 'avia_framework') => 'grey',
												__('Black', 'avia_framework') => 'black'
											)
										) )
									),

									array(
										"name" 	=> __( "Button Label", 'avia_framework' ),
										"desc" 	=> __( "Set a custom button label here, if leave empty, default will be used.", 'avia_framework' ),
										"id" 	=> "link_label",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
										"required"	=> array( "button_link", "not_empty_and", "" )
									),

									array(
										"name" 	=> __( "Date Format", 'avia_framework' ),
										"desc" 	=> __( "Date Format", 'avia_framework' ),
										"id" 	=> "date_format",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),
									
									array(
										"name" 	=> __( "Excerpt Length", 'avia_framework' ),
										"desc" 	=> __( "Excerpt Length", 'avia_framework' ),
										"id" 	=> "excerpt_length",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __( "Taxonomy to Show", 'avia_framework' ),
										"desc" 	=> __( "Input a taxonomy slug, if left empty 'category' will be used.", 'avia_framework' ),
										"id" 	=> "post_taxonomy",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),
									
									array(
										"name" 	=> __( "# of Terms to show", 'avia_framework' ),
										"desc" 	=> __( "# of Terms to show", 'avia_framework' ),
										"id" 	=> "post_terms_number",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										"name" 	=> __( "Item classes", 'avia_framework' ),
										"desc" 	=> __( "Individual item classes.", 'avia_framework' ),
										"id" 	=> "post_item_custom_class",
										"type" 	=> "input",
										'lockable' => true,
										"std" 	=> "",
									),

									array(
										'name' 	=> __( 'Disable Image', 'avia_framework' ),
										"desc" 	=> __( "Disable Image", 'avia_framework' ),
										'id' 	=> 'disable_image',
										'type' 	=> 'checkbox',
										'container_class' 	=> 'av_third av_third_first',
										'lockable' => true,
										'std' 	=> '',
									),
									
									array(
										'name' 	=> __( 'Disable Taxonomies', 'avia_framework' ),
										"desc" 	=> __( "Disable Taxonomies", 'avia_framework' ),
										'id' 	=> 'disable_tax',
										'container_class' 	=> 'av_third',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										'name' 	=> __( 'Disable Date', 'avia_framework' ),
										"desc" 	=> __( "Disable Date", 'avia_framework' ),
										'id' 	=> 'disable_date',
										'container_class' 	=> 'av_third',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										'name' 	=> __( 'Disable Title', 'avia_framework' ),
										"desc" 	=> __( "Disable Title", 'avia_framework' ),
										'id' 	=> 'disable_title',
										'container_class' 	=> 'av_third av_third_first',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

									array(
										'name' 	=> __( 'Disable Content/Excerpt', 'avia_framework' ),
										"desc" 	=> __( "Disable Content/Excerpt", 'avia_framework' ),
										'id' 	=> 'disable_content',
										'container_class' 	=> 'av_third',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),
									
									array(
										'name' 	=> __( "Disable Terms links", 'avia_framework' ),
										'desc' 	=> __( "Disable Terms links", 'avia_framework' ),
										'id' 	=> 'disable_term_links',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
										'container_class' 	=> 'av_third',
										"required"	=> array( "button_link", "not_empty_and", "" ),
									),

									array(
										'name' 	=> __( "Disable Button", 'avia_framework' ),
										'desc' 	=> __( "Disable button", 'avia_framework' ),
										'id' 	=> 'disable_button',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
										'container_class' 	=> 'av_third',
										"required"	=> array( "button_link", "not_empty_and", "" ),
									),

									array(
										'name' 	=> __( 'Disable All Links', 'avia_framework' ),
										"desc" 	=> __( "Disable All Links", 'avia_framework' ),
										'id' 	=> 'disable_link',
										'container_class' 	=> 'av_third',
										'type' 	=> 'checkbox',
										'lockable' => true,
										'std' 	=> '',
									),

								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Size & Coloring', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Heading Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading color', 'avia_framework' ),
										'id' 	=> 'color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font color for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'color', 'equals', 'custom' )
									),

									
									array(	
										'name' 	=> __( 'Content Custom Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a content color', 'avia_framework' ),
										'id' 	=> 'content_color',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Color', 'avia_framework' )	=> '', 
															__( 'Custom Color', 'avia_framework' )	=> 'custom'
														)
									), 

									array(	
										'name' 	=> __( 'Content Custom Font Color', 'avia_framework' ),
										'desc' 	=> __( 'Select a Content Custom Font Color here', 'avia_framework' ),
										'id' 	=> 'content_custom_color',
										'type' 	=> 'colorpicker',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_color', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Heading Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a heading size', 'avia_framework' ),
										'id' 	=> 'size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Heading Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a Heading custom font size for your Heading here', 'avia_framework' ),
										'id' 	=> 'custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'size', 'equals', 'custom' )
									),

									array(	
										'name' 	=> __( 'Content Custom Size', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom size', 'avia_framework' ),
										'id' 	=> 'content_size',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default Size', 'avia_framework' )	=> '', 
															__( 'Custom Size', 'avia_framework' )	=> 'custom'
														)
									), 
								
									array(	
										'name' 	=> __( 'Content Custom Size Value', 'avia_framework' ),
										'desc' 	=> __( 'Select a content custom font size for your content here', 'avia_framework' ),
										'id' 	=> 'content_custom_size',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'content_size', 'equals', 'custom' )
									),
									
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Animation', 'avia_framework' ),
			'content'		=> array(
									array(	
										'type'			=> 'template',
										'template_id'	=> 'ep_animation'
									),
								)
		),

		array(	
			'type'			=> 'template',
			'template_id'	=> 'toggle',
			'title'			=> __( 'Item Template', 'avia_framework' ),
			'content'		=> array(
									array(	
										'name' 	=> __( 'Item Template', 'avia_framework' ),
										'desc' 	=> __( 'Choose here if you want to use the default item template, a custom coded one located in your child theme or plugin. <strong>Note:</strong> none of the styling options above will work on a file/custom template.', 'avia_framework' ),
										'id' 	=> 'item_template_option',
										'type' 	=> 'select',
										'lockable' => true,
										'std' 	=> '',
										'subtype' => array( 
															__( 'Default', 'avia_framework' ) => '', 
															__( 'File', 'avia_framework' ) => 'file'
														)
									), 

									array(	
										'name' 	=> __( 'Item Template File', 'avia_framework' ),
										'desc' 	=> __( 'Input the path value of your template file starting from the root of the child theme (eg. /includes/item-grid-custom.php). This will not work if you\'re already hooking this item grid via PHP (`avf_ep_item_grid_item_template`).', 'avia_framework' ),
										'id' 	=> 'item_template_file',
										'type' 	=> 'input',
										'lockable' => true,
										'std' 	=> '',
										'required' => array( 'item_template_option', 'equals', 'file' )
									)	
								)
		),

		array(
			'type' 	=> 'toggle_container_close',
			'nodescription' => true
		),

	);

	$template_class->register_dynamic_template( 'ep_post_item_styling', $template );


	/* Max Width */
	$template = array(
		array(
			"name" 	=> __( "Custom max width", 'avia_framework' ),
			"desc" 	=> __( "If checked the text block will be contained within a defined max width.", 'avia_framework' ),
			"id" 	=> "max_width",
			"type" 	=> "checkbox",
			"std" 	=> "",
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
			"name" 	=> __( "Custom max width", 'avia_framework' ),
			"desc" 	=> __( "Set a max width (px/%/em/rem/vw) to this text block, useful for working with shorter texts.", 'avia_framework' ),
			"id" 	=> "max_width_value",
			"type" 	=> "input",
			"std" 	=> "",
			'required'	=> array( "max_width", "not_empty_and", "" )
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
			"name" 	=> __( "Custom max width (Tablet)", 'avia_framework' ),
			"desc" 	=> __( "Set a max width (px/%/em/rem/vw) to this text block, useful for working with shorter texts.", 'avia_framework' ),
			"id" 	=> "max_width_value_tablet",
			"type" 	=> "input",
			"std" 	=> "",
			'required'	=> array( "max_width", "not_empty_and", "" )
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
			"name" 	=> __( "Custom max width (Mobile)", 'avia_framework' ),
			"desc" 	=> __( "Set a max width (px/%/em/rem/vw) to this text block, useful for working with shorter texts.", 'avia_framework' ),
			"id" 	=> "max_width_value_mobile",
			"type" 	=> "input",
			"std" 	=> "",
			'required'	=> array( "max_width", "not_empty_and", "" )
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
		)
	);

	$template_class->register_dynamic_template( 'ep_max_width', $template );

	/**
	 * Item Grid Extra Fields 
	 */
	$template = apply_filters( 'avf_ep_item_grid_item_options', array() );
	$template_class->register_dynamic_template( 'ep_item_grid_extra_fields', $template );

	/**
	 * Tab Slider Extra Fields
	 */
	$template = apply_filters( 'avf_ep_tab_slider_options', array() );
	$template_class->register_dynamic_template( 'ep_tab_slider_extra_fields', $template );

}