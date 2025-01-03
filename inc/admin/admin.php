<?php
/**
 * All themee settings
 */
/**
 * Register Theme Option through ACF.
 */
if (!function_exists('register_option_sub_page')) {
    function register_option_sub_page($page_title, $menu_title, $parent)
    {
        acf_add_options_sub_page(array(
            'page_title'     => $page_title,
            'menu_title'    => $menu_title,
            'parent_slug'    => $parent,
        ));
    }
}
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'Outside Test Theme',
        'menu_title'    => 'Outside Test Theme',
        'menu_slug'     => 'theme-option',
        'capability'    => 'edit_posts',
        'parent_slug'     => '',
        'position'         => 2,
        'redirect'        => false
    ));
}
/*
Typography Settings
*/
// require get_template_directory() . '/inc/admin/typography-setting.php';
/*
Color Settings
*/
// require get_template_directory() . '/inc/admin/color-setting.php';
/*
Button Settings
*/
// require get_template_directory() . '/inc/admin/button-setting.php';
/*
Save Settings
*/
// require get_template_directory() . '/inc/admin/save-setting.php';
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if (!function_exists('outside_wp_widgets_init')) {
    add_action('widgets_init', 'outside_wp_widgets_init');
    function outside_wp_widgets_init()
    {
        $get_widgets = function_exists('get_field') ? get_field('add_sidebar', 'options') : "";
        if ($get_widgets) {
            foreach ($get_widgets as $widget) {
                register_sidebar(
                    array(
            'name'          => $widget['sidebar_name'],
            'id'            => str_replace(' ', '-', strtolower($widget['sidebar_name'])),
            'description'   => esc_html__('Add widgets here.', 'keller-theme'),
            'before_widget' => '<div id="%1$s" class="w-full lg:w-auto"><div class="widget-title">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        )
                );
            }
        }
    }
}
/* Admin JS */

add_action('admin_footer', 'outside_admin_js');
function outside_admin_js()
{
    wp_enqueue_script('keller-admin-js', get_template_directory_uri() . '/inc/admin/js/admin.js', array(), _S_VERSION, true);
    wp_localize_script('keller-admin-js', 'ajax_posts', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
    ));
}

/* Admin CSS */
add_action('admin_head', 'outside_admin_css');
function outside_admin_css()
{
    echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/inc/admin/css/admin.css" type="text/css" media="all" />';
}

function acf_load_sidebar_choices($field)
{
    $field['choices'] = array();
    if (have_rows('add_sidebar', 'option')) {
        while (have_rows('add_sidebar', 'option')) {
            the_row();

            $label = get_sub_field('sidebar_name');

            $value = get_sub_field('sidebar_name');
            $field['choices'][ $label ] = $label;
        }
    }
    return $field;
}
// add_filter('acf/load_field/name=choose_sidebar', 'acf_load_sidebar_choices');

add_action('admin_init', 'outside_disable_autosave');
function outside_disable_autosave()
{
    wp_deregister_script('autosave');
}

function outside_filter_acf_relationship($args, $field, $post_id)
{
    $args['post_status'] = 'publish';
    return $args;
}

add_filter('acf/fields/relationship/query', 'outside_filter_acf_relationship', 10, 3);
