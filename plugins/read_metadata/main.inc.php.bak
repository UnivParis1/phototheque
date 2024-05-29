<?php
/*
Plugin Name: Read Metadata
Version: 14.0.a
Description: Read metadata in piwigo photo
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=829
Author: ddtddt
Author URI: http://temmii.com/piwigo/
Has Settings: webmaster
*/

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

global $prefixeTable;

define('READ_METADATA_DIR' , basename(dirname(__FILE__)));
define('READ_METADATA_PATH' , PHPWG_PLUGINS_PATH . READ_METADATA_DIR . '/');
define('READ_METADATA_ADMIN',get_root_url().'admin.php?page=plugin-'.READ_METADATA_DIR);

add_event_handler('loading_lang', 'read_metadata_loading_lang');	  
function read_metadata_loading_lang(){
  load_language('plugin.lang', READ_METADATA_PATH);
}

  // Plugin for admin
if (script_basename() == 'admin')   
{
  include_once(dirname(__FILE__).'/initadmin.php');
}

?>