<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $user, $conf;

include_once CONCOURS_INC_PATH.'Concours.class.php';
include_once CONCOURS_PATH.'/stuffs_module/functions.inc.php';
include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');

if ($datas['contest_id'] != 0)
{
// Get informations from base for concours_id
$concours = new Concours($datas['contest_id']);
	

		
$block['contests'][$concours->concours_infos['id']] = array(
				'ID'	=> $concours->concours_infos['id'],
				'NAME'	=> $concours->concours_infos['name'],
				'DESCR'	=> $concours->concours_infos['descr'],
				'BEGIN_DATE'	=> format_date($concours->concours_infos['begin_date']),
				'END_DATE'	=> format_date($concours->concours_infos['end_date']),
				'METHOD'	=> l10n("concours_method".$concours->concours_infos['method']),
				'METHODNB'	=> $concours->concours_infos['method'],
				'URL'		=> './index.php?/concours/'.$concours->concours_infos['id'],
				'DAYS'		=> NbJours($concours->concours_infos['begin_date'], $concours->concours_infos['end_date']),
				'VISIBLE'	=> true,
				'NB_VOTANT' => count($concours->get_user_list($concours->concours_infos['id']))+count($concours->get_guest_list($concours->concours_infos['id'])),
				'NBIMG'		=> $concours->nb_img_by_concours($concours->concours_infos['id'])
				);




$podium = array();

		
// get podium image informations		
	$query = 'SELECT ' 
	.' RESULT.id_concours, CONC.name, CONC.descr, CONC.begin_date, CONC.end_date, CONC.method, 
		RESULT.img_id as id, IMG.name, IMG.author, IMG.file, IMG.path, IMG.added_by, 	
		ic.category_id, cat.name AS catname,
		RESULT.date, RESULT.note, RESULT.moyenne, RESULT.moderation1, RESULT.moderation2, RESULT.nbvotant, RESULT.datas'
	.' FROM ' .CONCOURS_RESULT_TABLE.' AS RESULT'
	.' INNER JOIN ' . CONCOURS_TABLE.' AS CONC on CONC.id = RESULT.id_concours'
	.' INNER JOIN ' . IMAGES_TABLE.' AS IMG on IMG.id = RESULT.img_id'
	.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON IMG.id = ic.image_id'
	.' INNER JOIN '.CATEGORIES_TABLE.' AS cat ON ic.category_id = cat.id'
	.' WHERE RESULT.id_concours = '.$concours->concours_id
	.' ORDER BY '
	.($concours->concours_infos['method'] == 1 ? 'note': ($concours->concours_infos['method'] == 2 ? 'moyenne' : ($concours->concours_infos['method'] == 3 ? 'moderation1' : 'moderation2')))
	.' DESC'
	.' LIMIT 3 OFFSET 0;';


$rank = 1;
$NB_RESULTS = 0;
$results = pwg_query($query);

while ($result = pwg_db_fetch_array($results)) 
{

	$NB_RESULTS ++;
	// link on picture.php page
	set_make_full_url();
	if ( isset($result['category_id']) & isset($result['catname']) ) 
	{
		$url = duplicate_picture_url(
		array(
		'image_id' => $result['id'],
		'image_file' => $result['file'],
		'category' => array(
						'id' => $result['category_id'],
						'name' => $result['catname'],
						'permalink' => ''
					  )
		),
		array('start')
		);
	}
	else
	{
		$url = duplicate_picture_url(
		  array(
			'image_id' => $result['id'],
			'image_file' => $result['file']
		  ),
		  array('start')
		);
	}	
	unset_make_full_url();



	$method = ($result['method'] == 1 ? 'note': ($result['method'] == 2 ? 'moyenne' : ($result['method'] == 3 ? 'moderation1' : 'moderation2')));

	$block['contests'][$result['id_concours']]['RESULTS'][$rank] = array(
	'RANK' => $rank,
	'AUTHOR' => (strlen($result['author']) === 0 ? get_username($result['added_by']): $result['author']),
	'TN_SRC' => DerivativeImage::thumb_url($result),
	'XSMALL_SRC' => DerivativeImage::url(IMG_XSMALL, $result),	
	'XXSMALL_SRC' => DerivativeImage::url(IMG_XXSMALL, $result),	
	'URL'	=> $url

);
$rank++;
}


$block['CR_CSS_PATH'] = PHPWG_PLUGINS_PATH . dirname(__FILE__)."/template/style.css";
$block['TEMPLATE'] = dirname(__FILE__).'/concours_stuffs.tpl';
$block['contests'][$concours->concours_infos['id']]['nb_results'] = $NB_RESULTS;

$block['IMG_URL'] = CONCOURS_IMG_PATH;


switch ($datas['nb_per_line']) {
	case '1' :
		$block['SIZE_CLASS'] = 'one_comment';
		break;
	case '2' :
		$block['SIZE_CLASS'] = 'two_comment';
		break;
	case '3' :
		$block['SIZE_CLASS'] = 'three_comment';
		break;
}

}

?>