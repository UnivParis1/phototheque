<?php

defined('CASU_PATH') or die('Hacking attempt!');


global $template, $page;

if (isset($_POST['save_config'])) {
    // plugin config
    if (isset($_POST['casu_groups'])) {
        
        $casu_group_up = array();
        foreach ($_POST['casu_groups'] as $group) {
            if ($group['name']!="") {
                $casu_group_up[$group['name']] = $group['regexp'];
            }
        }
//    var_dump($_POST['casu_groups']);
//        var_dump($casu_group_up);
//        die();
    }
    $confcasuup = array(
        'casu_host' => (isset($_POST['casu_host']) ? pwg_db_real_escape_string($_POST['casu_host']) : ''),
        'casu_port' => (isset($_POST['casu_port']) ? pwg_db_real_escape_string($_POST['casu_port']) : ''),
        'casu_context' => (isset($_POST['casu_context']) ? pwg_db_real_escape_string($_POST['casu_context']) : ''),
        'casu_logo' => (isset($_POST['casu_logo']) ? pwg_db_real_escape_string($_POST['casu_logo']) : ''),
        'casu_logo_alt' => (isset($_POST['casu_logo_alt']) ? pwg_db_real_escape_string($_POST['casu_logo_alt']) : ''),
        'casu_ssl' => isset($_POST['casu_ssl']),
        'casu_ca' => (isset($_POST['casu_ca']) ? pwg_db_real_escape_string($_POST['casu_ca']) : ''),
        'casu_altaccess' => isset($_POST['casu_altaccess']),
        'casu_altaccess_text' => (isset($_POST['casu_altaccess_text']) ? pwg_db_real_escape_string($_POST['casu_altaccess_text']) : '' ),
        'casu_login' => (isset($_POST['casu_login']) ? pwg_db_real_escape_string($_POST['casu_login']) : ''),
        //'casu_groups' => (isset($casu_group_up) ? serialize($casu_group_up) : ''),
        'casu_groups' => (isset($casu_group_up) ? $casu_group_up : ''),
    );


    conf_update_param('casu', $confcasuup, true);
    $conf['casu']['casu_groups'] = array_map("stripslashes", $conf['casu']['casu_groups']) ;

    //$conf['casu']['casu_groups'] = unserialize($conf['casu']['casu_groups']);
    $page['infos'][] = l10n('Information data registered in database');
}

$confcasu = conf_get_param('casu', array());

$template->assign($confcasu);

$template->set_filenames(
        array(
            'plugin_admin_content' => dirname(__FILE__) . '/admin/admin.tpl'
        )
);

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>