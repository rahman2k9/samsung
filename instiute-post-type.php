<?php

// Register Custom Post Type
function institute() {

    $labels = array(
        'name' => _x('Institutes', 'Institutes', 'institute'),
        'singular_name' => _x('Institute', 'Institute', 'institute'),
        'menu_name' => __('Institute', 'institute'),
        'name_admin_bar' => __('Institutes', 'institute'),
        'parent_item_colon' => __('Parent Institute:', 'institute'),
        'all_items' => __('All Institutes', 'institute'),
        'add_new_item' => __('Add New Institute', 'institute'),
        'add_new' => __('Add New Institute', 'institute'),
        'new_item' => __('New I', 'institute'),
        'edit_item' => __('Update New Institute', 'institute'),
        'update_item' => __('Update Institute', 'institute'),
        'view_item' => __('View Institute', 'institute'),
        'search_items' => __('Search Institute', 'institute'),
        'not_found' => __('Not found', 'institute'),
        'not_found_in_trash' => __('Not found in Trash', 'institute'),
    );
    $args = array(
        'label' => __('Institutes', 'institute'),
        'description' => __('Institutes', 'institute'),
        'labels' => $labels,
        'supports' => array(),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 92,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('post_type_institute', $args);
}
add_action('init', 'institute');
