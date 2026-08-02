<?php
/**
 * Copyright (c) 2016 Ultra Community (http://www.ultracommunity.com)
 */

namespace InvisibleReCaptcha\MchLib\Utils;


final class MchMinifier
{
	public static function getMinifiedCss($strCss)
	{
		$replace = array(
				"#/\*.*?\*/#s" => '',  // Strip C style comments.
				"#\s\s+#"      => ' ', // Strip excess whitespace.
		);

		$strCss = \preg_replace(array_keys($replace), $replace, $strCss);

		$replace = array(
				": "  => ":",
				"; "  => ";",
				" {"  => "{",
				" }"  => "}",
				", "  => ",",
				"{ "  => "{",
				";}"  => "}", // Strip optional semicolons.
				",\n" => ",", // Don't wrap multiple selectors.
				"\n}" => "}", // Don't wrap closing braces.
				"} "  => "}\n", // Put each rule on it's own line.
				"\n"  => "", // Strip \n
		);

		return  \str_replace(array_keys($replace), $replace, $strCss);

	}
}
