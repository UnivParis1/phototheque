<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

function plugin_uninstall($plugin_id)
{
  global $conf;
  @unlink( PHPWG_ROOT_PATH.$conf['data_location'].'plugins/'.$plugin_id.'.dat' );
}
?>
