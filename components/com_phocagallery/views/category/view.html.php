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
jimport( 'joomla.html.pane' );
jimport( 'joomla.client.helper' );
jimport( 'joomla.application.component.view' );
phocagalleryimport('phocagallery.file.fileupload');
phocagalleryimport( 'phocagallery.file.fileuploadmultiple' );
phocagalleryimport( 'phocagallery.file.fileuploadsingle' );
phocagalleryimport( 'phocagallery.file.fileuploadjava' );
phocagalleryimport('phocagallery.rate.ratecategory');
phocagalleryimport('phocagallery.rate.rateimage');
phocagalleryimport('phocagallery.comment.comment');
phocagalleryimport('phocagallery.comment.commentcategory');
phocagalleryimport('phocagallery.picasa.picasa');
phocagalleryimport( 'phocagallery.facebook.fbsystem');

class PhocaGalleryViewCategory extends JView
{
	public $tmpl;
	protected $params;
	
	function display($tpl = null) {
	
		$app						= JFactory::getApplication();
		$document					= JFactory::getDocument();
		$uri 						= JFactory::getURI();
		$menus						= JSite::getMenu();
		$menu						= $menus->getActive();
		$this->params				= $app->getParams();
		$this->tmpl['user'] 		= JFactory::getUser();
		$this->tmpl['action']		= $uri->toString();
		$path 						= PhocaGalleryPath::getPath();
		$limitStart					= JRequest::getVar( 'limitstart', 0, '', 'int');
		$id 						= JRequest::getVar('id', 0, '', 'int');
		$this->tagId				= JRequest::getVar( 'tagid', 0, '', 'int' );
		$this->tmpl['tab'] 			= JRequest::getVar('tab', 0, '', 'int');
		$this->tmpl['formaticon'] 	= PhocaGalleryImage::getFormatIcon();
		$this->tmpl['pl']			= 'index.php?option=com_users&view=login&return='.base64_encode($uri->toString());
		
		
		
		$neededAccessLevels	= PhocaGalleryAccess::getNeededAccessLevels();
		$access				= PhocaGalleryAccess::isAccess($this->tmpl['user']->authorisedLevels(), $neededAccessLevels);

	
		// LIBRARY
		$library 							= &PhocaGalleryLibrary::getLibrary();
		$libraries['pg-group-shadowbox']	= $library->getLibrary('pg-group-shadowbox');
		$libraries['pg-group-highslide']	= $library->getLibrary('pg-group-highslide');
		$libraries['pg-group-jak']			= $library->getLibrary('pg-group-jak');
		
		
		// PARAMS
		$this->tmpl['displaycatnametitle'] 		= $this->params->get( 'display_cat_name_title', 1 );
		$display_cat_name_breadcrumbs 			= $this->params->get( 'display_cat_name_breadcrumbs', 1 );
		$image_background_color 				= $this->params->get( 'image_background_color', '#f5f5f5' );
		$this->tmpl['displayimageshadow'] 		= $this->params->get( 'image_background_shadow', 'shadow1' );
		$this->tmpl['imagewidth']				= $this->params->get( 'medium_image_width', 100 );
		$this->tmpl['imageheight'] 				= $this->params->get( 'medium_image_height', 100 );
		$popup_width 							= $this->params->get( 'front_modal_box_width', 680 );
		$popup_height 							= $this->params->get( 'front_modal_box_height', 560 );
		$this->tmpl['olbgcolor']				= $this->params->get( 'ol_bg_color', '#666666' );
		$this->tmpl['olfgcolor']				= $this->params->get( 'ol_fg_color', '#f6f6f6' );
		$this->tmpl['oltfcolor']				= $this->params->get( 'ol_tf_color', '#000000' );
		$this->tmpl['olcfcolor']				= $this->params->get( 'ol_cf_color', '#ffffff' );
		
		$this->tmpl['maxuploadchar']			= $this->params->get( 'max_upload_char', 1000 );
		$this->tmpl['maxcommentchar']			= $this->params->get( 'max_comment_char', 1000 );
		$this->tmpl['maxcreatecatchar']			= $this->params->get( 'max_create_cat_char', 1000 );
		$this->tmpl['commentwidth']				= $this->params->get( 'comment_width', 500 );
		$this->tmpl['displayrating']			= $this->params->get( 'display_rating', 0 );
		$this->tmpl['displayratingimg']			= $this->params->get( 'display_rating_img', 0 );
		$this->tmpl['displaycomment']			= $this->params->get( 'display_comment', 0 );
		$this->tmpl['displaycommentimg']		= $this->params->get( 'display_comment_img', 0 );
		$this->tmpl['displaysubcategory']		= $this->params->get( 'display_subcategory', 1 );
		$this->tmpl['displaycategorygeotagging']= $this->params->get( 'display_category_geotagging', 0 );
		$this->tmpl['displaycategorystatistics']= $this->params->get( 'display_category_statistics', 0 );
		// Used for Highslide JS (only image)
		$this->tmpl['displaydescriptiondetail']	= $this->params->get( 'display_description_detail', 0 );
		$this->tmpl['displaytitleindescription']= $this->params->get( 'display_title_description', 0 );
		$this->tmpl['displayname']				= $this->params->get( 'display_name', 1);
		$this->tmpl['displayicondetail'] 		= $this->params->get( 'display_icon_detail', 1 );
		$this->tmpl['displayicondownload'] 		= $this->params->get( 'display_icon_download', 2 );
		$this->tmpl['displayiconfolder'] 		= $this->params->get( 'display_icon_folder', 0 );
		$this->tmpl['displayiconvm']			= $this->params->get( 'display_icon_vm', 0 );
		$this->tmpl['fontsizename']				= $this->params->get( 'font_size_name', 12 );
		$this->tmpl['fontsizeimgdesc']			= $this->params->get( 'font_size_img_desc', 10 );
		$this->tmpl['imgdescboxheight']			= $this->params->get( 'img_desc_box_height', 30 );
		$this->tmpl['displayimgdescbox']		= $this->params->get( 'display_img_desc_box', 0 );
		$this->tmpl['charlengthimgdesc']		= $this->params->get( 'char_length_img_desc', 300 );
		$this->tmpl['charlengthname'] 			= $this->params->get( 'char_length_name', 15);
		$this->tmpl['displayicongeo']			= $this->params->get( 'display_icon_geotagging', 0 );// Check the category
		$this->tmpl['displayicongeoimage']		= $this->params->get( 'display_icon_geotagging', 0 );// Check the image
		$this->tmpl['displaycamerainfo']		= $this->params->get( 'display_camera_info', 0 );
		$this->tmpl['displaypage'] 				= PhocaGalleryRenderInfo::getPhocaIc((int)$this->params->get( 'display_phoca_info', 1 ));
		$this->tmpl['switchimage']				= $this->params->get( 'switch_image', 0 );
		$this->tmpl['switchheight'] 			= $this->params->get( 'switch_height', 480 );
		$this->tmpl['switchwidth'] 				= $this->params->get( 'switch_width', 640);
		$this->tmpl['switchfixedsize'] 			= $this->params->get( 'switch_fixed_size', 0);
		// PARAMS - Upload
		$this->tmpl['multipleuploadchunk']		= $this->params->get( 'multiple_upload_chunk', 0 );
		$this->tmpl['displaytitleupload']		= $this->params->get( 'display_title_upload', 0 );
		$this->tmpl['displaydescupload'] 		= $this->params->get( 'display_description_upload', 0 );
		$this->tmpl['enablejava'] 				= $this->params->get( 'enable_java', 0 );
		$this->tmpl['enablemultiple'] 			= $this->params->get( 'enable_multiple', 0 );
		$this->tmpl['multipleuploadmethod'] 	= $this->params->get( 'multiple_upload_method', 1 );
		$this->tmpl['multipleresizewidth'] 		= $this->params->get( 'multiple_resize_width', -1 );
		$this->tmpl['multipleresizeheight'] 	= $this->params->get( 'multiple_resize_height', -1 );
		$this->tmpl['javaboxwidth'] 			= $this->params->get( 'java_box_width', 480 );
		$this->tmpl['javaboxheight'] 			= $this->params->get( 'java_box_height', 480 );
		$this->tmpl['large_image_width']		= $this->params->get( 'large_image_width', 640 );
		$this->tmpl['large_image_height']		= $this->params->get( 'large_image_height', 640 );
		$this->tmpl['uploadmaxsize'] 			= $this->params->get( 'upload_maxsize', 3145728 );
		$this->tmpl['uploadmaxsizeread'] 		= PhocaGalleryFile::getFileSizeReadable($this->tmpl['uploadmaxsize']);
		$this->tmpl['uploadmaxreswidth'] 		= $this->params->get( 'upload_maxres_width', 3072 );
		$this->tmpl['uploadmaxresheight'] 		= $this->params->get( 'upload_maxres_height', 2304 );
		$this->tmpl['phocagallerywidth']		= $this->params->get( 'phocagallery_width', '');
		$this->tmpl['phocagallerycenter']		= $this->params->get( 'phocagallery_center', '');
		$display_description_detail 			= $this->params->get( 'display_description_detail', 0 );
		$description_detail_height 				= $this->params->get( 'description_detail_height', 16 );
		$this->tmpl['categoryboxspace'] 		= $this->params->get( 'category_box_space', 0 );
		$this->tmpl['detailwindow']				= $this->params->get( 'detail_window', 0 );
		$detail_buttons 						= $this->params->get( 'detail_buttons', 1 );
		$modal_box_overlay_color 				= $this->params->get( 'modal_box_overlay_color', '#000000' );
		$modal_box_overlay_opacity 				= $this->params->get( 'modal_box_overlay_opacity', 0.3 );
		$modal_box_border_color 				= $this->params->get( 'modal_box_border_color', '#6b6b6b' );
		$modal_box_border_width 				= $this->params->get( 'modal_box_border_width', '2' );
		$this->tmpl['enablecooliris']			= $this->params->get( 'enable_cooliris', 0 );
		$highslide_class						= $this->params->get( 'highslide_class', 'rounded-white');
		$highslide_opacity						= $this->params->get( 'highslide_opacity', 0);
		$highslide_outline_type					= $this->params->get( 'highslide_outline_type', 'rounded-white');
		$highslide_fullimg						= $this->params->get( 'highslide_fullimg', 0);
		$highslide_slideshow					= $this->params->get( 'highslide_slideshow', 1);
		$highslide_close_button					= $this->params->get( 'highslide_close_button', 0);
		$this->tmpl['jakslideshowdelay']		= $this->params->get( 'jak_slideshow_delay', 5);
		$this->tmpl['jakorientation']			= $this->params->get( 'jak_orientation', 'none');
		$this->tmpl['jakdescription']			= $this->params->get( 'jak_description', 1);
		$this->tmpl['jakdescriptionheight']		= $this->params->get( 'jak_description_height', 0);
		$this->tmpl['categoryimageordering']	= $this->params->get( 'category_image_ordering', 9 );
		$this->tmpl['externalcommentsystem'] 	= $this->params->get( 'external_comment_system', 0 );
		// Possible Categories View in Category View
		$this->tmpl['categoryimageorderingcv']	= $this->params->get( 'category_image_ordering_cv', 9 );
		$this->tmpl['displaycategoriescv'] 		= $this->params->get( 'display_categories_cv', 0 );
		$display_subcat_page_cv					= $this->params->get( 'display_subcat_page_cv', 0 );
		$display_back_button_cv 				= $this->params->get( 'display_back_button_cv', 1 );
		$display_categories_back_button_cv 		= $this->params->get( 'display_categories_back_button_cv', 1 );
		$this->tmpl['displayimagecategoriescv'] = $this->params->get( 'display_image_categories_cv', 1 );
		$this->tmpl['categoriescolumnscv'] 		= $this->params->get( 'categories_columns_cv', 1 );
		$image_categories_size_cv 				= $this->params->get( 'image_categories_size_cv', 4 );
		$medium_image_width_cv 					= (int)$this->params->get( 'medium_image_width', 100 ) + 18;
		$medium_image_height_cv 				= (int)$this->params->get( 'medium_image_height', 100 ) + 18;
		$small_image_width_cv 					= (int)$this->params->get( 'small_image_width', 50 ) + 18;
		$small_image_height_cv 					= (int)$this->params->get( 'small_image_height', 50 ) + 18;
		$this->tmpl['imagetypecv']				= $image_categories_size_cv;
		$this->tmpl['overlibimagerate']			= (int)$this->params->get( 'overlib_image_rate', '' );
		$this->tmpl['picasa_correct_width_m']	= (int)$this->params->get( 'medium_image_width', 100 );	
		$this->tmpl['picasa_correct_height_m']	= (int)$this->params->get( 'medium_image_height', 100 );
		$this->tmpl['picasa_correct_width_s']	= (int)$this->params->get( 'small_image_width', 50 );	
		$this->tmpl['picasa_correct_height_s']	= (int)$this->params->get( 'small_image_height', 50 );
		$this->tmpl['picasa_correct_width_l']	= (int)$this->params->get( 'large_image_width', 640 );	
		$this->tmpl['picasa_correct_height_l']	= (int)$this->params->get( 'large_image_height', 480 );
		$this->tmpl['gallerymetakey'] 			= $this->params->get( 'gallery_metakey', '' );
		$this->tmpl['gallerymetadesc'] 			= $this->params->get( 'gallery_metadesc', '' );
		$this->tmpl['altvalue']		 			= $this->params->get( 'alt_value', 1 );
		$paramsFb = PhocaGalleryFbSystem::getCommentsParams($this->params->get( 'fb_comment_user_id', ''));// Facebook
		$this->tmpl['fb_comment_app_id']		= isset($paramsFb['fb_comment_app_id']) ? $paramsFb['fb_comment_app_id'] : '';
		$this->tmpl['fb_comment_width']			= isset($paramsFb['fb_comment_width']) ? $paramsFb['fb_comment_width'] : 550;
		$this->tmpl['fb_comment_lang'] 			= isset($paramsFb['fb_comment_lang']) ? $paramsFb['fb_comment_lang'] : 'en_US';
		$this->tmpl['fb_comment_count'] 		= isset($paramsFb['fb_comment_count']) ? $paramsFb['fb_comment_count'] : '';
		$this->tmpl['enable_direct_subcat']   = $this->params->get( 'enable_direct_subcat', 0 );
		$this->tmpl['display_comment_nopup']	= $this->params->get( 'display_comment_nopup', 0);
		$this->tmpl['boxplus_theme']			= $this->params->get( 'boxplus_theme', 'lightsquare');
		$this->tmpl['boxplus_bautocenter']		= (int)$this->params->get( 'boxplus_bautocenter', 1);
		$this->tmpl['boxplus_autofit']			= (int)$this->params->get( 'boxplus_autofit', 1);
		$this->tmpl['boxplus_slideshow']		= (int)$this->params->get( 'boxplus_slideshow', 0);
		$this->tmpl['boxplus_loop']				= (int)$this->params->get( 'boxplus_loop', 0);
		$this->tmpl['boxplus_captions']			= $this->params->get( 'boxplus_captions', 'bottom');
		$this->tmpl['boxplus_thumbs']			= $this->params->get( 'boxplus_thumbs', 'inside');
		$this->tmpl['boxplus_duration']			= (int)$this->params->get( 'boxplus_duration', 250);
		$this->tmpl['boxplus_transition']		= $this->params->get( 'boxplus_transition', 'linear');
		$this->tmpl['boxplus_contextmenu']		= (int)$this->params->get( 'boxplus_contextmenu', 1);
		$this->tmpl['enablecustomcss']			= $this->params->get( 'enable_custom_css', 0);
		$this->tmpl['customcss']				= $this->params->get( 'custom_css', '');
		$this->tmpl['display_tags_links'] 		= $this->params->get( 'display_tags_links', 0 );
		$this->tmpl['displaying_tags_true'] 	= 0;//No tag found, if yes, the box will be resized
		$this->tmpl['ytbupload'] 				= $this->params->get( 'youtube_upload', 0 );
		$this->tmpl['ytb_display'] 				= $this->params->get( 'ytb_display', 0 );
		$this->tmpl['enable_multibox']			= $this->params->get( 'enable_multibox', 0);
		$this->tmpl['multibox_height']			= (int)$this->params->get( 'multibox_height', 560 );	
		$this->tmpl['multibox_width']			= (int)$this->params->get( 'multibox_width', 980 );
		
		
		// = = = = = = = = = = 
		// CSS
		// = = = = = = = = = =
		JHtml::stylesheet('components/com_phocagallery/assets/phocagallery.css' );
		if ($this->tmpl['enablecustomcss'] == 1) {
			JHtml::stylesheet('components/com_phocagallery/assets/phocagallerycustom.css' );
			PhocaGalleryRenderFront::displayCustomCSS($this->tmpl['customcss']);
		} else {
			$libraries['pg-css-ie'] 			= $library->getLibrary('pg-css-ie');
			$libraries['pg-css-ie-hover']		= $library->getLibrary('pg-css-ie-hover');
		
			// PARAMS - Background shadow
			if ( $this->tmpl['displayimageshadow'] != 'none' ) {	
				// IE hack
				$shadowPath = $path->image_abs_front . $this->tmpl['displayimageshadow'].'.'.$this->tmpl['formaticon'];
				$shadowSize	= getimagesize($shadowPath);
				if (isset($shadowSize[0]) && isset($shadowSize[0])) {
					$w = (int)$this->tmpl['imagewidth'] + 18 - (int)$shadowSize[0];
					$h = (int)$this->tmpl['imageheight'] + 18 - (int)$shadowSize[1];
					if ($w != 0) {$w = $w/2;} // plus or minus should be divided, not null
					if ($h != 0) {$h = $h/2;}
				} else {
					$w = $h = 0;
				}
				$imageBgCSS = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$this->tmpl['displayimageshadow'].'.'.$this->tmpl['formaticon'].'\') 50% 50% no-repeat;';
				
				$imageBgCSSIE = 'background: url(\''.JURI::base(true).'/components/com_phocagallery/assets/images/'.$this->tmpl['displayimageshadow'].'.'.$this->tmpl['formaticon'].'\') '.$w.'px '.$h.'px no-repeat;';
			} else {
				$imageBgCSS 	= 'background: '.$image_background_color .';';
				$imageBgCSSIE 	= 'background: '.$image_background_color .';';
			}
		
			if ( $libraries['pg-css-ie']->value == 0 ) {
				$document->addCustomTag("<!--[if lt IE 8 ]>\n<link rel=\"stylesheet\" href=\""
				.JURI::base(true)
				."/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
				$library->setLibrary('pg-css-ie', 1);
			}
		
			$document->addCustomTag( PhocaGalleryRenderFront::renderCategoryCSS(
				$this->params->get( 'font_color', 		'#b36b00' ),
				$this->params->get( 'background_color', '#fcfcfc' ),
				$this->params->get( 'border_color', 	'#e8e8e8' ),
				$imageBgCSS,
				$imageBgCSSIE, 
				$this->params->get( 'border_color_hover', 		'#b36b00'), 
				$this->params->get( 'background_color_hover', 	'#f5f5f5' ),
				$this->tmpl['olfgcolor'],
				$this->tmpl['olbgcolor'],
				$this->tmpl['oltfcolor'],
				$this->tmpl['olcfcolor'],
				$this->params->get( 'margin_box', 5 ),
				$this->params->get( 'padding_box', 5 ),
				$this->params->get( 'overlib_overlay_opacity', 0.7 )));
			
			if ( $libraries['pg-css-ie-hover']->value == 0 ) {
				$document->addCustomTag( PhocaGalleryRenderFront::renderIeHover());
				$library->setLibrary('pg-css-ie-hover', 1);
			}
		}
		// = = = = = = = = = = 
		
		
		// Default_Categories
		$catImg = PhocaGalleryImageFront::getCategoriesImageBackground($image_categories_size_cv, $small_image_width_cv, $small_image_height_cv,  $medium_image_height_cv, $medium_image_width_cv);
		$this->tmpl['imagebgcv'] 		= $catImg->image;
		$this->tmpl['imagewidthcv'] 	= $catImg->width;
		
		switch($image_categories_size_cv) {
			// medium
			case 1:
			case 5:
				$this->tmpl['class_suffix']				= 'medium';
			break;
			
			case 0:
			case 4:
			default:
				$this->tmpl['class_suffix']				= 'small';
			break;
		}
		

		// Correct Height
		// Description detail height
		if ($display_description_detail == 1) {
			$popup_height	= $popup_height + $description_detail_height;
		}
		// Detail buttons in detail view
		if ($detail_buttons != 1) {
			$popup_height	= $popup_height - 45;
		}
		if ($this->tmpl['displayratingimg'] == 1) {
			$popup_height	= $popup_height + 35;
		}
		// Correct height of description in image box (set null if this will be hidden)
		if ($this->tmpl['displayimgdescbox'] == 0) {
			$this->tmpl['imgdescboxheight']	= 0;
		}
		
		// Youtube video without padding, margin
		if ($this->tmpl['detailwindow'] != 7 && $this->tmpl['ytb_display'] == 1) {
			$document->addCustomTag( "<style type=\"text/css\"> \n" 
			." #boxplus .boxplus-dialog .boxplus-controlsclose {
				top: -15px !important;
				right: -15px !important;
				margin:0px 0 0 0 !important;
			} \n"
			." </style> \n");
			
			$popup_width = PhocaGallerySettings::getAdvancedSettings('youtubewidth');
			$popup_height= PhocaGallerySettings::getAdvancedSettings('youtubeheight');
		}
		
		// Multibox
		if ($this->tmpl['enable_multibox']	== 1) {
			$popup_width 							= $this->tmpl['multibox_width'];
			$popup_height 							= $this->tmpl['multibox_height'];
		}
		
		
		// =======================================================
		// DIFFERENT METHODS OF DISPLAYING THE DETAIL VIEW
		// =======================================================
		
		// MODAL - will be displayed in case e.g. highslide or shadowbox too, because in there are more links 
		JHtml::_('behavior.modal', 'a.pg-modal-button');
		
		// CSS Specific
		$document->addCustomTag( "<style type=\"text/css\"> \n"  
		." #sbox-window {background-color:".$modal_box_border_color.";padding:".$modal_box_border_width."px} \n"
		." #sbox-overlay {background-color:".$modal_box_overlay_color.";} \n"			
		." </style> \n");

		// BUTTON (IMAGE - standard, modal, shadowbox)
		$button = new JObject();
		$button->set('name', 'image');
		$button->set('options', '');//initialize
		
		// BUTTON (ICON - standard, modal, shadowbox)
		$button2 = new JObject();
		$button2->set('name', 'icon');
		$button2->set('options', '');//initialize
		
		// BUTTON OTHER (geotagging, downloadlink, ...)
		$buttonOther = new JObject();
		$buttonOther->set('name', 'other');
		$buttonOther->set('options', '');//initialize
		$buttonOther->set('optionsrating', '');//initialize
	
		$this->tmpl ['highslideonclick']	= '';// for using with highslide
		$this->tmpl ['highslideonclick2']	= '';
		
		// -------------------------------------------------------
		// STANDARD POPUP
		// -------------------------------------------------------
		
		if ($this->tmpl['detailwindow'] == 1) {
			
			$button->set('methodname', 'js-button');
			$button->set('options', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
			$button->set('optionsrating', "window.open(this.href,'win2','width=".$popup_width.",height=".$popup_height.",scrollbars=yes,menubar=no,resizable=yes'); return false;");
			
			$button2->methodname 		= &$button->methodname;
			$button2->options 			= &$button->options;
			$buttonOther->methodname  	= &$button->methodname;
			$buttonOther->options 		= &$button->options;
			$buttonOther->optionsrating = &$button->optionsrating;
			
		}
		// -------------------------------------------------------
		// MODAL BOX
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 0 || $this->tmpl['detailwindow'] == 2) { 
			
			// Button
			$button->set('modal', true);
			$button->set('methodname', 'pg-modal-button');
			
			$button2->modal 			= &$button->modal;
			$button2->methodname 		= &$button->methodname;
			$buttonOther->modal 		= &$button->modal;
			$buttonOther->methodname  	= &$button->methodname;
			
			// Modal - Image only
			if ($this->tmpl['detailwindow'] == 2) {
				
				$button->set('options', "{handler: 'image', size: {x: 200, y: 150}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$button2->options 		= &$button->options;
				$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			
			// Modal - Iframe 			
			} else {
			
				$button->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
				
				$button2->options 		= &$button->options;
				$buttonOther->options  	= &$button->options;
			
			}
	
		} 
		
		// -------------------------------------------------------
		// SHADOW BOX
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 3) {
		
			$sb_slideshow_delay			= $this->params->get( 'sb_slideshow_delay', 5 );
			$sb_lang					= $this->params->get( 'sb_lang', 'en' );
			
			$button->set('methodname', 'shadowbox-button');
			$button->set('options', "shadowbox[PhocaGallery];options={slideshowDelay:".$sb_slideshow_delay."}");
			
			$button2->methodname 		= &$button->methodname;
			$button2->set('options', "shadowbox[PhocaGallery2];options={slideshowDelay:".$sb_slideshow_delay."}");
			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'pg-modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			
			//	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/adapter/shadowbox-mootools.js');
			
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/shadowbox.js');
			//$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/lang/shadowbox-cs.js');				
			//$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/shadowbox.css');
			
			if ( $libraries['pg-group-shadowbox']->value == 0 ) {
				$document->addCustomTag('<script type="text/javascript">
Shadowbox.loadSkin("classic", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/skin");
Shadowbox.loadLanguage("'.$sb_lang.'", "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/lang");
Shadowbox.loadPlayer(["img"], "'.JURI::base(true).'/components/com_phocagallery/assets/js/shadowbox/src/player");
window.addEvent(\'domready\', function(){
           Shadowbox.init()
});
</script>');

				/*$document->addCustomTag('<script type="text/javascript">
				Shadowbox.init({
					handleOversize: "drag",
					modal: true,
					overlayOpacity: 0.8,
					language: "cs"
				});
				</script>');*/
				// window.onload = function(){
				// Shadowbox.init();
				$library->setLibrary('pg-group-shadowbox', 1);
			}
		}
		
		// -------------------------------------------------------
		// HIGHSLIDE JS
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 4) {
			
			$button->set('methodname', 'highslide');
			$button2->methodname 		= &$button->methodname;
			$buttonOther->methodname 	= &$button->methodname;
			
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
			
			if ( $libraries['pg-group-highslide']->value == 0 ) {
				$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
				$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
				$library->setLibrary('pg-group-highslide', 1);
			}
			
			//$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS ('',$popup_width, $popup_height, $highslide_outline_type, $highslide_opacity));
			$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('', $popup_width, $popup_height, $highslide_slideshow, $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_close_button));
			$this->tmpl['highslideonclick'] = 'return hs.htmlExpand(this, phocaZoom )';
		}
		
		// -------------------------------------------------------
		// HIGHSLIDE JS IMAGE ONLY
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 5) {
		
			$button->set('methodname', 'highslide');
			$button2->methodname 		= &$button->methodname;
			$buttonOther->methodname 	= &$button->methodname;
			
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-full.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide.css');
			
		
			if ( $libraries['pg-group-highslide']->value == 0 ) {		
				$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJSAll());
				$document->addCustomTag('<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/highslide/highslide-ie6.css" /><![endif]-->');
				$library->setLibrary('pg-group-highslide', 1);
			}
			
			$document->addCustomTag( PhocaGalleryRenderFront::renderHighslideJS('', $popup_width, $popup_height, $highslide_slideshow, $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_close_button));
			$this->tmpl['highslideonclick2']	= 'return hs.htmlExpand(this, phocaZoom )';
			$this->tmpl['highslideonclick']	= PhocaGalleryRenderFront::renderHighslideJSImage('', $highslide_class, $highslide_outline_type, $highslide_opacity, $highslide_fullimg);
			
		}
		
		// -------------------------------------------------------
		// JAK LIGHTBOX
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 6) {
		
			$button->set('methodname', 'jaklightbox');
			$button2->methodname 		= &$button->methodname;

			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'pg-modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
		
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/jak_slideshow.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/window_compressed.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/jak/interpolator_compressed.js');		
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-slideshow.css');
			
			
			$lHeight 		= 472 + (int)$this->tmpl['jakdescriptionheight'];
			$lcHeight		= 10 + (int)$this->tmpl['jakdescriptionheight'];
			$customJakTag	= '';
			if ($this->tmpl['jakorientation'] == 'horizontal') {
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-horizontal.css');
			} else if ($this->tmpl['jakorientation'] == 'vertical'){
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
				$customJakTag .= '.lightBox {height: '.$lHeight.'px;}'
							    .'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}';
			} else  {
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/jak/lightbox-vertical.css');
				$customJakTag .= '.lightBox {height: '.$lHeight.'px;width:800px;}'
							.'.lightBox .image-browser-caption { height: '.$lcHeight.'px;}'
							.'.lightBox .image-browser-thumbs { display:none;}'
							.'.lightBox .image-browser-thumbs div.image-browser-thumb-box { display:none;}';
			}
			
			if ($customJakTag != '') {
				$document->addCustomTag("<style type=\"text/css\">\n". $customJakTag. "\n"."</style>");
			}
			
			if ( $libraries['pg-group-jak']->value == 0 ) {		
				$document->addCustomTag( PhocaGalleryRenderFront::renderJakJs($this->tmpl['jakslideshowdelay'], $this->tmpl['jakorientation']));
				$library->setLibrary('pg-group-jak', 1);
			}
			
		}
		
		// -------------------------------------------------------
		// NO POPUP
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 7) {
		
			$button->set('methodname', 'no-popup');
			$button2->methodname 		= &$button->methodname;

			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'no-popup');
			$buttonOther->set('options', "");
			$buttonOther->set('optionsrating', "");
			
		}
		
		// -------------------------------------------------------
		// SLIMBOX
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 8) {
		
			$button->set('methodname', 'slimbox');
			$button2->methodname 		= &$button->methodname;
			$button2->methodname 		= &$button->methodname;
			$button2->set('options', "lightbox-images");
			
			$buttonOther->set('modal', true);
			$buttonOther->set('methodname', 'pg-modal-button');
			$buttonOther->set('options', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
			$buttonOther->set('optionsrating', "{handler: 'iframe', size: {x: ".$popup_width.", y: ".$popup_height."}, overlayOpacity: ".$modal_box_overlay_opacity."}");
		
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/slimbox.js');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/slimbox/css/slimbox.css');

		} 
		
		// -------------------------------------------------------
		// BOXPLUS (BOXPLUS + BOXPLUS (IMAGE ONLY))
		// -------------------------------------------------------
		
		else if ($this->tmpl['detailwindow'] == 9 || $this->tmpl['detailwindow'] == 10) {
			
			$language = JFactory::getLanguage();
			
			$button->set('options', 'phocagallerycboxplus');
			$button->set('methodname', 'phocagallerycboxplus');
			$button2->set('options', "phocagallerycboxplusi");
			$button2->set('methodname', 'phocagallerycboxplusi');
			$buttonOther->set('methodname', 'phocagallerycboxpluso');
			$buttonOther->set('options', "phocagallerycboxpluso");
			$buttonOther->set('optionsrating', "phocagallerycboxpluso");
			
			//if ($crossdomain) {
			//	$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/jsonp.mootools.js');
			//}
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/boxplus.js');
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/boxplus.lang.js?lang='.$language->getTag());
			
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.css');
			if ($language->isRTL()) {
				$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.rtl.css');
			}
			$document->addCustomTag('<!--[if lt IE 9]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.ie8.css" type="text/css" /><![endif]-->');
			$document->addCustomTag('<!--[if lt IE 8]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.ie7.css" type="text/css" /><![endif]-->');
			$document->addStyleSheet(JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.'.$this->tmpl['boxplus_theme'].'.css', 'text/css', null, array('title'=>'boxplus-'.$this->tmpl['boxplus_theme']));
			
			if (file_exists(JPATH_BASE.DS.'components'.DS.'com_phocagallery'.DS.'assets'.DS.'js'.DS.'boxplus'.DS.'css'.DS.'boxplus.'.$this->tmpl['boxplus_theme'])) {  // use IE-specific stylesheet only if it exists
				$this->addCustomTag('<!--[if lt IE 9]><link rel="stylesheet" href="'.JURI::base(true).'/components/com_phocagallery/assets/js/boxplus/css/boxplus.'.$this->tmpl['boxplus_theme'].'.ie8.css" type="text/css" title="boxplus-'.$this->tmpl['boxplus_theme'].'" /><![endif]-->');
			}
			
			$document->addScriptDeclaration('window.addEvent("domready", function () {');
			
			if ($this->tmpl['detailwindow'] == 10) {
				// Image
				$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplus"),{"theme":"'.$this->tmpl['boxplus_theme'].'","autocenter":'.(int)$this->tmpl['boxplus_bautocenter'].',"autofit":'.(int)$this->tmpl['boxplus_autofit'].',"slideshow":'.(int)$this->tmpl['boxplus_slideshow'].',"loop":'.(int)$this->tmpl['boxplus_loop'].',"captions":"'.$this->tmpl['boxplus_captions'].'","thumbs":"'.$this->tmpl['boxplus_thumbs'].'","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":'.(int)$this->tmpl['boxplus_duration'].',"transition":"'.$this->tmpl['boxplus_transition'].'","contextmenu":'.(int)$this->tmpl['boxplus_contextmenu'].', phocamethod:1});');
				
				// Icon
				$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusi"),{"theme":"'.$this->tmpl['boxplus_theme'].'","autocenter":'.(int)$this->tmpl['boxplus_bautocenter'].',"autofit":'.(int)$this->tmpl['boxplus_autofit'].',"slideshow":'.(int)$this->tmpl['boxplus_slideshow'].',"loop":'.(int)$this->tmpl['boxplus_loop'].',"captions":"'.$this->tmpl['boxplus_captions'].'","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":'.(int)$this->tmpl['boxplus_duration'].',"transition":"'.$this->tmpl['boxplus_transition'].'","contextmenu":'.(int)$this->tmpl['boxplus_contextmenu'].', phocamethod:1});');
				
			} else {
				// Image
				$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplus"),{"theme":"'.$this->tmpl['boxplus_theme'].'","autocenter":'.(int)$this->tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
			
				// Icon
				$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxplusi"),{"theme":"'.$this->tmpl['boxplus_theme'].'","autocenter":'.(int)$this->tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
			}
			
			// Other (Map, Info, Download)
			$document->addScriptDeclaration('new boxplus($$("a.phocagallerycboxpluso"),{"theme":"'.$this->tmpl['boxplus_theme'].'","autocenter":'.(int)$this->tmpl['boxplus_bautocenter'].',"autofit": false,"slideshow": false,"loop":false,"captions":"none","thumbs":"hide","width":'.(int)$popup_width.',"height":'.(int)$popup_height.',"duration":0,"transition":"linear","contextmenu":false, phocamethod:2});');
			
			$document->addScriptDeclaration('});');
		}
		
		$folderButton = new JObject();
		$folderButton->set('name', 'image');
		$folderButton->set('options', "");					
		// End open window parameters
		// ==================================================================
		
		
		$this->tmpl['mac'] = '<div style="text-align: center; color: rgb(211, 211, 211);">Powe'. 'red by <a href="http://www.ph'. 'oca.cz" style="text-decoration: none;" target="_blank" title="Phoc'. 'a.cz">Phoca</a> <a href="http://www.phoca.cz/phocaga'. 'llery" style="text-decoration: none;" target="_blank" title="Phoca Gal'. 'lery">Gall'. 'ery</a></div>';
		
	
		// Information about current category
		$category			= $this->get('category');
		//$total			= $this->get('total');
		
		// Cooliris (Piclens)
		$this->tmpl['startpiclens'] 	= 0;
		if ($this->tmpl['enablecooliris'] == 1) {
			$this->tmpl['startpiclens'] = $this->params->get( 'start_cooliris', 0 );
			// CSS - PicLens START
			$document->addCustomTag(PhocaGalleryRenderFront::renderPicLens($category->id));
		}
		
		// PARAMS - Pagination and subcategories on other sites
		// Subcategories will be displayed only on first page if pagination will be used
		$display_subcat_page = $this->params->get( 'display_subcat_page', 0 );
		// On the first site subcategories will be displayed allways
		$get['start']	= JRequest::getVar( 'limitstart', '', 'get', 'string' );
		if ($display_subcat_page == 2) {
			$display_subcat_page = 0;// Nowhere
		} else if ($display_subcat_page == 0 && $get['start'] > 0) {
			$display_subcat_page = 0;//in case: second page and param=0
		} else {
			$display_subcat_page = 1;//in case:first page or param==1
		}
		// Categories View in Category View
		if ($display_subcat_page_cv == 2) {
			$display_subcat_page_cv = 0;// Nowhere
		} else if ($display_subcat_page_cv == 0 && $get['start'] > 0) {
			$display_subcat_page_cv = 0;//in case: second page and param=0
		} else {
			$display_subcat_page_cv = 1;//in case:first page or param==1
		}
		// PARAMS - Display Back Buttons
		$display_back_button 			= $this->params->get( 'display_back_button', 1 );
		$display_categories_back_button = $this->params->get( 'display_categories_back_button', 1 );
		// PARAMS - Access Category - display category (subcategory folder or backbutton  to not accessible cat
		$display_access_category 		= $this->params->get( 'display_access_category', 1 );	
		
		// Set page title per category
		if ($this->tmpl['displaycatnametitle'] == 1 && isset($category->title)) {
			$document->setTitle($this->params->get( 'page_title') . ' - '. $category->title);
		} else {
			$document->setTitle( $this->params->get( 'page_title' ));
		}

		// Breadcrumb display:
		// 0 - only menu link
		// 1 - menu link - category name
		// 2 - only category name
		$this->_addBreadCrumbs($category, isset($menu->query['id']) ? $menu->query['id'] : 0, $display_cat_name_breadcrumbs);
		
		// PARAMS - the whole page title with category or without category
		$this->tmpl['showpageheading'] = $this->params->get( 'show_page_heading', 1 );
		
		// Define image tag attributes
	/*	if (!empty ($category->image)) {
			$attribs['align'] = '"'.$category->image_position.'"';
			$attribs['hspace'] = '"6"';
			$this->tmpl['image'] = JHtml::_('image', 'images/stories/'.$category->image,'', $attribs);
		}*/
		
		// Switch image JS
		$this->tmpl['basicimage']	= '';
		if ($this->tmpl['switchimage'] == 1) {
			$imagePathFront		= PhocaGalleryPath::getPath();
			$this->tmpl['waitimage']	= $imagePathFront->image_rel_front_full . 'icon-switch.gif';
			$this->tmpl['basicimage']	= $imagePathFront->image_rel_front_full . 'phoca_thumb_l_no_image.' . $this->tmpl['formaticon'];
			$document->addCustomTag(PhocaGalleryRenderFront::switchImage($this->tmpl['waitimage']));
			$basicImageSelected = 0; // we have not selected the basic image yet
		}
		
		// Overlib
		$enable_overlib = $this->params->get( 'enable_overlib', 0 );
		if ((int)$enable_overlib > 0) {
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/overlib/overlib_mini.js');
		}
		
		// MODEL
		$model		= &$this->getModel();
		
		// Trash
		$this->tmpl['trash']				= 0;
		$this->tmpl['publishunpublish']		= 0;
		$this->tmpl['approvednotapproved']	= 0;// only to see the info
		// USER RIGHT - DELETE - - - - - - - - - - -
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayDelete = 0;// default is to null (all users cannot upload)
		if (!empty($category)) {
			$rightDisplayDelete = PhocaGalleryAccess::getUserRight('deleteuserid', $category->deleteuserid, 2, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
		}
		if ($rightDisplayDelete == 1) {
			$this->tmpl['trash']				= 1;
			$this->tmpl['publishunpublish']	= 1;
			$this->tmpl['approvednotapproved']= 1;// only to see the info
		}
		// - - - - - - - - - - - - - - - - - - - - - 
		// Upload
		$this->tmpl['displayupload']	= 0;
		// USER RIGHT - UPLOAD - - - - - - - - - - - 
		// 2, 2 means that user access will be ignored in function getUserRight for display Delete button
		$rightDisplayUpload = 0;// default is to null (all users cannot upload)
		if (!empty($category)) {
			$rightDisplayUpload = PhocaGalleryAccess::getUserRight('uploaduserid', $category->uploaduserid, 2, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
		}
	
		if ($rightDisplayUpload == 1) {
			$this->tmpl['displayupload']	= 1;
			$document->addCustomTag(PhocaGalleryRenderFront::renderOnUploadCategoryJS());
			$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionUploadJS((int)$this->tmpl['maxuploadchar']));
		}		
		
		$this->tmpl['displaycreatecat']	= 0;
		if (($rightDisplayUpload == 1) && ($this->tmpl['enable_direct_subcat'] == 1)) 
		{			
			$this->tmpl['displaycreatecat']	= 1;
			$document->addCustomTag(PhocaGalleryRenderFront::renderOnUploadCategoryJS());
			$document->addCustomTag(PhocaGalleryRenderFront::renderDescriptionCreateSubCatJS((int)$this->tmpl['maxcreatecatchar']));
		}		
		
		// - - - - - - - - - - - - - - - - - - - - - 
		
		// USER RIGHT - ACCESS - - - - - - - - - - - 
		$rightDisplay = 1;//default is set to 1 (all users can see the category)
		
		if (!empty($category)) {
			$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $category->accessuserid, 0, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), $display_access_category);
		}
		if ($rightDisplay == 0) {
			
			$app->redirect(JRoute::_($this->tmpl['pl'], false), JText::_('COM_PHOCAGALLERY_NOT_AUTHORISED_ACTION'));
			exit;
		}		
		// - - - - - - - - - - - - - - - - - - - - - 
		
		// 1. GEOTAGGING CATEGORY
		$map['longitude'] 	= '';// will be used for 1. default_geotagging to not display pane and 2. to remove pane (line cca 1554)
		$map['latitude'] 	= '';
		if (isset($category->latitude) && $category->latitude != '' && $category->latitude != 0
			&& isset($category->longitude) && $category->longitude != '' && $category->longitude != 0 ) {
			
			$map['longitude']	= $category->longitude;
			$map['latitude']	= $category->latitude;
			$map['zoom']		= $category->zoom;
			$map['geotitle'] 	= $category->geotitle;
			$map['description'] = $category->description;
			if ($map['geotitle'] == '') {
				$map['geotitle']	= $category->title;
			}	
		} else {
			$this->tmpl['displayicongeo'] = 0;
		}
		
		
		
		// Image next to Category in Categories View in Category View is ordered by Random as default
		phocagalleryimport('phocagallery.ordering.ordering');
		$categoryImageOrdering = PhocaGalleryOrdering::getOrderingString($this->tmpl['categoryimageordering']);
		$categoryImageOrderingCV = PhocaGalleryOrdering::getOrderingString($this->tmpl['categoryimageorderingcv']);
		
		
		
		
		
		// = = = = = = = = = = = = = = = = = = = = 
		// BOXES
		// = = = = = = = = = = = = = = = = = = = =
		
		// Information because of height of box (if they are used not by all images)
		$this->tmpl['displayiconextlink1box'] 	= 0;
		$this->tmpl['displayiconextlink2box'] 	= 0;
		$this->tmpl['displayiconvmbox'] 		= 0;
		$this->tmpl['displayicongeobox'] 		= 0;
		
        $iS 	= 0;
		$iCV 	= 0;
		$items		= array();// Category View
		$itemsCV	= array();// Category List (Categories View) in Category View


		// ----------------------------------------
		// PARENT FOLDERS(I) or Back Button STANDARD
		// ----------------------------------------		
		/*$menu 	= &JSite::getMenu();
		// Set Back Button to CATEGORIES VIEW
		$itemsLink	= $menu->getItems('link', 'index.php?option=com_phocagallery&view=categories');

		$itemId	= 0;
		if(isset($itemsLink[0])) {
			$itemId = $itemsLink[0]->id;
		}	
		$backLink = 'index.php?option=com_phocagallery&view=categories&Itemid='.$itemId;*/
		
		$posItemid		= $posItemidNull = $backLinkItemId = false;
		$backLink 		= PhocaGalleryRoute::getCategoriesRoute();
		$posItemidNull 	= strpos($backLink, "Itemid=0");
		$posItemid 		= strpos($backLink, "Itemid=");
		if ($posItemidNull === false && $posItemid) {
			$backLinkItemId = 1;
		}
	   

		$parentCategory = $this->get('parentcategory');  

		if ($display_back_button == 1) {
			if (!empty($parentCategory)) {
				
				$items[$iS] = $parentCategory;
				// USER RIGHT - ACCESS - - - - - - - - - - -
				// Should be the link to parentcategory displayed
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), $display_access_category);
				
				// Display Key Icon (in case we want to display unaccessable categories in list view)
				$rightDisplayKey  = 1;
				if ($display_access_category == 1) {
					// we simulate that we want not to display unaccessable categories
					// so we get rightDisplayKey = 0 then the key will be displayed
					if (!empty($parentCategory)) {
						$rightDisplayKey = PhocaGalleryAccess::getUserRight ('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
					}
				}
				// - - - - - - - - - - - - - - - - - - - - -

				if ($rightDisplay > 0) {
					$items[$iS]->cls					= 'pg-box-parentfolder';
					$items[$iS]->slug			 		= $items[$iS]->id . ':' . $items[$iS]->alias;
					$items[$iS]->item_type				= "parentfolder";
					$items[$iS]->linkthumbnailpath 		= PhocaGalleryImageFront::displayBackFolder('medium', $rightDisplayKey);
					$items[$iS]->extm					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->exts					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->numlinks 				= 0;// We are in category view
					$items[$iS]->link 					= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$items[$iS]->button 				= &$folderButton;
					$items[$iS]->button->methodname 	= '';
					$items[$iS]->displayicondetail 		= 0;				   
					$items[$iS]->displayicondownload 	= 0;
					$items[$iS]->displayiconfolder 		= 0;
					$items[$iS]->displayname 			= 0;
					$items[$iS]->displayiconvm 			= '';
					$items[$iS]->startpiclens 			= 0;
					$items[$iS]->trash					= 0;
					$items[$iS]->publishunpublish		= 0;
					$items[$iS]->approvednotapproved	= 0;
					$items[$iS]->enable_cooliris		= 0;
					$items[$iS]->overlib				= 0;
					$items[$iS]->displayicongeo			= 0;
					$items[$iS]->type					= 0;
					$items[$iS]->camerainfo				= 0;
					$items[$iS]->displayiconextlink1	= 0;
					$items[$iS]->displayiconextlink2	= 0;
					$items[$iS]->description			= '';
					$items[$iS]->altvalue				= '';
					$iS++;
				} else {
					// There is no right to see the data but the object exists (because it was loaded from database
					// Destroy it
					unset($items[$iS]);
				}
			} else { // Back button to categories list if it exists
				if ($backLinkItemId != 0 && $display_categories_back_button == 1) {
					$items[$iS] 						= new JObject();
					$items[$iS]->cls					= 'pg-box-backbtn';
					$items[$iS]->link 					= JRoute::_($backLink);
					$items[$iS]->title					= JTEXT::_('COM_PHOCAGALLERY_CATEGORY_LIST');
					$items[$iS]->item_type 				= "categorieslist";
					$items[$iS]->linkthumbnailpath 		= PhocaGalleryImageFront::displayBackFolder('medium', 1);
					$items[$iS]->extm					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->exts					= $items[$iS]->linkthumbnailpath;
					$items[$iS]->numlinks 				= 0;// We are in category view
					$items[$iS]->button 				= &$folderButton;
					$items[$iS]->button->methodname 	= '';
					$items[$iS]->displayicondetail 		= 0;				   
					$items[$iS]->displayicondownload	= 0;
					$items[$iS]->displayiconfolder 		= 0;
					$items[$iS]->displayname 			= 0;
					$items[$iS]->displayiconvm 			= '';
					$items[$iS]->startpiclens 			= 0;
					$items[$iS]->trash					= 0;
					$items[$iS]->publishunpublish		= 0;
					$items[$iS]->approvednotapproved	= 0;
					$items[$iS]->enable_cooliris		= 0;
					$items[$iS]->overlib				= 0;
					$items[$iS]->displayicongeo			= 0;
					$items[$iS]->type					= 0;
					$items[$iS]->camerainfo				= 0;
					$items[$iS]->displayiconextlink1	= 0;
					$items[$iS]->displayiconextlink2	= 0;
					$items[$iS]->description			= '';
					$items[$iS]->altvalue				= '';
					$iS++;
				}
			}
		}
		
	
		// ----------------------------------------
		// PARENT FOLDERS(II) or Back Button CATEGORIES VIEW IN CATEGORY VIEW
		// ---------------------------------------- 
		if ($display_back_button_cv == 1 && $this->tmpl['displaycategoriescv'] == 1) {
			if (!empty($parentCategory)) {
				
				$itemsCV[$iCV] = clone $parentCategory;
				// USER RIGHT - ACCESS - - - - - - - - - - -
				// Should be the link to parentcategory displayed
				$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), $display_access_category);
				
				// Display Key Icon (in case we want to display unaccessable categories in list view)
				$rightDisplayKey  = 1;
				if ($display_access_category == 1) {
					// we simulate that we want not to display unaccessable categories
					// so we get rightDisplayKey = 0 then the key will be displayed
					if (!empty($parentCategory)) {
						$rightDisplayKey = PhocaGalleryAccess::getUserRight ('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
					}
				}
				// - - - - - - - - - - - - - - - - - - - - -
				
				if ($rightDisplay > 0) {
					$itemsCV[$iCV]->cls					= 'pg-box-parentfolder-cv';
					$itemsCV[$iCV]->slug 				= $itemsCV[$iCV]->id.':'.$itemsCV[$iCV]->alias;
					$itemsCV[$iCV]->item_type 			= "parentfoldercv";
					$itemsCV[$iCV]->linkthumbnailpath	= PhocaGalleryImageFront::displayBackFolder('medium', $rightDisplayKey);
					$itemsCV[$iCV]->extm				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->exts				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->numlinks 			= 0;// We are in category view
					$itemsCV[$iCV]->link = JRoute::_('index.php?option=com_phocagallery&view=category&id='. $itemsCV[$iCV]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
					$itemsCV[$iCV]->type				= 3;
					$itemsCV[$iCV]->altvalue			= '';
					$iCV++;
				} else {
					// There is no right to see the data but the object exists (because it was loaded from database
					// Destroy it
					unset($itemsCV[$iCV]);
				}
			} else { // Back button to categories list if it exists
				if ($backLinkItemId != 0 && $display_categories_back_button_cv == 1) {
					$itemsCV[$iCV] 						= new JObject();
					$itemsCV[$iCV]->cls					= 'pg-box-backbtn-cv';
					$itemsCV[$iCV]->link 				= $backLink;
					$itemsCV[$iCV]->title				= JTEXT::_('COM_PHOCAGALLERY_CATEGORY_LIST');
					$itemsCV[$iCV]->item_type 			= "categorieslistcv";
					$itemsCV[$iCV]->linkthumbnailpath	= PhocaGalleryImageFront::displayBackFolder('medium', 1);
					$itemsCV[$iCV]->extm				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->exts				= $itemsCV[$iCV]->linkthumbnailpath;
					$itemsCV[$iCV]->numlinks = 0;// We are in category view
					$itemsCV[$iCV]->link 				= JRoute::_( $itemsCV[$iCV]->link );
					$itemsCV[$iCV]->type				= 3;
					$itemsCV[$iCV]->altvalue			= '';
					$iCV++;
				}
			}
		}
	
		
		// ----------------------------------------
		// SUB FOLDERS(1) STANDARD
		// ----------------------------------------
		// Display subcategories on every page
		if ($display_subcat_page == 1) {

			$subCategory = $this->get('subcategory'); 
			$totalSubCat = count($subCategory);
			
			if ((int)$this->tagId > 0) {$subCategory = array();}// No subcategories for tag searching

			if (!empty($subCategory)) {
				$items[$iS] = &$subCategory;
		  
				for($iSub = 0; $iSub < $totalSubCat; $iSub++) {
					
					$items[$iS] = &$subCategory[$iSub];
					// USER RIGHT - ACCESS - - - - - - - - - - 
					$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), $display_access_category);
					
					// Display Key Icon (in case we want to display unaccessable categories in list view)
					$rightDisplayKey  = 1;
					if ($display_access_category == 1) {
						// we simulate that we want not to display unaccessable categories
						// so we get rightDisplayKey = 0 then the key will be displayed
						if (!empty($items[$iS])) {
							$rightDisplayKey = PhocaGalleryAccess::getUserRight('accessuserid', $items[$iS]->accessuserid, $items[$iS]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
						}
					}
					// - - - - - - - - - - - - - - - - - - - -
				
					if ($rightDisplay > 0) {
						$items[$iS]->cls					= 'pg-box-subfolder';
						$items[$iS]->slug 					= $items[$iS]->id.':'.$items[$iS]->alias;
						$items[$iS]->item_type 				= "subfolder";
						
						$numlinks 	= $model->getCountItem($items[$iS]->id);//Should be get from main subcategories query
						if (isset($numlinks[0]) && $numlinks[0] > 0) {
							$items[$iS]->numlinks = (int)$numlinks[0];
						} else {
							$items[$iS]->numlinks = 0;
						}
						$extImage = PhocaGalleryImage::isExtImage($items[$iS]->extid);
						if ($extImage) {
							
							if ($this->tmpl['categoryimageordering'] != 10) {
								$imagePic		= PhocaGalleryImageFront::getRandomImageRecursive($items[$iS]->id, $categoryImageOrdering, 1);
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($imagePic->exts, $imagePic->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
								
							} else {
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($items[$iS]->exts,$items[$iS]->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
								
								
								$imagePic->extw = $items[$iS]->extw;
								$imagePic->exth = $items[$iS]->exth;
							}
							// in case category is locked or no extm exists
							
							$items[$iS]->linkthumbnailpath	= $fileThumbnail->linkthumbnailpath;
							$items[$iS]->extm	= $fileThumbnail->extm;
							$items[$iS]->exts	= $fileThumbnail->exts;
							
							$items[$iS]->exthswitch = $items[$iS]->extwswitch = 0;
							if ($imagePic->extw != '') {
								$extw 				= explode(',',$imagePic->extw);
								$items[$iS]->extw		= $extw[1];
								$items[$iS]->extwswitch	= $extw[0];
							}
							if ($imagePic->exth != '') {
								$exth 				= explode(',',$imagePic->exth);
								$items[$iS]->exth	= $exth[1];
								$items[$iS]->exthswitch	= $exth[0];
							}
							$items[$iS]->extpic		= $fileThumbnail->extpic;
						} else {
							if ($this->tmpl['categoryimageordering'] != 10) {
								$randomImage 	= PhocaGalleryImageFront::getRandomImageRecursive($items[$iS]->id, $categoryImageOrdering);
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($randomImage, 'medium', $rightDisplayKey, 'display_category_icon_image');
								
								
							} else {
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($items[$iS]->filename, 'medium', $rightDisplayKey, 'display_category_icon_image');
							}
							
							$items[$iS]->linkthumbnailpath  	= $fileThumbnail->rel;
						}
						$items[$iS]->link 					= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$items[$iS]->button 				= &$folderButton;
						$items[$iS]->button->methodname 	= '';
						$items[$iS]->displayicondetail 		= 0;				   
						$items[$iS]->displayicondownload 	= 0;
						$items[$iS]->displayiconfolder 		= $this->tmpl['displayiconfolder'];
						$items[$iS]->displayname 			= $this->tmpl['displayname'];
						$items[$iS]->displayiconvm 			= '';
						$items[$iS]->startpiclens 			= 0;
						$items[$iS]->trash					= 0;
						$items[$iS]->publishunpublish		= 0;
						$items[$iS]->approvednotapproved	= 0;
						$items[$iS]->enable_cooliris			= 0;
						$items[$iS]->overlib				= 0;
						$items[$iS]->displayicongeo			= 0;
						$items[$iS]->type					= 1;
						$items[$iS]->camerainfo				= 0;
						$items[$iS]->displayiconextlink1	= 0;
						$items[$iS]->displayiconextlink2	= 0;
						$items[$iS]->description			= '';
						$items[$iS]->displayiconcommentimg	= '';
						$items[$iS]->altvalue				= '';
						$iS++;
					} else {
						// There is no right to see the data but the object exists (because it was loaded from database
						// Destroy it
						unset($items[$iS]);
					}
				}
			}	
		}
		
		// ----------------------------------------
		// SUB FOLDERS(II) or Back Button CATEGORIES VIEW IN CATEGORY VIEW
		// ----------------------------------------
		//display subcategories on every page
		if ($display_subcat_page_cv == 1 && $this->tmpl['displaycategoriescv'] == 1) {	
			$subCategory = $this->get('subcategory'); 
			$totalSubCat = count($subCategory);
			
			if ((int)$this->tagId > 0) {$subCategory = array();}// No subcategories for tag searching
			
			if (!empty($subCategory)) {
				$itemsCV[$iCV] = &$subCategory;
				
				for($iSub = 0; $iSub < $totalSubCat; $iSub++) {
					
					$itemsCV[$iCV] = &$subCategory[$iSub];
					// USER RIGHT - ACCESS - - - - - - - - - - 
					$rightDisplay = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), $display_access_category);
					
					// Display Key Icon (in case we want to display unaccessable categories in list view)
					$rightDisplayKey  = 1;
					if ($display_access_category == 1) {
						// we simulate that we want not to display unaccessable categories
						// so we get rightDisplayKey = 0 then the key will be displayed
						if (!empty($itemsCV[$iCV])) {
							$rightDisplayKey = PhocaGalleryAccess::getUserRight('accessuserid', $itemsCV[$iCV]->accessuserid, $itemsCV[$iCV]->access, $this->tmpl['user']->authorisedLevels(), $this->tmpl['user']->get('id', 0), 0);
						}
					}
					// - - - - - - - - - - - - - - - - - - - -
				
					if ($rightDisplay > 0) {
					
						$itemsCV[$iCV]->cls					= 'pg-box-subfolder-cv';
						$itemsCV[$iCV]->slug 				= $itemsCV[$iCV]->id.':'.$itemsCV[$iCV]->alias;
						$itemsCV[$iCV]->item_type 			= "subfoldercv";
						$itemsCV[$iCV]->link 				= JRoute::_('index.php?option=com_phocagallery&view=category&id='. $itemsCV[$iCV]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$itemsCV[$iCV]->type				= 4;
						
						
						$numlinks = $model->getCountItem($itemsCV[$iCV]->id);//Should be get from main subcategories query
						if (isset($numlinks[0]) && $numlinks[0] > 0) {
							$itemsCV[$iCV]->numlinks = (int)$numlinks[0];
						} else {
							$itemsCV[$iCV]->numlinks = 0;
						}
						
						$extImage = PhocaGalleryImage::isExtImage($itemsCV[$iCV]->extid);
						if ($extImage) {
						
							if ($this->tmpl['categoryimageordering'] != 10) {
								$imagePic= PhocaGalleryImageFront::getRandomImageRecursive($itemsCV[$iCV]->id, $categoryImageOrderingCV, 1);
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($imagePic->exts, $imagePic->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
							} else {
								$fileThumbnail	= PhocaGalleryImageFront::displayCategoryExtImgOrFolder($itemsCV[$iCV]->exts,$itemsCV[$iCV]->extm, 'medium', $rightDisplayKey, 'display_category_icon_image');
								$imagePic->extw = $itemsCV[$iCV]->extw;
								$imagePic->exth = $itemsCV[$iCV]->exth;
							}
					
							// in case category is locked or no extm exists
							$itemsCV[$iCV]->linkthumbnailpath	= $fileThumbnail->linkthumbnailpath;
							$itemsCV[$iCV]->extm	= $fileThumbnail->extm;
							$itemsCV[$iCV]->exts	= $fileThumbnail->exts;
							
							$itemsCV[$iCV]->exthswitch = $items[$iS]->extwswitch = 0;
							if ($imagePic->extw != '') {
								$extw 						= explode(',',$imagePic->extw);
								$itemsCV[$iCV]->extw		= $extw[1];
								$itemsCV[$iCV]->extwswitch	= $extw[0];
							}
							if ($imagePic->exth != '') {
								$exth 				= explode(',',$imagePic->exth);
								$itemsCV[$iCV]->exth		= $exth[1];
								$itemsCV[$iCV]->exthswitch	= $exth[0];
							}
							$itemsCV[$iCV]->extpic	= $fileThumbnail->extpic;
						} else {							
							if ($this->tmpl['categoryimageordering'] != 10) {
								$randomImage 	= PhocaGalleryImageFront::getRandomImageRecursive($itemsCV[$iCV]->id, $categoryImageOrderingCV);
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($randomImage, 'medium', $rightDisplayKey, 'display_category_icon_image_cv');
							} else {
								$fileThumbnail 	= PhocaGalleryImageFront::displayCategoryImageOrFolder($itemsCV[$iCV]->filename, 'medium', $rightDisplayKey, 'display_category_icon_image_cv');
							}
							$itemsCV[$iCV]->linkthumbnailpath		= $fileThumbnail->rel;
							$itemsCV[$iCV]->altvalue				= '';
							
						}
						$iCV++;
					} else {
						// There is no right to see the data but the object exists (because it was loaded from database
						// Destroy it
						unset($itemsCV[$iCV]);
					}
				}
			}
		}
	
		
		
		// ----------------------------------------
		// IMAGES
		// ----------------------------------------
		// If user has rights to delete or publish or unpublish, unbublished items should be displayed
		if ($rightDisplayDelete == 1) {
			$images	= $model->getData(1, $this->tagId);
			$this->tmpl['pagination']	= &$model->getPagination(1, $this->tagId);
		} else {
			$images	= $model->getData(0, $this->tagId);
			$this->tmpl['pagination']	= &$model->getPagination(0, $this->tagId);
		}
		
		$this->tmpl['ordering']	= &$model->getOrdering();
		
		$totalImg = count($images);
		
		if ($limitStart > 0 ) {
			$this->tmpl['limitstarturl'] = '&limitstart='.$limitStart;
		} else {
			$this->tmpl['limitstarturl'] = '';
		}
		
		$this->tmpl['jakdatajs'] = array();
		$this->tmpl['displayiconcommentimgbox'] = 0;
		for($iM = 0; $iM < $totalImg; $iM++) {
			
			$items[$iS] 					= $images[$iM] ;
			$items[$iS]->cls				= 'pg-box-image';
			$items[$iS]->slug 				= $items[$iS]->id.':'.$items[$iS]->alias;
			$items[$iS]->item_type 			= "image";
			$items[$iS]->linknr 			= '';//Def
			$extImage = PhocaGalleryImage::isExtImage($items[$iS]->extid);
			
			// Get file thumbnail or No Image
			$items[$iS]->exthswitch = $items[$iS]->extwswitch = 0;
			if ($items[$iS]->extm != '') {
				
				if ($items[$iS]->extw != '') {
					$extw 				= explode(',',$items[$iS]->extw);
					$items[$iS]->extw	= $extw[1];
					$items[$iS]->extwswitch	= $extw[0];
				}
				if ($items[$iS]->exth != '') {
					$exth 				= explode(',',$items[$iS]->exth);
					$items[$iS]->exth	= $exth[1];
					$items[$iS]->exthswitch	= $exth[0];
				}
				$items[$iS]->extpic	= 1;
				$items[$iS]->linkthumbnailpath = '';
			} else {
				$items[$iS]->linkthumbnailpath 	= PhocaGalleryImageFront::displayCategoryImageOrNoImage($items[$iS]->filename, 'medium');
			}
			
			if (isset($parentCategory->params)) {
				$items[$iS]->parentcategoryparams = $parentCategory->params;
			}
			
			// Add the first Image as basic image
			if ($this->tmpl['switchimage'] == 1) {
				if ($basicImageSelected == 0) {
				
					if ((int)$this->tmpl['switchwidth'] > 0 && (int)$this->tmpl['switchheight'] > 0 && $this->tmpl['switchfixedsize'] == 1 ) {
					
						$wHArray	= array( 'id' => 'PhocaGalleryobjectPicture', 'border' =>'0', 'width' => $this->tmpl['switchwidth'], 'height' => $this->tmpl['switchheight']);
						$wHString	= ' id="PhocaGalleryobjectPicture"  border="0" width="'. $this->tmpl['switchwidth'].'" height="'.$this->tmpl['switchheight'].'"';
					} else {
						$wHArray 	= array( 'id' => 'PhocaGalleryobjectPicture', 'border' =>'0');
						$wHString	= ' id="PhocaGalleryobjectPicture"  border="0"';
					}
				
					if (isset($items[$iS]->extpic) && $items[$iS]->extpic != '') {
						$this->tmpl['basicimage']	= JHtml::_( 'image', $items[$iS]->extl, '', $wHArray);
					} else {
						$this->tmpl['basicimage']	= JHtml::_( 'image', str_replace('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath), '', $wHString);
						
					}
					$basicImageSelected = 1;
				}
			}
			
			$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($items[$iS]->filename, 'large');
			$thumbLinkM	= PhocaGalleryFileThumbnail::getThumbnailName($items[$iS]->filename, 'medium');
			$imgLinkOrig= JURI::base(true) . '/' .PhocaGalleryFile::getFileOriginal($items[$iS]->filename, 1);
			if ($this->tmpl['detailwindow'] == 7) {
				$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$items[$iS]->catslug.'&id='. $items[$iS]->slug.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
			} else {
				$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$items[$iS]->catslug.'&id='. $items[$iS]->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
			} 
			$imgLink	= $thumbLink->rel;
			
			if ($extImage) {
				$imgLink		= $items[$iS]->extl;
				$imgLinkOrig	= $items[$iS]->exto;
			}
			
			// Detail Window
			if ($this->tmpl['detailwindow'] == 2 ) {
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2		= $imgLink;
				$items[$iS]->linkother	= $imgLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
			
			} else if ( $this->tmpl['detailwindow'] == 3 ) {
			
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
			
			} else if ( $this->tmpl['detailwindow'] == 5 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $siteLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			} else if ( $this->tmpl['detailwindow'] == 6 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
				// jak data js
				switch ($this->tmpl['jakdescription']) {
					case 0:
						$descriptionJakJs = '';
					break;
					
					case 2:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes( $items[$iS]->description));
					break;
					
					case 3:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title));
						if ($items[$iS]->description != '') {
							$descriptionJakJs .='<br />' .PhocaGalleryText::strTrimAll(addslashes($items[$iS]->description));
						}
					break;
					
					case 1:
					default:
						$descriptionJakJs = PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title));
					break;
				}
				$items[$iS]->linknr		= $iM;
				$this->tmpl['jakdatajs'][$iS] = "{alt: '".PhocaGalleryText::strTrimAll(addslashes($items[$iS]->title))."',";
				if ($descriptionJakJs != '') {
					$this->tmpl['jakdatajs'][$iS] .= "description: '".$descriptionJakJs."',";
				} else {
					$this->tmpl['jakdatajs'][$iS] .= "description: ' ',";
				}
				
				
				if ($extImage) {
					$this->tmpl['jakdatajs'][$iS] .= "small: {url: '".$items[$iS]->extm."'},"
					."big: {url: '".$items[$iS]->extl."'} }";
				} else {
					$this->tmpl['jakdatajs'][$iS] .= "small: {url: '".htmlentities(JURI::base(true).'/'.PhocaGalleryText::strTrimAll(addslashes($thumbLinkM->rel)))."'},"
					."big: {url: '".htmlentities(JURI::base(true).'/'.PhocaGalleryText::strTrimAll(addslashes($imgLink)))."'} }";
				}
			} 
			
			// Added Slimbox URL settings
			
			else if ( $this->tmpl['detailwindow'] == 8 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $imgLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			} 
			
			else if ( $this->tmpl['detailwindow'] == 9 ) {
				
				$items[$iS]->link 		= $siteLink;
				$items[$iS]->link2 		= $siteLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			}

			else if ( $this->tmpl['detailwindow'] == 10 ) {
				
				$items[$iS]->link 		= $imgLink;
				$items[$iS]->link2 		= $imgLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			}
			
			else {
			
				$items[$iS]->link 		= $siteLink;
				$items[$iS]->link2 		= $siteLink;
				$items[$iS]->linkother	= $siteLink;
				$items[$iS]->linkorig	= $imgLinkOrig;
				
			}
			
			// Buttons, e.g. shadowbox:
			// button - click on image
			// button2 - click on zoom icon (cannot be the same as click on image because of duplicity of images)
			// buttonOther - other detail window like download, geotagging
			$items[$iS]->button 			= &$button;
			$items[$iS]->button2 			= &$button2;
			$items[$iS]->buttonother 		= &$buttonOther;
			
			$items[$iS]->displayicondetail 	= $this->tmpl['displayicondetail'];
			$items[$iS]->displayicondownload= $this->tmpl['displayicondownload'];
			$items[$iS]->displayiconfolder 	= 0;
			$items[$iS]->displayname 		= $this->tmpl['displayname'];
			$items[$iS]->displayiconvm 		= '';
			$items[$iS]->startpiclens 		= $this->tmpl['startpiclens'] ;
			$items[$iS]->type				= 2;
			
			// Trash icon
			if ($this->tmpl['trash'] == 1) {
				$items[$iS]->trash	= 1;
			} else {
				$items[$iS]->trash	= 0;
			}
			
			// Publish Unpublish icon
			if ($this->tmpl['publishunpublish'] == 1) {
				$items[$iS]->publishunpublish	= 1;
			} else {
				$items[$iS]->publishunpublish	= 0;
			}
			
			// Publish Unpublish icon
			if ($this->tmpl['approvednotapproved'] == 1) {
				$items[$iS]->approvednotapproved	= 1;
			} else {
				$items[$iS]->approvednotapproved	= 0;
			}
			
			// PICLENS 
			if($this->tmpl['enablecooliris']) { 
				$items[$iS]->enable_cooliris	= 1; 
			} else { 
				$items[$iS]->enable_cooliris	= 0; 
			}
			
			// 2. GEOTAGGING IMAGE
			// We have checked the category so if geotagging is enabled
			// and there is no geotagging data for category, then $this->tmpl['displayicongeo'] = 0;
			// so we need to check it for the image too, we need to set the $this->tmpl['displayicongeoimage'] for image only
			// we are in loop now
			$this->tmpl['displayicongeoimagetmp'] = 0;
			if ($this->tmpl['displayicongeoimage'] == 1) {
				
				$this->tmpl['displayicongeoimagetmp'] = 1;
				if (isset($items[$iS]->latitude) && $items[$iS]->latitude != '' && $items[$iS]->latitude != 0
					&& isset($items[$iS]->longitude) && $items[$iS]->longitude != '' && $items[$iS]->longitude != 0 ) {
				} else {
					$this->tmpl['displayicongeoimagetmp'] = 0;
				}
			}
			
			// GEOTAGGING
			if($this->tmpl['displayicongeo'] == 1 || $this->tmpl['displayicongeoimagetmp'] == 1) { 
				$items[$iS]->displayicongeo		= 1;
				$this->tmpl['displayicongeobox']	= 1;// because of height of box			
			} else { 
				$items[$iS]->displayicongeo	= 0; 
			}
			
			// Set it back because of loop
			$this->tmpl['displayicongeoimagetmp'] = 0;
			
			// CAMERA INFO 
			if($this->tmpl['displaycamerainfo'] == 1) { 
				$items[$iS]->camerainfo			= 1;
			} else { 
				$items[$iS]->camerainfo			= 0;	 
			}
			
			// EXT LINK
			$items[$iS]->displayiconextlink1	= 0;
			if (isset($items[$iS]->extlink1)) {
				$items[$iS]->extlink1	= explode("|", $items[$iS]->extlink1, 4);
				
				if (isset($items[$iS]->extlink1[0]) && $items[$iS]->extlink1[0] != '' && isset($items[$iS]->extlink1[1])) {
					$items[$iS]->displayiconextlink1		= 1;
					$this->tmpl['displayiconextlink1box'] = 1;// because of height of box
					if (!isset($items[$iS]->extlink1[2])) {
						$items[$iS]->extlink1[2] = '_self';
					}
					if (!isset($items[$iS]->extlink1[3]) || $items[$iS]->extlink1[3] == 1) {
						$items[$iS]->extlink1[4] = JHtml::_('image', 'components/com_phocagallery/assets/images/icon-extlink1.'.$this->tmpl['formaticon'], JText::_($items[$iS]->extlink1[1]));
						$items[$iS]->extlink1[5] = '';
					} else {
						$items[$iS]->extlink1[4] = $items[$iS]->extlink1[1];
						$items[$iS]->extlink1[5] = 'style="text-decoration:underline"';
					}
				} else {
					$items[$iS]->displayiconextlink1		= 0;
				}
			}
			
			$items[$iS]->displayiconextlink2		= 0;
			if (isset($items[$iS]->extlink2)) {
				$items[$iS]->extlink2	= explode("|", $items[$iS]->extlink2, 4);
				if (isset($items[$iS]->extlink2[0]) && $items[$iS]->extlink2[0] != '' && isset($items[$iS]->extlink2[1])) {
					$items[$iS]->displayiconextlink2		= 1;
					$this->tmpl['displayiconextlink2box'] = 1;// because of height of box
					if (!isset($items[$iS]->extlink2[2])) {
						$items[$iS]->extlink2[2] = '_self';
					}
					if (!isset($items[$iS]->extlink2[3]) || $items[$iS]->extlink2[3] == 1) {
						$items[$iS]->extlink2[4] = JHtml::_('image', 'components/com_phocagallery/assets/images/icon-extlink2.'.$this->tmpl['formaticon'], JText::_($items[$iS]->extlink2[1]));
						$items[$iS]->extlink2[5] = '';
					}else {
						$items[$iS]->extlink2[4] = $items[$iS]->extlink2[1];
						$items[$iS]->extlink2[5] = 'style="text-decoration:underline"';
					}
				} else {
					$items[$iS]->displayiconextlink2		= 0;
				}
			}
				
			
			// OVERLIB
			if (!empty($items[$iS]->description)) {
				$divPadding = 'padding:5px;';
			} else {
				$divPadding = 'padding:0px;margin:0px;';
			}
			
			// Resize image in overlib by rate
			$wHOutput = array();
			if (isset($items[$iS]->extpic) && $items[$iS]->extpic != '') {
				if ((int)$this->tmpl['overlibimagerate'] > 0) {
					$imgSize	= @getimagesize($items[$iS]->extl);
					$wHOutput	= PhocaGalleryImage::getTransformImageArray($imgSize, $this->tmpl['overlibimagerate']);
				}
				
				$oImg		= JHtml::_( 'image', $items[$iS]->extl, '' /*htmlspecialchars( addslashes($items[$iS]->title)) */, $wHOutput );
			} else {
				if ((int)$this->tmpl['overlibimagerate'] > 0) {
					$thumbL 	= str_replace ('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath);
					$imgSize	= @getimagesize($thumbL);
					$wHOutput	= PhocaGalleryImage::getTransformImageArray($imgSize, $this->tmpl['overlibimagerate']);
				}
				$oImg	= JHtml::_( 'image', str_replace ('phoca_thumb_m_','phoca_thumb_l_',$items[$iS]->linkthumbnailpath), '' /*$items[$iS]->title*/, $wHOutput );
			}
			
			switch ($enable_overlib) {
				
				case 1:
				case 4:
					$uBy = '';//Uploaded by ...
					if ($enable_overlib == 4 && isset($items[$iS]->usernameno) && $items[$iS]->usernameno != '') {
						$uBy = '<div>' . JText::_('COM_PHOCAGALLERY_UPLOADED_BY') . ' <strong>'.$items[$iS]->usernameno.'</strong></div>';
					}
					$items[$iS]->overlib			= 1;
					$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".htmlspecialchars( addslashes('<div class="pg-overlib"><center>' . $oImg . "</center></div>" . $uBy ))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, BGCLASS,'bgPhocaClass', FGCOLOR, '".$this->tmpl['olfgcolor']."', BGCOLOR, '".$this->tmpl['olbgcolor']."', TEXTCOLOR, '".$this->tmpl['oltfcolor']."', CAPCOLOR, '".$this->tmpl['olcfcolor']."');\""
				. " onmouseout=\"return nd();\" ";
				
				break;
				
				case 2:
				case 5:
					$uBy = '';//Uploaded by ...
					if ($enable_overlib == 5 && isset($items[$iS]->usernameno) && $items[$iS]->usernameno != '') {
						$uBy = '<div>' . JText::_('COM_PHOCAGALLERY_UPLOADED_BY') . ' <strong>'.$items[$iS]->usernameno.'</strong></div>';
					}
					$items[$iS]->overlib			= 2;
					$items[$iS]->description		= str_replace("\n", '<br />', $items[$iS]->description);
					$items[$iS]->description		= str_replace("\r", ' ', $items[$iS]->description);
					$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".htmlspecialchars( addslashes('<div class="pg-overlib"><div style="'.$divPadding.'">'.$items[$iS]->description.'</div></div>'. $uBy))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, CSSCLASS, TEXTFONTCLASS, 'fontPhocaClass', FGCLASS, 'fgPhocaClass', BGCLASS, 'bgPhocaClass', CAPTIONFONTCLASS,'capfontPhocaClass', CLOSEFONTCLASS, 'capfontclosePhocaClass');\""
				. " onmouseout=\"return nd();\" ";
				break;
				
				case 3:
				case 6:
					$uBy = '';//Uploaded by ...
					if ($enable_overlib == 6 && isset($items[$iS]->usernameno) && $items[$iS]->usernameno != '') {
						$uBy = '<div>' . JText::_('COM_PHOCAGALLERY_UPLOADED_BY') . ' <strong>'.$items[$iS]->usernameno.'</strong></div>';
					}
					$items[$iS]->overlib			= 3;
					$items[$iS]->description		= str_replace("\n", '<br />', $items[$iS]->description);
					$items[$iS]->description		= str_replace("\r", ' ', $items[$iS]->description);
					$items[$iS]->overlib_value 		= " onmouseover=\"return overlib('".PhocaGalleryText::strTrimAll(htmlspecialchars( addslashes( '<div class="pg-overlib"><div style="text-align:center"><center>' . $oImg . '</center></div><div style="'.$divPadding.'">' . $items[$iS]->description . '</div></div>' . $uBy)))."', CAPTION, '". htmlspecialchars( addslashes($items[$iS]->title))."', BELOW, RIGHT, BGCLASS,'bgPhocaClass', FGCLASS,'fgPhocaClass', FGCOLOR, '".$this->tmpl['olfgcolor']."', BGCOLOR, '".$this->tmpl['olbgcolor']."', TEXTCOLOR, '".$this->tmpl['oltfcolor']."', CAPCOLOR, '".$this->tmpl['olcfcolor']."');\""
				. " onmouseout=\"return nd();\" ";
				break;
				
				default:
					$items[$iS]->overlib			= 0;
					$items[$iS]->overlib_value		= '';
				break;
			}
			
			
						
			// VirtueMart link 
			
			if ($this->tmpl['displayiconvm'] == 1) {
			
				phocagalleryimport('phocagallery.virtuemart.virtuemart');				
				$vmLink	= PhocaGalleryVirtueMart::getVmLink($items[$iS]->vmproductid, $errorMsg);
				
				if (!$vmLink) {
					$items[$iS]->displayiconvm	= '';
				} else {
					$items[$iS]->displayiconvm	= 1;
					$items[$iS]->vmlink			= $vmLink;
					$this->tmpl['displayiconvmbox']	= 1;// because of height of box
				}
				
			} else {
				$items[$iS]->displayiconvm = '';
			}
			// End VM Link
			
			// V O T E S - IMAGES
			if ((int)$this->tmpl['displayratingimg'] == 1) {
				$items[$iS]->votescountimg		= 0;
				$items[$iS]->votesaverageimg	= 0;
				$items[$iS]->voteswidthimg		= 0;
				$votesStatistics	= PhocaGalleryRateImage::getVotesStatistics((int)$items[$iS]->id);
				if (!empty($votesStatistics->count)) {
					$items[$iS]->votescountimg = $votesStatistics->count;
				}
				if (!empty($votesStatistics->average)) {
					$items[$iS]->votesaverageimg = $votesStatistics->average;
					if ($items[$iS]->votesaverageimg > 0) {
						$items[$iS]->votesaverageimg 	= round(((float)$items[$iS]->votesaverageimg / 0.5)) * 0.5;
						$items[$iS]->voteswidthimg		= 16 * $items[$iS]->votesaverageimg;
					} else {
						$items[$iS]->votesaverageimg = (int)0;// not float displaying
					}
					
				}
			}
			
			
			$items[$iS]->displayiconcommentimg	= 0;
			// C O M M E N T S - IMAGES
			if ((int)$this->tmpl['displaycommentimg'] == 1) {
				$items[$iS]->displayiconcommentimg	= 1;
				$this->tmpl['displayiconcommentimgbox']	= 1;// because of height of box
				
			}
			
			// ALT VALUE
			$altValue	= PhocaGalleryRenderFront::getAltValue($this->tmpl['altvalue'], $items[$iS]->title, $items[$iS]->description, $items[$iS]->metadesc);
			$items[$iS]->altvalue				= $altValue;
			
			// TITLE TAG - Description Output in Title Tag
			$imgAlt = $imgTitle = '';
		
			// Some methods cannot use Alt because of conflicting with Title and popup methods
			if ($this->tmpl['detailwindow'] == 3 || $this->tmpl['detailwindow'] == 9 || $this->tmpl['detailwindow'] == 10) {
				$imgAlt 	= $items[$iS]->altvalue;
				$imgTitle	= $items[$iS]->title;
				if ($imgAlt == $imgTitle) {
					$imgAlt = '';
				}
				$items[$iS]->oimgalt = $imgAlt;
			} else {
				$items[$iS]->oimgalt = $altValue;
			}
			
			
			// TITLE TAG - Detail
			if ($this->tmpl['detailwindow'] == 9 || $this->tmpl['detailwindow'] == 10) {
				$detailAlt 		= $items[$iS]->altvalue;
				$detailTitle	= $items[$iS]->title;
				if ($detailAlt == $detailTitle) {
					$detailAlt = '';
				}
			} else {
				$detailAlt 		= JText::_('COM_PHOCAGALLERY_IMAGE_DETAIL');
				$detailTitle 	= JText::_('COM_PHOCAGALLERY_IMAGE_DETAIL');
			}
			$items[$iS]->oimgaltdetail 		= $detailAlt;
			$items[$iS]->oimgtitledetail 	= $detailTitle;
		
			$titleDesc = '';
			if ($this->tmpl['displaytitleindescription'] == 1) {
				$titleDesc .= $items[$iS]->title;
				if ($items[$iS]->description != '' && $titleDesc != '') {
					$titleDesc .= ' - ';
				}
			}
			
			if ($this->tmpl['detailwindow'] == 8 && $this->tmpl['displaydescriptiondetail'] == 1) {
				$items[$iS]->odesctitletag = strip_tags($titleDesc).strip_tags($items[$iS]->description);
			} else {
				$items[$iS]->odesctitletag = strip_tags($imgTitle);
			}
			
			// Overlib class
			if ($items[$iS]->overlib == 0) {
				$items[$iS]->ooverlibclass = array('class' => 'pg-image');
			} else { 
				$items[$iS]->ooverlibclass = array('class' => 'pimo pg-image');
			}
			
			// Tags
			$items[$iS]->otags = '';
			if ($this->tmpl['display_tags_links'] == 1 || $this->tmpl['display_tags_links'] == 3) {
				$items[$iS]->otags = PhocaGalleryTag::displayTags($items[$iS]->id);
				if ($items[$iS]->otags != '') {
					$this->tmpl['displaying_tags_true'] = 1;
				}
			}
		
			
			$iS++;
		}
	

		// END IMAGES
	
		
		// Upload Form - - - - - - - - - - - - -
		// Set FTP form
		$ftp = !JClientHelper::hasCredentials('ftp');

		// PARAMS - Upload size
		$this->tmpl['uploadmaxsize'] = $this->params->get( 'upload_maxsize', 3000000 );
		
		$this->assignRef('session', JFactory::getSession());
		//$this->assignRef('uploadmaxsize', $upload_maxsize);
		// END Upload Form - - - - - - - - - - - -
			
		
		// V O T E S - CATEGORY
		// Only registered (VOTES + COMMENTS)
		$this->tmpl['notregistered'] 	= true;
		$this->tmpl['name']		= '';
		if ($access > 0) {
			$this->tmpl['notregistered'] 	= false;
			$this->tmpl['name']				= $this->tmpl['user']->name;
		}	
			
		// VOTES Statistics
		if ((int)$this->tmpl['displayrating'] == 1 && (int)$id > 0) {
			$this->tmpl['votescount']		= 0;
			$this->tmpl['votesaverage'] 	= 0;
			$this->tmpl['voteswidth']		= 0;
			$votesStatistics	= PhocaGalleryRateCategory::getVotesStatistics((int)$id);
			if (!empty($votesStatistics->count)) {
				$this->tmpl['votescount'] = $votesStatistics->count;
			}
			if (!empty($votesStatistics->average)) {
				$this->tmpl['votesaverage'] = $votesStatistics->average;
				if ($this->tmpl['votesaverage'] > 0) {
					$this->tmpl['votesaverage'] 	= round(((float)$this->tmpl['votesaverage'] / 0.5)) * 0.5;
					$this->tmpl['voteswidth']		= 22 * $this->tmpl['votesaverage'];
				} else {
					$this->tmpl['votesaverage'] = (int)0;// not float displaying
				}
				
			}
			if ((int)$this->tmpl['votescount'] > 1) {
				$this->tmpl['votestext'] = 'COM_PHOCAGALLERY_VOTES';
			} else {
				$this->tmpl['votestext'] = 'COM_PHOCAGALLERY_VOTE';
			}
		
			// Already rated?
			$this->tmpl['alreadyrated']	= PhocaGalleryRateCategory::checkUserVote( (int)$id, (int)$this->tmpl['user']->id );
		}
		
		

		// COMMENTS
		if ((int)$this->tmpl['displaycomment'] == 1 && (int)$id > 0) {
			$document->addScript(JURI::base(true).'/components/com_phocagallery/assets/js/comments.js');
			$document->addCustomTag(PhocaGalleryRenderFront::renderCommentJS((int)$this->tmpl['maxcommentchar']));
		
			$this->tmpl['alreadycommented'] 	= PhocaGalleryCommentCategory::checkUserComment( (int)$id, (int)$this->tmpl['user']->id );
			$commentItem				= PhocaGalleryCommentCategory::displayComment( (int)$id );
	
			$this->assignRef( 'commentitem',		$commentItem);
		}

		
		
		// - - - - - - - - - - - - - - - -
		// TABS
		// - - - - - - - - - - - - - - - -
		$this->tmpl['displaytabs']	= 0;
		$this->tmpl['currenttab']	= 0;
		
		if ((int)$id > 0) {
			$displayTabs	= 0;
			
			// R A T I N G
			if ((int)$this->tmpl['displayrating'] == 0) {
				$currentTab['rating'] = -1;	
			} else {
				$currentTab['rating'] = $displayTabs;
				$displayTabs++;
			}
			
			// C O M M E N T S
			if ((int)$this->tmpl['displaycomment'] == 0) {
				$currentTab['comment'] = -1;
			} else {
				$currentTab['comment'] = $displayTabs;
				$displayTabs++;	
			}
			
			// S T A T I S T I C S
			if ((int)$this->tmpl['displaycategorystatistics'] == 0) {
				$currentTab['statistics'] = -1;
			} else {
				$currentTab['statistics'] = $displayTabs;
				$displayTabs++;

				
				$this->tmpl['displaymaincatstat']			= $this->params->get( 'display_main_cat_stat', 1 );
				$this->tmpl['displaylastaddedcatstat']	= $this->params->get( 'display_lastadded_cat_stat', 1 );
				$this->tmpl['displaymostviewedcatstat']	= $this->params->get( 'display_mostviewed_cat_stat', 1 );
				$this->tmpl['countlastaddedcatstat']		= $this->params->get( 'count_lastadded_cat_stat', 3 );
				$this->tmpl['countmostviewedcatstat']		= $this->params->get( 'count_mostviewed_cat_stat', 3 );
				
				
				if ($this->tmpl['displaymaincatstat'] == 1) {
					$numberImgP		= $model->getCountImages($id, 1);
					$this->tmpl['numberimgpub'] 	= $numberImgP->countimg;
					$numberImgU		= $model->getCountImages($id, 0);
					$this->tmpl['numberimgunpub'] = $numberImgU->countimg;
					$categoryViewed	= $model->getHits($id);
					$this->tmpl['categoryviewed'] = $categoryViewed->catviewed;
				}
				
				// M O S T   V I E W E D   I M A G E S 
				//$this->tmpl['mostviewedimg'] = array();
				if ($this->tmpl['displaymostviewedcatstat'] == 1) {
					$mostViewedImages	= $model->getStatisticsImages($id, 'hits', 'DESC', $this->tmpl['countmostviewedcatstat']);
					for($i = 0; $i <  count($mostViewedImages); $i++) {
						$itemMVI 		=& $mostViewedImages[$i];
						$itemMVI->button 				= &$button;
						$itemMVI->button2 				= &$button2;
						$itemMVI->buttonother 			= &$buttonOther;
						$itemMVI->displayicondetail 	= $this->tmpl['displayicondetail'];
						$itemMVI->displayname 			= $this->tmpl['displayname'];
						$itemMVI->type		 			= 2;
						
						$altValue	= PhocaGalleryRenderFront::getAltValue($this->tmpl['altvalue'], $itemMVI->title, $itemMVI->description, $itemMVI->metadesc);
						$itemMVI->altvalue				= $altValue;
						
						$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($itemMVI->filename, 'large');
						$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemMVI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$imgLink	= JURI::base(true) . '/'.$thumbLink->rel;
						if ($this->tmpl['detailwindow'] == 2 || $this->tmpl['detailwindow'] == 8) {
							$itemMVI->link 		= $imgLink;
						} else {
							$itemMVI->link 		= $siteLink;
						}
						//$this->tmpl['mostviewedimg'][] = $itemMVI;
						if ($itemMVI->extw != '') {
							$extw 				= explode(',',$itemMVI->extw);
							$itemMVI->extw		= $extw[1];
						}
						if ($itemMVI->exth != '') {
							$exth 				= explode(',',$itemMVI->exth);
							$itemMVI->exth	= $exth[1];
						}
					}
					
					$this->tmpl['mostviewedimg'] = $mostViewedImages;
				}
				
				// L A S T   A D D E D   I M A G E S
				//$this->tmpl['lastaddedimg'] = array();
				if ($this->tmpl['displaylastaddedcatstat'] == 1) {			
					$lastAddedImages	= $model->getStatisticsImages($id, 'date', 'DESC', $this->tmpl['countlastaddedcatstat']);
					for($i = 0; $i <  count($lastAddedImages); $i++) {
						$itemLAI 		=& $lastAddedImages[$i];
						$itemLAI->link 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemLAI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$itemLAI->button 				= &$button;
						$itemLAI->button2 				= &$button2;
						$itemLAI->buttonother 			= &$buttonOther;
						$itemLAI->displayicondetail 	= $this->tmpl['displayicondetail'];
						$itemLAI->displayname 			= $this->tmpl['displayname'];
						$itemLAI->type		 			= 2;
						
						$altValue	= PhocaGalleryRenderFront::getAltValue($this->tmpl['altvalue'], $itemLAI->title, $itemLAI->description, $itemLAI->metadesc);
						$itemLAI->altvalue				= $altValue;
						
						$thumbLink	= PhocaGalleryFileThumbnail::getThumbnailName($itemLAI->filename, 'large');
						$siteLink 	= JRoute::_('index.php?option=com_phocagallery&view=detail&catid='.$category->slug.'&id='. $itemLAI->slug.'&tmpl=component'.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int')  );
						$imgLink	= JURI::base(true) . '/'.$thumbLink->rel;
						if ($this->tmpl['detailwindow'] == 2 || $this->tmpl['detailwindow'] == 8) {
							$itemLAI->link 		= $imgLink;
						} else {
							$itemLAI->link 		= $siteLink;
						}
						//$this->tmpl['lastaddedimg'][] = $itemLAI;
						
						if ($itemLAI->extw != '') {
							$extw 				= explode(',',$itemLAI->extw);
							$itemLAI->extw		= $extw[1];
						}
						if ($itemLAI->exth != '') {
							$exth 				= explode(',',$itemLAI->exth);
							$itemLAI->exth	= $exth[1];
						}
					}
					$this->tmpl['lastaddedimg'] = $lastAddedImages;
				}
			}
			
			// G E O T A G G I N G
			if ((int)$this->tmpl['displaycategorygeotagging'] == 0) {
				$currentTab['geotagging'] = -1;
			} else if ( $map['longitude'] == '') {
				$currentTab['geotagging'] = -1;
			} else if ( $map['latitude'] == '') {
				$currentTab['geotagging'] = -1;
			} else {
				$currentTab['geotagging'] = $displayTabs;
				$displayTabs++;	
				
				$this->tmpl['googlemapsapikey'] 			= $this->params->get( 'google_maps_api_key', '' );
				$this->tmpl['categorymapwidth'] 			= $this->params->get( 'category_map_width', '' );
				$this->tmpl['categorymapheight'] 			= $this->params->get( 'category_map_height', 400 );
		
			}
			// = = = = = = = = = = 
			// U P L O A D
			// = = = = = = = = = =
			$this->tmpl['ftp'] 		= !JClientHelper::hasCredentials('ftp');
			
			
			// SEF problem
			$isThereQM = false;
			$isThereQM = preg_match("/\?/i", $this->tmpl['action']);

			if ($isThereQM) {
				$amp = '&amp;';
			} else {
				$amp = '?';
			}
			$isThereTab = false;
			$isThereTab = preg_match("/tab=/i", $this->tmpl['action']);
			
			if ((int)$this->tmpl['displayupload'] == 0) {
				$currentTab['upload'] = -1;
			}else {
				$currentTab['upload'] = $displayTabs;
				$displayTabs++;	
			}
			
			
			if ((int)$this->tmpl['ytbupload'] == 0 || (int)$this->tmpl['displayupload'] == 0) {
				$currentTab['ytbupload'] = -1;
			}else {
				$currentTab['ytbupload'] = $displayTabs;
				$displayTabs++;	
			}
			
			if ((int)$this->tmpl['enablemultiple'] < 1 || (int)$this->tmpl['displayupload'] == 0) {
				$currentTab['multipleupload'] = -1;
			}else {
				$currentTab['multipleupload'] = $displayTabs;
				$displayTabs++;	
			}
			
			if ((int)$this->tmpl['enablejava'] < 1 || (int)$this->tmpl['displayupload'] == 0) {
				$currentTab['javaupload'] = -1;
			}else {
				$currentTab['javaupload'] = $displayTabs;
				$displayTabs++;	
			}
		
			$this->tmpl['displaytabs']	= $displayTabs;
			$this->tmpl['currenttab']	= $currentTab;
			
			
			// - - - - - - - - - - -
			// Upload
			// - - - - - - - - - - -
			if ((int)$this->tmpl['displayupload'] == 1) {
				$sU							= new PhocaGalleryFileUploadSingle();
				$sU->returnUrl				= $this->tmpl['action'] . $amp .'task=upload&amp;'. $this->session->getName().'='.$this->session->getId()
											.'&amp;'. JUtility::getToken().'=1&amp;viewback=category&tab='.$this->tmpl['currenttab']['upload'];
				$sU->tab					= $this->tmpl['currenttab']['upload'];
				$this->tmpl['su_output']	= $sU->getSingleUploadHTML(1);
				$this->tmpl['su_url']		= $this->tmpl['action'] . $amp .'task=upload&amp;'. $this->session->getName().'='.$this->session->getId()
											.'&amp;'. JUtility::getToken().'=1&amp;viewback=category&tab='.$this->tmpl['currenttab']['upload'];
			}
			
			// - - - - - - - - - - -
			// Youtube Upload (single upload form can be used)
			// - - - - - - - - - - -
			
		
			if ((int)$this->tmpl['ytbupload'] == 1 && $this->tmpl['displayupload'] == 1 ) {
				$sYU						= new PhocaGalleryFileUploadSingle();
				$sYU->returnUrl				= $this->tmpl['action'] . $amp .'task=ytbupload&amp;'. $this->session->getName().'='.$this->session->getId()
											.'&amp;'. JUtility::getToken().'=1&amp;viewback=category&tab='.$this->tmpl['currenttab']['ytbupload'];
				$sYU->tab					= $this->tmpl['currenttab']['ytbupload'];
				$this->tmpl['syu_output']	= $sYU->getSingleUploadHTML(1);
				$this->tmpl['syu_url']		= $this->tmpl['action'] . $amp .'task=ytbupload&amp;'. $this->session->getName().'='.$this->session->getId()
											.'&amp;'. JUtility::getToken().'=1&amp;viewback=category&tab='.$this->tmpl['currenttab']['ytbupload'];
			}
			
			
			// - - - - - - - - - - -
			// Multiple Upload
			// - - - - - - - - - - -
			// Get infos from multiple upload
			$muFailed						= JRequest::getVar( 'mufailed', '0', '', 'int' );
			$muUploaded						= JRequest::getVar( 'muuploaded', '0', '', 'int' );
			$this->tmpl['mu_response_msg']	= $muUploadedMsg 	= '';
			
			if ($muUploaded > 0) {
				$muUploadedMsg = JText::_('COM_PHOCAGALLERY_COUNT_UPLOADED_IMG'). ': ' . $muUploaded;
			}
			if ($muFailed > 0) {
				$muFailedMsg = JText::_('COM_PHOCAGALLERY_COUNT_NOT_UPLOADED_IMG'). ': ' . $muFailed;
			}
			if ($muFailed > 0 && $muUploaded > 0) {
				$this->tmpl['mu_response_msg'] = '<div class="pgunsetmsg">'
				.JText::_('COM_PHOCAGALLERY_COUNT_UPLOADED_IMG'). ': ' . $muUploaded .'<br />'
				.JText::_('COM_PHOCAGALLERY_COUNT_NOT_UPLOADED_IMG'). ': ' . $muFailed.'</div>';
			} else if ($muFailed > 0 && $muUploaded == 0) {
				$this->tmpl['mu_response_msg'] = '<div class="pgerrormsg">'
				.JText::_('COM_PHOCAGALLERY_COUNT_NOT_UPLOADED_IMG'). ': ' . $muFailed.'</div>';
			} else if ($muFailed == 0 && $muUploaded > 0){
				$this->tmpl['mu_response_msg'] = '<div class="pgsuccessmsg">'
				.JText::_('COM_PHOCAGALLERY_COUNT_UPLOADED_IMG'). ': ' . $muUploaded.'</div>';
			} else {
				$this->tmpl['mu_response_msg'] = '';
			}
			
			if((int)$this->tmpl['enablemultiple']  == 1 && (int)$this->tmpl['displayupload'] == 1) {
			
				PhocaGalleryFileUploadMultiple::renderMultipleUploadLibraries();
				$mU						= new PhocaGalleryFileUploadMultiple();
				$mU->frontEnd			= 1;
				$mU->method				= $this->tmpl['multipleuploadmethod'];
				$mU->url				= $this->tmpl['action'] . $amp .'controller=category&task=multipleupload&amp;'
										 . $this->session->getName().'='.$this->session->getId().'&'
										 . JUtility::getToken().'=1&tab='.$this->tmpl['currenttab']['multipleupload'];
				$mU->reload				= $this->tmpl['action'] . $amp 
										. $this->session->getName().'='.$this->session->getId().'&'
										. JUtility::getToken().'=1&tab='.$this->tmpl['currenttab']['multipleupload'];
				$mU->maxFileSize		= PhocaGalleryFileUploadMultiple::getMultipleUploadSizeFormat($this->tmpl['uploadmaxsize']);
				$mU->chunkSize			= '1mb';
				$mU->imageHeight		= $this->tmpl['multipleresizeheight'];
				$mU->imageWidth			= $this->tmpl['multipleresizewidth'];
				$mU->imageQuality		= 100;
				$mU->renderMultipleUploadJS(0, $this->tmpl['multipleuploadchunk']);
				$this->tmpl['mu_output']= $mU->getMultipleUploadHTML();
			}
			
			// - - - - - - - - - - -
			// Java Upload
			// - - - - - - - - - - -
			if((int)$this->tmpl['enablejava']  == 1 && (int)$this->tmpl['displayupload'] == 1) {
				$jU							= new PhocaGalleryFileUploadJava();
				$jU->width					= $this->tmpl['javaboxwidth'];
				$jU->height					= $this->tmpl['javaboxheight'];
				$jU->resizewidth			= $this->tmpl['multipleresizewidth'];
				$jU->resizeheight			= $this->tmpl['multipleresizeheight'];
				$jU->uploadmaxsize			= $this->tmpl['uploadmaxsize'];
				$jU->returnUrl				= $this->tmpl['action'] . $amp 
											. $this->session->getName().'='.$this->session->getId().'&'
											. JUtility::getToken().'=1&tab='.$this->tmpl['currenttab']['javaupload'];
				$jU->url					= $this->tmpl['action'] . $amp .'controller=category&task=javaupload&amp;'
											. $this->session->getName().'='.$this->session->getId().'&'
											. JUtility::getToken().'=1&amp;tab='.$this->tmpl['currenttab']['javaupload'];
				$jU->source 				= JURI::root(true).'/components/com_phocagallery/assets/java/jupload/wjhk.jupload.jar';
				$this->tmpl['ju_output']	= $jU->getJavaUploadHTML();
				
			}
		}
		
		
		
		
		// ADD STATISTICS
		if ((int)$id > 0) {
			$model->hit($id);
		}
		
		// ADD JAK DATA CSS style
		if ( $this->tmpl['detailwindow'] == 6 ) {
			$document->addCustomTag('<script type="text/javascript">'
			. 'var dataJakJs = ['
			. implode($this->tmpl['jakdatajs'], ',')
			. ']'
			. '</script>');
		}
		
		// Detail Window - will be popup or not
		if ($this->tmpl['detailwindow'] == 7) {
			$this->tmpl['tmplcom']			= '';
			$this->tmpl['tmplcomcomments']	= '';

		} else {
			$this->tmpl['tmplcom'] 			= '&tmpl=component';
			$this->tmpl['tmplcomcomments'] 	= '&tmpl=component';
			
		}
		if ($this->tmpl['display_comment_nopup'] == 1) {
			$this->tmpl['tmplcomcomments']	= '';
		}
		
		
		
		// Height of all boxes
		$this->tmpl['imageheight'] 			= PhocaGalleryImage::correctSize($this->tmpl['imageheight'], 100, 100, 0);
		$this->tmpl['imagewidth'] 			= PhocaGalleryImage::correctSize($this->tmpl['imagewidth'], 100, 120, 20);
		$this->tmpl['imageheight']['boxsize']	= PhocaGalleryImage::setBoxSize(
			$this->tmpl['imageheight'],
			$this->tmpl['imagewidth'], 
			$this->tmpl['displayname'], 
			$this->tmpl['displayicondetail'], 
			$this->tmpl['displayicondownload'], 
			$this->tmpl['displayiconvmbox'], 
			$this->tmpl['startpiclens'], 
			$this->tmpl['trash'], 
			$this->tmpl['publishunpublish'], 
			$this->tmpl['displayicongeobox'], 
			$this->tmpl['displaycamerainfo'], 
			$this->tmpl['displayiconextlink1box'], 
			$this->tmpl['displayiconextlink2box'], 
			$this->tmpl['categoryboxspace'], 
			$this->tmpl['displayimageshadow'], 
			$this->tmpl['displayratingimg'],  
			$this->tmpl['displayiconfolder'], 
			$this->tmpl['imgdescboxheight'], 
			$this->tmpl['approvednotapproved'], 
			$this->tmpl['displayiconcommentimgbox'],
			$this->tmpl['displaying_tags_true']);
			
		
		
		if ( $this->tmpl['displayimageshadow'] != 'none' ) {		
			$this->tmpl['imageheight']['size']	= $this->tmpl['imageheight']['size'] + 18;
			$this->tmpl['imagewidth']['size'] 	= $this->tmpl['imagewidth']['size'] + 18;
		}
		
		
		
		//$this->assignRef( 'params' ,			$this->params);
		$this->assignRef( 'map',				$map);		
		$this->assignRef( 'items' ,				$items);// Category View
		$this->assignRef( 'itemscv' ,			$itemsCV);// Categories View in Category View
		$this->assignRef( 'category' ,			$category);
		$this->assignRef( 'button',				$button );
		$this->assignRef( 'button2',			$button2 );
		$this->assignRef( 'buttonother',		$buttonOther );
		
		$this->_prepareDocument($category);
		parent::display($tpl);
	}
	
	protected function _prepareDocument($category) {
		
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway 	= $app->getPathway();
		//$this->params		= &$app->getParams();
		$title 		= null;
		
		$this->tmpl['gallerymetakey'] 		= $this->params->get( 'gallery_metakey', '' );
		$this->tmpl['gallerymetadesc'] 		= $this->params->get( 'gallery_metadesc', '' );
		
		$menu = $menus->getActive();
		
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('JGLOBAL_ARTICLES'));
		}

		$title = $this->params->get('page_title', '');
		
		if (empty($title)) {
			$title = htmlspecialchars_decode($app->getCfg('sitename'));
		} else if ($app->getCfg('sitename_pagetitles', 0)) {
			$title = JText::sprintf('JPAGETITLE', htmlspecialchars_decode($app->getCfg('sitename')), $title);
		}
		
		if (isset($category->title) && $category->title != '') {
			$title = $title .' - ' .  $category->title;
		}
		
		$this->document->setTitle($title);
		
		if (isset($category->metadesc) && $category->metadesc != '') {
			$this->document->setDescription($category->metadesc);
		} else if ($this->tmpl['gallerymetadesc'] != '') {
			$this->document->setDescription($this->tmpl['gallerymetadesc']);
		} else if ($this->params->get('menu-meta_description', '')) {
			$this->document->setDescription($this->params->get('menu-meta_description', ''));
		} 

		if (isset($category->metadesc) && $category->metakey != '') {
			$this->document->setMetadata('keywords', $category->metakey);
		} else if ($this->tmpl['gallerymetakey'] != '') {
			$this->document->setMetadata('keywords', $this->tmpl['gallerymetakey']);
		} else if ($this->params->get('menu-meta_keywords', '')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords', ''));
		}

		if ($app->getCfg('MetaTitle') == '1' && $this->params->get('menupage_title', '')) {
			$this->document->setMetaData('title', $this->params->get('page_title', ''));
		}

		/*if ($app->getCfg('MetaAuthor') == '1') {
			$this->document->setMetaData('author', $this->item->author);
		}

		/*$mdata = $this->item->metadata->toArray();
		foreach ($mdata as $k => $v) {
			if ($v) {
				$this->document->setMetadata($k, $v);
			}
		}*/
		
	}
	
	/**
	 * Method to add Breadcrubms in Phoca Gallery
	 * @param array $category Object array of Category
	 * @param int $rootId Id of Root Category
	 * @param int $displayStyle Displaying of Breadcrubm - Nothing, Category Name, Menu link with Name
	 * @return string Breadcrumbs
	 */
	function _addBreadCrumbs($category, $rootId, $displayStyle)
	{
	    $app = JFactory::getApplication();
		$i = 0;
	    while (isset($category->id))
	    {
			$crumbList[$i++] = $category;
			if ($category->id == $rootId)
			{
				break;
			}

	        $db =& JFactory::getDBO();
	        $query = 'SELECT *' .
	            ' FROM #__phocagallery_categories AS c' .
	            ' WHERE c.id = '.(int) $category->parent_id.
	            ' AND c.published = 1';
	        $db->setQuery($query);
	        $rows = $db->loadObjectList('id');
			if (!empty($rows))
			{
				$category = $rows[$category->parent_id];
			}
			else
			{
				$category = '';
			}
		//	$category = $rows[$category->parent_id];
	    }

	    $pathway 		=& $app->getPathway();
		$pathWayItems 	= $pathway->getPathWay();
		$lastItemIndex 	= count($pathWayItems) - 1;

	    for ($i--; $i >= 0; $i--)
	    {
			// special handling of the root category
			if ($crumbList[$i]->id == $rootId) 
			{
				switch ($displayStyle) 
				{
					case 0:	// 0 - only menu link
						// do nothing
						break;
					case 1:	// 1 - menu link with category name
						// replace the last item in the breadcrumb (menu link title) with the current value plus the category title
						$pathway->setItemName($lastItemIndex, $pathWayItems[$lastItemIndex]->name . ' - ' . $crumbList[$i]->title);
						break;
					case 2:	// 2 - only category name
						// replace the last item in the breadcrumb (menu link title) with the category title
						$pathway->setItemName($lastItemIndex, $crumbList[$i]->title);
						break;
				}
			} 
			else 
			{
				$pathway->addItem($crumbList[$i]->title, JRoute::_('index.php?option=com_phocagallery&view=category&id='. $crumbList[$i]->id.':'.$crumbList[$i]->alias.'&Itemid='. JRequest::getVar('Itemid', 0, '', 'int') ));
			}
	    }
	}	
}
?>
