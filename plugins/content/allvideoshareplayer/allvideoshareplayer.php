<?php

/*
 * @version		$Id: allvideoshareplayer.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

require_once( JPATH_ROOT.DS.'components'.DS.'com_allvideoshare'.DS.'models'.DS.'player.php' );

class plgContentAllVideoSharePlayer extends JPlugin
{

	function plgContentAllVideoSharePlayer( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	function onContentPrepare($context, &$article, &$params, $page=0)
	{	
		$this->onPrepareContent( $article, $params, $page );
	}

	function onPrepareContent( &$row, &$params, $limitstart )
	{
		// simple performance check to determine whether bot should process further
		if ( JString::strpos( $row->text, 'avsplayer' ) === false ) {
			return true;
		}
		
		// expression to search for
 		$regex = '/{avsplayer\s*.*?}/i';
		
		// find all instances of plugin and put in $matches
		preg_match_all( $regex, $row->text, $matches );

		// Number of plugins
 		$count = count( $matches[0] );
		
		$this->plgContentProcessPositions( $row, $matches, $count, $regex);

	}
	
	function plgContentProcessPositions ( $row, $matches, $count, $regex)
	{
 		for ( $i=0; $i < $count; $i++ )
		{
 			$load  = str_replace( '{avsplayer', '', $matches[0][$i] );
 			$load  = str_replace( '}', '', $load );
			$load  = trim( $load );
			$load  = explode(" ",$load);
			$load  = implode("&",$load);
 			
			$modules	= $this->plgContentLoadPosition($load);
			$row->text 	= str_replace($matches[0][$i], $modules, $row->text );
 		}

  		// removes tags without matching module positions
		$row->text = preg_replace( $regex, '', $row->text );
	}
	
	function plgContentLoadPosition($load)
	{
		$videoid    = 1;
		$playerid   = 1;
		$width      = -1;
		$height     = -1;
		$autodetect = 0;
	    parse_str($load);
		$custom = new AllVideoShareModelPlayer( $width, $height );		
		return $custom->buildPlayer( $videoid, $playerid, $autodetect );
	}

}

?>