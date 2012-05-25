<?php
defined('_JEXEC') or die('Restricted access'); 

if ($this->tmpl['phocagallerywidth'] != '') {
	$centerPage = '';
	if ($this->tmpl['phocagallerycenter'] == 2 || $this->tmpl['phocagallerycenter'] == 3) {
		$centerPage = 'margin: auto;';
	}
	echo '<div id="phocagallery" style="width:'. $this->tmpl['phocagallerywidth'].'px;'.$centerPage.'" class="pg-categories-view'.$this->params->get( 'pageclass_sfx' ).'">';
} else {
	echo '<div id="phocagallery" class="pg-categories-view'.$this->params->get( 'pageclass_sfx' ).'">';
}

if ( $this->params->get( 'show_page_heading' ) ) { 
	echo '<h1>'. $this->escape($this->params->get('page_heading')) . '</h1>';
}

echo '<div id="pg-icons">';
echo PhocaGalleryRenderFront::renderFeedIcon('categories');
echo '</div>';
echo '<div style="clear:both"></div>';

if ($this->tmpl['categories_description'] != '') {
	echo '<div class="phocagallery-cat-desc" >'.$this->tmpl['categories_description'].'</div>';
}

echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">';


if ($this->tmpl['displayimagecategories'] == 1) {	
	echo $this->loadTemplate('catimg');// TABLE LAYOUT - Categories and Images
} else if ($this->tmpl['displayimagecategories'] == 2){
	echo $this->loadTemplate('catimgdetail');// DETAIL LAYOUT 2 (with columns)
} else if ($this->tmpl['displayimagecategories'] == 3){
	echo $this->loadTemplate('catimgdetailfloat');// DETAIL LAYOUT 3 - FLOAT - Every categoy will float Categories, images and detail information (Float)
} else if ($this->tmpl['displayimagecategories'] == 4){
	echo $this->loadTemplate('catimgdesc');// LAYOUT 4 (with columns) (easy categories, images and description)
} else if ($this->tmpl['displayimagecategories'] == 5){
	echo $this->loadTemplate('custom');// LAYOUT 5 Custom - float
} else {
	echo $this->loadTemplate('noimg');// UL LAYOUT - Categories Without Images
}


if (count($this->categories)) {
	echo '<div class="pg-center"><div class="pagination">';
	if ($this->params->get('show_ordering_categories')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_ORDER_FRONT') .'&nbsp;'
			.$this->tmpl['ordering']
			.'</div>';
	}
	if ($this->params->get('show_pagination_limit_categories')) {	
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_DISPLAY_NUM') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	if ($this->params->get('show_pagination_categories')) {
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" id="pg-pagination" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
		
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div></div>'. "\n";
}

echo '</form></div>';
echo PhocaGalleryUtils::footer();