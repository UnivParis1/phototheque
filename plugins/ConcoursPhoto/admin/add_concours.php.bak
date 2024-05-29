<?php

// To add a concours, 2 steps  are needed:
// Step 1 : action=new
//	initialize a concours and store it to database (with elements on piwigo_concours table)
//	After storage on database, step 2 is called (action=new_crit)
// Step 2 : action=new_crit  &  concours_id=XX

// add_concours with action=view is called only to list informations about a concours id
// add_concours with action=modify is called to modify informations about a concours.  Like creation, 2 steps are needed
//	Step 1 : action=modify &  concours_id=XX
//		List informations about concours id and modify it to store to piwifo_concours table
//		Go to Step 2 (if needed by client choice ==> 2 buttons) with action=modify_crit
//	Step 2 : action=modify_crit &  concours_id=XX
//		List informations about criterias and modify them
//		Warning : different cases are possible : 
//			- delete criteria ou sub criteria
//			- modify criteria ou sub criteria (
//			- add criteria ou sub criteria
//		For all theses actions, the command is sent by _GET method




if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template;

include_once(CONCOURS_PATH . 'admin/functions.inc.php');
load_language('plugin.lang', CONCOURS_PATH);

$method_list = array(l10n('concours_method1'), l10n ('concours_method2'), l10n ('concours_method3'), l10n ('concours_method4') );

	
// test for _GET informations needed
if (!isset($_GET['action']))
  die('Wrong parameters...1');
else
  $action = $_GET['action'];

/*
echo "action : ".$action."\n";
sleep(5);
*/ 
 
// Month initialization for date selection...
$month_list = $lang['month'];
$month_list[0]='------------';
ksort($month_list);


// concours initialize
if ($action != "new")
{
	if (!isset($_GET['concours']))
	  die('Wrong parameters...2');

	$concours_id = $_GET['concours'];
	// Get informations from base for concours_id
	$concours = new Concours($concours_id);
}
else	// creation
{
	$concours = new Concours();
	$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id
				FROM ' . CONCOURS_TABLE . ' ;';
	list($next_element_id) = pwg_db_fetch_array(pwg_query($query));
	$concours_id = $next_element_id;
}


// Add informations from previous pages if present
if (isset($_GET['infos']) && isset($concours))
{
  $infos = $_GET['infos'];
  switch($infos)
  {
    case "1" :
    array_push($page['errors'],   l10n('concours_end_date_change_to' ,$concours->concours_infos['end_date'] ));
    break;
        
  }
            
}

 
// Add criteria
if (isset($_POST['add']))
	redirect( PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours_id.'&amp;action=add');

  
if (isset($_POST['submit']))
{

// Update method if changed
	if (!isset($concours->concours_infos['method']) OR (isset($_POST['concours_method']) AND $concours->concours_infos['method'] != $_POST['concours_method']))
	{
		$concours->concours_infos['method'] = $_POST['concours_method'];
		$concours->update_concoursfield("method", $concours_id);
	}

	if ($action == "modify_crit")
    {
        $concours->infos = 0;
//        redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '-admin.php&amp;concours=' . $concours_id.(isset($concours->infos) ? '&amp;infos=' .$concours->infos: ''));
        redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php&amp;concours=' . $concours_id.(isset($concours->infos) ? '&amp;infos=' .$concours->infos: ''));
    }

	if ($action == "edit")
	{
	
		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php');
	}


// Step 1 : action = modify
// Step 2 : action = modify_crit
	
/*
	// Verify date format.		
	if (!preg_match(
	"/^([2][0]\d{2})\-([0]\d|[1][0-2])\-([0-2]\d|[3][0-1])\s([0-1]\d|[2][0-3])\:[0-5]\d\:[0-5]\d$/"
	, $_POST['concours_begin_date']))
	{
		$_POST['concours_begin_date'] = date("Y-m-d H:m:s");
	}
*/
	
	// Get information from form
	$concours->concours_id = $concours_id;
	$concours->concours_infos['id'] = $concours_id;
	$concours->concours_infos['name'] = $_POST['concours_name'];
	$concours->concours_infos['descr'] = $_POST['concours_descr'];


	$concours->concours_infos['begin_date'] = sprintf("%04d-%02d-%02d %02d:%02d:%02d",$_POST['start_year'], $_POST['start_month'], $_POST['start_day'], $_POST['start_hour'], $_POST['start_min'], 0);
    $concours->concours_infos['end_date'] = sprintf("%04d-%02d-%02d %02d:%02d:%02d",$_POST['end_year'], $_POST['end_month'], $_POST['end_day'], $_POST['end_hour'], $_POST['end_min'], 0);

if ($concours->debug)	
{
    echo "BEGIN=".$concours->concours_infos['begin_date']."\n";
    echo "END=".$concours->concours_infos['end_date']."\n";
    sleep(5);
}
    
    $BeginToEnd = NbJours($concours->concours_infos['begin_date'], $concours->concours_infos['end_date']);
//    echo "NB=".$BeginToEnd;
    // Test if end date is lower than end date
    if ($BeginToEnd == 0)
    {
        $tBeginDate = explodeDateArray($concours->concours_infos['begin_date']);
        $tEndDate = explodeDateArray($concours->concours_infos['end_date']);
        if ( (intval(@$tEndDate[3]) < intval(@$tBeginDate[3]))    // End hour is lower than begin hour 
            OR ( (intval(@$tBeginDate[3]) == intval(@$tEndDate[3]))    // End hour is equal to begin hour 
                 AND (intval(@$tEndDate[4]) < intval(@$tBeginDate[4]))) // End min is lower than begin hour
            )
        {
            $concours->concours_infos['end_date'] = AjoutJours ($concours->concours_infos['begin_date'], 1);
            $concours->infos = 1;  // sprintf( l10n('concours_end_date_change_to') ,$concours->concours_infos['end_date'] ));
        }
    }
    elseif ($BeginToEnd < 0 )
    {
        $concours->concours_infos['end_date'] = AjoutJours ($concours->concours_infos['begin_date'], 1);
        $concours->infos = 1;  // sprintf( l10n('concours_end_date_change_to') ,$concours->concours_infos['end_date'] ));
    }
    // End test date
        
	$concours->concours_infos['groups'] = (!empty($_POST['groups']) ? '"' . implode(',', $_POST['groups']) . '"' : 'NULL');
	$concours->concours_infos['guest'] = isset($_POST['guest']);
	$concours->concours_infos['admin'] = isset($_POST['admin']);
	$concours->concours_infos['Podium_onCat'] = isset($_POST['Podium_onCat']);
	
	$concours->concours_infos['category'] = $_POST['cat_selection'];
	


	switch($action)	
	{
		case "edit" :
			redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php');
			break;
		case "new" :
			
			$concours->save_concours();
			$concours->get_default_criterias();
			// Redirect to admin
			redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php&amp;tab=add_concours&amp;action=modify_crit&amp;concours=' . $concours_id.(isset($concours->infos) ? '&amp;infos=' .$concours->infos: ''));

			break;
		case "modify" :
            $concours->update_concours();
			redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php&amp;tab=add_concours&amp;action=modify_crit&amp;concours=' . $concours_id.(isset($concours->infos) ? '&amp;infos=' .$concours->infos: ''));

			break;
		case "modify_crit" :
            $concours->infos = 0;
			redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php&amp;concours=' . $concours_id.(isset($concours->infos) ? '&amp;infos=' .$concours->infos: ''));
			break;
	}
	  
		
}		
	
	
	
switch($action)	
{
// Download the file
	case "file" :
		//  generate csv file
		$file = $concours->generate_csv();
		// Get the existing filename or the new one if doesnt exist
		$filename = $concours->save_file($file);

		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php');
		break;

// Geneate result
	case "result" :
		// Generate result and save it to DB
		$concours->create_result();
		// Generate csv file
		// 1. Simple  csv file
//		$file = $concours->generate_csv();
		// 2.  Complete csv file.
		$file = $concours->generate_detail_csv();
		// Save file to directory
		$filename = $concours->save_file($file);
		
		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php');
		break;

	case "del" : 
	// Suppress concours and all parameters
		$concours->delete_concours();
		redirect(PHPWG_ROOT_PATH.'admin.php?page=plugin&section=' . CONCOURS_DIR . '%2Fadmin.php');
		break;
		
	case "new" :
		$concours->concours_infos['groups'] = array();
		$concours->concours_infos['category'] = '';
		$template->assign( 'CONCOURS', array(
				'ID'	=> $concours_id,
				));

        //  Init begin and end date
          $form['start_year']  = $form['end_year']  = date('Y');
          $form['start_month'] = $form['end_month'] = date('n');
          $form['start_day']   = $form['end_day']   = date('j');
                      
        $template->assign(
          array(

            'START_DAY_SELECTED' => @$form['start_day'],
            'START_MONTH_SELECTED' => @$form['start_month'],
            'START_YEAR' => @$form['start_year'],
            'START_HOUR' => '12',
            'START_MIN' => '00',
            
            'END_DAY_SELECTED' => @$form['end_day'],
            'END_MONTH_SELECTED' => @$form['end_month'],
            'END_YEAR'   => @$form['end_year'],
            'END_HOUR' => '12',
            'END_MIN' => '00',
            )
          );

  break;
	case "modify" :

		// Format group list
		$concours->concours_infos['groups'] = explode(',', $concours->concours_infos['groups']);

        
        $tBeginDate = explodeDateArray($concours->concours_infos['begin_date']);
        $tEndDate = explodeDateArray($concours->concours_infos['end_date']);



		
		$template->assign( 'CONCOURS', array(
				'ID'	=> $concours->concours_infos['id'],
				'NAME'	=> $concours->concours_infos['name'],
				'DESCR'	=> $concours->concours_infos['descr'],
                'GUEST' => ($concours->concours_infos['guest'] ? 'checked="checked"' : ''),
                'ADMIN' => ($concours->concours_infos['admin'] ? 'checked="checked"' : ''),				
                'SHOWPODIUM' => ($concours->concours_infos['Podium_onCat'] ? 'checked="checked"' : ''),				
				));
        $template->assign(
          array(

            'START_DAY_SELECTED' => @$tBeginDate[2],
            'START_MONTH_SELECTED' => intval($tBeginDate[1]),
            'START_YEAR' => @$tBeginDate[0],
            'START_HOUR' => @$tBeginDate[3],
            'START_MIN' => @$tBeginDate[4],
            
            'END_DAY_SELECTED' => @$tEndDate[2],
            'END_MONTH_SELECTED' => intval($tEndDate[1]),
            'END_YEAR'   => @$tEndDate[0],
            'END_HOUR' => @$tEndDate[3],
            'END_MIN' => @$tEndDate[4],
            )
          );

		break;
	case "modify_crit" :
	case "edit" :
		$concours->concours_infos['groups'] = explode(',', $concours->concours_infos['groups']);

        $tBeginDate = explodeDateArray($concours->concours_infos['begin_date']);
        $tEndDate = explodeDateArray($concours->concours_infos['end_date']);
		
		$template->assign( 'CONCOURS', array(
				'ID'	=> $concours->concours_infos['id'],
				'NAME'	=> $concours->concours_infos['name'],
				'DESCR'	=> $concours->concours_infos['descr'],
                'GUEST' => ($concours->concours_infos['guest'] ? 'checked="checked"' : ''),
                'ADMIN' => ($concours->concours_infos['admin'] ? 'checked="checked"' : ''),
				));
        $template->assign(
          array(

            'START_DAY_SELECTED' => @$tBeginDate[2],
            'START_MONTH_SELECTED' => @$tBeginDate[1],
            'START_YEAR' => @$tBeginDate[0],
            'START_HOUR' => @$tBeginDate[3],
            'START_MIN' => @$tBeginDate[4],
            
            'END_DAY_SELECTED' => @$tEndDate[2],
            'END_MONTH_SELECTED' => @$tEndDate[1],
            'END_YEAR'   => @$tEndDate[0],
            'END_HOUR' => @$tEndDate[3],
            'END_MIN' => @$tEndDate[4],
            )
          );
		
		$firstcriterias = $concours->get_firstlevel_criterias();
		foreach ($firstcriterias as $criteria)
		{
		if ($concours->debug)					echo "criteriaID=".$criteria['criteria_id']."\n";
			// First without sub criterias
			if (!$concours->is_criterias_contains_sub($criteria['criteria_id'] ))
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
						'U_EDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=modify&amp;id='.$criteria['id'],
						'U_DELETE' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=delete&amp;id='.$criteria['id'],
						'U_ADD' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=add&amp;upcriteria='.$criteria['criteria_id'],
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
						'U_ADD' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=add&amp;upcriteria='.$criteria['criteria_id'],
					));
				$secondcriterias = $concours->get_subcriterias($criteria['criteria_id'] );
				foreach ($secondcriterias as $subcriteria)
				{
		if ($concours->debug)							echo "subcriteriaID=".$criteria['criteria_id']."\n";
					$template->append( 'concours_criteria', array(
							'nosub'	=> true,
							'level'	=> 2,
							'id' 	=> $subcriteria['criteria_id'],				// id du critere
							'name' 	=> $subcriteria['name'],				// id du critere
							'lib'	=> $subcriteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
							'min' 	=> $subcriteria['min_value'],				// min
							'max' 	=> $subcriteria['max_value'],				// max
							'pond' 	=> $subcriteria['ponderation'],			// ponderation
							'U_EDIT' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=modify&amp;id='.$subcriteria['id'],
							'U_DELETE' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-criteria&amp;id_concours=' . $concours->concours_id.'&amp;action=delete&amp;id='.$subcriteria['id'] ,
						));					
				}
			}

		}
		
		break;
}
	
	
	
$template->assign( 'action', $action);
$template->assign('IMG_URL', CONCOURS_IMG_PATH);
	

// Add month list to template
$template->assign(array('month_list' => $month_list));

// Add method list to 
$i=1;
foreach ( $method_list as $order ) //on parcours le tableau 
{
	$template->append('concours_method',
		array(	'ID' => $i,
				'NAME' => $order,
				'SELECTED' => (isset($concours->concours_infos['method']) && $concours->concours_infos['method'] == $i ? 'selected' : '')));
	$i++;	
}

if ($concours->is_closed($concours_id) AND !$concours->is_result_present($concours_id))
	$template->append('result_not_generated', true);


// Groups selection
$groups = get_all_groups();
if (!empty($groups))
{
  $template->assign('group_perm', array('GROUPSELECTION' => get_html_groups_selection($groups, 'groups', (isset($concours->concours_infos['groups']) ? $concours->concours_infos['groups'] : array()))));
}


// Category selection
$query = '
  SELECT id, name, uppercats, global_rank
  FROM '.CATEGORIES_TABLE.';';

  $result = pwg_query($query);
  $categories = array();
if (!empty($result))
{
	while ($row = pwg_db_fetch_array($result))
		array_push($categories, $row);
}
usort($categories, 'global_rank_compare');

if (!empty($result))
{
		foreach ($categories as $cat)
			$template->append('category_selection',
				array(	'ID' => $cat['id'],
						'NAME' => get_cat_display_name_cache($cat['uppercats'],null,false),
						'SELECTED' => ($concours->concours_infos['category'] == $cat['id'] ? 'selected' : '')
					));
}



$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/template/add_concours.tpl'));
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');

// Explode a date format ("AAAA-MM-JJ HH:hh:ss") in array
// Array(YYYY, MM, JJ, HH, mm, ss)
function explodeDateArray($date) {

  $tDeb = explode("-", substr($date,0,strpos($date, ' ')));
  $tDebH = explode(":", substr($date,strpos($date, ' ')+1));

  return array($tDeb[0], $tDeb[1], $tDeb[2], $tDebH[0], $tDebH[1], $tDebH[2]);
  
}


// NB of days between 2 dates "AAAA-MM-JJ HH:hh:ss"
function NbJours($debut, $fin) {

  $tDeb = explode("-", substr($debut,0,strpos($debut, ' ')));
  $tFin = explode("-", substr($fin,0,strpos($fin, ' ')));

  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - 
          mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
  
  return(($diff / 86400));

}
function AjoutJours($debut, $jours) {
  $tDeb = explode("-", substr($debut,0,strpos($debut, ' ')));
  $tDebH = explode(":", substr($debut,strpos($debut, ' ')+1));
  $tFin = "";

	$nb_ans = (int)(($jours)/365);
	$nb_mois = (int)(( ($jours)%365) / 31);
	$nb_jours = (int)(( ($jours)%365) % 31);		

$tFin = date("Y-m-d H:m:s", mktime($tDebH[0], $tDebH[1], $tDebH[2], $tDeb[1] + $nb_mois, $tDeb[2] + $nb_jours, $tDeb[0] + $nb_ans));
  
  return($tFin);

}


?>