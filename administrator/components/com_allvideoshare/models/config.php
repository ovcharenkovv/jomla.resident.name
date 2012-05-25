<?php

/*
 * @version		$Id: config.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

// Import filesystem libraries.
jimport('joomla.filesystem.file');

class AllVideoShareModelConfig extends JModel {

    function __construct() {
		parent::__construct();
    }
	
	function getdata()
    {
        $mainframe = JFactory::getApplication();		 
        $db        = &JFactory::getDBO();
        $query     = "SELECT * FROM #__allvideoshare_config WHERE id=1";

        $db->setQuery( $query );
        $output = $db->loadObjectList();
		 
        return($output[0]);
	}
	
	function getplayers()
    {
         $mainframe = JFactory::getApplication();		 
         $db        = &JFactory::getDBO();
         $query     = "SELECT id,name FROM #__allvideoshare_players WHERE published=1";

         $db->setQuery( $query );
         $output = $db->loadObjectList();
		 
         return($output);
	}
	
	function save()
	{
	  	$mainframe = JFactory::getApplication();
	  	$row       = &JTable::getInstance('allvideoshareconfig', 'Table');
	  	$cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      	$id        = $cid[0];
      	$row->load($id);

      	if(!$row->bind(JRequest::get('post')))
	  	{
			JError::raiseError(500, $row->getError() );
	  	}
	
	  	$row->css = JRequest::getVar('css', '', 'post', 'string', JREQUEST_ALLOWRAW);
	  
	  	if(!$row->store()){
			JError::raiseError(500, $row->getError() );
	  	}

      	$msg  = JText::_('SAVED');
      	$link = 'index.php?option=com_allvideoshare&view=config';
  
	  	$mainframe->redirect($link, $msg);
	}
	
}

?>