<?php
// Register Custom Post Type
function batch() {

	$labels = array(
		'name'                => _x( 'Batches', 'Batche', 'batch' ),
		'singular_name'       => _x( 'Batch', 'Batch', 'batch' ),
		'menu_name'           => __( 'Batch', 'batch' ),
		'name_admin_bar'      => __( 'Batches', 'batch' ),
		'parent_item_colon'   => __( 'Parent Batch:', 'Batch' ),
		'all_items'           => __( 'All Batchs', 'batch' ),
		'add_new_item'        => __( 'Add New Batch', 'batch' ),
		'add_new'             => __( 'Add New Batch', 'batch' ),
		'new_item'            => __( 'New Batch', 'Batch' ),
		'edit_item'           => __( 'Update New Batch', 'batch' ),
		'update_item'         => __( 'Update Batch', 'Batch' ),
		'view_item'           => __( 'View Batch', 'batch' ),
		'search_items'        => __( 'Search batch', 'batch' ),
		'not_found'           => __( 'Not found', 'batch' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'batch' ),
	);
	$args = array(
		'label'               => __( 'batchs', 'batch' ),
		'description'         => __( 'batchs', 'batch' ),
		'labels'              => $labels,
		'supports'            => array( ),
		'taxonomies'          => array(),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 93,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
        
	register_post_type( 'post_type_batch', $args );

}

add_action( 'init', 'batch', 0 );