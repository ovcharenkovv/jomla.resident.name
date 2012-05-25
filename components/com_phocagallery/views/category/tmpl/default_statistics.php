<?php defined('_JEXEC') or die('Restricted access');

?><div id="phocagallery-statistics">
<?php
echo '<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>';//because of IE bug
	
	if ($this->tmpl['displaymaincatstat']) {
		echo '<fieldset>'
			.'<legend>'.JText::_('COM_PHOCAGALLERY_CATEGORY').'</legend>'
			.'<table>'
			.'<tr><td>'.JText::_('COM_PHOCAGALLERY_NR_PUBLISHED_IMG_CAT') .': </td>'
			.'<td>'.$this->tmpl['numberimgpub'].'</td></tr>'
			.'<tr><td>'.JText::_('COM_PHOCAGALLERY_NR_UNPUBLISHED_IMG_CAT') .': </td>'
			.'<td>'.$this->tmpl['numberimgunpub'].'</td></tr>'
			.'<tr><td>'.JText::_('COM_PHOCAGALLERY_CATEGORY_VIEWED') .': </td>'
			.'<td>'.$this->tmpl['categoryviewed'].' x</td></tr>'
			.'</table>'
			.'</fieldset>';
	}	

// MOST VIEWED			
if ($this->tmpl['displaymostviewedcatstat']) {
	
	echo '<fieldset><legend>'.JText::_('COM_PHOCAGALLERY_MOST_VIEWED_IMG_CAT').'</legend>';
		
	if (!empty($this->tmpl['mostviewedimg'])) {
		foreach($this->tmpl['mostviewedimg'] as $key => $value) {
			
			$extImage = PhocaGalleryImage::isExtImage($value->extid);
			if ($extImage) {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
				
			?>
			<div class="phocagallery-box-file pg-box-mv" style="height:<?php echo $this->tmpl['imageheight']['boxsize']; ?>px; width:<?php echo $this->tmpl['imagewidth']['boxsize']; ?>px">
				
					<div class="phocagallery-box-file-first" style="height:<?php echo $this->tmpl['imageheight']['size']; ?>px;width:<?php echo $this->tmpl['imagewidth']['size']; ?>px;margin:auto;">
						<div class="phocagallery-box-file-second">
							<div class="phocagallery-box-file-third">
								
								<a class="<?php echo $value->buttonother->methodname; ?>"<?php
								
								echo ' href="'. $value->link.'"';
								
								echo PhocaGalleryRenderFront::renderAAttributeStat($this->tmpl['detailwindow'], $value->button->options, '',$this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2'], '', $this->category->alias, 'mv');
								echo ' >';
								if ($extImage) {
									echo JHtml::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height'], 'class' => 'pg-image'));
								} else {
									echo JHtml::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('class' => 'pg-image'));
								}

								?></a>
								
							</div>
						</div>
					</div>
				
				
			<?php
			
			// subfolder
			if ($value->type == 1) {
				if ($value->displayname == 1 || $value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
			}
			// image
			if ($value->type == 2) {
				if ($value->displayname == 1) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
				if ($value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">&nbsp;</div>';
				}
			}

			echo '<div class="detail" style="margin-top:2px;text-align:left">';
					
			
			echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-viewed.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_IMAGE_DETAIL'));
			echo '&nbsp;&nbsp; '.$value->hits.' x';
		
			echo '</div>';
			echo '<div style="clear:both"></div>';
			
			echo '</div>';
		}
	}
		
	echo '</fieldset>';

} // END MOST VIEWED

// LAST ADDED	
if ($this->tmpl['displaylastaddedcatstat']) {		

	
	echo '<fieldset>'
		.'<legend>'.JText::_('COM_PHOCAGALLERY_LAST_ADDED_IMG_CAT').'</legend>';
		
	if (!empty($this->tmpl['lastaddedimg'])) {
		
		foreach($this->tmpl['lastaddedimg'] as $key => $value) {
			
			$extImage = PhocaGalleryImage::isExtImage($value->extid);
			if ($extImage) {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
				
			?>
			<div class="phocagallery-box-file pg-box-la" style="height:<?php echo $this->tmpl['imageheight']['boxsize']; ?>px; width:<?php echo $this->tmpl['imagewidth']['boxsize']; ?>px">
				
					<div class="phocagallery-box-file-first" style="height:<?php echo $this->tmpl['imageheight']['size']; ?>px;width:<?php echo $this->tmpl['imagewidth']['size']; ?>px;margin:auto;">
						<div class="phocagallery-box-file-second">
							<div class="phocagallery-box-file-third">
								
								<a class="<?php echo $value->buttonother->methodname; ?>"<?php
								
								echo ' href="'. $value->link.'"';
								
								echo PhocaGalleryRenderFront::renderAAttributeStat($this->tmpl['detailwindow'], $value->button->options, '', $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2'], '', $this->category->alias, 'la');
								
								echo ' >';
								if ($extImage) {
									echo JHtml::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height'], 'class' => 'pg-image'));
								} else {
									echo JHtml::_( 'image', $value->linkthumbnailpath, $value->altvalue, array('class' => 'pg-image') );
								}
								?></a>
								
							</div>
						</div>
					</div>
				
				
			<?php
			
			// subfolder
			if ($value->type == 1) {
				if ($value->displayname == 1 || $value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
			}
			// image
			if ($value->type == 2) {
				if ($value->displayname == 1) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
				if ($value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">&nbsp;</div>';
				}
			}

			echo '<div class="detail" style="margin-top:2px;text-align:left">';
					
			echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-date.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_IMAGE_DETAIL'));
			echo '&nbsp;&nbsp; '.JHtml::Date($value->date, "d. m. Y");
			
		
			echo '</div>';
			echo '<div style="clear:both"></div>';
			
			echo '</div>';
		}
	}

	echo '</fieldset>';

}// END MOST VIEWED	
?>
</div>
