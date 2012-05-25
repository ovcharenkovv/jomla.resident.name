<?php

/*
 * @version		$Id: mod_allvideosharesearch.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$moduleclass_sfx = htmlspecialchars( $params->get('moduleclass_sfx') );

?>

<div align="center" class="avs_input_search<?php echo $moduleclass_sfx; ?>">
  <form action="<?php echo JRoute::_( "index.php?option=com_allvideoshare&view=search" ); ?>" name="hsearch" id="hsearch" method="post" enctype="multipart/form-data"  >
    <input type="text" name="avssearch" id="avssearch" style="width:75%" value=""/>
    <input type="submit" name="search_btn" id="search_btn" value="Go" />
  </form>
</div>