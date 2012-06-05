<?php 

/*
 * @version		$Id: default_videos.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

$morelink  = ( $items['catslg'] != "0" ) ? 'index.php?option=com_allvideoshare&view=category&slg='.$items['catslg'] : 'index.php?option=com_allvideoshare&view=video';
$morelink .= '&orderby='.$items['orderby'];
$link      = ( $items['link'] != '' ) ? $items['link'] : 'index.php?option=com_allvideoshare&view=video';
$qs        = (!strpos($link, '?')) ? '?' : '&';
$videos    = $items['data'];
$more      = $items['more'];
$count     = $items['columns'] * $items['rows'];
if(count($videos) <= $count) {
	$more  = 0;
	$count = count($videos);
}
$row       = 0;
$column    = 0;

$document =& JFactory::getDocument();
$document->addStyleSheet( JURI::root() . "components/com_allvideoshare/css/allvideoshare.css",'text/css',"screen");

?>

<div id="avs_gallery<?php echo $moduleclass_sfx; ?>" class="avs_gallery<?php echo $moduleclass_sfx; ?>">
  <?php 
  	if(!count($videos)) echo JText::_('ITEM_NOT_FOUND');
  	for ($i=0, $n=$count; $i < $n; $i++) {   
		$clear = ''; 
    	if($column >= $items['columns']) {
			$clear  = '<div style="clear:both;"></div>';
			$column = 0;
			$row++;		
		}
		$column++;
		echo $clear;
  ?>
  <div class="avs_thumb" style="width:<?php echo $items['thumb_width']; ?>px;"> 
  	<a href="<?php echo JRoute::_($link.$qs.'slg='.$videos[$i]->slug.'&Itemid='.JRequest::getVar('Itemid').'&orderby='.$items['orderby']); ?>">
    	<img class="arrow" src="<?php echo JURI::root(); ?>components/com_allvideoshare/assets/play.gif" border="0" style="margin-left:<?php echo ($items['thumb_width'] / 2) - 21; ?>px; margin-top:<?php echo ($items['thumb_height'] / 2) - 21; ?>px;" />
        <img class="image" src="<?php echo $videos[$i]->thumb; ?>" width="<?php echo $items['thumb_width']; ?>" height="<?php echo $items['thumb_height']; ?>" title="<?php echo JText::_('CLICK_TO_VIEW') . ' : ' . $videos[$i]->title; ?>" border="0" /> 
        <span class="title"><?php echo $videos[$i]->title; ?></span> 
        <span class="views"><strong>views : </strong><?php echo $videos[$i]->views; ?></span> 
    </a> 
  </div>
  <?php } ?>
  <div style="clear:both"></div>
</div>
<?php if($more == 1) { ?>
	<div class="avsmore"><a href="<?php echo JRoute::_($morelink); ?>"><?php echo JText::_('MORE'); ?></a></div>
<?php } ?>