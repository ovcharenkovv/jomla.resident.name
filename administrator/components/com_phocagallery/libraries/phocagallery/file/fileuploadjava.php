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

class PhocaGalleryFileUploadJava
{
	public $returnUrl;
	public $url;
	public $source;
	public $height;
	public $width;
	public $resizeheight;
	public $resizewidth;
	public $uploadmaxsize;

	public function __construct() {}
	
	public function getJavaUploadHTML() {
		
		$html = '<!--[if !IE]> -->'
.'<object classid="java:wjhk.jupload2.JUploadApplet" type="application/x-java-applet"'
.' archive="'. $this->source.'" height="'.$this->height.'" width="'.$this->width.'" >'
.'<param name="archive" value="'. $this->source.'" />'
.'<param name="postURL" value="'. $this->url.'"/>'
.'<param name="afterUploadURL" value="'. $this->returnUrl.'"/>'
.'<param name="allowedFileExtensions" value="jpg/gif/png/" />'		            
.'<param name="uploadPolicy" value="PictureUploadPolicy" />'            
.'<param name="nbFilesPerRequest" value="1" />'
.'<param name="maxPicHeight" value="'. $this->resizeheight .'" />'
.'<param name="maxPicWidth" value="'. $this->resizewidth .'" />'
.'<param name="maxFileSize" value="'. $this->uploadmaxsize .'" />'	
.'<param name="pictureTransmitMetadata" value="true" />'
.'<param name="showLogWindow" value="false" />'
.'<param name="showStatusBar" value="false" />'
.'<param name="pictureCompressionQuality" value="1" />'
.'<param name="lookAndFeel"  value="system"/>'
.'<!--<![endif]-->'
.'<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/update/1.5.0/jinstall-1_5_0-windows-i586.cab"'
.' height="'.$this->height.'" width="'.$this->width.'" >'
.'<param name="code" value="wjhk.jupload2.JUploadApplet" />'
.'<param name="archive" value="'. $this->source .'" />'
.'<param name="postURL" value="'. $this->url .'"/>'
.'<param name="afterUploadURL" value="'. $this->returnUrl.'"/>'
.'<param name="allowedFileExtensions" value="jpg/gif/png" />'	            
.'<param name="uploadPolicy" value="PictureUploadPolicy" /> '          
.'<param name="nbFilesPerRequest" value="1" />'
.'<param name="maxPicHeight" value="'. $this->resizeheight .'" />'
.'<param name="maxPicWidth" value="'. $this->resizewidth .'" />'
.'<param name="maxFileSize" value="'. $this->uploadmaxsize .'" />'	
.'<param name="pictureTransmitMetadata" value="true" />'
.'<param name="showLogWindow" value="false" />'
.'<param name="showStatusBar" value="false" />'
.'<param name="pictureCompressionQuality" value="1" />'
.'<param name="lookAndFeel"  value="system"/>' 
.'<div style="color:#cc0000">'.JText::_('COM_PHOCAGALLERY_JAVA_PLUGIN_MUST_BE_ENABLED').'</div>'
.'</object>'
.'<!--[if !IE]> -->'
.'</object>'
.'<!--<![endif]-->'
.'</fieldset>';
		
		return $html;
		
	}
}
?>