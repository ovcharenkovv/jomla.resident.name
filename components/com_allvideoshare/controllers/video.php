<?php

/*
 * @version		$Id: video.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class AllVideoShareControllerVideo extends JController {

   function __construct() {
        parent::__construct();
    }
	
	function video()
	{		
	    $document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('video', $vType);
		
        $model    = &$this->getModel('video');
		
        $view->setModel($model, true);
		$view->setLayout('default');
		$view->display();
	}
			
}

?>