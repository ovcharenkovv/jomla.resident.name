<?php

/*
 * @version		$Id: user.php 1.2.1 2012-05-03 $
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

class AllVideoShareModelUser extends JModel {

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
	
	function getvideos($user)
    {
		 $mainframe  = JFactory::getApplication();
		 $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', 10, 'int');
		 $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		 
		 // In case limit has been changed, adjust it
		 $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
		 $this->setState('limit', $limit);
		 $this->setState('limitstart', $limitstart);
		 
    	 $db       =& JFactory::getDBO();		 
		 $query    = "SELECT * FROM #__allvideoshare_videos WHERE user=" . $db->quote( $user );
		 $query   .= " ORDER BY ordering";
    	 $db->setQuery ( $query, $limitstart, $limit );
    	 $output   = $db->loadObjectList();
         return($output);
	}
	
	function getpagination( $user )
    {
    	 jimport( 'joomla.html.pagination' );
		 $pageNav = new JPagination($this->gettotal( $user ), $this->getState('limitstart'), $this->getState('limit'));
         return($pageNav);
	}
	
	function gettotal( $user )
    {
         $db    =& JFactory::getDBO();
         $query = "SELECT COUNT(*) FROM #__allvideoshare_videos WHERE user=" . $db->quote( $user );
         $db->setQuery( $query );
         $output = $db->loadResult();
         return($output);
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
	
	function savevideo()
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
	  
	  	 if($row->type != 'youtube')
	  	 {
	     	jimport('joomla.filesystem.file');
		
			$dir = JFilterOutput::stringURLSafe( $row->category );
		 	if(!JFolder::exists(ALLVIDEOSHARE_UPLOAD_BASE . $dir . DS)) {
				JFolder::create(ALLVIDEOSHARE_UPLOAD_BASE . $dir . DS);
			}
		
			if($row->type == 'upload') {
				$row->video = $this->upload('upload_video', $dir);
				$row->hd    = $this->upload('upload_hd', $dir);
			}
			
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

		 $row->qs          = JRequest::getVar('qs', '', 'post', 'string', JREQUEST_ALLOWRAW);
		 $link = JRoute::_( 'index.php?option=com_allvideoshare&view=user' . $row->qs, false );
		 
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
		 		JError::raiseWarning(21, 'Error Occured While Uploading!');
				return false;
		 	}
	  	 }		
	}
	
	function deletevideo()
	{
		 $mainframe =  JFactory::getApplication();
         $cid       =  JRequest::getVar( 'cid', array(), '', 'array' );
         $db        =& JFactory::getDBO();
         $cids      =  implode( ',', $cid );
         if(count($cid))
         {
            $query = "DELETE FROM #__allvideoshare_videos WHERE id IN ( $cids )";
            $db->setQuery( $query );
            if (!$db->query())
            {
                echo "<script> alert('".$db->getErrorMsg()."');window.history.go(-1); </script>\n";
            }
         }
		
         $qs   = JRequest::getVar('Itemid');
		 $link = JRoute::_( 'index.php?option=com_allvideoshare&view=user&Itemid=' . $qs, false );
		 
		 $mainframe->redirect($link ); 
	}
		
}

?>