<?php

// Register Custom Post Type
function subjects() {

    $labels = array(
        'name' => _x('Subjectes', 'Class', 'subject'),
        'singular_name' => _x('Subject', 'Batch', 'subject'),
        'menu_name' => __('Subject', 'subject'),
        'name_admin_bar' => __('Subjectes', 'subject'),
        'parent_item_colon' => __('Parent Subject:', 'subject'),
        'all_items' => __('All Subjects', 'subject'),
        'add_new_item' => __('Add New Subject', 'subject'),
        'add_new' => __('Add New Subject', 'subject'),
        'new_item' => __('New Subject', 'subject'),
        'edit_item' => __('Update Subject', 'subject'),
        'update_item' => __('Update Subject', 'subject'),
        'view_item' => __('View Subject', 'subject'),
        'search_items' => __('Search Subject', 'subject'),
        'not_found' => __('Not found', 'subject'),
        'not_found_in_trash' => __('Not found in Trash', 'subject'),
    );
    $args = array(
        'label' => __('subject', 'subject'),
        'description' => __('subject', 'subject'),
        'labels' => $labels,
        'supports' => array(),
        'taxonomies' => array(),
        'hierarchical' => true,
        'public' => true,
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

    register_post_type('post_type_subject', $args);
}

add_action('init', 'subjects', 0);
