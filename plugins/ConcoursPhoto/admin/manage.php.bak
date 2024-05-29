<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template, $page;


if (isset($_POST['add_concours_submit']))
    redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-'.CONCOURS_DIR.'-add_concours&action=new');



if (isset($_GET['action']))
{
	$action = $_GET['action'];
	if ($action == 'podium')
	{
		$mode = $_GET['mode'];
		$concours_id = $_GET['concours'];
		$query = "UPDATE " . CONCOURS_TABLE . "
					SET Podium_onCat = ". $mode 
				." WHERE id = ".$concours_id ."
					;";
		pwg_query($query);
	}
	redirect( PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR. '-manage' );
	
}


// Show default criterias (concours id=0)
$defaultconcours = new Concours(0);

$status = (isset($_GET['concours_status']) ? $_GET['concours_status'] : '');
$sortby = (isset($_GET['concours_sort_by']) ? $_GET['concours_sort_by'] : 'id');
$sortorder = (isset($_GET['concours_sort_order']) ? $_GET['concours_sort_order'] : 'desc');
$start = (isset($_GET['start']) ? $_GET['start'] : 0);
$no_concours = l10n('active_concours_1') ;
$query = 'SELECT DISTINCT(id), name, descr, create_date, begin_date, end_date, method, category, Podium_onCat FROM '.CONCOURS_TABLE;

if (isset($_POST['concours_form_filter_submit'])) {
	$start = 0;
	switch ($_POST['concours_status']) {
		case 'prepared':
			$query .= ' WHERE time_to_sec(TIMEDIFF(begin_date, now())) > 0 AND id!=0';
			$status = 'prepared';
			$no_concours = l10n('prepared_concours_1') ;
			break;
		case 'active':
			$query .= ' WHERE time_to_sec(TIMEDIFF(begin_date, now())) < 0 AND id!=0
			AND time_to_sec(TIMEDIFF(now(), end_date)) < 0';
			$status = 'active';
			$no_concours = l10n('active_concours_1') ;
			break;
		case 'closed':
			$query .= ' WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 AND id!=0';
			$status = 'closed';
			$no_concours = l10n('closed_concours_1') ;
			break;
		case'closed-noresult':
			$query .= ' WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 AND id!=0';
			$query .= ' AND id NOT IN (SELECT id_concours FROM ' .CONCOURS_RESULT_TABLE.') ';
			$status = 'closed-noresult';
			$no_concours = l10n('closed_noresult_concours_1');
			break;
		default:
			$query .= ' WHERE id!=0';
			$status = null;
			$no_concours = '';
			break;
	}
	
	switch ($_POST['concours_sort_by']) {
		case 'id':
			$query .= ' ORDER BY id';
			break;
		case 'name':
			$query .= ' ORDER BY name';
			break;
		case 'create_date':
			$query .= ' ORDER BY create_date';
			break;
		case 'begin_date':
			$query .= ' ORDER BY begin_date';
			break;
		case 'end_date':
			$query .= ' ORDER BY end_date';
			break;
		default:
			$query .= ' ORDER BY create_date';
			break;
	}
	
	switch ($_POST['concours_sort_order']) {
		case 'asc':
			$query .= ' ASC';
			break;
		case 'desc':
			$query .= ' DESC';
			break;
		default:
			$query .= ' DESC';
			break;
	}
	$sortby = $_POST['concours_sort_by'];
	$sortorder = $_POST['concours_sort_order'];	
	$template->assign('concours_filter', array(
											'status' => $_POST['concours_status'],
											'sort_by' => $_POST['concours_sort_by'],
											'sort_order' => $_POST['concours_sort_order'],
										)
	);
	
	if (intval($_POST['concours_nb_concours_page']) == 0)
		$defaultconcours->my_config['nb_concours_page'] = 1;
	else
		$defaultconcours->my_config['nb_concours_page'] = intval($_POST['concours_nb_concours_page']);
	$defaultconcours->set_config();


}
else
{
	switch ($status) {
		case 'prepared':
			$query .= ' WHERE time_to_sec(TIMEDIFF(begin_date, now())) > 0 AND id!=0';
			$status = 'prepared';
			$no_concours = l10n('prepared_concours_1') ;
			break;
		case 'active':
			$query .= ' WHERE time_to_sec(TIMEDIFF(begin_date, now())) < 0 AND id!=0
			AND time_to_sec(TIMEDIFF(now(), end_date)) < 0';
			$status = 'active';
			$no_concours = l10n('active_concours_1') ;
			break;
		case 'closed':
			$query .= ' WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 AND id!=0';
			$status = 'closed';
			$no_concours = l10n('closed_concours_1') ;
			break;
		case 'closed-noresult':
			$query .= ' WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 AND id!=0';
			$query .= ' AND id NOT IN (SELECT id_concours FROM ' .CONCOURS_RESULT_TABLE.') ';
			$status = 'closed-noresult';
			$no_concours = l10n('closed_noresult_concours_1');
			break;
		default:
			$query .= ' WHERE id!=0';
			$status = null;
			$no_concours = '';
			break;
	}
	
	switch ($sortby) {
		case 'id':
			$query .= ' ORDER BY id';
			break;
		case 'name':
			$query .= ' ORDER BY name';
			break;
		case 'create_date':
			$query .= ' ORDER BY create_date';
			break;
		case 'begin_date':
			$query .= ' ORDER BY begin_date';
			break;
		case 'end_date':
			$query .= ' ORDER BY end_date';
			break;
		default:
			$query .= ' ORDER BY create_date';
			break;
	}
	
	switch ($sortorder) {
		case 'asc':
			$query .= ' ASC';
			break;
		case 'desc':
			$query .= ' DESC';
			break;
		default:
			$query .= ' DESC';
			break;
	}
	
	$template->assign('concours_filter', array(
											'status' => $status,
											'sort_by' => $sortby,
											'sort_order' => $sortorder,
										)
	);
	
}





if (isset($_POST['delete_selected_submit'])) {
	if (isset($_POST['concours_to_delete_sure']) && $_POST['concours_to_delete_sure'] == '1') {
		if (isset($_POST['concours_to_delete'])) {
			foreach ($_POST['concours_to_delete'] as $concours_id) {
				$defaultconcours->delete_concours($concours_id);
			}
			array_push($page['infos'], l10n('concours_deleted'));
		}
		if (isset($_POST['concours_delete_closed']) && $_POST['concours_delete_closed'] == '1') {
			$defaultconcours->delete_allclosed_concours();
			array_push($page['infos'], l10n('concours_invalid_deleted'));
		}
	} else {
		array_push($page['errors'], l10n('You need to confirm deletion'));
	}
}

//////////
$end = get_nb_concours($status);
$start =  (isset($_GET['start']) ? intval($_GET['start']) : 0);
if ($start > $end)
	$start = 0;
if ($start != 0 AND $end <= $defaultconcours->my_config['nb_concours_page'])
	$start = 0;

$management_url_std = get_root_url().'admin.php?page=plugin-'.CONCOURS_DIR.'-manage'.'&concours_status='.$status.'&concours_sort_order='.$sortorder.'&concours_sort_by='.$sortby;
//Create the navigation bar (for more than 1 page)
$management_url = get_root_url().'admin.php?page=plugin-'.CONCOURS_DIR.'-manage'.'&concours_status='.$status.'&concours_sort_order='.$sortorder.'&concours_sort_by='.$sortby;
$concours_navbar = array();
$concours_navbar = create_navigation_bar($management_url, $end, $start, $defaultconcours->my_config['nb_concours_page']);

//DB Query

if (strpos($query, 'WHERE') === FALSE) {
	$query .= ' WHERE time_to_sec(TIMEDIFF(begin_date, now())) < 0 AND id!=0
	AND time_to_sec(TIMEDIFF(now(), end_date)) < 0';
}

if (strpos($query, 'ORDER BY') === FALSE) {
	$query .= ' ORDER BY create_date';
}


$query .= ' LIMIT '.$start.','.$defaultconcours->my_config['nb_concours_page'].';';
$result = pwg_query($query);
while($concours = pwg_db_fetch_assoc($result)) {

	if ($concours['id']!=0)
	{
		
		
		$concours_status = 0;
		// 0 Prepared / 1 Active / 2 Closed
		$concours_status = (strtotime($concours['begin_date'])-time() > 0 ? 0 : (strtotime($concours['end_date']) - time() > 0 ? 1 : 2  ));
		$filename = has_file($concours['id']);

		if ( ($status == 'closed-noresult' AND !has_result($concours['id']))	// option "closed without result' => display only closed without result
			 OR ($status != 'closed-noresult' )								// OR option "closed" OR  "active" OR "prepared"
			)
		{
			$template->append('concours_list', array(
											'ID' => $concours['id'],
											'STATUS1' => $concours_status,
											'STATUS' => ($concours_status == 0 ? 'prepared' : ($concours_status == 1 ? 'actived' : 'closed')) ,
											'CREATE_DATE'	=> $concours['create_date'],
											'NAME' => $concours['name'],
											'DESC' => $concours['descr'],
											'BEGIN_DATE'	=> $concours['begin_date'],
											'END_DATE'	=> $concours['end_date'],

											'U_EDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;concours=' . $concours['id'].'&amp;action='.($concours_status != 2 ? 'modify' : 'edit'),
											'U_AUDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-audit&amp;concours=' . $concours['id'],
											'U_DELETE' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;concours=' . $concours['id'].'&amp;action=del' ,
											'U_RESULT' => !has_result($concours['id'])? PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;concours=' . $concours['id'].'&amp;action=result' : '',
											'U_FILE' => $filename ? CONCOURS_ADMIN_PATH . 'file.php?file=' . $filename : (has_result($concours['id']) ? PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;concours=' . $concours['id'].'&amp;action=file' : ''),
											'NB_VOTE' => count($defaultconcours->get_user_list($concours['id']))+count($defaultconcours->get_guest_list($concours['id'])),
											'NBIMG'   => $defaultconcours->nb_img_by_concours($concours['id']),
                							'SHOWPODIUM' => ($concours['Podium_onCat'] ? '1' : '0'),				
											'U_PODIUM' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-manage&amp;concours=' . $concours['id'].'&amp;action=podium&amp;mode='.($concours['Podium_onCat'] ? '0' : '1') ,
											
	

			));
		}
	}
}

$template->assign('IMG_URL', CONCOURS_IMG_PATH);
$template->assign('MANAGE_URL', $management_url_std); 
$template->assign('PODIUM_URL', get_root_url().'admin.php?page=plugin-'.CONCOURS_DIR.'-podium');
$template->assign('no_concours', sprintf(l10n('concours_no_concours'), $no_concours));

$nb_concours_valid_total = sprintf(l10n('concours_nb_concours_total'), get_nb_concours(), get_nb_prepared_concours(), get_nb_active_concours(), get_nb_closed_concours());


$template->assign('nb_concours_total', $nb_concours_valid_total);
$template->assign('concours_nb_concours_page', $defaultconcours->my_config['nb_concours_page']);
$template->assign('navbar', $concours_navbar);

$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/manage.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');






?>