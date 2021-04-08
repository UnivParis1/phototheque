<?php

/*
  Plugin Name: casusers
  Version: 0.6
  Description: Authenticate again a CAS SSO server and fetch some useful attributes.
  Plugin URI: auto
  Author: Pascal
  Author URI: http://www.pantheonsorbonne.fr
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');
if (basename(dirname(__FILE__)) != 'casusers') {
    add_event_handler('init', 'casusers_error');

    function casusers_error() {
        global $page;
        $page['errors'][] = 'CAS Users folder name is incorrect, uninstall the plugin and rename it to "casusers"';
    }

    return;
}

define('CASU_PATH', PHPWG_PLUGINS_PATH . 'casusers/');
define('CASU_CAS', CASU_PATH . 'include/phpCAS/CAS.php');
define('CASU_ADMIN', get_root_url() . 'admin.php?page=plugin-casusers');

add_event_handler('init', 'casu_init');
add_event_handler('get_admin_plugin_menu_links', 'casu_admin_plugin_menu_links', 50, CASU_PATH . 'include/admin_events.inc.php');
add_event_handler('blockmanager_apply', 'casu_blockmanager', 55, CASU_PATH . 'include/public_events.inc.php');

function casu_init() {
    global $conf;
    $conf['casu'] = safe_unserialize($conf['casu']);
    if (isset($conf['casu']['casu_groups']) && is_array($conf['casu']['casu_groups'])) {
        $conf['casu']['casu_groups'] = array_map("stripslashes", $conf['casu']['casu_groups']);
    } else {
        $conf['casu']['casu_groups'] = array();
    }
    load_language('plugin.lang', CASU_PATH);

    //we keep a safe noCAS access to the identification page for administration purpose.
    if (isset($_GET['noCAS'])) {
        pwg_set_session_var('noCASU', 'noCAS');
    }

    //all the phpCAS stuff here :
    if (script_basename() == 'identification' && !pwg_get_session_var('noCASU') == 'noCAS' && isset($conf['casu']['casu_host'])) {
        require_once CASU_CAS;
        $ccas = conf_get_param('casu');

//        phpCAS::setDebug();
//        phpCAS::setVerbose(true);
        phpCAS::client(SAML_VERSION_1_1, $ccas['casu_host'], (int) $ccas['casu_port'], $ccas['casu_context']);
        if (!$ccas['casu_ssl']) {
            phpCAS::setCasServerCACert($ccas['casu_ca']);
        } else {
            phpCAS::setNoCasServerValidation();
        }

        phpCAS::forceAuthentication();
        $cas_user = array(
            'id' => phpCAS::getUser(),
        );
        if (phpCAS::hasAttributes()) {
            $cas_user['attributes'] = phpCAS::getAttributes();
            $cas_user['user'] = $cas_user['attributes'][$ccas['casu_login']];
        }

//all the actual stuff is comming trough get but identification.php need to think it's post
        $_POST['login'] = true;
        if (isset($_GET['redirect'])) {
            $_POST['redirect'] = $_GET['redirect'];
        }
        $_POST['username'] = $cas_user;
        $_POST['password'] = 'fake';

//if we are here we should have a valid CAS user, we want to log in with :
        add_event_handler('try_log_user', 'casu_try_log_user', 49, CASU_PATH . 'include/auth.inc.php');
    }
}

?>