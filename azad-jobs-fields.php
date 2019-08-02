<?php
// EXIT IF ACCESSED DIRECTLY
function dwwp_custom_meta_box(){
    add_meta_box(
        'dwwp_meta',
        'Job Listing',
        'dwwp_meta_callback',
        'job',
        'normal',
        'core'
    );
}
// THIS CAN BE WRITTEN IN add_action('after_setup_theme','text_domain_name');
add_action('add_meta_boxes','dwwp_custom_meta_box'); 

function dwwp_meta_callback($post){
    wp_nonce_field(basename(__FILE__),'dwwp_jobs_nonce');
    $dwwp_stored_meta = get_post_meta($post->ID);
    ?>
        <div class="">
            <div class="meta-row">
                <div class="meta-th">
                    <label for="job-id" class="dwwp-row-title">Job ID</label>
                </div>            
                <div class="meta-td">
                    <input type="text" id="job-id" name="job_id" value="<?php if( ! empty($dwwp_stored_meta['job_id']) ) echo esc_attr($dwwp_stored_meta['job_id'][0]); ?>"/>
                </div>            
            </div>
            <div class="meta-row">
                <div class="meta-th">
                    <label for="date-listed" class="dwwp-row-title">Date Listed</label>
                </div>            
                <div class="meta-td">
                    <input type="text" id="date-listed" class="dwwp-row-content datepicker" name="date_listed" value="<?php if( ! empty($dwwp_stored_meta['date_listed']) ) echo esc_attr($dwwp_stored_meta['date_listed'][0]); ?>"/>
                </div>            
            </div>
            <div class="meta-row">
                <div class="meta-th">
                    <label for="application-deadline" class="dwwp-row-title">Application Deadline</label>
                </div>            
                <div class="meta-td">
                    <input type="text" id="application-deadline" class="dwwp-row-content datepicker" name="application_deadline" value="<?php if( ! empty($dwwp_stored_meta['application_deadline']) ) echo esc_attr($dwwp_stored_meta['application_deadline'][0]); ?>"/>
                </div>            
            </div>
            <div class="meta-row">
                <div class="meta-th">
                    <label for="principal-duties" class="dwwp-row-title">Principal Duties</label>
                </div>            
                <div class="meta-td">
                <?php
                    $content = get_post_meta($post->ID,'principal_duties',true); 
                    $editor = 'principal_duties'; 
                    $settings = array(
                        'textarea_rows'=>8,
                        'media_buttons'=>false
                    ); 
                    wp_editor($content,$editor,$settings); 
                ?>
                </div>            
            </div>
            <div class="meta-row">
                <div class="meta-th">
                    <span>Preferred Requirements</span>
                </div>            
                <div class="meta-td">
                    <textarea id="preferred-requirements" name="preferred_requirements" ><?php if( ! empty($dwwp_stored_meta['preferred_requirements']) ) echo esc_attr($dwwp_stored_meta['preferred_requirements'][0]); ?></textarea>                    
                </div>            
            </div>
            <div class="meta-row">
                <div class="meta-th">
                    <label for="relodcation-assistance" class="dwwp-row-title">Relocation Assistance</label>
                </div>            
                <div class="meta-td">
                    <select name="relocation_assistance" id="relocation-assistance" >
                        <option value="select-yes">Yes</option>
                        <option value="select-no">No</option>
                    </select>
                </div>            
            </div>
        </div>
    <?php
}
function dwww_meta_save($post_id){
    // Check save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['dwwp_jobs_nonce']) && wp_verify_nonce($_POST['dwwp_jobs_nonce'],basename(__FILE__))) ? 'true' : 'false';

    // Exit script depending on save status
    if($is_autosave || $is_revision || ! $is_valid_nonce){
        return;
    }
    if(isset($_POST['job_id'])){
        update_post_meta( $post_id, 'job_id', sanitize_text_field($_POST['job_id']));
    }
    if(isset($_POST['date_listed'])){
        update_post_meta( $post_id, 'date_listed', sanitize_text_field($_POST['date_listed']));
    }
    if(isset($_POST['application_deadline'])){
        update_post_meta( $post_id, 'application_deadline', sanitize_text_field($_POST['application_deadline']));
    }
    if(isset($_POST['principal_duties'])){
        update_post_meta( $post_id, 'principal_duties', sanitize_text_field($_POST['principal_duties']));
    }
    if(isset($_POST['preferred_requirements'])){
        update_post_meta( $post_id, 'preferred_requirements', sanitize_text_field($_POST['preferred_requirements']));
    }
    if(isset($_POST['relocation_assistance'])){
        update_post_meta( $post_id, 'relocation_assistance', sanitize_text_field($_POST['relocation_assistance']));
    }        
}
add_action('save_post','dwww_meta_save'); 