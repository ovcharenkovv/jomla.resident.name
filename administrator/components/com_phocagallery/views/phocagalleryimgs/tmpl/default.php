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
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_phocagallery');
$saveOrder	= 'a.ordering';

echo '<div style="float:right">' . $this->tmpl['enablethumbcreationstatus'] .'</div><div class="clr"></div>';

if (isset($this->tmpl['notapproved']->count) && (int)$this->tmpl['notapproved']->count > 0 ) {
	echo '<div class="notapproved">'.JText::_('COM_PHOCAGALLERY_NOT_APPROVED_IMAGE_IN_GALLERY').': '.(int)$this->tmpl['notapproved']->count.'</div>';
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_phocagallery&view=phocagalleryimgs'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_PHOCAGALLERY_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => 0, 'trash' => 0)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>

			<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
				<?php echo JHtml::_('select.options', PhocaGalleryCategory::options('com_phocagallery'), 'value', 'text', $this->state->get('filter.category_id'));?>
			</select>
			
			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
			</select>

		</div>
	</fieldset>
	<div class="clr"> </div>

	<div id="editcell">
		<table class="adminlist">
			<thead>
				<tr>
					
					<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" /></th>
					<th class="image" width="70" align="center"><?php echo JText::_( 'COM_PHOCAGALLERY_IMAGE' ); ?></th>
					<th class="title" width="40%"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_TITLE', 'a.title', $listDirn, $listOrder); ?>
					</th>
					<th width="12%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_FILENAME', 'a.filename',$listDirn, $listOrder ); ?>
					</th>
					

					<th width="1%" nowrap="nowrap"><?php echo JText::_('COM_PHOCAGALLERY_FUNCTIONS'); ?>
					</th>
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', 'COM_PHOCAGALLERY_PUBLISHED', 'a.published',$listDirn, $listOrder ); ?>
					</th>
					<th width="5%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', 'COM_PHOCAGALLERY_APPROVED', 'a.approved',$listDirn, $listOrder ); ?>
					</th>
					
					<th width="15%"  class="title">
						<?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_CATEGORY', 'category_id',$listDirn, $listOrder ); ?></th>
					
					<th width="15%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder);
					if ($canOrder && $saveOrder) {
						echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'phocagalleryimgs.saveorder');
					} ?>
					</th>
					
					
					<th width="5%"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_OWNER', 'category_owner_id',$listDirn, $listOrder ); ?></th>
					
					<th width="5%"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_UPLOADED_BY', 'uploadusername',$listDirn, $listOrder ); ?></th>
					
					<th width="5%"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_RATING', 'v.average',$listDirn, $listOrder ); ?>
					</th>
					
					<th width="5%">
			<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
		</th> 
					<th width="5%"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_HITS', 'a.hits',$listDirn, $listOrder ); ?>
					</th>
					<th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort',  'COM_PHOCAGALLERY_ID', 'a.id',$listDirn, $listOrder ); ?>
					</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
				

if (is_array($this->items)) {
	foreach ($this->items as $i => $item) {
					

$linkEdit 		= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryimg.edit&id='. $item->id );
$linkRotate90 	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryimg.rotate&angle=90&id='. $item->id );
$linkRotate270 	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryimg.rotate&angle=270&id='. $item->id );
$linkDeleteThumbs= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryimg.recreate&cid[]='. (int)$item->id );
//$checked 	= JHTML::_('grid.checkedout', $item, $i );
//$published 	= JHTML::_('grid.published', $item, $i );
//$approved 	= PhocaGalleryRenderAdmin::approved( $item, $i );
					
$ordering	= ($listOrder == 'a.ordering');			
$canCreate	= $user->authorise('core.create', 'com_phocagallery');
$canEdit	= $user->authorise('core.edit', 'com_phocagallery');
$canCheckin	= $user->authorise('core.manage', 'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
$canChange	= $user->authorise('core.edit.state', 'com_phocagallery') && $canCheckin;

$linkCat	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryc.edit&id='.(int) $item->category_id );
$canEditCat	= $user->authorise('core.edit', 'com_phocagallery');
				
echo '<tr class="row'. $i % 2 .'">';
					
echo '<td class="center">'. JHtml::_('grid.id', $i, $item->id) . '</td>';

// - - - - - - - - - -
// Image
echo '<td>';
echo '<div class="phocagallery-box-file">'
    .' <center>'
	.'  <div class="phocagallery-box-file-first">'
	.'   <div class="phocagallery-box-file-second">'
	.'    <div class="phocagallery-box-file-third">'
	.'     <center>';
// PICASA
if (isset($item->extid) && $item->extid !='') {									
	
	$resW				= explode(',', $item->extw);
	$resH				= explode(',', $item->exth);
	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($resW[2], $resH[2], 50, 50);
	$imgLink			= $item->extl;
	
	echo '<a class="'. $this->button->modalname.'" title="'.$this->button->text.'" href="'. $imgLink .'" rel="'. $this->button->options.'" >'
	//. JHTML::_( 'image', $item->exts.'?imagesid='.md5(uniqid(time())), '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']))
	. '<img src="'.$item->exts.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_('COM_PHOCAGALLERY_ENLARGE_IMAGE').'" />'
	.'</a>';
} else if (isset ($item->fileoriginalexist) && $item->fileoriginalexist == 1) {
	
	$imageRes			= PhocaGalleryImage::getRealImageSize($item->filename, 'small');
	$correctImageRes 	= PhocaGalleryImage::correctSizeWithRate($imageRes['w'], $imageRes['h'], 50, 50);
	$imgLink			= PhocaGalleryFileThumbnail::getThumbnailName($item->filename, 'large');
	

	echo '<a class="'. $this->button->modalname.'" title="'. $this->button->text.'" href="'. JURI::root(). $imgLink->rel.'" rel="'. $this->button->options.'" >'
	//. JHTML::_( 'image', $item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())), '', array('width' => $correctImageRes['width'], 'height' => $correctImageRes['height']))
	. '<img src="'.JURI::root().$item->linkthumbnailpath.'?imagesid='.md5(uniqid(time())).'" width="'.$correctImageRes['width'].'" height="'.$correctImageRes['height'].'" alt="'.JText::_('COM_PHOCAGALLERY_ENLARGE_IMAGE').'" />'
	.'</a>';
} else {
	echo JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/phoca_thumb_s_no_image.gif', '');
}
echo '     </center>'
    .'    </div>'
	.'   </div>'
	.'  </div>'
	.' </center>'
	.'</div>';
echo '</td>';
// - - - - - - - - - -


echo '<td>'; 
if ($item->checked_out) {
	echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'phocagallerycs.', $canCheckin);
}

if ($canCreate || $canEdit) {
	echo '<a href="'. JRoute::_($linkEdit).'">'. $this->escape($item->title).'</a>';
} else {
	echo $this->escape($item->title);
}
echo '<p class="smallsub">(<span>'.JText::_('COM_PHOCAGALLERY_FIELD_ALIAS_LABEL').':</span>'. $this->escape($item->alias).')</p>';
echo '</td>';
				
if (isset($item->extid) && $item->extid !='') {
	if (isset($item->exttype) && $item->exttype == 1) {
		echo '<td align="center">'.JText::_('COM_PHOCAGALLERY_FACEBOOK_STORED_FILE').'</td>'
			.'<td></td>';
	} else {
		echo '<td align="center">'.JText::_('COM_PHOCAGALLERY_PICASA_STORED_FILE').'</td>'
			.'<td></td>';
	}
} else {
	echo '<td>'. $item->filename .'</td>'
		.'<td align="center">'
		.'<a href="'. $linkRotate90 .'" title="'. JText::_( 'COM_PHOCAGALLERY_ROTATE_LEFT' ).'">'
		. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-22-rotate-left.png', JText::_( 'COM_PHOCAGALLERY_ROTATE_LEFT' )).'</a> '
		.'<a href="'. $linkRotate270 .'" title="'. JText::_( 'COM_PHOCAGALLERY_ROTATE_RIGHT' ).'">'
		. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-22-rotate-right.png', JText::_( 'COM_PHOCAGALLERY_ROTATE_RIGHT' )).'</a> '
		.'<a href="'. $linkDeleteThumbs.'" title="'. JText::_( 'COM_PHOCAGALLERY_RECREATE_THUMBS' ).'">'. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-22-remove-create.png', JText::_( 'COM_PHOCAGALLERY_DELETE_RECREATE_THUMBS' )).'</a> '
		.'<a href="#" onclick="window.location.reload(true);" title="'. JText::_( 'COM_PHOCAGALLERY_RELOAD_SITE' ).'">'. JHTML::_( 'image', 'administrator/components/com_phocagallery/assets/images/icon-22-reload.png', JText::_( 'COM_PHOCAGALLERY_RELOAD_SITE' )).'</a>' 
		.'</td>';
}

echo '<td class="center">'. JHtml::_('jgrid.published', $item->published, $i, 'phocagalleryimgs.', $canChange) . '</td>';
echo '<td class="center">'. PhocaGalleryJGrid::approved( $item->approved, $i, 'phocagalleryimgs.', $canChange) . '</td>';

echo '<td class="center">';
if ($canEditCat) {
	echo '<a href="'. JRoute::_($linkCat).'">'. $this->escape($item->category_title).'</a>';
} else {
	echo $this->escape($item->category_title);
}
echo '</td>';
	
$cntx = 'phocagalleryimgs';
echo '<td class="order">';
if ($canChange) {
	if ($saveOrder) {
		if ($listDirn == 'asc') {
			echo '<span>'. $this->pagination->orderUpIcon($i, ($item->category_id == @$this->items[$i-1]->category_id), $cntx.'.orderup', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
			echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, ($item->category_id == @$this->items[$i+1]->category_id), $cntx.'.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
		} else if ($listDirn == 'desc') {
			echo '<span>'. $this->pagination->orderUpIcon($i, ($item->category_id == @$this->items[$i-1]->category_id), $cntx.'.orderdown', 'JLIB_HTML_MOVE_UP', $ordering).'</span>';
			echo '<span>'.$this->pagination->orderDownIcon($i, $this->pagination->total, ($item->category_id == @$this->items[$i+1]->category_id), $cntx.'.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering).'</span>';
		}
	}
	$disabled = $saveOrder ?  '' : 'disabled="disabled"';
	echo '<input type="text" name="order[]" size="5" value="'.$item->ordering.'" '.$disabled.' class="text-area-order" />';
} else {
	echo $item->ordering;
}
echo '</td>';

echo '<td>';
echo $item->usernameno;
echo $item->username ? ' ('.$item->username.')' : '';
echo '</td>';


echo '<td>';
echo $item->uploadname;
echo $item->uploadusername ? ' ('.$item->uploadusername.')' : '';
echo '</td>';

echo '<td align="center">';
$voteAvg 		= round(((float)$item->ratingavg / 0.5)) * 0.5;
$voteAvgWidth	= 16 * $voteAvg;
echo '<ul class="star-rating-small">'
.'<li class="current-rating" style="width:'.$voteAvgWidth.'px"></li>'
.'<li><span class="star1"></span></li>';

for ($ir = 2;$ir < 6;$ir++) {
	echo '<li><span class="stars'.$ir.'"></span></li>';
}
echo '</ul>';
echo '</td>';

?>
<td class="center">
	<?php
	if ($item->language=='*') {
		echo JText::_('JALL');
	} else {
		echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED');
	}
	?>
</td>
<?php
echo '<td align="center">'. $item->hits.'</td>';
echo '<td align="center">'. $item->id .'</td>';

echo '</tr>';

		}
	}
echo '</tbody>';		
?>
			</tbody>
			
			<tfoot>
				<tr>
					<td colspan="15"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
		</table>
		<?php echo $this->loadTemplate('batch'); ?>
	</div>

<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>