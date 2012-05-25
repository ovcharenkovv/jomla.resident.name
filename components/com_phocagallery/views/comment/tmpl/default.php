<?php defined('_JEXEC') or die('Restricted access');
if ($this->tmpl['backbutton'] != '' && $this->tmpl['enable_multibox_iframe'] != 1) {
	echo $this->tmpl['backbutton'];
} 
echo '<div id="phocagallery-comments">';
if (($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) && $this->tmpl['enable_multibox_iframe'] != 1) {
	echo '<div id="image-box" style="text-align:center">'.$this->item->linkimage.'</div>';
}

if ($this->tmpl['externalcommentsystem'] == 1) {
	if (JComponentHelper::isEnabled('com_jcomments', true)) {
		include_once(JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
		echo JComments::showComments($this->item->id, 'com_phocagallery_images', JText::_('COM_PHOCAGALLERY_IMAGE') .' '. $this->item->title);
	}
} else if($this->tmpl['externalcommentsystem'] == 2) {
	
	$uri 		= &JFactory::getURI();
	$getParamsArray = explode(',', 'start,limitstart,template,fb_comment_id,tmpl');
	if (!empty($getParamsArray) ) {
		foreach($getParamsArray as $key => $value) {
			$uri->delVar($value);
		}
	}
	
	echo '<div style="margin:10px">';
	if ($this->tmpl['fb_comment_app_id'] == '') {
		echo JText::_('COM_PHOCAGALLERY_ERROR_FB_APP_ID_EMPTY');
	} else {
	
		$cCount = '';
		if ((int)$this->tmpl['fb_comment_count'] > 0) {
			$cCount = 'numposts="'.$this->tmpl['fb_comment_count'].'"';
		}

?><fb:comments href="<?php echo $uri->toString(); ?>" simple="1" <?php echo $cCount;?> width="<?php echo (int)$this->tmpl['fb_comment_width'] ?>"></fb:comments>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
   FB.init({
     appId: '<?php echo $this->tmpl['fb_comment_app_id'] ?>',
     status: true,
	 cookie: true,
     xfbml: true
   });
 }; 
  (function() {
    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.src = document.location.protocol + '//connect.facebook.net/<?php echo $this->tmpl['fb_comment_lang']; ?>/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
   }());
</script>
<?php 
	echo '</div>';
	} 

} else {

	if (!empty($this->commentitem)){
		$userImage	= JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-user.'.$this->tmpl['formaticon'], '');
		$smileys = PhocaGalleryComment::getSmileys();
			
		foreach ($this->commentitem as $itemValue) {
			$date		= JHtml::_('date',  $itemValue->date, JText::_('DATE_FORMAT_LC2') );
			$comment	= $itemValue->comment;
			$comment 	= PhocaGalleryComment::bbCodeReplace($comment);
			foreach ($smileys as $smileyKey => $smileyValue) {
				$comment = str_replace($smileyKey, JHtml::_( 'image', 'components/com_phocagallery/assets/images/'.$smileyValue .'.'.$this->tmpl['formaticon'],''), $comment);
			}
			
			echo '<fieldset>'
				.'<legend>'.$userImage.'&nbsp;'.$itemValue->name.'</legend>'
				.'<p><strong>'.PhocaGalleryText::wordDelete($itemValue->title, 50, '...').'</strong></p>'
				.'<p style="overflow:auto;width:'.$this->tmpl['commentwidth'].'px;">'.$comment.'</p>'
				.'<p style="text-align:right"><small>'.$date.'</small></p>'
				.'</fieldset>';
		}
	}
	
	echo '<fieldset>'.'<legend>'.JText::_('COM_PHOCAGALLERY_ADD_COMMENT').'</legend>';

	if ($this->tmpl['alreadycommented']) {
		echo '<p>'.JText::_('COM_PHOCAGALLERY_COMMENT_ALREADY_SUBMITTED').'</p>';
	} else if ($this->tmpl['notregistered']) {
		echo '<p>'.JText::_('COM_PHOCAGALLERY_COMMENT_ONLY_REGISTERED_LOGGED_SUBMIT_COMMENT').'</p>';
	} else {
		echo '<form action="'.$this->tmpl['action'].'" name="phocagallerycommentsform" id="phocagallery-comments-form" method="post" >'	
			.'<table>'
			.'<tr>'
			.'<td>'.JText::_('COM_PHOCAGALLERY_NAME').':</td>'
			.'<td>'.$this->tmpl['name'].'</td>'
			.'</tr>';
			
		echo '<tr>'
			.'<td>'.JText::_('COM_PHOCAGALLERY_TITLE').':</td>'
			.'<td><input type="text" name="phocagallerycommentstitle" id="phocagallery-comments-title" value="" maxlength="255" class="comment-input" /></td>'
			.'</tr>';
			
		echo '<tr>'
			.'<td>&nbsp;</td>'
			.'<td>'
			.'<a href="#" onclick="pasteTag(\'b\', true); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-b.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_BOLD'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteTag(\'i\', true); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-i.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_ITALIC'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteTag(\'u\', true); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-u.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_UNDERLINE'))
			.'</a>&nbsp;&nbsp;'
				
			.'<a href="#" onclick="pasteSmiley(\':)\'); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-smile.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_SMILE'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':lol:\'); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-lol.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_LOL'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':(\'); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-sad.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_SAD'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':?\'); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-confused.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_CONFUSED'))
			.'</a>&nbsp;'
			
			.'<a href="#" onclick="pasteSmiley(\':wink:\'); return false;">'
			. JHtml::_('image', 'components/com_phocagallery/assets/images/icon-s-wink.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_WINK'))
			.'</a>&nbsp;'
			.'</td>'
			.'</tr>';
			
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td>'
				.'<textarea name="phocagallerycommentseditor" id="phocagallery-comments-editor" cols="30" rows="10"  class= "comment-input" onkeyup="countChars();" ></textarea>'
				.'</td>'
				.'</tr>';
			
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td>'
				. JText::_('COM_PHOCAGALLERY_CHARACTERS_WRITTEN').' <input name="phocagallerycommentscountin" value="0" readonly="readonly" class="comment-input2" /> '
				. JText::_('COM_PHOCAGALLERY_AND_LEFT_FOR_COMMENT').' <input name="phocagallerycommentscountleft" value="'. $this->tmpl['maxcommentchar'].'" readonly="readonly" class="comment-input2" />'
				.'</td>'
				.'</tr>';
				
			echo '<tr>'
				.'<td>&nbsp;</td>'
				.'<td align="right">'
				.'<input type="submit" id="phocagallerycommentssubmit" onclick="return(checkCommentsForm());" value="'. JText::_('COM_PHOCAGALLERY_SUBMIT_COMMENT').'"/>'
				.'</td>'
				.'</tr>';
			
			echo '</table>';

			echo '<input type="hidden" name="task" value="comment" />';
			echo '<input type="hidden" name="view" value="comment" />';
			echo '<input type="hidden" name="controller" value="comment" />';
			echo '<input type="hidden" name="id" value="'. $this->tmpl['id'].'" />';
			echo '<input type="hidden" name="catid" value="'. $this->tmpl['catid'].'" />';
			echo '<input type="hidden" name="Itemid" value="'. JRequest::getVar('Itemid', 0, '', 'int') .'" />';
			echo JHtml::_( 'form.token' );
			echo '</form>';
		}
	echo '</fieldset>';
}
echo '</div>';
if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) {
	PhocaGalleryUtils::footer();
}
?>