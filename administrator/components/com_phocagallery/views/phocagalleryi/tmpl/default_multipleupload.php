<?php 
defined('_JEXEC') or die('Restricted access');
echo '<div id="phocagallery-multipleupload">';
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';
echo $this->tmpl['mu_response_msg'] ;
echo '<form action="'. JURI::base().'index.php?option=com_phocagallery" >';
if ($this->tmpl['ftp']) {echo PhocaGalleryFileUpload::renderFTPaccess();}
echo '<fieldset class="actions">'
	.' <legend>'; 
echo JText::_( 'COM_PHOCAGALLERY_UPLOAD_FILE' ).' [ '. JText::_( 'COM_PHOCAGALLERY_MAX_SIZE' ).':&nbsp;'.$this->tmpl['uploadmaxsizeread'].','
	.' '.JText::_('COM_PHOCAGALLERY_MAX_RESOLUTION').':&nbsp;'. $this->tmpl['uploadmaxreswidth'].' x '.$this->tmpl['uploadmaxresheight'].' px ]';
echo ' </legend>';
echo $this->tmpl['mu_output']
	.'</fieldset>';
echo '</form>';
echo PhocaGalleryFileUpload::renderCreateFolder($this->session->getName(), $this->session->getId(), $this->currentFolder, 'phocagalleryi', 'tab='.$this->tmpl['currenttab']['multipleupload'] .'&amp;field='.$this->field);
echo '</div>';
?>