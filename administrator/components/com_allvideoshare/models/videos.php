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
jimport('joomla.application.component.model');

// Import filesystem libraries.
jimport('joomla.filesystem.file');

class AllVideoShareModelVideos extends JModel {

    function __construct() {
		parent::__construct();
    }
	
	function getdata()
    {
		 $mainframe        = JFactory::getApplication();	
		 $option           = JRequest::getCmd('option');
		 $view             = JRequest::getCmd('view');
		 
		 $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		 $limitstart       = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		 $filter_state     = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		 $filter_category  = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', '', 'string');
		 $search           = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		 $search           = JString::strtolower($search);
		 
	     $db               = &JFactory::getDBO();
         $query            = "SELECT * FROM #__allvideoshare_videos";
		 $where            = array();
		 
		 if ($filter_state > -1) {
			$where[]       = "published={$filter_state}";
		 }
		 
		 if ($filter_category && $filter_category != JText::_('SELECT_BY_CATEGORY')) {
			$where[]       = 'category='.$db->Quote($filter_category);
		 }
		
		 if ( $search ) {
			$where[]       = 'LOWER(title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		 }

		 $where 		   = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		 
		 $query           .= $where;
		 $query           .= " ORDER BY category,ordering";
         $db->setQuery( $query, $limitstart, $limit );
         $output = $db->loadObjectList();
		 
         return($output);
	}
	
	function gettotal()
    {
		 $mainframe        = JFactory::getApplication();	
		 $option           = JRequest::getCmd('option');
		 $view             = JRequest::getCmd('view');
		 
		 $filter_state     = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		 $filter_category  = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', '', 'string');
		 $search           = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		 $search           = JString::strtolower($search);
		 
         $db               =& JFactory::getDBO();
         $query            = "SELECT COUNT(*) FROM #__allvideoshare_videos";
		 $where            = array();
		 
		 if ($filter_state > -1) {
			$where[]       = "published={$filter_state}";
		 }

		 if ($filter_category && $filter_category != JText::_('SELECT_BY_CATEGORY')) {
			$where[]       = 'category='.$db->Quote($filter_category);
		 }
		 
		 if ( $search ) {
			$where[]       = 'LOWER(title) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		 }

		 $where 		   = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		 
		 $query           .= $where;

         $db->setQuery( $query );
         $output = $db->loadResult();
         return($output);
	}
	
	function getpagination()
    {
		 $mainframe  = JFactory::getApplication();	
		 $option     = JRequest::getCmd('option');
		 $view       = JRequest::getCmd('view');
		 
		 $total      = $this->gettotal();
		 $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		 $limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
     
    	 jimport( 'joomla.html.pagination' );
		 $pageNav    = new JPagination($total, $limitstart, $limit);
         return($pageNav);
	}
	
	function getlists()
    {
		 $mainframe              = JFactory::getApplication();	
		 $option                 = JRequest::getCmd('option');
		 $view                   = JRequest::getCmd('view');
		 
		 $filter_state           = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int' );
		 $filter_category        = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', '', 'string');
		 $search                 = $mainframe->getUserStateFromRequest($option.$view.'search','search','','string');
		 $search                 = JString::strtolower ( $search );
     
    	 $lists                  = array ();
		 $lists ['search']       = $search;
            
		 $filter_state_options[] = JHTML::_('select.option', -1, JText::_('SELECT_PUBLISHING_STATE'));
		 $filter_state_options[] = JHTML::_('select.option', 1, JText::_('PUBLISHED'));
		 $filter_state_options[] = JHTML::_('select.option', 0, JText::_('UNPUBLISHED'));
		 $lists['state']         = JHTML::_('select.genericlist', $filter_state_options, 'filter_state', 'onchange="this.form.submit();"', 'value', 'text', $filter_state);
		 
		 $category_options[]     = JHTML::_('select.option', '', JText::_('SELECT_BY_CATEGORY'));
		 $categories             = $this->getcategories();
		 for ($i=0; $i < count( $categories ); $i++)
         {
         	$category_options[]  = JHTML::_('select.option', $categories[$i]->id, $categories[$i]->name);
	     }
		 $lists['categories']    = JHTML::_('select.genericlist', $category_options, 'filter_category', 'onchange="this.form.submit();"', 'text', 'text', $filter_category);
		 
         return($lists);
	}
	
	function getcategories()
    {
         $mainframe = JFactory::getApplication();		 
         $db        = &JFactory::getDBO();
         $query     = "SELECT id,name FROM #__allvideoshare_categories WHERE published=1";

         $db->setQuery( $query );
         $output = $db->loadObjectList();
		 
         return($output);
	}
	
	function getrow()
    {
     	 $db  =& JFactory::getDBO();
         $row =& JTable::getInstance('allvideosharevideos', 'Table');
         $cid =  JRequest::getVar( 'cid', array(0), '', 'array' );
         $id  =  $cid[0];
         $row->load($id);

         return $row;
	}
	
	function save()
	{
		 $mainframe = JFactory::getApplication();
	  	 $row       = &JTable::getInstance('allvideosharevideos', 'Table');
	  	 $cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      	 $id        = $cid[0];
      	 $row->load($id);
	
      	 if(!$row->bind(JRequest::get('post')))
	  	 {
		 	JError::raiseError(500, $row->getError() );
	  	 }
	  
	   	 jimport( 'joomla.filter.output' );
	  	 $row->title = JString::trim($row->title);
	  	 if(!$row->slug) $row->slug = $row->title;
		 $row->slug  = JFilterOutput::stringURLSafe($row->slug);
	  	 $row->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $row->thirdparty  = JRequest::getVar('thirdparty', '', 'post', 'string', JREQUEST_ALLOWRAW);
	  
	  	 if($row->type == 'upload')
	  	 {
	     	jimport('joomla.filesystem.file');
		
			$dir = JFilterOutput::stringURLSafe( $row->category );	
		 	if(!JFolder::exists(ALLVIDEOSHARE_UPLOAD_BASE . $dir . DS)) {
				JFolder::create(ALLVIDEOSHARE_UPLOAD_BASE . $dir . DS);
			}
		
			$row->video   = $this->upload('upload_video', $dir);
			$row->hd      = $this->upload('upload_hd', $dir);
	  		$row->thumb   = $this->upload('upload_thumb', $dir);
			$row->preview = $this->upload('upload_preview', $dir);
	  	 }
	  	 
		 if($row->type == 'youtube')
	     {
	      	$youtubeID = array(); 
		  	preg_match('/http\:\/\/www\.youtube\.com\/watch\?v=([\w-]{11})/',$row->video, $youtubeID);
			if(!$row->thumb) {
          		$row->thumb   = 'http://img.youtube.com/vi/'.$youtubeID[1].'/default.jpg';
			}
			if(!$row->preview) {
		 		$row->preview = 'http://img.youtube.com/vi/'.$youtubeID[1].'/0.jpg';
			}
	     }
	  
	  	 if(!$row->store()){
			JError::raiseError(500, $row->getError() );
	  	 }

	  	 switch (JRequest::getCmd('task'))
      	 {
        	case 'apply':
            	$msg  = JText::_('CHANGES_SAVED');
             	$link = 'index.php?option=com_allvideoshare&view=videos&task=edit&'. JUtility::getToken() .'=1&'.'cid[]='.$row->id;				
             	break;
        	case 'save':
        	default:
				$msg  = JText::_('SAVED');
             	$link = 'index.php?option=com_allvideoshare&view=videos';
              	break;
      	 }
		 
		 $mainframe->redirect($link, $msg); 	 
	}
	
	function upload($filename, $dir)
	{
	 	 $temp = $_FILES[$filename]['tmp_name'];
	  	 $file = JFile::makeSafe($_FILES[$filename]['name']);	 
	  
      	 if($file != "") {
     	 	if(JFile::upload($temp, ALLVIDEOSHARE_UPLOAD_BASE . $dir . DS . $file)) {
		 		return ALLVIDEOSHARE_UPLOAD_BASEURL . $dir . '/' . $file;
		 	} else {
		 		JError::raiseWarning(21, JText::_('ERROR_OCCURED_WHILE_UPLOADING'));
				return false;
		 	}
	  	 }		
	}
	
	function cancel()
	{
		 $mainframe = JFactory::getApplication();
		 
		 $link = 'index.php?option=com_allvideoshare&view=videos';
	     $mainframe->redirect($link);
	}	

	function delete()
	{
		 $mainframe = JFactory::getApplication();
         $cid       = JRequest::getVar( 'cid', array(), '', 'array' );
         $db        =& JFactory::getDBO();
         $cids       = implode( ',', $cid );
         if(count($cid))
         {
            $query = "DELETE FROM #__allvideoshare_videos WHERE id IN ( $cids )";
            $db->setQuery( $query );
            if (!$db->query())
            {
                echo "<script> alert('".$db->getErrorMsg()."');window.history.go(-1); </script>\n";
            }
         }
		
         $mainframe->redirect( 'index.php?option=com_allvideoshare&view=videos' );
	}
	
	function publish()
    {
		 $mainframe = JFactory::getApplication();
		 $cid       = JRequest::getVar( 'cid', array(), '', 'array' );
         $publish   = ( JRequest::getCmd('task') == 'publish' ) ? 1 : 0;
			
         $reviewTable =& JTable::getInstance('allvideosharevideos', 'Table');
         $reviewTable->publish($cid, $publish);
         $mainframe->redirect( 'index.php?option=com_allvideoshare&view=videos' );
    }
	
	function saveorder()
	{
		 $mainframe  = JFactory::getApplication();

		 // Initialize variables
		 $db	        =& JFactory::getDBO();
		 $cid        = JRequest::getVar( 'cid', array(0), '', 'array' );
		 $total      = count( $cid );
		 $order      = JRequest::getVar( 'order', array(0), '', 'array' );
		 JArrayHelper::toInteger($order, array(0));
		 
		 $row        =& JTable::getInstance('allvideosharevideos', 'Table');
		 $groupings  = array();
		 // update ordering values
		 for( $i=0; $i < $total; $i++ ) {
			$row->load( (int) $cid[$i] );
			$groupings[] = $row->category;
 			if ($row->ordering != $order[$i]) {
				$row->ordering  = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		 }
 
		 $groupings = array_unique($groupings);
		 foreach ($groupings as $group) {
			$row->reorder('category = "'.$group.'"');
		 }
 
		 $mainframe->redirect('index.php?option=com_allvideoshare&view=videos', JText::_('NEW_ORDERING_SAVED'));
	}
	
	function move($direction)
	{
		 $mainframe  = JFactory::getApplication();
		 $cid        = JRequest::getVar( 'cid', array(0), '', 'array' );
		 $row        = & JTable::getInstance('allvideosharevideos', 'Table');
		 $row->load($cid[0]);
		 $row->move($direction, 'category = "'.$row->category.'"');
		 $row->reorder('category = "'.$row->category.'"');
	  	 $mainframe->redirect('index.php?option=com_allvideoshare&view=videos', JText::_('NEW_ORDERING_SAVED'));
	}
	
}

?>