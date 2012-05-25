<?php

/*
 * @version		$Id: allvideosharelicensing.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableAllVideoShareLicensing extends JTable {

	var $id           = null;
	var $type         = null;
	var $licensekey   = null;
	var $logo         = null;
	var $logoposition = null;
	var $logoalpha    = null;
	var $logotarget   = null;
	var $displaylogo  = 0;

	function __construct(& $db) {
		parent::__construct('#__allvideoshare_licensing', 'id', $db);
	}

	function check() {
		return true;
	}
	
}

?>