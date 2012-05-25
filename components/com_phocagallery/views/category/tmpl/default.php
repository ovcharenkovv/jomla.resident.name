<?php
defined('_JEXEC') or die('Restricted access'); 

// Phoca Gallery Width
if ($this->tmpl['phocagallerywidth'] != '') {
	$centerPage = '';
	if ($this->tmpl['phocagallerycenter'] == 1 || $this->tmpl['phocagallerycenter'] == 3) {
		$centerPage = 'margin: auto;';
	}
	echo '<div id="phocagallery" style="width:'. $this->tmpl['phocagallerywidth'].'px;'.$centerPage.'" class="pg-category-view'.$this->params->get( 'pageclass_sfx' ).'">'. "\n";
} else {
	echo '<div id="phocagallery" class="pg-category-view'.$this->params->get( 'pageclass_sfx' ).'">'. "\n";
}

// Heading
$heading = '';
if ($this->params->get( 'page_heading' ) != '') {
	$heading .= $this->params->get( 'page_heading' );
}
// Category Name Title
if ( $this->tmpl['displaycatnametitle'] == 1) {
	if (isset($this->category->title) && $this->category->title != '') {
		if ($heading != '') {
			$heading .= ' - ';
		}
		$heading .= $this->category->title;
	}
}
// Pagetitle
if ($this->tmpl['showpageheading'] != 0) {
	if ( $heading != '') {
		echo '<h1>'. $this->escape($heading) . '</h1>';
	} 
}
// Category Description
if (isset($this->category->description) && $this->category->description != '' ) {
	echo '<div class="pg-category-view-desc'.$this->params->get( 'pageclass_sfx' ).'">';
	echo $this->category->description.'</div>'. "\n";
}
if (isset($this->category->id) && (int)$this->category->id > 0) {
	echo '<div id="pg-icons">';
	echo PhocaGalleryRenderFront::renderFeedIcon('category', 1, $this->category->id, $this->category->alias);
	echo '</div>';
}
echo '<div style="clear:both"></div>';


$this->checkRights = 1;
if ((int)$this->tagId > 0) {
	// Search by tags
	$this->checkRights = 1;
	
	// Categories View in Category View
	if ($this->tmpl['displaycategoriescv']) {
		echo $this->loadTemplate('categories');
	}
	
	echo $this->loadTemplate('images');
	
	
	echo '<div style="clear:both"></div>';
	echo '<div>&nbsp;</div>';
	
	echo $this->loadTemplate('pagination');
	echo '</div>'. "\n";
	
} else {
	// Standard category displaying
	$this->checkRights = 0;
	// Switch image
	$noBaseImg 	= false;
	$noBaseImg	= preg_match("/phoca_thumb_l_no_image/i", $this->tmpl['basicimage']);
	if ($this->tmpl['switchimage'] == 1 && $noBaseImg == false) {
		$switchImage = PhocaGalleryImage::correctSwitchSize($this->tmpl['switchheight'], $this->tmpl['switchwidth']);
		echo '<div class="main-switch-image"><center>'
			.'<table border="0" cellspacing="5" cellpadding="5" class="main-switch-image-table">'
			.'<tr>'
			.'<td align="center" valign="middle" style="text-align:center;'
			.'width: '.$switchImage['width'].'px;'
			.'height: '.$switchImage['height'].'px;'
			.'background: url(\''.$this->tmpl['waitimage'].'\') '
			.$switchImage['centerw'] .'px '
			.$switchImage['centerh'].'px no-repeat;margin:0px;padding:0px;">'
			.$this->tmpl['basicimage'] .'</td>'
			.'</tr></table></center></div>'. "\n";
	}

	// Categories View in Category View
	if ($this->tmpl['displaycategoriescv']) {
		echo $this->loadTemplate('categories');
	}

	// Rendering images
	echo $this->loadTemplate('images');

	echo '<div style="clear:both"></div>';
	echo '<div>&nbsp;</div>';

	echo $this->loadTemplate('pagination');

	if ($this->tmpl['displaytabs'] > 0) {
		echo '<div id="phocagallery-pane">';
		$pane =& JPane::getInstance('Tabs', array('startOffset'=> $this->tmpl['tab']));
		echo $pane->startPane( 'pane' );
		
		if ((int)$this->tmpl['displayrating'] == 1) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-vote.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_RATING'), 'pgvotes' );
			echo $this->loadTemplate('rating');
			echo $pane->endPanel();
		}

		if ((int)$this->tmpl['displaycomment'] == 1) {
			$commentImg = ($this->tmpl['externalcommentsystem'] == 2) ? 'icon-comment-fb' : 'icon-comment';
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/'.$commentImg.'.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_COMMENTS'), 'pgcomments' );
				
				
			if ($this->tmpl['externalcommentsystem'] == 1) {
				if (JComponentHelper::isEnabled('com_jcomments', true)) {
					include_once(JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php');
					echo JComments::showComments($this->category->id, 'com_phocagallery', JText::_('COM_PHOCAGALLERY_CATEGORY') .' '. $this->category->title);
				}
			} else if($this->tmpl['externalcommentsystem'] == 2) {
				echo $this->loadTemplate('comments-fb');
			} else {
				echo $this->loadTemplate('comments');
			}
			echo $pane->endPanel();
		}

		if ((int)$this->tmpl['displaycategorystatistics'] == 1) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-statistics.'.$this->tmpl['formaticon'], '') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_STATISTICS'), 'pgstatistics' );
			echo $this->loadTemplate('statistics');
			echo $pane->endPanel();
		}
		
		if ((int)$this->tmpl['displaycategorygeotagging'] == 1) {
			
			if ($this->map['longitude'] == '' || $this->map['latitude'] == '') {
				//echo '<p>' . JText::_('COM_PHOCAGALLERY_ERROR_MAP_NO_DATA') . '</p>';
			} else {
				echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-geo.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_GEOTAGGING'), 'pggeotagging' );
				echo $this->loadTemplate('geotagging');
				echo $pane->endPanel();
			}
		}
		if ((int)$this->tmpl['displaycreatecat'] == 1) 
		{		
				echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-subcategories.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_CATEGORY'), 'pgnewcategory' );		
			echo $this->loadTemplate('newcategory');		
			echo $pane->endPanel();	
		}
		if ((int)$this->tmpl['displayupload'] == 1) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-upload.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_UPLOAD'), 'pgupload' );
			echo $this->loadTemplate('upload');
			echo $pane->endPanel();
		}
	
		if ((int)$this->tmpl['ytbupload'] == 1 && $this->tmpl['displayupload'] == 1 ) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-upload-ytb.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_YTB_UPLOAD'), 'pgytbupload' );
			echo $this->loadTemplate('ytbupload');
			echo $pane->endPanel();
		}
		
		if((int)$this->tmpl['enablemultiple']  == 1 && (int)$this->tmpl['displayupload'] == 1) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-upload-multiple.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_MULTIPLE_UPLOAD'), 'pgmultipleupload' );
			echo $this->loadTemplate('multipleupload');
			echo $pane->endPanel();
		}

		if($this->tmpl['enablejava'] == 1 && (int)$this->tmpl['displayupload'] == 1) {
			echo $pane->startPanel( JHtml::_( 'image', 'components/com_phocagallery/assets/images/icon-upload-java.'.$this->tmpl['formaticon'],'') . '&nbsp;'.JText::_('COM_PHOCAGALLERY_JAVA_UPLOAD'), 'pgjavaupload' );
			echo $this->loadTemplate('javaupload');
			echo $pane->endPanel();
		}
		

		echo $pane->endPane();
		echo '</div>'. "\n";// end phocagallery-pane
	}
}

if ($this->tmpl['detailwindow'] == 6) {
	?><script type="text/javascript">
	var gjaks = new SZN.LightBox(dataJakJs, optgjaks);
	</script><?php
}

echo '<div>&nbsp;</div>';
echo $this->tmpl['mac'];
?>
