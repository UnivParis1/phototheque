<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

load_language('plugin.lang', STAT_PATH);

$conf_statistics = unserialize($conf['statistics']);

$template->assign(
  array(
    'statisticsCONTENT' => $conf_statistics['content'],
    'STATITICS_HEADER'  => $conf_statistics['header'] ? 'checked="checked"' : '' ,
    'STATISTICS_TAIL'   => $conf_statistics['tail']   ? 'checked="checked"' : '' ,
    'STATISTICS_ADMIN'  => $conf_statistics['exclude_admin']  ? 'checked="checked"' : '' ,
    'STATISTICS_GUEST'  => $conf_statistics['exclude_guest']  ? 'checked="checked"' : '' ,
    )
  );

if (isset($_POST['submit']))
{
  $statistics_content = stripslashes($_POST['statistics_content']);
  
  $conf_statistics = array(
    'content' => $statistics_content,
    'header' => isset($_POST['stat_header']),
    'tail' => isset($_POST['stat_tail']),
    'exclude_admin' => isset($_POST['stat_admin']),
    'exclude_guest' => isset($_POST['stat_guest']),
    );

  $query = '
UPDATE '.CONFIG_TABLE.'
  SET value = \''.pwg_db_real_escape_string(serialize($conf_statistics)).'\'
  WHERE param = \'statistics\'
;';
  pwg_query($query);

  array_push($page['infos'], l10n('statistics_save_config'));
  $template->assign(
    array(
      'statisticsCONTENT' => $statistics_content,
      'STATITICS_HEADER'  => isset($_POST['stat_header']) ? 'checked="checked"' : '' ,
      'STATISTICS_TAIL'   => isset($_POST['stat_tail'])   ? 'checked="checked"' : '' ,
      'STATISTICS_ADMIN'  => isset($_POST['stat_admin'])  ? 'checked="checked"' : '' ,
      'STATISTICS_GUEST'  => isset($_POST['stat_guest'])  ? 'checked="checked"' : '' ,
      )
    );
}

$template->set_filenames(array('plugin_admin_content' => realpath(STAT_PATH . 'admin/stat_admin.tpl')));
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
