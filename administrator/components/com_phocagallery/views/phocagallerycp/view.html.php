<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );
phocagalleryimport( 'phocagallery.render.renderinfo' );

class PhocaGalleryCpViewPhocaGallerycp extends JView
{
	public function display($tpl = null) {
		
		$tmpl = array();
		JHtml::stylesheet( 'administrator/components/com_phocagallery/assets/phocagallery.css' );
		//JHTML::_('behavior.tooltip');
		$tmpl['version'] = PhocaGalleryRenderInfo::getPhocaVersion();
		
		$this->assignRef('tmpl',	$tmpl);
		$this->addToolbar();
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'phocagallerycp.php';

		$state	= $this->get('State');
		$canDo	= PhocaGalleryCpHelper::getActions();
		JToolBarHelper::title( JText::_( 'COM_PHOCAGALLERY_PG_CONTROL_PANEL' ), 'phoca.png' );
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_phocagallery');
			JToolBarHelper::divider();
		}
		
		JToolBarHelper::help( 'screen.phocagallery', true );
	}
}
?>