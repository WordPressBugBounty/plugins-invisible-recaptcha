=== Invisible reCaptcha ===
Contributors: berrypressjonhall, berrypress
Tags: invisible reCaptcha, woocommerce invisible reCaptcha, contact form 7 invisible reCaptcha
Requires at least: 4.5
Requires PHP: 7.0
Tested up to: 7.0
Stable tag: 1.3.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Invisible reCaptcha for WordPress plugin helps you to protect your sites against bad spam bots using the new Invisible reCaptcha by Google.

**Notice:** As of version 1.3.0, this plugin is now maintained by [@berrypress](https://profiles.wordpress.org/berrypress/).

== Description ==

Invisible reCaptcha for WordPress is an extremely powerful plugin which integrates the new [Invisible reCaptcha by Google](https://www.google.com/recaptcha/intro/invisible.html) with your WordPress site.

= External service disclosure =

This plugin is designed to integrate [reCAPTCHA by Google](https://cloud.google.com/security/products/recaptcha) into your site, which is an external third-party service used to implement security and fraud prevention measures. The plugin may communicate with the reCAPTCHA service via API and/or by loading assets on your site's frontend, resulting in data transfer with the reCAPTCHA service when the site frontend is accessed and/or when reCAPTCHA validation is triggered by to user actions. In addition to authentication and operational data such as API keys and reCAPTCHA identifiers, the service may receive information from your and your users' browser and network, such as their IP address, user agent, etc.

Use of the reCAPTCHA service is subject to the [Google Cloud Terms of Service](https://cloud.google.com/terms), [Service Specific Terms](https://cloud.google.com/terms/service-term), [Google Privacy Policy](https://policies.google.com/privacy), and the [Cloud Data Processing Addendum](https://cloud.google.com/terms/data-processing-addendum).

This plugin is not affiliated with or endorsed by Google.

= Summary of features =

**WordPress Invisible reCaptcha**

	- Login form protection - annihilates Brute Force attacks
	- Registration form protection
	- Comments form protection
	- Forgot Password form protection

**WooCommerce Invisible reCaptcha**

	- Login form protection
	- Registration form protection
	- Product Review form protection
	- Lost Password form protection
	- Reset Password form protection

**Contact Form 7 Invisible reCaptcha**
	- Protect your Contact Form 7 forms with Invisible reCaptcha

**Gravity Forms Invisible reCaptcha**
	- Protect your Gravity Forms with Invisible reCaptcha

**[Ultra Community](https://wordpress.org/plugins/ultra-community/) Invisible reCaptcha**
	- Login form protection
	- Registration form protection

**BuddyPress Invisible reCaptcha**
	- Protect your BuddyPress registration form with Invisible reCaptcha

= Compatibility =
On a **WP Multisite** you can either activate the plugin network wide or on a single site.

= How-To =

Check out the Invisible reCAPTCHA v2 Guide: [https://developers.google.com/recaptcha/docs/invisible](https://developers.google.com/recaptcha/docs/invisible)

1. Create a reCAPTCHA v2 site using the Invisible reCAPTCHA badge option: [https://www.google.com/recaptcha/admin/create](https://www.google.com/recaptcha/admin/create)
2. Copy the Site Key and Secret Key from the Google reCAPTCHA admin console.
3. In WordPress, go to Settings > Invisible reCaptcha > Settings.
4. Enter your Site Key and Secret Key.
5. Save the settings.
6. In the settings, choose which forms should be protected by reCAPTCHA.
7. Visit a page containing a protected form and verify that the reCAPTCHA badge is displayed and that form submissions are working correctly.

= Extending Invisible reCaptcha =
Here are some useful hooks to help developers integrate Invisible reCaptcha with any plugin or custom form

**Actions**
`
- google_invre_render_widget_action - renders the recaptcha widget
`
**Filters**
`
- google_invre_is_valid_request_filter   - used to check if Google approved the request (returns bool true/false)
- google_invre_widget_output_html_filter - used to change the recaptcha widget output
- google_invre_language_code_filter      - used to change the badge/challenge language code
- google_invre_badge_position_filter     - used to change the badge position (possible returning values are: 'bottomright', 'bottomleft', 'inline')
`
> **Examples of using  Invisible reCaptcha hooks**

- Add Invisible reCaptcha into any form
`
Just call
do_action('google_invre_render_widget_action');
anywhere before form closing tag
`

- Validate form post request
`
$is_valid = apply_filters('google_invre_is_valid_request_filter', true);
if( ! $is_valid )
{
	// handle error here
}
else
{
	// continue with your logic
}
`

- Change the badge/challenge language code

`
add_filter( 'google_invre_language_code_filter', 'myprefix_change_recaptcha_language' );
function myprefix_change_recaptcha_language($language_code){
	$language_code = 'fr'; // French
	return $language_code;
}
`
See all [reCaptcha Language Codes](https://developers.google.com/recaptcha/docs/language)


> **Note: This plugin requires PHP 7.0 or higher to be activated.**

== Upgrade Notice ==

= 1.3.1 =
* Maintenance release requiring PHP 7.0 or newer, updating WordPress compatibility metadata, external service disclosure, and setup documentation while removing inactive code.

= 1.3.0 =
* In accordance with current best practices, the custom CSS feature is no longer supported in this plugin. Before updating to v1.3.0+, make a copy of any custom CSS you have defined in Invisible Recaptcha settings, and use a different method to load it on the frontend of your site.

== Changelog ==

= 1.3.1 =
* Removed inactive WooCommerce checkout protection code ([commit details](https://github.com/BerryPress/invisible-recaptcha/commit/0e520ef3b74d7a413a44ee69f45c14532209b622)).
* Removed unused licensing and external module-loading infrastructure.
* Declared PHP 7.0 as the minimum supported PHP version.
* Updated WordPress compatibility metadata.
* Added a link to the Google Privacy Policy to the external service disclosure.
* Corrected the setup documentation to specify Invisible reCAPTCHA v2.

= 1.3.0 =
* PHP 8 compatibility
* Removed the custom CSS feature

= 1.2.3 =
* Fixed class not found issue [Problem with AJAX after update](https://wordpress.org/support/topic/problem-with-ajax-after-update/)

= 1.2.2 =
* Fixed the compatibility with  WPML 4.x - the multilingual WordPress plugin

= 1.2.1 =
* Fixed bug [Users with Author roles cannot reply to comments from backend](https://wordpress.org/support/topic/users-with-author-roles-cannot-reply-to-comments-from-backend/)

= 1.2 =
* Fixed Contact Form 7 issue [Cannot contact reCAPTCHA. Check your connection and try again](https://wordpress.org/support/topic/contact-form-7-error-message-everytime/)
* Improved Gravity Forms protection

= 1.1 =
* Fixed PHP wrong Namespace issue
* Fixed PHP warning when contact forms settings were saved for the first time
* Moved Plugin Menu to Settings
* Fixed PHP warning when contact forms settings were saved for the first time
* Moved Plugin Menu to Settings

= 1.0.8 =
* Added integration with [Ultra Community](https://wordpress.org/plugins/ultra-community/) Membership plugin
* Fixed Reset Password redirect [issue](https://wordpress.org/support/topic/breaks-password-reset-link/)
* Fixed [Badge CSS not working for Login/Register page](https://wordpress.org/support/topic/badge-css-not-working/)


= 1.0.6 =
* Fixed WooCommerce login and registration issue
* Added Invisible reCaptcha for BuddyPress

= 1.0.5 =
* Fixed Contact Form 7 issue reported by [@silvercode](https://wordpress.org/support/topic/spam-error-showing-before-page-reloads-and-message-sends-successfully)
* Added Invisible reCaptcha for Gravity Forms

= 1.0.4 =
* Multisite compatible
* Network interface ready
* Fixed PHP7 warning

= 1.0.3 =
* Added WordPress hooks for custom forms/plugins integrations

= 1.0.2 =
* Added Badge Position option
* Added Badge Custom CSS option
* Added Language option

= 1.0.1 =
* Fixed the Strict Standards Warning on PHP 5.4+

= 1.0 =
* Initial release
