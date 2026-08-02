<?php

namespace InvisibleReCaptcha\Modules\Membership\UltraCommunity;


use InvisibleReCaptcha\MchLib\Plugin\MchBaseAdminPlugin;
use InvisibleReCaptcha\MchLib\Utils\MchHtmlUtils;
use InvisibleReCaptcha\Modules\BaseAdminModule;

class UltraCommunityAdminModule extends BaseAdminModule
{
	CONST OPTION_LOGIN_FORM_PROTECTION_ENABLED          = 'IsLoginEnabled';
	CONST OPTION_REGISTRATION_FORM_PROTECTION_ENABLED   = 'IsRegisterEnabled';

	public  function __construct()
	{
		parent::__construct();
	}


	public function getDefaultOptions()
	{
		static $arrDefaultSettingOptions = null;
		if(null !== $arrDefaultSettingOptions)
			return $arrDefaultSettingOptions;

		$arrDefaultSettingOptions = array(

			self::OPTION_LOGIN_FORM_PROTECTION_ENABLED => array(
				'Value'      => null,
				'LabelText'  => __('Enable Login Form Protection', 'invisible-recaptcha'),
				'InputType'  => MchHtmlUtils::FORM_ELEMENT_INPUT_CHECKBOX
			),

			self::OPTION_REGISTRATION_FORM_PROTECTION_ENABLED  => array(
				'Value'      => null,
				'LabelText'  => __('Enable Registration Form Protection', 'invisible-recaptcha'),
				'InputType'  => MchHtmlUtils::FORM_ELEMENT_INPUT_CHECKBOX
			),

		);

		return $arrDefaultSettingOptions;

	}

	public function validateModuleSettingsFields( $arrOptions )
	{
		$arrOptions = $this->sanitizeModuleSettings($arrOptions);
		$this->registerSuccessMessage(__('Your changes were successfully saved!', 'invisible-recaptcha'));

		return $arrOptions;
	}


	public function renderModuleSettingsSectionHeader( array $arrSectionInfo ) {
		echo '<div class="mch-settings-section-header">
				<h3>

				<a style="text-decoration: none;" href="https://wordpress.org/plugins/ultra-community/" target="_blank">
					<span>UltraCommunity</span>
				</a>
				'.esc_html__(' Protection Settings', 'invisible-recaptcha').'</h3>
			</div>';
	}


}