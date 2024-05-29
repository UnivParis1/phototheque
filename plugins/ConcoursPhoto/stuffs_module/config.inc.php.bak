<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// display only on home
$display_options = & $template->get_template_vars('display_options');
$display_options['on_root'] = false;
$display_options['on_cats'] = false;
$display_options['on_picture'] = false;


// Configuration par défaut
if (!isset($datas)) {
	$datas = array(
		'contest_id' => array(0),
		'nb_per_line' => 1,
	);
}

// Enregistrement de la configuration
if (isset($_POST['submit']) ) {

	$datas = array(
//		'contest_id' => implode(',', $_POST['contest_id']),
		'contest_id' => intval($_POST['contest_id']),
		'nb_per_line' => $_POST['nb_per_line'],
	);
}

// list of closed contests
$query = 'SELECT DISTINCT(id_concours),CONC.name'
.' FROM ' .CONCOURS_RESULT_TABLE
.' INNER JOIN ' . CONCOURS_TABLE.' AS CONC on CONC.id = id_concours'
.' AND time_to_sec(TIMEDIFF(now(), end_date)) > 0'
.' ORDER BY id_concours;'; 
 
// selected contests
$selected_ids = explode(',', $datas['contest_id']);
	
$result = pwg_query($query);

$visible = false;
// Contest list
while ($contest = pwg_db_fetch_assoc($result)) 
{
	$visible = true;

	$template->append('contests', array(
		'ID' => $contest['id_concours'],
		'NAME' =>  $contest['name'],
		'SELECTED' => in_array($contest['id_concours'], $selected_ids) ? true : false,
	));
} 
if (!$visible)
{
	$template->append('contests', array(
		'ID' => 0,
		'NAME' =>  l10n('NO_concours'),
		'SELECTED' => true ,
	));
	$template->assign('VISILBLE',false);
}

// Nombre de cadres
$template->assign('NB_PER_LINE', array(
	'OPTIONS' => array(1 => 1, 2 => 2, 3 => 3),
	'SELECTED' => $datas['nb_per_line'],
));



// +-----------------------------------------------------------------------+
//				Template
// +-----------------------------------------------------------------------+
$template->set_filenames(array('module_options' => dirname(__FILE__) . '/config.tpl'));
$template->assign_var_from_handle('MODULE_OPTIONS', 'module_options');



?>