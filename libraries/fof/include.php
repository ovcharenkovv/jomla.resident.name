<?php
/**
 *  @package FrameworkOnFramework
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * Automatic registration of FrameworkOnFramework's classes with JLoader
 * 
 * FrameworkOnFramework is a set of classes whcih extend Joomla! 1.5 and later's
 * MVC framework with features making maintaining complex software much easier,
 * without tedious repetitive copying of the same code over and over again.
 */

if(!defined('FOF_INCLUDED'))
{
	define('FOF_INCLUDED','rev28A0F2E');
	
	function fofRegisterClasses()
	{
		jimport('joomla.filesystem.folder');
		$fofPath = dirname(__FILE__);
		$fofFiles = JFolder::files($fofPath, '\.php$');
		foreach($fofFiles as $file) {
			$baseName = basename($file, '.php');
			$parts = explode('.', $baseName);
			$className = 'FOF';
			foreach($parts as $p) $className .= ucfirst($p);
			JLoader::register($className, $fofPath.'/'.$file);
		}
	}

	fofRegisterClasses();
}
?>
