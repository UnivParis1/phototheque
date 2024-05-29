<?php

// file to audit concours configutation and votes
// --> if _GET['concours'] ==> concours audit (with id)
//		if _GET['user_id'] ==> audit for a user
// --> else ==> list concours to be audited

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
include_once(CONCOURS_PATH . 'admin/functions.inc.php');

global $template;

$user_vote = array();

if (isset($_POST['user_list']))
    $user_id = $_POST['user_list'];
else 
    $user_id = 0;
    
//		echo "USER_ID=".$user_id;
   
// Get the concours id if present
if (isset($_GET['concours']))
{
	$concours_id = $_GET['concours'];
	// Get informations from base for concours_id
	$concours = new Concours($concours_id);

	// get user that already vote for the concours
	$user_vote = $concours->get_user_list();
	
    // Get group authorized to participate 
    $users = array();     // contain {id;username} or each 
    $groups = $concours->concours_infos['groups'];

    $query = 'SELECT distinct(id) AS user_id, username FROM '. USERS_TABLE .' USER '
    .($groups != NULL ?' INNER JOIN ' . USER_GROUP_TABLE .' ON id = user_id' : '')
    .($groups != NULL ? ' WHERE group_id IN ('.$groups.')' : '')
	.($user_vote != NULL ? ($groups != NULL ? 'AND ' : 'WHERE ').'id IN ('.implode(',', $user_vote).')' : '')
    .' ORDER BY username ASC'
    .';';

    $result = pwg_query($query);
    while ($row = pwg_db_fetch_array($result))
    {		
			array_push($users, $row);
    }       

	
    // Add user list
    $template->append('user_list',
        array(	'ID' => '0',
                'NAME' => l10n('all_users'),
                'SELECTED' => ($user_id == 0 ? 'selected' : '')));

    foreach ( $users as $userid ) //on parcours le tableau 
    {
        $template->append('user_list',
            array(	'ID' => $userid['user_id'],
                    'NAME' => $userid['username'],
                    'SELECTED' => ($user_id == $userid['user_id'] ? 'selected' : '')));
    }

    // Add the guest list (if coucours OK for guest)
    $ipguest = $concours->get_guest_list();
    if ($concours->concours_infos['guest'])
    {
        foreach ( $ipguest as $i => $userid ) //on parcours le tableau 
        {
            $template->append('user_list',
                array(	'ID' => 'G'.$i,     //$userid['user_id'],
                        'NAME' => $userid,
                        'SELECTED' => ($user_id == 'G'.$i ? 'selected' : '')));
        }
    }
    
    // Send concours info to template
    $template->assign( 'CONCOURS', array(
            'ID'	=> $concours->concours_infos['id'],
            'NAME'	=> $concours->concours_infos['name'],
            'DESCR'	=> $concours->concours_infos['descr'],
            'BEGIN_DATE'	=> $concours->concours_infos['begin_date'],
            'END_DATE'	=> $concours->concours_infos['end_date'],
            'METHOD'	=> l10n("concours_method".$concours->concours_infos['method']),
			'METHODNB'	=> $concours->concours_infos['method']
            ));

// Step 1 : recover all the picture for the concours
// Step 2 :For each picture, recover the global note, the number of vote, the actual rank (?),
// Step 3 : Display theses informations
	
    // Get the nb of vote for the concours
    $nbvotes = $concours->nb_votes_by_img();


	// Get all the users who have notes for the concours
	$query = 'SELECT distinct user_id, USER.username'
	.' FROM ' .CONCOURS_DATA_TABLE
	.' INNER JOIN ' . USERS_TABLE.' AS USER on USER.id = user_id'
	.' WHERE id_concours = '.$concours_id
        // Dont take the guest informations because 
    .' AND user_id <> '.$conf['guest_id']
	.' ORDER BY username ASC'
	.';';
	$result = pwg_query($query);
	// For each user
	$user_list = array();
	while ($row2 = pwg_db_fetch_array($result))
            array_push($user_list, $row2);	


	// Get criteria list and 
	$criteria_list = "";
	$firstcriterias = $concours->get_firstlevel_criterias($concours_id);
	$ident1 = 1;
	$criteria_number = 0;	// total number of criterias
	foreach ($firstcriterias as $criteria)
	{
		// format (id:name)
		$criteria_list .= (strlen($criteria_list) ? "," : "")
							.$ident1.":".$criteria['name']
							."(id=".$criteria['criteria_id'].")";
		// First wit sub criterias
		if ($concours->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
		{
			$ident2 = 1;
			$secondcriterias = $concours->get_subcriterias($criteria['criteria_id'], $concours_id );
			foreach ($secondcriterias as $subcriteria)
			{
				// format (id:name)
				$criteria_list .= (strlen($criteria_list) ? "," : "")
								  .$ident1.".".$ident2
								  .":".$subcriteria['name']."(id=".$subcriteria['criteria_id'].")";
				$ident2 ++;
				$criteria_number ++;
			}
		}
		else
		$criteria_number ++;
		$ident1++;
	}
		


	// Get images for all the selected cconcours
		
	$category = $concours->concours_infos['category'];

	$query = 'SELECT DISTINCT(img.id), img.name, img.file, img.path, img.author , img.added_by ,
			  ic.category_id, cat.name AS catname' 	//, conc.note'
			.' FROM ' . IMAGES_TABLE.' AS img'
			.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON img.id = ic.image_id'
			.' INNER JOIN '.CATEGORIES_TABLE.' AS cat ON ic.category_id = cat.id'
			.' WHERE ic.category_id = '.$concours->concours_infos['category']
			.';';

	$result = pwg_query($query);
	$concours_img = array();

	// Recover all pictures and informations (global note
	while ($row = pwg_db_fetch_array($result))
	{
		// link on picture.php page
		set_make_full_url();
		if ( isset($row['category_id']) & isset($row['catname']) ) 
		{
			$url = duplicate_picture_url(
			array(
			'image_id' => $row['id'],
			'image_file' => $row['file'],
			'category' => array(
							'id' => $row['category_id'],
							'name' => $row['catname'],
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
				'image_id' => $row['id'],
				'image_file' => $row['file']
			  ),
			  array('start')
			);
		}	
		unset_make_full_url();
		
		// Get note (depending on the calling : global OR user)
		$user_note = array();
		$globalnote = 0;
		if (!is_numeric($user_id) OR $user_id != 0)	// for user 
		{   
            $pos = strpos($user_id, 'G');
	
            if ($pos === false)
            {
                $globalnote = $concours->get_img_globalnote_user($row['id'], $concours_id, $user_id);
				if ($globalnote < 0) $globalnote = 0;
                $user_note = $concours->get_img_note_user($row['id'], $concours_id, $user_id);
            }
            else
            {
                $globalnote = $concours->get_img_globalnote_user($row['id'], $concours_id, $conf['guest_id'], $ipguest[substr($user_id, $pos+1)]);
				if ($globalnote < 0) $globalnote = 0;	
                $user_note = $concours->get_img_note_user($row['id'], $concours_id, $conf['guest_id'], $ipguest[substr($user_id, $pos+1)]);
            }
		}
		elseif (is_numeric($user_id) AND $user_id == 0)	// for user 	// global
		{        
			foreach ($user_list as $i => $userid)
			{	
				$usernote = $concours->get_img_globalnote_user($row['id'], null, $userid['user_id']);
                $globalnote += ($usernote >= 0 ? $usernote : 0) ;
            }
			foreach ($ipguest as $i => $ipguestt)
            {
				$usernote = $concours->get_img_globalnote_user($row['id'], null, $conf['guest_id'], $ipguestt);
                $globalnote += ($usernote >= 0 ? $usernote : 0) ;

			}
        }



	// replace get_thumbnail_url (>piwigo 2.5) 
    // DerivativeImage::thumb_url($row);
		
		$concours_img[$row['id']]  = array(
				'img_id' => $row['id'],
				'name'	=> $row['name'],
				'author'=> $row['author'],
				'addedby'  =>  get_username($row['added_by']),
				'file'	=> $row['file'],
				'rang'	=> 0,
				'thumb'	=> DerivativeImage::thumb_url($row),
				'url'	=> $url,
				'note'	=> ($globalnote < 0 ? "N/A" : $globalnote) ,
                'moyenne' 	=> (isset($nbvotes[$row['id']]) && $nbvotes[$row['id']] >=0  ? round ($globalnote/(int)$nbvotes[$row['id']], 2) : "N/A"),
				'nbvotant' => isset($nbvotes[$row['id']]) ? $nbvotes[$row['id']] : 0
				);

	}

	// Order image by "note" or "moyenne"
    if ($concours->concours_infos['method'] == 1) // sum method
        $concours_img = array_sort($concours_img, 'note', false);
    elseif ($concours->concours_infos['method'] > 1) // moy method (even for moderation, moderation are only calculated on final)
        $concours_img = array_sort($concours_img, 'moyenne', false);
    
	$rang = 1;
    $previousNote = $previousMoy = 0;

	if ($concours_img != null)
	{
		foreach ($concours_img  as $key => $value) 
		{

			// Check the exaequos
			if ($concours->my_config['check_exaequo'])
			{
				if ( ($concours->concours_infos['method'] == 1	// total
					   AND ($concours_img[$key]['note'] == $previousNote))
					 OR  ($concours->concours_infos['method'] > 1	// moyenne (and moderation)
						  AND ($concours_img[$key]['moyenne'] == $previousMoy)))
				{
					$rang --;
					
				}
			}
		   $concours_img[$key]['rang'] = $rang;

			$template->append( 'concours_note', array(
					'img_id' => $concours_img[$key]['img_id'],
					'author' => $concours_img[$key]['author'],
					'addedby'  =>  $concours_img[$key]['addedby'],
					'name'	=> $concours_img[$key]['name'],
					'file'	=> $concours_img[$key]['file'],
					'rang'	=> $concours_img[$key]['rang'],
					'thumb'	=> $concours_img[$key]['thumb'],
					'url'	=> $concours_img[$key]['url'],
					'note' 	=> ($concours_img[$key]['note'] < 0 ? "N/A" : $concours_img[$key]['note']),
					'moyenne' 	=> ($concours_img[$key]['moyenne'] < 0 ? "N/A" : round($concours_img[$key]['moyenne'], 2)),
					'nbvotant' => $concours_img[$key]['nbvotant']

				));
			$rang++;

			$previousNote = ($concours_img[$key]['note'] < 0 ? $previousNote : $concours_img[$key]['note']);
			$previousMoy = ($concours_img[$key]['moyenne'] < 0 ? $previousMoy : $concours_img[$key]['moyenne']);
		}
	}
}




if (isset($_POST['submit'])) { 
}


$template->set_filename('plugin_admin_content', dirname(__FILE__) . '/template/audit.tpl');
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');


// Function to sort the array
// asc =  false ==> descendant
function array_sort($array, $key, $asc=true)
{
	if ($array != null)
	{
		foreach ($array as $i => $o) 
		{
		   $sort_values[$i] = $array[$i][$key];

		}
		if ($asc)
			asort  ($sort_values);
		else
			arsort ($sort_values);
		reset ($sort_values);


		while (list ($arr_key, $arr_val) = each ($sort_values)) 
		{
			 $sorted_arr[] = $array[$arr_key];
		}

		unset($array);
		return $sorted_arr;
	}
	return null;
}

?>