<?php

/*
 * @version		$Id: videos.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class AllVideoShareControllerVideos extends JController {

   function __construct() {
        parent::__construct();
    }
	
	function videos()
	{		
	    $document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('videos', $vType);
		
        $model = &$this->getModel('videos');
		
        $view->setModel($model, true);
		$view->setLayout('default');
		$view->display();
	}
			
}

?>