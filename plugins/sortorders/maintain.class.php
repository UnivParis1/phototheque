<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class sortorders_maintain extends PluginMaintain
{
  private $default_conf = array(
    'disabled' => array()
    );

  function __construct($plugin_id)
  {
    parent::__construct($plugin_id);
  }

  function install($plugin_version, &$errors=array())
  {
    global $conf;

    if (empty($conf['sortorders']))
    {
      conf_update_param('sortorders', $this->default_conf, true);
    }
    else
    {
      $old_conf = safe_unserialize($conf['sortorders']);
      conf_update_param('sortorders', $old_conf, true);
    }
  }

  function activate($plugin_version, &$errors=array())
  {
  }

  function deactivate()
  {
  }

  function update($old_version, $new_version, &$errors=array())
  {
    $this->install($new_version, $errors);
  }

  function uninstall()
  {
    conf_delete_param('sortorders');
  }
}
