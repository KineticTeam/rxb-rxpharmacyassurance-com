=== Enfold Plus ===
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enfold Plus is an addon for the Enfold theme by Kriesi, this plugin aims to add / improve existing Enfold features and elements.

== Changelog ==

= 0.1.9.61 =
* Added: ignore sticky posts on Posts Grid / Posts Slider and Posts Tab Slider, toggle will be added later.

= 0.1.9.60 =
* Added: onClick option for button and buttonrow.

= 0.1.9.59 =
* Added: Vimeo background params to ensure functionality on Chrome.

= 0.1.9.58 =
* Updated: plugin php version

= 0.1.9.57 =
* Tweak: added items_wrap to custom_menu element nav rendering to improve Accesibility
* Tweak: revamped Hr element options and CSS.
* Added: added more generic hooks to Posts Grid post.php 
* Tweak: Simplified posts grid post.php classes rendering
* Added: subtitle field to tab slider
* Fixed: wrong field type for posts tab slider
* Added: multiple ep styles support
* Added: option to set subheading inside heading tag 
* Removed: support for <4.8 theme conditionals
* Fixed: icon alignment and custom class output

= 0.1.9.56 =
* Removed: unnecessary padding-bottom styling attribute from headings.
* Added: `avf_ep_posts_grid_load_more_data_string` hook, also provided more context to other PG hooks.
* Added: `avf_ep_item_grid_item_default_options` hook, needed to initialize custom options on item grid.
* Added: `avf_ep_item_grid_item_classes` hook.
* Added: initialIndex option to Flickity sliders.

= 0.1.9.55 =
* Tweak: Item Grid, added subtitle check for content output conditional
* Added: span wrapper to load more button in Posts Grid
* Added: Multiple item grid do action hooks
* Tweak: Added func to get_term functions so that if term is publicly_queryable false force no links since there won't be archive view
* Added: avf_ep_get_terms_array, avf_ep_get_terms_term_slug and avf_ep_get_terms_term_name hook to get_terms helper func to manipulate returned array.
* Tweak: added $atts context to posts grid post internal hooks
* Fixed: fixed a bug in columns/row lazy loaded bg that didn't work well when Enfold Fast wasn't present.
* Added: heading appearance parameter for Heading element

= 0.1.9.54 =
* Added: div/span option to Heading element.
* Tweak: Increased available sizes options for heading size.
* Fixed: an issue with FacetWP and Pagination
* Added: added lazy load support to flex column and row background options.

= 0.1.9.53 =
* Tweak: Converted Tab Slider and Posts Tab Slider before/after fields to rich text and added wrappers.
* Added: `ava_ep_post_grid_post_title_before`, `ava_ep_post_grid_post_title_after`, `ava_ep_post_grid_post_button_before`, `ava_ep_post_grid_post_button_after` hooks
* Tweak: Posts Grid/Posts Slider, updated thumbnail function to use wp_get_attachment_image instead of get_the_post_thumbnail in order to get it to add loading='lazy' attribute, it makes more sense as get_the_post_thumbnail should be used in a single post context.
* Tweak: Defaulted loading lazy for all responsive images
* Added: freeScroll option to Flickity Sliders
* Added: Pagination links option to Post Grid
* Tweak: Moved `avf_ep_item_grid_item_options` render to "Extra" tab for better organization.
* Updated: avia-builder.js (support for Enfold 5+).
* Added: added EP Style to HR and Icon

= 0.1.9.52 = 
* Added: added `avf_ep_get_terms_term_link` for easier term html modification.
* Tweak: Moved EP Style setup to Enfold Plus

= 0.1.9.51 = 
* Added: lockable param to ep_style options.
* Added: added ep_style to Section, Rows/Columns, Buttons/ButtonRows, Image, Textblock, Heading, Posts Sliders/Posts Grid
* Added: added max width to Image element
* Added: added responsive options for images in Item Grid/Slider and Content Slider
* Updated: added `avf_custom_element_subtype_handling` filter to force 'individually' mode for templates, this fixes the bug where adding a "new" item in a subgroup would clone the first rather than creating an empty one (this is opinionated).
* Tweak: enabled loading='lazy' on Image by default
* Added: Flickity lazy load support on Item Grid Slider and Content Slider
* Added: Lazy Loading for Background Images on Section and Section overlay (needs Enfold Fast)
* Tweak: added "Extra fields" tab to tab slider item for better organization of custom fields, also moved `avf_ep_tab_slider_options` filter to it using custom template `ep_tab_slider_extra_fields`.
* Added: added multiple hooks to tab slider control and slide, goal is to not have to custom template all the times.
* Added: added custom id/custom class to tab slider content/control

= 0.1.9.50 = 
* Added: added 'ep_style' to item grid, content slider and tab sliders (experimental)

= 0.1.9.49 = 
* Added: added default subtitle field for Item Grid

= 0.1.9.48 = 
* Added: added `avf_ep_item_grid_item_options` to be able to filter item options for item grid
* Tweak: updated `avf_ep_post_item_classes` to be an associative array for better handling of post_classes
* Tweak: updated default options for some elements, will make propagation easier
* Added: added `parent` option to Posts Grid / Slider settings.

= 0.1.9.47 = 
* Updated: updated posts_tab_slider.php to fix error related to $meta value in post.php template.

= 0.1.9.46 = 
* Updated: updated section.php code to use newer Enfold 4.8.9 slideshow class for video backgrounds.

= 0.1.9.45 = 
* Added: `avf_ep_posts_tab_slider_data_flickity`, `avf_ep_posts_tab_slider_data_controller_flickity`, `avf_ep_tab_slider_data_flickity`, `avf_ep_tab_slider_data_controller_flickity` filters for direct control over rendered data-flickity on HTML.

= 0.1.9.44 = 
* Added: `ava_ep_post_grid_post_item_inner_before` and `ava_ep_post_grid_post_item_inner_after` for Posts Grid / Posts Slider post.php template.
* Tweak: Made Posts Grid available as a base element for custom templating.

= 0.1.9.43 = 
* Added: responsive max width options to text block
* Added: responsive max width options to Heading
* Added: Before/after content fields for tab slider

= 0.1.9.42 = 
* Added: added `contain` Flickity option to Flickity slider.
* Added: added `avf_ep_post_grid_post_item_button_color` and `avf_ep_post_grid_post_item_link_label` hooks to post.php template.

= 0.1.9.41 = 
* Tweak: made Google Maps marker image return 'full' image intead of resized.

= 0.1.9.40 =
* Fixed: fixed CSS error on Tab Slider that made before controls be removed.

= 0.1.9.39 =
* Fixed: fixed a CSS class issue related native jQuery posts load more with old/legacy loop content items.

= 0.1.9.38 =
* Fixed: fixed typo in backwards compat func for overlay bg

= 0.1.9.37 =
* Tweak: Posts Grid/Slider, updated terms helper functions, made sure we had something to loop before attempting a loop and also made them use a single private function for links/without links options.
* Updated: Content Slider, made it available as a Custom Element.
* Updated: Item Grid/Slider, made it available as a Custom Element.
* Updated: Tab Slider, made it available as a Custom Element.
* Added: added before/after hooks for item.php/post.php/slide.php
* Updated: Color Section, overlay bg updated bugs, improved styling declation, separated bg repeat from bg size
* Updated: Color Section, added responsive padding/margin options

= 0.1.9.36 =
* Updated: Color Section, custom container variable name update.

= 0.1.9.35 =
* Fixed: Columns, fixed typo on columns offset option
* Fixed: Tab Slider / Posts Tab Slider, fixed conflict when on same Page
* Tweak: Item Grid/Slider, added flickity slider single wrapper class in case item grid slid
in case item grid slider is set to no grid
* Added: Tab Slider / Posts Tab Slider, added multiple hooks to posts tab slider and tab slider for more control
* Tweak: Posts Grid, unified Post Query processing using helper func
* Removed: Posts Grid/Slider/Tab Slider, removed avia_template_builder_custom_post_type_grid and add_avia_builder_post_type_option hook conditionals.
* Added: Posts Grid, added more opts to customizer post template links and button

= 0.1.9.34 =
* Fixed: fixed post item template not getting item styling classes.

= 0.1.9.33 =
* Added: added `avf_ep_post_item_classes` for hooking into post item template identifier classes.

= 0.1.9.32 =
* Updated: Updated Color Section to be used a base custom element
* Updated: Updated Separator / Whitespace base custom element class setting.

= 0.1.9.31 =
* Updated: Post/Item Grid, left/right setting with flex based columnization
* Added: Post/Item Grid, added custom content font size option
* Added: Post/Item Grid, added space between title and content option

= 0.1.9.30 =
* Updated: Separator / Whitespace, added check for parent theme compatibility (Custom Elements)
* Added: Posts Grid/Posts Slider, added `avf_ep_post_grid_query_object` and `avf_ep_post_slider_query_object` hook to modify resulting WP_Query object (also added to Posts Tab Slider).
* Updated: updated Posts Slider to work with new item options and functionality.

= 0.1.9.29 =
* Tweak: Posts Grid, added $post_title to post vars for post template, hook: `avf_ep_post_item_title`
* Updated: Updated Separator / Whitespace, made available as a base custom elemented and extended position options to custom separator too (was only short sep).

= 0.1.9.28 =
* Tweak: Posts Grid, added $post_image to post vars for post template, hook: `avf_ep_post_item_image`, excepts a <img> element to be returned, not an ID.
* Tweak: Posts Grid, added option to set a custom individual class on each item ("Item Styling > Item Contents > Item classes"), useful when doing featured posts blocks so identifier can be in the block, not the container.

= 0.1.9.27 =
* Fixed: made sure item grid button color options provided a default opt

= 0.1.9.26 =
* Fixed: function name for EP template part column name

= 0.1.9.25 =
* Added: option to limit number of terms shown in Posts Grid block

= 0.1.9.24 =
* Added: do_shortcode param for template_part sc
* Added: "Used in" and "Copy shortcodes" columns for Template Part
* Added: custom content color option for Item Grid/Post Grid
* Updated: updated item grid item template internal linking

= 0.1.9.23 =
* Fixed: fixed a class bug with columns

= 0.1.9.22 =
* Added: updated hooks for post vars helper func

= 0.1.9.21 =
* Added: no grid option for item grid / posts grid

= 0.1.9.20 =
* Fixed: Item Grid item link_label override

= 0.1.9.19 =
* Added: disabler checkboxes for Posts Grid Post item, post taxonomy option, excerpt length option and date format option
* Added: post template option for Post Grid implemented.

= 0.1.9.18 =
* Fixed: tab slider notice error

= 0.1.9.17 =
* Fixed: made item grid media back a inline-block, previous update messed up alignment.

= 0.1.9.16 = 
* Added: added avf_ep_posts_grid_item_content_length filter.

= 0.1.9.15 =
* Updated: added item count to posts tab slider and tab slider

= 0.1.9.14 =
* Updated: added filters to Posts Tab Slider

= 0.1.9.13 =
* Updated version

= 0.1.9.12 =
* Added: Posts Tab Slider, similar to Tab Slider but pulls Posts.
* Fixed: Item grid default item button rendering

= 0.1.9.11 =
* Added: added option to set max width and alignment to text block

= 0.1.9.10 =
* Updated labels
* Added: Helper function get_post_vars for better Posts Grid usage on child themes.

= 0.1.9.9 =
* Updated version

= 0.1.9.8 =
* Removed unused files from previous update.

= 0.1.9.7 =
* Added: added Tab Slider element
* Added: autoplay responsive option for Flickity sliders
* Updated: updated get_terms_with_links/get_terms_without_links helper functions

= 0.1.9.6 =
* Added: unified Posts Grid options, added option for button link handling for Posts/Item Grid and more.
* Added: added slider responsive options for draggable, wrapAround, prevNextButtons, pageDots and animation 
* Fix: added fixes to responsive options for Section overlay

= 0.1.9.5 =
* Fix: added fixes to responsive options for Section overlay

= 0.1.9.4 =
* Fix: added fixes to responsive options for Section overlay

= 0.1.9.3 =
* Added: mobile/tablet position for small hr
* Added: responsive options for Section overlay
* Removed: custom HTML template inside Element Settings for Item Grid.

= 0.1.9.2 =
* Defaulted lazy load for Images

= 0.1.9.1 =
* Added div option for item grid

= 0.1.9 =
* Fixed notice error from previous update.

= 0.1.8.9 =
* Added "Fill vertical space" option to Item Grid, fixed some bugs.

= 0.1.8.8 =
* Added Flickity hash option
* Added Flickity imagesLoaded option

= 0.1.8.7 =
* Improvement: added `avf_ep_button_inner_html` to filter inner button HTML output.

= 0.1.8.6 =
* Fix: fixed error notice on Content Slider.

= 0.1.8.5 =
* Feature: Item Grid, provided an option to target a file to load as template.

= 0.1.8.4 =
* Improvement: Item Grid, made it possible to select both image and icon.
* Improvement: Item Grid and Content Slider, added item index variable ($item_index).
* Feature: Item Grid, provided a way to create a custom HTML template inside Element Settings.

= 0.1.8.3 =
* Added avf_ep_subheading_default_size filter (provides backward supports for old versions of plugin)

= 0.1.8.2 =
* Updated multi_value_result_lockable support (4.8)

= 0.1.8.1 =
* Added support for Enfold 4.8+

= 0.1.8 =
* Added Flickity prev-next 

= 0.1.7.9 =
* Content Slider: Added conditional to not render text div if slide text fields (heading, subheading, content) are empty
* Post Grid/Post Slider: Added meta context parameter for `avf_ep_post_grid_query` / `avf_ep_post_slider_query`
* Post Grid/Post Slider: Added `ava_ep_post_grid_before` / `ava_ep_post_slider_before` with meta context parameter
* Post Grid: Changed Pagination option default value to "No", plays better with Enfold Fast
* Item Grid/Content Slider: Added `avf_ep_item_grid_wrapper_data` / `avf_ep_content_slider_wrapper_data` to modify Item Grid wrapper data.

= 0.1.7.8 =
* Provided basic support in case child already wants to include class-gmaps (path should match)

= 0.1.7.7 =
* Added option to set custom marker size in Google Maps element