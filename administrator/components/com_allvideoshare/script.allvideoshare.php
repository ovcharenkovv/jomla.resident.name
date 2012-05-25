<?php

/*
 * @version		$Id: script.allvideoshare.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class COM_AllVideoShareInstallerScript {

	function postflight($type, $parent) {
		define('ALL_VIDEO_SHARE_INSTALL_HACK', 1);
		require_once('install.allvideoshare.php');
	}
	
}

?>