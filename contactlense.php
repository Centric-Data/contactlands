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
    add_action( 'init', array( $this, 'clf_create_custom_post_type' ) );

    add_action( 'add_meta_boxes', array( $this, 'clf_enquiry_add_meta_box' ) );

    // Add Assets (js, css)
    add_action( 'wp_enqueue_scripts', array( $this, 'clf_load_assets' ) );

    // Add shortcode
    add_shortcode( 'contact-lense', array( $this, 'clf_load_shortcode' ) );

    // Load Javascript
    add_action( 'wp_footer', array( $this, 'clf_load_scripts' ) );

    //  Register REST API
    add_action( 'rest_api_init', array( $this, 'clf_register_rest_api' ) );

  }

  /**
  * Register a custom post type called 'centric_enquire'
  *
  */
  public function clf_create_custom_post_type()
  {
    $args = array(
      'public'                =>  true,
      'has_archive'           =>  true,
      'hierarchical'          =>  false,
      'supports'              =>  array('title','editor','author'),
      'exclude_from_search'   =>  true,
      'publicly_queryable'    =>  false,
      'capability_type'       =>  'post',
      'labels'                =>  array(
        'name'                => __( 'Enquries', 'contactlense' ),
        'singular_name'       => __( 'Form Enquiry', 'contactlense' ),
        'menu_name'           => _x( 'Enquries', 'Admin Menu text', 'contactlense' ),
        'add_new'             => __( 'Add New', 'contactlense' ),
        'add_new_item'        => __( 'Add New Enquiry', 'contactlense' ),
        'new_item'            => __( 'New Enquiry', 'contactlense' ),
        'edit_item'           => __( 'Edit Enquiry', 'contactlense' ),
        'view_item'           => __( 'View Enquiry', 'contactlense' ),
        'all_items'           => __( 'All Enquiries', 'contactlense' )
      ),
      'menu_icon'       =>  'dashicons-email',
    );
    register_post_type( 'centric_enquire', $args );
  }

  // Enqueue Scripts
  public function clf_load_assets()
  {
    wp_enqueue_style( 'contactlense-css', CLF_PLUGIN_URL . 'css/contactlense.css', [], time(), 'all' );
    wp_enqueue_script( 'contactlense-js', CLF_PLUGIN_URL . 'js/contactlense.js', ['jquery'], time(), 1 );
  }

  // Shortcode function
  public function clf_load_shortcode()
  {?>
    <section>
    	<div class="contact__wrapper lense-row">
    		<h4><?php echo esc_html__( 'Contact Us', 'contactlense' ); ?></h4>
    		<p><?php echo esc_html__( 'We’re here to help and answer any question you might have. We look forward to hearing from you', 'contactlense' ); ?></p>
    		<div class="contact__layout">
    			<div class="contact__layout--top">
    				<div class="top__left">
    					<h5><?php echo esc_html__( 'Contact Information', 'contactlense' ); ?></h5>
    					<div class="top__left--card">
    						<div class="card--info">
    							<div class="card--icon">
    								<span class="material-icons">room</span>
    							</div>
    							<div class="card--details">
    								<p>
    								The Zimbabwe Land Commission <br>
    								19280 Borrowdale Road <br>
    								Block 1, Celestial Park, Harare <br>
    								Private Bag CY7771, Harare, Zimbabwe
    								</p>
    							</div>
    						</div>
    						<div class="card--info">
    							<div class="card--icon">
    								<span class="material-icons">phone</span>
    							</div>
    								<div class="card--details">
    									<p>+263-242- 774604</p>
    								</div>
    						</div>
    						<div class="card--info">
    							<div class="card--icon">
    								<span class="material-icons">mail</span>
    							</div>
    							<div class="card--details">
    								<p>info@zlc.co.zw</p>
    							</div>
    						</div>
    					</div>
    				</div>
    				<div class="top__right">
    					<h3><?php echo esc_html__( 'Get In Touch.', 'contactlense' ); ?></h3>
    					<div class="form__wrapper">
    						<form id="cf_form">
    							<input id="cf_fullname" type="text" name="fullname" placeholder="Fullname">
    							<input id="cf_email" type="email" name="email" placeholder="Email">
                  <input id="cf_telno" type="tel" name="phone" placeholder="Phone Number">
    							<textarea id="cf_message" rows="5" cols="33" name="message" placeholder="Message">Message</textarea>
    							<button type="submit" id="cf_submit">Send Message</button>
    						</form>
    					</div>
    				</div>
    			</div>
    			<div class="contact__layout--bottom">

          </div>
    		</div>
    	</div>
    </section>
  <?php }

  // Run Script on Submit
  public function clf_load_scripts()
  {?>
    <script>

    let nonce = '<?php echo wp_create_nonce('wp_rest'); ?>';

      ( function($){
        $( '#cf_form' ).on("submit", function( e ) {
          e.preventDefault();
          var form = $( this ).serialize();
          console.log( form );

          $.ajax({
            method:'post',
            url: '<?php echo get_rest_url( null, 'contactlense/v1/send-email' ); ?>',
            headers: { 'X-WP-Nonce': nonce },
            data: form
          })
        });
      } )(jQuery)
    </script>
  <?php }

  public function clf_register_rest_api()
  {
    register_rest_route( 'contactlense/v1', 'send-email', array(
        'methods' => 'POST',
        'callback' => array( $this, 'handle_contact_form' )
    )  );
  }

  public function handle_contact_form($data)
  {
    $headers = $data->get_headers();
    $params = $data->get_params();

    $nonce = $headers[ 'x_wp_nonce' ][0];

    //  Verify Nonce
    if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) )
    {
      return new WP_REST_Response( 'Message not sent', 422 );
    }

    $post_id = wp_insert_post( [
        'post_type' => 'centric_enquire',
        'post_title' => wp_strip_all_tags( $params['fullname'] ),
        'post_content'  =>  wp_strip_all_tags( $params['message'] ),
        'post_status' => 'publish'
      ] );

      add_post_meta( $post_id, '_clf_email_meta_key', $params['email'] );
      add_post_meta( $post_id, '_clf_phone_meta_key', $params['phone'] );
      // Message success message
      if ( $post_id )
      {
        return new WP_REST_Response( $params['fullname'], 200 );

      }
  }

  // Enquiry Meta Boxes
  public function clf_enquiry_add_meta_box() {
    add_meta_box( 'enquiry_email', 'User Email', 'clf_enquiry_email_callback', 'centric_enquire', 'side', 'default'  );
    add_meta_box( 'enquiry_phone', 'User Phone', 'clf_enquiry_phone_callback', 'centric_enquire', 'side', 'default' );
  }

}

new ContactLenseForm;

// Custom Enquiry Columns
function clf_enquiry_columns( $columns ) {

  $newColumns = array();
  $newColumns['title'] = 'Fullname';
  $newColumns['message'] = 'Message';
  $newColumns['email'] = 'Email';
  $newColumns['phone'] = 'Phone';
  $newColumns['date'] = 'Date';

  return $newColumns;
}
add_filter( 'manage_centric_enquire_posts_columns', 'clf_enquiry_columns' );

// Manage Custom Column Data
add_action( 'manage_centric_enquire_posts_custom_column', 'clf_enquiry_custom_column', 10, 2 );
function clf_enquiry_custom_column( $column, $post_id  ){
  switch ( $column ) {
    case 'message':
      echo get_the_excerpt();
      break;
    case 'email':
      $email = get_post_meta( $post_id, '_clf_email_meta_key', true);
      echo '<a href="mailto:'.$email.'">'.$email.'</a>';
      break;
    case 'phone':
      $phone = get_post_meta( $post_id, '_clf_phone_meta_key', true );
      echo $phone;
      break;

    default:
      // code...
      break;
  }
}

// Meta box callback functions
function clf_enquiry_email_callback( $post ) {
  $value = get_post_meta( $post->ID, '_clf_email_meta_key', true);
  ?>
    <label for="user_email">Email</label>
    <input type="email" id="clf_email_data" name="clf_email_data" value="<?php echo esc_attr( $value ); ?>">
  <?
}

function clf_enquiry_phone_callback( $post ) {
  $value = get_post_meta( $post->ID, '_clf_phone_meta_key', true );
  ?>
  <label for="user_phone">Phone Number</label>
  <input type="tel" id="clf_phone_data" name="clf_phone_data" value="<?php echo esc_attr( $value ); ?>">
  <?
}

/**
* Save data on Meta box input fields
*
*/
function clf_save_email_phone_data( $post_id ) {
  if( ! current_user_can( 'edit_post', $post_id ) ){
    return;
  }
  if ( array_key_exists( 'clf_email_data', $_POST ) ) {
    $my_email_data = sanitize_text_field( $_POST[ 'clf_email_data' ] );
    update_post_meta( $post_id, '_clf_email_meta_key', $my_email_data );
  }
  if ( array_key_exists( 'clf_phone_data', $_POST ) ) {
    $my_phone_data = sanitize_text_field( $_POST[ 'clf_phone_data' ] );
    update_post_meta( $post_id, '_clf_phone_meta_key', $my_phone_data );
  }
}
add_action( 'save_post', 'clf_save_email_phone_data' );

 ?>
