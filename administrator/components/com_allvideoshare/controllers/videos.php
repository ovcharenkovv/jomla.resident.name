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
	
	function add()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		$document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('videos' , $vType);

        $model = &$this->getModel('videos');
		
        $view->setModel($model, true);
		$view->setLayout('add');
		$view->add();
	}
	
	function edit()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		$document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('videos' , $vType);

        $model = &$this->getModel('videos');
		
        $view->setModel($model, true);
		$view->setLayout('edit');
		$view->edit();
	}
	
	function delete()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('videos');
	 	$model->delete();
	}
	
	function save()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('videos');
	  	$model->save();
	}
	
	function apply()
	{
		$this->save();
	}
	
	function cancel()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('videos');
	    $model->cancel();
	}
	
	function publish()
    {
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('videos');
        $model->publish();
    }
	
    function unpublish()
    {
        $this->publish();
    }
	
	function saveorder()
	{
		$model = &$this->getModel('videos');
	  	$model->saveorder();		
	}
	
	function orderdown()
	{
		$model = &$this->getModel('videos');
	  	$model->move(1);		
	}
	
	function orderup()
	{
		$model = &$this->getModel('videos');
	  	$model->move(-1);		
	}
		
}

?>