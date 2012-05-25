<?php 
defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery-javaupload">';
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';

echo '<form action="'. JURI::base().'index.php?option=com_phocagallery" >';
//if ($this->tmpl['ftp']) {echo PhocaGalleryFileUpload::renderFTPaccess();}
echo '<fieldset class="actions">'
	.' <legend>'; 
echo JText::_( 'Upload File' ).' [ '. JText::_( 'COM_PHOCAGALLERY_MAX_SIZE' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('COM_PHOCAGALLERY_MAX_RESOLUTION').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
echo ' </legend>';
echo $this->tmpl['ju_output']
	.'</fieldset>';
echo '</form>';
echo '</div>';