<?php
defined('EXTENDED_DESC_PATH') or die('Hacking attempt!');

include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');

global $template, $page;

load_language('plugin.lang', EXTENDED_DESC_PATH);

define('EXTDESC_BASE_URL', get_root_url() . 'admin.php?page=plugin-ExtendedDescription');

// +-----------------------------------------------------------------------+
// | Tabs                                                                  |
// +-----------------------------------------------------------------------+

$tabs = array(
  array(
    'code' => 'lang',
    'label' => l10n('Multilingual'),
    ),
  array(
    'code' => 'extdesc',
    'label' => l10n('Descriptions'),
    ),
  array(
    'code' => 'cat_photo',
    'label' => l10n('Album').'/'.l10n('photo'),
    ),
  array(
    'code' => 'slider',
    'label' => l10n('Carrousel'),
    ),
  array(
    'code' => 'hide',
    'label' => l10n('Hide'),
    ),
  array(
    'code' => 'redirect',
    'label' => l10n('Redirects'),
    ),
  array(
    'code' => 'logged',
    'label' => l10n('Login block'),
    ),
  );

$tab_codes = array_map(
  function ($a) { return $a["code"]; },
  $tabs
  );

if (isset($_GET['tab']) and in_array($_GET['tab'], $tab_codes))
{
  $page['tab'] = $_GET['tab'];
}
else
{
  $page['tab'] = $tabs[0]['code'];
}

$tabsheet = new tabsheet();
foreach ($tabs as $tab)
{
  $tabsheet->add(
    $tab['code'],
    $tab['label'],
    EXTDESC_BASE_URL.'-'.$tab['code']
    );
}
$tabsheet->select($page['tab']);
$tabsheet->assign();

$page['messages'][] = l10n('Extended Description have been successfully installed. Now you can use all its features in most text boxes of Piwigo.');

$template->assign(array(
  'ADMIN_PAGE_TITLE' => 'ExtendedDescription',
  'EXTDESC_PAGE' => $page['tab'],
  'EXTDESC_HELP' => load_language('help.'. $page['tab'] .'.html', EXTENDED_DESC_PATH, array('return'=>true)),
  'EXTENDED_DESC_PATH' => EXTENDED_DESC_PATH,
  'EXTDESC_ADMIN' => get_root_url() . 'admin.php?page=plugin-ExtendedDescription',
  'EXTDESC_TITLES' => array(
    'lang' => l10n('Multilingual descriptions'),
    'extdesc' => l10n('Extended descriptions'),
    'cat_photo' => l10n('Insert an album or a photo'),
    'slider' => l10n('Insert a carousel'),
    'hide' => l10n('Hide elements'),
    'redirect' => l10n('Redirect elements'),
    'logged' => l10n('Login link & logged in block'),
  ),
));

$template->set_filename('extdesc', realpath(EXTENDED_DESC_PATH . 'template/admin/main.tpl'));
$template->assign_var_from_handle('ADMIN_CONTENT', 'extdesc');
