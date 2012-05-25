<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'phocagalleryc.cancel' || document.formvalidator.isValid(document.id('phocagalleryc-form'))) {
			if (task == 'phocagalleryc.loadextimgp') {
				document.getElementById('loading-ext-imgp').style.display='block';
			}
			if (task == 'phocagalleryc.loadextimgf') {
				document.getElementById('loading-ext-imgf').style.display='block';
			}
			
			if (task == 'phocagalleryc.uploadextimgf') {
				document.getElementById('uploading-ext-imgf').style.display='block';
			}
			Joomla.submitform(task, document.getElementById('phocagalleryc-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_phocagallery'); ?>" method="post" name="adminForm" id="phocagalleryc-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php
			echo empty($this->item->id) ? JText::_('COM_PHOCAGALLERY_NEW_CATEGORY') : JText::sprintf('COM_PHOCAGALLERY_EDIT_CATEGORY', $this->item->id); ?></legend>
		
		<ul class="adminformlist">
			<?php 
			$formArray = array ('title', 'alias', 'parent_id', 'ordering',
			'access', 'accessuserid', 'uploaduserid', 'deleteuserid', 'owner_id', 'userfolder',
			'latitude', 'longitude', 'zoom', 'geotitle');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start','phocagallerx-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

	<?php echo JHtml::_('sliders.panel',JText::_('COM_PHOCAGALLERY_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="adminform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field) {
				echo '<li>';
				if (!$field->hidden) {
					echo $field->label;
				}
				echo $field->input;
				echo '</li>';
			} ?>
			</ul>
		</fieldset>
	
	
	
	<?php echo $this->loadTemplate('metadata'); ?>
		
	<?php echo JHtml::_('sliders.end'); ?>
	
	</div>

	<div class="clr"></div>
	
	<?php if ($this->tmpl['enablepicasaloading'] == 1) { ?>
	<div class="width-60 fltlft">
		<fieldset class="adminform">
		<legend><?php echo JText::_('COM_PHOCAGALLERY_PICASA_SETTINGS') ?></legend>
			<ul class="adminformlist">
				<?php 
				$formArray = array ('extu', 'exta', 'extauth');
				foreach ($formArray as $value) {
					echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
				} ?>
			</ul>
			<?php /*
			<div style="float:right;margin:5px" id="toolbar-loadext"><a href="#" onclick="javascript:Joomla.submitbutton('phocagalleryc.loadextimg')" >
<?php echo JText::_('COM_PHOCAGALLERY_LOAD_EXT_IMAGES'); ?></div>
			<div class="clr"></div> */ ?>
		</fieldset>
	</div>
	<?php } ?>
	
	<div class="clr"></div>
	
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PHOCAGALLERY_FB_SETTINGS') ?></legend>
			<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('extfbuid', 'extfbcatid');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
			
		</ul>
		
		
			<div class="clr"></div>
			</fieldset>

	</div>
	
	
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>


<div id="loading-ext-imgp"><div class="loading"><div><center><?php echo JHTML::_('image', 'administrator/components/com_phocagallery/assets/images/icon-loading.gif', JText::_('COM_PHOCAGALLERY_LOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_PICASA_LOADING_DATA'); ?></center></div></div></div>
<div id="loading-ext-imgf"><div class="loading"><div><center><?php echo JHTML::_('image', 'administrator/components/com_phocagallery/assets/images/icon-loading.gif', JText::_('COM_PHOCAGALLERY_LOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_FACEBOOK_LOADING_DATA'); ?></center></div></div></div>
<div id="uploading-ext-imgf"><div class="loading"><div><center><?php echo JHTML::_('image', 'administrator/components/com_phocagallery/assets/images/icon-loading.gif', JText::_('COM_PHOCAGALLERY_UPLOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_FB_UPLOADING_DATA'); ?></center></div></div></div>