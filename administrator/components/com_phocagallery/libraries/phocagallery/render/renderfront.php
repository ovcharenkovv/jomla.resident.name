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
defined( '_JEXEC' ) or die( 'Restricted access' );

class PhocaGalleryRenderFront
{
	// hotnew
	function getOverImageIcons($date, $hits) {
		$app	= JFactory::getApplication();
		$params = $app->getParams();
		$new	= $params->get( 'display_new', 0 );
		$hot	= $params->get( 'display_hot', 0 );
		
		
		$output = '';
		if ($new == 0) {
			$output .= '';
		} else {
			$dateAdded 	= strtotime($date, time());
			$dateToday 	= time();
			$dateExists = $dateToday - $dateAdded;
			$dateNew	= (int)$new * 24 * 60 * 60;
			if ($dateExists < $dateNew) {
				$output .= JHTML::_('image', 'components/com_phocagallery/assets/images/icon-new.png', '', array('class' => 'pg-img-ovr1'));
			}
		}
		if ($hot == 0) {
			$output .='';
		} else {
			if ((int)$hot <= $hits) {
				if ($output == '') {
					$output .= JHTML::_('image', 'components/com_phocagallery/assets/images/icon-hot.png', '', array('class' => 'pg-img-ovr1'));
				} else {
					$output .= JHTML::_('image', 'components/com_phocagallery/assets/images/icon-hot.png', '', array('class' => 'pg-img-ovr2'));
				}
			}
		}
		return $output;
	}
	
	function renderCommentJS($chars) {
		
		$tag = "<script type=\"text/javascript\">" 
		."function countChars() {" . "\n"
		."var maxCount	= ".$chars.";" . "\n"
		."var pfc 			= document.getElementById('phocagallery-comments-form');" . "\n"
		."var charIn		= pfc.phocagallerycommentseditor.value.length;" . "\n"
		."var charLeft	= maxCount - charIn;" . "\n"
		."" . "\n"
		."if (charLeft < 0) {" . "\n"
		."   alert('".JText::_('COM_PHOCAGALLERY_MAX_LIMIT_CHARS_REACHED')."');" . "\n"
		."   pfc.phocagallerycommentseditor.value = pfc.phocagallerycommentseditor.value.substring(0, maxCount);" . "\n"
		."	charIn	 = maxCount;" . "\n"
		."  charLeft = 0;" . "\n"
		."}" . "\n"
		."pfc.phocagallerycommentscountin.value	= charIn;" . "\n"
		."pfc.phocagallerycommentscountleft.value	= charLeft;" . "\n"
		."}" . "\n"
		
		."function checkCommentsForm() {" . "\n"
		."   var pfc = document.getElementById('phocagallery-comments-form');" . "\n"
		."   if ( pfc.phocagallerycommentstitle.value == '' ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_TITLE' )."');". "\n"
		."     return false;" . "\n"
		."   } else if ( pfc.phocagallerycommentseditor.value == '' ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_COMMENT' )."');". "\n"
		."     return false;" . "\n"
		."   } else {". "\n"
		."     return true;" . "\n"
		."   }" . "\n"
		."}". "\n"
		."</script>";
		
		return $tag;
	}
	
	function renderCategoryCSS($font_color, $background_color, $border_color, $imageBgCSS,$imageBgCSSIE, $border_color_hover, $background_color_hover, $ol_fg_color, $ol_bg_color, $ol_tf_color, $ol_cf_color, $margin_box, $padding_box, $opacity = 0.8) {
		
		$opacityPer = (float)$opacity * 100;
		
		$tag = "<style type=\"text/css\">\n"
		." #phocagallery .pg-name {color: $font_color ;}\n"
		." .phocagallery-box-file {background: $background_color ; border:1px solid $border_color;margin: ".$margin_box."px;padding: ".$padding_box."px; }\n"
		." .phocagallery-box-file-first { $imageBgCSS }\n"
		." .phocagallery-box-file:hover, .phocagallery-box-file.hover {border:1px solid $border_color_hover ; background: $background_color_hover ;}\n"
		/*
		." .ol-foreground { background-color: $ol_fg_color ;}\n"
		." .ol-background { background-color: $ol_bg_color ;}\n"
		." .ol-textfont { font-family: Arial, sans-serif; font-size: 10px; color: $ol_tf_color ;}"
		." .ol-captionfont {font-family: Arial, sans-serif; font-size: 12px; color: $ol_cf_color ; font-weight: bold;}"*/
		
		. ".bgPhocaClass{
			background:".$ol_bg_color.";
			filter:alpha(opacity=".$opacityPer.");
			opacity: ".$opacity.";
			-moz-opacity:".$opacity.";
			z-index:1000;
			}
			.fgPhocaClass{
			background:".$ol_fg_color.";
			filter:alpha(opacity=100);
			opacity: 1;
			-moz-opacity:1;
			z-index:1000;
			}
			.fontPhocaClass{
			color:".$ol_tf_color.";
			z-index:1001;
			}
			.capfontPhocaClass, .capfontclosePhocaClass{
			color:".$ol_cf_color.";
			font-weight:bold;
			z-index:1001;
			}"
		." </style>\n"
		.'<!--[if lt IE 8]>' . "\n" 
		. '<style type="text/css">' . "\n"
		." .phocagallery-box-file-first { $imageBgCSSIE }\n"
		.' </style>'. "\n" .'<![endif]-->';
		
		return $tag;
	}
	
	function renderIeHover() {
		
		$tag = '<!--[if lt IE 7]>' . "\n" . '<style type="text/css">' . "\n"
		.'.phocagallery-box-file{' . "\n"
		.' background-color: expression(isNaN(this.js)?(this.js=1, '
		.'this.onmouseover=new Function("this.className+=\' hover\';"), ' ."\n"
		.'this.onmouseout=new Function("this.className=this.className.replace(\' hover\',\'\');")):false););
}' . "\n"
		.' </style>'. "\n" .'<![endif]-->';
		
		return $tag;
		
	}
	
	function renderPicLens($categoryId) {
		$tag ="<link id=\"phocagallerypiclens\" rel=\"alternate\" href=\""
		.JURI::base(true)."/images/phocagallery/"
		.$categoryId.".rss\" type=\"application/rss+xml\" title=\"\" />"
	    ."<script type=\"text/javascript\" src=\"http://lite.piclens.com/current/piclens.js\"></script>"
		
		."<style type=\"text/css\">\n"
		." .mbf-item { display: none; }\n"
		." #phocagallery .mbf-item { display: none; }\n"
		." </style>\n";
		return $tag;
	
	}
	
	function renderOnUploadJS() {
		
		$tag = "<script type=\"text/javascript\"> \n"
		. "function OnUploadSubmitUserPG() { \n"
		. "document.getElementById('loading-label-user').style.display='block'; \n" 
		. "return true; \n"
		. "} \n"
		. "function OnUploadSubmitPG(idLoad) { \n"
		."  if ( document.getElementById('filter_catid_image').value < 1 ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_PLEASE_SELECT_CATEGORY' )."');". "\n"
		."     return false;" . "\n"
		. "} \n"
		. "document.getElementById(idLoad).style.display='block'; \n" 
		. "return true; \n"
		. "} \n"
		. "</script>";
		return $tag;
	}
	
	function renderOnUploadCategoryJS() {
		
		$tag = "<script type=\"text/javascript\"> \n"
		. "function OnUploadSubmitCategoryPG(idLoad) { \n"
		. "document.getElementById(idLoad).style.display='block'; \n" 
		. "return true; \n"
		. "} \n"
		. "</script>";
		return $tag;
	}
	
	function renderDescriptionUploadJS($chars) {
		
		$tag = "<script type=\"text/javascript\"> \n"
		//. "function OnUploadSubmit() { \n"
		//. "document.getElementById('loading-label').style.display='block'; \n" 
		//. "return true; \n"
		//. "} \n"
		."function countCharsUpload(id) {" . "\n"
		."var maxCount	= ".$chars.";" . "\n"
		."var pfu 			= document.getElementById(id);" . "\n"
		."var charIn		= pfu.phocagalleryuploaddescription.value.length;" . "\n"
		."var charLeft	= maxCount - charIn;" . "\n"
		."" . "\n"
		."if (charLeft < 0) {" . "\n"
		."   alert('".JText::_('COM_PHOCAGALLERY_MAX_LIMIT_CHARS_REACHED')."');" . "\n"
		."   pfu.phocagalleryuploaddescription.value = pfu.phocagalleryuploaddescription.value.substring(0, maxCount);" . "\n"
		."	charIn	 = maxCount;" . "\n"
		."  charLeft = 0;" . "\n"
		."}" . "\n"
		."pfu.phocagalleryuploadcountin.value	= charIn;" . "\n"
		."pfu.phocagalleryuploadcountleft.value	= charLeft;" . "\n"
		."}" . "\n"
		. "</script>";
		
		return $tag;
	}
	
	function renderDescriptionCreateCatJS($chars) {
		
		$tag = "<script type=\"text/javascript\"> \n"
		."function countCharsCreateCat() {" . "\n"
		."var maxCount	= ".$chars.";" . "\n"
		."var pfcc 			= document.getElementById('phocagallery-create-cat-form');" . "\n"
		."var charIn		= pfcc.phocagallerycreatecatdescription.value.length;" . "\n"
		."var charLeft	= maxCount - charIn;" . "\n"
		."" . "\n"
		."if (charLeft < 0) {" . "\n"
		."   alert('".JText::_('COM_PHOCAGALLERY_MAX_LIMIT_CHARS_REACHED')."');" . "\n"
		."   pfcc.phocagallerycreatecatdescription.value = pfcc.phocagallerycreatecatdescription.value.substring(0, maxCount);" . "\n"
		."	charIn	 = maxCount;" . "\n"
		."  charLeft = 0;" . "\n"
		."}" . "\n"
		."pfcc.phocagallerycreatecatcountin.value	= charIn;" . "\n"
		."pfcc.phocagallerycreatecatcountleft.value	= charLeft;" . "\n"
		."}" . "\n"
		
		."function checkCreateCatForm() {" . "\n"
		."   var pfcc = document.getElementById('phocagallery-create-cat-form');" . "\n"
		."   if ( pfcc.categoryname.value == '' ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_TITLE' )."');". "\n"
		."     return false;" . "\n"
		//."   } else if ( pfcc.phocagallerycreatecatdescription.value == '' ) {". "\n"
		//."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_DESCRIPTION' )."');". "\n"
		//."     return false;" . "\n"
		."   } else {". "\n"
		."     return true;" . "\n"
		."   }" . "\n"
		."}". "\n"
		. "</script>";
		
		return $tag;
	}
	
	function renderDescriptionCreateSubCatJS($chars) {
		
		$tag = "<script type=\"text/javascript\"> \n"
		."function countCharsCreateSubCat() {" . "\n"
		."var maxCount	= ".$chars.";" . "\n"
		."var pfcc 			= document.getElementById('phocagallery-create-subcat-form');" . "\n"
		."var charIn		= pfcc.phocagallerycreatesubcatdescription.value.length;" . "\n"
		."var charLeft	= maxCount - charIn;" . "\n"
		."" . "\n"
		."if (charLeft < 0) {" . "\n"
		."   alert('".JText::_('COM_PHOCAGALLERY_MAX_LIMIT_CHARS_REACHED')."');" . "\n"
		."   pfcc.phocagallerycreatesubcatdescription.value = pfcc.phocagallerycreatesubcatdescription.value.substring(0, maxCount);" . "\n"
		."	charIn	 = maxCount;" . "\n"
		."  charLeft = 0;" . "\n"
		."}" . "\n"
		."pfcc.phocagallerycreatesubcatcountin.value	= charIn;" . "\n"
		."pfcc.phocagallerycreatesubcatcountleft.value	= charLeft;" . "\n"
		."}" . "\n"
		
		."function checkCreateSubCatForm() {" . "\n"
		."   var pfcc = document.getElementById('phocagallery-create-subcat-form');" . "\n"
		."   if ( pfcc.subcategoryname.value == '' ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_TITLE' )."');". "\n"
		."     return false;" . "\n"
		//."   } else if ( pfcc.phocagallerycreatecatdescription.value == '' ) {". "\n"
		//."	   alert('". JText::_( 'COM_PHOCAGALLERY_ENTER_DESCRIPTION' )."');". "\n"
		//."     return false;" . "\n"
		."   } else if ( document.getElementById('filter_catid_subcat').value < 1 ) {". "\n"
		."	   alert('". JText::_( 'COM_PHOCAGALLERY_PLEASE_SELECT_CATEGORY' )."');". "\n"
		."     return false;" . "\n"
		
		
		."   } else {". "\n"
		."     return true;" . "\n"
		."   }" . "\n"
		."}". "\n"
		. "</script>";
		
		return $tag;
	}
	
	function renderHighslideJSAll() {
		
		$tag = '<script type="text/javascript">'
		.'//<![CDATA[' ."\n"
		.' hs.graphicsDir = \''.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/graphics/\';'
		.'//]]>'."\n"
		.'</script>'."\n";
		
		return $tag;
	}
	
	/*
	*	@return		code snippet to insert into the onClick javascript routine of an image calling highslide
	*	@author	modified by Kay Messerschmidt
	*	@param	integer		slideShowGroup		if there are several plugin instances creating slideshows at one single web-page this enables the group support of highslide
	*	@see http://highslide.com/ref/hs.slideshowGroup and http://highslide.com/ref/hs.addslideShow
	*/

	function renderHighslideJSImage($type, $highslide_class = '',$highslide_outline_type = 'rounded-white', $highslide_opacity = 0, $highslide_fullimg = 0, $slideShowGroup = 0) {
	
		if ($type == 'li')  {
			$typeOutput = 'groupLI';
		} else if ($type == 'pm')  {
			$typeOutput = 'groupPM';
		} else if ($type == 'ri' ){
			$typeOutput = 'groupRI';
		} else if ($type == 'pl' ){
			$typeOutput = 'groupPl';
		} else {
			$typeOutput = 'groupC';
		}

		$code = 'return hs.expand(this, {'
		//.'autoplay:\'true\','
		.' slideshowGroup: \''.$typeOutput.$slideShowGroup.'\', ';
		if ($highslide_fullimg  == 1) {
			$code .= ' src: \'[phocahsfullimg]\',';
		}

		$code .= ' wrapperClassName: \''.$highslide_class.'\',';
		if ($highslide_outline_type != 'none') {
			$code .= ' outlineType : \''.$highslide_outline_type.'\',';
		}
		$code .= ' dimmingOpacity: '.$highslide_opacity.', '
		.' align : \'center\', '
		.' transitions : [\'expand\', \'crossfade\'],'
		.' fadeInOut: true'
		.' });';
		return $code;
	}
	
	/*
	*	@author	modified by Kay Messerschmidt
	*	@param	integer		slideShowGroup		if there are several plugin instances creating slideshows at one single web-page this enables the group support of highslide
	*	@see		http://highslide.com/ref/hs.slideshowGroup and http://highslide.com/ref/hs.addslideShow
	*/
	function renderHighslideJS($type, $front_modal_box_width, $front_modal_box_height, $slideshow = 0, $highslide_class = '',$highslide_outline_type = 'rounded-white', $highslide_opacity = 0, $highslide_close_button = 0, $slideShowGroup = 0) {	
		
		if ($type == 'li')  {
			$typeOutput = 'groupLI';
			$varImage	= 'phocaImageLI';
			$varZoom	= 'phocaZoomLI';
		} else if ($type == 'pm')  {
			$typeOutput = 'groupPM';
			$varImage	= 'phocaImagePM';
			$varZoom	= 'phocaZoomPM';
		} else if ($type == 'ri' ){
			$typeOutput = 'groupRI';
			$varImage	= 'phocaImageRI';
			$varZoom	= 'phocaZoomRI';
		} else if ($type == 'pl' ){
			$typeOutput = 'groupPl';
			$varImage	= 'phocaImagePl';
			$varZoom	= 'phocaZoomPl';
		} else {
			$typeOutput = 'groupC';
			$varImage	= 'phocaImage';
			$varZoom	= 'phocaZoom';
		}
		
		$tag = '<script type="text/javascript">'
		.'//<![CDATA[' ."\n"
		.' var '.$varZoom.' = { '."\n"
		.' objectLoadTime : \'after\',';
		if ($highslide_outline_type != 'none') {
			$tag .= ' outlineType : \''.$highslide_outline_type.'\',';
		}
		$tag .= ' wrapperClassName: \''.$highslide_class.'\','
		.' outlineWhileAnimating : true,'
		.' enableKeyListener : false,'
		.' minWidth : '.$front_modal_box_width.','
		.' minHeight : '.$front_modal_box_height.','
		.' dimmingOpacity: '.$highslide_opacity.', '
		.' fadeInOut : true,'
		.' contentId: \'detail\','
		.' objectType: \'iframe\','
		.' objectWidth: '.$front_modal_box_width.','
		.' objectHeight: '.$front_modal_box_height.''
		.' };';

		if ($highslide_close_button == 1) {
			$tag .= 'hs.registerOverlay({
			html: \'<div class=\u0022closebutton\u0022 onclick=\u0022return hs.close(this)\u0022 title=\u0022Close\u0022></div>\',
			position: \'top right\',
			fade: 2
		});';
		}

		switch ($slideshow) {
			case 1:
				$tag .= ' if (hs.addSlideshow) hs.addSlideshow({ '."\n"
				.'  slideshowGroup: \''.$typeOutput.$slideShowGroup.'\','."\n"
				.'  interval: 5000,'."\n"
				.'  repeat: false,'."\n"
				.'  useControls: true,'."\n"
				.'  fixedControls: true,'."\n"
				.'    overlayOptions: {'."\n"
				.'      opacity: 1,'."\n"
				.'     	position: \'top center\','."\n"
				.'     	hideOnMouseOut: true'."\n"	
				.'	  }'."\n"
				.' });'."\n";
			break;
			
			case 2:
				$tag .=' if (hs.addSlideshow) hs.addSlideshow({'."\n"
				.'slideshowGroup: \''.$typeOutput.$slideShowGroup.'\','."\n"
				.'interval: 5000,'."\n"
				.'repeat: false,'."\n"
				.'useControls: true,'."\n"
				.'fixedControls: \'true\','."\n"
				.'overlayOptions: {'."\n"
				.'  className: \'text-controls\','."\n"
				.'	position: \'bottom center\','."\n"
				.'	relativeTo: \'viewport\','."\n"
				.'	offsetY: -60'."\n"
				.'},'."\n"
				.'thumbstrip: {'."\n"
				.'	position: \'bottom center\','."\n"
				.'	mode: \'horizontal\','."\n"
				.'	relativeTo: \'viewport\''."\n"
				.'}'."\n"
				.'});'."\n";

			case 0:
			Default:
			break;
		}

		$tag .= '//]]>'."\n"
		.'</script>'."\n";
		  
		return $tag;
	}
	
	
	/**
	 * Method to get the Javascript for switching images
	 * @param string $waitImage Image which will be displayed as while loading
	 * @return string Switch image javascript
	 */
	function switchImage($waitImage) {	
		$js  = "\t". '<script language="javascript" type="text/javascript">'."\n".'var pcid = 0;'."\n"
		     . 'var waitImage = new Image();' . "\n"
			 . 'waitImage.src = \''.$waitImage.'\';' . "\n";
			/*
			if ((int)$customWidth > 0) {
				$js .= 'waitImage.width = '.$customWidth.';' . "\n";
			}
			if ((int)$customHeight > 0) {
				$js .= 'waitImage.height = '.$customHeight.';' . "\n";
			}*/
			 $js.= 'function PhocaGallerySwitchImage(imageElementId, imageSrcUrl, width, height)' . "\n"
			 . '{ ' . "\n"
			 . "\t".'var imageElement 	= document.getElementById(imageElementId);'
			 . "\t".'var imageElement2 	= document.getElementById(imageElementId);'
			 . "\t".'if (imageElement && imageElement.src)' . "\n"
			 . "\t".'{' . "\n"
			 . "\t"."\t".'imageElement.src = \'\';' . "\n"
			 . "\t".'}'. "\n"
			 . "\t".'if (imageElement2 && imageElement2.src)' . "\n"
			 
			 . "\t"."\t".'imageElement2.src = imageSrcUrl;' . "\n"
			 . "\t"."\t".'if (width > 0) {imageElement2.width = width;}' . "\n"
			 . "\t"."\t".'if (height > 0) {imageElement2.height = height;}' . "\n"
			 
			 . '}'. "\n"
			 . 'function _PhocaGalleryVoid(){}'. "\n"
			 . '</script>' . "\n";
			
		return $js;
	}
	
	function renderJakJs($slideshowDelay = 5, $orientation = 'None', $name = 'optgjaks') {
		$js  = "\t". '<script language="javascript" type="text/javascript">'."\n"
		.'var '.$name.' = {'
		.'galleryClassName: \'lightBox\','
		.'zIndex: 10,'
		.'useShadow: true,'
		.'imagePath: \''.JURI::base(true).'/components/com_phocagallery/assets/js/jak/img/shadow-\','
		.'usePageShader: true,'
		.'components: {';
		
		if ($orientation == 'None') {
			$js .= 'strip: SZN.LightBox.Strip,';
		} else {
			$js .= 'strip: SZN.LightBox.Strip.Scrollable,';
		}
 		$js .=	'navigation: SZN.LightBox.Navigation.Basic,
 			anchorage: SZN.LightBox.Anchorage.Fixed,
 			main: SZN.LightBox.Main.CenteredScaled,
 			description: SZN.LightBox.Description.Basic,
			transition: SZN.LightBox.Transition.Fade,
 			others: [
 				{name: \'slideshow\', part: SZN.SlideShow, setting: {duration: '.(int)$slideshowDelay.', autoplay: false}}
			 ]
		 },';
		
		if ($orientation != 'None') {
			$js .= 'stripOpt : {
				activeBorder : \'outer\',
				orientation : \''.$orientation.'\'
			},';
		}
		
		$js .= 'navigationOpt : {
			continuous: false,
			showDisabled: true
		},'
		
		.'transitionOpt: {
			interval: 500,
			overlap: 0.5
		}'
		.'}'
		. '</script>' . "\n";
		return $js;
	}
	
	function userTabOrdering() {	
		$js  = "\t". '<script language="javascript" type="text/javascript">'."\n"
			 . 'function tableOrdering( order, dir, task )' . "\n"
			 . '{ ' . "\n"
			 . "\t".'if (task == "subcategory") {'. "\n"
			 . "\t"."\t".'var form = document.phocagallerysubcatform;' . "\n"
			 . "\t".'form.filter_order_subcat.value 	= order;' . "\n"
			 . "\t".'form.filter_order_Dir_subcat.value	= dir;' . "\n"
			 . "\t".'document.phocagallerysubcatform.submit();' . "\n"
			 . "\t".'} else {'. "\n"
			 . "\t"."\t".'var form = document.phocagalleryimageform;' . "\n"
			 . "\t".'form.filter_order_image.value 		= order;' . "\n"
			 . "\t".'form.filter_order_Dir_image.value	= dir;' . "\n"
			 . "\t".'document.phocagalleryimageform.submit();' . "\n"
			 . "\t".'}'. "\n"
			 . '}'. "\n"
			 . '</script>' . "\n";
			
		return $js;
	}
	
	function saveOrderUserJS() {
		$js  = '<script language="javascript" type="text/javascript">'."\n"
			.'function saveordersubcat(task){'. "\n"
			."\t".'document.phocagallerysubcatform.task.value=\'saveordersubcat\';'. "\n"
			."\t".'document.phocagallerysubcatform.submit();'. "\n"
			.'}'
			.'function saveorderimage(task){'. "\n"
			."\t".'document.phocagalleryimageform.task.value=\'saveorderimage\';'. "\n"
			."\t".'document.phocagalleryimageform.submit();'. "\n"
			.'}'
			.'</script>' . "\n";
		return $js;
	}
	
	function getAltValue($altValue = 0, $title = '', $description = '', $metaDesc = '') {
		$output = '';
		switch ($altValue) {
			case 1:
				$output = $title;
			break;
			case 2:
				$output = strip_tags($description);
			break;
			case 3: 
				$output = $title;
				if ($description != '') {
					$output .= ' - '. strip_tags($description);
				}
			break;
			case 4:
				$output = strip_tags($metaDesc);
			break;
			case 5:
				if ($title != '') {
					$output = $title;
				} else if ($description != '') {
					$output = strip_tags($description);
				} else {
					$output = strip_tags($metaDesc);
				}
			break;
			case 6:
				if ($description != '') {
					$output = strip_tags($description);
				} else if ($title != '') {
					$output = $title;
				} else {
					$output = strip_tags($metaDesc);
				}
			break;
			case 7:
				if ($description != '') {
					$output = strip_tags($description);
				} else if ($metaDesc != '') {
					$output = strip_tags($metaDesc);
				} else {
					$output = $title;
				}
			break;
			case 8:
				if ($metaDesc != '') {
					$output = strip_tags($metaDesc);
				} else if ($title != '') {
					$output = $title;
				} else {
					$output = strip_tags($description);
				}
			break;
			case 9:
				if ($metaDesc != '') {
					$output = strip_tags($metaDesc);
				} else if ($description != '') { 
					$output = strip_tags($description);
				} else {
					$output = $title;
				}
			break;
			
			case 0:
			Default:
				$output = '';
			break;
		}
		return htmlspecialchars( addslashes($output));
	}
	
	function renderCloseReloadDetail($detailWindow, $type = 0) {
		$o = array();
		
		if ($detailWindow == 1) {
			$output['detailwindowclose']	= 'window.close();';
			$output['detailwindowreload']	= 'window.location.reload(true);';
			$closeLink = '<div><a href="javascript:void(0);" onclick="'.$output['detailwindowclose'].'" >'.JText::_('COM_PHOCAGALLERY_CLOSE_WINDOW').'</a></div>';
		// Highslide
		} else if ($detailWindow == 4 || $detailWindow == 5) {
			$output['detailwindowclose']	= 'return false;';
			$output['detailwindowreload']	= 'window.location.reload(true);';
			$closeLink = '<div><a href="javascript:void(0);" onclick="'.$output['detailwindowclose'].'" >'.JText::_('COM_PHOCAGALLERY_CLOSE_WINDOW').'</a></div>';
		// No Popup
		} else if ($detailWindow == 7) {
			$output['detailwindowclose']	= '';
			$output['detailwindowreload']	= '';
			// Should not happen as it should be reloaded to login page
			$closeLink = '<div><a href="'.JURI::base(true).'" >'.JText::_('COM_PHOCAGALLERY_MAIN_SITE').'</a></div>';
		// Modal Box
		} else {
			//$this->tmpl['detailwindowclose']	= 'window.parent.document.getElementById(\'sbox-window\').close();';
			$output['detailwindowclose']	= 'window.parent.SqueezeBox.close();';
			$output['detailwindowreload']	= 'window.location.reload(true);';
			$closeLink = '<div><a href="javascript:void(0);" onclick="'.$output['detailwindowclose'].'" >'.JText::_('COM_PHOCAGALLERY_CLOSE_WINDOW').'</a></div>';
		} 
		
		$o[] = '<div style="font-family:sans-serif">';
		if ($type == 0) {
			$o[] = '<div>'.JText::_('COM_PHOCAGALLERY_NOT_AUTHORISED_ACTION').' '.JText::_('COM_PHOCAGALLERY_PLEASE_LOGIN').'.</div>';
			$o[] = '<div>&nbsp;</div>';
		}
		$o[] = $closeLink;
		$o[] = '</div>';
		
		$output['html'] = implode('', $o);
		
		return $output;
		
	}
	
	function renderInfo() {
		return '<div style="text-align: center; color: rgb(211, 211, 211);">Powe'
				. 'red by <a href="http://www.ph'
				. 'oca.cz" style="text-decoration: none;" target="_blank" title="Phoc'
				. 'a.cz">Phoca</a> <a href="http://www.phoca.cz/phocaga'
				. 'llery" style="text-decoration: none;" target="_blank" title="Phoca Gal'
				. 'lery">Gall'
				. 'ery</a></div>';
	}
	
	function renderFeedIcon($type = 'categories', $paramsIcons = true, $catid = 0, $catidAlias = '') {
		
		$paramsC 	= JComponentHelper::getParams('com_phocagallery') ;
		$df 		= $paramsC->get('display_feed', 1);

		if ($type == 'categories' && $df != 1 && $df != 2) {
			return '';
		}
		if ($type == 'category' && $df != 1 && $df != 3) {
			return '';
		}
	
		$url	= PhocaGalleryRoute::getFeedRoute($type, $catid, $catidAlias);
		$icon	= PhocaGalleryImage::getFormatIcon();
		if ($paramsIcons) {
			$text = JHTML::_('image', 'components/com_phocagallery/assets/images/icon-feed.'.$icon, JText::_('COM_PHOCAGALLERY_RSS'));
		} else {
			$text = JText::_('COM_PHOCAGALLERY_RSS');
		}
		
		$output = '<a href="'.JRoute::_($url).'" title="'.JText::_('COM_PHOCAGALLERY_RSS').'">'. $text . '</a>';
		
		
		return $output;	
	}
	/*
	function correctRender() {
		if (class_exists('plgSystemRedact')) {
			echo "Phoca Gallery doesn't work in case Redact plugin is enabled. Please disable this plugin to run Phoca Gallery";exit;
			$db =& JFactory::getDBO();
			$query = 'SELECT a.params AS params'
					.' FROM #__plugins AS a'
					.' WHERE a.element = \'redact\''
					.' AND a.folder = \'system\''
					.' AND a.published = 1';
			$db->setQuery($query, 0, 1);
			$params = $db->loadObject();
			if(isset($params->params) && $params->params != '') {
				$params->params = str_replace('phoca.cz', 'phoca_cz', $params->params);
				$params->params = str_replace('phoca\.cz', 'phoca_cz', $params->params);
				if ($params->params != '') {
					$query = 'UPDATE #__plugins'
							.' SET params = \''.$params->params.'\''
							.' WHERE element = \'redact\''
							.' AND folder = \'system\'';
					$db->setQuery($query);
					$db->query();
				}
			}
		
		}
		
		if (class_exists('plgSystemReReplacer')) {
			echo "Phoca Gallery doesn't work in case ReReplacer plugin is enabled. Please disable this plugin to run Phoca Gallery";exit;
			/*$db =& JFactory::getDBO();
			$query = 'SELECT a.id, a.search'
					.' FROM #__rereplacer AS a'
					.' WHERE (a.search LIKE \'%phoca.cz%\''
					.' OR a.search LIKE \'%phoca\\\\\\\\.cz%\')'
					.' AND a.published = 1';
			$db->setQuery($query);
			$search = $db->loadObjectList();
			
			if(isset($search) && count($search)) {
				
				foreach ($search as $value) {
					if (isset($value->search) && $value->search != '' && isset($value->id) && $value->id > 0) {
						$value->search = str_replace('phoca.cz', 'phoca_cz', $value->search);
						$value->search = str_replace('phoca\.cz', 'phoca_cz', $value->search);
						if ($value->search != '') {
							$query = 'UPDATE #__rereplacer'
							.' SET search = \''.$value->search.'\''
							.' WHERE id = '.(int)$value->id;
							$db->setQuery($query);
							$db->query();
						}
					}
				}
			}
		}
	
	}*/
	
	public function renderAAttribute($detailWindow, $buttonOptions, $lingOrig, $hSOnClick, $hsOnClick2, $linkNr, $catAlias) {
	
		if ($detailWindow == 1) {
			return ' onclick="'. $buttonOptions.'"';
		} else if ($detailWindow == 4 || $detailWindow == 5) {
			$hSOC = str_replace('[phocahsfullimg]', $lingOrig, $hSOnClick);
			return ' onclick="'. $hSOC.'"';
		} else if ($detailWindow == 6 ) {
			return ' onclick="gjaks.show('.$linkNr.'); return false;"';
		} else if ($detailWindow == 7 ) {
			return '';
		} else if ($detailWindow == 8) {
			return ' rel="lightbox-'.$catAlias.'" ';
		} else {
			return ' rel="'.$buttonOptions.'"';
		}
		
		return '';
	}
	
	public function renderAAttributeTitle($detailWindow, $buttonOptions, $lingOrig, $hsOnClick, $hsOnClick2, $linkNr, $catAlias) {
			
		if ($detailWindow == 1) {
			return ' onclick="'. $buttonOptions.'"';
		} else if ($detailWindow == 2) {
			return ' rel="'. $buttonOptions.'"';
		} else if ($detailWindow == 4 ) {
			return ' onclick="'. $hsOnClick.'"';
		} else if ($detailWindow == 5 ) {
			return ' onclick="'. $hsOnClick2.'"';
		} else if ($detailWindow == 6) {
			return ' onclick="gjaks.show('.$linkNr.'); return false;"';
		} else if ($detailWindow == 7 ) {
			return '';
		} else if ($detailWindow == 8) {
			return ' rel="lightbox-'.$catAlias.'2" ';
		} else {
			return ' rel="'.$buttonOptions.'"';
		}
		
		return '';
	}
	
	public function renderAAttributeStat($detailWindow, $buttonOptions, $lingOrig, $hSOnClick, $hsOnClick2, $linkNr, $catAlias, $suffix) {
			
		if ($detailWindow == 1) {
			return ' onclick="'. $buttonOptions.'"';
		} else if ($detailWindow == 2) {
			return ' rel="'. $buttonOptions.'"';
		} else if ($detailWindow == 4) {
			return ' onclick="'. $hSOnClick.'"';
		} else if ($detailWindow == 5) {
			return ' onclick="'. $hSOnClick2.'"';
		} else if ($detailWindow == 8) {
			return ' rel="lightbox-'.$catAlias.'-'.$suffix.'" ';
		} else {
			return ' rel="'. $buttonOptions.'"';
		}
		
		return '';
	}
	
	public function renderAAttributeOther($detailWindow, $buttonOptionsOther, $hSOnClick, $hSOnClick2) {
	
		if ($detailWindow == 1) {
			return ' onclick="'. $buttonOptionsOther.'"';
		} else if ($detailWindow == 4) {
			return ' onclick="'. $hSOnClick.'"';
		} else if ($detailWindow == 5 ) {
			return ' onclick="'. $hSOnClick2.'"';
		} else if ($detailWindow == 7 ) {
			return '';
		} else {
			return ' rel="'.$buttonOptionsOther.'"';
		}
		return '';
	}
	
	public function renderASwitch($switchW, $switchH, $switchFixedSize, $extWSwitch, $extHSwitch, $extL, $linkThumbPath) {
	
		if ($extL != '') {
			// Picasa
			if ((int)$switchW > 0 && (int)$switchH > 0 && $switchFixedSize == 1) {
				// Custom Size
				return ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $extL.'\', '.$switchW.', '.$switchH.');" ';
			} else {
				// Picasa Size
				$correctImageResL = PhocaGalleryPicasa::correctSizeWithRate($extWSwitch, $extHSwitch, $switchW, $switchH);
				return ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $extL.'\', '.$correctImageResL['width'].', '.$correctImageResL['height'].');" '; 
				// onmouseout="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''.$extL.'\');"
			}
		} else {
			$switchImg = str_replace('phoca_thumb_m_','phoca_thumb_l_',JURI::base(true).'/'. $linkThumbPath);
			if ((int)$switchW > 0 && (int)$switchH > 0 && $switchFixedSize == 1) {
				return ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $switchImg.'\', '.$switchW.', '.$switchH.');" ';
			} else {
				return ' onmouseover="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''. $switchImg.'\');" ';
				// onmouseout="PhocaGallerySwitchImage(\'PhocaGalleryobjectPicture\', \''.$switchImg.'\');"
			}
		}
		
		return '';
	}
	
	public function renderImageClass($image) {
	
		$isFolder 	= strpos($image, 'com_phocagallery/assets/images/icon-folder');
		$isUp 		= strpos($image, 'com_phocagallery/assets/images/icon-up');
		if ($isFolder !== false) {
			return 'pg-cat-folder';
		} else if ($isUp !== false) {
			return 'pg-cat-up';
		} else {
			return 'pg-cat-image';
		}
	}
	
	public function displayCustomCSS($customCss) {
		if ($customCss != ''){
			$customCss = str_replace('background: url(images/', 'background: url('.JURI::base(true).'/components/com_phocagallery/assets/images/', $customCss);
			$document	= &JFactory::getDocument();
			$document->addCustomTag( "\n <style type=\"text/css\"> \n" 
				.strip_tags($customCss)
				."\n </style> \n");
		}
	}
}
?>