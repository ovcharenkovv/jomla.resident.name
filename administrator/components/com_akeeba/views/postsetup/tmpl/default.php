<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 *
 * @since 1.3
 */

defined('_JEXEC') or die();

$disabled = AKEEBA_PRO ? '' : 'disabled = "disabled"';

$confirmText = JText::_('AKEEBA_POSTSETUP_MSG_MINSTABILITY');
$script = <<<ENDSCRIPT
window.addEvent( 'domready' ,  function() {
	(function($) {
		$('#akeeba-postsetup-apply').click(function(e){
			var minstability = $('#minstability').val();
			if(minstability != 'stable') {
				var reply=confirm("$confirmText");
				if(!reply) return false;
			}
			$('#adminForm').submit();
		});
	})(akeeba.jQuery);
});

ENDSCRIPT;
JFactory::getDocument()->addScriptDeclaration($script);

?>
<div id="akeeba-container" style="width:100%">
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="option" value="com_akeeba" />
	<input type="hidden" name="view" value="postsetup" />
	<input type="hidden" name="task" id="task" value="save" />
	<input type="hidden" name="<?php echo JFactory::getSession()->getToken()?>" value="1" />
	
	<p><?php echo JText::_('AKEEBA_POSTSETUP_LBL_WHATTHIS'); ?></p>

	<?php if($this->showsrp): ?>
	<input type="checkbox" id="srp" name="srp" <?php if($this->enablesrp): ?>checked="checked"<?php endif; ?> <?php echo $disabled?> />
	<label for="srp" class="postsetup-main"><?php echo JText::_('AKEEBA_POSTSETUP_LBL_SRP')?></label>
	</br>
	<?php if(AKEEBA_PRO): ?>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_DESC_SRP');?></div>
	<?php else: ?>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_NOTAVAILABLEINCORE');?></div>
	<?php endif; ?>
	<br/>
	<?php else: ?>
	<input type="hidden" id="srp" name="srp" value="0" />
	<?php endif; ?>

	<input type="checkbox" id="autoupdate" name="autoupdate" <?php if($this->enableautoupdate): ?>checked="checked"<?php endif; ?> <?php echo $disabled?> />
	<label for="autoupdate" class="postsetup-main"><?php echo JText::_('AKEEBA_POSTSETUP_LBL_AUTOUPDATE')?></label>
	</br>
	<?php if(AKEEBA_PRO): ?>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_DESC_autoupdate');?></div>
	<?php else: ?>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_NOTAVAILABLEINCORE');?></div>
	<?php endif; ?>
	<br/>
	
	<input type="checkbox" id="confwiz" name="confwiz" <?php if($this->enableconfwiz): ?>checked="checked"<?php endif; ?> />
	<label for="confwiz" class="postsetup-main"><?php echo JText::_('AKEEBA_POSTSETUP_LBL_confwiz')?></label>
	</br>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_DESC_confwiz');?></div>
	<br/>
	
	<?php if(AKEEBA_PRO): ?>
	<label for="minstability" class="postsetup-main"><?php echo JText::_('AKEEBA_POSTSETUP_LBL_MINSTABILITY')?></label>
	<select id="minstability" name="minstability">
		<option value="alpha" <?php if($this->minstability=='alpha'): ?>selected="selected"<?php endif; ?>><?php echo JText::_('AKEEBA_STABILITY_ALPHA') ?></option>
		<option value="beta" <?php if($this->minstability=='beta'): ?>selected="selected"<?php endif; ?>><?php echo JText::_('AKEEBA_STABILITY_BETA') ?></option>
		<option value="rc" <?php if($this->minstability=='rc'): ?>selected="selected"<?php endif; ?>><?php echo JText::_('AKEEBA_STABILITY_RC') ?></option>
		<option value="stable" <?php if($this->minstability=='stable'): ?>selected="selected"<?php endif; ?>><?php echo JText::_('AKEEBA_STABILITY_STABLE') ?></option>
	</select>
	</br>
	<div class="postsetup-desc"><?php echo JText::_('AKEEBA_POSTSETUP_DESC_MINSTABILITY');?></div>
	<br/>
	<?php else: ?>
	<input type="hidden" id="minstability" name="minstability" value="stable" />
	<?php endif; ?>
	
	<br/>
	<button id="akeeba-postsetup-apply" onclick="return false;"><?php echo JText::_('AKEEBA_POSTSETUP_LBL_APPLY');?></button>

</form>
</div>