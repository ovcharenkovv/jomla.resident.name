<?php defined('_JEXEC') or die('Restricted access'); 

echo '<form action="'.$this->tmpl['action'].'" method="post" name="adminForm">'. "\n";

if (count($this->items)) {
	echo '<div class="pg-center"><div class="pagination">';
	if ($this->params->get('show_ordering_images')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_ORDER_FRONT') .'&nbsp;'
			.$this->tmpl['ordering']
			.'</div>';
	}
	if ($this->params->get('show_pagination_limit_category')) {
		echo '<div class="pg-inline">'
			.JText::_('COM_PHOCAGALLERY_DISPLAY_NUM') .'&nbsp;'
			.$this->tmpl['pagination']->getLimitBox()
			.'</div>';
	}
	if ($this->params->get('show_pagination_category')) {
	
		echo '<div style="margin:0 10px 0 10px;display:inline;" class="sectiontablefooter'.$this->params->get( 'pageclass_sfx' ).'" id="pg-pagination" >'
			.$this->tmpl['pagination']->getPagesLinks()
			.'</div>'
			.'<div style="margin:0 10px 0 10px;display:inline;" class="pagecounter">'
			.$this->tmpl['pagination']->getPagesCounter()
			.'</div>';
	}
	echo '</div></div>'. "\n";

}
echo '<input type="hidden" name="controller" value="category" />';
echo JHtml::_( 'form.token' );
echo '</form>';
echo '</div>'. "\n";
