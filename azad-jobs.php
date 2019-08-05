<?php
/*
Plugin Name: Azad Jobs
Description: Description will go here...
Plugin URi: gittechs.com/plugin/azad-custom-login 
Author: Md. Abul Kalam Azad
Author URI: gittechs.com/author
Author Email: webdevazad@gmail.com
Version: 0.0.0.1
Text Domain: azad-jobs
*/ 
// EXIT IF ACCESSED DIRECTLY
defined('ABSPATH') || exit;

if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    //require_once (dirname(__FILE__) . '/vendor/autoload.php');
}
//use Inc\Activate;
require_once (plugin_dir_path(__FILE__) . '/azad-jobs-fields.php');
require_once (plugin_dir_path(__FILE__) . '/azad-jobs-post.php');
require_once (plugin_dir_path(__FILE__) . '/azad-jobs-admin.php');

function dwwp_enqueue_scripts(){	
    global $pagenow, $typenow;
    //$screen = get_current_screen();
    //var_dump($screen);
    if($typenow == 'job'){
        wp_register_style('azad-jobs', plugins_url('assets/css/jobs.min.css',__FILE__), null, '123', 'all');
        wp_enqueue_style('azad-jobs');
    }
    if($pagenow == 'post.php' || $pagenow == 'post-new.php' && $typenow == 'job'){        
        wp_register_script('azad-jobs', plugins_url('assets/js/jobs.js',__FILE__), array('jquery','jquery-ui-datepicker'), '123', true );
        wp_enqueue_script('azad-jobs');

        wp_register_style('jquery-ui-datepicker', plugins_url('assets/css/jqueryui.css',__FILE__), null, '123', 'all' );
        wp_enqueue_style('jquery-ui-datepicker');

        wp_register_script('dwwp-custom-quicktags', plugins_url('assets/js/quicktags.js',__FILE__), array('quicktags'), '123', true );
        wp_enqueue_script('dwwp-custom-quicktags');
    }
    if($pagenow == 'edit.php' && $typenow == 'job'){
        wp_register_script('azad-reorder', plugins_url('assets/js/reorder.js',__FILE__), array('jquery','jquery-ui-sortable'), '123', true );
        wp_enqueue_script('azad-reorder');
    }
}
add_action('admin_enqueue_scripts','dwwp_enqueue_scripts');
function dwwp_add_submenu_page(){	
    add_submenu_page(
        'edit.php?post_type=job',
        'Reorder Jobs',
        'Reorder Jobs',
        'manage_options',
        'reorder_jobs',
        'reorder_jobs_callback',
    );
}
add_action('admin_menu','dwwp_add_submenu_page');
function reorder_jobs_callback(){
    $args = array(
        'post_type' => 'job',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => true,
        'update_post_term_cache' => false,
        'post_per_page' => 50
    );
    $jobs = new WP_Query($args);
    ?>
    <div class="wrap">    
        <div id="wrap" class="job-sort">
            <div id="icon-job-admin" class="icon32"><br /></div>
                <h1><?php echo esc_html(get_admin_page_title()); ?>
                    <img src="<?php echo esc_url(admin_url()) . 'images/loading.gif'; ?>" id="loading-animation">
                </h1>
                <p><?php _e('<strong>Note:</strong> This only affects teh You can write any there iadfasd asdfas ','asdf'); ?></p>
                <ul id="custom-type-list">
                    <?php if($jobs->have_posts()) : while($jobs->have_posts()) : $jobs->the_post(); ?>
                        <li id="<?php the_id(); ?>"><?php the_title(); ?></li>
                    <?php endwhile; else: _e('You have no jobs to sort.','asdf'); endif; ?>
                </ul>
            </div>
        </div>
    <?php
}
