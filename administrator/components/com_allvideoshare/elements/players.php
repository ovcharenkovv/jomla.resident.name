<?php

/*
 * @version		$Id: players.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementPlayers extends JElement
{
	var	$_name = 'Players';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT a.id, a.name'
		. ' FROM #__allvideoshare_players AS a'
		. ' WHERE a.published = 1'
		. ' ORDER BY a.name';
		$db->setQuery( $query );
		$options = $db->loadObjectList();

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'id', 'name', $value, $control_name.$name );
	}
}
 
?>