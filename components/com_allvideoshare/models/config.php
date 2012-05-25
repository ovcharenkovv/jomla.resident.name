<?php

/*
 * @version		$Id: config.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class AllVideoShareModelConfig extends JModel {

	function __construct() {
		parent::__construct();
    }
	
	function buildXml()
	{
		ob_clean();
		header("content-type:text/xml;charset=utf-8");
		echo '<?xml version="1.0" encoding="utf-8"?>'."\n";
		echo '<config>'."\n";
		echo $this->buildNodes();
		echo '</config>'."\n";
		exit();
	}
	
	function buildNodes() {
		$video     = $this->getvideo();
		$player    = $this->getplayer();
		$licensing = $this->getlicensing();
		
		$node  = '';
		$node .= '<loop>'.$this->castAsBoolean( $player->loop ).'</loop>'."\n";
		$node .= '<autoStart>'.$this->castAsBoolean( $player->autostart ).'</autoStart>'."\n";
		$node .= '<buffer>'.$player->buffer.'</buffer>'."\n";
		$node .= '<volumeLevel>'.$player->volumelevel.'</volumeLevel>'."\n";
		$node .= '<stretch>'.$player->stretch.'</stretch>'."\n";
		$node .= '<controlBar>'.$this->castAsBoolean( $player->controlbar ).'</controlBar>'."\n";
		$node .= '<playList>'.$this->castAsBoolean( $player->playlist ).'</playList>'."\n";
		$node .= '<playListXml>'.JURI::root().'index.php?option=com_allvideoshare&amp;view=playlist&amp;vid='.JRequest::getCmd('vid').'&amp;pid='.JRequest::getCmd('pid').'</playListXml>'."\n";
		$node .= '<durationDock>'.$this->castAsBoolean( $player->durationdock ).'</durationDock>'."\n";
		$node .= '<timerDock>'.$this->castAsBoolean( $player->timerdock ).'</timerDock>'."\n";		
		$node .= '<fullScreenDock>'.$this->castAsBoolean( $player->fullscreendock ).'</fullScreenDock>'."\n";
		$node .= '<hdDock>'.$this->castAsBoolean( $player->hddock ).'</hdDock>'."\n";
		$node .= '<embedDock>'.$this->castAsBoolean( $player->embeddock ).'</embedDock>'."\n";
		$node .= '<facebookDock>'.$this->castAsBoolean( $player->facebookdock ).'</facebookDock>'."\n";
		$node .= '<twitterDock>'.$this->castAsBoolean( $player->twitterdock ).'</twitterDock>'."\n";
		$node .= '<controlBarOutlineColor>'.$player->controlbaroutlinecolor.'</controlBarOutlineColor>'."\n";
		$node .= '<controlBarBgColor>'.$player->controlbarbgcolor.'</controlBarBgColor>'."\n";
		$node .= '<controlBarOverlayColor>'.$player->controlbaroverlaycolor.'</controlBarOverlayColor>'."\n";
		$node .= '<controlBarOverlayAlpha>'.$player->controlbaroverlayalpha.'</controlBarOverlayAlpha>'."\n";
		$node .= '<iconColor>'.$player->iconcolor.'</iconColor>'."\n";
		$node .= '<progressBarBgColor>'.$player->progressbarbgcolor.'</progressBarBgColor>'."\n";
		$node .= '<progressBarBufferColor>'.$player->progressbarbuffercolor.'</progressBarBufferColor>'."\n";
		$node .= '<progressBarSeekColor>'.$player->progressbarseekcolor.'</progressBarSeekColor>'."\n";
		$node .= '<volumeBarBgColor>'.$player->volumebarbgcolor.'</volumeBarBgColor>'."\n";
		$node .= '<volumeBarSeekColor>'.$player->volumebarseekcolor.'</volumeBarSeekColor>'."\n";
		$node .= '<playListBgColor>'.$player->playlistbgcolor.'</playListBgColor>'."\n";
		$node .= '<type>'.$video->type.'</type>'."\n";
		$node .= '<preview>'.$video->preview.'</preview>'."\n";
		$node .= '<streamer>'.$video->streamer.'</streamer>'."\n";
		$node .= '<token>'.$video->token.'</token>'."\n";
		$node .= '<video>'.$video->video.'</video>'."\n";
		if($video->hd) {
			$node .= '<hd>'.$video->hd.'</hd>'."\n";
		}
		$node .= '<dvr>'.$this->castAsBoolean( $video->dvr ).'</dvr>'."\n";
		$node .= '<license>'.$licensing->licensekey.'</license>'."\n";
		$node .= '<displayLogo>'.$this->castAsBoolean( $licensing->displaylogo ).'</displayLogo>'."\n";
		$node .= '<logo>'.$licensing->logo.'</logo>'."\n";
		$node .= '<logoAlpha>'.$licensing->logoalpha.'</logoAlpha>'."\n";
		$node .= '<logoPosition>'.$licensing->logoposition.'</logoPosition>'."\n";
		$node .= '<logoTarget>'.$licensing->logotarget.'</logoTarget>'."\n";
		
		return $node;
	}
	
	function getvideo()
    {
         $db     =& JFactory::getDBO();
         $query  =  "SELECT * FROM #__allvideoshare_videos WHERE id=" . $db->Quote( JRequest::getCmd('vid') );
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
	function getplayer()
    {
         $db     =& JFactory::getDBO();
         $query  =  "SELECT * FROM #__allvideoshare_players WHERE id=" . $db->Quote( JRequest::getCmd('pid') );
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
	function getlicensing()
    {
         $db     =& JFactory::getDBO();
         $query  =  "SELECT * FROM #__allvideoshare_licensing WHERE id=1";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
		 $result = $output[0];
         return($result);
	}

	function castAsBoolean($val){
		if($val == 1) {
	    	return 'true';
		} else {
			return 'false';
		}
	}

}

?>