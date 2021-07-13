<?php
/**
 * Contact-Lense Form
 *
 * @package     Contact-Lense Form
 * @author      Centric Data
 * @copyright   2021 Centric Data
 * @license     GPL-2.0-or-later
 *
*/
/*
Plugin Name: Contact-Lense Form
Plugin URI:  https://github.com/Centric-Data/contactlense
Description: This is a custom contact form plugin, it can be used in the contact page. Its using a two column layout, with custom css (no-blotted-frameworks)
Author: Centric Data
Version: 1.0.0
Author URI: https://github.com/Centric-Data
Text Domain: contactlense
*/
/*
Contact-Lense Form is free software: you can redistribute it and/or modify it under the terms of GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

Contact-Lense Form is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Contact-Lense Form.
*/

/* Exit if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define variable for path to this plugin file.
define( 'CLF_LOCATION', dirname( __FILE__ ) );
define( 'CLF_LOCATION_URL' , plugins_url( '', __FILE__ ) );
define( 'CLF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 *
 */
class ContactLenseForm
{

  public function __construct()
  {
    // Create Custom post type
    add_action( 'init', array($this, 'create_custom_post_type') );

    // Add Assets (js, css)
    add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ) );

  }

  public function create_custom_post_type()
  {
    $args = array(
      'public'      =>  true,
      'has_archive' =>  true,
      'supports'    =>  array('title'),
      'exclude_from_search' =>  true,
      'publicly_queryable'   =>  false,
      'capability'          =>  'manage_options',
      'labels'              =>  array(
        'name' => __( 'Contact Form', 'contactlense' ),
        'singular_name' => __( 'Contact Form Entry', 'contactlense' )
      ),
      'menu_icon'       =>  'dashicons-text',
    );
    register_post_type( 'contact_lense_form', $args );
  }

  public function load_assets()
  {
    wp_enqueue_style( 'contactlense-css', CLF_PLUGIN_URL . 'css/contactlense.css', [], time(), 'all' );
    wp_enqueue_script( 'contactlense-js', CLF_PLUGIN_URL . 'js/contactlense.js', [], time(), 'all' );
  }

}

new ContactLenseForm;


 ?>
