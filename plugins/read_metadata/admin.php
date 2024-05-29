<?php
// +-----------------------------------------------------------------------+
// | Read Metadata plugin for piwigo  by TEMMII                            |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2016-2023 ddtddt               http://temmii.com/piwigo/ |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
global $template;
include_once(PHPWG_ROOT_PATH .'admin/include/tabsheet.class.php');

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+
check_status(ACCESS_ADMINISTRATOR);

//-------------------------------------------------------- sections definitions
if (!is_webmaster()){
  array_push($page['errors'], l10n('This section is reserved for the webmaster'));
} else{

if (!isset($_GET['tab']))
    $page['tab'] = 'read';
else
    $page['tab'] = $_GET['tab'];

$tabsheet = new tabsheet();
  $tabsheet->add('read', l10n('Metadata'), READ_METADATA_ADMIN . '-read');
$tabsheet->select($page['tab']);
$tabsheet->assign();

switch ($page['tab'])
{
  case 'read':
$admin_base_url = READ_METADATA_ADMIN.'-read';
if (isset($_GET['showmetadata']) and !isset($_POST['submitreadmetadata'])) {
  check_input_parameter('showmetadata', $_GET, false, PATTERN_ID);
  $_POST['idreadmetadata']=$_GET['showmetadata'];
  $_POST['submitreadmetadata']=1;
}
if(isset($_POST['idreadmetadata2']) and $_POST['idreadmetadata2']!=-1){
  $_POST['idreadmetadata']=$_POST['idreadmetadata2'];
}

if(isset($_POST['idreadmetadata'])){
$template->assign(
  'read',
    array('RM_ID' => $_POST['idreadmetadata']));
}else{
$template->assign(
  'read',
    array('RM_ID' => ''));	
}

    $tab_picture = pwg_query('SELECT id,file,name FROM ' . IMAGES_TABLE . ' order by id;');
	if (pwg_db_num_rows($tab_picture)) {
        while ($info_photos = pwg_db_fetch_assoc($tab_picture)) {
	     if(empty($info_photos['name'])){$legend=$info_photos['file'];}else{$legend=$info_photos['name'];}
			$items = array(
					'PHOTOID' => $info_photos['id'],
					'PHOTOINFO' => $info_photos['id'].' - '.$legend,
				);
			$template->append('info_photos', $items);
        }
    }

if (isset($_POST['submitreadmetadata'])){
  if (isset($_POST['idreadmetadata']) and is_numeric($_POST['idreadmetadata'])){
	$query = 'select id,name,file,path FROM ' . IMAGES_TABLE . ' WHERE id = \''.$_POST['idreadmetadata'].'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$filename=$row['path'];
	if(empty($filename)){
	  $_SESSION['page_infos'] = array(l10n('This ID isn\'t used in your gallery'));
	  redirect($admin_base_url);
	}
	if(exif_imagetype($filename) != IMAGETYPE_JPEG and exif_imagetype($filename) != IMAGETYPE_TIFF_II and exif_imagetype($filename) != IMAGETYPE_TIFF_MM){
	  $_SESSION['page_infos'] = array(l10n('This file type doesn\'t use metadata'));
	  redirect($admin_base_url);		
	}
	$rd_image = new SrcImage($row);
	$name=$row['name'];
	$file=$row['file'];
	$template->assign(
	  'readmetadata',
		array(
		  'RM_NAME' => $name,
		  'RM_FILE' => $file,
		  'RM_SCR' => DerivativeImage::url(IMG_THUMB, $rd_image),
		  'U_SHOWPHOTOADMIN' => 'admin.php?page=photo-'.$_POST['idreadmetadata'],
	));
	/*IPTC*/
	$iptc_result = array();
	$imginfo = array();
	getimagesize($filename, $imginfo);
	if (isset($imginfo['APP13'])){
	  $iptc = iptcparse($imginfo['APP13']);
	  if (is_array($iptc)){
		foreach (array_keys($iptc) as $iptc_key){
          if (isset($iptc[$iptc_key][0])){
           if ($iptc_key == '2#025'){
             $value = implode(',',
               array_map(
                 'clean_iptc_value',
                 $iptc[$iptc_key]
               )
             );
           }else{
             $value = clean_iptc_value($iptc[$iptc_key][0]);
           }
           $iptc_result[$iptc_key] = $value;
          }
        }
      }
	  $template->assign(
	  'readmetadata2',
		array(
		  'RM_IPTCWORDING' => 'IPTC Fields in ',
		  'RM_IPTView' => 'view',
	  ));
      $keys = array_keys($iptc_result);
      sort($keys);
	  foreach ($keys as $key){
		$items['RM_KEY'] = $key;
		$items['RM_VALUE'] = $iptc_result[$key];
		$template->append('rm_iptc', $items);
	  }
	}else{
	  $template->assign(
	    'readmetadata2',
		  array(
		    'RM_IPTCWORDING' => 'no IPTC information ',
	  ));

    }
	
	/*Exif*/
	$exif = exif_read_data($filename);
	foreach ($exif as $key => $section){
		if(is_array($section)){
			$i=0;
		  foreach ($section as $name => $value){
			if($i==0){
			  $items['RM_SECTION'] = $key.'<br>';
			}else{
			  $items['RM_SECTION'] = '';
			}
			$items['RM_KEY'] = $name;
			$items['RM_VALUE'] = $value;
			$template->append('rm_exif', $items);
			$i++;
		  }
		}else{
			$items['RM_SECTION'] = '1';
			$items['RM_KEY'] = $key;
			$items['RM_VALUE'] = $section;
			$template->append('rm_exif', $items);
		}
	}
	$template->assign(
	  'readmetadata3',
		array(
		  'RM_EXIFWORDING' => 'EXIF Fields in ',
	  ));
	  
	#
	#       Read and parse XMP metadata
	#	(ImageMagick PHP extension required)
	#

	//	Check ImageMagick is installed
	if	(	extension_loaded(	'imagick' ) &&
			class_exists(		'imagick' )) { 

		//create new Imagick object from image & get the XMP data
		$RM_IM =			new imagick($filename) ;		
		$RM_XMP =			$RM_IM -> getImageProperties( "xmp:*" ) ;

		// Setup readout
		$headerTxt = 'XMP Properties:' ;
		$template -> assign('XMPdata', $RM_XMP) ;
	}
	else {
		$headerTxt = l10n('Unable to read XMP data. ImageMagick not loaded.') ;
	}

	$template ->	assign('XMPheader', $headerTxt ) ;


	
  }else{
	$_SESSION['page_infos'] = array(l10n('You must choose a photo ID'));
	redirect($admin_base_url);
  }
}
		
		
		
		
  break;
} 

$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/admin.tpl')); 
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
}
?>