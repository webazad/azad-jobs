<?php
// :: STATIC CUSTOM POST
function azad_custom_post(){
    $singular = apply_filters('custom_post_name','job');
    $plural = $singular.'s';
    $domain = 'azad-jobs';

    $labels = array(
        'name'               => _x( ucwords($plural), 'post type general name', $domain ),
        'singular_name'      => _x( 'Book', 'post type singular name', $domain ),
        'menu_name'          => _x( 'Jobs', 'admin menu', $domain ),
        'name_admin_bar'     => _x( ucwords($singular), 'add new on admin bar', $domain ),
        'add_new'            => _x( 'Add New', $singular, $domain ),
        'add_new_item'       => __( 'Add New Job', $domain ),
        'new_item'           => __( 'New Book', $domain ),
        'edit_item'          => __( 'Edit Book', $domain ),
        'view_item'          => __( 'View Book', $domain ),
        'all_items'          => __( 'All Jobs', $domain ),
        'search_items'       => __( 'Search Books', $domain ),
        'parent_item_colon'  => __( 'Parent Books:', $domain ),
        'not_found'          => __( 'No books found.', $domain ),
        'not_found_in_trash' => __( 'No books found in Trash.', $domain )
    );
    $args = array(
        'labels'                => $labels,
        'description'		=> __( 'Description.', $domain ),
        'public'             	=> true,
        'publicly_queryable' 	=> true,
        'show_ui'            	=> true,
        'show_in_menu'       	=> true,
        'query_var'          	=> true,
        'rewrite'            	=> array( 'slug' => 'book' ),
        'map_meta_cap'    		=> true,
		'query_var'    			=> true,
		'delete_with_user'    	=> false,
		'can_export'    		=> true,
        //'capabilities'    	=> array(),
		'capability_type'    	=> 'post',
        'has_archive'        	=> true,
        'hierarchical'       	=> false,
        'menu_position'      	=> 5,
        'menu_icon'      		=> 'dashicons-lock',
        'supports'           	=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'post-formats' ),
		//'has_archive'    	=> 'archive-name',
		'taxonomies'    	=> array('category','post_tag')		
    );
    register_post_type($singular,$args);
}
add_action('init','azad_custom_post'); 
