<?php

function plugin_activate()
{
  $query = '
SELECT
    value
  FROM '.CONFIG_TABLE.'
  WHERE param=\'statistics\'
;';
  $result = pwg_query($query);
  if ($row = pwg_db_fetch_assoc($result))
  {
    if (!preg_match('/^a:/', $row['value']))
    {
      $old_conf = explode("," , $row['value']);
      
      $conf_statistics = array(
        'content'       => $old_conf[2],
        'header'        => ($old_conf[0] == 'on'),
        'tail'          => ($old_conf[1] == 'on'),
        'exclude_admin' => ($old_conf[3] == 'on'),
        'exclude_guest' => ($old_conf[4] == 'on'),
        );

      $query = '
UPDATE '.CONFIG_TABLE.'
  SET value = \''.pwg_db_real_escape_string(serialize($conf_statistics)).'\'
  WHERE param=\'statistics\'
;';
      pwg_query($query);
    }
  }
}

function plugin_install()
{
  $conf_statistics = array(
    'content' => '',
    'header' => false,
    'tail' => true,
    'exclude_admin' => false,
    'exclude_guest' => false,
    );
  
  $query = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
  VALUES (
    \'statistics\',
    \''.pwg_db_real_escape_string(serialize($conf_statistics)).'\',
    \'Parameters of Statistics plugin\'
  )
;';
  pwg_query($query);
}

function plugin_uninstall()
{
  $query = '
DELETE FROM '.CONFIG_TABLE.'
  WHERE param=\'statistics\'
;';
  pwg_query($query);
}
?>
