<?php 

/*
 * @version		$Id: edit.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

if(!$this->user) {
	echo JText::_('YOU_NEED_TO_REGISTER_TO_VIEW_THIS_PAGE');
	return;
}

$config   = $this->config;
$data     = $this->video;
$category = $this->category;
$header   = ( substr(JVERSION,0,3) != '1.5' ) ? 'page_heading' : 'page_title';
$cancel   = 'index.php?option=com_allvideoshare&view=user';
$qs       = JRequest::getVar('Itemid') ? '&Itemid=' . JRequest::getVar('Itemid') : '';

$document =& JFactory::getDocument();
$document->addStyleSheet( JRoute::_("index.php?option=com_allvideoshare&view=css"),'text/css',"screen");

?>
<?php if ($this->params->get('show_'.$header, 1)) : ?>
	<h2> <?php echo $this->escape($this->params->get($header)); ?> </h2>
<?php endif; ?>
<?php
	jimport('joomla.html.pane');
	$pane =& JPane::getInstance( 'tabs' );
	echo $pane->startPane( 'pane' );
	echo $pane->startPanel( JText::_('EDIT_THIS_VIDEO'), 'editthisvideo' );
?>
<div class="avs_user<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
  <form action="index.php"method="post"  name="adminForm" id="adminForm" onsubmit="return submitbutton();" enctype="multipart/form-data">
    <table>
      <tr>
        <td class="avskey"><?php echo JText::_('TITLE'); ?></td>
        <td><input type="text" name="title" size="60" value="<?php echo $data->title; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('SLUG'); ?></td>
        <td><input type="text" name="slug" size="60" value="<?php echo $data->slug; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TYPE'); ?></td>
        <td>
          <select id="type" name="type" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            <option value="url" id="url"><?php echo JText::_('DIRECT_URL'); ?></option>
            <option value="upload" id="upload"><?php echo JText::_('GENERAL_UPLOAD'); ?></option>
            <?php if($config[0]->type_youtube) { ?>
            <option value="youtube" id="youtube"><?php echo JText::_('YOUTUBE'); ?></option>
            <?php } ?>
            <?php if($config[0]->type_rtmp) { ?>
            <option value="rtmp" id="rtmp"><?php echo JText::_('RTMP_STREAMING'); ?></option>
            <?php } ?>
            <?php if($config[0]->type_lighttpd) { ?>
            <option value="lighttpd" id="lighttpd"><?php echo JText::_('LIGHTTPD'); ?></option>
            <?php } ?>
            <?php if($config[0]->type_highwinds) { ?>
            <option value="highwinds" id="highwinds"><?php echo JText::_('HIGHWINDS'); ?></option>
            <?php } ?>
            <?php if($config[0]->type_bitgravity) { ?>
            <option value="bitgravity" id="bitgravity"><?php echo JText::_('BITGRAVITY'); ?></option>
            <?php } ?>
            <?php if($config[0]->type_thirdparty) { ?>
            <option value="thirdparty" id="thirdparty"><?php echo JText::_('THIRD_PARTY_EMBEDCODE'); ?></option>
            <?php } ?>
          </select>
          <?php echo '<script>document.getElementById("'.$data->type.'").selected="selected"</script>'; ?> 
        </td>
      </tr>
      <tr id="data_streamer">
        <td class="avskey"><?php echo JText::_('STREAMER'); ?></td>
        <td><input type="text" name="streamer" size="60" value="<?php echo $data->streamer; ?>" /></td>
      </tr>
      <tr id="url_data_video">
        <td class="avskey"><?php echo JText::_('VIDEO'); ?></td>
        <td><input type="text" name="video" size="60" value="<?php echo $data->video; ?>" /></td>
      </tr>
      <tr id="url_data_hd">
        <td class="avskey"><?php echo JText::_('HD_VIDEO'); ?></td>
        <td><input type="text" name="hd" size="60" value="<?php echo $data->hd; ?>" /></td>
      </tr>
      <tr id="url_data_thumb">
        <td class="avskey"><?php echo JText::_('THUMB'); ?></td>
        <td><input type="text" name="thumb" size="60" value="<?php echo $data->thumb; ?>" /></td>
      </tr>
      <tr id="url_data_preview">
        <td class="avskey"><?php echo JText::_('PREVIEW'); ?></td>
        <td><input type="text" name="preview" size="60" value="<?php echo $data->preview; ?>" /></td>
      </tr>
      <tr id="upload_data_video">
        <td class="avskey"><?php echo JText::_('VIDEO'); ?></td>
        <td id="upload_video"><?php if($data->video) { ?>
          <input name="upload_video" readonly="readonly" value="<?php echo $data->video; ?>" size="47" />
          <input type="button" name="change" value="Change" onclick="changeMode('video')" />
          <?php } else { ?>
          <input type="file" name="upload_video" maxlength="100" />
          <?php } ?>
        </td>
      </tr>
      <tr id="upload_data_hd">
        <td class="avskey"><?php echo JText::_('HD_VIDEO'); ?></td>
        <td id="upload_hd"><?php if($data->hd) { ?>
          <input name="upload_hd" readonly="readonly" value="<?php echo $data->hd; ?>" size="47" />
          <input type="button" name="change" value="Change" onclick="changeMode('hd')" />
          <?php } else { ?>
          <input type="file" name="upload_hd" maxlength="100" />
          <?php } ?>
        </td>
      </tr>
      <tr id="upload_data_thumb">
        <td class="avskey"><?php echo JText::_('THUMB'); ?></td>
        <td id="upload_thumb"><?php if($data->thumb) { ?>
          <input name="upload_thumb" readonly="readonly" value="<?php echo $data->thumb; ?>" size="47" />
          <input type="button" name="change" value="Change" onclick="changeMode('thumb')" />
          <?php } else { ?>
          <input type="file" name="upload_thumb" maxlength="100" />
          <?php } ?>
        </td>
      </tr>
      <tr id="upload_data_preview">
        <td class="avskey"><?php echo JText::_('PREVIEW'); ?></td>
        <td id="upload_preview"><?php if($data->preview) { ?>
          <input name="upload_preview" readonly="readonly" value="<?php echo $data->preview; ?>" size="47" />
          <input type="button" name="change" value="Change" onclick="changeMode('preview')" />
          <?php } else { ?>
          <input type="file" name="upload_preview" maxlength="100" />
          <?php } ?>
        </td>
      </tr>
      <tr id="data_token">
        <td class="avskey"><?php echo JText::_('TOKEN'); ?></td>
        <td><input type="text" name="token" size="60" value="<?php echo $data->token; ?>" /></td>
      </tr>
      <tr id="data_dvr">
        <td class="avskey"><?php echo JText::_('DVR'); ?></td>
        <td><input type="checkbox" name="dvr" value="1" <?php if($data->dvr == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
      <tr id="data_thirdparty">
        <td class="avskey"><?php echo JText::_('THIRD_PARTY_EMBEDCODE'); ?></td>
        <td><textarea name="thirdparty" rows="10" cols="60" ><?php echo $data->thirdparty; ?></textarea></td>
      </tr>
      <tr>
        <td class="avskey" valign="top" style="padding-top:10px;"><?php echo JText::_('DESCRIPTION'); ?></td>
        <td><textarea name="description" rows="10" cols="60" ><?php echo $data->description; ?></textarea></td>
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
          <?php echo '<script>document.getElementById("'.$data->category.'").selected="selected"</script>'; ?> 
        </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('TAGS'); ?></td>
        <td><input type="text" name="tags" size="60" value="<?php echo $data->tags; ?>" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="<?php echo JText::_('SAVE_CHANGES'); ?>" />
          <input type="button" value="<?php echo JText::_('CANCEL'); ?>" onClick="javascript:location.href='<?php echo JRoute::_( $cancel . $qs ); ?>';" />
        </td>
      </tr>
    </table>
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="option" value="com_allvideoshare">
    <input type="hidden" name="view" value="user">
    <input type="hidden" name="task" value="savevideo" />
    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
    <input type="hidden" name="user" value="<?php echo $this->user; ?>">
    <input type="hidden" name="featured" value="<?php echo $data->featured; ?>">
    <input type="hidden" name="published" value="<?php echo $data->published; ?>">
    <input type="hidden" name="qs" value="<?php echo $qs; ?>">
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<?php 
	echo $pane->endPanel();
	echo $pane->endPane();
?>
<script type="text/javascript">
var form            = document.adminForm;
var type            = document.getElementById("type");
var videoExtensions = ['flv', 'mp4' , '3g2', '3gp', 'aac', 'f4b', 'f4p', 'f4v', 'm4a', 'm4v', 'mov', 'sdp', 'vp6', 'smil'];
var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
var isAllowed       = true;
changeType('<?php echo $data->type; ?>');

function submitbutton() {
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
	
	if(method != 'youtube') {
		if(form.upload_thumb.value == '') {
       		alert( "<?php echo JText::_( 'YOU_MUST_ADD_A_THUMB_IMAGE', true); ?>" );
       		return false;
	    } else {
			isAllowed = checkExtension('THUMB', form.upload_thumb.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	}
	
	if(form.category.value == '') {
		alert( "<?php echo JText::_( 'YOU_HAVE_NOT_SELECTED_ANY_CATEGORY_FOR_THE_VIDEO', true); ?>" );
       	return false;
	}
	
	return true;
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
    switch(typ) {
		case 'url' :		
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('url_data_hd').style.display         = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			break;
		case 'upload':
			document.getElementById('upload_data_video').style.display   = "";
			document.getElementById('upload_data_hd').style.display      = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			break;
		case 'youtube':		
			document.getElementById('url_data_video').style.display      = "";
			break;
		case 'highwinds':
		case 'lighttpd' :
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			break;
		case 'rtmp':
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			document.getElementById('data_streamer').style.display       = "";
			document.getElementById('data_token').style.display          = "";
			break;
		case 'bitgravity':
			document.getElementById('url_data_video').style.display      = "";
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('upload_data_preview').style.display = "";
			document.getElementById('data_dvr').style.display            = "";
			break;
		case 'thirdparty':
			document.getElementById('upload_data_thumb').style.display   = "";
			document.getElementById('data_thirdparty').style.display     = "";
			break;

	}	
}

function changeMode(inp) {
    var mode;
    mode='<input type="file" name="upload_' + inp + '" maxlength="100" />';
	document.getElementById('upload_' + inp).innerHTML = mode;
}
</script>