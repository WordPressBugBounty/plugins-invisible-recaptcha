<?php
/**
 * Copyright (c) 2016 Ultra Community (http://www.ultracommunity.com)
 */

namespace InvisibleReCaptcha\MchLib\Plugin;

abstract class MchBasePublicPlugin extends MchBasePlugin
{

	public abstract function enqueuePublicScriptsAndStyles();
	public abstract function registerInitHooks();

	protected function __construct()
	{
		add_action('wp_enqueue_scripts', array( $this, 'enqueuePublicScriptsAndStyles' ));
		add_action('init', array( $this, 'registerInitHooks' ));

	}

	public static function registerShortCode($tagName, $callBackHandler)
	{
		add_shortcode($tagName, $callBackHandler );
	}

	private function __clone()
	{}

	public function __wakeup()
	{}

}