<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template;

// Load language
load_language('help\plugin.lang', CONCOURS_PATH);

$template->assign(array('SCRIPT' =>
			'<script type="text/javascript" src="'.CONCOURS_ADMIN_PATH.'template/Scripts.js"></script>
  			<link rel="stylesheet" type="text/css" href="'.CONCOURS_ADMIN_PATH.'template/concours.css")'
			
			));


$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/help.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>