<?php

// sourced from https://developer.wordpress.org

function sanitize_email($email)
{
	// Test for the minimum length the email can be
	if (strlen($email) < 6)
	{
		/**
		 * Filters a sanitized email address.
		 *
		 * This filter is evaluated under several contexts, including 'email_too_short',
		 * 'email_no_at', 'local_invalid_chars', 'domain_period_sequence', 'domain_period_limits',
		 * 'domain_no_periods', 'domain_no_valid_subs', or no context.
		 *
		 * @since 2.8.0
		 *
		 * @param string $email   The sanitized email address.
		 * @param string $email   The email address, as provided to sanitize_email().
		 * @param string $message A message to pass to the user.
		 */
		return apply_filters('sanitize_email', '', $email, 'email_too_short');
	}

	// Test for an @ character after the first position
	if (strpos($email, '@', 1) === false)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'email_no_at');
	}

	// Split out the local and domain parts
	list($local, $domain) = explode('@', $email, 2);

	// LOCAL PART
	// Test for invalid characters
	$local = preg_replace('/[^a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]/', '', $local);
	if ('' === $local)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'local_invalid_chars');
	}

	// DOMAIN PART
	// Test for sequences of periods
	$domain = preg_replace('/\.{2,}/', '', $domain);
	if ('' === $domain)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'domain_period_sequence');
	}

	// Test for leading and trailing periods and whitespace
	$domain = trim($domain, " \t\n\r\0\x0B.");
	if ('' === $domain)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'domain_period_limits');
	}

	// Split the domain into subs
	$subs = explode('.', $domain);

	// Assume the domain will have at least two subs
	if (2 > count($subs))
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'domain_no_periods');
	}

	// Create an array that will contain valid subs
	$new_subs = array();

	// Loop through each sub
	foreach ($subs as $sub)
	{
		// Test for leading and trailing hyphens
		$sub = trim($sub, " \t\n\r\0\x0B-");

		// Test for invalid characters
		$sub = preg_replace('/[^a-z0-9-]+/i', '', $sub);

		// If there's anything left, add it to the valid subs
		if ('' !== $sub)
		{
			$new_subs[] = $sub;
		}
	}

	// If there aren't 2 or more valid subs
	if (2 > count($new_subs))
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('sanitize_email', '', $email, 'domain_no_valid_subs');
	}

	// Join valid subs into the new domain
	$domain = join('.', $new_subs);

	// Put the email back together
	$email = $local . '@' . $domain;

	// Congratulations your email made it!
	/** This filter is documented in wp-includes/formatting.php */
	return apply_filters('sanitize_email', $email, $email, null);
}

function is_email($email, $deprecated = false)
{
	if (!empty($deprecated))
	{
		_deprecated_argument(__FUNCTION__, '3.0.0');
	}

	// Test for the minimum length the email can be
	if (strlen($email) < 6)
	{
		/**
		 * Filters whether an email address is valid.
		 *
		 * This filter is evaluated under several different contexts, such as 'email_too_short',
		 * 'email_no_at', 'local_invalid_chars', 'domain_period_sequence', 'domain_period_limits',
		 * 'domain_no_periods', 'sub_hyphen_limits', 'sub_invalid_chars', or no specific context.
		 *
		 * @since 2.8.0
		 *
		 * @param bool   $is_email Whether the email address has passed the is_email() checks. Default false.
		 * @param string $email    The email address being checked.
		 * @param string $context  Context under which the email was tested.
		 */
		return apply_filters('is_email', false, $email, 'email_too_short');
	}

	// Test for an @ character after the first position
	if (strpos($email, '@', 1) === false)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('is_email', false, $email, 'email_no_at');
	}

	// Split out the local and domain parts
	list($local, $domain) = explode('@', $email, 2);

	// LOCAL PART
	// Test for invalid characters
	if (!preg_match('/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~\.-]+$/', $local))
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('is_email', false, $email, 'local_invalid_chars');
	}

	// DOMAIN PART
	// Test for sequences of periods
	if (preg_match('/\.{2,}/', $domain))
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('is_email', false, $email, 'domain_period_sequence');
	}

	// Test for leading and trailing periods and whitespace
	if (trim($domain, " \t\n\r\0\x0B.") !== $domain)
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('is_email', false, $email, 'domain_period_limits');
	}

	// Split the domain into subs
	$subs = explode('.', $domain);

	// Assume the domain will have at least two subs
	if (2 > count($subs))
	{
		/** This filter is documented in wp-includes/formatting.php */
		return apply_filters('is_email', false, $email, 'domain_no_periods');
	}

	// Loop through each sub
	foreach ($subs as $sub)
	{
		// Test for leading and trailing hyphens and whitespace
		if (trim($sub, " \t\n\r\0\x0B-") !== $sub)
		{
			/** This filter is documented in wp-includes/formatting.php */
			return apply_filters('is_email', false, $email, 'sub_hyphen_limits');
		}

		// Test for invalid characters
		if (!preg_match('/^[a-z0-9-]+$/i', $sub))
		{
			/** This filter is documented in wp-includes/formatting.php */
			return apply_filters('is_email', false, $email, 'sub_invalid_chars');
		}
	}

	// Congratulations your email made it!
	/** This filter is documented in wp-includes/formatting.php */
	return apply_filters('is_email', $email, $email, null);
}

function apply_filters($tag, $value)
{
	global $wp_filter, $wp_current_filter;

	$args = array();

	// Do 'all' actions first.
	if (isset($wp_filter['all']))
	{
		$wp_current_filter[] = $tag;
		$args                = func_get_args();
		_wp_call_all_hook($args);
	}

	if (!isset($wp_filter[$tag]))
	{
		if (isset($wp_filter['all']))
		{
			array_pop($wp_current_filter);
		}

		return $value;
	}

	if (!isset($wp_filter['all']))
	{
		$wp_current_filter[] = $tag;
	}

	if (empty($args))
	{
		$args = func_get_args();
	}

	// don't pass the tag name to WP_Hook
	array_shift($args);

	$filtered = $wp_filter[$tag]->apply_filters($value, $args);

	array_pop($wp_current_filter);

	return $filtered;
}

function _deprecated_argument($function, $version, $message = null)
{

	/**
	 * Fires when a deprecated argument is called.
	 *
	 * @since 3.0.0
	 *
	 * @param string $function The function that was called.
	 * @param string $message  A message regarding the change.
	 * @param string $version  The version of WordPress that deprecated the argument used.
	 */
	do_action('deprecated_argument_run', $function, $message, $version);

	/**
	 * Filters whether to trigger an error for deprecated arguments.
	 *
	 * @since 3.0.0
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated arguments. Default true.
	 */
	if (WP_DEBUG && apply_filters('deprecated_argument_trigger_error', true))
	{
		if (function_exists('__'))
		{
			if (!is_null($message))
			{
				/* translators: 1: PHP function name, 2: version number, 3: optional message regarding the change */
				trigger_error(sprintf(__('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s'), $function, $version, $message));
			}
			else
			{
				/* translators: 1: PHP function name, 2: version number */
				trigger_error(sprintf(__('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.'), $function, $version));
			}
		}
		else
		{
			if (!is_null($message))
			{
				trigger_error(sprintf('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s', $function, $version, $message));
			}
			else
			{
				trigger_error(sprintf('%1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.', $function, $version));
			}
		}
	}
}

?>
