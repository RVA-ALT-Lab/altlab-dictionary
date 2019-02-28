<?php 
/*
Plugin Name: ALT Lab dictionary creator
Plugin URI:  https://github.com/
Description: For building word banks with accessible tooltip definitions using ACF tooltips derived from https://codepen.io/geraldfullam/pen/MYpKyj
Version:     1.0
Author:      Tom Woodward
Author URI:  http://bionicteaching.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//based on acf field vocabulary_bank with subfields target_language_word and english_equivalent

add_action('wp_enqueue_scripts', 'load_dictionary_tooltip_script');

function load_dictionary_tooltip_script() {                           
    $deps = array('jquery');
    $version= '1.0'; 
    $in_footer = true;    
    wp_enqueue_script('tooltip-dictionary', plugin_dir_url( __FILE__) . 'js/altlab-dictionary.js', $deps, $version, $in_footer); 
    wp_enqueue_style( 'tooltip-dictionary', plugin_dir_url( __FILE__) . 'css/altlab-dictionary.css');
}
        


function get_the_vocab_words(){
    global $post;
    $html= '';
    if( have_rows('vocabulary_bank', $post->ID) ):
        $html = '<h2 class="alt-dictionary-title">Word Bank</h2><div class="alt-dictionary">';
    while ( have_rows('vocabulary_bank') ) : the_row();
        // Your loop code
      $html .= '<button type="button" class="dictionary">' . get_sub_field('target_language_word');
      $html .= '<span class="tooltip tip-top" role="tooltip">' . get_sub_field('english_equivalent') . '</span></button>';
    endwhile;
      $html .=  '</div>';
      return $html;
    else :
        // no rows found
    endif;
   
}



function add_the_vocab_words( $content ) {

    $words = get_the_vocab_words();
    $content = $content . $words;
    return $content;
}

add_filter( 'the_content', 'add_the_vocab_words', 20 );

//add acf stuff if you have ACF pro running (based on repeater field so you need pro) -- will remove option to edit it though which might be confusing
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
    'key' => 'group_5b562549618d1',
    'title' => 'Vocabulary Builder',
    'fields' => array (
        array (
            'key' => 'field_5b5625749e430',
            'label' => 'Vocabulary Bank',
            'name' => 'vocabulary_bank',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => 'Add a new word pair',
            'sub_fields' => array (
                array (
                    'key' => 'field_5b5626ba63e37',
                    'label' => 'Target Language Word',
                    'name' => 'target_language_word',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_5b5625939e432',
                    'label' => 'English Equivalent',
                    'name' => 'english_equivalent',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'part',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'front-matter',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'back-matter',
            ),
        ),
    ),
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;
