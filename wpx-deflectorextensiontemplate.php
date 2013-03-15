<?php
/**
 * WPXDeflectorExtensionTemplate is the main class of this plugin.
 * This class extends WPDKWordPressPlugin in order to make easy several WordPress functions.
 *
 * @class              WPXDeflectorExtensionTemplate
 * @author             wpXtreme <info@wpxtre.me>
 * @copyright          Copyright (C) wpXtreme <info@wpxtre.me>.
 * @date               2013-03-15
 * @since              1.0.0
 *
 */
final class WPXDeflectorExtensionTemplate extends WPDKWordPressPlugin {

  //---------------------------------------------------------------------------
  // PROPERTIES
  //---------------------------------------------------------------------------

  /**
   * Deflector extension configuration
   *
   * @brief Deflector extension configuration
   *
   * @var WPXDeflectorExtensionTemplateConfiguration $_config
   *
   * @since 1.0.0
   */
  private $_config;

  /**
   * Create and return a singleton instance of WPXDeflectorExtensionTemplate class
   *
   * @brief Init
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXDeflectorExtensionTemplate
   */
  public static function boot( $file ) {
    static $instance = null;
    if( is_null( $instance ) ) {
      $instance = new WPXDeflectorExtensionTemplate( $file );
      do_action( __CLASS__ );
    }
    return $instance;
  }

  /**
   * Create an instance of WPXDeflectorExtensionTemplate class
   *
   * @brief Construct
   *
   * @param string $file The main file of this plugin. Usually __FILE__ (main.php)
   *
   * @return WPXDeflectorExtensionTemplate object instance
   */
  public function __construct( $file ) {

    parent::__construct( $file );

    $this->defines();

    // Build environment of autoload classes - this is ALWAYS the first thing to do
    $this->_registerClasses();

    // Get configuration ( in this template is totally empty because it is not necessary
    $this->_config = WPXDeflectorExtensionTemplateConfiguration::init();

    // First example of extending Deflector: add a rule to an existent Deflector collection
    $this->_templateExtendingExistentCollection();

    // Second example of extending Deflector: add a rule collection to an existent Deflector tab
    $this->_templateExtendingExistentTab();

    // Third example of extending Deflector: add a brand new tab with a brand new rules collection to Deflector
    $this->_templateCreatingNewTab();

  }

  /**
   * Template for extending an existent Deflector Rule Collection
   *
   * @brief Template for extending an existent Deflector Rule Collection
   *
   * @since 1.0.0
   *
   */
  private function _templateExtendingExistentCollection() {

    // Get the main Deflector instance; it DOES EXIST, because of wpXtreme chain
    $deflectorInstance = WPXDeflector::getInstance();

    //--------------------------------------------------------------------------
    // INIT A SAMPLE RULE
    //--------------------------------------------------------------------------

    // Rule model
    $templateRule = new WPXDeflectorExtensionTemplateRule(
      'wpxdeflector-template-rule-1',
      __( 'This is an example of a rule. Activation does nothing but set a generic param.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // If rule status is OFF, increment Deflector rule counter in order to show Deflector badge with proper value
    if( WPXDeflectorRule::RULE_OFF == $templateRule->status() ) {
      $deflectorInstance->numberOfRulesOFF++;
    }

    // Set rule help
    $helpInfo = __( 'This is a sample of a rule attached to an existing collection. It does nothing but set a generic param to a value.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN );
    $templateRule->help( $helpInfo, __('wpXtreme Deflector Basic Shields - Info about this rule', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // Hook rule execution to proper WordPress action - the method engages execution internally only if rule status = ON
    $templateRule->hookExecutionToAction( 'init' );

    //--------------------------------------------------------------------------
    // ATTACH THIS RULE AT THE END OF THE FIRST RULES COLLECTION IN BASIC SHIELDS TAB
    //--------------------------------------------------------------------------

    $basicShieldsFirstCollection = $deflectorInstance->rulesEnvironment['wpxdeflector-basic-shields']['rules-collection'][0];

    // Add template rule 1 to this collection
    $basicShieldsFirstCollection->addRule( $templateRule );

  }

  /**
   * Template for extending an existent Deflector Rule tab with a new collection
   *
   * @brief Template for extending an existent Deflector Rule tab with a new collection
   *
   * @since 1.0.0
   *
   */
  private function _templateExtendingExistentTab() {

    // Get the main Deflector instance; it DOES EXIST, because of wpXtreme chain
    $deflectorInstance = WPXDeflector::getInstance();

    //--------------------------------------------------------------------------
    // INIT A SAMPLE RULE
    //--------------------------------------------------------------------------

    // Rule model
    $templateRule = new WPXDeflectorExtensionTemplateRule(
      'wpxdeflector-newcollection-template-rule-1',
      __( 'This is an example of a rule. Activation does nothing but set a generic param.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // If rule status is OFF, increment Deflector rule counter in order to show Deflector badge with proper value
    if( WPXDeflectorRule::RULE_OFF == $templateRule->status() ) {
      $deflectorInstance->numberOfRulesOFF++;
    }

    // Set rule help
    $helpInfo = __( 'This is a sample of a rule attached to an existing collection. It does nothing but set a generic param to a value.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN );
    $templateRule->help( $helpInfo, __('wpXtreme Deflector Basic Shields - Info about this rule', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // Hook rule execution to proper WordPress action - the method engages execution internally only if rule status = ON
    $templateRule->hookExecutionToAction( 'init' );

    //--------------------------------------------------------------------------
    // CREATE A BRAND NEW RULES COLLECTION
    //--------------------------------------------------------------------------

    // Create collection
    $newCollection = new WPXDeflectorRulesCollection(
      'wpxdeflector-basic-shields-new-collection-rules',
      __( 'New template collection for Basic Shields tab', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // Set description for admin area basic shields collection
    $newCollection->description( __( 'This is a template of a new rules collection added to Basic Shields Tab.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ) );

    // Add template rule 1 to this collection
    $newCollection->addRule( $templateRule );

    //--------------------------------------------------------------------------
    // APPEND THIS RULES COLLECTION IN BASIC SHIELDS TAB
    //--------------------------------------------------------------------------

    $deflectorInstance->rulesEnvironment['wpxdeflector-basic-shields']['rules-collection'][] = $newCollection;

  }

  /**
   * Template for creating a brand new tab in Deflector
   *
   * @brief Template for creating a brand new tab in Deflector
   *
   * @since 1.0.0
   *
   */
  private function _templateCreatingNewTab() {

    // Get the main Deflector instance; it DOES EXIST, because of wpXtreme chain
    $deflectorInstance = WPXDeflector::getInstance();

    //--------------------------------------------------------------------------
    // INIT A SAMPLE RULE
    //--------------------------------------------------------------------------

    // Rule model
    $templateRule = new WPXDeflectorExtensionTemplateRule(
      'wpxdeflector-new-tab-and-collection-template-rule-1',
      __( 'This is an example of a rule. Activation does nothing but set a generic param.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // If rule status is OFF, increment Deflector rule counter in order to show Deflector badge with proper value
    if( WPXDeflectorRule::RULE_OFF == $templateRule->status() ) {
      $deflectorInstance->numberOfRulesOFF++;
    }

    // Set rule help
    $helpInfo = __( 'This is a sample of a rule attached to an existing collection. It does nothing but set a generic param to a value.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN );
    $templateRule->help( $helpInfo, __('wpXtreme Deflector Basic Shields - Info about this rule', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // Hook rule execution to proper WordPress action - the method engages execution internally only if rule status = ON
    $templateRule->hookExecutionToAction( 'init' );

    //--------------------------------------------------------------------------
    // CREATE A BRAND NEW RULES COLLECTION
    //--------------------------------------------------------------------------

    // Create collection
    $newCollection = new WPXDeflectorRulesCollection(
      'wpxdeflector-basic-shields-new-tab-and-collection-rules',
      __( 'New template collection for a brand new tab', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN )
    );

    // Set description for admin area basic shields collection
    $newCollection->description( __( 'This is a template of a new rules collection added to A Brand New Tab.', WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN ) );

    // Add template rule 1 to this collection
    $newCollection->addRule( $templateRule );

    //--------------------------------------------------------------------------
    // CREATE A BRAND NEW TAB IN DEFLECTOR
    //--------------------------------------------------------------------------

    // Create tab
    $keyTab                                   = 'wpxdeflector-brand-new-tab';
    $deflectorInstance->rulesEnvironment[$keyTab]['title'] = __( 'A Brand New Tab', WPXDEFLECTOR_TEXTDOMAIN );

    // Add rules collections to this tab
    $deflectorInstance->rulesEnvironment[$keyTab]['rules-collection'][]  = $newCollection;

  }

  /**
   * Include the external defines file
   *
   * @brief Defines
   */
  private function defines() {
    include_once( 'defines.php' );
  }

  /**
   * Register all autoload classes
   *
   * @brief Autoload classes
   */
  private function _registerClasses() {

    //------------------------------------------------------------------
    // NOTE: if you're including class definitions, don't insert any require|include statement here!
    // Follow SPL autoload login embedded instead.
    // See ... for details about how to proceed with this embedded loading logic.
    //------------------------------------------------------------------

    $includes = array(
    	$this->classesPath . 'admin/wpxdeflectorextensiontemplate-about-vc.php' => 'WPXDeflectorExtensionTemplateAboutViewController',

    	$this->classesPath . 'admin/wpxdeflectorextensiontemplate-admin.php' => 'WPXDeflectorExtensionTemplateAdmin',

    	$this->classesPath . 'configuration/wpxdeflectorextensiontemplate-configuration.php' => 'WPXDeflectorExtensionTemplateConfiguration',

    	$this->classesPath . 'rules/wpxdeflector-extension-template-rule.php' => array( 'WPXDeflectorExtensionTemplateRule',
    'WPXDeflectorExtensionTemplateRuleView' ) );

    $this->registerAutoloadClass( $includes );

  }

  /**
   * Catch for admin
   *
   * @brief Admin backend
   */
  public function admin() {
    WPXDeflectorExtensionTemplateAdmin::init( $this );
    // Add your code from now on
  }

  /**
   * Catch for frontend
   *
   * @brief Frontend
   */
  public function theme() {
    /**
     * To override.
     *
     * For example:
     *
     * @todo completare questo esempio con la nuova logica autoload
     *       WPXDeflectorExtensionTemplateShortcode::init();
     */
  }

  /**
   * Ready to init plugin configuration
   *
   * @brief Init configuration
   */
  public function configuration() {
    WPXDeflectorExtensionTemplateConfiguration::init();
  }

  /**
   * Catch for activation. This method is called one shot.
   *
   * @brief Activation
   */
  public function activation() {
    WPXDeflectorExtensionTemplateConfiguration::init()->delta();
  }

  /**
   * Catch for deactivation. This method is called when the plugin is deactivate.
   *
   * @brief Deactivation
   */
  public function deactivation() {

    // Get the main Deflector instance; it DOES EXIST, because of wpXtreme chain
    $deflectorInstance = WPXDeflector::getInstance();

    // Deactivate my own security rules
    $arrayTabKeys = array_keys( $deflectorInstance->rulesEnvironment );
    foreach( $arrayTabKeys as $tabKey ) {
      foreach( $deflectorInstance->rulesEnvironment[$tabKey]['rules-collection'] as $ruleCollectionInstance ) {
        foreach( $ruleCollectionInstance->rules() as $rule ) {

          // This is only an example, but it is better if any Deflector extension marks with a unique key
          // the rules it creates.
          if( FALSE!== strpos( $rule->id(), '-template-rule')  ) {
            $rule->disableRuleOnDeflectorDeactivation();
          }

        }
      }
    }

  }

  /**
   * Do log in easy way
   *
   * @brief Helper for log
   *
   * @param mixed  $txt
   * @param string $title Optional. Any free string text to context the log
   *
   */
  public static function log( $txt, $title = '' ) {
    /**
     * @var WPXDeflectorExtensionTemplate $me
     */
    $me = $GLOBALS[ __CLASS__ ];
    $me->log->log( $txt, $title );
  }

}

