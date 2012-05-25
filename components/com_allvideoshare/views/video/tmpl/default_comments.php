<?php

/*
 * @version		$Id: default_comments.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$config = $this->config;
$custom = $this->custom;

?>

<div class="avs_video_comments">
  <h2><?php echo JText::_('ADD_YOUR_COMMENTS'); ?></h2>
  <div class="fb-comments" data-href="<?php echo JURI::current(); ?>" data-num-posts="<?php echo $config[0]->comments_posts; ?>" data-width="<?php echo $custom->width; ?>" data-colorscheme="<?php echo $config[0]->comments_color; ?>"></div>
</div>