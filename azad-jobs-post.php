<?php
/* 

*/ 

// EXIT IF ACCESSED DIRECTLY
/**
*----------------------------------------------------------------------------------------------------------------------
* :: STATIC CUSTOM POST
*----------------------------------------------------------------------------------------------------------------------
*/
function dwwp_custom_post(){
    // POST TYPES FOR BOOKS (YOU CAN COPY THIS AS MUCH AS YOU NEED)
    $singular = apply_filters('custom_post','book');
    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'quick_start_dev_pack' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'quick_start_dev_pack' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'quick_start_dev_pack' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
        'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
        'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
        'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
        'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
        'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
        'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
        'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
        'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
        'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
    );
    $args = array(
        'labels'                => $labels,
        'description'		=> __( 'Description.', 'your-plugin-textdomain' ),
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
		'taxonomies'    	=> array('category','post_tag'),
		
    );
    register_post_type('job',$args);
}
// THIS CAN BE WRITTEN IN add_action('after_setup_theme','text_domain_name');
add_action('init','dwwp_custom_post'); 
