<?php 
/*
#Author: Cengkuru Micheal
9/12/14
11:29 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$config['site_name'] = 'Uganda Integrated Tender Portal';//name of website

	define('BASE_URL', 'http://localhost/ppda/');#Set to HTTPS:// if SECURE_MODE = TRUE
	
	define('SITE_TITLE', "PPDA Integrated Tender Portal");
		
	define('SITE_SLOGAN', "Integrated Tender Portal");
	        	        
	define('SITE_ADMIN_MAIL', "sirotim@gmail.com");
	
	define('SITE_ADMIN_NAME', "ITP Admin");
	
	define('SYS_TIMEZONE', "America/Los_Angeles");
	
	define('NUM_OF_ROWS_PER_PAGE', "10");
	
	define('IMAGE_URL', BASE_URL."images/");
	
	define('HOME_URL', getcwd()."/");
	
	define('UPLOAD_DIRECTORY',  HOME_URL."uploads/");
	
	define('MAX_FILE_SIZE', 40000000);
	
	define('ALLOWED_EXTENSIONS', ".doc,.docx,.txt,.pdf,.xls,.xlsx");
	
	define('MAXIMUM_FILE_NAME_LENGTH', 100);
	
	define("MINIFY_JS", true);
	
	define("NOREPLY_EMAIL", "votim@newwavetech.co.ug");
	
	define("APPEALS_EMAIL", "info@newwavetech.co.ug");
	
	define("SECURITY_EMAIL", "info@newwavetech.co.ug");
	
	
	/*
	|--------------------------------------------------------------------------
	| URI PROTOCOL
	|--------------------------------------------------------------------------
	|
	| The default setting of "AUTO" works for most servers.
	| If your links do not seem to work, try one of the other delicious flavors:
	|
	| 'AUTO'	
	| 'REQUEST_URI'
	| 'PATH_INFO'	
	| 'QUERY_STRING'
	| 'ORIG_PATH_INFO'
	|
	*/
	
	define('URI_PROTOCOL', 'AUTO'); // Set "AUTO" For WINDOWS
									       // Set "REQUEST_URI" For LINUX


// Email Settings
#  ==============

	define('SMTP_HOST', "smtp.1and1.com");
	
	define('SMTP_PORT', "25");
	
	define('SMTP_USER', "sirotim@gmail.com"); 
	
	define('SMTP_PASS', "newwave");
	
	define('FLAG_TO_REDIRECT', "1");// 1 => Redirect emails to a specific mail id, 
									 // 0 => No need to redirect emails.
	/*
	| If "FLAG_TO_REDIRECT" is set to 1, it will redirect all the mails from this site
	| to the email address  defined in "MAILID_TO_REDIRECT".
	*/
		
	define('MAILID_TO_REDIRECT', "sirotim@gmail.com");

/*	
 *---------------------------------------------------------------
 * QUERY CACHE SETTINGS
 *---------------------------------------------------------------
 */
 	
	define('ENABLE_QUERY_CACHE', TRUE); 
 	
 	define('QUERY_FILE', HOME_URL.'application/helpers/queries_list_helper.php');