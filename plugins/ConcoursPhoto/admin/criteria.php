<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template;

// Add or modify new criteria
// if previous page is "config" ==> id_concours=0. After submit, redirect to config page
// if previous page is add_concours with action modify_crit and id_concours !=0, redirect to add_concours page with correct params.

// action = modify/add/edit

$id_concours = (isset($_GET['id_concours']) ? $_GET['id_concours'] : 0);
	
$concours = new Concours($id_concours);

if (!isset($_GET['action']))
	$_GET['action'] = "edit";


if (isset($_POST['submit'])) // validation
{
	$datas = array();

	$datas['id'] = isset($_GET['id']) ? $_GET['id'] : null;
	$datas['name'] = $_POST['criteria_name'];
	$datas['descr'] = $_POST['criteria_lib'];
	$datas['min_value'] = $_POST['criteria_min'];
	$datas['max_value'] = $_POST['criteria_max'];
	$datas['ponderation'] = $_POST['criteria_pond'];
	$datas['uppercriteria'] = isset($_GET['upcriteria']) ? $_GET['upcriteria'] : false;
	// if action = add
	if ($_GET['action'] == "add")
	{
		$concours->add_criteria($datas);
	}
	// if action = modify
	elseif ($_GET['action'] == "modify" )
	{
		$concours->update_criteria($datas);
	}

	if ($id_concours == 0)
		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-' . CONCOURS_DIR . '-config');
	else
		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;action=modify_crit&amp;concours=' . $id_concours);
} 


switch ($_GET['action'])
{

	case "delete" :
		if (!isset($_GET['id']))
			die ("Wrong parameters...");
		else
		{	
if ($concours->debug)		echo "ID=".$_GET['id'];
			$concours->delete_criteria_by_id($_GET['id']);

			if ($id_concours == 0)
				redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-' . CONCOURS_DIR . '-config');
			else
				redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;action=modify_crit&amp;concours=' . $id_concours);
			
		}
		break;
		
	case "modify" :
		if (!isset($_GET['id']))
			die ("Wrong parameters...");
		else
		{	
			$criteria = $concours->get_criteria_by_id($_GET['id']);
			if (!$criteria == array()) // Not found
			{
				$template->assign( array(
						'criteria_id' 		=> $criteria['criteria_id'],				// id du critere
						'criteria_name' 	=> $criteria['name'],				// id du critere
						'criteria_lib'		=> $criteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
						'criteria_min' 		=> $criteria['min_value'],				// min
						'criteria_max' 		=> $criteria['max_value'],				// max
						'criteria_pond' 	=> $criteria['ponderation'],			// ponderation
						'action'			=> $_GET['action']
					));
			
			}
			
		}
		break;
		
	case "add" :
		$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id
					FROM ' . CONCOURS_DETAIL_TABLE . ' ;';
		list($next_element_id) = pwg_db_fetch_array(pwg_query($query));
		$query = 'SELECT IF(MAX(criteria_id)+1 IS NULL, 1, MAX(criteria_id)+1) AS next_criteria_id
					FROM ' . CONCOURS_DETAIL_TABLE . '
				  WHERE id_concours = '.$concours->concours_id  . ' ;';
		list($next_criteria_id) = pwg_db_fetch_array(pwg_query($query));

		$template->assign( array(
				'criteria_id' 		=> $next_criteria_id,				// id du critere
				'action'			=> $_GET['action']
			));
		break;
	default : 
		break;
}

$template->assign( array('EDIT'=>(isset($_GET['edit']) ? true : false)));



$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/criteria.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>