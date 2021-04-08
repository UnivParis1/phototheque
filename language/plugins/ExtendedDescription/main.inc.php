<?php
/*
Plugin Name: Extended Description
Version: 2.9.0
Description: Add multilinguale descriptions, banner, NMB, category name, etc...
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=175
Author: P@t & Grum
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

define('EXTENDED_DESC_PATH' , PHPWG_PLUGINS_PATH . basename(dirname(__FILE__)) . '/');


global $conf;

$extdesc_conf = array(
  'more'           => '<!--more-->',
  'complete'       => '<!--complete-->',
  'up-down'        => '<!--up-down-->',
  'not_visible'    => '<!--hidden-->',
  'mb_not_visible' => '<!--mb-hidden-->'
);

$conf['ExtendedDescription'] = isset($conf['ExtendedDescription']) ?
  array_merge($extdesc_conf, $conf['ExtendedDescription']) :
  $extdesc_conf;


include_once(EXTENDED_DESC_PATH . 'include/events.inc.php');
include_once(EXTENDED_DESC_PATH . 'include/functions.inc.php');

if (script_basename() == 'admin' or script_basename() == 'popuphelp')
{
  include_once(EXTENDED_DESC_PATH . 'include/admin.inc.php');

  add_event_handler('get_popup_help_content', 'extended_desc_popup', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
  add_event_handler('loc_begin_admin_page', 'add_ed_help');
  add_event_handler('get_admin_plugin_menu_links', 'extdesc_admin_menu');
}


// main
add_event_handler ('get_extended_desc',  'get_extended_desc');
add_event_handler ('render_page_banner', 'get_extended_desc');
// categories
add_event_handler ('render_category_name',        'parse_lang_tag');
add_event_handler ('render_category_description', 'get_extended_desc', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
// tags
add_event_handler ('render_tag_name',   'parse_lang_tag');
add_event_handler ('render_tag_url',    'get_user_language_tag_url', 40);
add_event_handler ('get_tag_alt_names', 'ed_get_all_alt_names', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
add_event_handler ('get_tag_name_like_where', 'ed_name_like_where');
// element
add_event_handler ('render_element_name',        'parse_lang_tag');
add_event_handler ('render_element_description', 'get_extended_desc', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
// mail/nbm
add_event_handler ('nbm_render_user_customize_mail_content', 'get_extended_desc');
add_event_handler ('mail_group_assign_vars',                 'extended_desc_mail_group_assign_vars');
// removals
add_event_handler ('loc_end_index_category_thumbnails', 'ext_remove_cat', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
add_event_handler ('loc_end_index_thumbnails',          'ext_remove_image', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
add_event_handler ('get_categories_menu_sql_where',     'ext_remove_menubar_cats');
