<?php

/*
 * @version		$Id: allvideoshare.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Define constants for all pages
define( 'UPLOAD_DIR', 'media'.DS.'com_allvideoshare'.DS);
define( 'ALLVIDEOSHARE_UPLOAD_BASE', JPATH_ROOT.DS.UPLOAD_DIR );
define( 'ALLVIDEOSHARE_UPLOAD_BASEURL', JURI::root().str_replace( DS, '/', UPLOAD_DIR ));

// Require the base controller
if(JRequest::getCmd('view') == '') {
	JRequest::setVar('view', 'categories');
} else if(JRequest::getCmd('view') == 'category' && !JRequest::getCmd('slg')){
	JRequest::setVar('view', 'categories');
} else if(JRequest::getCmd('view') == 'video' && !JRequest::getCmd('slg')){
	JRequest::setVar('view', 'videos');
}

$controller = JRequest::getCmd('view');
$controller = JString::strtolower( $controller );
require_once JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

// Initialize the controller
$classname  = 'AllVideoShareController'.$controller;
$controller = new $classname();

// Perform the Request task
if(JRequest::getCmd('task') == '') {
	JRequest::setVar('task', JRequest::getCmd('view'));
}
$controller->execute( JRequest::getCmd('task') );
$controller->redirect();

?>