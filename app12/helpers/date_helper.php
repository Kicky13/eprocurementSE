<?php defined('BASEPATH') OR exit('No direct script access allowed');

$sys_helper = SYSDIR.DIRECTORY_SEPARATOR.'/helpers/date_helper.php';
file_exists($sys_helper) AND require_once($sys_helper);

if (!function_exists('today')) {
  /**
   * Get date time now!
   *
   * @param  string  $fmt Date time format, default is 'us'
   * @return string  
   */
  function today($format = 'us') {
  	return unix_to_human(now(), true, $format);
  }
}


if (!function_exists('today_sql')) {
	/**
	 * Get date time now in sql format
	 *
	 * @return string something like 2018-03-28 16:13:13
	 */
	function today_sql() {
		return today('non-us');
	}
}