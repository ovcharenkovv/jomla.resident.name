<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 1.3
 */

defined('_JEXEC') or die();

// Include tooltip support
jimport('joomla.html.html');
JHTML::_('behavior.tooltip');

if( empty($this->item) )
{
	$id = 0;
	$description = '';
}
else
{
	$id = $this->item->id;
	$description = $this->item->description;
}
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="option" value="com_akeeba" />
	<input type="hidden" name="view" value="profiles" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getToken()?>" value="1" />
	<table>
		<tr>
			<td><?php echo JHTML::_('tooltip', JText::_('PROFILE_LABEL_DESCRIPTION_TOOLTIP'), '', '', JText::_('PROFILE_LABEL_DESCRIPTION')) ?></td>
			<td><input type="text" name="description" size="60" id="description" value="<?php echo $description; ?>" /></td>
		</tr>
	</table>
</form>