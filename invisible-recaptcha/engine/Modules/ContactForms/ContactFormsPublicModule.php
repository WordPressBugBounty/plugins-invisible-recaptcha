<?php


namespace InvisibleReCaptcha\Modules\ContactForms;


use InvisibleReCaptcha\MchLib\Utils\MchWpUtils;
use InvisibleReCaptcha\Modules\BasePublicModule;
use InvisibleReCaptcha\RequestHandler;

class ContactFormsPublicModule extends BasePublicModule
{
	public function __construct()
	{
		parent::__construct();

		$selfInstance = $this;

		if($this->getOption(ContactFormsAdminModule::OPTION_CF7_PROTECTION_ENABLED)){

			MchWpUtils::addFilterHook('wpcf7_form_elements', [$selfInstance, 'getReCaptchaHolderHtmlCode'], PHP_INT_MAX);

			MchWpUtils::addFilterHook('wpcf7_spam', function($isSpam){
				return $isSpam || !RequestHandler::isInvisibleReCaptchaTokenValid();
			}, 9);
		}


		if($this->getOption(ContactFormsAdminModule::OPTION_GF_PROTECTION_ENABLED)){

			MchWpUtils::addFilterHook('gform_get_form_filter', function($formHtml, $gForm) use ($selfInstance){
				return empty($gForm['id']) || $selfInstance->isGFormExcluded($gForm['id']) ? $formHtml : str_ireplace('</form>', $selfInstance->getReCaptchaHolderHtmlCode().'</form>', $formHtml);
			}, 1, 2);


			MchWpUtils::addFilterHook('gform_entry_is_spam', function($isSpam, $submittedForm) use ($selfInstance){
				if( $isSpam )
					return $isSpam;
				
				$submittedForm   = (array)$submittedForm;
				$submittedForm['id']   = (!empty($submittedForm['id']) ? absint($submittedForm['id'])  : null);

				if( $selfInstance->isGFormExcluded($submittedForm['id']) )
					return $isSpam;

				return BasePublicModule::isRecaptchaValid() ? false : true;

			}, 10, 2);

		}

	}


	public function isGFormExcluded($gFormId)
	{
		$gFormId = (int)$gFormId;
		$isExcluded = in_array($gFormId, (array)$this->getOption(ContactFormsAdminModule::OPTION_GF_EXCLUDED_FORM_IDS));

		return apply_filters('google_invre_is_gf_excluded', $isExcluded, $gFormId);
	}

}