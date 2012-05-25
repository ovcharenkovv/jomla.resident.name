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
defined( '_JEXEC' ) or die( 'Restricted access' );
if (is_file( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'phocagallery'.DS.'facebook'.DS.'api.php')) {
	require_once(  JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phocagallery'.DS.'libraries'.DS.'phocagallery'.DS.'facebook'.DS.'api.php');
}

class PhocaGalleryFb
{
	private static $fb = array();
	
	private function __construct(){}

	public static function getAppInstance($appid, $appsid) {
	
		if( !array_key_exists( $appid, self::$fb ) ) {
			$facebook = new Facebook(array(
			  'appId'  => $appid,
			  'secret' => $appsid,
			  'cookie' => false,
			));
			
			self::$fb[$appid] = $facebook;
		}
		return self::$fb[$appid];
	}
	
	public static function getFbStatus($appid, $appsid) {
	
		$facebook 	= self::getAppInstance($appid, $appsid);

		$session	= $facebook->getSession();
		
		$output = array();
		
		$u = null;
		// Session based API call.
		if ($session) {
		  try {
			$uid = $facebook->getUser();
			$u = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
			error_log($e);
		  }
		}

		// login or logout url will be needed depending on current user state.
		if ($u) {
			$logoutUrl = $facebook->getLogoutUrl();
		
			$output['log']	= 1;
			$output['html'] = '<div><img src="https://graph.facebook.com/'.  $uid .'/picture" /></div>';
			$output['html'] .= '<div>'. $u['name'].'</div>';
			$output['html'] .= '<div><a href="'. $logoutUrl .'"><img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif" /></a></div>';
			
			/*
			$script = array();
			$fields = array('name', 'uid', 'base_domain', 'secret', 'session_key', 'access_token', 'sig');
			$script[] = 'function clearFbFields() {';
			foreach ($fields as $field) {
				$script[] = ' document.getElementById(\'jform_'.$field.'\').value = \'\';';
			}
			$script[] = '}';

			// Add the script to the document head.
			JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
			$uri = JURI::getInstance();
			$loginUrl = $facebook->getLoginUrl(array('req_perms' => 'user_photos,user_groups,offline_access,publish_stream', 'cancel_url' => $uri->toString(), 'next' => $uri->toString()));
			
			$output['log']	= 0;
			$output['html'] .= '<div><a onclick="clearFbFields()" href="'. $loginUrl .'">Clear and Fill data bu</a></div>';*/
			
		} else {
			$uri = JURI::getInstance();
		
			$loginUrl = $facebook->getLoginUrl(array('req_perms' => 'user_photos,user_groups,offline_access,publish_stream', 'cancel_url' => $uri->toString(), 'next' => $uri->toString()));
			
			$output['log']	= 0;
			$output['html'] = '<div><a href="'. $loginUrl .'"><img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" /></a></div>';
	
		}
		$output['u']		= $u;
		$output['session'] 	= $session;
		
		
		return $output;
	}
	
	public function getFbAlbums ($appid, $appidfanpage, $appsid, $session, $aid = 0) {
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);
		
		// Change the uid to fan page id => Fan PAGE has other UID
		$userID = $newUID = $session['uid'];
		if (isset($appidfanpage) && $appidfanpage != '') {
			$newUID 	= $appidfanpage;
		}

		if ($aid > 0) {
			$albums = $facebook->api(array('method' => 'photos.getAlbums', 'aids' => $aid));
		} else {
			$albums = $facebook->api(array('method' => 'photos.getAlbums', 'uid' => $newUID));
			//$albums = $facebook->api(array('method' => 'photos.getAlbums'));
		}
		return $albums;
	}
	
	/* BY ID
	public function getFbAlbumsFan ($appid, $appsid, $session, $id = 0) {
		
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);
		$albums 	= false;
		$userID 	= $session['uid'];

		if ($aid > 0) {
			$albums = $facebook->api('/' . $userID . '/albums');
		} else {
			$albums = $facebook->api('/' . $userID . '/albums');
		}
		return $albums['data'];
	}*/
	
	
	 public function getFbAlbumName ($appid, $appsid, $session, $aid) {
		
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);

		$album = $facebook->api(array('method' => 'photos.getAlbums', 'aids' => $aid));
		
		$albumName 	= '';
		//$userID 	= $session['uid'];
		if (isset($album[0]['object_id']) && $album[0]['object_id'] != '') {
			$album = $facebook->api('/' . $album[0]['object_id']);
            $albumName = $album['name'];
		}

		return $albumName;
	}
	
	public static function getFbImages ($appid, $appsid, $session, $aid = 0) {
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);
		$images 	= false;
		if ($aid > 0) {
			$images = $facebook->api(array('method' => 'photos.get', 'aid' => $aid));
		}
		
		return $images;
	}
	
	/* BY ID
	public static function getFbImagesFan ($appid, $appsid, $session, $id = 0) {
		
		
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);
		$images 	= false;
		if ($id > 0) {
            $imagesFolder = $facebook->api('/' . $id . '/photos?limit=0');
			$images = $imagesFolder['data'];
		}
		return $images;
	}*/
	
	public static function exportFbImage ($appid, $appidfanpage, $appsid, $session, $image, $aid = 0) {
		
		
		$facebook 	= self::getAppInstance($appid, $appsid, $session);
		$facebook->setSession($session);	
		$facebook->setFileUploadSupport(true);
		
		// Change the uid to fan page id => Fan PAGE has other UID
		$userID = $newUID = $session['uid'];
		if (isset($appidfanpage) && $appidfanpage != '') {
			$newUID 	= $appidfanpage;
		}
		
		if ($aid > 0) {
			$export = $facebook->api(array('method' => 'photos.upload', 'aid' => $aid, 'uid' => $newUID, 'caption' => $image['caption'], $image['filename'] => '@'.$image['fileorigabs']));
			
			return $export;
		}
		return false;
	}
	
	public final function __clone() {
		JError::raiseWarning(500, 'Function Error: Cannot clone instance of Singleton pattern');// No JText - for developers only
		return false;
	}
}