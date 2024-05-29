<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template;

// Show default criterias (concours id=0)
// Available actions : 
// add (action=add)
// modify(action=modify)
// delete(action=delete)

$defaultconcours = new Concours(0);


if (isset($_POST['add']))	// Add new criteria
{
	redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;action=add&amp;concours_id=' . $id_concours);
}

if (isset($_GET['action']))
{
	if (isset($_GET['id']))
		$criteria_id = $_GET['id'];
	switch($_GET['action'])
	{
		case "delete" :
			if (isset($criteria_id))
				$defaultconcours->delete_criteria($criteria_id);
			else
				die ("Wrong parameters...");
			break;
		case "modify" : 
			break;
	}
}


$firstcriterias = $defaultconcours->get_firstlevel_criterias();
foreach ($firstcriterias as $criteria)
{
if ($defaultconcours->debug)					echo "criteriaID=".$criteria['criteria_id']."\n";
	// First without sub criterias
	if (!$defaultconcours->is_criterias_contains_sub($criteria['criteria_id'] ))
	{
		$template->append( 'concours_criteria', array(
				'nosub'	=> true,
				'level'	=> 1,
				'id' 	=> $criteria['criteria_id'],				// id du critere
				'name' 	=> $criteria['name'],				// id du critere
				'lib'	=> $criteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
				'min' 	=> $criteria['min_value'],				// min
				'max' 	=> $criteria['max_value'],				// max
				'pond' 	=> $criteria['ponderation'],			// ponderation
				'U_EDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=modify&amp;id='.$criteria['id'],
				'U_DELETE' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=delete&amp;id='.$criteria['id'] ,
				'U_ADD' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=add&amp;upcriteria='.$criteria['criteria_id'],
			));
	}
	else
	{
		$template->append( 'concours_criteria', array(
				'nosub'	=> false,
				'level'	=> 1,
				'id' 	=> $criteria['criteria_id'],				// id du critere
				'name' 	=> $criteria['name'],				// id du critere
				'lib'	=> $criteria['descr'],
				'U_ADD' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=add&amp;upcriteria='.$criteria['criteria_id'],
			));
		$secondcriterias = $defaultconcours->get_subcriterias($criteria['criteria_id'] );
		foreach ($secondcriterias as $subcriteria)
		{
if ($defaultconcours->debug)							echo "subcriteriaID=".$criteria['criteria_id']."\n";
			$template->append( 'concours_criteria', array(
					'nosub'	=> true,
					'level'	=> 2,
					'id' 	=> $subcriteria['criteria_id'],				// id du critere
					'name' 	=> $subcriteria['name'],				// id du critere
					'lib'	=> $subcriteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
					'min' 	=> $subcriteria['min_value'],				// min
					'max' 	=> $subcriteria['max_value'],				// max
					'pond' 	=> $subcriteria['ponderation'],			// ponderation
					'U_EDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=modify&amp;id='.$subcriteria['id'],
					'U_DELETE' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;concours_id=' . $defaultconcours->concours_id.'&amp;action=delete&amp;id='.$subcriteria['id'] ,
				));
			
		}
	}

}

$template->assign('IMG_URL', CONCOURS_IMG_PATH);


$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/config.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

?>