<?php
defined('SORTORDERS_PATH') or die('Hacking attempt!');

global $template, $page, $conf;


// get current tab
$page['tab'] = isset($_GET['tab']) ? $_GET['tab'] : $page['tab'] = 'config';

// plugin tabsheet is not present on photo page
if ($page['tab'] != 'photo')
{
  // tabsheet
  include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
  $tabsheet = new tabsheet();
  $tabsheet->set_id('sortorders');

  $tabsheet->add('config', l10n('Configuration'), SORTORDERS_ADMIN . '-config');
  $tabsheet->select($page['tab']);
  $tabsheet->assign();
}

// include page
include(SORTORDERS_PATH . 'admin/' . $page['tab'] . '.php');

// template vars
$template->assign(array(
  'SORTORDERS_PATH'=> SORTORDERS_PATH, // used for images, scripts, ... access
  'SORTORDERS_ABS_PATH'=> realpath(SORTORDERS_PATH), // used for template inclusion (Smarty needs a real path)
  'SORTORDERS_ADMIN' => SORTORDERS_ADMIN,
  ));

// send page content
$template->assign_var_from_handle('ADMIN_CONTENT', 'sortorders_content');
