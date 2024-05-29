<?php
/*
Plugin Name: Statistics
Version: 11.0.a
Description: Add source code like Google Analytics on each page.
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=174
Author: Ruben & Sakkhho
Author URI: http://piwigo.org
Has Settings: webmaster
*/
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
define('STAT_DIR' , basename(dirname(__FILE__)));
define('STAT_PATH' , PHPWG_PLUGINS_PATH . STAT_DIR . '/');

/* add_event_handler('get_admin_plugin_menu_links', 'statistics_admin_menu');
function statistics_admin_menu($menu)
{
  array_push(
    $menu,
    array(
      'NAME' => 'Statistics',
      'URL' => get_admin_plugin_menu_link(STAT_PATH . 'admin/stat_admin.php')
      )
    );
  return $menu;
}
*/
function stat_candoit($type)
{
  global $conf, $user;

  $conf_statistics = unserialize($conf['statistics']);

  if (is_admin() and $conf_statistics['exclude_admin'])
  {
    return false;
  }

  if (is_a_guest() and $conf_statistics['exclude_guest'])
  {
    return false;
  }


  $show_htmlcontent = false;
  if ($conf_statistics['header'] and $type == 'header')
  {
    $show_htmlcontent = true;
  }
  if ($conf_statistics['tail'] and $type == 'tail')
  {
    $show_htmlcontent = true;
  }

  if (!$show_htmlcontent)
  {
    return false;
  }

  return '
<!-- Plugin Statistics -->
'.$conf_statistics['content'].'
<!-- Plugin Statistics -->
';
}

function stat_tail()
{
  global $template;

  if ($code_stat = stat_candoit('tail'))
  {
    $template->append('footer_elements', $code_stat);
  }
}

function stat_header()
{
  global $template;

  if ($code_stat = stat_candoit('header'))
  {
    $template->append('head_elements', $code_stat);
  }
}


add_event_handler('loc_end_page_tail', 'stat_tail');
add_event_handler('loc_end_page_header', 'stat_header');
?>
