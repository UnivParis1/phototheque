<?php

defined('CASU_PATH') or die('Hacking attempt!');


/*
 * prepare things to the connexion menu :
 */
function casu_blockmanager($menu_ref_arr)
{
    global $template;
    $menu = &$menu_ref_arr[0];

    $conf = conf_get_param('casu');
    if ($menu->get_block('mbIdentification') == null or ! isset($conf['casu_host'])) 
    {
        return;
    }

    $template->assign(array(
        'casu_conf' => conf_get_param('casu')
    ));

    $template->set_prefilter('menubar', 'casu_add_menubar_buttons_prefilter');
}
/*
 * we want to replace completely the form part in identification_menubar.tpl as CAS becomme the only authentification available
 */
function casu_add_menubar_buttons_prefilter($content, $smarty)
{
    $search = '#(<form[^>]*action="{\$U_LOGIN}".*/form>)#is';
    $replace = file_get_contents(CASU_PATH . 'template/identification_menubar.tpl');
    return preg_replace($search, $replace, $content);
}
