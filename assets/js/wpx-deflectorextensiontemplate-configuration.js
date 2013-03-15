/**
 * Description
 *
 * @class           WPXDeflectorExtensionTemplateSettings
 * @author          wpXtreme <info@wpxtre.me>
 * @copyright       Copyright 2013- wpXtreme inc.
 * @date            2013-03-15 10:05:09
 * @version         0.1.0
 */

var WPXDeflectorExtensionTemplateSettings = (function ( $ ) {

  /**
   * Internal class pointer
   *
   * @brief This object
   *
   * @var WPXDeflectorExtensionTemplateSettings $this
   */
  var $this = {};

  /**
   * The WPXDeflectorExtensionTemplateSettings version
   *
   * @brief Version
   */
  $this.version = "0.1.0";

  /**
   * You can catch jQuery document ready
   */
  $( document ).ready( _init );

  /**
   * Use a simple private function to init your class WPXDeflectorExtensionTemplateSettings
   *
   * @private
   */
  function _init() {

    /* For example we attach a document event for swipe button. */
    $( '.wpdk-form-swipe' ).on( 'swipe ', function ( e, swipeButton, status ) {
      alert( 'Swipe Button: ' + status );
    } );
  }

  // -----------------------------------------------------------------------------------------------------------------
  // End
  // -----------------------------------------------------------------------------------------------------------------

  return $this;

})( window.jQuery );
