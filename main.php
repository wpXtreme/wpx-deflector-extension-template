<?php
/// @cond private
/**
 * Plugin Name:     Deflector extension template
 * Plugin URI:      https://wpxtre.me
 * Description:     Base template for extending Deflector. 
 * Version:         1.0.0
 * Author:          wpXtreme <info@wpxtre.me>
 * Author URI:      https://www.wpxtre.me
 * Text Domain:     wpx-deflector-extension-template
 * Domain Path:     localization
 *
 * WPX PHP Min: 5.2.4
 * WPX WP Min: 3.4
 * WPX MySQL Min: 5.0
 * WPX wpXtreme Min: 1.0.0.b4
 *
 */
/// @endcond

/* Avoid directly access. */
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

// wpXtreme kickstart logic
require_once( trailingslashit( dirname( __FILE__ ) ) . 'kickstart.php' );

// Engage this WPX plugin
wpxtreme_kickstart( __FILE__, 'WPXDeflectorExtensionTemplate', 'wpx-deflectorextensiontemplate.php', 'WPXDeflector' );

