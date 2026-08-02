<?php
/**
 *
 * @package   Invisible reCaptcha
 * @author    BerryPress (previously: Mihai Chelaru)
 *
 * @wordpress-plugin
 * Plugin Name: Invisible reCaptcha
 * Description: Integrate Google Invisible reCaptcha with WordPress.
 * Version: 1.3.1
 * Requires PHP: 7.0
 * Author: BerryPress (previously: Mihai Chelaru)
 * License: GPLv3+
 * Text Domain: invisible-recaptcha
 */

defined('ABSPATH') || exit;

final class InvisibleReCaptcha
{
	CONST PLUGIN_VERSION    = '1.3.1';
	CONST PLUGIN_ABBR       = 'ic';
	CONST PLUGIN_SLUG       = 'invisible-recaptcha';
	CONST PLUGIN_NAME       = 'Invisible reCaptcha';

	CONST PLUGIN_MAIN_FILE  = __FILE__;

	private function __construct()
	{}

	public static function init()
	{
		\InvisibleReCaptcha\MchLib\Plugin\MchBasePlugin::setPluginInfo(array(
				'PLUGIN_MAIN_FILE'   => self::PLUGIN_MAIN_FILE,
				'PLUGIN_VERSION'     => self::PLUGIN_VERSION,
				'PLUGIN_SLUG'        => self::PLUGIN_SLUG,
				'PLUGIN_ABBR'        => self::PLUGIN_ABBR,
				'PLUGIN_NAME'        => self::PLUGIN_NAME,
		));

		InvisibleReCaptcha\RequestHandler::handleRequest();

	}

}

include __DIR__ . '/includes/MchLibAutoloader.php';
include __DIR__ . '/engine/RequestHandler.php';

InvisibleReCaptcha::init();
