<?php
/**
 * Social Profiles
 */

if ( !class_exists( 'ep_sc_social_profiles' ) ) 
{
	class ep_sc_social_profiles extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */ 
		function shortcode_insert_button()
		{
			$this->config['version']		= '1.0';
			$this->config['self_closing']	=	'yes';	
			$this->config['name']			= __( 'Social Profiles', 'avia_framework' );
			$this->config['tab']			= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
			$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-button.png";
			$this->config['order']			= 1;
			$this->config['target']			= 'avia-target-insert';
			$this->config['shortcode'] 		= 'ep_social_profiles';
			$this->config['tooltip'] 		= __('Displays Social Profiles set in Theme Options', 'avia_framework' );
			$this->config['tinyMCE']   	 	= array('tiny_always'=>true);
			$this->config['disabling_allowed'] = true; 
			$this->config['preview'] 		= true; 
			$this->config['id_name']	= 'id';
			$this->config['id_show']	= 'yes';
		}
		
		/**
		 * Popup Elements
		 *
		 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
		 * opens a modal window that allows to edit the element properties
		 *
		 * @return void
		 */
		function extra_assets()
		{
			//load css
			wp_enqueue_style( 'avia-module-ep-social-profiles' , ENFOLD_PLUS_ASSETS . 'css/ep_social_profiles.css' , array( 'avia-layout' ), ENFOLD_PLUS_VERSION, false );
		}

			
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
					"name" 	=> __("Alignment", 'avia_framework' ),
					"desc" 	=> __("Set the alignment for your Social Profiles.", 'avia_framework' ),
					"id" 	=> "alignment",
					"type" 	=> "select",
					"std" 	=> "left",
					"subtype" => array(	
						__('Left', 'avia_framework' ) =>'left',
						__('Center', 'avia_framework' ) =>'center',
						__('Right', 'avia_framework' ) =>'right',
					)
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
		function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
		{
			$this->screen_options = AviaHelper::av_mobile_sizes( $atts );

			extract( $this->screen_options );

			$atts = shortcode_atts( array(
				'alignment' => 'left'
 			), $atts );

			extract( $atts );

			ob_start();
			
			?>
			<div <?php echo $meta['custom_el_id']; ?> class='ep-social-bookmarks-wrapper <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>'>
				<?php 
				$social_args = array( 'outside' => 'ul', 'inside'=>'li', 'append' => '', 'class' => 'ep-social-bookmarks ep-align-'.$alignment );
				echo avia_social_media_icons( $social_args, false ); 
				?>
			</div>
			<?php
			$output = ob_get_clean();

			return $output;
		}
	
	}
}
