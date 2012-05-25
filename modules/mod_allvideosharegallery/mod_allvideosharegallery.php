<?php

/*
 * @version		$Id: mod_allvideosharegallery.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$params->def('thumb_width', 145);
$params->def('thumb_height', 80);
$params->def('more', 0);
 
$items = AllVideoShareGalleryHelper::getItems( $params );
$moduleclass_sfx = htmlspecialchars( $params->get('moduleclass_sfx') );

require (JModuleHelper::getLayoutPath('mod_allvideosharegallery', 'default_' . $items['type']));

?>