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
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

// phocagallerym-form renamed to adminForm because of used Joomla! javascript and its fixed value.
?>


<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		
		if (task == 'phocagallerym.cancel') {
			submitform(task);
		}

		if (task == 'phocagallerym.save') {
			phocagallerymform = document.getElementById('adminForm');
			
			if (phocagallerymform.boxchecked.value==0) {
				alert( "<?php echo JText::_( 'COM_PHOCAGALLERY_WARNING_SELECT_FILENAME_OR_FOLDER', true ); ?>" );
			} else  {
				var f = phocagallerymform;
				var nSelectedImages = 0;
				var nSelectedFolders = 0;
				var i=0;
				cb = eval( 'f.cb' + i );
				while (cb) {
					if (cb.checked == false) {
						// Do nothing
					}
					else if (cb.name == "cid[]") {
						nSelectedImages++;
					}
					else {
						nSelectedFolders++;
					}
					// Get next
					i++;
					cb = eval( 'f.cb' + i );
				}
				
				if (phocagallerymform.jform_catid.value == "" && nSelectedImages > 0){
					alert( "<?php echo JText::_( 'COM_PHOCAGALLERY_WARNING_IMG_SELECTED_SELECT_CATEGORY', true ); ?>" );
				} else {
					submitform(task);
				}
			}
		}
		//submitform(task);
	}
</script>

<div style="text-align:right;margin:5px;"><?php echo $this->tmpl['enablethumbcreationstatus']; ?></div>
<div class="clr"></div>

<form action="<?php JRoute::_('index.php?option=com_phocagallery'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="width-100 fltlft">
		
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PHOCAGALLERY_MULTIPLE_ADD'); ?></legend>
			
		
		<ul class="adminformlist">
			<?php
			// Extid is hidden - only for info if this is an external image (the filename field will be not required)
			$formArray = array ('title', 'alias','published', 'approved', 'ordering', 'catid', 'language');
			foreach ($formArray as $value) {
				echo '<li>'.$this->form->getLabel($value) . $this->form->getInput($value).'</li>' . "\n";
			} ?>
		</ul>
		<div class="clr"></div>
		
		<div id="editcell">
			<table  class="adminlist">
			<thead>
				<tr>
					<th width="5">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->images)+count($this->folders); ?>);" /></th>
					<th width="20">&nbsp;</th>
					<th width="95%"><?php echo JText::_( 'COM_PHOCAGALLERY_FILENAME' ); ?></th>
				</tr>
			</thead>
			<tbody><?php
	
$link = 'index.php?option=com_phocagallery&amp;view=phocagallerym&amp;layout=edit&amp;hidemainmenu=1&amp;folder='.$this->folderstate->parent;
echo '<tr><td>&nbsp;</td>'
.'<td>'
.'<a href="'.$link.'" >'
. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-16-up.png', '').'</a>'
.'</td>'
.'<td><a href="'.$link.'" >..</a></td>'
.'</tr>';
			
if (count($this->images) > 0 || count($this->folders) > 0) {
	//FOLDERS
	for ($i = 0, $n = count($this->folders); $i<$n; $i++) {
		$checked 	= JHtml::_( 'grid.id', $i, $this->folders[$i]->path_with_name_relative_no, false, 'foldercid' );
		//$checked 	= PhocaGalleryGrid::id( $i, $this->folders[$i]->path_with_name_relative_no, false, 'foldercid' );
		$link		= 'index.php?option=com_phocagallery&view=phocagallerym&layout=edit&hidemainmenu=1&folder='
					  .$this->folders[$i]->path_with_name_relative_no;
		echo '<tr>'
			.' <td>'. $checked .'</td>'
			.' <td><a href="'. JRoute::_( $link ).'">'
			. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-folder-small.gif', '').'</a></td>'
			.' <td><a href="'. JRoute::_( $link ).'">'. $this->folders[$i]->name.'</a></td>'
			.'</tr>';
	}
				
	//IMAGES
	for ($i = 0,$n = count($this->images); $i<$n; $i++) {
		$row 		= &$this->images[$i];
		$checked 	= JHtml::_( 'grid.id', $i+count($this->folders), $this->images[$i]->nameno);
		//$checked	= '<input type="checkbox" name="cid[]" value="'.$i.'" />';
		echo '<tr>'
			.' <td>'. $checked .'</td>'
			.' <td><a href="'. JRoute::_( $link ).'">'
			. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-image-small.gif', '').'</a></td>'
			.' <td>'.$this->images[$i]->nameno.'</td>'
			.'</tr>';
	}
} else { 
	echo '<tr>'
	.'<td>&nbsp;</td>'
	.'<td>&nbsp;</td>'
	.'<td>'.JText::_( 'COM_PHOCAGALLERY_THERE_IS_NO_IMAGE' ).'</td>'
	.'</tr>';			

} ?>
		</tbody>
		</table>
	</div>
	</fieldset>
</div>
<div class="clr"></div>
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="layout" value="edit" />
<?php echo JHtml::_('form.token'); ?>
</form>

<div style="clear:both"></div>


<div class="width-100 fltlft">
<?php

if ($this->tmpl['displaytabs'] > 0) {
	echo '<div id="phocagallery-pane">';
	$pane =& JPane::getInstance('Tabs', array('startOffset'=> $this->tmpl['tab']));
	echo $pane->startPane( 'pane' );

	echo $pane->startPanel( JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-16-upload.png','') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_UPLOAD'), 'upload' );
	echo $this->loadTemplate('upload');
	echo $pane->endPanel();
	
	if((int)$this->tmpl['enablemultiple']  >= 0) {
		echo $pane->startPanel( JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-16-upload-multiple.png','') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_MULTIPLE_UPLOAD'), 'multipleupload' );
		echo $this->loadTemplate('multipleupload');
		echo $pane->endPanel();
	}

	if($this->tmpl['enablejava'] >= 0) {
		echo $pane->startPanel( JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-16-upload-java.png','') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_JAVA_UPLOAD'), 'javaupload' );
		echo $this->loadTemplate('javaupload');
		echo $pane->endPanel();
	}

	echo $pane->endPane();
	echo '</div>';// end phocagallery-pane
}
?>
</div>

