<?php
/**
 * Custom Color Palette for WYSIWYG
 *
 * @param array $init
 * @return array
 */
function wysiwyg_custom_palette($init)
{
    $colours = "
    '5f89e6', 'Link Blue',
    'c84bf4', 'Header Purple',
    'db3cfd', 'Bright Pink',
    '304d7c', 'Dark Blue (default text)',
	";

    $init['textcolor_map'] = '['.$colours.']';
    return $init;
}

add_filter('tiny_mce_before_init', 'wysiwyg_custom_palette');

 /**
 * Add Custom Styles to TinyMCE editor
 *
 * @param array $init_array
 * @return void
 */
function my_mce_before_init_insert_formats($init_array)
{
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Text',
            'items' => array(
                // Font Weights
                array(
                    'title' => 'Weight',
                    'items' => array(
                        array(
                            'title' => 'Light (300)',
                            'inline' => 'span',
                            'classes' => 'fw-300',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'Regular (400)',
                            'inline' => 'span',
                            'classes' => 'fw-400',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'Bold (700)',
                            'inline' => 'span',
                            'classes' => 'fw-700',
                            'wrapper' => false,
                        ),
                    ),
                ),

                // Font Sizes
                array(
                    'title' => 'Size',
                    'items' => array(
                        array(
                            'title' => 'Default',
                            'inline' => 'span',
                            'classes' => 'text-base',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'H1 (4xl)',
                            'inline' => 'span',
                            'classes' => 'text-4xl',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'H2 (3xl)',
                            'inline' => 'span',
                            'classes' => 'text-3xl',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'H3 (2xl)',
                            'inline' => 'span',
                            'classes' => 'text-2xl',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'H4 (xl)',
                            'inline' => 'span',
                            'classes' => 'text-xl',
                            'wrapper' => false,
                        ),
                        array(
                            'title' => 'H5 (lg)',
                            'inline' => 'span',
                            'classes' => 'text-lg',
                            'wrapper' => false,
                        ),
                    ),
                ),

                // Font family
                [
                    'title' => 'Font Family',
                    'items' => [
                        [
                            'title' => 'Default (Lato)',
                            'inline' => 'span',
                            'classes' => 'font-sans',
                            'wrapper' => false,
                        ],
                        [
                            'title' => 'Heading (Poppins)',
                            'inline' => 'span',
                            'classes' => 'font-display',
                            'wrapper' => false,
                        ],
                    ],
                ],
            ),
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode($style_formats);

    return $init_array;
}
// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2($buttons)
{
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');
