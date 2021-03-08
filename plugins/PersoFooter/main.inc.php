<?php
/*
Plugin Name: Perso Footer
Version: 11.0.a
Description: Add information in the footer
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=554
Author: ddtddt
Author URI: http://temmii.com/piwigo/
Has Settings: webmaster
*/
// +-----------------------------------------------------------------------+
// | Perso Footer plugin for Piwigo by TEMMII                              |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2011 - 2021 ddtddt             http://temmii.com/piwigo/ |
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

define('PFT_DIR' , basename(dirname(__FILE__)));
define('PFT_PATH' , PHPWG_PLUGINS_PATH . PFT_DIR . '/');
define('PFT_ADMIN',get_root_url().'admin.php?page=plugin-'.PFT_DIR);
/*
add_event_handler('get_admin_plugin_menu_links', 'PFT_admin_menu');
function PFT_admin_menu($menu){
  if (is_webmaster()){
	array_push($menu, array(
	  'NAME' => 'Perso Footer',
	  'URL' => PFT_ADMIN));
  } 
  return $menu;
}*/

add_event_handler('loc_end_page_tail', 'pft');
function pft(){
global $page, $pwg_loaded_plugins;
  if ((script_basename() != 'admin') and (isset($page['body_id']) and ($page['body_id'] != 'thePopuphelpPage'))){
	global $template, $conf;
	if (isset($pwg_loaded_plugins['ExtendedDescription'])){add_event_handler('AP_render_content', 'get_user_language_desc');}
	$pat=trigger_change('AP_render_content', $conf['persoFooter']);
	 if (!empty($pat)){
		 $template->assign('PERSO_FOOTER2', $pat);
	}
	$template->set_filename('PERSO_FOOTER', realpath(PFT_PATH.'persofooter.tpl'));	
	$template->append('footer_elements', $template->parse('PERSO_FOOTER', true));
  }
}
?>
