<?php

/*
 * @version		$Id: default.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$config = $this->config;
$video  = $this->video;
$custom = $this->custom;
$player = $this->player;
$action = "index.php?option=com_allvideoshare&view=search";
$qs     = JRequest::getVar('Itemid') ? '&Itemid=' . JRequest::getVar('Itemid') : '';

$document =& JFactory::getDocument();
$document->addStyleSheet( JRoute::_("index.php?option=com_allvideoshare&view=css"),'text/css',"screen");
$document->addScript( JURI::root() . "components/com_allvideoshare/js/allvideoshare.js" );

?>

<div id="fb-root"></div>
<?php if($config[0]->title) { ?>
	<h2> <?php echo $this->escape($video->title); ?> </h2>
<?php } ?>
<div id="avs_video<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" style="width:<?php echo $custom->width; ?>px;">
  <div class="avs_video_header">
    <?php if($config[0]->category) { ?>
    <div class="avs_category_label"><strong>Category : </strong><?php echo $video->category; ?></div>
    <?php } ?>
    <?php if($config[0]->views) { ?>
    <div class="avs_views_label"><strong>Views : </strong><?php echo $video->views; ?></div>
    <?php } ?>
    <?php if($config[0]->search) { ?>
    <div class="avs_input_search">
      <form action="<?php echo JRoute::_( $action.$qs ); ?>" name="hsearch" id="hsearch" method="post" enctype="multipart/form-data"  >
        <input type="text" name="avssearch" id="avssearch" value=""/>
        <input type="submit" name="search_btn" id="search_btn" value="Go" />
      </form>
    </div>
    <?php } ?>
    <div style="clear:both;"></div>
  </div>
  <div class="avs_player"> <?php echo $player; ?> </div>
  <div class="avs_video_description"><?php echo $video->description; ?></div>
  <?php
	if($config[0]->layout != 'none') {
		echo $this->loadTemplate($config[0]->layout); 
	}
  ?>
</div>