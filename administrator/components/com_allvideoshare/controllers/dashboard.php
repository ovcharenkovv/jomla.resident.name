<?php

/*
 * @version		$Id: dashboard.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class AllVideoShareControllerDashboard extends JController {

   function __construct() {        
        $this->item_type = 'Default';
        parent::__construct();
    }
	
	function dashboard()
	{
	    $document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('dashboard', $vType);
		
        $model = &$this->getModel('dashboard');
		
        $view->setModel($model, true);
		$view->setLayout('default');
		$view->display();
	}
		
}

?>