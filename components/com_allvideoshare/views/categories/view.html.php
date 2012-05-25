<?php

/*
 * @version		$Id: view.html.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class AllVideoShareViewCategories extends JView {

    function display($tpl = null) {
	    $mainframe = JFactory::getApplication();
		$model 	   = $this->getModel();
		
		$config = $model->getconfig();
		$this->assignRef('config', $config);
		
		$categories = $model->getcategories($config[0]->rows * $config[0]->cols);
		$this->assignRef('categories', $categories);
		
		$pagination = $model->getpagination();
		$this->assignRef('pagination', $pagination);
		
		// Adds parameter handling
		$params = $mainframe->getParams();
		$this->assignRef('params',	$params);
				
        parent::display($tpl);
    }
	
}

?>