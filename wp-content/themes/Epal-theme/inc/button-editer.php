<?php

function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );
function my_custom_styles( $init_array ) {

    $style_formats = array(
        // These are the custom styles
        array(
            'title' => 'Button 1',
            'block' => 'span',
            'classes' => 'btn btn-sm animated-button victoria-one',
            'wrapper' => true,
        ),
        array(
            'title' => 'Button 2',
            'block' => 'span',
            'classes' => 'btn btn-sm animated-button victoria-two',
            'wrapper' => true,
        ),
        array(
            'title' => 'Button 3',
            'block' => 'span',
            'classes' => 'btn btn-sm animated-button victoria-three',
            'wrapper' => true,
        ),
        array(
            'title' => 'Button 4',
            'block' => 'span',
            'classes' => 'btn btn-sm animated-button victoria-four',
            'wrapper' => true,
        ),
        array(
            'title' => 'Button 5',
            'block' => 'span',
            'classes' => 'btn btn-sm animated-button victoria-four',
            'wrapper' => true,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );
