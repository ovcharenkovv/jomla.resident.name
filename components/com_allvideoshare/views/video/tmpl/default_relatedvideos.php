<?php

/*
 * @version		$Id: default_relatedvideos.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$config  = $this->config;
$videos  = $this->videos;
$catlink = "index.php?option=com_allvideoshare&view=category&slg=";
$vidlink = "index.php?option=com_allvideoshare&view=video&slg=";
$qs      = '';
$qs     .= JRequest::getVar('orderby') ? '&orderby=' . JRequest::getVar('orderby') : '';
$qs     .= JRequest::getVar('Itemid')  ? '&Itemid=' . JRequest::getVar('Itemid') : '';
$row     = 0;
$column  = 0;

?>

<div class="avs_video_related">
  <h2><?php echo JText::_('RELATED_VIDEOS'); ?></h2>
  <div id="avs_gallery<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
    <?php
  	if(!count($videos)) echo JText::_('ITEM_NOT_FOUND');
  	for ($i=0, $n=count($videos); $i < $n; $i++) {
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
    	<a href="<?php echo JRoute::_($vidlink.$videos[$i]->slug.$qs); ?>">
        	<img class="arrow" src="<?php echo JURI::root(); ?>components/com_allvideoshare/assets/play.gif" border="0" style="margin-left:<?php echo ($config[0]->thumb_width / 2) - 15; ?>px; margin-top:<?php echo ($config[0]->thumb_height / 2) - 13; ?>px;" />
            <img class="image" src="<?php echo $videos[$i]->thumb; ?>" width="<?php echo $config[0]->thumb_width; ?>" height="<?php echo $config[0]->thumb_height; ?>" title="<?php echo JText::_('CLICK_TO_VIEW').' : '.$videos[$i]->title; ?>" border="0" />
            <span class="title"><?php echo $videos[$i]->title; ?></span>
            <span class="views"><strong>views : </strong><?php echo $videos[$i]->views; ?></span>
         </a>
    </div>
    <?php } ?>
    <div style="clear:both"></div>
  </div>
  <div id="avs_pagination<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->pagination->getPagesLinks(); ?></div>
</div>