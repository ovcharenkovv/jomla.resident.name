<?php

/*
 * @version		$Id: ismobile.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class IsMobile {

    protected $accept;
	protected $userAgent;
	protected $isMobile           = false;
	protected $isAndroid          = null;
	protected $isAndroidtablet    = null;
	protected $isIphone           = null;
	protected $isIpad             = null;
	protected $isBlackberry       = null;
	protected $isBlackberrytablet = null;
	protected $isOpera            = null;
	protected $isPalm             = null;
	protected $isWindows          = null;
	protected $isWindowsphone     = null;
	protected $isGeneric          = null;
	protected $devices            = array(
		"android"                 => "android.*mobile",
		"androidtablet"           => "android(?!.*mobile)",
		"blackberry"              => "blackberry",
		"blackberrytablet"        => "rim tablet os",
		"iphone"                  => "(iphone|ipod)",
		"ipad"                    => "(ipad)",
		"palm"                    => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
		"windows"                 => "windows ce; (iemobile|ppc|smartphone)",
		"windowsphone"            => "windows phone os",
		"generic"                 => "(kindle|mobile|mmp|midp|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap|opera mini)"
	);

	public function __construct()
	{
		$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->accept    = $_SERVER['HTTP_ACCEPT'];

		if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
			$this->isMobile = true;
		} elseif (strpos($this->accept, 'text/vnd.wap.wml') > 0 || strpos($this->accept, 'application/vnd.wap.xhtml+xml') > 0) {
			$this->isMobile = true;
		} else {
			foreach ($this->devices as $device => $regexp) {
				if ($this->isDevice($device)) {
					$this->isMobile = true;
				}
			}
		}
	}

	public function __call($name, $arguments)
	{
		$device = substr($name, 2);
		if ($name == "is" . ucfirst($device) && array_key_exists(strtolower($device), $this->devices)) {
			return $this->isDevice($device);
		} else {
			trigger_error("Method $name not defined", E_USER_WARNING);
		}
	}

	public function isMobile()
	{
		return $this->isMobile;
	}

	protected function isDevice($device)
	{
		$var = "is" . ucfirst($device);
		$return = $this->$var === null ? (bool) preg_match("/" . $this->devices[strtolower($device)] . "/i", $this->userAgent) : $this->$var;
		if ($device != 'generic' && $return == true) {
			$this->isGeneric = false;
		}

		return $return;
	}
	
}

?>