<?php
/**
 * Sample configuration class. In this class you define your tree configuration.
 *
 * @class              WPXDeflectorExtensionTemplateConfiguration
 * @author             wpXtreme <info@wpxtre.me>
 * @copyright          Copyright 2013- wpXtreme inc.
 * @date               2013-03-15 10:05:09
 * @version            0.1.2
 */

class WPXDeflectorExtensionTemplateConfiguration extends WPDKConfiguration {

    /**
     * The configuration name used on database
     *
     * @brief Configuration name
     *
     * @var string
     */
    const CONFIGURATION_NAME = 'wpx-deflectorextensiontemplate-configuration';

    /**
     * Your own configuration property
     *
     * @brief Configuration version
     *
     * @var string $version
     */
    public $version = WPXDEFLECTOREXTENSIONTEMPLATE_VERSION;

    /**
     * This is the first entry pointer to your own tree configuration
     *
     * @brief Settings
     *
     * @var mixed $settings
     */
    public $settings;

    /**
     * Return an instance of WPXDeflectorExtensionTemplateConfiguration class from the database or onfly.
     *
     * @brief Get the configuration
     *
     * @return WPXDeflectorExtensionTemplateConfiguration
     */
    public static function init() {
        $instance = parent::init( self::CONFIGURATION_NAME, __CLASS__ );

        /* Or if the obfly version is different from stored version. */
        if( version_compare( $instance->version, WPXDEFLECTOREXTENSIONTEMPLATE_VERSION ) < 0 ) {
            /* For i.e. you would like update the version property. */
            $instance->version = WPXDEFLECTOREXTENSIONTEMPLATE_VERSION;
            $instance->update();
        }

        return $instance;
    }

    /**
     * Create an instance of WPXDeflectorExtensionTemplateConfiguration class
     *
     * @brief Construct
     *
     * @return WPXDeflectorExtensionTemplateConfiguration
     */
    public function __construct() {
        parent::__construct( self::CONFIGURATION_NAME );

        /* Init my tree settings. */
        $this->settings = '';
    }

}
