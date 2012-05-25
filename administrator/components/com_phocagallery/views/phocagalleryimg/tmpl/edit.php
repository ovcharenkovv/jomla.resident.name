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
	
		if (task != 'phocagalleryimg.cancel' && document.id('jform_catid').value == '') {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')) . ' - '. $this->escape(JText::_('COM_PHOCAGALLERY_CATEGORY_NOT_SELECTED'));?>');
		} else if (task == 'phocagalleryimg.cancel' || document.formvalidator.isValid(document.id('phocagalleryimg-form'))) {
			Joomla.submitform(task, document.getElementById('phocagalleryimg-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>


<form action="<?php JRoute::_('index.php?option=com_phocagallery'); ?>" method="post" name="adminForm" id="phocagalleryimg-form" class="form-validate">
	<div class="width-60 fltlft">
		
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_PHOCAGALLERY_NEW_IMAGE') : JText::sprintf('COM_PHOCAGALLERY_EDIT_IMAGE', $this->item->id); ?></legend>
			
			
<?php 		
// - - - - - - - - - -
// Image

$fileOriginal = PhocaGalleryFile::getFileOriginal($this->item->filename);
if (!JFile::exists($fileOriginal)) {
	$this->item->fileoriginalexist = 0;
} else {
	$fileThumb 		= PhocaGalleryFileThumbnail::getOrCreateThumbnail($this->item->filename, '', 0, 0, 0);
	$this->item->linkthumbnailpath 	= $fileThumb['thumb_name_s_no_rel'];
	$this->item->fileoriginalexist = 1;	
}

echo '<div style="float:right;margin:5px;">';
// PICASA
if (isset($this->item->extid) && $this->item->extid !='') {									
	
	$resW				= explode(',', $this->item->extw);
	$resH				= explode(',', $this->item->exth);
	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($resW[2], $resH[2], 50, 50);
	$imgLink			= $this->item->extl;
	
	echo '<img src="'.$this->item->exts.'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="" />';
	
} else if (isset ($this->item->fileoriginalexist) && $this->item->fileoriginalexist == 1) {
	
	$imageRes			= PhocaGalleryImage::getRealImageSize($this->item->filename, 'small');
	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
	$imgLink			= PhocaGalleryFileThumbnail::getThumbnailName($this->item->filename, 'large');
	

	echo '<img src="'.JURI::root().$this->item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_('COM_PHOCAGALLERY_ENLARGE_IMAGE').'" />'
	.'</a>';
} else {
	
}
echo '</div>';
// - - - - - - - - - -			
?>			
		<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('title', 'alias', 'catid', 'ordering',
			'filename','latitude', 'longitude', 'zoom', 'geotitle', 'videocode', 'vmproductid');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
		
		<?php echo $this->form->getInput('extid');?>
		
		<div class="clr"></div>
		<div><?php echo JText::_('COM_PHOCAGALLERY_EXTERNAL_LINKS1');?></div>
		<ul class="adminformlist">
			<?php 
			$formArray = array ('extlink1link', 'extlink1title', 'extlink1target', 'extlink1icon');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
		
		<div class="clr"></div>
		<div><?php echo JText::_('COM_PHOCAGALLERY_EXTERNAL_LINKS2');?></div>
		<ul class="adminformlist">
			<?php 
			$formArray = array ('extlink2link', 'extlink2title', 'extlink2target', 'extlink2icon');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
		
			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>
		
		<div class="clr"></div>
		</fieldset>
	</div>

<div class="width-40 fltrt">
	<div style="text-align:right;margin:5px;"><?php echo $this->tmpl['enablethumbcreationstatus']; ?></div>
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

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>

	
