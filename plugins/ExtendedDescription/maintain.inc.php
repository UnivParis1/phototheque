<?php

function plugin_activate()
{
  // Update all url name for tags
  include_once('main.inc.php');
  $query = 'SELECT * FROM '.TAGS_TABLE.';';
  $result = pwg_query($query);

  $datas = array();
  while ($row = pwg_db_fetch_assoc($result))
  {
    array_push(
      $datas,
      array(
        'id' => $row['id'],
        'url_name' => trigger_change('render_tag_url', $row['name'])
        )
      );
  }

  if (!empty($datas))
  {
    mass_updates(
      TAGS_TABLE,
      array('primary' => array('id'), 'update' => array('url_name')),
      $datas
      );
  }
}

?>