<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
include_once(CONCOURS_PATH . 'admin/functions.inc.php');

global $template;

// General parameters for the concours
$concours1 = new Concours();

if (isset($_POST['submit'])) { 
  $concours1->my_config['active_menubar'] = isset($_POST['active_menubar']);
  $concours1->my_config['nbconcours_menubar'] = $_POST['nbconcours_menubar'];

  $concours1->my_config['mask_author'] = isset($_POST['mask_author']);
  $concours1->my_config['mask_meta'] = isset($_POST['mask_meta']);
  $concours1->my_config['thumb_note'] = isset($_POST['thumb_note']);

  $concours1->my_config['check_exaequo'] = isset($_POST['check_exaequo']);

  $concours1->my_config['author_vote_available'] = $_POST['AUTHOR_MODE'];

  $concours1->my_config['concours_change_score'] = isset($_POST['concours_change_score']);
  $concours1->my_config['concours_deadline'] = $_POST['concours_deadline'];
  $concours1->my_config['mask_thumbnail'] = isset($_POST['mask_thumbnail']);
  $concours1->my_config['active_global_score_page'] = isset($_POST['active_global_score_page']);
  $concours1->my_config['score_mode'] = $_POST['score_mode'];
  $concours1->my_config['text_overlay'] = $_POST['text_overlay'];
  
  $concours1->save_config();

  array_push($page['infos'], l10n('concours_saveOK'));
}

for($jj=0; $jj < 4; $jj++)
{
	$template->append('AUTHOR_MODE',array('ID' => $jj,'NAME' => l10n('concours_author_vote'.$jj),'SELECTED' => ($concours1->my_config['author_vote_available'] == $jj ? 'selected' : '')));
}



for($jj=0; $jj < 10; $jj++)
{
	$template->append('NBCONCOURS',array('ID' => $jj,'NAME' => $jj,'SELECTED' => ($concours1->my_config['nbconcours_menubar'] == $jj ? 'selected' : '')));
}

for($jj=0; $jj < 3; $jj++)
{
	$template->append('DEADLINE',array('ID' => $jj,'NAME' => l10n('concours_deadline_param'.$jj),'SELECTED' => ($concours1->my_config['concours_deadline'] == $jj ? 'selected' : '')));
}
for($jj=0; $jj < 2; $jj++)
{
	$template->append('SCORE_MODE',array('ID' => $jj,'NAME' => l10n('concours_score_mode'.$jj),'SELECTED' => ($concours1->my_config['score_mode'] == $jj ? 'selected' : '')));
}


$template->assign(array(
	'SHOW_MENUBAR' 			=> ($concours1->my_config['active_menubar'] ? 'checked="checked"' : ''),
    'MASK_AUTHOR' 			=> ($concours1->my_config['mask_author'] ? 'checked="checked"' : ''),
    'THUMB_NOTE' 			=> ($concours1->my_config['thumb_note'] ? 'checked="checked"' : ''),
    'CHECK_EXAEQUO'         => ($concours1->my_config['check_exaequo'] ? 'checked="checked"' : ''),
    'CHANGE_SCORE'          => ($concours1->my_config['concours_change_score'] ? 'checked="checked"' : ''),
    'MASK_THUMB'            => ($concours1->my_config['mask_thumbnail'] ? 'checked="checked"' : ''),
    'GLOBAL_SCORE'          => ($concours1->my_config['active_global_score_page'] ? 'checked="checked"' : ''),
	'TEXT_OVERLAY'			=> $concours1->my_config['text_overlay'],
    'MASK_META' 			=> ($concours1->my_config['mask_meta'] ? 'checked="checked"' : ''),

        ));

$result = array();
$result = get_csvfile_result();		
$o=0;
foreach($result as $file)
{
	$template->append('FILE',array('NAME' => $file['name'],
								   'LINK' => $file['link'],
								   'CONC_ID' => $file['conc_id'],
								   'CONC_NAME' => $file['conc_name'],
								   'CONC_DESCR' => $file['conc_descr']
					));
}

$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/params.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>