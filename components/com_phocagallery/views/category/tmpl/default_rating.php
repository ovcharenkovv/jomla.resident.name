<?php defined('_JEXEC') or die('Restricted access');
// SEF problem
$isThereQMR = false;
$isThereQMR = preg_match("/\?/i", $this->tmpl['action']);
if ($isThereQMR) {
	$amp = '&amp;';
} else {
	$amp = '?';
}
?><div id="phocagallery-votes">
	<div style="font-size:1px;height:1px;margin:0px;padding:0px;">&nbsp;</div>
	<fieldset>
	<legend><?php echo JText::_('COM_PHOCAGALLERY_RATE_THIS_CATEGORY'); ?></legend>
			
	<?php
	echo '<p><strong>' . JText::_('COM_PHOCAGALLERY_RATING'). '</strong>: ' . $this->tmpl['votesaverage'] .' / '.$this->tmpl['votescount'] . ' ' . JText::_($this->tmpl['votestext']). '</p>';

	if ($this->tmpl['alreadyrated']) {
	
		echo '<ul class="star-rating">'
			.'<li class="current-rating" style="width:'.$this->tmpl['voteswidth'].'px"></li>'
			.'<li><span class="star1"></span></li>';
	
		for ($i = 2;$i < 6;$i++) {
			echo '<li><span class="stars'.$i.'"></span></li>';
		}
		echo '</ul>'
		    .'<p>'.JText::_('COM_PHOCAGALLERY_RATING_ALREADY_RATED').'</p>';
			
	} else if ($this->tmpl['notregistered']) {
	
		echo '<ul class="star-rating">'
			.'<li class="current-rating" style="width:'.$this->tmpl['voteswidth'].'px"></li>'
			.'<li><span class="star1"></span></li>';
	
		for ($i = 2;$i < 6;$i++) {
			echo '<li><span class="stars'.$i.'"></span></li>';
		}
		echo '</ul>'
		    .'<p>'.JText::_('COM_PHOCAGALLERY_COMMENT_ONLY_REGISTERED_LOGGED_RATE_CATEGORY').'</p>';
			
	} else {
		
		echo '<ul class="star-rating">'
		    .'<li class="current-rating" style="width:'.$this->tmpl['voteswidth'].'px"></li>'
			//.'<li><a href="'.$this->tmpl['action'].$amp.'controller=category&task=rate&rating=1&tab='.$this->tmpl['currenttab']['rating'].$this->tmpl['limitstarturl'].'" title="1 '. JText::_('COM_PHOCAGALLERY_STAR_OUT_OF').' 5" class="star1">1</a></li>';

			
			.'<li><a href="'.$this->tmpl['action'].$amp.'controller=category&task=rate&rating=1&tab='.$this->tmpl['currenttab']['rating'].$this->tmpl['limitstarturl'].'" title="'. JText::sprintf('COM_PHOCAGALLERY_STAR_OUT_OF', 1, 5). '" class="star1">1</a></li>';
		
		for ($i = 2;$i < 6;$i++) {
			//echo '<li><a href="'.$this->tmpl['action'].$amp.'controller=category&task=rate&rating='.$i.'&tab='.$this->tmpl['currenttab']['rating'].$this->tmpl['limitstarturl'].'" title="'.$i.' '. JText::_('COM_PHOCAGALLERY_STARS_OUT_OF').' 5" class="stars'.$i.'">'.$i.'</a></li>';
			
			echo '<li><a href="'.$this->tmpl['action'].$amp.'controller=category&task=rate&rating='.$i.'&tab='.$this->tmpl['currenttab']['rating'].$this->tmpl['limitstarturl'].'" title="'. JText::sprintf('COM_PHOCAGALLERY_STARS_OUT_OF', $i, 5) .'" class="stars'.$i.'">'.$i.'</a></li>';
		}
		echo '</ul>';
	}
	?>
	
	</fieldset>
</div>
