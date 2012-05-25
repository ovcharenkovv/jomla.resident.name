<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryUtils
{
	
	function htmlToRgb($clr) {
		if ($clr[0] == '#') {
			$clr = substr($clr, 1);
		}
		
		if (strlen($clr) == 6) {
			list($r, $g, $b) = array($clr[0].$clr[1],$clr[2].$clr[3],$clr[4].$clr[5]);
		} else if (strlen($clr) == 3) {
			list($r, $g, $b) = array($clr[0].$clr[0], $clr[1].$clr[1], $clr[2].$clr[2]);
		} else {
			$r = $g = $b = 255;
		}

		$color[0] = hexdec($r);
		$color[1] = hexdec($g);
		$color[2] = hexdec($b);

		return $color;
	}
	
	/*
	 * Source: http://php.net/manual/en/function.ini-get.php
	 */
	function iniGetBool($a) {
		$b = ini_get($a);
		switch (strtolower($b)) {
			case 'on':
			case 'yes':
			case 'true':
			return 'assert.active' !== $a;

			case 'stdout':
			case 'stderr':
			return 'display_errors' === $a;

			Default:
			return (bool) (int) $b;
		}
	}
	
	function setQuestionmarkOrAmp($url) {
		$isThereQMR = false;
		$isThereQMR = preg_match("/\?/i", $url);
		if ($isThereQMR) {
			return '&amp;';
		} else {
			return '?';
		}
	}
	
	public function toArray($value = FALSE) {
		if ($value == FALSE) {
			return array(0 => 0);
		} else if (empty($value)) {
			return array(0 => 0);
		} else if (is_array($value)) {
			return $value;
		} else {
			return array(0 => $value);
		}
	
	}
	
	public function setMessage($new = '', $current = '') {
		
		$message = $current;
		if($new != '') {
			if ($current != '') {
				$message .= '<br />';
			}
			$message .= $new;
		}
		return $message;
	}
	
	
	function filterInput($string) {
		if (strpos($string, '"') !== false) {
			$string = str_replace(array('=', '<'), '', $string);
		}
		return $string;
	}
	
	function isURLAddress($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	public function isEnabledMultiboxFeature($feature) {
	
		$app		= JFactory::getApplication();	
		$params		= $app->getParams();
		
		$enable_multibox				= $params->get( 'enable_multibox', 0);
		$display_multibox				= $params->get( 'display_multibox', array(1,2));
		
		if ($enable_multibox == 1 && in_array($feature,$display_multibox)) {
			return true;
		}
		return false;
	}
	
	public function footer() {
	 echo '<div style="text-align: center; color: rgb(211, 211, 211);">Powe'.'red by <a href="http://www.ph' .'oca.cz" style="text-decoration: none;" target="_blank" title="Phoc'.'a.cz">Phoca</a> <a href="http://www.phoca.cz/phocaga'.'llery" style="text-decoration: none;" target="_blank" title="Phoca Gal' .'lery">Gall'.'ery</a></div>';

	}
}
?>