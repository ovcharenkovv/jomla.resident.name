<?php

/*
 * @version		$Id: categories.php 1.2.1 2012-05-03 $
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

class AllVideoShareModelCategories extends JModel {

    function __construct() {
		parent::__construct();
    }
	
	function getconfig()
    {
         $db     =& JFactory::getDBO();
         $query  = "SELECT * FROM #__allvideoshare_config";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output);
	}
	
	function getcategories($rc)
    {
		 $mainframe  = JFactory::getApplication();
		 $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $rc, 'int');
		 $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		 
		 // In case limit has been changed, adjust it
		 $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
		 $this->setState('limit', $limit);
		 $this->setState('limitstart', $limitstart);
			 
         $db    =& JFactory::getDBO();
         $query =  "SELECT * FROM #__allvideoshare_categories WHERE published=1";		
         $db->setQuery( $query, $limitstart, $limit );
         $output = $db->loadObjectList();
         return($output);
	}
	
	function getpagination()
    {
    	 jimport( 'joomla.html.pagination' );
		 $pageNav    = new JPagination($this->gettotal(), $this->getState('limitstart'), $this->getState('limit'));
         return($pageNav);
	}
	
	function gettotal()
    {
         $db    =& JFactory::getDBO();
         $query = "SELECT COUNT(*) FROM #__allvideoshare_categories WHERE published=1";	 
         $db->setQuery( $query );
         $output = $db->loadResult();
         return($output);
	}
	
}

?>