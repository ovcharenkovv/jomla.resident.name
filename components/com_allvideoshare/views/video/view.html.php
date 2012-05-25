<?php

/*
 * @version		$Id: view.html.php 1.2 2012-04-11 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

require_once( JPATH_ROOT.DS.'components'.DS.'com_allvideoshare'.DS.'models'.DS.'player.php' );

class AllVideoShareViewVideo extends JView {

    function display($tpl = null) {
	    $mainframe = JFactory::getApplication();
		$model 	   = $this->getModel();
		
		$config = $model->getconfig();
		$this->assignRef('config', $config);
		
		$video = $model->getvideo();
		$this->assignRef('video', $video);
		
		$custom = new AllVideoShareModelPlayer();
		$this->assignRef('custom', $custom);
		
		$player = $custom->buildPlayer($video->id, $config[0]->playerid);
		$this->assignRef('player', $player);
		
		$videos = $model->getvideos( $config[0]->rows * $config[0]->cols, $video->category, $video->id );
		$this->assignRef('videos', $videos);
		
		$slug = $model->getslug( $video->category );
		$this->assignRef('slug', $slug);
		
		$pagination = $model->getpagination( $video->category, $video->id );
		$this->assignRef('pagination', $pagination);
		
		// Adds parameter handling
		$params = $mainframe->getParams();
		$this->assignRef('params',	$params);
				
        parent::display($tpl);
    }
	
}

?>