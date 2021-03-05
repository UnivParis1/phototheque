<?php

/*
  Plugin Name: addmeta
  Version: 0.1
  Description: Extend data model for images.
  Plugin URI: auto
  Author: Pascal
  Author URI: http://www.pantheonsorbonne.fr
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');
if (basename(dirname(__FILE__)) != 'addmeta') {
    add_event_handler('init', 'addmeta_error');

    function addmeta_error() {
        global $page;
        $page['errors'][] = 'AMEta folder name is incorrect, uninstall the plugin and rename it to "addmeta"';
    }

    return;
}

define('ADDM_ADMIN', get_root_url() . 'admin.php?page=plugin-addmeta');

//add_event_handler('init', 'casu_init');
//
//function casu_init() {
//}

?>