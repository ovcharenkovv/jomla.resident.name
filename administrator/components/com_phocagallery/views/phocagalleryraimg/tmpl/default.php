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
?>

<form action="<?php echo JRoute::_('index.php?option=com_phocagallery&view=phocagalleryraimg'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_PHOCAGALLERY_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			<?php /*
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => 0, 'trash' => 0)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
			*/ ?>
			<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>
				<?php echo JHtml::_('select.options', PhocaGalleryCategory::options('com_phocagallery'), 'value', 'text', $this->state->get('filter.category_id'));?>
			</select>
			<?php /*
			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
			</select>
			*/ ?>
		</div>
	</fieldset>
	<div class="clr"> </div>

<table class="adminlist">
<thead>
	<tr>
		<th width="1%">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(this)" />
		</th>
		<th class="title">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_USER', 'ua.username', $listDirn, $listOrder); ?>
		</th>
		<th width="5%" align="center">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_RATING', 'a.rating', $listDirn, $listOrder); ?>
		</th>
		<?php /*
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
		</th>
		*/ ?>
		<th width="20%">
			<?php echo JHtml::_('grid.sort',  'COM_PHOCAGALLERY_IMAGE', 'image_title', $listDirn, $listOrder); ?>
		</th>
		<th width="20%">
			<?php echo JHtml::_('grid.sort',  'COM_PHOCAGALLERY_CATEGORY', 'category_title', $listDirn, $listOrder); ?>
		</th>
		<?php /*
		<th width="5%">
			<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
		</th> */ ?>
		<th width="1%" nowrap="nowrap">
			<?php echo JHtml::_('grid.sort', 'COM_PHOCAGALLERY_ID', 'a.id', $listDirn, $listOrder); ?>
		</th>
		
	</tr>
</thead>

<tbody>
<?php foreach ($this->items as $i => $item) {

$linkCat	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryc.edit&id='. $item->category_id );
$canEditCat	= $user->authorise('core.edit', 'com_phocagallery');
$linkImg	= JRoute::_( 'index.php?option=com_phocagallery&task=phocagalleryimg.edit&id='. $item->image_id );
$canEditImg	= $user->authorise('core.edit', 'com_phocagallery');
?>
<tr class="row<?php echo $i % 2; ?>">
	<td class="center">
		<?php echo JHtml::_('grid.id', $i, $item->id); ?>
	</td>
	<td><?php echo $item->ratingname .' ('.$item->ratingusername.')'; ?></td>
	<td class="center"><?php echo $item->rating; ?></td>
	
	<td class="center">
		<?php if ($canEditImg) {
			echo '<a href="'. JRoute::_($linkImg).'">'. $this->escape($item->image_title).'</a>';
		} else {
			echo $this->escape($item->image_title);
		} ?>
	</td>
	
	<td class="center">
		<?php if ($canEditCat) {
			echo '<a href="'. JRoute::_($linkCat).'">'. $this->escape($item->category_title).'</a>';
		} else {
			echo $this->escape($item->category_title);
		} ?>
	</td>
	<td class="center"><?php echo (int) $item->id; ?></td>
</tr>
<?php } ?>
</tbody>
			
<tfoot>
	<tr>
		<td colspan="11">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
</table>

<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>