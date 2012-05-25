<?php

/*
 * @version		$Id: default.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<div style="float:left;width:55%"> <?php echo $this->loadTemplate('left'); ?>
  <div class="clr"></div>
</div>
<div style="float:right; width:44%;"> <?php echo $this->loadTemplate('right'); ?> </div>
<div class="clr"></div>