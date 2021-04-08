<?php

/*
  Plugin Name: xmpreader
  Version: auto
  Description: try to read some xmp metadata from our picture.
  Plugin URI: auto
  Author: Pascal
  Author URI: http://www.pantheonsorbonne.fr
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

// Fetch the template.
global $template;

// Add our template to the global template
$template->set_filenames(
        array(
            'plugin_admin_content' => dirname(__FILE__) . '/admin.tpl'
        )
);

// Assign the template contents to ADMIN_CONTENT
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>