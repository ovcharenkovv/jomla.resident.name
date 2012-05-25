<?php
/**
 * @package AkeebaBackup
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU General Public License version 3, or later
 *
 * @since 1.3
 */

// Protect from unauthorized access
defined('_JEXEC') or die();

/**
 * MVC View for Database Table filters
 *
 */
class AkeebaViewDbef extends FOFViewHtml
{
	public function onBrowse($tpl = null)
	{
		$model = $this->getModel();
		
		$task = $model->getState('browse_task', 'normal');

		// Add custom submenus
		JSubMenuHelper::addEntry(
			JText::_('FILTERS_LABEL_NORMALVIEW'),
			JURI::base().'index.php?option=com_akeeba&view=dbef&task=normal',
			($task == 'normal')
		);
		JSubMenuHelper::addEntry(
			JText::_('FILTERS_LABEL_TABULARVIEW'),
			JURI::base().'index.php?option=com_akeeba&view=dbef&task=tabular',
			($task == 'tabular')
		);

		// Add references to scripts and CSS
		AkeebaHelperIncludes::includeMedia(false);
		$media_folder = JURI::base().'../media/com_akeeba/';

		// Get the root URI for media files
		$this->assign( 'mediadir', AkeebaHelperEscape::escapeJS($media_folder.'theme/') );

		// Get a JSON representation of the available roots
		$model = $this->getModel();
		$root_info = $model->get_roots();
		$roots = array();
		if(!empty($root_info))
		{
			// Loop all dir definitions
			foreach($root_info as $def)
			{
				$roots[] = $def->value;
				$options[] = JHTML::_('select.option', $def->value, $def->text );
			}
		}
		$site_root = '[SITEDB]';
		$attribs = 'onchange="akeeba_active_root_changed();"';
		$this->assign('root_select', JHTML::_('select.genericlist', $options, 'root', $attribs, 'value', 'text', $site_root, 'active_root') );
		$this->assign('roots', $roots);

		switch($task)
		{
			case 'normal':
			default:
				$this->setLayout('default');

				// Get a JSON representation of the database data
				$model = $this->getModel();
				$json = json_encode($model->make_listing($site_root));
				$this->assignRef( 'json', $json );
				break;

			case 'tabular':
				$this->setLayout('tabular');

				// Get a JSON representation of the tabular filter data
				$model = $this->getModel();
				$json = json_encode( $model->get_filters($site_root) );
				$this->assignRef( 'json', $json );

				break;
		}

		// Add live help
		AkeebaHelperIncludes::addHelp('dbef');

		// Get profile ID
		$profileid = AEPlatform::getInstance()->get_active_profile();
		$this->assign('profileid', $profileid);

		// Get profile name
		if(!class_exists('AkeebaModelProfiles')) JLoader::import('models.profiles', JPATH_COMPONENT_ADMINISTRATOR);
		$model = new AkeebaModelProfiles();
		$model->setId($profileid);
		$profile_data = $model->getProfile();
		$this->assign('profilename', $profile_data->description);

		return true;
	}
}