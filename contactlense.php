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
Plugin URI:  https://github.com/Centric-Data/contactlands
Description: This is a custom contact form plugin, it can be used in the contact page. Its using a two column layout, with custom css (no-blotted-frameworks)
Author: Centric Data
Version: 1.0.0
Author URI: https://github.com/Centric-Data
Text Domain: contactlands
*/
/*
Contact-Lense Form is free software: you can redistribute it and/or modify it under the terms of GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

Contact-Lense Form is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Contact-Lense Form.
*/

/* Exit if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

// Define variable for path to this plugin file.
define( 'CLF_LOCATION', dirname( __FILE__ ) );
define( 'CLF_LOCATION_URL' , plugins_url( '', __FILE__ ) );

 ?>