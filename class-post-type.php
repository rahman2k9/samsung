<?php

// Register Custom Post Type
function classs() {

    $labels = array(
        'name' => _x('Classes', 'Class', 'class'),
        'singular_name' => _x('Class', 'Batch', 'class'),
        'menu_name' => __('Class', 'class'),
        'name_admin_bar' => __('Classes', 'class'),
        'parent_item_colon' => __('Parent Class:', 'class'),
        'all_items' => __('All Class', 'class'),
        'add_new_item' => __('Add New Class', 'class'),
        'add_new' => __('Add New Class', 'class'),
        'new_item' => __('New Class', 'class'),
        'edit_item' => __('Update Class', 'class'),
        'update_item' => __('Update class', 'class'),
        'view_item' => __('View Class', 'class'),
        'search_items' => __('Search Class', 'class'),
        'not_found' => __('Not found', 'class'),
        'not_found_in_trash' => __('Not found in Trash', 'class'),
    );
    $args = array(
        'label' => __('class', 'class'),
        'description' => __('class', 'class'),
        'labels' => $labels,
        'supports' => array(),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 94,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type('post_type_class', $args);
}

add_action('init', 'classs', 0);
