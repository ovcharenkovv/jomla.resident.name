<?php

/*
 * @version		$Id: mod_allvideoshareplayer.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
require_once( JPATH_ROOT.DS.'components'.DS.'com_allvideoshare'.DS.'models'.DS.'player.php' );

$params->def('width', '-1');
$params->def('height','-1');

$moduleclass_sfx = htmlspecialchars( $params->get('moduleclass_sfx') );
$custom = new AllVideoShareModelPlayer( $params->get('width'), $params->get('height') );

?>

<div class="avs_player<?php echo $moduleclass_sfx; ?>">
	<?php echo $custom->buildPlayer( $params->get('videoid'), $params->get('playerid'), $params->get('autodetect') ); ?>
</div>