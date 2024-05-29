<?php
/*
 Plugin Name: ConcoursPhoto
 Version: 12.0.0
 Description: Concours de photo paramétrable
 Plugin URI: http://piwigo.org/ext/extension_view.php?eid=323
 Author: Tiico
 Author URI:  
 Has Settings: true
*/
/********* Fichier main.inc.php  *********/

/* See CHANGELOG for release informations */

 
if (!defined('PHPWG_ROOT_PATH'))  die('Hacking attempt!');

global $prefixeTable;

define('CONCOURS_VERSION', '12.0.0');       // 


define('CONCOURS_NAME', 'Concours Photo');
define('CONCOURS_ROOT', dirname(__FILE__));
define('CONCOURS_DIR' , basename(dirname(__FILE__)));
define('CONCOURS_CFG_FILE' , CONCOURS_ROOT.'/'.CONCOURS_DIR.'.dat');
define('CONCOURS_CFG_FILE1' , PHPWG_PLUGINS_PATH.CONCOURS_DIR.'.dat');
define('CONCOURS_CFG_DB' , CONCOURS_DIR);
define('CONCOURS_PATH' , PHPWG_PLUGINS_PATH . CONCOURS_DIR . '/');
define('CONCOURS_INC_PATH' , PHPWG_PLUGINS_PATH . CONCOURS_DIR . '/include/');
define('CONCOURS_IMG_PATH' , PHPWG_PLUGINS_PATH . CONCOURS_DIR . '/img/');
define('CONCOURS_ADMIN_PATH' , PHPWG_PLUGINS_PATH . CONCOURS_DIR . '/admin/');
define('CONCOURS_RESULT_FOLDER' , PHPWG_PLUGINS_PATH . CONCOURS_DIR . '/result/');


define('CONCOURS_TABLE' , $prefixeTable . 'concours');
define('CONCOURS_DETAIL_TABLE' , $prefixeTable . 'concours_detail');
define('CONCOURS_DATA_TABLE' , $prefixeTable . 'concours_data');
define('CONCOURS_RESULT_TABLE' , $prefixeTable . 'concours_result');



load_language('plugin.lang', CONCOURS_PATH);

include_once CONCOURS_INC_PATH.'Concours.class.php';
global $page, $template;


$concours = new Concours();

// disable meta to picture page (if param)
add_event_handler('loc_begin_picture',array(&$concours, 'disable_meta_to_picture'));


// Add concours to picture page
add_event_handler('loc_end_picture', array(&$concours, 'display_concours_to_picture')); 
// Add admin page - DEPRECATED 
//add_event_handler('get_admin_plugin_menu_links', array(&$concours, 'concours_admin_menu') );

// MenuBar 
add_event_handler('blockmanager_register_blocks', array(&$concours, 'register_blocks') );
add_event_handler('blockmanager_apply', array(&$concours, 'blockmanager_apply') );

add_event_handler('loc_end_section_init', array(&$concours, 'section_init_concours'));

// Publish result page
add_event_handler('loc_end_index', array(&$concours, 'index_concours'));

// Global vote page (with all thumbnails)
add_event_handler('loc_end_index', array(&$concours, 'index_vote_concours'));


// Add Global note under thumbnail
add_event_handler('loc_end_index_thumbnails', array(&$concours, 'thumbnail_note'), 50, 2);

// Add PWG Stuffs
add_event_handler('get_stuffs_modules', array(&$concours, 'concours_stuffs_module'));

// Add description with contest informations on category
add_event_handler ('loc_end_index', array(&$concours, 'add_contest_desc'));
//, EVENT_HANDLER_PRIORITY_NEUTRAL, 2);



/* +-----------------------------------------------------------------------+
 * | CSS/JS Style                                                          |
 * +-----------------------------------------------------------------------+ */
add_event_handler('loc_end_page_header', 'ConcoursPhoto_css_js');

function ConcoursPhoto_css_js() {
	global $template;
	
	$template->append('head_elements', '<link rel="stylesheet" type="text/css" href="'.CONCOURS_PATH . 'template/style.css">');
	$template->append('head_elements', '<link rel="stylesheet" type="text/css" href="'.CONCOURS_PATH . 'template/style_podium_cat.css">');
}

/* +-----------------------------------------------------------------------+
 * | AJAX Methods                                                          |
 * +-----------------------------------------------------------------------+ */
/*
add_event_handler('ws_add_methods', 'ConcoursPhoto_ws_add_methods');

function ConcoursPhoto_ws_add_methods($arr) {
	require_once('ws/ws_functions.inc.php');
}
*/


set_plugin_data($plugin['id'], $concours)

?>
