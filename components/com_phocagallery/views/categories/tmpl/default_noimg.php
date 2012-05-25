<?php
defined('_JEXEC') or die('Restricted access');
echo "\n\n";
for ($i = 0; $i < $this->tmpl['countcategories']; $i++) {
	if ( (int)$this->tmpl['categoriescolumns'] == 1 ) {
		echo '<ul class="pg-cats-list" >'."\n";
	} else {
		$float = 0;
		foreach ($this->tmpl['begin'] as $k => $v) {
			if ($i == $v) {
				$float = 1;
			}
		}
		if ($float == 1) {		
			echo '<div style="'.$this->tmpl['fixedwidthstyle2'].'" class="pg-cats-box-float">'."\n"
				.'<ul class="pg-cats-list">'."\n";
		}
	}
	
	echo '<li><a href="'.$this->categories[$i]->link.'">'.$this->categories[$i]->title.'</a>&nbsp;';
	
	if ($this->categories[$i]->numlinks > 0) {echo '<span class="pg-small">('.$this->categories[$i]->numlinks.')</span>';}
	
	echo '</li>'."\n";
	
	if ( (int)$this->tmpl['categoriescolumns'] == 1 ) {
		echo '</ul>'."\n";
	} else {
		if ($i == $this->tmpl['endfloat']) {
			echo '</ul></div><div style="clear:both"></div>'."\n";
		} else {
			$float = 0;
			foreach ($this->tmpl['end'] as $k => $v)
			{
				if ($i == $v) {
					$float = 1;
				}
			}
			if ($float == 1) {		
				echo '</ul></div>'."\n";
			}
		}
	}
}
echo "\n";
?>