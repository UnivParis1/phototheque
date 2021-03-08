<?php
/* -----------------------------------------------------------------------------
  Plugin     : Grum Plugin Classes - 3
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  UserStat_AIM : classe to manage plugin integration into plugin menu

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php');

class GPC_AIM extends CommonPlugin
{
  public function __construct($prefixeTable, $filelocation)
  {
    $this->setPluginName("Grum Plugin Classes");
    $this->setPluginNameFiles("gpc");
    parent::__construct($prefixeTable, $filelocation);
  }

  /*
    initialize events call for the plugin
  */
  public function initEvents()
  {
    parent::initEvents();
    add_event_handler('get_admin_plugin_menu_links', array(&$this, 'pluginAdminMenu') );
  }

  public function loadCSS()
  {
    parent::loadCSS();
    GPCCore::addUI('gpcCSS');
  }

  /* ---------------------------------------------------------------------------
  Function needed for plugin activation
  --------------------------------------------------------------------------- */



} // GPC_AIM class


?>
