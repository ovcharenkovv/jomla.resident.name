<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
jimport('joomla.application.component.controller');

$l['cp']	= array('COM_PHOCAGALLERY_CONTROL_PANEL', '');
$l['i']		= array('COM_PHOCAGALLERY_IMAGES', 'phocagalleryimgs');
$l['c']		= array('COM_PHOCAGALLERY_CATEGORIES', 'phocagallerycs');
$l['t']		= array('COM_PHOCAGALLERY_THEMES', 'phocagalleryt');
$l['cr']	= array('COM_PHOCAGALLERY_CATEGORY_RATING', 'phocagalleryra');
$l['ir']	= array('COM_PHOCAGALLERY_IMAGE_RATING', 'phocagalleryraimg');
$l['cc']	= array('COM_PHOCAGALLERY_CATEGORY_COMMENTS', 'phocagallerycos');
$l['ic']	= array('COM_PHOCAGALLERY_IMAGE_COMMENTS', 'phocagallerycoimgs');
$l['u']		= array('COM_PHOCAGALLERY_USERS', 'phocagalleryusers');
$l['fb']	= array('COM_PHOCAGALLERY_FB', 'phocagalleryfbs');
$l['tg']	= array('COM_PHOCAGALLERY_TAGS', 'phocagallerytags');
$l['in']	= array('COM_PHOCAGALLERY_INFO', 'phocagalleryin');

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

foreach ($l as $k => $v) {
	
	if ($v[1] == '') {
		$link = 'index.php?option=com_phocagallery';
	} else {
		$link = 'index.php?option=com_phocagallery&view=';
	}

	if ($view == $v[1]) {
		JSubMenuHelper::addEntry(JText::_($v[0]), $link.$v[1], true );
	} else {
		JSubMenuHelper::addEntry(JText::_($v[0]), $link.$v[1]);
	}

}

class PhocaGalleryCpController extends JController
{
	function display() {
		parent::display();
	}
}
?>