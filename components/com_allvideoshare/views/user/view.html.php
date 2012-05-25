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

class AllVideoShareViewUser extends JView {

    function display($tpl = null) {
	    $mainframe = JFactory::getApplication();
		$model 	   = $this->getModel();
		
		$config = $model->getconfig();
		$this->assignRef('config', $config);
		
		$userobj =& JFactory::getUser();	
		$user    = $userobj->get('username');
		$this->assignRef('user', $user);
		 
		$videos = $model->getvideos( $user );
		$this->assignRef('videos', $videos);
		
		$pagination = $model->getpagination( $user );
		$this->assignRef('pagination', $pagination);
		
		$video = $model->getrow();
		$this->assignRef('video', $video);
		
		$category = $model->getcategories();
		$this->assignRef('category', $category);
		
		// Adds parameter handling
		$params = $mainframe->getParams();
		$this->assignRef('params',	$params);
				
        parent::display($tpl);
    }
	
}

?>