<?php
/**
 * Brief Description here
 *
 * ## Overview
 * Markdown here
 *
 * @class              WPXDeflectorExtensionTemplateAdmin
 * @author             wpXtreme <info@wpxtre.me>
 * @copyright          Copyright 2013- wpXtreme inc.
 * @date               2013-03-15 10:05:09
 * @version            0.1.0
 *
 */

class WPXDeflectorExtensionTemplateAdmin extends WPDKWordPressAdmin {

  /**
   * This is the minumun capability required to display admin menu item
   *
   * @brief Menu capability
   */
  const MENU_CAPABILITY = 'manage_options';


  /**
   * Create and return a singleton instance of WPXDeflectorExtensionTemplateAdmin class
   *
   * @brief Init
   *
   * @param WPXDeflectorExtensionTemplate $plugin The main class of this plugin.
   *
   * @return WPXDeflectorExtensionTemplateAdmin
   */
  public static function init( WPXDeflectorExtensionTemplate $plugin ) {
    static $instance = null;
    if ( is_null( $instance ) ) {
      $instance = new WPXDeflectorExtensionTemplateAdmin( $plugin );
    }
    return $instance;
  }



  /**
   * Create an instance of WPXDeflectorExtensionTemplateAdmin class
   *
   * @brief Construct
   *
   * @param WPXDeflectorExtensionTemplate $plugin Main class of your plugin
   *
   * @return WPXDeflectorExtensionTemplateAdmin
   */
  public function __construct( WPXDeflectorExtensionTemplate $plugin ) {
    parent::__construct( $plugin );

    /* Loading Script & style for backend */
    add_action( 'admin_head', array( $this, 'admin_head' ) );

    // Hook to plugin list in order to catch deactivation click
    add_action( 'plugin_action_links_' . $this->plugin->pluginBasename, array( $this, 'plugin_action_links' ) );

  }

  /**
   * Called by WPDKWordPressAdmin parent when the admin head is loaded
   *
   * @brief Admin head
   */
  public function admin_head() {

    /* Scripts */
    wp_enqueue_script( 'wpx-deflectorextensiontemplate-admin',
      $this->plugin->javascriptURL . 'wpx-deflectorextensiontemplate-admin.js', array( 'jquery' ), $this->plugin->version, true );

    wp_enqueue_style( 'wpx-deflectorextensiontemplate-plugins-list',
      $this->plugin->cssURL . 'plugins-list.css' );
    wp_enqueue_style( 'wpx-deflectorextensiontemplate-admin', $this->plugin->cssURL . 'wpx-deflectorextensiontemplate-admin.css' );
  }

  /**
   * Called when WordPress is ready to build the admin menu.
   * Sample hot to build a simple menu.
   *
   * @brief Admin menu
   */
  public function admin_menu() {

    /* Hack for wpXtreme icon. */
    $icon_menu = $this->plugin->imagesURL . 'logo-16x16.png';

    $menus = array(
      'deflectorextensiontemplatemenu_sample' => array(
        'menuTitle'  => __( 'Deflector extension', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
        'pageTitle'  => __( 'Deflector extension', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
        'capability' => self::MENU_CAPABILITY,
        'icon'       => $icon_menu,
        'subMenus'   => array(
          array(
            'menuTitle' =>  __( 'About', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
            'viewController' => 'WPXDeflectorExtensionTemplateAboutViewController',
          ),
        )
      )
    );

    WPDKMenu::renderByArray( $menus );
  }

  // -----------------------------------------------------------------------------------------------------------------
  // Menu
  // -----------------------------------------------------------------------------------------------------------------

  /*
   * Second item
   */
  public function menuSecondItem() {
    echo '<h1>Second View without view</h1>';

    /* Title... */
    echo '<h2>Title</h2>';

    /* However you can display what U want. */
    $item = array(
      'type'        => WPDKUIControlType::TEXT,
      'label'       => __( 'My Custom label', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
      'placeholder' => __( 'Your placeholder', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
    );
    $text = new WPDKUIControlText( $item );
    $text->display();
  }

  /**
   * Handle Deflector extension deactivation through a confirm dialog.
   *
   * @brief Handle Deflector extension deactivation through a confirm dialog.
   *
   * @param array $links
   *
   * @return array
   */
  public function plugin_action_links( $links ) {

    $l10n = array(
      'warning_confirm_deactive_plugin' => __( "WARNING! If you deactivate Deflector extension template plugin, _ALL_ security rules currently active in this plugin will be disabled and reset to OFF status.\n\nDo you really want to continue?", WPXDEFLECTOR_TEXTDOMAIN )
    );

    wp_enqueue_script( 'wpxdeflector-extension-template-plugin-list',
      $this->plugin->javascriptURL . 'wpxdeflector-extension-template-plugin-list.js', $this->plugin->version, true );
    wp_localize_script( 'wpxdeflector-extension-template-plugin-list', 'WPXDeflectorExtensionTemplatePluginListL10n', $l10n );

    return $links;

  }


}
