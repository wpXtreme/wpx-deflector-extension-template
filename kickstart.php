<?php
/**
 * This file is the kickstart used by any WPX plugin in order to check environment and boot itself
 *
 * @author     wpXtreme
 * @copyright  Copyright (C) 2013 wpXtreme Inc. All Rights Reserved.
 * @date       2013-02-06
 * @version    1.1.0
 * @since      1.0.0.b4
 *
 */


//-----------------------------------------------------------------------------------------
// Function wpxtreme_kickstart
//-----------------------------------------------------------------------------------------

if ( !function_exists( 'wpxtreme_kickstart' ) ) {
  /**
   * Check environment and boot WPX plugin
   *
   * @brief Check environment and boot WPX plugin
   */
  function wpxtreme_kickstart( $sMainFile, $sMainClassName, $sMainClassFile, $sClassFather = 'WPXtreme' ) {

    // Create function to boot plugin
    $fBoot = create_function( '',
       // Check all versions, and DO NOT PROCEED if some version is invalid
      'if( TRUE == wpxtreme_check_environment( \'' . $sMainFile . '\' )) {' .
      'require_once( trailingslashit( dirname( \'' . $sMainFile . '\' )) . basename( \'' . $sMainClassFile . '\' ));' .
      '$GLOBALS[\'' . $sMainClassName . '\'] = ' . $sMainClassName . '::boot( \'' . $sMainFile . '\' );' .
      '}' );

    // If I'm starting wpXtreme plugin, I immediately execute plugin boot
    // or, is it already booted the WPX plugin I belong to ?
    if ( isset( $GLOBALS[$sClassFather] ) || ( 'WPXtreme' == $sMainClassName ) ) {
      // In this case I can directly boot plugin
      $fBoot();
    }
    else {
      // I need to boot this plugin after the boot of WPX plugin father
      add_action( $sClassFather, $fBoot );
    }

    // Hook the 'wpxtreme_loaded' action ONLY if I'm not starting wpXtreme plugin.
    // For ALL other plugins: detect if WPXtreme is loaded in 'init' WP action
    if( 'WPXtreme' != $sMainClassName ) {

      // Create function to check wpXtreme global instance
      // Must be dynamic because I need to store the main file of plugin
      // See internal comment on wpxtreme_not_loaded function
      $fCheckWpxtremeGlobalInstance = create_function( '',
        'if ( !isset( $GLOBALS[\'WPXtreme\'] ) ) {' .
        '$GLOBALS[\'wpxtreme_notice_refers_to\'] = \'' . $sMainFile . '\';' .
        'add_action( \'admin_notices\', \'wpxtreme_not_loaded\' );' .
        '}' );

      add_action( 'init', $fCheckWpxtremeGlobalInstance );

    }

  }

}

//-----------------------------------------------------------------------------------------
// Function wpxtreme_environment_notices
//-----------------------------------------------------------------------------------------

if ( !function_exists( 'wpxtreme_environment_notices' ) ) {
  /**
   * Internal function used to show a custom message in admin area. Engaged in case of error
   * in checking environment.
   *
   * @brief Show a custom message in admin area
   *
   */
  function wpxtreme_environment_notices() {

    global $wp_version;

    $aNotice = array(

      'WPX_INVALID_WORDPRESS_VERSION' => sprintf( __('%s cannot be used because your WordPress version is %s, and it is lower than minimum requested for this plugin: %s.<br>To resolve this issue, it is <strong>strongly recommended</strong> to deactivate this plugin and upgrade your system.', WPDK_TEXTDOMAIN ),
        $GLOBALS['wpxtreme_notification_data']['name'] , $wp_version,
        $GLOBALS['wpxtreme_notification_data']['required_version'] ),

      'WPX_INVALID_PHP_VERSION' => sprintf( __('%s cannot be used because your PHP language version is %s, and it is lower than minimum requested for this plugin: %s.<br>To resolve this issue, it is <strong>strongly recommended</strong> to deactivate this plugin and upgrade your system.', WPDK_TEXTDOMAIN ),
        $GLOBALS['wpxtreme_notification_data']['name'], PHP_VERSION,
        $GLOBALS['wpxtreme_notification_data']['required_version'] ),

      'WPX_INVALID_MYSQL_VERSION' => sprintf( __('%s cannot be used because your MySQL database version is %s, and it is lower than minimum requested for this plugin: %s.<br>To resolve this issue, it is <strong>strongly recommended</strong> to deactivate this plugin and upgrade your system.', WPDK_TEXTDOMAIN ),
        $GLOBALS['wpxtreme_notification_data']['name'], mysql_get_server_info(),
        $GLOBALS['wpxtreme_notification_data']['required_version'] )

    );

    if( defined( 'WPXTREME_VERSION' )) {

      $aNotice['WPX_INVALID_WPXTREME_VERSION'] = sprintf( __('%s cannot be used because your wpXtreme framework version is %s, and it is lower than minimum requested for this plugin: %s.<br>To resolve this issue, it is <strong>strongly recommended</strong> to deactivate this plugin and upgrade your system.', WPDK_TEXTDOMAIN ),
        $GLOBALS['wpxtreme_notification_data']['name'], WPXTREME_VERSION,
        $GLOBALS['wpxtreme_notification_data']['required_version'] );

    }

    ?>
  <div id="message" class="error">
    <h3><?php echo $GLOBALS['wpxtreme_notification_data']['name']; ?> - WARNING!</h3>

    <p><?php echo $aNotice[$GLOBALS['wpxtreme_notification_data']['type']]; ?></p>
  </div>
  <?php

  }

}

//-----------------------------------------------------------------------------------------
// Function wpxtreme_check_environment
//-----------------------------------------------------------------------------------------

if ( !function_exists( 'wpxtreme_check_environment' ) ) {

  /**
   * Do all checks for minimum WP, PHP, MySQL and wpXtreme version needed by this plugin
   *
   * @brief Check environment
   *
   * @return bool
   */
  function wpxtreme_check_environment( $sMainFile ) {

    global $wp_version;

    // If I already have a version notice pending, don't reset array of data!
    if( !isset( $GLOBALS['wpxtreme_notification_flag'] )) {
      $GLOBALS['wpxtreme_notification_data'] = array();
    }

    // Get WPX custom metadata from header
    $cPluginData = new WPDKPlugin( $sMainFile );
    $aWPXMetadata = array( 'WPX wpXtreme Min' => '', 'WPX WP Min' => '', 'WPX PHP Min' => '', 'WPX MySQL Min' => '' );
    $aWPXMetadata = $cPluginData->readMetadata( $aWPXMetadata );

    //------------------------------------------------------------------------------------------------
    // if wpXtreme framework needed for this plugin is greater than current wpXtreme in this system
    //------------------------------------------------------------------------------------------------

    if( !empty( $aWPXMetadata['WPX wpXtreme Min'] )) {

      $sWpxtremeRequested = $aWPXMetadata['WPX wpXtreme Min'];
      if ( TRUE == version_compare( $sWpxtremeRequested, WPXTREME_VERSION , '>' ) ) {

        // this plugin can't be activated because wpXtreme is not updated to the minimum required version
        $GLOBALS['wpxtreme_notification_data'] = array(
                                                  'name' => $cPluginData->name,
                                                  'type' => 'WPX_INVALID_WPXTREME_VERSION',
                                                  'required_version' => $sWpxtremeRequested
                                                 );

        // Notice on WP environment
        if( !isset( $GLOBALS['wpxtreme_notification_flag'] )) {
          add_action( 'admin_notices', 'wpxtreme_environment_notices' );
          $GLOBALS['wpxtreme_notification_flag'] = TRUE;
        }

        return FALSE;

      }
    }

    //------------------------------------------------------------------------------------------------
    // if WordPress needed for this plugin is greater than current WordPress in this system
    //------------------------------------------------------------------------------------------------

    if( !empty( $aWPXMetadata['WPX WP Min'] )) {

      // if WordPress needed for this plugin is greater than actual WordPress in this system
      $sWordPressRequested = $aWPXMetadata['WPX WP Min'];
      if ( TRUE == version_compare( $sWordPressRequested, $wp_version, '>' ) ) {

        // this plugin can't be activated because WordPress is not updated to the minimum required version
        $GLOBALS['wpxtreme_notification_data'] = array(
                                                  'name' => $cPluginData->name,
                                                  'type' => 'WPX_INVALID_WORDPRESS_VERSION',
                                                  'required_version' => $sWordPressRequested
                                                 );

        // Notice on WP environment
        if( !isset( $GLOBALS['wpxtreme_notification_flag'] )) {
          add_action( 'admin_notices', 'wpxtreme_environment_notices' );
          $GLOBALS['wpxtreme_notification_flag'] = TRUE;
        }

        return FALSE;

      }
    }

    //------------------------------------------------------------------------------------------------
    // if PHP needed for this plugin is greater than current PHP in this system
    //------------------------------------------------------------------------------------------------

    if( !empty( $aWPXMetadata['WPX PHP Min'] )) {

      $sPHPRequested = $aWPXMetadata['WPX PHP Min'];
      if ( TRUE == version_compare( $sPHPRequested, PHP_VERSION, '>' ) ) {

        // this plugin can't be activated because PHP is not updated to the minimum required version
        $GLOBALS['wpxtreme_notification_data'] = array(
                                                  'name' => $cPluginData->name,
                                                  'type' => 'WPX_INVALID_PHP_VERSION',
                                                  'required_version' => $sPHPRequested
                                                 );

        // Notice on WP environment
        if( !isset( $GLOBALS['wpxtreme_notification_flag'] )) {
          add_action( 'admin_notices', 'wpxtreme_environment_notices' );
          $GLOBALS['wpxtreme_notification_flag'] = TRUE;
        }

        return FALSE;

      }
    }

    //------------------------------------------------------------------------------------------------
    // if MySQL needed for this plugin is greater than current MySQL in this system
    //------------------------------------------------------------------------------------------------

    if( !empty( $aWPXMetadata['WPX MySQL Min'] )) {

      $sMySQLRequested = $aWPXMetadata['WPX MySQL Min'];
      $sMySQLRunning   = mysql_get_server_info();
      if ( TRUE == version_compare( $sMySQLRequested, $sMySQLRunning, '>' ) ) {

        // This plugin can't be activated because MySQL is not updated to the minimum required version
        $GLOBALS['wpxtreme_notification_data'] = array(
                                                  'name' => $cPluginData->name,
                                                  'type' => 'WPX_INVALID_MYSQL_VERSION',
                                                  'required_version' => $sMySQLRequested
                                                 );

        // Notice on WP environment
        if( !isset( $GLOBALS['wpxtreme_notification_flag'] )) {
          add_action( 'admin_notices', 'wpxtreme_environment_notices' );
          $GLOBALS['wpxtreme_notification_flag'] = TRUE;
        }

        return FALSE;

      }
    }

    return TRUE;

  }

}

//-----------------------------------------------------------------------------------------
// Functions wpxtreme_not_loaded
//-----------------------------------------------------------------------------------------

if ( !function_exists( 'wpxtreme_not_loaded' )) {

  /**
   * Display the admin notices when WPXtreme is NOT loaded
   *
   * @brief Admin notice
   */
  function wpxtreme_not_loaded() {
    if ( !function_exists( 'get_plugin_data' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    // Here I can't use __FILE__, because it refers to the first require_once path of kickstart.php
    $result = get_plugin_data( trailingslashit( dirname( $GLOBALS['wpxtreme_notice_refers_to'] ) ) . 'main.php', false );

    ?>
  <div id="message" class="error">
    <h2 style="font-weight: bold;text-decoration: blink"><img style="vertical-align: middle"
                                                              alt="<?php _e( 'Warning' ) ?>"
                                                              src="data:image/png;base64,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"/>WARNING!
    </h2>

    <h3 style="color:#a00">The plugin
      <strong style="background-color: #a00;color: #fff;padding: 4px 8px 2px;border-radius: 3px"><?php echo $result['Name'] ?></strong>
                           needs <a href="https://wpxtre.me">wpXtreme Framework plugin</a> <em>up and running</em> in
                           order to properly work.</h3>

    <h3 style="color:#a00">Also, if you have installed <strong>other</strong> WPX plugins, be careful because they have
                           the same requirement!</h3>
  </div>
  <?php
  }

}
