<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (isset($_GET['page_saved']))
{
  array_push($page['infos'], l10n('ap_saved_page'));
}
if (isset($_GET['page_deleted']))
{
  array_push($page['infos'], l10n('ap_deleted_page'));
}

if (isset($_POST['submit']))
{
  asort($_POST['position'], SORT_NUMERIC);
  $pos = 1;
  foreach($_POST['position'] as $id => $old_pos)
  {
    $num = isset($_POST['hide_'.$id]) ? -1 : +1;
    $query = '
UPDATE ' . ADD_PAGES_TABLE . '
  SET pos = '.$num*abs($pos++).'
  WHERE id = '.$id.'
LIMIT 1
;';
    pwg_query($query);
  }
  array_push($page['infos'], l10n('ap_conf_saved'));
}

if (defined('EXTENDED_DESC_PATH'))
{
  add_event_handler('AP_render_title', 'get_user_language_desc');
}

$languages = get_languages();

$query = 'SELECT id, pos, lang, title, standalone, permalink
FROM '.ADD_PAGES_TABLE.'
ORDER BY ABS(pos) ASC, id ASC
;';
$result = pwg_query($query);

while ($row = pwg_db_fetch_assoc($result))
{
  $row['U_PAGE'] = make_index_url(array('section'=>'page')).'/'.(isset($row['permalink']) ? $row['permalink'] : $row['id']);
  $row['U_EDIT'] = get_root_url().'admin.php?page=plugin-'.AP_DIR.'-edit_page&amp;edit='.$row['id'];
  $row['U_DELETE'] = get_root_url().'admin.php?page=plugin-'.AP_DIR.'-edit_page&amp;edit='.$row['id'].'&amp;delete=';

  $row['title'] = trigger_change('AP_render_title', $row['title']);
  $row['language'] = @$languages[$row['lang']];

  $template->append('pages', $row);
}

$template->assign(array(
  'F_ACTION' => $my_base_url.'&amp;tab=manage',
  'HOMEPAGE' => $conf['AP']['homepage'],
  )
);

$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/template/manage.tpl'));
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>