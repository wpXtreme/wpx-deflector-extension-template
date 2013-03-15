<?php
/**
 * Standard about view controller
 *
 * @class           WPXDeflectorAboutViewController
 * @author          =undo= <info@wpxtre.me>
 * @copyright       Copyright (C) 2013 wpXtreme Inc. All Rights Reserved.
 * @date            2013-02-21
 * @version         1.0.0
 *
 */
class WPXDeflectorExtensionTemplateAboutViewController extends WPDKAboutViewController {

  /**
   * Create an instance of WPXDeflectorAboutViewController class
   *
   * @brief Construct
   *
   * @return WPXDeflectorAboutViewController
   */
  public function __construct() {
    parent::__construct( $GLOBALS['WPXDeflectorExtensionTemplate'] );
  }

  /**
   * Return the fields with about information
   *
   * @brief Fields
   *
   * Return a sdf array with the information/credits
   */
  public function fields() {

    $credits = array(
      __( 'Developers & UI Designers', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )   => array(
        array(
          'name' => 'wpXtreme, Inc.',
          'mail' => 'info@wpxtre.me',
          'site' => 'https://wpxtre.me',
        ),
      ),

      __( 'Translations', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )                => array(
        array(
          'name' => __( 'If you like make a translation, please send here.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
          'mail' => 'info@wpxtre.me',
          'site' => 'mailto: info@wpxtre.me',
        ),
      ),

      __( 'Bugs report and beta tester', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ) => array(
        array(
          'name' => __( 'FAQ support?', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
          'mail' => 'info@wpxtre.me',
          'site' => 'https://wpxtre.me/support',
        ),
        array(
          'name' => __( 'Do you need help or support?', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
          'mail' => 'info@wpxtre.me',
          'site' => 'mailto:support@wpxtre.me',
        ),
        array(
          'name'  => __( 'Run the Issue Report', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
          'mail'  => 'info@wpxtre.me',
          'site'  => '#issue-report',
          'title' => __( 'Issue Report is available in your WordPress footer too', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
        ),
      ),
    );
    return $credits;
  }

}
