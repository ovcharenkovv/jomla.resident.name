<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
phocagalleryimport('phocagallery.access.access');
phocagalleryimport('phocagallery.rate.rateimage');
class PhocaGalleryControllerDetail extends PhocaGalleryController
{
	
	function display() {
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'detail' );
		}
		parent::display();
    }

	function rate() {
		$app	= JFactory::getApplication();
		$params			= &$app->getParams();
		$detailWindow	= $params->get( 'detail_window', 0 );
		
		$user 		=& JFactory::getUser();
		$view 		= JRequest::getVar( 'view', '', 'get', '', JREQUEST_NOTRIM  );
		//$id 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$imgid 		= JRequest::getVar( 'id', '', 'get', 'string', JREQUEST_NOTRIM  );
		$catid 		= JRequest::getVar( 'catid', '', 'get', 'string', JREQUEST_NOTRIM  );
		$rating		= JRequest::getVar( 'rating', '', 'get', 'string', JREQUEST_NOTRIM  );
		$Itemid		= JRequest::getVar( 'Itemid', 0, '', 'int');
	
		$neededAccessLevels	= PhocaGalleryAccess::getNeededAccessLevels();
		$access				= PhocaGalleryAccess::isAccess($user->authorisedLevels(), $neededAccessLevels);
	
		if ($detailWindow == 7) {
			$tmplCom = '';
		} else {
			$tmplCom = '&tmpl=component';
		}
		
		$post['imgid'] 		= (int)$imgid;
		$post['userid']		= $user->id;
		$post['rating']		= (int)$rating;

		$imgIdAlias 	= $imgid;
		$catIdAlias 	= $catid;		//Itemid
		if ($view != 'detail') {
			$this->setRedirect( JRoute::_('index.php?option=com_phocagallery', false) );
		}
		
		$model = $this->getModel('detail');
		
		$checkUserVote	= PhocaGalleryRateImage::checkUserVote( $post['imgid'], $post['userid'] );
		
		// User has already rated this category
	
		if ($checkUserVote) {
			$msg = JText::_('COM_PHOCAGALLERY_RATING_IMAGE_ALREADY_RATED');
		} else {
			if ((int)$post['rating']  < 1 || (int)$post['rating'] > 5) {
				
				$app->redirect( JRoute::_('index.php?option=com_phocagallery', false)  );
				exit;
			}
			
			if ($access > 0 && $user->id > 0) {
				if(!$model->rate($post)) {
				$msg = JText::_('COM_PHOCAGALLERY_ERROR_RATING_IMAGE');
				} else {
				$msg = JText::_('COM_PHOCAGALLERY_SUCCESS_RATING_IMAGE');
				} 
			} else {
				$app->redirect(JRoute::_('index.php?option=com_users&view=login', false), JText::_('COM_PHOCAGALLERY_NOT_AUTHORISED_ACTION'));
				exit;
			}
		}
		// Do not display System Message in Detail Window as there are no scrollbars, so other items will be not displayed
		// we send infor about already rated via get and this get will be worked in view (detail - default.php) - vote=1
		$msg = '';
		
		$this->setRedirect( JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$catIdAlias.'&id='.$imgIdAlias.$tmplCom.'&vote=1&Itemid='. $Itemid, false), $msg );
	}
}
?>