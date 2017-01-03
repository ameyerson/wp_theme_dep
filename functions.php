
<?php
// ******************* enqueue scripts ****************** //

if (!is_admin()) add_action("wp_enqueue_scripts", "ameye_scripts_styles", 11);
function ameye_scripts_styles() {

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/jquery-1.11.0.min.js', null, null, false);
    wp_enqueue_script('jquery');
    wp_enqueue_script('modernizr', get_stylesheet_directory_uri() . '/assets/js/modernizr-2.6.2-respond-1.1.0.min.js', 'jquery', null, false);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js/libraries/bootstrap.min.js', 'jquery', null, true);

    wp_enqueue_script('main', get_stylesheet_directory_uri() . '/assets/js/scripts.js', 'jquery', null, true);

    wp_enqueue_style( 'master-stylesheet', get_template_directory_uri()."/style.css" );

}


require_once('includes/customizer.php');
require_once('includes/wp_bootstrap_navwalker.php');
require_once('includes/template-tags.php');
require_once('includes/options-social.php');


// ******************* Add Custom Menus ****************** //

add_theme_support( 'menus' );
register_nav_menu( 'primary', 'Primary Navigiation' );


// ******************* Add Post Thumbnails ****************** //

add_theme_support( 'post-thumbnails' );

if ( function_exists( 'add_image_size' ) ) {

  // add_image_size( 'grid-box-bkg', 380, 240, true);

}

add_theme_support( 'html5', array(
  'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
) );


// add_filter( 'jpeg_quality', create_function( '', 'return 80;' ) );

register_post_type('custom-posts', array(
   'label' => __('Custom Posts'),
   'labels' => array ('name' => 'Custom Posts', 
                      'singular_name' => 'Custom Post',
                      'add_new_item' => 'Add New Custom Post',
                      'edit_item' => 'Edit Custom Post',
                      'new_item' => 'New Custom Post',
                      'view_item' => 'View Custom Post'),
   'public' => true,
   'menu_position' => 5,
   'rewrite' => array('slug' => 'custom-post'),
   'has_archive' => true,
   'menu_icon' => 'dashicons-carrot',
   'supports' => array('title', 'editor', 'author', 'thumbnail', 'revisions', 'comments', 'page-attributes', 'excerpt' )

));

// ******************* Login Screen ****************** //
// Change login logo
add_action( 'login_enqueue_scripts', 'ameye_login_styles' );
function ameye_login_styles() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_theme_mod('theme_customizer_logo') ?>);
            background-size: 200px;
            height: 200px;
            width: 200px;
        }
    </style>
<?php }
// Change login logo url
function ameye_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'ameye_logo_url' );

// Change login logo title
function ameye_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'ameye_logo_url_title' );


// Callback function to insert 'styleselect' into the $buttons array
function ameye_mce_buttons_2( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'ameye_mce_buttons_2');

// Callback function to filter the MCE settings
function ameye_before_init_insert_formats( $init_array ) {  
  // Define the style_formats array
  $style_formats = array(  
    // Each array child is a format with it's own settings
    array(  
      'title' => 'Bootstrap Basic Table',  
      'selector' => 'table',  
      'classes' => 'table'
    ),
    array(  
      'title' => 'Bootstrap Striped Table',  
      'selector' => 'table',  
      'classes' => 'table-striped'
    ),
    array(  
      'title' => 'Bootstrap Bordered Table',  
      'selector' => 'table',  
      'classes' => 'table-bordered'
    ),
    array(  
      'title' => 'Bootstrap Hover Table',  
      'selector' => 'table',  
      'classes' => 'table-hover'
    ),
    array(  
      'title' => 'Bootstrap Condensed Table',  
      'selector' => 'table',  
      'classes' => 'table-condensed'
    ),

    array(  
      'title' => 'Blockquote Reverse',  
      'selector' => 'blockquote',  
      'classes' => 'blockquote-reverse'
    ),

    array(  
      'title' => 'Unstyled List',  
      'selector' => 'ul',  
      'classes' => 'list-unstyled'
    ),
    array(  
      'title' => 'Inline List',  
      'selector' => 'ul',  
      'classes' => 'list-inline'
    ),

    array(  
      'title' => 'Button Link',  
      'selector' => 'a',  
      'classes' => 'btn btn-default'
    ),

  );  

  // Insert the array, JSON ENCODED, into 'style_formats'
  $init_array['style_formats'] = json_encode( $style_formats );  
 
  return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'ameye_before_init_insert_formats' ); 

function ameye_excerpt( $length ) {
    if (is_search() ) {
        return 15;
    } else {
        return 50;
    }
}

function ameye_widgets_init() {
  register_sidebar( array(
    'name'          => 'Blog Sidebar',
    'id'            => 'sidebar-widgets',
    'description'   => 'Add widgets here to appear in your sidebar.',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
  ) );

  // register_sidebar( array(
  //   'name'          => 'Content Bottom 1',
  //   'id'            => 'bottom-widget-1',
  //   'description'   => 'Appears at the bottom of the content on posts and pages.',
  //   'before_widget' => '<section id="%1$s" class="widget %2$s">',
  //   'after_widget'  => '</section>',
  //   'before_title'  => '<h4 class="widget-title">',
  //   'after_title'   => '</h4>',
  // ) );

  // register_sidebar( array(
  //   'name'          => 'Content Bottom 2',
  //   'id'            => 'bottom-widget-2',
  //   'description'   => 'Appears at the bottom of the content on posts and pages.',
  //   'before_widget' => '<section id="%1$s" class="widget %2$s">',
  //   'after_widget'  => '</section>',
  //   'before_title'  => '<h4 class="widget-title">',
  //   'after_title'   => '</h4>',
  // ) );
}
add_action( 'widgets_init', 'ameye_widgets_init' );

function ameye_search_join( $join ) {
  global $wpdb;
  //* if main query and search...
  if( is_main_query() && is_search() )
  {
      //* join term_relationships, term_taxonomy, and terms into the current SQL where clause


      // $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';

    $join .=" LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id ";

    $join .= "
      LEFT JOIN
      (
          {$wpdb->term_relationships}
          INNER JOIN
              {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id
          INNER JOIN
              {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id

      )
      ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id ";
  }


  $join .=" LEFT JOIN {$wpdb->users} ON {$wpdb->posts}.post_author = {$wpdb->users}.ID ";

  // var_dump($join); die();

  return $join;
}
add_filter('posts_join', 'ameye_search_join' );

function ameye_search_where( $where ) {
    global $wpdb;

    if ( is_search() ) {

      // var_dump($where); die();


     $where .= " OR (
                     {$wpdb->term_taxonomy}.taxonomy IN( 'category', 'post_tag')
                       AND
                        {$wpdb->terms}.name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
                          AND ({$wpdb->posts}.post_status = 'publish'
                            OR {$wpdb->posts}.post_author = " . absint( get_current_user_id()) . " AND {$wpdb->posts}.post_status = 'private')
                 )";

      // var_dump($where); die();

      $where .= " OR (
                  {$wpdb->posts}.post_type IN( 'post')
                   AND 
                   {$wpdb->users}.display_name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
                     AND ({$wpdb->posts}.post_status = 'publish'
                       OR {$wpdb->posts}.post_author = " . absint( get_current_user_id()) . " AND {$wpdb->posts}.post_status = 'private')
            )";

      $where = preg_replace(
          "/\(\s*".$wpdb->posts.".post_content\s+LIKE\s*(\'[^\']+\')\s*\)/",
          "(".$wpdb->posts.".post_content LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'ameye_search_where' );

function ameye_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}

add_filter( 'posts_distinct', 'ameye_search_distinct' );
//Remove Emojii

/*
Plugin Name: Disable Emojis
Plugin URI: https://geek.hellyer.kiwi/plugins/disable-emojis/
Description: Disable Emojis
Version: 1.5
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/


/**
 * Disable the emoji's
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );  
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
