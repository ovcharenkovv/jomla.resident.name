<?php

/*
 * @version		$Id: default.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$config     = $this->config;
$categories = $this->categories;
$header     = ( substr(JVERSION,0,3) != '1.5' ) ? 'page_heading' : 'page_title';
$link       = 'index.php?option=com_allvideoshare&view=category&slg=';
$qs         = '';
$qs        .= JRequest::getVar('orderby') ? '&orderby=' . JRequest::getVar('orderby') : '';
$qs        .= JRequest::getVar('Itemid')  ? '&Itemid=' . JRequest::getVar('Itemid') : '';
$row        = 0;
$column     = 0;

$document =& JFactory::getDocument();
$document->addStyleSheet( JRoute::_("index.php?option=com_allvideoshare&view=css"),'text/css',"screen");

?>
<?php if ($this->params->get('show_'.$header, 1)) : ?>
	<h2> <?php echo $this->escape($this->params->get($header)); ?> </h2>
<?php endif; ?>
<div id="avs_gallery<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
  <?php
  	if(!count($categories)) echo JText::_('ITEM_NOT_FOUND');
  	for ($i=0, $n=count($categories); $i < $n; $i++) {
		$clear = '';
  		if($column >= $config[0]->cols) {
			$clear  = '<div style="clear:both;"></div>';
			$column = 0;
			$row++;
		}
		$column++;
		echo $clear;
  ?>
  <div class="avs_thumb" style="width:<?php echo $config[0]->thumb_width; ?>px;">
  	<a href="<?php echo JRoute::_($link.$categories[$i]->slug.$qs); ?>">
    	<img class="arrow" src="<?php echo JURI::root(); ?>components/com_allvideoshare/assets/play.gif" border="0" style="margin-left:<?php echo ($config[0]->thumb_width / 2) - 15; ?>px; margin-top:<?php echo ($config[0]->thumb_height / 2) - 13; ?>px;" />
        <img class="image" src="<?php echo $categories[$i]->thumb; ?>" width="<?php echo $config[0]->thumb_width; ?>" height="<?php echo $config[0]->thumb_height; ?>" title="<?php echo JText::_('CLICK_TO_VIEW').' : '.$categories[$i]->name; ?>" border="0" />
        <span class="name"><?php echo $categories[$i]->name; ?></span>
    </a>
  </div>
  <?php } ?>
  <div style="clear:both"></div>
</div>
<div id="avs_pagination<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->pagination->getPagesLinks(); ?></div>