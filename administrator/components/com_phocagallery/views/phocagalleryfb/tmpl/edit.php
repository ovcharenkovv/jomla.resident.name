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
		if (task == 'phocagalleryfb.cancel' || document.formvalidator.isValid(document.id('phocagalleryfb-form'))) {
			Joomla.submitform(task, document.getElementById('phocagalleryfb-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php JRoute::_('index.php?option=com_phocagallery'); ?>" method="post" name="adminForm" id="phocagalleryfb-form" class="form-validate">
	<div class="width-60 fltlft">
		
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PHOCAGALLERY_FB_APPLICATION') ?></legend>
			
		<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('appid', 'appsid', 'ordering');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
		
		<div class="clr"></div>
		<div><?php echo JText::_('COM_PHOCAGALLERY_FB_INSTR1') ?></div>
		<div style="text-align:right"><a style="text-decoration:underline;font-weight:bold;" href="http://developers.facebook.com/setup/" target="_blank" ><?php echo JText::_('COM_PHOCAGALLERY_FB_CREATE_APP') ;?></a></div>
		<div class="clr"></div>
		</fieldset>
		
		<?php 
		if (isset($this->item->appid) && $this->item->appid != ''
			&& isset($this->item->appsid) && $this->item->appsid != '') { ?>
			
			<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PHOCAGALLERY_FB_USER_SETTINGS') ?></legend>
			
			<?php
			$status	= PhocaGalleryFb::getFbStatus($this->item->appid, $this->item->appsid);
			
			echo $status['html'];
			
			if ($status['session']['uid'] != ''
			/*&& $status['session']['base_domain'] != ''*/
			&& $status['session']['secret'] != ''
			&& $status['session']['session_key'] != ''
			&& $status['session']['access_token'] != ''
			&& $status['session']['sig'] != ''
			&& $status['u']['name'] != '') {
				/*$this->form->setValue('uid', '', $status['session']['uid']);
				$this->form->setValue('base_domain', '', $status['session']['base_domain']);
				$this->form->setValue('secret', '', $status['session']['secret']);
				$this->form->setValue('session_key', '', $status['session']['session_key']);
				$this->form->setValue('access_token', '', $status['session']['access_token']);
				$this->form->setValue('sig', '', $status['session']['sig']);
				if ($status['u']['name'] != '') {
					$this->form->setValue('name', '', $status['u']['name']);
				}
				*/
				
				$div[]	= array();
				$script = array();
				$fields = array( 'uid', 'base_domain', 'secret', 'session_key', 'access_token', 'sig');
				
				$script[] = 'function pasteFbFields() {';
				foreach ($fields as $field) {
					if (!isset($status['session'][$field])) {
						$status['session'][$field] = '';
					}
				
					$script[] = ' document.getElementById(\'jform_'.$field.'\').value = document.getElementById(\'div_'.$field.'\').value;';
					$div[]	  = '<input type="hidden" id="div_'.$field.'" value="'.$status['session'][$field].'" />';
					
				}
				$script[] 	= ' document.getElementById(\'jform_name\').value = document.getElementById(\'div_name\').value;';
				$div[]		= '<input type="hidden" id="div_name" value="'.$status['u']['name'].'" />';
				$script[] = '}';
				
				echo '<div style="display:none">';
				$n = "\n";
				echo implode($n, $div);
				echo '</div>';

				// Add the script to the document head.
				JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
				
				echo '<div style="float:right;"><a href="javascript:void(0)" onclick="pasteFbFields()"><div class="pg-button">'.JText::_('COM_PHOCAGALLERY_FB_PASTE_LOADED_DATA').'</div></a></div>';
			}
			
			?>
		
			<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('name', 'uid', 'base_domain', 'secret', 'session_key', 'access_token', 'sig', 'fanpageid');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
			
			</ul>
			<input name="jform[expires]" id="jform_expires" value="0" readonly="readonly" type="hidden" />
		
		
			<div class="clr"></div>
			</fieldset>
		
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_PHOCAGALLERY_FB_COMMENTS_SETTINGS') ?></legend>
			<?php
			// Comments
			$fieldSets = $this->form->getFieldsets('comments');
			foreach ($fieldSets as $name => $fieldSet) {
				echo '<ul class="adminformlist">';
				foreach ($this->form->getFieldset($name) as $field) {
					echo '<li>'. $field->label .' '. $field->input .'</li>';
				}
				echo '</ul>';
				
			}
			echo '</fieldset>';
		}
		?>
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
	<?php echo JHtml::_('sliders.end'); ?>
</div>

<div class="clr"></div>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>

	
