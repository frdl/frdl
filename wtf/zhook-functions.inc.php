<?php
/**
 * Author: Melanie Wehowski, WEID Consortium
 * Author URI: https://weid.info
 * License: MIT
 */
/**
global functions wordpress shims
*/
use Frdlweb\OIDplus\Plugins\PublicPages\WTFunctions\WPHooks; 
use ViaThinkSoft\OIDplus\Core\OIDplus;
use ViaThinkSoft\OIDplus\Core\OIDplusConfig;

 
function frdl_to_http_query(   
		array | object $data,    
		string $numeric_prefix = '',    
		?string $arg_separator = '&',   
		int $encoding_type = \PHP_QUERY_RFC1738) : string
 {
        return \http_build_query($data, $numeric_prefix, $arg_separator, $encoding_type);
}
	
function frdl_to_query(array | object $data) : string
{
		return  preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', frdl_to_http_query($data, '', '&', \PHP_QUERY_RFC1738) );
}

function wp_protect_special_option(string $option ) {
	throw new \Exception('Not implemented in '.__FUNCTION__.' line '.__LINE__.' '.basename(__FILE__));
/*
//	$res = OIDplus::db()->query("select name, description, protected, visible, value from ###config WHERE name = ? LIMIT 1", [$option]);
	$res = OIDplus::db()->query("select name, description, protected, visible, value from ###config WHERE name = ?", [$option]);	
	$row = $res->fetch_object();	
	
	if (
		(isset($row->protected) && (true === $row->protected || 1===intval($row->protected) ) ) 
		|| 'alloptions' === $option || 'notoptions' === $option ) {
		wp_die(
			sprintf(
				 
				__( '%s is a protected %s option and may not be modified' ),
				esc_html( $option ),
				'OIDplus'
			)
		);
	}
	*/
}


function wp_load_alloptions(?bool  $force_cache = false ) :array {
	//global $wpdb;

	/**
	 * Filters the array of alloptions before it is populated.
	 *
	 * Returning an array from the filter will effectively short circuit
	 * wp_load_alloptions(), returning that value instead.
	 *
	 * @since 6.2.0
	 *
	 * @param array|null $alloptions  An array of alloptions. Default null.
	 * @param bool       $force_cache Whether to force an update of the local cache from the persistent cache. Default false.
	 */
	$alloptions = apply_filters( 'pre_wp_load_alloptions', null, $force_cache );
	if ( is_array( $alloptions ) ) {
		return $alloptions;
	}

	if ( ! wp_installing() || ! is_multisite() ) {
		$alloptions = wp_cache_get( 'alloptions', 'options', $force_cache );
	} else {
		$alloptions = false;
	}

	if ( ! $alloptions ) {
		/*
		$suppress      = $wpdb->suppress_errors();
		$alloptions_db = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE autoload IN ( '" . implode( "', '", esc_sql( wp_autoload_values_to_autoload() ) ) . "' )" );

		if ( ! $alloptions_db ) {
			$alloptions_db = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options" );
		}
		$wpdb->suppress_errors( $suppress );

		$alloptions = array();
		foreach ( (array) $alloptions_db as $o ) {
			$alloptions[ $o->option_name ] = $o->option_value;
		}
       */
		$alloptions = array();
		/*
		$res = OIDplus::db()->query("select name, description, protected, visible, value from ###config");
		while ($row = $res->fetch_object()) {
			$alloptions[ $row->name ] = $row->value;
		}
		*/
		 
				if(class_exists(\ViaThinkSoft\OIDplus\Core\OIDplus::class) ){	
					$res = OIDplus::db()->query("select name, description, protected, visible, value from ###config");		
					while ($row = $res->fetch_object()) {		
						$alloptions[ $row->name ] = $row->value;		
					}
				}elseif(class_exists(\IO4\Context::class) && null !== \IO4\Context::config() ){
					$config = \IO4\Context::config();
					foreach ($config as $path => $value) {
                        //  echo "\n" . $path . ": " . $value;
						$alloptions[ $path ] = $value;
                    }
				}else{
				    throw new \Exception('Not implemented in '.__FUNCTION__.' line '.__LINE__.' '.basename(__FILE__));
				}		
		
		
		if ( ! wp_installing() || ! is_multisite() ) {
			/**
			 * Filters all options before caching them.
			 *
			 * @since 4.9.0
			 *
			 * @param array $alloptions Array with all options.
			 */
			$alloptions = apply_filters( 'pre_cache_alloptions', $alloptions );

			wp_cache_add( 'alloptions', $alloptions, 'options' );
		}
	}

	/**
	 * Filters all options after retrieving them.
	 *
	 * @since 4.9.0
	 *
	 * @param array $alloptions Array with all options.
	 */
	return apply_filters( 'alloptions', $alloptions );
}


function add_option( string $option, $value = '', $deprecated = '', $autoload = null ) {
	//global $wpdb;

	if ( ! empty( $deprecated ) ) {
		_deprecated_argument( __FUNCTION__, '2.3.0' );
	}

	if ( is_scalar( $option ) ) {
		$option = trim( $option );
	}

	if ( empty( $option ) ) {
		return false;
	}

	/*
	 * Until a proper _deprecated_option() function can be introduced,
	 * redirect requests to deprecated keys to the new, correct ones.
	 */
	$deprecated_keys = array(
		'blacklist_keys'    => 'disallowed_keys',
		'comment_whitelist' => 'comment_previously_approved',
	);

	if ( isset( $deprecated_keys[ $option ] ) && (!function_exists('wp_installing') || !call_user_func('wp_installing') ) ) {
		_deprecated_argument(
			__FUNCTION__,
			'5.5.0',
			sprintf(
				/* translators: 1: Deprecated option key, 2: New option key. */
				__( 'The "%1$s" option key has been renamed to "%2$s".' ),
				$option,
				$deprecated_keys[ $option ]
			)
		);
		return add_option( $deprecated_keys[ $option ], $value, $deprecated, $autoload );
	}

	wp_protect_special_option( $option );

	if ( is_object( $value ) ) {
		$value = clone $value;
	}

	$value = sanitize_option( $option, $value );

	/*
	 * Make sure the option doesn't already exist.
	 * We can check the 'notoptions' cache before we ask for a DB query.
	 */
	$notoptions = wp_cache_get( 'notoptions', 'options' );

	if ( ! is_array( $notoptions ) || ! isset( $notoptions[ $option ] ) ) {
		/** This filter is documented in wp-includes/option.php */
		if ( apply_filters( "default_option_{$option}", false, $option, false ) !== get_option( $option ) ) {
			return false;
		}
	}

	$serialized_value = maybe_serialize( $value );

	$autoload = wp_determine_option_autoload_value( $option, $value, $serialized_value, $autoload );

	/**
	 * Fires before an option is added.
	 *
	 * @since 2.9.0
	 *
	 * @param string $option Name of the option to add.
	 * @param mixed  $value  Value of the option.
	 */
	do_action( 'add_option', $option, $value );
/*
	$result = $wpdb->query( $wpdb->prepare( "INSERT INTO `$wpdb->options` (`option_name`, `option_value`, `autoload`) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`), `autoload` = VALUES(`autoload`)", $option, $serialized_value, $autoload ) );
	if ( ! $result ) {
		return false;
	}
*/
	// OIDplus::config()->setValue($option, $serialized_value);
	throw new \Exception('Not implemented in '.__FUNCTION__.' line '.__LINE__.' '.basename(__FILE__));
	if ((!function_exists('wp_installing') || !call_user_func('wp_installing') ) ) {
		if ( in_array( $autoload, wp_autoload_values_to_autoload(), true ) ) {
			$alloptions            = wp_load_alloptions( true );
			$alloptions[ $option ] = $serialized_value;
			wp_cache_set( 'alloptions', $alloptions, 'options' );
		} else {
			wp_cache_set( $option, $serialized_value, 'options' );
		}
	}

	// This option exists now.
	$notoptions = wp_cache_get( 'notoptions', 'options' ); // Yes, again... we need it to be fresh.

	if ( is_array( $notoptions ) && isset( $notoptions[ $option ] ) ) {
		unset( $notoptions[ $option ] );
		wp_cache_set( 'notoptions', $notoptions, 'options' );
	}

	/**
	 * Fires after a specific option has been added.
	 *
	 * The dynamic portion of the hook name, `$option`, refers to the option name.
	 *
	 * @since 2.5.0 As "add_option_{$name}"
	 * @since 3.0.0
	 *
	 * @param string $option Name of the option to add.
	 * @param mixed  $value  Value of the option.
	 */
	do_action( "add_option_{$option}", $option, $value );

	/**
	 * Fires after an option has been added.
	 *
	 * @since 2.9.0
	 *
	 * @param string $option Name of the added option.
	 * @param mixed  $value  Value of the option.
	 */
	do_action( 'added_option', $option, $value );

	return true;
}
 

 
function get_option( string $option, $default_value = false ) {
	//global $wpdb;

	if ( is_scalar( $option ) ) {
		$option = trim( $option );
	}

	if ( empty( $option ) ) {
		return false;
	}

	/*
	 * Until a proper _deprecated_option() function can be introduced,
	 * redirect requests to deprecated keys to the new, correct ones.
	 */
	$deprecated_keys = array(
		'blacklist_keys'    => 'disallowed_keys',
		'comment_whitelist' => 'comment_previously_approved',
	);

	if ( isset( $deprecated_keys[ $option ] ) && (!function_exists('wp_installing') || !call_user_func('wp_installing') ) ) {
		_deprecated_argument(
			__FUNCTION__,
			'5.5.0',
			sprintf(
				/* translators: 1: Deprecated option key, 2: New option key. */
				__( 'The "%1$s" option key has been renamed to "%2$s".' ),
				$option,
				$deprecated_keys[ $option ]
			)
		);
		return get_option( $deprecated_keys[ $option ], $default_value );
	}

	/**
	 * Filters the value of an existing option before it is retrieved.
	 *
	 * The dynamic portion of the hook name, `$option`, refers to the option name.
	 *
	 * Returning a value other than false from the filter will short-circuit retrieval
	 * and return that value instead.
	 *
	 * @since 1.5.0
	 * @since 4.4.0 The `$option` parameter was added.
	 * @since 4.9.0 The `$default_value` parameter was added.
	 *
	 * @param mixed  $pre_option    The value to return instead of the option value. This differs from
	 *                              `$default_value`, which is used as the fallback value in the event
	 *                              the option doesn't exist elsewhere in get_option().
	 *                              Default false (to skip past the short-circuit).
	 * @param string $option        Option name.
	 * @param mixed  $default_value The fallback value to return if the option does not exist.
	 *                              Default false.
	 */
	$pre = apply_filters( "pre_option_{$option}", false, $option, $default_value );

	/**
	 * Filters the value of all existing options before it is retrieved.
	 *
	 * Returning a truthy value from the filter will effectively short-circuit retrieval
	 * and return the passed value instead.
	 *
	 * @since 6.1.0
	 *
	 * @param mixed  $pre_option    The value to return instead of the option value. This differs from
	 *                              `$default_value`, which is used as the fallback value in the event
	 *                              the option doesn't exist elsewhere in get_option().
	 *                              Default false (to skip past the short-circuit).
	 * @param string $option        Name of the option.
	 * @param mixed  $default_value The fallback value to return if the option does not exist.
	 *                              Default false.
	 */
	$pre = apply_filters( 'pre_option', $pre, $option, $default_value );

	if ( false !== $pre ) {
		return $pre;
	}

	if ( defined( 'WP_SETUP_CONFIG' ) ) {
		return false;
	}

	// Distinguish between `false` as a default, and not passing one.
	$passed_default = func_num_args() > 1;

	if ( (!function_exists('wp_installing') || !call_user_func('wp_installing') ) ) {
		$alloptions = wp_load_alloptions();

		if ( isset( $alloptions[ $option ] ) ) {
			$value = $alloptions[ $option ];
		} else {
			$value = wp_cache_get( $option, 'options' );

			if ( false === $value ) {
				// Prevent non-existent options from triggering multiple queries.
				$notoptions = wp_cache_get( 'notoptions', 'options' );

				// Prevent non-existent `notoptions` key from triggering multiple key lookups.
				if ( ! is_array( $notoptions ) ) {
					$notoptions = array();
					wp_cache_set( 'notoptions', $notoptions, 'options' );
				} elseif ( isset( $notoptions[ $option ] ) ) {
					/**
					 * Filters the default value for an option.
					 *
					 * The dynamic portion of the hook name, `$option`, refers to the option name.
					 *
					 * @since 3.4.0
					 * @since 4.4.0 The `$option` parameter was added.
					 * @since 4.7.0 The `$passed_default` parameter was added to distinguish between a `false` value and the default parameter value.
					 *
					 * @param mixed  $default_value  The default value to return if the option does not exist
					 *                               in the database.
					 * @param string $option         Option name.
					 * @param bool   $passed_default Was `get_option()` passed a default value?
					 */
					return apply_filters( "default_option_{$option}", $default_value, $option, $passed_default );
				}
/*
			//	$row = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );
                $res =
					OIDplus::db()->query("select name, description, protected, visible, value from ###config WHERE option_name = ? LIMIT 1",
										[$option]);
*/
				
				//$value = OIDplus::config()->getValue($option, null);
			
				if(class_exists(\ViaThinkSoft\OIDplus\Core\OIDplus::class) ){
					$value = OIDplus::config()->getValue($option, null);
				}elseif(class_exists(\IO4\Context::class) && null !== \IO4\Context::config() ){
					\IO4\Context::config()->get($option);
				}else{
				    throw new \Exception('Not implemented in '.__FUNCTION__.' line '.__LINE__.' '.basename(__FILE__));
				}
				
				// Has to be get_row() instead of get_var() because of funkiness with 0, false, null values.
				if ( $value   ) {
					//$value = $row->option_value;
					wp_cache_add( $option, $value, 'options' );
				} else { // Option does not exist, so we must cache its non-existence.
					$notoptions[ $option ] = true;
					wp_cache_set( 'notoptions', $notoptions, 'options' );

					/** This filter is documented in wp-includes/option.php */
					return apply_filters( "default_option_{$option}", $default_value, $option, $passed_default );
				}
			}
		}
	} else {
		/*
		$suppress = $wpdb->suppress_errors();
		$row      = $wpdb->get_row( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name = %s LIMIT 1", $option ) );
		$wpdb->suppress_errors( $suppress );
       */
	//	$value = OIDplus::config()->getValue($option, null);
		throw new \Exception('Not implemented in '.__FUNCTION__.' line '.__LINE__.' '.basename(__FILE__));
		if ($value ) {
			//$value = $row->option_value;
		} else {
			/** This filter is documented in wp-includes/option.php */
			return apply_filters( "default_option_{$option}", $default_value, $option, $passed_default );
		}
	}

	// If home is not set, use siteurl.
	if ( 'home' === $option && '' === $value ) {
		return get_option( 'siteurl' );
	}

	if ( in_array( $option, array( 'siteurl', 'home', 'category_base', 'tag_base' ), true ) ) {
		$value = untrailingslashit( $value );
	}

	/**
	 * Filters the value of an existing option.
	 *
	 * The dynamic portion of the hook name, `$option`, refers to the option name.
	 *
	 * @since 1.5.0 As 'option_' . $setting
	 * @since 3.0.0
	 * @since 4.4.0 The `$option` parameter was added.
	 *
	 * @param mixed  $value  Value of the option. If stored serialized, it will be
	 *                       unserialized prior to being returned.
	 * @param string $option Option name.
	 */
	return apply_filters( "option_{$option}", maybe_unserialize( $value ), $option );
}
 

if(!function_exists('maybe_unserialize')){
function maybe_unserialize( $data ) {
	if ( is_serialized( $data ) ) { // Don't attempt to unserialize data that wasn't serialized going in.
		return @unserialize( trim( $data ) );
	}

	return $data;
}
}

 

if(!function_exists('untrailingslashit')){ 
function untrailingslashit(string $value ) {
	return rtrim( $value, '/\\' );
}
} 

if(!function_exists('_deprecated_argument')){ 
function _deprecated_argument(string $function_name, string $version, string $message = '' ) {

	/**
	 * Fires when a deprecated argument is called.
	 *
	 * @since 3.0.0
	 *
	 * @param string $function_name The function that was called.
	 * @param string $message       A message regarding the change.
	 * @param string $version       The version of WordPress that deprecated the argument used.
	 */
	do_action( 'deprecated_argument_run', $function_name, $message, $version );

	/**
	 * Filters whether to trigger an error for deprecated arguments.
	 *
	 * @since 3.0.0
	 *
	 * @param bool $trigger Whether to trigger the error for deprecated arguments. Default true.
	 */
	if ( defined('WP_DEBUG') && WP_DEBUG && apply_filters( 'deprecated_argument_trigger_error', true ) ) {
		if ( function_exists( '__' ) ) {
			if ( $message ) {
				$message = sprintf(
					/* translators: 1: PHP function name, 2: Version number, 3: Optional message regarding the change. */
					__( 'Function %1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s' ),
					$function_name,
					$version,
					$message
				);
			} else {
				$message = sprintf(
					/* translators: 1: PHP function name, 2: Version number. */
					__( 'Function %1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.' ),
					$function_name,
					$version
				);
			}
		} else {
			if ( $message ) {
				$message = sprintf(
					'Function %1$s was called with an argument that is <strong>deprecated</strong> since version %2$s! %3$s',
					$function_name,
					$version,
					$message
				);
			} else {
				$message = sprintf(
					'Function %1$s was called with an argument that is <strong>deprecated</strong> since version %2$s with no alternative available.',
					$function_name,
					$version
				);
			}
		}

	//	wp_trigger_error( '', $message, E_USER_DEPRECATED );
		trigger_error( '', $message, \E_USER_DEPRECATED );
	}
}//_deprecated_argument
}






  
  
 


 

 
	
  
	
  
	
	
 	
function tag_escape(string $tag_name ) {
	$safe_tag = strtolower( preg_replace( '/[^a-zA-Z0-9-_:]/', '', $tag_name ) );
	/**
	 * Filters a string cleaned and escaped for output as an HTML tag.
	 *
	 * @since 2.8.0
	 *
	 * @param string $safe_tag The tag name after it has been escaped.
	 * @param string $tag_name The text before it was escaped.
	 */
	return apply_filters( 'tag_escape', $safe_tag, $tag_name );
}	
 
/**
 * Returns RegEx body to liberally match an opening HTML tag.
 *
 * Matches an opening HTML tag that:
 * 1. Is self-closing or
 * 2. Has no body but has a closing tag of the same name or
 * 3. Contains a body and a closing tag of the same name
 *
 * Note: this RegEx does not balance inner tags and does not attempt
 * to produce valid HTML
 *
 * @since 3.6.0
 *
 * @param string $tag An HTML tag name. Example: 'video'.
 * @return string Tag RegEx.
 */
 	
function get_tag_regex( string $tag ) {
	if ( empty( $tag ) ) {
		return '';
	}
	return sprintf( '<%1$s[^<]*(?:>[\s\S]*<\/%1$s>|\s*\/>)', tag_escape( $tag ) );
}
 
/**
 * Indicates if a given slug for a character set represents the UTF-8 text encoding.
 *
 * A charset is considered to represent UTF-8 if it is a case-insensitive match
 * of "UTF-8" with or without the hyphen.
 *
 * Example:
 *
 *     true  === _is_utf8_charset( 'UTF-8' );
 *     true  === _is_utf8_charset( 'utf8' );
 *     false === _is_utf8_charset( 'latin1' );
 *     false === _is_utf8_charset( 'UTF 8' );
 *
 *     // Only strings match.
 *     false === _is_utf8_charset( [ 'charset' => 'utf-8' ] );
 *
 * `is_utf8_charset` should be used outside of this file.
 *
 * @ignore
 * @since 6.6.1
 *
 * @param string $charset_slug Slug representing a text character encoding, or "charset".
 *                             E.g. "UTF-8", "Windows-1252", "ISO-8859-1", "SJIS".
 *
 * @return bool Whether the slug represents the UTF-8 encoding.
 */
function _is_utf8_charset(string $charset_slug ) : bool {
	if ( ! is_string( $charset_slug ) ) {
		return false;
	}

	return (
		0 === strcasecmp( 'UTF-8', $charset_slug ) ||
		0 === strcasecmp( 'UTF8', $charset_slug )
	);
}
/**
 * Indicates if a given slug for a character set represents the UTF-8
 * text encoding. If not provided, examines the current blog's charset.
 *
 * A charset is considered to represent UTF-8 if it is a case-insensitive
 * match of "UTF-8" with or without the hyphen.
 *
 * Example:
 *
 *     true  === is_utf8_charset( 'UTF-8' );
 *     true  === is_utf8_charset( 'utf8' );
 *     false === is_utf8_charset( 'latin1' );
 *     false === is_utf8_charset( 'UTF 8' );
 *
 *     // Only strings match.
 *     false === is_utf8_charset( [ 'charset' => 'utf-8' ] );
 *
 *     // Without a given charset, it depends on the site option "blog_charset".
 *     $is_utf8 = is_utf8_charset();
 *
 * @since 6.6.0
 * @since 6.6.1 A wrapper for _is_utf8_charset
 *
 * @see _is_utf8_charset
 *
 * @param string|null $blog_charset Optional. Slug representing a text character encoding, or "charset".
 *                                  E.g. "UTF-8", "Windows-1252", "ISO-8859-1", "SJIS".
 *                                  Default value is to infer from "blog_charset" option.
 * @return bool Whether the slug represents the UTF-8 encoding.
 */
function is_utf8_charset(string|null  $blog_charset = null ) : bool {
	return _is_utf8_charset( $blog_charset ?? get_option( 'blog_charset' ) );
}

/**
 * Retrieves a canonical form of the provided charset appropriate for passing to PHP
 * functions such as htmlspecialchars() and charset HTML attributes.
 *
 * @since 3.6.0
 * @access private
 *
 * @see https://core.trac.wordpress.org/ticket/23688
 *
 * @param string $charset A charset name, e.g. "UTF-8", "Windows-1252", "SJIS".
 * @return string The canonical form of the charset.
 */
function _canonical_charset(string $charset ) {
	if ( is_utf8_charset( $charset ) ) {
		return 'UTF-8';
	}

	/*
	 * Normalize the ISO-8859-1 family of languages.
	 *
	 * This is not required for htmlspecialchars(), as it properly recognizes all of
	 * the input character sets that here are transformed into "ISO-8859-1".
	 *
	 * @todo Should this entire check be removed since it's not required for the stated purpose?
	 * @todo Should WordPress transform other potential charset equivalents, such as "latin1"?
	 */
	if (
		( 0 === strcasecmp( 'iso-8859-1', $charset ) ) ||
		( 0 === strcasecmp( 'iso8859-1', $charset ) )
	) {
		return 'ISO-8859-1';
	}

	return $charset;
}
 
 
 
	 
	
	
 
/*!*
 * Hooks a function or method to a specific filter action.
 *
 * @param string $tag The name of the filter to hook the $function_to_add to.
 * @param callback $function_to_add The name of the function to be called when the filter is applied.
 * @param int $priority optional. Used to specify the order in which the functions associated with a particular
 * action are executed (default: 10). Lower numbers correspond with earlier execution,
 * and functions with the same priority are executed in the order in which they were
 * added to the action.
 * @param int $accepted_args optional. The number of arguments the function accept (default 1).
 * @return boolean true
 */
 
function add_filter(string $tag, string | array | \callable | \Closure $function_to_add,  int | bool | null  $priority = 10, int | null $accepted_args = 1)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::addFilter($tag, $function_to_add, $priority, $accepted_args);
}
 
/*!*
 * Removes a function from a specified filter hook.
 *
 * @param string $tag The filter hook to which the function to be removed is hooked.
 * @param callback $function_to_remove The name of the function which should be removed.
 * @param int $priority optional. The priority of the function (default: 10).
 * @param int $accepted_args optional. The number of arguments the function accepts (default: 1).
 * @return boolean Whether the function existed before it was removed.
 */
 
function remove_filter(string $tag,  string | array | \callable | \Closure $function_to_remove, int | bool | null $priority = 10)
{
  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//	return Whooks::removeFilter($tag, $function_to_remove, $priority);
}
 
/**
 * Remove all of the hooks from a filter.
 *
 * @param string $tag The filter to remove hooks from.
 * @param int $priority The priority number to remove.
 * @return bool true when finished.
 */
 
function remove_all_filters(string $tag,  int | bool | null  $priority = false) : bool
{
  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//	return Whooks::removeAllFilters($tag, $priority);
}
 
/**
 * Check if any filter has been registered for a hook.
 *
 * @param string $tag The name of the filter hook.
 * @param callback $function_to_check optional.
 * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything
 * registered. When checking a specific function, the priority of that hook is returned,
 * or false if the function is not attached. When using the $function_to_check argument, this
 * function may return a non-boolean value that evaluates to false (e.g.) 0, so use
 * the === operator for testing the return value.
 */
 
function has_filter(string $tag,string | array | \callable | \Closure | bool $function_to_check = false)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::hasFilter($tag, $function_to_check);
}
 
/**
 * Call the functions added to a filter hook.
 *
 * @param string $tag The name of the filter hook.
 * @param mixed $value The value on which the filters hooked to <tt>$tag</tt> are applied on.
 * @param mixed $var,... Additional variables passed to the functions hooked to <tt>$tag</tt>.
 * @return mixed The filtered value after all hooked functions are applied to it.
 */
 
function apply_filters(string $tag, mixed $value)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::applyFilters($tag, $value);
}
 
/**
 * Execute functions hooked on a specific filter hook, specifying arguments in an array.
 *
 * @param string $tag The name of the filter hook.
 * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
 * @return mixed The filtered value after all hooked functions are applied to it.
 */
 
function apply_filters_ref_array(string $tag, mixed $args)
{
	  return \call_user_func_array([Hooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::applyFiltersRefArray($tag, $args);
}
 
/**
 * Hooks a function on to a specific action.
 *
 * @param string $tag The name of the action to which the $function_to_add is hooked.
 * @param callback $function_to_add The name of the function you wish to be called.
 * @param int $priority optional. Used to specify the order in which the functions associated with a
 * particular action are executed (default: 10). Lower numbers correspond with
 * earlier execution, and functions with the same priority are executed in the
 * order in which they were added to the action.
 * @param int $accepted_args optional. The number of arguments the function accept (default 1).
 * @return mixed
 */
 
function add_action(string $tag, string | array | \callable | \Closure $function_to_add, int | bool | null $priority = 10,int |null $accepted_args = 1)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::addAction($tag, $function_to_add, $priority, $accepted_args);
}
 
/**
 * Check if any action has been registered for a hook.
 *
 * @param string $tag The name of the action hook.
 * @param callback $function_to_check optional.
 * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything
 * registered. When checking a specific function, the priority of that hook is returned,
 * or false if the function is not attached. When using the $function_to_check argument,
 * this function may return a non-boolean value that evaluates to false. (e.g.) 0, so use
 * the === operator for testing the return value.
 */
 
function has_action(string $tag, string | array | \callable | \Closure | bool $function_to_check = false)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::hasAction($tag, $function_to_check);
}
 
/**
 * Removes a function from a specified action hook.
 *
 * @param string $tag The action hook to which the function to be removed is hooked.
 * @param callback $function_to_remove The name of the function which should be removed.
 * @param int $priority optional The priority of the function (default: 10).
 * @return boolean Whether the function is removed.
 */
 
function remove_action(string $tag, string | array | \callable | \Closure  $function_to_remove,int | bool | null $priority = 10)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::removeAction($tag, $function_to_remove, $priority);
}
 
/**
 * Remove all of the hooks from an action.
 *
 * @param string $tag The action to remove hooks from.
 * @param int $priority The priority number to remove them from.
 * @return bool True when finished.
 */
 
function remove_all_actions(string $tag,int | bool | null $priority = false)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::removeAllActions($tag, $priority);
}
 
/**
 * Execute functions hooked on a specific action hook.
 *
 * @param string $tag The name of the action to be executed.
 * @param mixed $arg,... Optional additional arguments which are passed on to the
 * functions hooked to the action.
 * @return null Will return null if $tag does not exist in $filter array
 */
 
function do_action(string $tag, mixed $arg = '')
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::doAction($tag, $arg);
}
 
/**
 * Execute functions hooked on a specific action hook, specifying arguments in an array.
 *
 * @param string $tag The name of the action to be executed.
 * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
 * @return null Will return null if $tag does not exist in $filter array
 */
 
function do_action_ref_array(string $tag, array $args)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::doActionRefArray($tag, $args);
}
 
/**
 * Retrieve the number of times an action is fired.
 *
 * @param string $tag The name of the action hook.
 * @return int The number of times action hook <tt>$tag</tt> is fired
 */
 
function did_action(string $tag)
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::didAction($tag);
}
 


/**
 * Retrieve the name of the current filter or action.
 *
 * @return string Hook name of the current filter or action.
 */
 
function current_filter()
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::currentFilter();
}
 
/**
 * Retrieve the name of the current action.
 *
 * @return string Hook name of the current action.
 */
 
function current_action()
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::currentAction();
}
 
/**
 * Retrieve the name of a filter currently being processed.
 *
 * current_filter() only returns the most recent filter or action
 * being executed. did_action() returns true once the action is initially
 * processed. This function allows detection for any filter currently being
 * executed (despite not being the most recent filter to fire, in the case of
 * hooks called from hook callbacks) to be verified.
 *
 * @param null|string $filter Optional. Filter to check. Defaults to null, which
 * checks if any filter is currently being run.
 * @return bool Whether the filter is currently in the stack
 */
 
function doing_filter(null|string $filter = null) : bool
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::doingFilter($filter);
}
 
/**
 * Retrieve the name of an action currently being processed.
 *
 * @param string|null $action Optional. Action to check. Defaults to null, which checks
 * if any action is currently being run.
 * @return bool Whether the action is currently in the stack.
 */
 
function doing_action(string|null $action = null) : bool
{
  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//	return Whooks::doingAction($action);
}
 
	
 
function add_shortcode( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::doingFilter($filter);
}
 	
	
 
function do_shortcode( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
	//return Whooks::doingFilter($filter);
}
 
	
	
	
 
function strip_shortcodes( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 		
	

 
function shortcode_atts( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 		
	

 
function shortcode_parse_atts( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 		
	
	
	


 
function has_shortcode( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 		
		
	

 
function display_shortcodes( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 			
				
 
function did_filter( )
{
	  return \call_user_func_array([WPHooks::getInstance(), __FUNCTION__], func_get_args());
}
 	 






 
function wp_kses_normalize_entities( $content, $context = 'html' ) {
	// Disarm all entities by converting & to &amp;
	$content = str_replace( '&', '&amp;', $content );

	// Change back the allowed entities in our list of allowed entities.
	if ( 'xml' === $context ) {
		$content = preg_replace_callback( '/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', 'wp_kses_xml_named_entities', $content );
	} else {
		$content = preg_replace_callback( '/&amp;([A-Za-z]{2,8}[0-9]{0,2});/', 'wp_kses_named_entities', $content );
	}
	$content = preg_replace_callback( '/&amp;#(0*[0-9]{1,7});/', 'wp_kses_normalize_entities2', $content );
	$content = preg_replace_callback( '/&amp;#[Xx](0*[0-9A-Fa-f]{1,6});/', 'wp_kses_normalize_entities3', $content );

	return $content;
}
 

 
function _wp_specialchars( $text, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
	$text = (string) $text;

	if ( 0 === strlen( $text ) ) {
		return '';
	}

	// Don't bother if there are no specialchars - saves some processing.
	if ( ! preg_match( '/[&<>"\']/', $text ) ) {
		return $text;
	}

	// Account for the previous behavior of the function when the $quote_style is not an accepted value.
	if ( empty( $quote_style ) ) {
		$quote_style = ENT_NOQUOTES;
	} elseif ( ENT_XML1 === $quote_style ) {
		$quote_style = ENT_QUOTES | ENT_XML1;
	} elseif ( ! in_array( $quote_style, array( ENT_NOQUOTES, ENT_COMPAT, ENT_QUOTES, 'single', 'double' ), true ) ) {
		$quote_style = ENT_QUOTES;
	}

	$charset = _canonical_charset( $charset ? $charset : get_option( 'blog_charset' ) );

	$_quote_style = $quote_style;

	if ( 'double' === $quote_style ) {
		$quote_style  = ENT_COMPAT;
		$_quote_style = ENT_COMPAT;
	} elseif ( 'single' === $quote_style ) {
		$quote_style = ENT_NOQUOTES;
	}

	if ( ! $double_encode ) {
		/*
		 * Guarantee every &entity; is valid, convert &garbage; into &amp;garbage;
		 * This is required for PHP < 5.4.0 because ENT_HTML401 flag is unavailable.
		 */
		$text = wp_kses_normalize_entities( $text, ( $quote_style & ENT_XML1 ) ? 'xml' : 'html' );
	}

	$text = htmlspecialchars( $text, $quote_style, $charset, $double_encode );

	// Back-compat.
	if ( 'single' === $_quote_style ) {
		$text = str_replace( "'", '&#039;', $text );
	}

	return $text;
}
 


 
function wp_check_invalid_utf8( $text, $strip = false ) {
	$text = (string) $text;

	if ( 0 === strlen( $text ) ) {
		return '';
	}

	// Store the site charset as a static to avoid multiple calls to get_option().
	static $is_utf8 = null;
	if ( ! isset( $is_utf8 ) ) {
		$is_utf8 = is_utf8_charset();
	}
	if ( ! $is_utf8 ) {
		return $text;
	}

	// Check for support for utf8 in the installed PCRE library once and store the result in a static.
	static $utf8_pcre = null;
	if ( ! isset( $utf8_pcre ) ) {
		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		$utf8_pcre = @preg_match( '/^./u', 'a' );
	}
	// We can't demand utf8 in the PCRE installation, so just return the string in those cases.
	if ( ! $utf8_pcre ) {
		return $text;
	}

	// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged -- preg_match fails when it encounters invalid UTF8 in $text.
	if ( 1 === @preg_match( '/^./us', $text ) ) {
		return $text;
	}

	// Attempt to strip the bad chars if requested (not recommended).
	if ( $strip && function_exists( 'iconv' ) ) {
		return iconv( 'utf-8', 'utf-8', $text );
	}

	return '';
}
 


 
function esc_html( $text ) {
	$safe_text = wp_check_invalid_utf8( $text );
	$safe_text = _wp_specialchars( $safe_text, ENT_QUOTES );
	/**
	 * Filters a string cleaned and escaped for output in HTML.
	 *
	 * Text passed to esc_html() is stripped of invalid or special characters
	 * before output.
	 *
	 * @since 2.8.0
	 *
	 * @param string $safe_text The text after it has been escaped.
	 * @param string $text      The text prior to being escaped.
	 */
	return apply_filters( 'esc_html', $safe_text, $text );
}
 


 

 


 
function wp_autoload_values_to_autoload() {
	$autoload_values = array( 'yes', 'on', 'auto-on', 'auto' );

	/**
	 * Filters the autoload values that should be considered for autoloading from the options table.
	 *
	 * The filter can only be used to remove autoload values from the default list.
	 *
	 * @since 6.6.0
	 *
	 * @param string[] $autoload_values Autoload values used to autoload option.
	 *                               Default list contains 'yes', 'on', 'auto-on', and 'auto'.
	 */
	$filtered_values = apply_filters( 'wp_autoload_values_to_autoload', $autoload_values );

	return array_intersect( $filtered_values, $autoload_values );
}
 

 
function wp_die(string $message = '',string $title = '',array $args = array() ) {
  echo "<h1>$title</h1>$message<br /><small>@ToDo: ".__FUNCTION__."</small>";
  ob_end_flush();
  die();
}
 


function wp_determine_option_autoload_value( $option, $value, $serialized_value, $autoload ) {

	// Check if autoload is a boolean.
	if ( is_bool( $autoload ) ) {
		return $autoload ? 'on' : 'off';
	}

	switch ( $autoload ) {
		case 'on':
		case 'yes':
			return 'on';
		case 'off':
		case 'no':
			return 'off';
	}

	/**
	 * Allows to determine the default autoload value for an option where no explicit value is passed.
	 *
	 * @since 6.6.0
	 *
	 * @param bool|null $autoload The default autoload value to set. Returning true will be set as 'auto-on' in the
	 *                            database, false will be set as 'auto-off', and null will be set as 'auto'.
	 * @param string    $option   The passed option name.
	 * @param mixed     $value    The passed option value to be saved.
	 */
	$autoload = apply_filters( 'wp_default_autoload_value', null, $option, $value, $serialized_value );
	if ( is_bool( $autoload ) ) {
		return $autoload ? 'auto-on' : 'auto-off';
	}

	return 'auto';
}