<?php
/**
 * Copyright (c) 2016 Ultra Community (http://www.ultracommunity.com)
 */

namespace InvisibleReCaptcha\MchLib\Utils;

final class MchValidator
{
	public static function isNullOrEmpty($value, $allowZeroValue = false)
	{
		return $allowZeroValue ? (empty($value) && !\is_numeric($value)) : empty($value);
	}

	public static function isNumeric($value)
	{
		return \is_numeric($value);
	}

	public static function isInteger($value, $strict = false)
	{
		if(false === \filter_var($value, FILTER_VALIDATE_INT))
			return false;

		return $strict ? $value === (int)$value : true;
	}

}
