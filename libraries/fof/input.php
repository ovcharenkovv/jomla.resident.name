<?php
/**
 *  @package FrameworkOnFramework
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

jimport("joomla.environment.request");

/**
 * FrameworkOnFramework input handling class
 * 
 * FrameworkOnFramework is a set of classes whcih extend Joomla! 1.5 and later's
 * MVC framework with features making maintaining complex software much easier,
 * without tedious repetitive copying of the same code over and over again.
 */
class FOFInput
{
	public static function getVar($name, $default = null, $input = null, $type = 'none', $mask = 0)
	{
		if(is_null($input)) {
			$var = JRequest::getVar($name, $default, 'default', $type, $mask);
		} elseif(is_string($input)) {
			$var = JRequest::getVar($name, $default, $input, $type, $mask);
		} elseif (isset($input[$name]) && $input[$name] !== null) {
			// Get the variable from the input hash and clean it
			$var = JRequest::_cleanVar($input[$name], $mask, $type);

			// Handle magic quotes compatability
			if (get_magic_quotes_gpc() && ($var != $default)) {
				$var = self::_stripSlashesRecursive( $var );
			}
		}
		elseif ($default !== null) {
			// Clean the default value
			$var = JRequest::_cleanVar($default, $mask, $type);
		}
		else {
			$var = $default;
		}
		
		return $var;
	}
	
	public static function setVar($name, $value = null, &$input = array(), $overwrite = true)
	{
		if(empty($input)) {
			return JRequest::setVar($name, $value, 'default', $overwrite);
		} elseif(is_string($input)) {
			return JRequest::setVar($name, $value, $input, $overwrite);
		} else {
			if(!$overwrite && array_key_exists($name, $input)) {
				return $input[$name];
			}
			
			$previous = array_key_exists($name, $input) ? $input[$name] : null;
			
			$input[$name] = $value;
			
			return $previous;
		}
	}
	
	public static function getBool($name, $default = false, $input = array())
	{
		return self::getVar($name, $default, $input, 'bool');
	}
	
	public static function getWord($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'word');
	}
	
	public static function getCmd($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'cmd');
	}
	
	public static function getString($name, $default = '', $input = array(), $mask = 0)
	{
		// Cast to string, in case JREQUEST_ALLOWRAW was specified for mask
		return (string) self::getVar($name, $default, $input, 'string', $mask);
	}
	
	public static function getInt($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'int');
	}
	
	public static function getUint($name, $default = '', $input = array())
	{
		if(!version_compare(JVERSION, '1.6.0', 'ge')) {
			return @abs((int) self::getVar($name, $default, $input, 'uint'));
		} else {
			return self::getVar($name, $default, $input, 'uint');
		}
	}
	
	public static function getFloat($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'float');
	}
	
	public static function getAlnum($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'alnum');
	}
	
	public static function getBase64($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'base64');
	}
	
	public static function getHtml($name, $default = '', $input = array())
	{
		if(version_compare(JVERSION,'1.6.0','ge')) {
			return self::getVar($name, $default, $input, 'html');
		} else {
			$data = self::getVar($name, $default, $input, 'none');
			$filter = JFilterInput::getInstance();
			return $filter->_remove((string)$data);
		}
	}
	
	public static function getArray($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'array');
	}
	
	public static function getPath($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'path');
	}
	
	public static function getUsername($name, $default = '', $input = array())
	{
		return self::getVar($name, $default, $input, 'username');
	}
	
	protected static function _stripSlashesRecursive($value)
	{
		$value = is_array($value) ? array_map(array('FOFInput', '_stripSlashesRecursive'), $value) : stripslashes($value);
		return $value;
	}
}