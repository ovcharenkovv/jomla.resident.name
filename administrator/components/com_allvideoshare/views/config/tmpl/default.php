<?php

/*
 * @version		$Id: default.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$data    = $this->data;
$players = $this->players;
$editor  =& JFactory::getEditor();

jimport('joomla.html.pane');
$pane   =& JPane::getInstance('tabs');

?>

<div id="avs">
  <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <?php 
		echo $pane->startPane('content-pane');
		echo $pane->startPanel(JText::_('GALLERY_SETTINGS'), 'gallerysettings'); 
  	?>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('NO_OF_ROWS'); ?></td>
        <td><input type="text" name="rows" value="<?php echo $data->rows; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('NO_OF_COLS'); ?></td>
        <td><input type="text" name="cols" value="<?php echo $data->cols; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('THUMBNAIL_WIDTH'); ?></td>
        <td><input type="text" name="thumb_width" value="<?php echo $data->thumb_width; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('THUMBNAIL_HEIGHT'); ?></td>
        <td><input type="text" name="thumb_height" value="<?php echo $data->thumb_height; ?>" /></td>
      </tr>
    </table>
    <?php 
		echo $pane->endPanel(); 
		echo $pane->startPanel(JText::_('VIDEO_PAGE_SETTINGS'), 'videopagesettings'); 
  	?>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('SELECT_THE_PLAYER'); ?></td>
        <td>
          <select id="playerid" name="playerid" >
            <?php
            $k = count( $players );
            for ($i=0; $i < $k; $i++)
            {
               $row = $players[$i];
            ?>
            <option value="<?php echo $row->id; ?>" id="<?php echo 'player_'.$row->id; ?>"><?php echo $row->name; ?></option>
            <?php } ?>
          </select>
          <?php echo '<script>document.getElementById("player_'.$data->playerid.'").selected="selected"</script>'; ?>
        </td>
      </tr>
      <tr>
        <td class="avskey" width="150"><?php echo JText::_('LAYOUT_TYPE'); ?></td>
        <td>
          <select id="layout" name="layout" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            <option value="all" id="layout_all"><?php echo JText::_('PLAYER_WITH_COMMENTS_AND_RELATED_VIDEOS'); ?></option>
            <option value="comments" id="layout_comments"><?php echo JText::_('PLAYER_WITH_COMMENTS_ONLY'); ?></option>
            <option value="relatedvideos" id="layout_relatedvideos"><?php echo JText::_('PLAYER_WITH_RELATED_VIDEOS_ONLY'); ?></option>
            <option value="none" id="layout_none"><?php echo JText::_('PLAYER_ONLY'); ?></option>
          </select>
          <?php echo '<script>document.getElementById("layout_'.$data->layout.'").selected="selected"</script>'; ?>
        </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SHOW_VIDEO_TITLE'); ?></td>
        <td><input type="checkbox" name="title" value="1" <?php if($data->title == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SHOW_VIDEO_DESCRIPTION'); ?></td>
        <td><input type="checkbox" name="description" value="1" <?php if($data->description == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SHOW_CATEGORY_NAME'); ?></td>
        <td><input type="checkbox" name="category" value="1" <?php if($data->category == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SHOW_VIEW_COUNT'); ?></td>
        <td><input type="checkbox" name="views" value="1" <?php if($data->views == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SHOW_SEARCH_BOX'); ?></td>
        <td><input type="checkbox" name="search" value="1" <?php if($data->search == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
    </table>
    <div id="data_comments">
      <p class="avssubheader"><?php echo JText::_('FACEBOOK_COMMENTS_SETTINGS'); ?></p>
      <table class="admintable">
        <tr>
          <td class="avskey" width="150"><?php echo JText::_('NO_OF_POSTS'); ?></td>
          <td><input type="text" name="comments_posts" value="<?php echo $data->comments_posts; ?>" /></td>
        </tr>
        <tr>
          <td class="avskey"><?php echo JText::_('COLOR_SCHEME'); ?></td>
          <td>
            <select id="comments_color" name="comments_color">
              <option value="light" id="comments_light"><?php echo JText::_('LIGHT'); ?></option>
              <option value="dark" id="comments_dark"><?php echo JText::_('DARK'); ?></option>
            </select>
          </td>
          <?php echo '<script>document.getElementById("comments_'.$data->comments_color.'").selected="selected"</script>'; ?> </tr>
      </table>
    </div>
    <?php 
		echo $pane->endPanel(); 
		echo $pane->startPanel(JText::_('FRONT_END_USER_SETTINGS'), 'frontendusersettings'); 
  	?>
    <table class="admintable">
      <tr>
        <td><input type="checkbox" name="auto_approval" value="1" <?php if($data->auto_approval == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('AUTO_APPROVE_USER_ADDED_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_youtube" value="1" <?php if($data->type_youtube == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_YOUTUBE_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_rtmp" value="1" <?php if($data->type_rtmp == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_RTMP_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_lighttpd" value="1" <?php if($data->type_lighttpd == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_LIGHTTPD_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_highwinds" value="1" <?php if($data->type_highwinds == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_HIGHWINDS_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_bitgravity" value="1" <?php if($data->type_bitgravity == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_BITGRAVITY_VIDEOS'); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="type_thirdparty" value="1" <?php if($data->type_thirdparty == 1) echo 'checked="checked"'; ?> /></td>
        <td class="avskey"><?php echo JText::_('ALLOW_USERS_TO_ADD_THIRDPARTY_VIDEOS'); ?></td>
      </tr>
    </table>
    <?php 
		echo $pane->endPanel(); 
		echo $pane->startPanel(JText::_('FRONT_END_STYLESHEET'), 'frontendstylesheet'); 
  	?>
    <table class="admintable">
      <tr>
        <td><textarea name="css" style="width:99.5%; height:500px;" rows="40" cols="200"><?php echo $data->css; ?></textarea></td>
      </tr>
    </table>
    <?php 
		echo $pane->endPanel(); 
		echo $pane->endPane(); 
  	?>
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="option" value="com_allvideoshare" />
    <input type="hidden" name="view" value="config" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="id" value="1">
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
var form   = document.adminForm;
var layout = document.getElementById("layout");
changeType('layout_<?php echo $data->layout; ?>');

if(<?php echo substr(JVERSION,0,3); ?> != '1.5') {
	Joomla.submitbutton = submitbutton;
}
	
function submitbutton(pressbutton){ 	
	submitform( pressbutton );	
	return;
}

function changeType(typ) {
	document.getElementById('data_comments').style.display = "";
	switch(typ) {
		case 'layout_relatedvideos' :
		case 'layout_none'          :
			document.getElementById('data_comments').style.display = "none";
			break;
	}	
}
</script>