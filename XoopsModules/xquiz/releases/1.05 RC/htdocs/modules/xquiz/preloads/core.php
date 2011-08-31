<?php

/**
 * Questionair forms with export and plugin set (based on formulaire)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @since           1.0.5
 * @author          Simon Roberts <simon@chronolabs.coop>
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XquizCorePreload extends XoopsPreloadItem
{
	
	function eventCoreIncludeCommonStart($args)
	{
		$GLOBAL['quiz']['profiles'] = array();
		$cookie_parm = session_get_cookie_params();
		
		// Retrieve the Local Facebook ID from Facebook Cookie		
		/*session_set_cookie_params(3600*24*7, '/', '.facebook.com');
		session_start();
		$GLOBAL['quiz']['profiles']['facebook']['id'] = $_COOKIE['c_user'];  
		$GLOBAL['quiz']['profiles']['facebook']['url'] = 'http://www.facebook.com/profile.php?id='.$_COOKIE['c_user'];
		if (empty($GLOBAL['quiz']['profiles']['facebook']['id']))
			unset($GLOBAL['quiz']['profiles']['facebook']);
		session_destroy();*/
		
		// Retrieve the Local Twitter ID from Twitter Cookie	
		/*session_set_cookie_params(3600*24*7, '/', '.twitter.com');
		session_start();
		$GLOBAL['quiz']['profiles']['twitter']['id'] = $_COOKIE['guest_id'];  
		if (empty($GLOBAL['quiz']['profiles']['twitter']['id']))
			unset($GLOBAL['quiz']['profiles']['twitter']);
		session_destroy();*/
		
		//session_set_cookie_params($cookie_parm['lifetime'], $cookie_parm['path'], $cookie_parm['domain']);
	}
	
}

?>