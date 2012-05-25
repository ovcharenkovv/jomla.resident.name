<?php 
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip'); ?>

<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm" id="phocagalleryt-form" class="form-validate">

<?php 
if ($this->require_ftp) {
	echo PhocaGalleryFileUpload::renderFTPaccess();
} 
?>
<table class="adminform" border="0">
<?php if ($this->theme_name != '') { ?>
	<tr>
		<td colspan="3"><?php echo JText::_( 'COM_PHOCAGALLERY_CURRENT_THEME' ); ?> : <?php echo $this->theme_name; ?></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
<?php
}
?>
	<tr>
		<td width="5"><input type="checkbox" name="theme_component" value=""  /></td>
		<td colspan="2"><?php echo JText::_( 'COM_PHOCAGALLERY_APPLY_COMPONENT' ); ?></td>
	</tr>
	<?php /*
	<tr>
		<td width="5"><input type="checkbox" name="theme_categories" value="" /></td>
		<td colspan="2"><?php echo JText::_( 'COM_PHOCAGALLERY_APPLY_CATEGORIES' ); ?></td>
	</tr>
	<tr>
		<td width="5"><input type="checkbox" name="theme_category" value="" /></td>
		<td colspan="2"><?php echo JText::_( 'COM_PHOCAGALLERY_APPLY_CATEGORY' ); ?></td>
	</tr>
	*/ ?>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="2"><b><?php echo JText::_( 'COM_PHOCAGALLERY_UPLOAD_THEME_PACKAGE_FILE' ); ?></b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="120">
			<label for="install_package"><?php echo JText::_( 'COM_PHOCAGALLERY_UPLOAD_FILE' ); ?>:</label>
		</td>
		<td>
			<input class="input_box" id="install_package" name="install_package" type="file" size="57" />
			<input class="button" type="button" value="<?php echo JText::_( 'COM_PHOCAGALLERY_UPLOAD_FILE' ); ?> &amp; <?php echo JText::_( 'COM_PHOCAGALLERY_INSTALL' ); ?>" onclick="submitbutton()" />
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	</table>

	
<input type="hidden" name="type" value="" />
<input type="hidden" name="option" value="com_phocagallery" />
<input type="hidden" name="task" value="phocagalleryt.themeinstall" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

<?php  echo $this->loadTemplate('background_image'); ?>

<div id="pg-update" ><a href="http://www.phoca.cz/themes/" target="_blank"><?php echo JText::_('COM_PHOCAGALLERY_NEW_THEME_DOWNLOAD'); ?></a></div>

