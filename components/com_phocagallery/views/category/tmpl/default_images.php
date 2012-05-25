<?php defined('_JEXEC') or die('Restricted access');
// - - - - - - - - - - 
// Images
// - - - - - - - - - -

if (!empty($this->items)) {
	foreach($this->items as $key => $value) {
	
		if ($this->checkRights == 1) {
			// USER RIGHT - Access of categories (if file is included in some not accessed category) - - - - -
			// ACCESS is handled in SQL query, ACCESS USER ID is handled here (specific users)
			$rightDisplay	= 0;
			if (isset($value->catid) && isset($value->cataccessuserid) && isset($value->cataccess)) {
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $value->cataccessuserid, $value->cataccess, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
			}
			// - - - - - - - - - - - - - - - - - - - - - -
		} else {
			$rightDisplay = 1;
		}
		
		// Display back button to categories list
		if ($value->item_type == 'categorieslist'){
			$rightDisplay = 1;
		}
		
		if ($rightDisplay == 1) {
		
			// BOX Start
			echo "\n\n";
			echo '<div class="phocagallery-box-file '.$value->cls.'" style="height:'. $this->tmpl['imageheight']['boxsize'].'px; width:'.$this->tmpl['imagewidth']['boxsize'].'px;">'. "\n";
			echo '<div class="phocagallery-box-file-first" style="height:'.$this->tmpl['imageheight']['size'].'px;width:'.$this->tmpl['imagewidth']['size'].'px;margin:auto;">'. "\n";
			echo '<div class="phocagallery-box-file-second">'. "\n";
			echo '<div class="phocagallery-box-file-third">'. "\n";
			
			// A Start
			echo '<a class="'.$value->button->methodname.'"';
			
			if ($value->type == 2) {
				if ($value->overlib == 0) {
					echo ' title="'.$value->odesctitletag.'"';
				}
			}
			echo ' href="'. $value->link.'"';
								
			// Correct size for external Image (Picasa) - subcategory
			$extImage = false;
			if (isset($value->extid)) {
				$extImage = PhocaGalleryImage::isExtImage($value->extid);
			}
			if ($extImage && isset($value->extw) && isset($value->exth)) {
				$correctImageRes = PhocaGalleryPicasa::correctSizeWithRate($value->extw, $value->exth, $this->tmpl['picasa_correct_width_m'], $this->tmpl['picasa_correct_height_m']);
			}
				
			// Image Box (image, category, folder)
			if ($value->type == 2 ) {
				
				// Render OnClick, Rel
				echo PhocaGalleryRenderFront::renderAAttribute($this->tmpl['detailwindow'], $value->button->options, $value->linkorig, $this->tmpl['highslideonclick'], '', $value->linknr, $value->catalias);
				
				// SWITCH OR OVERLIB 
				if ($this->tmpl['switchimage'] == 1) {
					echo PhocaGalleryRenderFront::renderASwitch($this->tmpl['switchwidth'], $this->tmpl['switchheight'], $this->tmpl['switchfixedsize'], $value->extwswitch, $value->exthswitch, $value->extl, $value->linkthumbnailpath);
				} else {
					echo $value->overlib_value;					
				}
				echo ' >';// A End

				// IMG Start
				if ($extImage) {
					echo JHtml::_( 'image', $value->extm, $value->altvalue, array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height'], 'class' => 'pg-image'));
				} else {
					echo JHtml::_( 'image', $value->linkthumbnailpath, $value->oimgalt, array('class' => $value->ooverlibclass ));
				}
				
				if ($value->type == 2 && $value->enable_cooliris == 1) {
					if ($extImage) {
						echo '<span class="mbf-item">#phocagallerypiclens '.$value->catid.'-phocagallerypiclenscode-'.$value->extid.'</span>';
					} else {
						echo '<span class="mbf-item">#phocagallerypiclens '.$value->catid.'-phocagallerypiclenscode-'.$value->filename.'</span>';
					}
				}
				// IMG End
			
			} else if ($value->type == 1) {
				// Other than image
				// A End
				echo ' >';
				// IMG Start
				if ($extImage && isset($value->extm) && isset($correctImageRes['width']) && isset($correctImageRes['width'])) {
					
					echo JHtml::_( 'image', $value->extm, '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height'], 'class' => PhocaGalleryRenderFront::renderImageClass($value->extm)));
				} else {
					echo JHtml::_( 'image', $value->linkthumbnailpath, '', array( 'class' => PhocaGalleryRenderFront::renderImageClass($value->linkthumbnailpath)) );
				}
				// IMG END
				
			} else {
				// Other than image
				// A End
				echo ' >';
				// IMG Start
				if ($extImage && isset($value->extm) && isset($correctImageRes['width']) && isset($correctImageRes['width'])) {
					echo JHtml::_( 'image', $value->extm, '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']));
				} else {
					echo JHtml::_( 'image', $value->linkthumbnailpath, '');
				}
				// IMG END
				
			} // if type 2 else type 0, 1 (image, category, folder)
			
			// A CLOSE
			echo '</a>';
			
			// Highslide Caption, Description
			if ( $this->tmpl['detailwindow'] == 5) {
				if ($this->tmpl['displaytitleindescription'] == 1) {
					echo '<div class="highslide-heading">';
					echo $value->title;
					echo '</div>';
				}
				if ($this->tmpl['displaydescriptiondetail'] == 1) {
					echo '<div class="highslide-caption">';
					echo $value->description;
					echo '</div>';
				}
			}
			
			// Hot, New
			if ($value->type == 2) {
				echo PhocaGalleryRenderFront::getOverImageIcons($value->date, $value->hits);
				
			}
			echo "\n".'</div></div></div>'. "\n";
			// BOX End
				
				
			// Subfolder Name
			if ($value->type == 1) {
				if ($value->displayname == 1 || $value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
			}
			// Image Name
			if ($value->type == 2) {
				if ($value->displayname == 1) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">'
					.PhocaGalleryText::wordDelete($value->title, $this->tmpl['charlengthname'], '...').'</div>';
				}
				if ($value->displayname == 2) {
					echo '<div class="pg-name" style="font-size:'.$this->tmpl['fontsizename'].'px">&nbsp;</div>';
				}
			}
			
			// Rate Image
			if($value->item_type == 'image' && $this->tmpl['displayratingimg'] == 1) {
				echo '<div><a class="'.$value->buttonother->methodname.'" title="'.JText::_('COM_PHOCAGALLERY_RATE_IMAGE').'"'
					.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$value->catslug.'&id='.$value->slug.$this->tmpl['tmplcom'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					
				echo PhocaGalleryRenderFront::renderAAttributeOther($this->tmpl['detailwindow'], $value->buttonother->optionsrating, $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2']);
				
				echo ' >';
						
				echo '<div><ul class="star-rating-small">'
				.'<li class="current-rating" style="width:'.$value->voteswidthimg.'px"></li>'
				.'<li><span class="star1"></span></li>';
				for ($iV = 2;$iV < 6;$iV++) {
					echo '<li><span class="stars'.$iV.'"></span></li>';
				}
				echo '</ul></div>'."\n";
				echo '</a></div>'."\n";
			}

			if ($value->displayicondetail == 1 ||
			$value->displayicondownload > 0 || 
			$value->displayiconfolder == 1 || 
			$value->displayiconvm || 
			$value->startpiclens == 1 || 
			$value->trash == 1 || 
			$value->publishunpublish == 1 || 
			$value->displayicongeo == 1 || 
			$value->camerainfo == 1 || 
			$value->displayiconextlink1	== 1 || 
			$value->displayiconextlink2	== 1 || 
			$value->camerainfo == 1 ) {
				
				echo '<div class="detail" style="margin-top:2px">';
				
				if ($value->startpiclens == 1) {							
					echo '<a href="javascript:PicLensLite.start({feedUrl:\''.JURI::base(true) . '/images/phocagallery/'
			. $value->catid .'.rss'.'\'});" title="Cooliris" >';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-cooliris.'.$this->tmpl['formaticon'], 'Cooliris');
					echo '</a>';
				}
				
				// ICON DETAIL	
				if ($value->displayicondetail == 1) {				
				
			
					echo ' <a class="'.$value->button2->methodname.'" title="'. $value->oimgtitledetail.'"'
						.' href="'.$value->link2.'"';
						
					echo PhocaGalleryRenderFront::renderAAttributeTitle($this->tmpl['detailwindow'], $value->button2->options, '', $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2'], $value->linknr, $value->catalias);
						
					echo ' >';
						
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-view.'.$this->tmpl['formaticon'], $value->oimgaltdetail);
					echo '</a>';
				}
				
				// ICON FOLDER
				if ($value->displayiconfolder == 1) {
					echo ' <a title="'.JText::_('COM_PHOCAGALLERY_SUBCATEGORY').'"'.' href="'.$value->link.'">';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-folder-small.'.$this->tmpl['formaticon'], $value->title);	
					echo '</a>';
				}
				
				// ICON DOWNLOAD
				if ($value->displayicondownload > 0) {
					// Direct Download but not if there is a youtube
					if ($value->displayicondownload == 2 && $value->videocode == '') {
						echo ' <a title="'. JText::_('COM_PHOCAGALLERY_IMAGE_DOWNLOAD').'"'
							.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$value->catslug.'&id='.$value->slug. $this->tmpl['tmplcom'].'&phocadownload='.$value->displayicondownload.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					} else { 
						echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('COM_PHOCAGALLERY_IMAGE_DOWNLOAD').'"'
							.' href="'.JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$value->catslug.'&id='.$value->slug. $this->tmpl['tmplcom'].'&phocadownload='.(int)$value->displayicondownload.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
							
						echo PhocaGalleryRenderFront::renderAAttributeOther($this->tmpl['detailwindow'], $value->buttonother->options, $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2']);
					}
					echo ' >';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-download.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_IMAGE_DOWNLOAD'));
					echo '</a>';
				}
				
				// ICON GEO
				if ($value->displayicongeo == 1) {
					echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('COM_PHOCAGALLERY_GEOTAGGING').'"'
						.' href="'. JRoute::_('index.php?option=com_phocagallery&view=map&catid='.$value->catslug.'&id='.$value->slug.$this->tmpl['tmplcom'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
						
					echo PhocaGalleryRenderFront::renderAAttributeOther($this->tmpl['detailwindow'], $value->buttonother->options, $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2']);
			
					echo ' >';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-geo.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_GEOTAGGING'));
					echo '</a>';
				}
				
				// ICON EXIF
				if ($value->camerainfo == 1) {
					echo ' <a class="'.$value->buttonother->methodname.'" title="'.JText::_('COM_PHOCAGALLERY_CAMERA_INFO').'"'
						.' href="'.JRoute::_('index.php?option=com_phocagallery&view=info&catid='.$value->catslug.'&id='.$value->slug.$this->tmpl['tmplcom'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
						
					echo PhocaGalleryRenderFront::renderAAttributeOther($this->tmpl['detailwindow'], $value->buttonother->options, $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2']);
						
					echo ' >';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-info.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_CAMERA_INFO'));
					echo '</a>';
				}
				
				// ICON COMMENT
				if ($value->displayiconcommentimg == 1) {
					if ($this->tmpl['detailwindow'] == 7 || $this->tmpl['display_comment_nopup'] == 1) {
						$tmplClass	= '';
					} else {
						$tmplClass 	= 'class="'.$value->buttonother->methodname.'"';
					}
					echo ' <a '.$tmplClass.' title="'.JText::_('COM_PHOCAGALLERY_COMMENT_IMAGE').'"'
						.' href="'. JRoute::_('index.php?option=com_phocagallery&view=comment&catid='.$value->catslug.'&id='.$value->slug.$this->tmpl['tmplcomcomments'].'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).'"';
					
					if ($this->tmpl['display_comment_nopup'] == 1) {
						echo '';
					} else {
						echo PhocaGalleryRenderFront::renderAAttributeOther($this->tmpl['detailwindow'], $value->buttonother->options, $this->tmpl['highslideonclick'], $this->tmpl['highslideonclick2']);
					}
					echo ' >';
					// If you go from RSS or administration (e.g. jcomments) to category view, you will see already commented image (animated icon)
					$cimgid = JRequest::getVar( 'cimgid', 0, '', 'int');
					if($cimgid > 0) {
						echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-comment-a.gif', JText::_('COM_PHOCAGALLERY_COMMENT_IMAGE'));
					} else {
						$commentImg = ($this->tmpl['externalcommentsystem'] == 2) ? 'icon-comment-fb-small' : 'icon-comment';
						echo JHtml::_('image', 'components/com_phocagallery/assets/images/'.$commentImg.'.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_COMMENT_IMAGE'));
					}
					echo '</a>';	
				}
				
				// ICON EXTERNAL LINK 1
				if ($value->displayiconextlink1 == 1) {
					echo ' <a title="'.$value->extlink1[1] .'"'
						.' href="http://'.$value->extlink1[0] .'" target="'.$value->extlink1[2] .'" '.$value->extlink1[5].'>'
						.$value->extlink1[4].'</a>';
				}
				
				// ICON EXTERNAL LINK 2
				if ($value->displayiconextlink2 == 1) {
					echo ' <a title="'.$value->extlink2[1] .'"'
						.' href="http://'.$value->extlink2[0] .'" target="'.$value->extlink2[2] .'" '.$value->extlink2[5].'>'
						.$value->extlink2[4].'</a>';
					
				}
				
				// ICON VIRTUEMART PRODUCT
				if ($value->displayiconvm == 1) {
					echo ' <a title="'.JText::_('COM_PHOCAGALLERY_ESHOP').'" href="'. JRoute::_($value->vmlink).'">';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-cart.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_ESHOP'));
					echo '</a>';
				}
				
				// ICON Trash for private categories
				if ($value->trash == 1) {
					echo ' <a onclick="return confirm(\''.JText::_('COM_PHOCAGALLERY_WARNING_DELETE_ITEMS').'\')" title="'.JText::_('COM_PHOCAGALLERY_DELETE').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$value->catslug.'&id='.$value->slug.'&controller=category&task=remove'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
					echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-trash.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_DELETE'));
					echo '</a>';
				}
				
				// ICON Publish Unpublish for private categories
				if ($value->publishunpublish == 1) {
					if ($value->published == 1) {
						echo ' <a title="'.JText::_('COM_PHOCAGALLERY_UNPUBLISH').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$value->catslug.'&id='.$value->slug.'&&controller=category&task=unpublish'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
						echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-publish.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_UNPUBLISH'));
						echo '</a>';
					}
					if ($value->published == 0) {
						echo ' <a title="'.JText::_('COM_PHOCAGALLERY_PUBLISH').'" href="'. JRoute::_('index.php?option=com_phocagallery&view=category&catid='.$value->catslug.'&id='.$value->slug.'&controller=category&task=publish'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ).$this->tmpl['limitstarturl'].'">';
						echo JHtml::_('image', 'components/com_phocagallery/assets/images/icon-unpublish.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_PUBLISH'));
						echo '</a>';
					
					}
				}
			
				// ICON APPROVE
				if ($value->approvednotapproved == 1) {
					// Display the information about Approving too:
					if ($value->approved == 1) {
						echo ' <a href="#" title="'.JText::_('COM_PHOCAGALLERY_IMAGE_APPROVED').'">'.JHtml::_('image', 'components/com_phocagallery/assets/images/icon-publish.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_APPROVED')).'</a>';
					}
					if ($value->approved == 0) {
						echo ' <a href="#" title="'.JText::_('COM_PHOCAGALLERY_IMAGE_NOT_APPROVED').'">'.JHtml::_('image', 'components/com_phocagallery/assets/images/icon-unpublish.'.$this->tmpl['formaticon'], JText::_('COM_PHOCAGALLERY_NOT_APPROVED')).'</a>';
					
					}
				}
			
				echo '</div>'. "\n";
				echo '<div style="clear:both"></div>'. "\n";
			}
			
			// Tags
			if ($value->type == 2 && isset($value->otags) && $value->otags != '') {
				echo '<div class="pg-cat-tags">'.$value->otags.'</div>';
			}
			
			// DESCRIPTION BELOW THUMBNAILS
			if ($this->tmpl['displayimgdescbox'] == 1  && $value->description != '') {
				echo '<div class="phocaimgdesc" style="font-size:'.$this->tmpl['fontsizeimgdesc'].'px">'. strip_tags(PhocaGalleryText::wordDelete($value->description, $this->tmpl['charlengthimgdesc'], '...')).'</div>';
			} else if ($this->tmpl['displayimgdescbox'] == 2  && $value->description != '') {	
				echo '<div class="phocaimgdeschtml">' .(JHtml::_('content.prepare', $value->description, 'com_phocagallery.item')).'</div>';
			}
			
			echo '</div>';

		}
	}

} else {
	// Will be not displayed
	//echo JText::_('COM_PHOCAGALLERY_THERE_IS_NO_IMAGE');
}