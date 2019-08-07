<?php
defined('ABSPATH') || exit;
function azad_jobs_shortcode($atts,$content=null){
    $atts = shortcode_atts(array(
        'title'         => 'Default title',
        'count'         => 2,
        'location'      => '',
        'pagination'    => false
    ),$atts);
    $locations = get_terms('locations');
    if( ! empty($locations) && ! is_wp_error($locations)):

        $displaylist .= '<div class="job-location-list">';
        $displaylist .= '<h2 class="list">'.esc_html__($atts['title']).'</h2><ul class="">';
        
        foreach($locations as $location) :
            $displaylist .= '<li class="job-location">';
            $displaylist .= '<a href="'. get_term_link($location) .'">';
            $displaylist .= esc_html__($location->name);
            $displaylist .= '</a></li>';
        endforeach;

        $displaylist .= '<ul></div>';
    else:
        $displaylist = 'No location found.';
    endif;
    return $displaylist;
}
add_shortcode('job_listing','azad_jobs_shortcode');

function azad_list_jobs_shortcode($atts,$content=null){
    if(! isset($atts['locations'])){
        return '<p class="job-error"> You must provide a location for this shortcode to work.</p>';
    }
    $atts = shortcode_atts(array(
        'title'         => 'Default title',
        'count'         => 2,
        'locations'     => '',
        'pagination'    => false
    ),$atts);

    $paged = get_query_var ('paged') ? get_query_var('paged') : 1;

    $args = array(
        'post_type'         => 'job',
        'post_status'       => 'publish',
        'no_found_rows'     => $atts['pagination'],
        'posts_per_page'    => $atts['count'],
        'paged'             => $paged,
        'tax_query'         =>array(
            array(
                'taxonomy'  => 'locations',
                'field'     => 'slug',
                'terms'     => $atts['locations'],
            )
        )
    );
    $jobs_by_locations = new WP_Query($args);
    //var_dump($jobs_by_locations->get_posts());

    if( $jobs_by_locations->have_posts()):
        $display_by_locations = '<div class="display-by-location"><h4>'.$atts['title'].'</h4><ul>';

        while($jobs_by_locations->have_posts()) : $jobs_by_locations->the_post();
            global $post;
            $deadline   = get_post_meta(get_the_ID(),'application_deadline',true);
            $title      = get_the_title();
            $slug      = get_permalink();
            $display_by_locations .= '<li class="jobs-listing">';
            $display_by_locations .= sprintf('<a href="%s">%s</a> ',esc_url($slug),esc_html__($title));
            $display_by_locations .= '<span>' . esc_html($deadline) . '</span>';
            $display_by_locations .= '</li>';
        endwhile;
        
        $display_by_locations .= '</ul></div>';
    else:
        $display_by_locations .= 'No jobs fund.';
    endif;
    wp_reset_postdata();

    if($display_by_locations->max_num_pages > 1 && is_page()){
        $display_by_locations .= '<nav class="prev-next-posts">';
        $display_by_locations .= '<div class="nav-previous">';
        $display_by_locations .= get_next_posts_link(__('<span class="meta-mav">&larr</span> Previous'),$display_by_locations->max_num_pages);
        $display_by_locations .= '<div class="next-posts-link">';
        $display_by_locations .= get_previous_posts_link(__('<span class="meta-mav">&rarr</span> Next'));
        $display_by_locations .= '</div>';
        $display_by_locations .= '</nav>';
    }
    return $display_by_locations;    
}
add_shortcode('jobs_by_location','azad_list_jobs_shortcode');

function azad_template($original_template){
    if(get_query_var('post_type') !== 'job'){
        return;
    }
    if(is_archive() || is_search()){
        if(file_exists(get_stylesheet_directory().'/archive-job.php')){
            return get_stylesheet_directory() . '/archive-job.php';
        }else{
            return plugin_dir_path(__FILE__) . 'templates/archive-job.php';
        }
    }else{
        if(file_exists(get_stylesheet_directory().'/single-job.php')){
            return get_stylesheet_directory() . '/single-job.php';
        }else{
            return plugin_dir_path(__FILE__) . 'templates/single-job.php';
        }
    }   
    return $original_template;
}
add_action('template_include','azad_template');