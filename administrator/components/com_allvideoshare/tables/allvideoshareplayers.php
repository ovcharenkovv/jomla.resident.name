<?php

/*
 * @version		$Id: allvideoshareplayers.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableAllVideoSharePlayers extends JTable {

	var $id                      = null;
	var $name                    = null;
	var $width                   = null;
	var $height                  = null;
	var $loop                    = 0;
	var $autostart               = 0;
	var $buffer                  = null;
	var $volumelevel             = null;
	var $stretch                 = null;
	var $controlbar              = 0;
	var $playlist                = 0;
	var $durationdock            = 0;
	var $timerdock               = 0; 
	var $fullscreendock          = 0;
	var $hddock                  = 0;
	var $embeddock               = 0;
	var $facebookdock            = 0;
	var $twitterdock             = 0;	
	var $controlbaroutlinecolor  = null;
	var $controlbarbgcolor       = null;
	var $controlbaroverlaycolor  = null;
	var $controlbaroverlayalpha  = null;
	var $iconcolor               = null;
	var $progressbarbgcolor      = null;
	var $progressbarbuffercolor  = null;
	var $progressbarseekcolor    = null;
	var $volumebarbgcolor        = null;
	var $volumebarseekcolor      = null;
	var $playlistbgcolor         = null;
	var $customplayerpage        = null;
	var $published               = 0;	

	function __construct(& $db) {
		parent::__construct('#__allvideoshare_players', 'id', $db);
	}

	function check() {
		return true;
	}

}

?>