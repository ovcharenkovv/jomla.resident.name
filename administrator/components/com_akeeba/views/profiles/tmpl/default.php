<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 1.3
 */

defined('_JEXEC') or die();

$configurl = base64_encode(JURI::base().'index.php?option=com_akeeba&view=config');
$token = JFactory::getSession()->getToken();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="option" value="com_akeeba" />
	<input type="hidden" name="view" value="profiles" />
	<input type="hidden" name="boxchecked" id="boxchecked" value="0" />
	<input type="hidden" name="task" id="task" value="" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getToken()?>" value="1" />
	
	<fieldset>
		<legend>
			<span class="ui-icon ui-icon-info" style="display:inline-block;">&nbsp;</span>
			<?php echo JText::_('CONFIG_LABEL_INFORMATION') ?>
		</legend>
		
		<div>
			<b><?php echo JText::_('CPANEL_PROFILE_TITLE'); ?></b>: #<?php echo $this->profileid; ?> <?php echo $this->profilename; ?>
		</div>
	</fieldset>
	
	<table class="adminlist">
		<thead>
			<tr>
				<th width="20px">&nbsp;</th>
				<th width="20px">#</th>
				<th><?php JText::_('PROFILE_COLLABEL_DESCRIPTION'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i = 1;
		foreach( $this->items as $profile ):
		$id = JHTML::_('grid.id', ++$i, $profile->id);
		$link = 'index.php?option=com_akeeba&amp;view=profiles&amp;task=edit&amp;id='.$profile->id;
		$i = 1 - $i;
		?>
			<tr class="row<?php echo $i; ?>">
				<td><?php echo $id; ?></td>
				<td><?php echo $profile->id ?></td>
				<td>
					<button onclick="window.location='index.php?option=com_akeeba&task=switchprofile&profileid=<?php echo $profile->id ?>&returnurl=<?php echo $configurl ?>&<?php echo $token ?>=1'; return false;">
						<?php echo JText::_('CONFIG_UI_CONFIG'); ?>
					</button>
					&nbsp;
					<a href="<?php echo $link; ?>">
						<?php echo $profile->description; ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>