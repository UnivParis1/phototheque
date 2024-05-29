<?php

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class casusers_maintain extends PluginMaintain {

    private $default_conf = array(
        'casu_port' => 443,
        'casu_context' => '/cas',
        'casu_ssl' => true,
        'casu_login' => "login",
        'casu_groups' => array(
            'memberOf' => '/cn=\\\(.*\\\),/\\\1/',
            ),
    );

    function __construct($plugin_id) {
        parent::__construct($plugin_id);
    }

    function install($plugin_version, &$errors = array()) {
        $casu_conf = conf_get_param('casu', array());
        if (empty($casu_conf)) {
            conf_update_param('casu', $this->default_conf, true);
        }

        $result = pwg_query('SHOW COLUMNS FROM `' . USER_INFOS_TABLE . '` LIKE "casu_id";');
        if (!pwg_db_num_rows($result)) {
            pwg_query('ALTER TABLE `' . USER_INFOS_TABLE . '` ADD `casu_id` VARCHAR(255) DEFAULT NULL;');
        }
    }

    function update($old_version, $new_version, &$errors = array()) {
        $this->install($new_version, $errors);
    }

    function uninstall() {
        conf_delete_param('casu');
        pwg_query('ALTER TABLE `' . USER_INFOS_TABLE . '` DROP `casu_id`;');
    }

}

?>