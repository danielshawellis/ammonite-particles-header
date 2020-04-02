<?php
/**
 * Plugin Name:       Ammonite Particles Header
 * Description:       Adds header with particles.js background
 * Version:           1.0.0
 * Author:            Daniel Ellis
 * Author URI:        https://danielellisdevelopment.com/
 */

/*
  Basic Security
*/
if ( ! defined( 'ABSPATH' ) ) {
  die;
}

/*
  Plugin Base Class
*/
if ( !class_exists( 'Ammonite_Particles_Header' ) ) {
  class Ammonite_Particles_Header {
    public static function register_styles_and_scripts() {
      add_action( 'wp_enqueue_scripts', function() {
        // Remove jQuery dependency if unnecessary
        wp_register_script( 'ammonite-particles-header-script', plugins_url('assets/js/ammonite-particles-header.js', __FILE__ ), array(), '1.0.0', true );
        wp_register_style( 'ammonite-particles-header-styles', plugins_url('assets/css/ammonite-particles-header.css', __FILE__ ), array(), '1.0.0', 'all' );
      } );
    }

    public static function add_shortcode() {
      // Use [ammonite_particles_header header_text=""] to call this shortcode
      add_shortcode( 'ammonite_particles_header', function( $atts ) {
        // Handle shortcode attributes
        $atts = shortcode_atts( array( 'header_text' => '' ), $atts );

        // Enqueue styles and scripts wherever shortcode is called
        wp_enqueue_script( 'ammonite-particles-header-script' );
        wp_enqueue_style( 'ammonite-particles-header-styles' );

        // Localize data to script
        wp_localize_script( 'ammonite-particles-header-script', 'ammoniteParticlesHeaderLoacalizedData',
          array(
            'pathToJSONConfig' => plugins_url('assets/js/ammonite-particles-header-config.json', __FILE__ )
          )
        );

        // Return template
        ob_start();
        include( 'templates/ammonite-particles-header-shortcode-template.php' );
        return ob_get_clean();
      } );
    }
  }

  // Call methods on load here
  Ammonite_Particles_Header::register_styles_and_scripts();
  Ammonite_Particles_Header::add_shortcode();
}
