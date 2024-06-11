<?php
/**
 * Custom Sub Menu
 * 
 * Shortcode that allows to display a Custom Sub Menu
 */
if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


if ( !class_exists( 'ep_custom_sc_submenu' ) ) 
{
	class ep_custom_sc_submenu extends aviaShortcodeTemplate
	{	
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['version']		= '1.0';
				$this->config['self_closing']	= 'yes';
				$this->config['name']			= __('Custom Menu', 'avia_framework' );
				$this->config['tab']			= apply_filters( "avf_ep_tab_name", "Enfold Plus" );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-submenu.png";
				$this->config['order']			= 30;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'ep_custom_menu';
				$this->config['tooltip'] 	    = __('Displays a custom menu set in Appareance > Menus', 'avia_framework' );
				$this->config['tinyMCE'] 		= array('disable' => "true");
				$this->config['preview'] 		= true;
				$this->config['disabling_allowed'] = true; 
				$this->config['id_name']	= 'id';
				$this->config['id_show']	= 'yes';
			}

			function extra_assets()
			{
				//load css
				wp_enqueue_style( 'avia-module-ep-custom-menu' , ENFOLD_PLUS_ASSETS . 'css/ep_custom_menu.css' , array( 'avia-layout' ), ENFOLD_PLUS_VERSION, false );
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
				global $avia_config;
				
				$menus = array();
				$menus = AviaHelper::list_menus();
				
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
						"name" 	=> __("Select menu to display", 'avia_framework' ),
						"desc" 	=> __("You can create new menus in ", 'avia_framework' )."<a target='_blank' href='".admin_url('nav-menus.php?action=edit&menu=0')."'>".__('Appearance -> Menus', 'avia_framework' )."</a><br/>".__("Please note that Mega Menus are not supported for this element ", 'avia_framework' ),
						"id" 	=> "menu",
						"type" 	=> "select",
						"std" 	=> "",
						"subtype" =>  $menus
					),
					
					array(	
						"name" 	=> __("Style", 'avia_framework' ),
						"desc" 	=> __("Set the menu to be either vertical or horizontal", 'avia_framework' ),
						"id" 	=> "style",
						"type" 	=> "select",
						"std" 	=> "",
						"subtype" =>  array(
							"Horizontal" => '',
							"Vertical"	=> 'vertical'
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
					'menu'	=> '',
					'style'	=> 'horizontal'
				), $atts );

				extract( $atts );

				$style = $style ? $style : "horizontal";

				ob_start();
				?>
				<div <?php echo $meta['custom_el_id']; ?> class='ep-custom-menu-element ep-custom-menu-style-<?php echo $style; ?> <?php echo $av_display_classes; ?> <?php echo $meta['el_class']; ?>'>
					<?php 

					$menu = wp_nav_menu(
						array(
							'items_wrap'	=> '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
							'menu' 			=> wp_get_nav_menu_object( $menu ),
							'fallback_cb' 	=> '',
							'container'		=> false,
							'echo' 			=> false,
							'walker' 		=> new avia_responsive_mega_menu( array( 'megamenu' => 'disabled' ) )
						)
					);

					echo $menu;

					?>
				</div>
				<?php
				$output = ob_get_clean();

				return $output;
			}

	}
}



