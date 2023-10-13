<?php
/*
Plugin Name: Iboora Simple Jobs Manager
Plugin URI: https://console.iboora.com
Description: Register and manage jobs and categories
Version: 1.0
Author: Eugy Enoch
Author URI: https://github.com/eugyenoch
Textdomain: kadence
License: GPLv2
*/



/* CREATE JOB CATEGORY */
// Register Hierarchical Taxonomy for Job Categories
function custom_register_job_category_taxonomy() {
    $labels = array(
        'name'                       => 'Job Categories',
        'singular_name'              => 'Job Category',
        'search_items'               => 'Search Job Categories',
        'all_items'                  => 'All Job Categories',
        'parent_item'                => 'Parent Job Category',
        'parent_item_colon'          => 'Parent Job Category:',
        'edit_item'                  => 'Edit Job Category',
        'update_item'                => 'Update Job Category',
        'add_new_item'               => 'Add New Job Category',
        'new_item_name'              => 'New Job Category Name',
        'menu_name'                  => 'Job Categories',
    );
    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'job-category'),
    );
    register_taxonomy('job_category', 'iboora_jobs', $args); // Associate with 'iboora_jobs' custom post type
}
add_action('init', 'custom_register_job_category_taxonomy');


// Register Non-Hierarchical Taxonomy for Job Tags
function custom_register_job_tag_taxonomy() {
    $labels = array(
        'name'                       => 'Job Tags',
        'singular_name'              => 'Job Tag',
        'search_items'               => 'Search Job Tags',
        'popular_items'              => 'Popular Job Tags',
        'all_items'                  => 'All Job Tags',
        'edit_item'                  => 'Edit Job Tag',
        'update_item'                => 'Update Job Tag',
        'add_new_item'               => 'Add New Job Tag',
        'new_item_name'              => 'New Job Tag Name',
        'separate_items_with_commas' => 'Separate Job tags with commas',
        'add_or_remove_items'        => 'Add or remove Job tags',
        'choose_from_most_used'      => 'Choose from the most used Job tags',
        'menu_name'                  => 'Job Tags',
    );
    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'job-tag'),
    );
    register_taxonomy('job_tag', 'iboora_jobs', $args); // Associate with 'iboora_jobs' custom post type
}
add_action('init', 'custom_register_job_tag_taxonomy');


/* CREATE THE JOB CUSTOM POST TYPE*/

function iboora_register_job_type() {
    $labels = array(
        'name' => __( 'Jobs', 'kadence' ),
        'singular_name' => __( 'Job', 'kadence' ),
        'menu_name'           => __( 'Jobs', 'kadence' ),
        'parent_item_colon'   => __( 'Parent Job', 'kadence' ),
        'add_new' => __( 'New Job', 'kadence' ),
        'add_new_item' => __( 'Add New Job', 'kadence' ),
        'edit_item' => __( 'Edit Job', 'kadence' ),
        'update_item'         => __( 'Update Job', 'kadence' ),
        'new_item' => __( 'New Job', 'kadence' ),
        'view_item' => __( 'View Jobs', 'kadence' ),
        'search_items' => __( 'Search Jobs', 'kadence' ),
        'not_found' =>  __( 'No Jobs Found', 'kadence' ),
        'not_found_in_trash' => __( 'No Jobs found in Trash', 'kadence' ),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'comments',
            'revisions',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'taxonomies' => array( 'job_category', 'job_tag' ), // Associate with taxonomies
        'rewrite'   => array( 'slug' => 'job' ),
        'show_in_rest' => true
    );

    register_post_type( 'iboora_jobs', $args );
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', 'iboora_register_job_type');
