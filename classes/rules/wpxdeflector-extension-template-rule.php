<?php
/**
 * Deflector sample rule model.
 *
 * @class              WPXDeflectorExtensionTemplateRule
 * @author             yuma <info@wpxtre.me>
 * @copyright          Copyright (C) 2013- wpXtreme Inc. All Rights Reserved.
 * @date               2013-02-18
 * @since              1.0.0
 *
 */

class WPXDeflectorExtensionTemplateRule extends WPXDeflectorRule {

  //---------------------------------------------------------------------------
  // PROPERTIES
  //---------------------------------------------------------------------------

  /**
   * A generic rule parameter.
   *
   * @brief A generic rule parameter.
   *
   * @var string $_genericParam
   *
   * @since 1.0.0
   *
   * @note IT MUST BE PROTECTED, NOT PRIVATE, ELSE sync to DB DOES NOT SET IT!
   *
   */
  protected $_genericParam;

  //---------------------------------------------------------------------------
  // METHODS
  //---------------------------------------------------------------------------

  /**
   * Create an instance of WPXDeflectorExtensionTemplateRule class
   *
   * @brief Construct
   *
   * @return WPXDeflectorExtensionTemplateRule
   */
  function __construct( $id, $title ) {

    // Set custom properties to default
    $this->_genericParam = '';

    // Engage parent constructor ( and restore settings as they have been saved )
    parent::__construct( $id, $title, self::RULE_WITH_STATUS_CHANGEABLE );

  }

  /**
   * This method returns a title => value array with custom settings of this rule, in the form
   * 'setting title to display' => 'its value'. It is used in view to show current settings of this rule when its status is ON.
   *
   * @brief Return settings array
   *
   * @since 1.0.0
   *
   */
  public function settingsData() {

    $arraySettings = array (
      'Generic Param' => $this->_genericParam
    );

    return $arraySettings;

  }

  /**
   * This function executes this rule. Overridden parent method. It does nothing, because this is a template
   *
   * @brief Execute template rule
   *
   * @since 1.0.0
   *
   */
  public function execute() {
    $currentClassID = $this->id();
    add_action( 'admin_notices', $f = create_function( '',
      '$currentClassID = \'' . $currentClassID . '\';'.
      'echo \'<div id="message" class="error">\';' .
      'echo \'<h3>DEFLECTOR TEMPLATE RULE EXECUTION!</h3>\';' .
      'echo \'<p>I am executing from class id \' . $currentClassID . \' but I do nothing. Deactivate Deflector extension template plugin or deactivate any template rule if you don\\\'t want to see this message anymore!</p>\';'.
      'echo \'</div>\';' ) );
  }

  /**
   * This is the Ajax action invoked in handling this rule. This method overrides correctly parent ajaxGateway method,
   * that should be an abstract.
   *
   * @brief This AJAX action is invoked in handling this rule
   *
   * @since 1.0.0
   *
   */
  public function ajaxGateway() {

    // Out of that if I'm not in Ajax channel!
    if( FALSE == wpdk_is_ajax() ) {
      echo '<h3>Unable to execute the method ' . __METHOD__ .'in this way</h3>';
      die();
    }

    // Init Ajax response
    $response = array();

    switch( $_POST['command'] ) {

      case self::ENGAGE_RULE:

        // Build parameter = value array
        $parameters = array();
        foreach( explode('&', $_POST['data']) as $chunk ) {
          $single = explode( '=', $chunk );
          $parameters[ urldecode( $single[0] ) ] = urldecode( $single[1] );
        }

        // Get generic param
        $genericParam  = $parameters[ $this->id() . '-generic-param'];

        // Enable rule 1 in configuration
        $this->status( self::RULE_ON );
        $this->_genericParam = $genericParam;

        break;

      case self::DISABLE_RULE:

        // Disable rule 1 in configuration
        $this->status( self::RULE_OFF );
        $this->_genericParam = '';

        break;

      default:

        $response['message'] = __( 'General error in Deflector Template Rule', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN );

    }

    // Store new configuration into DB
    $this->_saveSettings();

    // Return response to caller
    echo json_encode( $response );
    die();

  }

  /**
   * This function is the get interface to generic param property.
   *
   * @brief Get interface to generic param property.
   *
   * @return string The current value of generic param.
   *
   * @since 1.0.0
   *
   */
  public function genericParam() {
    return $this->_genericParam;
  }

}



/**
 * Deflector sample rule view
 *
 * @class              WPXDeflectorExtensionTemplateRuleView
 * @author             yuma <info@wpxtre.me>
 * @copyright          Copyright (C) 2013- wpXtreme Inc. All Rights Reserved.
 * @date               2013-01-18
 * @version            1.0.0
 *
 */
class WPXDeflectorExtensionTemplateRuleView extends WPXDeflectorRuleView {

  //---------------------------------------------------------------------------
  // METHODS
  //---------------------------------------------------------------------------

  /**
   * Return an instance of WPXDeflectorExtensionTemplateRuleView class
   *
   * @brief Construct
   *
   * @return WPXDeflectorExtensionTemplateRuleView
   */
  public function __construct( $model, $classes = '') {

    // Create the standard rule view, in a single line, with swipe and icon.
    parent::__construct( $model, $classes );

  }

  /**
   * Build the help content view
   *
   * @brief Help content view
   *
   * @param string $title - The title of help view.
   * @param string $message - The help message to show.
   *
   * @since 1.0.0
   *
   */
  public function helpContent( $title, $message ) {

    $content = <<<CONTENT
<div class="wpxdeflector-help-box">
<div class="wpxdeflector-help-title">
CONTENT;

    $content .= $title;

    $content .= <<<CONTENT
<span class="wpxdeflector-accordion-selector">Read more...</span>
</div>
<div id="wpxdeflector-accordion-help">
  <p>
CONTENT;

    $content .= $message;

    $content .= <<<CONTENT
  </p>
</div>
</div>
CONTENT;

  return $content;

  }

  /**
   * Twitter Bootstrap Modal to attach to this rule
   *
   * @brief Twitter Bootstrap Modal to attach to this rule
   *
   * @since 1.0.0
   *
   */
  public function modalContent() {

    $fields = array( __( 'Template Rule Settings', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ) => array() );
    $sKey = key( $fields );

    //------------------------------------------------------------------
    // GENERIC PARAM
    //------------------------------------------------------------------

    $helpContent = $this->helpContent(  __( 'Choose the value of this generic param.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
                                        __( 'Choose the value of this generic param. It is set only for process flowing, and it is not used anywhere in your WordPress environment.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ) );

    $fields[$sKey][] = array(
      array(
        'type'    => WPDKUIControlType::CUSTOM,
        'content' => $helpContent
      )
    );

    $fields[$sKey][] =  array(
      array(
        'type'  => WPDKUIControlType::TEXT,
        'name'  => $this->_model->id() . '-generic-param',
        'value' => $this->_model->genericParam(),
        'label' => array(
          'value' => __( 'Generic Param', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ),
          'data' => array( 'placement' => 'right' )
        ),
        'size'  => 24,
        'title' => __( 'Enter the value of this generic param. It is set only for process flowing, and it is not used anywhere in your WordPress environment.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
      )
    );

    $layout = new WPDKUIControlsLayout( $fields );

    // Build output buffer
    $outputBuffer = '<form name="' . $this->_model->id() . '-form" method="POST" action="">' .
                    $layout->html() .
                    '</form>';

    return $outputBuffer;

  }

}
