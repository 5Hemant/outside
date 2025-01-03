<?php

/**
 * blocks
 */


if (!function_exists('outside_test_wp_register_block')) {
    function outside_test_wp_register_block($name, $title, $img)
    {
        if (function_exists('acf_register_block')) {
            acf_register_block(array(
                'name'                => $name,
                'title'                => __($title),
                'description'        => __($title),
                'render_callback'    => 'outside_test_block_render_callback',
                'category'            => 'outside_test-theme',
                'supports' => array(
                    'className'  => true,
                    'anchor' => true,
                ),
                'mode' => 'edit',
                'align' => false,
                'icon'                => 'format-image',
                'keywords'            => array($name, $title, 'outside_test'),
                'example'           => array(
                    'attributes' => array(
                        'mode' => 'preview',
                        // 'data' => array(
                        //     'is_preview'    => true,
                        //     'gutenberg_preview' => __('<img src="' . $img . '">'),
                        // )
                    )
                )
            ));
        }
    }
}

add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
    $path = get_theme_root() . '/outside-test/blocks/';
    $get_dir = outside_test_wp_dir_to_array($path);
    $block_name = array();

    //Block load from child theme
    if (get_template_directory() !== get_stylesheet_directory()) {
        $path_child = get_stylesheet_directory() . '/blocks/';
        $get_dir_child = outside_test_wp_dir_to_array($path_child);

        if ($get_dir_child) {
            foreach ($get_dir_child as $k => $dir) {
                if (is_array($dir)) {
                    outside_test_wp_register_init_child($k, $dir, 'child');
                }
            }
        }

        //Block load from parent theme
        $path = get_template_directory() . '/blocks/';
        $get_dir = outside_test_wp_dir_to_array($path);
        if ($get_dir) {
            foreach ($get_dir as $k => $dir) {
                if (is_array($dir)) {
                    if (!array_key_exists($k, $get_dir_child) && !empty($dir)) {
                        outside_test_wp_register_init_child($k, $dir, 'parent');
                    }
                }
            }
        }
    } else {
        if ($get_dir) {
            foreach ($get_dir as $k => $dir) {
                $title = ucwords(str_replace('-', ' ', $k));
                $img = get_template_directory_uri() . '/inc/admin/images/outside_test-wp.png';
                if (is_array($dir) && in_array('template.php', $dir)) {
                    $img = get_template_directory_uri() . '/blocks/' . $k . '/preview.png';
                    outside_test_wp_register_block($k, $title, $img);
                }
            }
        }
    }
}
function outside_test_wp_register_init_child($key, $dir, $theme)
{
    if (!is_array($dir)) {
        return;
    }
    $title = ucwords(str_replace('-', ' ', $key));
    $img = get_template_directory_uri() . '/inc/admin/images/outside_test-wp.png';
    outside_test_wp_register_block($key, $title, $img);
    if (is_array($dir) && in_array('preview.png', $dir) && in_array('template.php', $dir)) {
        if($theme == 'child') {
            $img = get_stylesheet_directory_uri() . '/blocks/' . $key . '/preview.png';
        } else {
            $img = get_template_directory_uri() . '/blocks/' . $key . '/preview.png';
        }
    }
}
function outside_test_block_render_callback($block)
{
    $slug = str_replace('acf/', '', $block['name']);
    if (get_template_directory() !== get_stylesheet_directory()) {
        if (file_exists(get_stylesheet_directory() . '/blocks/' . $slug . '/template.php')) {
            require get_stylesheet_directory() . '/blocks/' . $slug . '/template.php';
        } else {
            require get_template_directory() . '/blocks/' . $slug . '/template.php';
        }
    } else {
        if (file_exists(get_theme_file_path("/blocks/{$slug}/template.php"))) {
            include(get_theme_file_path("/blocks/{$slug}/template.php"));
        }
    }
}

add_filter('allowed_block_types_all', 'outside_test_wp_allowed_block_types');
function outside_test_wp_allowed_block_types($allowed_blocks)
{
    $path = get_theme_root() . '/outside-test/blocks/';
    $get_dir = outside_test_wp_dir_to_array($path);
    $block_name = array();
    if ($get_dir) {
        foreach ($get_dir as $k => $dir) {
            $block_name[] = 'acf/' . $k;
        }
    }
    if (get_template_directory() !== get_stylesheet_directory()) {
        //Load block from child theme
        if (get_template_directory() !== get_stylesheet_directory()) {
            $path_child = get_stylesheet_directory() . '/blocks/';
            $get_dir_child = outside_test_wp_dir_to_array($path_child);
            if ($get_dir_child) {
                foreach ($get_dir_child as $k => $dir) {
                    if (!array_key_exists($k, $get_dir) && is_array($dir) && !empty($dir)) {
                        $block_name[] = 'acf/' . $k;
                    }
                }
            }
        }
    }

    return $block_name;
}

if (!function_exists('outside_test_wp_dir_to_array')) {
    function outside_test_wp_dir_to_array($dir)
    {
        $result = array();
        if(file_exists($dir)) {
            $cdir = scandir($dir);
            foreach ($cdir as $key => $value) {
                if (!in_array($value, array(".", ".."))) {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                        $result[$value] = outside_test_wp_dir_to_array($dir . DIRECTORY_SEPARATOR . $value);
                    } else {
                        $result[] = $value;
                    }
                }
            }
        }

        return $result;
    }
}


function disable_gutenberg_editor_for_page_templates( $use_block_editor, $post ) {
    $template = get_page_template_slug( $post->ID );
    $excluded_templates = array(
        'templates/page-my-account.php'
	);

    if ( in_array( $template, $excluded_templates ) ) {
        return false;
    }
    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'disable_gutenberg_editor_for_page_templates', 10, 2 );
