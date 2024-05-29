<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template, $conf, $user;

load_language('plugin.lang', CONCOURS_PATH);
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
include_once(CONCOURS_PATH . 'admin/functions.inc.php');
add_event_handler('get_admin_plugin_menu_links', 'localfiles_admin_menu');
$my_base_url = get_root_url().'admin.php?page=plugin-'.CONCOURS_DIR;


$concours_tabs = array('manage', 'add_concours', 'config', 'params', 'help');


// +-----------------------------------------------------------------------+
// |                            Tabsheet
// +-----------------------------------------------------------------------+
if (!isset($_GET['tab']))
    $page['tab'] = $concours_tabs[0];
else
    $page['tab'] = $_GET['tab'];

$tabsheet = new tabsheet();
$tabsheet->add('manage',
               l10n('concours_management'),
               $my_base_url.'-manage');

$tabsheet->add('add_concours',
               l10n('concours_add'),
               $my_base_url.'-add_concours&amp;action=new');

$tabsheet->add('config',
               l10n('concours_config'),
               $my_base_url.'-config');

$tabsheet->add('params',
               l10n('concours_params'),
               $my_base_url.'-params');


$tabsheet->add('help',
               l10n('concours_help'),
               $my_base_url.'-help');
			   
$tabsheet->select($page['tab']);
$tabsheet->assign();

if (isset($_GET['concours']))
{
    // Get informations from base for concours_id
    $concours = new Concours($_GET['concours']);
}


// Add informations from previous pages if present
if (isset($_GET['infos']) && isset($concours))
{
  $infos = $_GET['infos'];
  switch($infos)
  {
    case "0" :
//    array_push($page['infos'],  sprintf( l10n('concours_saved'), $concours->concours_id, $concours->concours_infos['name']));
    array_push($page['infos'],  l10n('concours_saved', $concours->concours_id, $concours->concours_infos['name']));
    break;

    }
}
            
$template->assign( 'CONCOURS_VERSION', l10n('concoursphoto')." (<i>Version ".CONCOURS_VERSION.'</i>)');


// Include file
include_once(CONCOURS_PATH.'admin/'.$page['tab'].'.php');

?>