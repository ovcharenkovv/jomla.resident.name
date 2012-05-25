<?php

/*
 * @version		$Id: players.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.controller' );

class AllVideoShareControllerPlayers extends JController {

   function __construct() {
        parent::__construct();
    }
	
	function players()
	{
	    $document = &JFactory::getDocument();
		$vType	  = $document->getType();
	    $view     = &$this->getView('players', $vType);
		
        $model = &$this->getModel('players');
		
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
	    $view     = &$this->getView('players' , $vType);

        $model = &$this->getModel('players');
		
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
	    $view     = &$this->getView('players' , $vType);

        $model = &$this->getModel('players');
		
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
		
		$model = &$this->getModel('players');
	 	$model->delete();
	}
	
	function save()
	{
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('players');
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
		
		$model = &$this->getModel('players');
	    $model->cancel();
	}
	
	function publish()
    {
		if(JRequest::checkToken( 'get' )) {
			JRequest::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JRequest::checkToken() or die( 'Invalid Token' );
		}
		
		$model = &$this->getModel('players');
        $model->publish();
    }
	
    function unpublish()
    {
        $this->publish();
    }
		
}

?>