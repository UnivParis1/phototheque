<?php

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class addmeta_maintain extends PluginMaintain {

//    private $default_conf = array(
//        'casu_port' => 443,
//        'casu_context' => '/cas',
//        'casu_ssl' => true
//    );

    function __construct($plugin_id) {
        parent::__construct($plugin_id);
    }

    function install($plugin_version, &$errors = array()) {

        $result = pwg_query('SHOW COLUMNS FROM `' . IMAGES_TABLE . '` LIKE "label";');
        if (!pwg_db_num_rows($result)) {
            pwg_query('ALTER TABLE `' . IMAGES_TABLE . '` ADD `label` VARCHAR(255) DEFAULT NULL;');
        }
    }

    function update($old_version, $new_version, &$errors = array()) {
        $this->install($new_version, $errors);
    }

    function uninstall() {
//        conf_delete_param('casu');
        pwg_query('ALTER TABLE `' . IMAGES_TABLE . '` DROP `label`;');
    }

}

?>