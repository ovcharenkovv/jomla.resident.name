<?php

/*
 * @version		$Id: view.html.php 1.2.1 2012-05-03 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2013 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class AllVideoShareViewVideos extends JView {

    function display($tpl = null) {
	    $model = $this->getModel();
		
		$data = $model->getdata();
		$this->assignRef('data', $data);
	
		$category = $model->getcategories();
		$this->assignRef('category', $category);
		
		$pagination = $model->getpagination();
		$this->assignRef('pagination', $pagination);
		
		$lists = $model->getlists();
		$this->assignRef('lists', $lists);
		
		JToolBarHelper::title(JText::_('ALL_VIDEO_SHARE'), 'allvideoshare');
		JToolBarHelper::publishList('publish', JText::_('PUBLISH'));
        JToolBarHelper::unpublishList('unpublish', JText::_('UNPUBLISH'));
        JToolBarHelper::deleteList(JText::_('ARE_YOU_SURE_WANT_TO_DELETE_SELECTED_ITEMS'),'delete', JText::_('DELETE'));
        JToolBarHelper::editList('edit', JText::_('EDIT'));
        JToolBarHelper::addNew('add', JText::_('NEW'));
		$help =& JToolBar::getInstance('toolbar');
		$help->appendButton( 'Popup', 'help', 'help', 'http://allvideoshare.mrvinoth.com/adding-a-video', 900, 500 );
		
		JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_allvideoshare');	
		JSubMenuHelper::addEntry(JText::_('PLAYERS'), 'index.php?option=com_allvideoshare&view=players');	
		JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_allvideoshare&view=categories');		
		JSubMenuHelper::addEntry(JText::_('VIDEOS'), 'index.php?option=com_allvideoshare&view=videos', true);
		JSubMenuHelper::addEntry(JText::_('APPROVAL_QUEUE'), 'index.php?option=com_allvideoshare&view=approval');
		JSubMenuHelper::addEntry(JText::_('GENERAL_CONFIGURATION'), 'index.php?option=com_allvideoshare&view=config');
		JSubMenuHelper::addEntry(JText::_('LICENSING'), 'index.php?option=com_allvideoshare&view=licensing');	
		
        parent::display($tpl);
    }
	
	function add($tpl = null) {
		$model = $this->getModel();
		
		$category = $model->getcategories();
		$this->assignRef('category', $category);
		
		JToolBarHelper::title(JText::_('ALL_VIDEO_SHARE'), 'allvideoshare');
		JToolBarHelper::save('save', JText::_('SAVE'));
        JToolBarHelper::apply('apply', JText::_('APPLY'));
        JToolBarHelper::cancel('cancel', JText::_('CANCEL'));
		$help =& JToolBar::getInstance('toolbar');
		$help->appendButton( 'Popup', 'help', 'help', 'http://allvideoshare.mrvinoth.com/adding-a-video', 900, 500 );
		
		JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_allvideoshare');	
		JSubMenuHelper::addEntry(JText::_('PLAYERS'), 'index.php?option=com_allvideoshare&view=players');	
		JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_allvideoshare&view=categories');		
		JSubMenuHelper::addEntry(JText::_('VIDEOS'), 'index.php?option=com_allvideoshare&view=videos', true);
		JSubMenuHelper::addEntry(JText::_('APPROVAL_QUEUE'), 'index.php?option=com_allvideoshare&view=approval');
		JSubMenuHelper::addEntry(JText::_('GENERAL_CONFIGURATION'), 'index.php?option=com_allvideoshare&view=config');
		JSubMenuHelper::addEntry(JText::_('LICENSING'), 'index.php?option=com_allvideoshare&view=licensing');
		
        parent::display($tpl);
    }
	
	function edit($tpl = null) {
	    $model = $this->getModel();
		
		$data = $model->getrow();
		$this->assignRef('data', $data);
	
		$category = $model->getcategories();
		$this->assignRef('category', $category);
		
		JToolBarHelper::title(JText::_('ALL_VIDEO_SHARE'), 'allvideoshare');
		JToolBarHelper::save('save', JText::_('SAVE'));
        JToolBarHelper::apply('apply', JText::_('APPLY'));
        JToolBarHelper::cancel('cancel', JText::_('CANCEL'));
		$help =& JToolBar::getInstance('toolbar');
		$help->appendButton( 'Popup', 'help', 'help', 'http://allvideoshare.mrvinoth.com/adding-a-video', 900, 500 );
		
		JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_allvideoshare');	
		JSubMenuHelper::addEntry(JText::_('PLAYERS'), 'index.php?option=com_allvideoshare&view=players');	
		JSubMenuHelper::addEntry(JText::_('CATEGORIES'), 'index.php?option=com_allvideoshare&view=categories');		
		JSubMenuHelper::addEntry(JText::_('VIDEOS'), 'index.php?option=com_allvideoshare&view=videos', true);
		JSubMenuHelper::addEntry(JText::_('APPROVAL_QUEUE'), 'index.php?option=com_allvideoshare&view=approval');
		JSubMenuHelper::addEntry(JText::_('GENERAL_CONFIGURATION'), 'index.php?option=com_allvideoshare&view=config');
		JSubMenuHelper::addEntry(JText::_('LICENSING'), 'index.php?option=com_allvideoshare&view=licensing');
		
        parent::display($tpl);
    }
	
}

?>