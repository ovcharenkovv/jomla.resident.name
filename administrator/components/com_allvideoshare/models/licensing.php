<?php

/*
 * @version		$Id: licensing.php 1.2.1 2012-05-03 $
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

class AllVideoShareModelLicensing extends JModel {

    function __construct() {
		parent::__construct();
    }
	
	function getdata()
    {
     	 $db  =& JFactory::getDBO();
         $row =& JTable::getInstance('allvideosharelicensing', 'Table');
         $row->load(1);

         return $row;
	}
	
	function save()
	{
		 $mainframe = JFactory::getApplication();
	  	 $row       = &JTable::getInstance('allvideosharelicensing', 'Table');
	  	 $cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      	 $id        = $cid[0];
      	 $row->load($id);
	
      	 if(!$row->bind(JRequest::get('post')))
	  	 {
		 	JError::raiseError(500, $row->getError() );
	  	 }
	  
	  	 if($row->type == 'upload')
	  	 {
	     	jimport('joomla.filesystem.file');
		
		 	if(!JFolder::exists(ALLVIDEOSHARE_UPLOAD_BASE)) {
				JFolder::create(ALLVIDEOSHARE_UPLOAD_BASE);
			}
		
			$row->logo = $this->upload('upload_logo');
	  	 }
	  
	  	 if(!$row->store()){
			JError::raiseError(500, $row->getError() );
	  	 }

		 $msg  = JText::_('SAVED');
         $link = 'index.php?option=com_allvideoshare&view=licensing';
		 
		 $mainframe->redirect($link, $msg); 	 
	}
	
	function upload($filename)
	{
	 	 $temp = $_FILES[$filename]['tmp_name'];
	  	 $file = JFile::makeSafe($_FILES[$filename]['name']);	 
	  
      	 if($file != "") {
     	 	if(JFile::upload($temp, ALLVIDEOSHARE_UPLOAD_BASE.$file)) {
		 		return ALLVIDEOSHARE_UPLOAD_BASEURL.$file;
		 	} else {
		 		JError::raiseWarning(21, JText::_('ERROR_OCCURED_WHILE_UPLOADING'));
				return false;
		 	}
	  	 }		
	}
	
}

?>