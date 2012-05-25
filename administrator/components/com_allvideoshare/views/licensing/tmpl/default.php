<?php

/*
 * @version		$Id: default.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$data = $this->data;

?>

<div id="avs">
  <p class="avsheader"><?php echo JText::_('LICENSING_THE_COMPONENT'); ?></p>
  <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <table class="admintable">
      <tr>
        <td class="avskey"><?php echo JText::_('LICENSE_KEY'); ?></td>
        <td><input type="text" name="licensekey" size="60" value="<?php echo $data->licensekey; ?>" /></td>
      </tr>
      <tr id="upload_type">
        <td class="avskey"></td>
        <td class="avskey"><input type="radio" name="type" value="upload" <?php if($data->type == "upload") echo 'checked="checked"'; ?> onclick="changeUpload('upload')" />
          <?php echo JText::_('UPLOAD'); ?>&nbsp;&nbsp;
          <input type="radio" name="type" value="url" <?php if($data->type == "url") echo 'checked="checked"'; ?> onclick="changeUpload('url')" />
          <?php echo JText::_('URL'); ?></td>
      </tr>
      <tr id="url_data_logo">
        <td class="avskey"><?php echo JText::_('LOGO'); ?></td>
        <td><input type="text" name="logo" size="60" value="<?php echo $data->logo; ?>" /></td>
      </tr>
      <tr id="upload_data_logo">
        <td class="avskey"><?php echo JText::_('LOGO'); ?></td>
        <td id="upload_logo"><?php if($data->logo) { ?>
          <input name="upload_logo" readonly="readonly" value="<?php echo $data->logo; ?>" size="47" />
          <input type="button" name="change" value="Change" onclick="changeMode('logo')" />
          <?php } else { ?>
          <input type="file" name="upload_logo" maxlength="100" />
          <?php } ?>
        </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('LOGO_POSITION'); ?></td>
        <td>
          <select id="logoposition" name="logoposition" >
            <option value="topleft" id="topleft"><?php echo JText::_('TOP_LEFT'); ?></option>
            <option value="topright" id="topright"><?php echo JText::_('TOP_RIGHT'); ?></option>
            <option value="bottomleft" id="bottomleft"><?php echo JText::_('BOTTOM_LEFT'); ?></option>
            <option value="bottomright" id="bottomright"><?php echo JText::_('BOTTOM_RIGHT'); ?></option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->logoposition.'").selected="selected"</script>'; ?> </td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('LOGO_ALPHA'); ?></td>
        <td><input type="text" name="logoalpha" size="60" value="<?php echo $data->logoalpha; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('LOGO_TARGET'); ?></td>
        <td><input type="text" name="logotarget" size="60" value="<?php echo $data->logotarget; ?>" /></td>
      </tr>
      <tr>
        <td class="avskey"><?php echo JText::_('DISPLAY_LOGO'); ?></td>
        <td><input type="checkbox" name="displaylogo" value="1" <?php if($data->displaylogo == 1) echo 'checked="checked"'; ?> /></td>
      </tr>
    </table>
    <input type="hidden" name="boxchecked" value="1">
    <input type="hidden" name="option" value="com_allvideoshare" />
    <input type="hidden" name="view" value="licensing" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
var form            = document.adminForm;
var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
var isAllowed       = true;
changeUpload('<?php echo $data->type; ?>');

if(<?php echo substr(JVERSION,0,3); ?> != '1.5') {
	Joomla.submitbutton = submitbutton;
}
	
function submitbutton(pressbutton){ 	
	if(pressbutton == 'save') {	
		if(valForm() == false) return;
	}
	submitform( pressbutton );	
	return;
}

function valForm() {
	if(valButton(form.type) == 'upload') {
		if(form.upload_logo.value) {
       		isAllowed = checkExtension('LOGO', form.upload_logo.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	} else {
		if(form.logo.value) {
			isAllowed = checkExtension('LOGO', form.logo.value, imageExtensions);
			if(isAllowed == false) 	return false;
		}
	}	
}

function valButton(btn) {
	var cnt = -1;
    for (var i=btn.length-1; i > -1; i--) {
        if (btn[i].checked) {cnt = i; i = -1;}
    }
    if (cnt > -1) return btn[cnt].value;
    else return null;
}

function checkExtension(type, filePath, validExtensions) {
	var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
}

function changeUpload(typ) {
	document.getElementById('url_data_logo').style.display             = "none";
	document.getElementById('upload_data_logo').style.display          = "none";
    switch(typ) {
		case 'upload':
			document.getElementById('upload_data_logo').style.display  = "";
			break;
		case 'url':
			document.getElementById('url_data_logo').style.display     = "";
			break;

	}	
}

function changeMode(inp) {
    var mode;
    mode='<input type="file" name="upload_' + inp + '" maxlength="100" />';
	document.getElementById('upload_' + inp).innerHTML = mode;
}
</script>