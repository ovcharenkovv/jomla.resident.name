<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * Controller class for Profiles Administration page
 *
 */
class AkeebaControllerProfiles extends FOFController
{
	public function  __construct($config = array()) {
		parent::__construct($config);
		// Access check, Joomla! 1.6 style.
		$user = JFactory::getUser();
		if (!$user->authorise('core.admin', 'com_akeeba')) {
			$this->setRedirect('index.php?option=com_akeeba');
			return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			$this->redirect();
		}
		$base_path = JPATH_COMPONENT_ADMINISTRATOR.'/plugins';
		$model_path = $base_path.'/models';
		$view_path = $base_path.'/views';
		$this->addModelPath($model_path);
		$this->addViewPath($view_path);
	}

	/**
	 * Copies the selected profile into a new record at the end of the list
	 *
	 */
	public function copy()
	{
		// CSRF prevention
		if($this->csrfProtection) {
			$this->_csrfProtection();
		}
		
		$model = $this->getThisModel();
		if($model->copy())
		{
			// Show a "COPY OK" message
			$message = JText::_('PROFILE_COPY_OK');
			$type = 'message';
			
			$session = JFactory::getSession();
			$session->set('profile', $model->getId(), 'akeeba');
		}
		else
		{
			// Show message on failure
			$message = JText::_('PROFILE_COPY_ERROR');
			$message .= ' ['.$model->getError().']';
			$type = 'error';
		}
		// Redirect
		$this->setRedirect('index.php?option=com_akeeba&view=profiles', $message, $type);
	}
}