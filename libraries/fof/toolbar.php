<?php
/**
 *  @package FrameworkOnFramework
 *  @copyright Copyright (c)2010-2012 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

class FOFToolbar
{
	protected $config = array();

	protected $input = array();

	public $perms = array();

	/**
	 *
	 * @staticvar array $instances
	 * @param type $option
	 * @param type $view
	 * @param type $config
	 * @return FOFToolbar
	 */
	public static function &getAnInstance($option = null, $config = array())
	{
		static $instances = array();

		$hash = $option;
		if(!array_key_exists($hash, $instances)) {
			if(array_key_exists('input', $config)) {
				$input = $config['input'];
			} else {
				$input = JRequest::get('default', 3);
			}
			$config['option'] = !is_null($option) ? $option : FOFInput::getCmd('option','com_foobar',$input);
			$input['option'] = $config['option'];
			$config['input'] = $input;

			$className = ucfirst(str_replace('com_', '', $config['option'])).'Toolbar';
			if (!class_exists( $className )) {
				$app = JFactory::getApplication();
				if($app->isSite()) {
					$basePath = JPATH_SITE;
				} else {
					$basePath = JPATH_ADMINISTRATOR;
				}

				$searchPaths = array(
					$basePath.'/components/'.$config['option'],
					$basePath.'/components/'.$config['option'].'/toolbars',
					JPATH_ADMINISTRATOR.'/components/'.$config['option'],
					JPATH_ADMINISTRATOR.'/components/'.$config['option'].'/toolbars'
				);
				if(array_key_exists('searchpath', $config)) {
					array_unshift($searchPaths, $config['searchpath']);
				}

				jimport('joomla.filesystem.path');
				$path = JPath::find(
					$searchPaths,
					'toolbar.php'
				);

				if ($path) {
					require_once $path;
				}
			}

			if (!class_exists( $className )) {
				$className = 'FOFToolbar';
			}
			$instance = new $className($config);

			$instances[$hash] = $instance;
		}

		return $instances[$hash];
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

		// Overrides from the config
		if(array_key_exists('option', $config)) $this->component = $config['option'];

		FOFInput::setVar('option', $this->component, $this->input);

		// Get default permissions (can be overriden by the view)
		if(version_compare(JVERSION, '1.6.0', 'ge')) {
			$isAdmin = !JFactory::$application ? false : JFactory::getApplication()->isAdmin();
			$user = JFactory::getUser();
			$perms = (object)array(
				'manage'	=> $user->authorise('core.manage', FOFInput::getCmd('option','com_foobar',$this->input) ),
				'create'	=> $user->authorise('core.create', FOFInput::getCmd('option','com_foobar',$this->input) ),
				'edit'		=> $user->authorise('core.edit', FOFInput::getCmd('option','com_foobar',$this->input)),
				'editstate'	=> $user->authorise('core.edit.state', FOFInput::getCmd('option','com_foobar',$this->input)),
				'delete'	=> $user->authorise('core.delete', FOFInput::getCmd('option','com_foobar',$this->input)),
			);
		} else {
			$isAdmin = JFactory::getApplication()->isAdmin();
			$perms = (object)array(
				'manage'	=> true,
				'create'	=> true,
				'edit'		=> true,
				'editstate'	=> true,
				'delete'	=> true,
			);
		}

		//if not in the administrative area, load the JToolbarHelper
		if(!$isAdmin)
		{
			//pretty ugly require...
			require_once(JPATH_ROOT.'/administrator/includes/toolbar.php');
		}

		// Store permissions in the local toolbar object
		$this->perms = $perms;
	}

	public function renderToolbar($view = null, $task = null, $input = null)
	{
		if(!empty($input)) {
			$saveInput = $this->input;
			$this->input = $input;
		}

		// If there is a render.toolbar=0 in the URL, do not render a toolbar
		if(!FOFInput::getBool('render.toolbar',true,$this->input)) return;

		// Get the view and task
		if(empty($view)) $view = FOFInput::getCmd('view','cpanel',$this->input);
		if(empty($task)) $task = FOFInput::getCmd('task','default',$this->input);

		$this->view = $view;
		$this->task = $task;

		$view = FOFInflector::pluralize($view);

		// Check for an onViewTask method
		$methodName = 'on'.ucfirst($view).ucfirst($task);
		if(method_exists($this, $methodName)) {
			return $this->$methodName();
		}

		// Check for an onView method
		$methodName = 'on'.ucfirst($view);
		if(method_exists($this, $methodName)) {
			return $this->$methodName();
		}

		// Check for an onTask method
		$methodName = 'on'.ucfirst($task);
		if(method_exists($this, $methodName)) {
			return $this->$methodName();
		}

		if(!empty($input)) {
			$this->input = $saveInput;
		}
	}

	/**
	 * Renders the toolbar for the component's Control Panel page
	 */
	public function onCpanelsBrowse()
	{
		//on frontend, buttons must be added specifically
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if(!$isAdmin) return;

		JToolBarHelper::title(JText::_( FOFInput::getCmd('option','com_foobar',$this->input)), str_replace('com_', '', FOFInput::getCmd('option','com_foobar',$this->input)));
		JToolBarHelper::preferences(FOFInput::getCmd('option','com_foobar',$this->input), 550, 875);
		$this->renderSubmenu();
	}

	/**
	 * Renders the toolbar for the component's Browse pages (the plural views)
	 */
	public function onBrowse()
	{
		//on frontend, buttons must be added specifically
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if(!$isAdmin) return;

		// Set toolbar title
		$subtitle_key = FOFInput::getCmd('option','com_foobar',$this->input).'_TITLE_'.strtoupper(FOFInput::getCmd('view','cpanel',$this->input));
		JToolBarHelper::title(JText::_( FOFInput::getCmd('option','com_foobar',$this->input)).' &ndash; <small>'.JText::_($subtitle_key).'</small>', str_replace('com_', '', FOFInput::getCmd('option','com_foobar',$this->input)));

		// Add toolbar buttons
		if($this->perms->create) {
			JToolBarHelper::addNewX();
		}
		if($this->perms->edit) {
			JToolBarHelper::editListX();
		}
		if($this->perms->create || $this->perms->edit) {
			JToolBarHelper::divider();
		}

		if($this->perms->editstate) {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::divider();
		} 
		if($this->perms->delete) {
			$msg = JText::_(FOFInput::getCmd('option','com_foobar',$this->input).'_CONFIRM_DELETE');
			JToolBarHelper::deleteList($msg);
		}

		$this->renderSubmenu();
	}

	/**
	 * Renders the toolbar for the component's Read pages
	 */
	public function onRead()
	{
		//on frontend, buttons must be added specifically
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if(!$isAdmin) return;

		$option = FOFInput::getCmd('option','com_foobar',$this->input);
		$componentName = str_replace('com_', '', $option);

		// Set toolbar title
		$subtitle_key = FOFInput::getCmd('option','com_foobar',$this->input).'_TITLE_'.strtoupper(FOFInput::getCmd('view','cpanel',$this->input)).'_READ';
		JToolBarHelper::title(JText::_(FOFInput::getCmd('option','com_foobar',$this->input)).' &ndash; <small>'.JText::_($subtitle_key).'</small>', $componentName);

		// Set toolbar icons
		JToolBarHelper::back();
		$this->renderSubmenu();
	}

	public function onAdd()
	{
		//on frontend, buttons must be added specifically
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if(!$isAdmin) return;

		$option = FOFInput::getCmd('option','com_foobar',$this->input);
		$componentName = str_replace('com_', '', $option);

		// Set toolbar title
		$subtitle_key = FOFInput::getCmd('option','com_foobar',$this->input).'_TITLE_'.strtoupper(FOFInflector::pluralize(FOFInput::getCmd('view','cpanel',$this->input))).'_EDIT';
		JToolBarHelper::title(JText::_(FOFInput::getCmd('option','com_foobar',$this->input)).' &ndash; <small>'.JText::_($subtitle_key).'</small>',$componentName);

		// Set toolbar icons
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if(version_compare(JVERSION,'1.6.0','ge')) {
			JToolBarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		} else {
			$sanTitle = 'Save & New';
			JToolBar::getInstance('toolbar')->appendButton( 'Standard', 'save', $sanTitle, 'savenew', false, false );
		}
		JToolBarHelper::cancel();
	}

	public function onEdit()
	{
		//on frontend, buttons must be added specifically
		$isAdmin = version_compare(JVERSION, '1.6.0', 'ge') ? (!JFactory::$application ? false : JFactory::getApplication()->isAdmin()) : JFactory::getApplication()->isAdmin();
		if(!$isAdmin) return;

		$this->onAdd();
	}

	/**
	 * Renders the submenu (toolbar links) for all detected views of this component
	 */
	protected function renderSubmenu()
	{
		$views = $this->getMyViews();
		if(empty($views)) return;

		$activeView = FOFInput::getCmd('view','cpanel',$this->input);

		foreach($views as $view) {
			// Get the view name
			$key = strtoupper($this->component).'_TITLE_'.strtoupper($view);
			if(strtoupper(JText::_($key)) == $key) {
				$altview = FOFInflector::isPlural($view) ? FOFInflector::singularize($view) : FOFInflector::pluralize($view);
				$key2 = strtoupper($this->component).'_TITLE_'.strtoupper($altview);
				if(strtoupper(JText::_($key2)) == $key2) {
					$name = ucfirst($view);
				} else {
					$name = JText::_($key2);
				}
			} else {
				$name = JText::_($key);
			}

			$link = 'index.php?option='.$this->component.'&view='.$view;

			$active = $view == $activeView;

			JSubMenuHelper::addEntry($name, $link, $active);
		}
	}

	/**
	 * Automatically detects all views of the component
	 *
	 * @return array
	 */
	protected function getMyViews()
	{
		$views = array();

		$app = JFactory::getApplication();
		if($app->isSite()) {
			$basePath = JPATH_SITE;
		} else {
			$basePath = JPATH_ADMINISTRATOR;
		}
		$searchPath = $basePath.'/components/'.$this->component.'/views';

		jimport('joomla.filesystem.folder');
		$allFolders = JFolder::folders($searchPath);

		if(!empty($allFolders)) foreach($allFolders as $folder) {
			$view = $folder;
			// Do we have a 'skip.xml' file in there?
			$files = JFolder::files($searchPath.'/'.$view,'^skip\.xml$');
			if(!empty($files)) continue;
			if($view != 'cpanel') {
				$view = FOFInflector::pluralize($view);
				if(!in_array($view, $views)) $views[] = $view;
			} else {
				array_unshift($views, 'cpanel');
			}
		}

		return $views;
	}
}