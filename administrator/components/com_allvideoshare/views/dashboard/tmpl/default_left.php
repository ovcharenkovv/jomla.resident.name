<?php

/*
 * @version		$Id: default_left.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$server           = $this->server;
$recentvideos     = $this->recentvideos;
$recentcategories = $this->recentcategories;
$popularvideos    = $this->popularvideos;

?>

<div class="avsicon"> <a title="<?php echo JText::_('PLAYERS'); ?>" href="index.php?option=com_allvideoshare&view=players"> <img alt="<?php echo JText::_('PLAYERS'); ?>" src="components/com_allvideoshare/assets/players.png" /> <span><?php echo JText::_('PLAYERS'); ?></span> </a> </div>
<div class="avsicon"> <a title="<?php echo JText::_('CATEGORIES'); ?>" href="index.php?option=com_allvideoshare&view=categories"> <img alt="<?php echo JText::_('CATEGORIES'); ?>" src="components/com_allvideoshare/assets/categories.png" /> <span><?php echo JText::_('CATEGORIES'); ?></span> </a> </div>
<div class="avsicon"> <a title="<?php echo JText::_('VIDEOS'); ?>" href="index.php?option=com_allvideoshare&view=videos"> <img alt="<?php echo JText::_('VIDEOS'); ?>" src="components/com_allvideoshare/assets/videos.png" /> <span><?php echo JText::_('VIDEOS'); ?></span> </a> </div>
<div class="avsicon"> <a title="<?php echo JText::_('APPROVAL'); ?>" href="index.php?option=com_allvideoshare&view=approval"> <img alt="<?php echo JText::_('APPROVAL'); ?>" src="components/com_allvideoshare/assets/approve.png" /> <span><?php echo JText::_('APPROVAL'); ?></span> </a> </div>
<div class="avsicon"> <a title="<?php echo JText::_('CONFIG'); ?>" href="index.php?option=com_allvideoshare&view=config"> <img alt="<?php echo JText::_('CONFIG'); ?>" src="components/com_allvideoshare/assets/config.png" /> <span><?php echo JText::_('CONFIG'); ?></span> </a> </div>
<div class="avsicon"> <a title="<?php echo JText::_('LICENSING'); ?>" href="index.php?option=com_allvideoshare&view=licensing"> <img alt="<?php echo JText::_('LICENSING'); ?>" src="components/com_allvideoshare/assets/license.png" /> <span><?php echo JText::_('LICENSING'); ?></span> </a> </div>
<div style=" clear:both"></div>
<div id="avstabs">
  <?php
	jimport('joomla.html.pane');
	$pane =& JPane::getInstance('tabs');
	
	echo $pane->startPane('content-pane');
	echo $pane->startPanel(JText::_('SUPPORT'), 'support');
  ?>
  <table class="adminlist">
    <tr class="row0">
      <td align="center"><strong>1.</strong></td>
      <td style="padding-left:10px;"><strong><?php echo JText::_('WEBSITE'); ?></strong></td>
      <td style="padding-left:10px;">http://allvideoshare.mrvinoth.com/</td>
    </tr>
    <tr class="row1">
      <td align="center"><strong>2.</strong></td>
      <td style="padding-left:10px;"><strong><?php echo JText::_('SUPPORT_MAIL'); ?></strong></td>
      <td style="padding-left:10px;">support@mrvinoth.com</td>
    </tr>
    <tr class="row0">
      <td align="center"><strong>3.</strong></td>
      <td style="padding-left:10px;"><strong><?php echo JText::_('FORUM_LINK'); ?></strong></td>
      <td style="padding-left:10px;">http://allvideoshare.mrvinoth.com/forum/</td>
    </tr>
    <tr class="row1">
      <td align="center"><strong>4.</strong></td>
      <td style="padding-left:10px;"><strong><?php echo JText::_('BUG_REPORT'); ?></strong></td>
      <td style="padding-left:10px;">issues@mrvinoth.com</td>
    </tr>
  </table>
  <?php  
  	echo $pane->endPanel(); 
  	echo $pane->startPanel(JText::_('SERVER_INFORMATION'), 'serverinformation'); 
  ?>
  <table class="adminlist">
    <?php
		$k = 0;
		for ($i=0, $n=count($server); $i < $n; $i++) {
			$row    = $server[$i];
			
			$k      = $i % 2;
			$color  = ($row['value'] == JText::_('NO')) ? '#FF0000' : '#339900';
			$status = $row['value'];
    ?>
    <tr class="<?php echo "row$k"; ?>">
      <td align="center"><strong><?php echo $i + 1; ?></strong></td>
      <td style="padding-left:10px;"><strong><?php echo $row['name']; ?></strong></td>
      <td align="center" style="color:<?php echo $color; ?>"><?php echo $status; ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php  
  	echo $pane->endPanel(); 
  	echo $pane->startPanel(JText::_('RECENTLY_ADDED_VIDEOS'), 'recentlyaddedvideos'); 
  ?>
  <table class="adminlist">
    <thead>
      <tr>
        <th width="8%">#</th>
        <th><?php echo JText::_('VIDEO_TITLE'); ?></th>
        <th width="20%"><?php echo JText::_('CATEGORY'); ?></th>
        <th width="12%"><?php echo JText::_('USER'); ?></th>
        <th width="12%"><?php echo JText::_('PUBLISHED'); ?></th>
      </tr>
    </thead>
    <?php
		$k = 0;
		for ($i=0, $n=count($recentvideos); $i < $n; $i++) {
			$row       = $recentvideos[$i];			
			$k         = $i % 2;
			$color     = ($row->published == 0) ? '#FF0000' : '#339900';
			$published = ($row->published == 0) ? JText::_('NO') : JText::_('YES');
    ?>
    <tr class="<?php echo "row$k"; ?>">
      <td align="center"><?php echo $i + 1; ?></td>
      <td align="center"><?php echo $row->title; ?></td>
      <td align="center"><?php echo $row->category; ?></td>
      <td align="center"><?php echo $row->user; ?></td>
      <td align="center" style="color:<?php echo $color; ?>"><?php echo $published; ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php  
  	echo $pane->endPanel(); 
  	echo $pane->startPanel(JText::_('RECENTLY_CREATED_CATEGORIES'), 'recentlycreatedcategories'); 
  ?>
  <table class="adminlist">
    <thead>
      <tr>
        <th width="8%">#</th>
        <th><?php echo JText::_('CATEGORY_NAME'); ?></th>
        <th width="15%"><?php echo JText::_('PUBLISHED'); ?></th>
      </tr>
    </thead>
    <?php
		$k = 0;
		for ($i=0, $n=count($recentcategories); $i < $n; $i++) {
			$row       = $recentcategories[$i];			
			$k         = $i % 2;
			$color     = ($row->published == 0) ? '#FF0000' : '#339900';
			$published = ($row->published == 0) ? JText::_('NO') : JText::_('YES');
	?>
    <tr class="<?php echo "row$k"; ?>">
      <td align="center"><?php echo $i + 1; ?></td>
      <td align="center"><?php echo $row->name; ?></td>
      <td align="center" style="color:<?php echo $color; ?>"><?php echo $published; ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php  
  	echo $pane->endPanel(); 
  	echo $pane->startPanel(JText::_('MOST_VIEWED_VIDEOS'), 'mostviewedvideos'); 
  ?>
  <table class="adminlist">
    <thead>
      <tr>
        <th width="8%">#</th>
        <th><?php echo JText::_('VIDEO_TITLE'); ?></th>
        <th width="20%"><?php echo JText::_('CATEGORY'); ?></th>
        <th width="12%"><?php echo JText::_('VIEWS'); ?></th>
        <th width="12%"><?php echo JText::_('PUBLISHED'); ?></th>
      </tr>
    </thead>
    <?php
		$k = 0;
		for ($i=0, $n=count($popularvideos); $i < $n; $i++) {
			$row       = $popularvideos[$i];			
			$k         = $i % 2;
			$color     = ($row->published == 0) ? '#FF0000' : '#339900';
			$published = ($row->published == 0) ? JText::_('NO') : JText::_('YES');
	?>
    <tr class="<?php echo "row$k"; ?>">
      <td align="center"><?php echo $i + 1; ?></td>
      <td align="center"><?php echo $row->title; ?></td>
      <td align="center"><?php echo $row->category; ?></td>
      <td align="center"><?php echo $row->views; ?></td>
      <td align="center" style="color:<?php echo $color; ?>"><?php echo $published; ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php 
	echo $pane->endPanel(); 
	echo $pane->endPane(); 
  ?>
</div>