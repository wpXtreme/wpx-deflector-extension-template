/**
 * Used in WordPress Plugin list to handle deactivation of Deflector Extension Template Plugin. Show a confirm dialog
 * alerting user to consequences of plugin deactivation.
 *
 * @class       WPXDeflectorExtensionTemplatePluginList
 * @author      yuma <info@wpxtre.me>
 * @copyright   Copyright (C) 2013- wpXtreme Inc. All Rights Reserved.
 * @date        2013-03-15
 * @since       1.0.0
 *
 * @note The confirm dialog does not appear in case of bulk deactivation.
 *
 */

var WPXDeflectorExtensionTemplatePluginList = (function ( $ ) {

  /**
   * Internal class pointer
   *
   * @brief This object
   */
  var $this = {};

  /**
   * The WPXDeflectorPluginList version
   *
   * @brief Version
   */
  $this.version = "1.0";

  /**
   * Return an instance of WPXDeflectorPluginList class
   *
   * @brief Init this class
   *
   * @return WPXDeflectorPluginList
   */
  $this.init = function () {

    /* Catch the deactive link for a wpXtreme plugin. */
    $( 'tr#deflector-extension-template span.deactivate a' ).on( 'click', _onClickDeactivePlugin );

    return $this;
  };

  /**
   * Open a Javascript confirm dialog to ask if you are sure to deactive plugin. This confirm dialog tells user what happens
   * if this plugin is deactivated.
   *
   * @brief Confirm
   *
   * @return bool
   */
  function _onClickDeactivePlugin() {
    return confirm( WPXDeflectorExtensionTemplatePluginListL10n.warning_confirm_deactive_plugin );
  }

  return $this.init();

})( jQuery );