<?php

/*
 * @version		$Id: add.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$data = $this->data;

?>

<div id="avs">
  <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <p class="avsheader"><?php echo JText::_('GENERAL_SETTINGS'); ?></p>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('NAME'); ?></td>
        <td><input type="text" name="name" size="60" value="<?php echo $data->name; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('WIDTH'); ?></td>
        <td><input type="text" name="width" size="60" value="<?php echo $data->width; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('HEIGHT'); ?></td>
        <td><input type="text" name="height" size="60" value="<?php echo $data->height; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('LOOP'); ?></td>
        <td><input type="checkbox" name="loop" value="1" <?php if($data->loop == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('AUTOSTART'); ?></td>
        <td><input type="checkbox" name="autostart" value="1" <?php if($data->autostart == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('BUFFER_TIME'); ?></td>
        <td><input type="text" name="buffer" size="60" value="<?php echo $data->buffer; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('VOLUME_LEVEL'); ?></td>
        <td><input type="text" name="volumelevel" size="60" value="<?php echo $data->volumelevel; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('STRETCH'); ?></td>
        <td>
          <select id="stretch" name="stretch" >
            <option value="uniform" id="uniform"><?php echo JText::_('UNIFORM'); ?></option>
            <option value="fill" id="fill"><?php echo JText::_('FILL'); ?></option>
            <option value="original" id="original"><?php echo JText::_('ORIGINAL'); ?></option>
            <option value="exactfit" id="exactfit"><?php echo JText::_('EXACT_FIT'); ?></option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->stretch.'").selected="selected"</script>'; ?> </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('PUBLISH'); ?></td>
        <td><input type="checkbox" name="published" value="1" <?php if($data->published == 1) echo 'checked="checked"'; ?> <?php if($data->id == 1) echo 'disabled="disabled"'; ?>/>
        </td>
      </tr>
    </table>
    <p class="avsheader"><?php echo JText::_('ENABLE_OR_DISABLE_SKIN_ELEMENTS'); ?></p>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('CONTROLBAR'); ?></td>
        <td><input type="checkbox" name="controlbar" value="1" <?php if($data->controlbar == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('RELATED_VIDEOS'); ?></td>
        <td><input type="checkbox" name="playlist" value="1" <?php if($data->playlist == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('DURATION_DOCK'); ?></td>
        <td><input type="checkbox" name="durationdock" value="1" <?php if($data->durationdock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TIMER_DOCK'); ?></td>
        <td><input type="checkbox" name="timerdock" value="1" <?php if($data->timerdock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('FULLSCREEN_DOCK'); ?></td>
        <td><input type="checkbox" name="fullscreendock" value="1" <?php if($data->fullscreendock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('HD_DOCK'); ?></td>
        <td><input type="checkbox" name="hddock" value="1" <?php if($data->hddock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('EMBED_DOCK'); ?></td>
        <td><input type="checkbox" name="embeddock" value="1" <?php if($data->embeddock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('FACEBOOK_DOCK'); ?></td>
        <td><input type="checkbox" name="facebookdock" value="1" <?php if($data->facebookdock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TWITTER_DOCK'); ?></td>
        <td><input type="checkbox" name="twitterdock" value="1" <?php if($data->twitterdock == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
    </table>
    <p class="avsheader"><?php echo JText::_('COLOR_YOUR_SKIN'); ?></p>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('CONTROLBAR_OUTLINE_COLOR'); ?></td>
        <td><input type="text" name="controlbaroutlinecolor" size="60" value="<?php echo $data->controlbaroutlinecolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('CONTROLBAR_BG_COLOR'); ?></td>
        <td><input type="text" name="controlbarbgcolor" size="60" value="<?php echo $data->controlbarbgcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('CONTROLBAR_OVERLAY_COLOR'); ?></td>
        <td><input type="text" name="controlbaroverlaycolor" size="60" value="<?php echo $data->controlbaroverlaycolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('CONTROLBAR_OVERLAY_ALPHA'); ?></td>
        <td><input type="text" name="controlbaroverlayalpha" size="60" value="<?php echo $data->controlbaroverlayalpha; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('ICON_COLOR'); ?></td>
        <td><input type="text" name="iconcolor" size="60" value="<?php echo $data->iconcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('PROGRESSBAR_BG_COLOR'); ?></td>
        <td><input type="text" name="progressbarbgcolor" size="60" value="<?php echo $data->progressbarbgcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('PROGRESSBAR_BUFFER_COLOR'); ?></td>
        <td><input type="text" name="progressbarbuffercolor" size="60" value="<?php echo $data->progressbarbuffercolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('PROGRESSBAR_SEEK_COLOR'); ?></td>
        <td><input type="text" name="progressbarseekcolor" size="60" value="<?php echo $data->progressbarseekcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('VOLUMEBAR_BG_COLOR'); ?></td>
        <td><input type="text" name="volumebarbgcolor" size="60" value="<?php echo $data->volumebarbgcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('VOLUMEBAR_SEEK_COLOR'); ?></td>
        <td><input type="text" name="volumebarseekcolor" size="60" value="<?php echo $data->volumebarseekcolor; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('RELATED_VIDEOS_BG_COLOR'); ?></td>
        <td><input type="text" name="playlistbgcolor" size="60" value="<?php echo $data->playlistbgcolor; ?>" /></td>
      </tr>
    </table>
    <p class="avsheader"><?php echo JText::_('RELATED_VIDEOS_INSIDE_THE_PLAYER'); ?></p>
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('CUSTOM_PLAYER_PAGE'); ?></td>
        <td><input type="text" name="customplayerpage" size="60" value="<?php echo $data->customplayerpage; ?>" />
          <span id="avs_help"> <a href="http://allvideoshare.mrvinoth.com/custom-player-page-url" target="_blank"><?php echo JText::_('WHAT_IS_THIS'); ?></a> </span> 
        </td>
      </tr>
    </table>
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="option" value="com_allvideoshare" />
    <input type="hidden" name="view" value="players" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
var form = document.adminForm;

if(<?php echo substr(JVERSION,0,3); ?> != '1.5') {
	Joomla.submitbutton = submitbutton;
}
	
function submitbutton(pressbutton){ 	
	if(pressbutton == 'save' || pressbutton == 'apply') {	
		if(valForm() == false) return;
	}
	submitform( pressbutton );	
	return;
}

function valForm() {
	if(form.name.value == '') {
       	alert( "<?php echo JText::_( 'NAME_FIELD_SHOULD_NOT_BE_EMPTY', true); ?>" );
       	return false;
	}
	
	if(form.width.value == '') {
       	alert( "<?php echo JText::_( 'WIDTH_FIELD_SHOULD_NOT_BE_EMPTY', true); ?>" );
       	return false;
	}
	
	if(form.height.value == '') {
       	alert( "<?php echo JText::_( 'HEIGHT_FIELD_SHOULD_NOT_BE_EMPTY', true); ?>" );
       	return false;
	}
	
	if(form.playlist.value == 1 && form.width.value < 320 || form.height.value < 240) {
       	alert( "<?php echo JText::_( 'YOUR_PLAYER_SIZE_SHOULD_BE_ATLEAST_320X240_TO_HAVE_THE_RELATED_VIDEOS', true); ?>" );
       	return false;
	}
}
</script>