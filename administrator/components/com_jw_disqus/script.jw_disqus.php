<?php
/**
 * @version		3.2
 * @package		DISQUS Comments for Joomla! (package)
 * @author		JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class Com_jw_disqusInstallerScript {
	function postflight($type, $parent) {
		$db = JFactory::getDBO();
		$db->setQuery("UPDATE #__extensions SET enabled = 0 WHERE client_id = 1 AND element = ".$db->Quote($parent->get('element')));
		$db->query();
	}
}
