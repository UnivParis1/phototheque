<?php
defined('SORTORDERS_PATH') or die('Hacking attempt!');

function sortorders_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => l10n('SortOrders'),
    'URL' => SORTORDERS_ADMIN,
    );

  return $menu;
}
