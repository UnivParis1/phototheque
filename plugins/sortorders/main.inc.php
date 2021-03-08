<?php
/*
Plugin Name: SortOrders
Version: 1.2.0
Description: Select which sort orders that should be avalible, also adds a random sort order.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=806
Author: Per Sandström
Author URI: https://github.com/persandstrom
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

global $prefixeTable;

define('SORTORDERS_ID',      basename(dirname(__FILE__)));
define('SORTORDERS_PATH' ,   PHPWG_PLUGINS_PATH . SORTORDERS_ID . '/');
define('SORTORDERS_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . SORTORDERS_ID);

add_event_handler('init', 'sortorders_init');

if (defined('IN_ADMIN'))
{
  // file containing all admin handlers functions
  $admin_file = SORTORDERS_PATH . 'include/admin_events.inc.php';

  // admin plugins menu link
  add_event_handler('get_admin_plugin_menu_links', 'sortorders_admin_plugin_menu_links', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}
else{

  // file containing all public handlers functions
  $public_file = SORTORDERS_PATH . 'include/public_events.inc.php';

  // add category prefered image orders
  add_event_handler('get_category_preferred_image_orders', 'get_choosen_sort_orders', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
}

function sortorders_init()
{
  global $conf;
  load_language('plugin.lang', SORTORDERS_PATH);
  $conf['sortorders'] = safe_unserialize($conf['sortorders']);
}
