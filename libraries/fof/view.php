<?php
/**
 *  @package FrameworkOnFramework
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

/**
 * FrameworkOnFramework View class
 * 
 * FrameworkOnFramework is a set of classes which extend Joomla! 1.5 and later's
 * MVC framework with features making maintaining complex software much easier,
 * without tedious repetitive copying of the same code over and over again.
 */
abstract class FOFView extends JView
{
	protected $config = array();
	
	protected $input = array();
	
	public function  __construct($config = array()) {
		parent::__construct($config);
		
		// Get the input
		if(array_key_exists('input', $config)) {
			$this->input = $config['input'];
		} else {
			$this->input = JRequest::get('default', 3);
		}
		
		// Get the component name
		if(array_key_exists('input', $config)) {
			$component = FOFInput::getCmd('option','',$config['input']);
		}
		if(array_key_exists('option', $config)) if($config['option']) $component = $config['option'];
		$config['option'] = $component;
		
		// Get the view name
		if(array_key_exists('input', $config)) {
			$view = FOFInput::getCmd('view','',$config['input']);
		}
		if(array_key_exists('view', $config)) if($config['view']) $view = $config['view'];
		$config['view'] = $view;
		
		// Set the component and the view to the input array
		if(array_key_exists('input', $config)) {
			FOFInput::setVar('option', $config['option'], $config['input']);
			FOFInput::setVar('view', $config['view'], $config['input']);
		}
		
		// Set the view name
		if (array_key_exists('name', $config))  {
			$this->_name = $config['name'];
		} else {
			$this->_name = $config['view'];
		}
		
		// Set a base path for use by the view
		if (array_key_exists('base_path', $config)) {
			$this->_basePath	= $config['base_path'];
		} else {
			$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
			$this->_basePath	= ($isAdmin ? JPATH_ADMINISTRATOR : JPATH_COMPONENT).'/'.$config['option'];
		}
		
		// Set the default template search path
		if (array_key_exists('template_path', $config)) {
			// User-defined dirs
			$this->_setPath('template', $config['template_path']);
		} else {
			$altView = FOFInflector::isSingular($this->getName()) ? FOFInflector::pluralize($this->getName()) : FOFInflector::singularize($this->getName());
			$this->_setPath('template', $this->_basePath . '/views/' . $altView . '/tmpl');
			$this->_addPath('template', $this->_basePath . '/views/' . $this->getName() . '/tmpl');
		}
		
		// Set the default helper search path
		if (array_key_exists('helper_path', $config)) {
			// User-defined dirs
			$this->_setPath('helper', $config['helper_path']);
		} else {
			$this->_setPath('helper', $this->_basePath . '/helpers');
		}

		$this->config = $config;
		
		$app = JFactory::getApplication();
		if (isset($app))
		{
			$component = preg_replace('/[^A-Z0-9_\.-]/i', '', $component);
			$fallback = JPATH_THEMES . '/' . $app->getTemplate() . '/html/' . $component . '/' . $this->getName();
			$this->_addPath('template', $fallback);
		}
	}
	
	/**
	 * Loads a template given any path. The path is in the format:
	 * [admin|site]:com_foobar/viewname/templatename
	 * e.g. admin:com_foobar/myview/default
	 * @param string $path 
	 * @param array $forceParams A hash array of variables to be extracted in the local scope of the template file
	 */
	public function loadAnyTemplate($path = '', $forceParams = array())
	{
		$template = JFactory::getApplication()->getTemplate();
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$layoutTemplate = $this->getLayoutTemplate();
		}
		
		// Parse the path
		$templateParts = $this->_parseTemplatePath($path);
		
		// Get the default paths
		$paths = array();
		$paths[] = ($templateParts['admin'] ? JPATH_ADMINISTRATOR : JPATH_SITE).'/components/'.
			$templateParts['component'].'/views/'.$templateParts['view'].'/tmpl';
		$paths[] = ($templateParts['admin'] ? JPATH_ADMINISTRATOR : JPATH_SITE).'/templates/'.
			$template.'/html/'.$templateParts['component'].'/'.$templateParts['view'];
		
		// Look for a template override
		if (isset($layoutTemplate) && $layoutTemplate != '_' && $layoutTemplate != $template)
		{
			$apath = array_pop($paths);
			$paths[] = str_replace($template, $layoutTemplate, $apath);
		}
		
		$filetofind = $templateParts['template'].'.php';
		jimport('joomla.filesystem.path');
		$this->_tempFilePath = JPath::find($paths, $filetofind);
		if($this->_tempFilePath) {
			// Unset from local scope
			unset($template); unset($layoutTemplate); unset($paths); unset($path);
			unset($filetofind);
			
			// Never allow a 'this' property
			if (isset($this->this)) {
				unset($this->this);
			}
			
			// Force parameters into scope
			if(!empty($forceParams)) {
				extract($forceParams);
			}
			
			// Start capturing output into a buffer
			ob_start();
			// Include the requested template filename in the local scope
			// (this will execute the view logic).
			include $this->_tempFilePath;

			// Done with the requested template; get the buffer and
			// clear it.
			$this->_output = ob_get_contents();
			ob_end_clean();

			return $this->_output;
		} else {
			return JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $path));
			return false;
		}
	}
	
	private function _parseTemplatePath($path = '')
	{
		$parts = array(
			'admin'		=> 0,
			'component'	=> $this->config['option'],
			'view'		=> $this->config['view'],
			'template'	=> 'default'
		);
		
		if(substr($path,0,6) == 'admin:') {
			$parts['admin'] = 1;
			$path = substr($path,6);
		} elseif(substr($path,0,5) == 'site:') {
			$path = substr($path,5);
		}
		
		if(empty($path)) return;
		
		$pathparts = explode('/', $path, 3);
		switch(count($pathparts)) {
			case 3:
				$parts['component'] = array_shift($pathparts);
			
			case 2:
				$parts['view'] = array_shift($pathparts);
			
			case 1:
				$parts['template'] = array_shift($pathparts);
				break;
		}
		
		return $parts;
	}
}
