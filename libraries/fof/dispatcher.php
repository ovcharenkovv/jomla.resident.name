<?php
/**
 *  @package FrameworkOnFramework
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * FrameworkOnFramework dispatcher class
 * 
 * FrameworkOnFramework is a set of classes whcih extend Joomla! 1.5 and later's
 * MVC framework with features making maintaining complex software much easier,
 * without tedious repetitive copying of the same code over and over again.
 */
class FOFDispatcher extends JObject
{
	protected $config = array();
	
	protected $input = array();
	
	public $defaultView = 'cpanel';
	
	/**
	 *
	 * @staticvar array $instances
	 * @param type $option
	 * @param type $view
	 * @param type $config
	 * @return FOFDispatcher
	 */
	public static function &getAnInstance($option = null, $view = null, $config = array())
	{
		static $instances = array();
		
		$hash = $option.$view;
		if(!array_key_exists($hash, $instances)) {
			$instances[$hash] = self::getTmpInstance($option, $view, $config);
		}

		return $instances[$hash];
	}
	
	public static function &getTmpInstance($option = null, $view = null, $config = array())
	{
		if(array_key_exists('input', $config)) {
			$input = $config['input'];
		} else {
			$input = JRequest::get('default', 3);
		}
		$config['option'] = !is_null($option) ? $option : FOFInput::getCmd('option','com_foobar',$input);
		$config['view'] = !is_null($view) ? $view : FOFInput::getCmd('view','',$input);
		$input['option'] = $config['option'];
		$input['view'] = $config['view'];
		$config['input'] = $input;

		$className = ucfirst(str_replace('com_', '', $config['option'])).'Dispatcher';
		if (!class_exists( $className )) {
			$app = JFactory::getApplication();
			if($app->isSite()) {
				$basePath = JPATH_SITE;
			} else {
				$basePath = JPATH_ADMINISTRATOR;
			}

			$searchPaths = array(
				$basePath.'/components/'.$config['option'],
				$basePath.'/components/'.$config['option'].'/dispatchers',
				JPATH_ADMINISTRATOR.'/components/'.$config['option'],
				JPATH_ADMINISTRATOR.'/components/'.$config['option'].'/dispatchers'
			);
			if(array_key_exists('searchpath', $config)) {
				array_unshift($searchPaths, $config['searchpath']);
			}

			jimport('joomla.filesystem.path');
			$path = JPath::find(
				$searchPaths,
				'dispatcher.php'
			);

			if ($path) {
				require_once $path;
			}
		}

		if (!class_exists( $className )) {
			$className = 'FOFDispatcher';
		}
		$instance = new $className($config);
		
		return $instance;
	}
	
	public function __construct($config = array()) {
		// Cache the config
		$this->config = $config;
		
		// Get the input for this MVC triad
		if(array_key_exists('input', $config)) {
			$this->input = $config['input'];
		} else {
			$this->input = JRequest::get('default', 3);
		}
		
		// Get the default values for the component and view names
		$this->component = FOFInput::getCmd('option','com_foobar',$this->input);
		$this->view = FOFInput::getCmd('view',$this->defaultView,$this->input);
		if(empty($this->view)) $this->view = $this->defaultView;
		$this->layout = FOFInput::getCmd('layout',null,$this->input);
		
		// Overrides from the config
		if(array_key_exists('option', $config)) $this->component = $config['option'];
		if(array_key_exists('view', $config)) $this->view = empty($config['view']) ? $this->view : $config['view'];
		if(array_key_exists('layout', $config)) $this->layout = $config['layout'];
		
		FOFInput::setVar('option', $this->component, $this->input);
		FOFInput::setVar('view', $this->view, $this->input);
		FOFInput::setVar('layout', $this->layout, $this->input);
	}
	
	public function dispatch()
	{
		// Timezone fix; avoids errors printed out by PHP 5.3.3+
		if( !version_compare(JVERSION, '1.6.0', 'ge') && function_exists('date_default_timezone_get') && function_exists('date_default_timezone_set')) {
			if(function_exists('error_reporting')) {
				$oldLevel = error_reporting(0);
			}
			$serverTimezone = @date_default_timezone_get();
			if(empty($serverTimezone) || !is_string($serverTimezone)) $serverTimezone = 'UTC';
			if(function_exists('error_reporting')) {
				error_reporting($oldLevel);
			}
			@date_default_timezone_set( $serverTimezone);
		}
		
		// Master access check for the back-end
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if($isAdmin && version_compare(JVERSION, '1.6.0', 'ge')) {
			// Access check, Joomla! 1.6 style.
			$user = JFactory::getUser();
			if (
				!$user->authorise('core.manage', FOFInput::getCmd('option','com_foobar',$this->input) )
				&& !$user->authorise('core.admin', FOFInput::getCmd('option','com_foobar',$this->input))
			) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}
		
		// Merge English and local translations
		if($isAdmin) {
			$paths = array(JPATH_ROOT, JPATH_ADMINISTRATOR);
		} else {
			$paths = array(JPATH_ADMINISTRATOR, JPATH_ROOT);
		}
		$jlang = JFactory::getLanguage();
		$jlang->load($this->component, $paths[0], 'en-GB', true);
		$jlang->load($this->component, $paths[0], null, true);
		$jlang->load($this->component, $paths[1], 'en-GB', true);
		$jlang->load($this->component, $paths[1], null, true);

		if(!$this->onBeforeDispatch()) {

			// For json, don't use normal 403 page, but a json encoded message
			if(FOFInput::getVar('format', '') == 'json'){
				echo json_encode(array('code' => '403', 'error' => $this->getError()));
				exit();
			}

			if(version_compare(JVERSION, '1.6.0', 'ge')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			} else {
				return JError::raiseError(403, JText::_('ALERTNOTAUTH'));
			}
		}
		
		// Get and execute the controller
		$option = FOFInput::getCmd('option','com_foobar',$this->input);
		$view = FOFInput::getCmd('view',$this->defaultView, $this->input);
		$task = FOFInput::getCmd('task','',$this->input);
		if(empty($task)) {
			$task = $this->getTask($view);
		}
		// Pluralise/sungularise the view name for typical tasks
		if(in_array($task,array('edit', 'add', 'read'))) {
			$view = FOFInflector::singularize($view);
		} elseif(in_array($task,array('browse'))) {
			$view = FOFInflector::pluralize($view);
		}
		FOFInput::setVar('view',$view,$this->input);
		FOFInput::setVar('task',$task,$this->input);
		
		$config = array('input'=>$this->input);
		$controller = FOFController::getTmpInstance($option, $view, $config);
		$status = $controller->execute($task);
		if($status === false) {
			if(version_compare(JVERSION, '1.6.0', 'ge')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			} else {
				return JError::raiseError(403, JText::_('ALERTNOTAUTH'));
			}
		}

		if(!$this->onAfterDispatch()) {
			if(version_compare(JVERSION, '1.6.0', 'ge')) {
				return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
			} else {
				return JError::raiseError(403, JText::_('ALERTNOTAUTH'));
			}
		}
		
		$controller->redirect();
	}
	
	protected function getTask($view)
	{
		// get a default task based on plural/singular view
		$task = FOFInflector::isPlural($view) ? 'browse' : 'edit';
		
		// Get a potential ID, we might need it later
		$id = FOFInput::getVar('id', null, $this->input);
		if($id == 0) {
			$ids = FOFInput::getArray('ids',array(),$this->input);
			if(!empty($ids)) {
				$id = array_shift($ids);
			}
		}

		// Check the request method
		$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
		switch($requestMethod) {
			case 'POST':
			case 'PUT':
				if($id != 0) $task = 'save';
				break;
				
			case 'DELETE':
				if($id != 0) $task = 'delete';
				break;
			
			case 'GET':
			default:
				// If it's an edit without an ID or ID=0, it's really an add
				if(($task == 'edit') && ($id == 0)) {
					$task = 'add';
				// If it's an edit in the frontend, it's really a read
				} elseif(($task == 'edit') && JFactory::getApplication()->isSite()) {
					$task = 'read';
				}
				break;
		}

		return $task;
	}
	
	public function onBeforeDispatch()
	{
		return true;
	}
	
	public function onAfterDispatch()
	{
		return true;
	}
}