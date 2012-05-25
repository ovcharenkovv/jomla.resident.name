<?php

/*
 * @version		$Id: add.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$editor   =& JFactory::getEditor();
$category = $this->category;

?>

<div id="avs">
  <p class="avsheader"><?php echo JText::_('ADD_A_NEW_VIDEO'); ?></p>
  <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('TITLE'); ?></td>
        <td><input type="text" name="title" size="60" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SLUG'); ?></td>
        <td><input type="text" name="slug" size="60" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TYPE'); ?></td>
        <td>
          <select id="type" name="type" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            <option value="url" id="url"><?php echo JText::_('DIRECT_URL'); ?></option>
            <option value="upload" id="upload"><?php echo JText::_('GENERAL_UPLOAD'); ?></option>
            <option value="youtube" id="youtube"><?php echo JText::_('YOUTUBE'); ?></option>
            <option value="rtmp" id="rtmp"><?php echo JText::_('RTMP_STREAMING'); ?></option>
            <option value="lighttpd" id="lighttpd"><?php echo JText::_('LIGHTTPD'); ?></option>
            <option value="highwinds" id="highwinds"><?php echo JText::_('HIGHWINDS'); ?></option>
            <option value="bitgravity" id="bitgravity"><?php echo JText::_('BITGRAVITY'); ?></option>
            <option value="thirdparty" id="thirdparty"><?php echo JText::_('THIRD_PARTY_EMBEDCODE'); ?></option>
          </select>
          <span id="avs_help"> 
          	<a href="http://allvideoshare.mrvinoth.com/forum/7-adding-videos/3-video-uploading-issues" target="_blank"><?php echo JText::_('GENERAL_UPLOAD_HELP'); ?></a>
          </span>
        </td>
      </tr>
      <tr id="data_streamer">
        <td class="avskey"><?php echo JText::_('STREAMER'); ?></td>
        <td><input type="text" name="streamer" size="60" /></td>
      </tr>
      <tr id="url_data_video">
        <td class="avskey"><?php echo JText::_('VIDEO'); ?></td>
        <td><input type="text" name="video" size="60" /></td>
      </tr>
      <tr id="url_data_hd">
        <td class="avskey"><?php echo JText::_('HD_VIDEO'); ?></td>
        <td><input type="text" name="hd" size="60" /></td>
      </tr>
      <tr id="url_data_thumb">
        <td class="avskey"><?php echo JText::_('THUMB'); ?></td>
        <td><input type="text" name="thumb" size="60" /></td>
      </tr>
      <tr id="url_data_preview">
        <td class="avskey"><?php echo JText::_('PREVIEW'); ?></td>
        <td><input type="text" name="preview" size="60" /></td>
      </tr>
      <tr id="upload_data_video">
        <td class="avskey"><?php echo JText::_('VIDEO'); ?></td>
        <td><input type="file" name="upload_video" maxlength="100" /></td>
      </tr>
      <tr id="upload_data_hd">
        <td class="avskey"><?php echo JText::_('HD_VIDEO'); ?></td>
        <td><input type="file" name="upload_hd" maxlength="100" /></td>
      </tr>
      <tr id="upload_data_thumb">
        <td class="avskey"><?php echo JText::_('THUMB'); ?></td>
        <td><input type="file" name="upload_thumb" maxlength="100" /></td>
      </tr>
      <tr id="upload_data_preview">
        <td class="avskey"><?php echo JText::_('PREVIEW'); ?></td>
        <td><input type="file" name="upload_preview" maxlength="100" /></td>
      </tr>
      <tr id="data_token">
        <td class="avskey"><?php echo JText::_('TOKEN'); ?></td>
        <td><input type="text" name="token" size="60" /></td>
      </tr>
      <tr id="data_dvr">
        <td class="avskey"><?php echo JText::_('DVR'); ?></td>
        <td><input type="checkbox" name="dvr" value="1" /></td>
      </tr>
      <tr id="data_thirdparty">
        <td class="avskey"><?php echo JText::_('THIRD_PARTY_EMBEDCODE'); ?></td>
        <td><textarea name="thirdparty" rows="10" cols="60" ></textarea></td>
      </tr>
      <tr>
        <td class="avskey" valign="top" style="padding-top:10px;"><?php echo JText::_('DESCRIPTION'); ?></td>
        <td><?php echo $editor->display('description', '', '700', '400', '60', '20', true); ?></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TAGS'); ?></td>
        <td><input type="text" name="tags" size="60" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SELECT_A_CATEGORY'); ?></td>
        <td>
          <select id="category" name="category" >
            <?php
            $k=count( $category );
            for ($i=0; $i < $k; $i++)
            {
               $row = $category[$i]->name;
            ?>
            <option value="<?php echo $row; ?>" id="<?php echo $row; ?>"><?php echo $row; ?></option>
            <?php } ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('FEATURED'); ?></td>
        <td><input type="checkbox" name="featured" value="1" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('PUBLISH'); ?></td>
        <td><input type="checkbox" name="published" value="1" checked="checked" /></td>
      </tr>
    </table>
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="option" value="com_allvideoshare" />
    <input type="hidden" name="view" value="videos" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="user" value="Admin" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
var form            = document.adminForm;
var type            = document.getElementById("type");
var videoExtensions = ['flv', 'mp4' , '3g2', '3gp', 'aac', 'f4b', 'f4p', 'f4v', 'm4a', 'm4v', 'mov', 'sdp', 'vp6', 'smil'];
var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
var isAllowed       = true;
changeType('url');

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
	var method = type.options[type.selectedIndex].value;
	
	if(form.title.value == '') {
       	alert( "<?php echo JText::_( 'TITLE_FIELD_SHOULD_NOT_BE_EMPTY', true); ?>" );
       	return false;
	}
	
	if(method == 'upload') {
		if(form.upload_video.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_A_VIDEO', true); ?>" );
       		return false;
	    } else {
			isAllowed = checkExtension('VIDEO', form.upload_video.value, videoExtensions);
			if(isAllowed == false) 	return false;
		}
		
		if(form.upload_hd.value) {
			isAllowed = checkExtension('HD VIDEO', form.upload_hd.value, videoExtensions);
			if(isAllowed == false) 	return false;
		}		
		
		if(form.upload_thumb.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_A_THUMB_IMAGE', true); ?>" );
       		return false;
	    } else {
			isAllowed = checkExtension('THUMB', form.upload_thumb.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
		
		if(form.upload_preview.value) {
			isAllowed = checkExtension('PREVIEW', form.upload_preview.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	} else if(method == 'url') {
		if(form.video.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_A_VIDEO', true); ?>" );
       		return false;
	    } else {
			isAllowed = checkExtension('VIDEO', form.video.value, videoExtensions);
			if(isAllowed == false) 	return false;
		}
		
		if(form.hd.value) {
			isAllowed = checkExtension('HD VIDEO', form.hd.value, videoExtensions);
			if(isAllowed == false) 	return false;
		}		
		
		if(form.preview.value) {
			isAllowed = checkExtension('PREVIEW', form.preview.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	} else if(method == 'rtmp') {
		if(form.streamer.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_THE_STREAMER_PATH', true); ?>" );
       		return false;
	    }
	} else if(method == 'thirdparty') {
		if(form.thirdparty.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_ANY_THIRD_PARTY_EMBEDCODE', true); ?>" );
       		return false;
	    }
	}	
	
	if(method != 'upload' && method != 'youtube') {
		if(form.thumb.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_A_THUMB_IMAGE', true); ?>" );
       		return false;
	    } else {
			isAllowed = checkExtension('THUMB', form.thumb.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	}
		
	if(form.category.value == '') {
		alert( "<?php echo JText::_( 'YOU_HAVE_NOT_SELECTED_ANY_CATEGORY_FOR_THE_VIDEO', true); ?>" );
       	return false;
	}
}

function checkExtension(type, filePath, validExtensions) {
	var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
}

function changeType(typ) {
	document.getElementById('url_data_video').style.display              = "none";
	document.getElementById('url_data_hd').style.display                 = "none";
	document.getElementById('url_data_thumb').style.display              = "none";
	document.getElementById('url_data_preview').style.display            = "none";
	document.getElementById('upload_data_video').style.display           = "none";
	document.getElementById('upload_data_hd').style.display              = "none";
	document.getElementById('upload_data_thumb').style.display           = "none";
	document.getElementById('upload_data_preview').style.display         = "none";
	document.getElementById('data_streamer').style.display               = "none";
	document.getElementById('data_token').style.display                  = "none";
	document.getElementById('data_dvr').style.display                    = "none";
	document.getElementById('data_thirdparty').style.display             = "none";
	document.getElementById('avs_help').style.display                    = "none";
    switch(typ) {
		case 'url' :
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('url_data_hd').style.display         = "";
			document.getElementById('url_data_thumb').style.display      = "";
			document.getElementById('url_data_preview').style.display    = "";
			break;
		case 'upload':
			document.getElementById('upload_data_video').style.display   = "";
			document.getElementById('upload_data_hd').style.display      = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			document.getElementById('avs_help').style.display            = "";
			break;
		case 'youtube'  :
		case 'highwinds':
		case 'lighttpd' :
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('url_data_thumb').style.display      = "";
			document.getElementById('url_data_preview').style.display    = "";
			break;
		case 'rtmp':
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('url_data_thumb').style.display      = "";
			document.getElementById('url_data_preview').style.display    = "";
			document.getElementById('data_streamer').style.display       = "";
			document.getElementById('data_token').style.display          = "";
			break;
		case 'bitgravity':
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('url_data_thumb').style.display      = "";
			document.getElementById('url_data_preview').style.display    = "";
			document.getElementById('data_dvr').style.display            = "";
			break;
		case 'thirdparty':
			document.getElementById('url_data_thumb').style.display      = "";
			document.getElementById('data_thirdparty').style.display     = "";
			break;
	}	
}
</script>