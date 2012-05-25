<?php

/*
 * @version		$Id: player.php 1.2.1 2012-05-03 $
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

require_once( JPATH_ROOT.DS.'components'.DS.'com_allvideoshare'.DS.'models'.DS.'ismobile.php' );

class AllVideoShareModelPlayer extends JModel {

    var $width, $height;

    function __construct($width = -1, $height = -1) {
		$this->width  = $width;
		$this->height = $height;
		 
		parent::__construct();
    }
	
	function buildPlayer( $videoid = 1, $playerid = 1, $autodetect = 0 )
    {
		 if(JRequest::getVar('slg') && $autodetect == 1) {
		 	$video = $this->getvideobyslug();
		 } else {
		 	$video = $this->getvideobyid( $videoid );
		 }
		 
		 if(!$video) return;
		 
		 $player = $this->getplayerbyid( $playerid );
		 
		 if($this->width  == -1) $this->width  = $player->width;
		 if($this->height == -1) $this->height = $player->height;
		 
		 if($video->type == 'thirdparty') {
		 	$result    = '<div style="width:' . $this->width . 'px; height:' . $this->height . 'px;">';
		 	$result   .= $video->thirdparty;
			$result   .= '</div>';
		 } else {		 	
		    $flashvars = 'base='.JURI::root().'&amp;vid=' . $video->id . '&amp;pid=' . $playerid;
			$detect    = new IsMobile();			
		    $result    = $detect->isMobile() ? $this->gethtmlplayer( $video ) : $this->getflashplayer( $player, $video, $flashvars );	
		 }		
		 
		 $this->updateviews( $video->slug );
		 
		 return $result;
	}
	
	function getflashplayer( $player, $video, $flashvars )
	{
		 $this->buildCustomMeta( $player, $video );
		 
		 $result  = '<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="' . $this->width . '" height="' . $this->height . '">';
    	 $result .= '<param name="movie" value="' . JURI::root() . 'components/com_allvideoshare/player.swf?random=' . rand() . '" />';
    	 $result .= '<param name="wmode" value="opaque" />';
    	 $result .= '<param name="allowfullscreen" value="true" />';
    	 $result .= '<param name="allowscriptaccess" value="always" />';
    	 $result .= '<param name="flashvars" value="' . $flashvars . '" />';
    	 $result .= '<object type="application/x-shockwave-flash" data="' . JURI::root() . 'components/com_allvideoshare/player.swf?random=' . rand() . '" width="' . $this->width . '" height="' . $this->height . '">';
      	 $result .= '<param name="movie" value="' . JURI::root() . 'components/com_allvideoshare/player.swf?random=' . rand() . '" />';
      	 $result .= '<param name="wmode" value="opaque" />';
      	 $result .= '<param name="allowfullscreen" value="true" />';
      	 $result .= '<param name="allowscriptaccess" value="always" />';
      	 $result .= '<param name="flashvars" value="' . $flashvars . '" />';
    	 $result .= '</object>';
  	 	 $result .= '</object>';
		 
		 return $result;
	}
	
	function gethtmlplayer( $video )
	{
		 if($video->type == 'youtube') {
	     	$url_string = parse_url($video->video, PHP_URL_QUERY);
  	    	parse_str($url_string, $args);
	    	$result  = '<iframe title="YouTube Video Player" width="'.$this->width.'" height="'.$this->height.'" ';
			$result .= 'src="http://www.youtube.com/embed/'.$args['v'].'" frameborder="0" allowfullscreen></iframe>';
		 } else {
			$preview = $video->preview ? 'poster="' . $video->preview . '"' : '';
	    	$result  = '<video onclick="this.play();" width="'.$this->width.'" height="'.$this->height.'" '.$preview.' controls>';
  	    	$result .= '<source src="'.$video->video.'" />';
			$result .= '</video>';
         }
		 
		 return $result;
	}
	
	function getvideobyid( $id )
    {
         $db     =& JFactory::getDBO();
         $query  =  "SELECT * FROM #__allvideoshare_videos WHERE id=" . $db->Quote( $id );
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return $output ? $output[0] : false;
	}
	
	function getvideobyslug()
    {		 
         $db     =& JFactory::getDBO();
		 $slug   =  str_replace(":", "-", JRequest::getVar('slg'));
         $query  =  "SELECT * FROM #__allvideoshare_videos WHERE slug=" . $db->Quote( $slug );
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return $output ? $output[0] : false;
	}
	
	function getplayerbyid( $id )
    {
         $db     =& JFactory::getDBO();
         $query  =  "SELECT * FROM #__allvideoshare_players WHERE id=" . $db->Quote( $id );
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
	function buildCustomMeta( $player, $video )
    {
		 $swf  = JURI::root().'components/com_allvideoshare/player.swf?autoStart=true&random=' . rand();
		 $swf .= '&base='.urlencode( JURI::root() ).'&vid=' . $video->id . '&pid=' . $player->id;
		 
		 $doc =& JFactory::getDocument();
         $doc->addCustomTag( '<meta property="og:video" content="'.$swf.'" />' );
		 $doc->addCustomTag( '<meta property="og:video:type" content="application/x-shockwave-flash" />' );
		 $doc->addCustomTag( '<meta property="og:video:width" content="560" />' );
         $doc->addCustomTag( '<meta property="og:video:height" content="340" />' );
         $doc->addCustomTag( '<meta property="og:title" content="'.$video->title.'" />' );
         $doc->addCustomTag( '<meta property="og:image" content="'.$video->thumb.'" />' );		 
	}
	
	function updateviews( $slug )
    {
		$session =& JFactory::getSession();
		$db      =& JFactory::getDBO();
		$avs_arr =  array();
		$ses_arr =  array();
		
		if($session->get('avs_arr')) {
			$ses_arr = $session->get('avs_arr');
		}
		
		if(!in_array($slug, $ses_arr)) {
	    	$avs_arr   = $ses_arr;
		    $avs_arr[] = $slug;
				
		 	$mainframe = JFactory::getApplication();	     	    
		 	$query     = "SELECT views FROM #__allvideoshare_videos WHERE slug=".$db->Quote( $slug );
    	 	$db->setQuery ( $query );
    	 	$output    = $db->loadObjectList();
		 
			if($output) {
				$count = $output[0]->views + 1;
			} else {
				$count = 1;
			}
	 
		 	$query     = "UPDATE #__allvideoshare_videos SET views=".$count." WHERE slug=".$db->Quote( $slug );
    	 	$db->setQuery ( $query );
		 	$db->query();
		 
		 	$session->set('avs_arr', $avs_arr);
		}
	}
		
}

?>