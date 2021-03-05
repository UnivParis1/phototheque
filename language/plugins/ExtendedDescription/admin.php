<?php
defined('EXTENDED_DESC_PATH') or die('Hacking attempt!');

global $template, $page;

load_language('plugin.lang', EXTENDED_DESC_PATH);


if (isset($_GET['tab']))
{
  $template->assign(array(
    'EXTDESC_PAGE' => $_GET['tab'],
    'EXTDESC_HELP' => load_language('help.'. $_GET['tab'] .'.html', EXTENDED_DESC_PATH, array('return'=>true))
    ));
}
else
{
  $page['infos'][] = l10n('Extended Description have been successfully installed. Now you can use all its features in most text boxes of Piwigo.');
}


$template->assign(array(
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
