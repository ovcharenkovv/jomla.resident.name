<?php

/*
 * @version		$Id: css.php 1.2.1 2012-05-03 $
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

class AllVideoShareModelCSS extends JModel {

    function __construct() {
		parent::__construct();
    }	
	
	function buildCSS()
    {
		 ob_clean();
		 header("content-type:text/css");
		 echo $this->getconfig();
		 exit();
	}
	
	function getconfig()
    {
         $db    =& JFactory::getDBO();
         $query = "SELECT * FROM #__allvideoshare_config";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return( $output[0]->css );
	}
	
}

?>