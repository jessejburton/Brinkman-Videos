<?php

/**
 * @package BrinkmanVideos
 *
**/
/*
Plugin Name: Baba Brinkman Videos
Plugin URI: https://www.burtonmediainc.com/plugins/brinkmanvideos
Description: A plugin created to add functionality for using the YouTube API to display video
             information and comments using shortcodes
Version: 1.0.0
Author: Jesse James Burton
Author URI: https://www.burtonmediainc.com
License: GPLv2 or Later
Text Domain: brinkman-videos
GIT: https://github.com/jessejburton/Brinkman-Reviews
*/

/* Include Styles */
function add_videos_plugin_styles() {
  wp_enqueue_style( 'brinkman-videos-styles', plugins_url('brinkman-videos.css',__FILE__ ), array(), '1.1', 'all');
}
add_action( 'wp_enqueue_scripts', 'add_videos_plugin_styles' );

/* Include Scripts */
function add_videos_plugin_script() {
  wp_enqueue_script( 'brinkman-videos-scripts', plugins_url('brinkman-videos.js',__FILE__ ), array(), '1.1', 'all', false);
}
add_action( 'wp_enqueue_scripts', 'add_videos_plugin_script' );

/**
 * Register comments shortcode
 *
 * @return null
 */
function burtonmedia_comments_shortcode() {
  add_shortcode( 'brinkman-comments', 'shortcode_comments' );
}
add_action( 'init', 'burtonmedia_comments_shortcode' );

/**
* Comments Shortcode Callback
* @param Array $atts
* @return string
*/
function shortcode_comments( $atts ) {
  global $wp_query,
         $post;

  $atts = shortcode_atts( array(
      'max_posts' => 1,
  ), $atts );

  $loop = new WP_Query( array(
      'posts_per_page'    => sanitize_title( $atts['max_posts'] ),
      'post_type'         => 'video',
      'orderby' => 'rand',
      'order' => 'DESC'
  ) );

// The Loop
if ( $loop->have_posts() ) {
	?><div class="brinkman-comments"><?php
    while ( $loop->have_posts() ) {
        $loop->the_post();
     require('templates/comment.php');
    }
	?></div><?php
} else {
    ob_start();
      echo 'No videos found';
    return ob_get_clean();
}

// Restore original Post Data
wp_reset_postdata();	

}

/**
 * Register Video Display Shortcode
 *
 * @return null
 */
function burtonmedia_video_display_shortcode() {
  add_shortcode( 'brinkman-videos', 'video_display_comments' );
}
add_action( 'init', 'burtonmedia_video_display_shortcode' );

/**
* Video Display Shortcode Callback
* @param Array $atts
* @return string
*/
function video_display_comments( $atts ) {
  global $wp_query,
         $post;

  $atts = shortcode_atts( array(
      'show' => 'featured',
      'max_posts' => 3
  ), $atts );

  $term_slugs = array( sanitize_title( $atts['show'] ) );

  $loop = new WP_Query( array(
      'posts_per_page'    => sanitize_title( $atts['max_posts'] ),
      'post_type'         => 'video',
      'orderby' => 'date',
      'order' => 'DESC',
      'tax_query'         => array( array(
          'taxonomy'  => 'shows',
          'field'     => 'slug',
          'terms'     => $term_slugs
      ) )
  ) );

  if( ! $loop->have_posts() ) {
    ob_start();
      echo 'No videos found';
    return ob_get_clean();
  }

  ob_start();
    ?>
    <style type="text/css">
        .video-grid {
          display: grid;
          grid-template-columns: 1fr 1fr 1fr;
          column-gap: 10px;
        }
        .video-container {
          position: relative;
          padding-bottom: 56.25%;
          height: 0;
          overflow: hidden;
        }

        .video-container iframe,
        .video-container object,
        .video-container embed {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
        }
        .video-link {
          text-align: center;
          margin-top: 15px;
        }
        .video-link a {
          color: black;
          transition: all .3s ease;
        }
        .video-link a:hover {
          color: #DD3333;
        }
      </style>
      <div class="video-grid">
    <?php
    while( $loop->have_posts() ) {
      $loop->the_post();
      require('templates/video.php');
    }
    ?> </div> <?php
  return ob_get_clean();

  wp_reset_postdata();

}

/**
* add Review Archive template page
* @param Array $atts
* @return string

function reviews_template( $template ) {
  if ( is_post_type_archive('reviews') ) {
    $theme_files = array('archive-reviews.php', 'brinkman-reviews/archive-reviews.php');
    $exists_in_theme = locate_template($theme_files, false);
    if ( $exists_in_theme != '' ) {
      return $exists_in_theme;
    } else {
      return plugin_dir_path(__FILE__) . 'archive-reviews.php';
    }
  }
  return $template;
}
add_filter('template_include', 'reviews_template');
*/

/* UTILITIES */
// Get Data from YouTube
function get_data_from_youtube($url){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  return json_decode($response, true);
}


?>