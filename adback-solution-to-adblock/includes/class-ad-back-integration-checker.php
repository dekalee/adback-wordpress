<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */
class Integration_Checker
{
    /**
     * Check integration & return 0 if lite 1 if full
     *
     * @since    2.7.0
     */
    public static function isFullIntegration()
    {
        return get_option('adback_integration') === '1';
    }

    public static function switchIntegration()
    {
        if (self::isFullIntegration()) {
            update_option('adback_integration', '0');
        } else {
            update_option('adback_integration', '1');
        }
    }
}