<?php
// CREATE CUSTOM POST TYPE
if(!function_exists('createPostType')){
    add_action('init', 'createPostType');

    function createPostType()
    {
        $addPostTypes = array(
            // array(
            //     'slug'         	=> 'Team',
            //     'singular_name'  	=> 'Team',
            //     'plural_name'  	=> 'Teams',
            //     'post_type'    	=> 'kt-Team',
            //     'supports'		=> array( 'title', 'thumbnail'),
            //     'has_single'		=> false,
            //     'has_archive' => false,
            //     'icons'		=> 'dashicons-id',
            // ),
        );
        if($addPostTypes){
            foreach ($addPostTypes as $postType) {
                $args = array(
                    'labels' => array(
                        'name' => $postType['plural_name'],
                        'singular_name' => $postType['singular_name'],
                        'add_new' => 'Add New',
                        'add_new_item' => 'Add New '.$postType['singular_name'],
                        'edit_item' => 'Edit '.$postType['singular_name'],
                        'new_item' => 'New '.$postType['singular_name'],
                        'all_items' => 'All '.$postType['plural_name'],
                        'view_item' => 'View '.$postType['singular_name'],
                        'search_items' => 'Search '.$postType['plural_name'],
                        'not_found' =>  'No '.$postType['plural_name'].' found',
                        'not_found_in_trash' => 'No '.$postType['plural_name'].' found in Trash',
                        'menu_name' => $postType['plural_name']
                    ),
                    'public' => $postType['has_single'],
                    'publicly_queryable' => $postType['has_single'],
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'show_in_rest'       => true, // To use Gutenberg editor.
                    'query_var' => $postType['has_single'],
                    'rewrite' => array( 'slug' => $postType['slug'],'with_front' => false ),
                    //'rewrite' => array( 'with_front' => false ),
                    'capability_type' => 'post',
                    'has_archive' => $postType['has_archive'],
                    'hierarchical' => true,
                    'menu_position' => null,
                    'menu_icon'     => (isset($postType['icons']) && !empty($postType['icons']))?$postType['icons']:null,
                    'supports' => $postType['supports'],
                );
                register_post_type($postType['post_type'], $args);
            }
        }
    }
}

// CUSTOM TAXONOMY
if (!function_exists('registerTaxonomy')) {
    add_action('init', 'registerTaxonomy');

    function registerTaxonomy()
    {
        $postTaxonomies = array(
            // array(
            //     'slug'         	    => 'product-type',
            //     'singular_name'  	=> 'Product Type',
            //     'name'  			=> 'Product Type',
            //     'post_type'    	    => array( 'product'),
            //     'show_admin_column' => true,
            //     'public'			=> false
            // )
        );

        if ($postTaxonomies) {
            foreach ($postTaxonomies as $postTaxonomy) {
                register_taxonomy($postTaxonomy['slug'], $postTaxonomy['post_type'], array(
                'hierarchical' => true,
                'show_admin_column' => $postTaxonomy['show_admin_column'],
                'show_ui'           => true,
                'show_in_rest' => true,

                'labels' => array(
                    'name' => __($postTaxonomy['name'], $postTaxonomy['name']),
                    'singular_name' => __($postTaxonomy['singular_name'], $postTaxonomy['singular_name']),
                    'search_items' =>  __('Search '.$postTaxonomy['name']),
                    'all_items' => __('All '.$postTaxonomy['name']),
                    'parent_item' => __('Parent '.$postTaxonomy['name']),
                    'parent_item_colon' => __('Parent '.$postTaxonomy['name']),
                    'edit_item' => __('Edit '.$postTaxonomy['name']),
                    'update_item' => __('Update '.$postTaxonomy['name']),
                    'add_new_item' => __('Add New '.$postTaxonomy['name']),
                    'new_item_name' => __('New '.$postTaxonomy['name'].' Name'),
                    'menu_name' => __($postTaxonomy['name']),
                ),
                'rewrite' => array(
                    'slug' => $postTaxonomy['slug'],
                    'with_front' => false,
                    'public'    => $postTaxonomy['public'],
                    'hierarchical' => true,
                ),
            ));
            }
        }
    }
}