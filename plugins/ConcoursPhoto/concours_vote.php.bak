<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

global $template, $user, $tpl_var;


$page['title'] = 'Global Concours';

// Display all photo with criterias in 1 global page.

$ap_id = explode('concours_vote/' , $_SERVER['REQUEST_URI']);
$id_concours = $ap_id[1];


$sortby = (isset($_GET['concours_sort_order']) ? $_GET['concours_sort_order'] : 'score');

if (isset($_POST['concours_SORT_submit']) OR isset($_POST['concours_submit'])) 
{
	$sortby = $_POST['concours_sort_order'];
//		echo 'sortby='.$sortby;
	$template->assign('sort_order',$sortby);
}

$template->assign('sort_order',$sortby);

$img_array = array();

$user['ipguest'] = null;
if (is_a_guest())
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $IP = $_SERVER['HTTP_X_FORWARDED_FOR']; 
    elseif(isset($_SERVER['HTTP_CLIENT_IP']))   
        $IP = $_SERVER['HTTP_CLIENT_IP'];   
    else
        $IP = $_SERVER['REMOTE_ADDR'];  
         
    // store ip
    $user['ipguest'] = $IP;
}

$concours = new Concours($id_concours);

if (isset($concours->my_config['active_global_score_page']) AND $concours->my_config['active_global_score_page'])	// only if option is activated
{
$concours_maxnote = $concours->get_concours_maxnote($id_concours);

	if (strtotime($concours->concours_infos['end_date'])-time() < 0)	// Concours finished
	{
	}
	elseif (strtotime($concours->concours_infos['begin_date'])-time() > 0)
	{
		$template->assign('begin_concours_min', (strtotime($concours->concours_infos['begin_date'])-time()));
		$template->assign('deadline_type',$concours->my_config['concours_deadline']);
		$template->assign('begin_concours', $concours->concours_infos['begin_date']);
	}
	else
	{

		$authorized_groups = explode(',', $concours->concours_infos['groups']);
		if ( (!empty($concours->user_groups && array_intersect($concours->user_groups, $authorized_groups) != array()))
			OR (is_a_guest() AND $concours->concours_infos['guest'])
			OR !is_a_guest()
			)
		{	

			$template->assign('end_concours', $concours->concours_infos['end_date']);
			$template->assign('end_concours_min', (strtotime($concours->concours_infos['end_date'])-time()));
			$template->assign('deadline_type',$concours->my_config['concours_deadline']);

			$template->assign( 'CONCOURS', array(
					'ID'	=> $concours->concours_infos['id'],
					'NAME'	=> $concours->concours_infos['name'],
					'DESCR'	=> $concours->concours_infos['descr'],
					'BEGIN_DATE'	=> $concours->concours_infos['begin_date'],
					'END_DATE'	=> $concours->concours_infos['end_date'],
					'end_concours', $concours->concours_infos['end_date'],
					'end_concours_min', (strtotime($concours->concours_infos['end_date'])-time()),
					'deadline_type',$concours->my_config['concours_deadline']		
					));


			$category = $concours->concours_infos['category'];

			$query = 'SELECT DISTINCT(img.id) AS id, img.name, img.file, img.path, img.author, 
					  ic.category_id, cat.name AS catname, '
					.' conc.id as concours_id'
					.' FROM ' . IMAGES_TABLE.' AS img'
					.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON img.id = ic.image_id'
					.' INNER JOIN '.CATEGORIES_TABLE.' AS cat ON ic.category_id = cat.id'
					.' INNER JOIN '.CONCOURS_TABLE.' AS conc ON conc.category = cat.id'
					.' WHERE ic.category_id = '.$concours->concours_infos['category']
					.' AND conc.id = '.$concours->concours_infos['id']
//					.' AND time_to_sec(TIMEDIFF(now(), conc.end_date)) < 0'
					;
				
			$query .=';';

			$result = pwg_query($query);
			$array_note_user = array();

			while ($row = pwg_db_fetch_array($result))
			{
				

				if ( !$concours->check_img_user($row['id']))
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


					$firstcriterias = $concours->get_firstlevel_criterias($concours->concours_infos['id']);

					
					// save all note
					if (isset($_POST['concours_submit']))
					{
					//                    array_push($page['infos'] , l10n('concours_vote_saved'));	
						$user_note = "";
						// DEBUG
						if ($this->debug)			echo "SUBMIT";
						// END DEBUG
						
						// concat all the notes to save on db
						foreach ($firstcriterias as $criteria)
						{							
							// First without sub criterias
							if (!$concours->is_criterias_contains_sub($criteria['criteria_id'],$concours->concours_infos['id'] ))
							{
								if (isset($_POST[$row['id']."_".$criteria['criteria_id']]))	// vote present
								{
									// Check value 
									$value = str_replace(",",".",(isset($_POST[$row['id']."_".$criteria['criteria_id']]) ? $_POST[$row['id']."_".$criteria['criteria_id']] : floatval($criteria['min_value'])));
									$value = str_replace(" ","",$value);
									$value = floatval($value);
									if ($value < floatval($criteria['min_value']))
										$value = floatval($criteria['min_value']);
									if ($value > floatval($criteria['max_value']))
										$value = floatval($criteria['max_value']);

									$user_note .= (strlen($user_note) != 0 ? ";" : "").$criteria['criteria_id']."=".$value;
								}
							}
							else
							{
								$secondcriterias = $concours->get_subcriterias($criteria['criteria_id'], $concours->concours_infos['id'] );
								foreach ($secondcriterias as $subcriteria)
								{
									if (isset($_POST[$row['id']."_".$subcriteria['criteria_id']]))	// vote present
									{

										// Check value 
										$value = str_replace(",",".",(isset($_POST[$row['id']."_".$subcriteria['criteria_id']]) ? $_POST[$row['id']."_".$subcriteria['criteria_id']] : floatval($subcriteria['min_value'])));
										$value = str_replace(" ","",$value);
										$value = floatval($value);
										if ($value < floatval($subcriteria['min_value']))
											$value = floatval($subcriteria['min_value']);
										if ($value > floatval($subcriteria['max_value']))
											$value = floatval($subcriteria['max_value']);
									
										$user_note .= (strlen($user_note) != 0 ? ";" : "").$subcriteria['criteria_id']."=".$value;
									}
								}
							}
						}

						if ($user_note != "")		// store only if criterias are presents
						{
							$concours->store_img_note_user($row['id'], $user_note, $concours->concours_infos['id'], $user['ipguest']);
							// comment on global page
							$concours->store_img_comment_user($row['id'], $_POST[$row['id'].'_concours_comment'], $concours->concours_infos['id'], $user['ipguest']);
						}
					}

					
					
					$user_notes = $concours->get_img_note_user($row['id'], $row['concours_id'], $user['id'], $user['ipguest']);
			
					$real_criteria_nb = 0;

					foreach ($firstcriterias as $criteria)
					{
						// First without sub criterias
						if (!$concours->is_criterias_contains_sub($criteria['criteria_id'],$concours->concours_infos['id'] ))
						{
				//			echo "---1---<br>\n";
							$array_note_user[$row['id']][$criteria['criteria_id']] = array(
																					'nosub'	=> true,
																					'level'	=> 1,
																					'id' 	=> $criteria['criteria_id'],				// id du critere
																					'name' 	=> $criteria['name'],				// id du critere
																					'lib'	=> $criteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
																					'val'	=> (isset($user_notes[$criteria['criteria_id']])?$user_notes[$criteria['criteria_id']] : $criteria['min_value']),		//  valeur du critere
																					'min' 	=> $criteria['min_value'],				// min
																					'max' 	=> $criteria['max_value']				// max
																					);
							$real_criteria_nb ++;
						}
						else
						{
				//			echo "---2---criteriaID=".$criteria['criteria_id']."<br>\n";

							$secondcriterias = $concours->get_subcriterias($criteria['criteria_id'], $concours->concours_infos['id'] );
							foreach ($secondcriterias as $subcriteria)
							{
				//			echo "---3---<br>\n";
								// DEBUG
								$array_note_user[$row['id']][$subcriteria['criteria_id']] = array(
														'nosub'	=> true,
														'level'	=> 2,
														'id' 	=> $subcriteria['criteria_id'],				// id du critere
														'name' 	=> $criteria['name'].' : '.$subcriteria['name'],				// id du critere
														'lib'	=> $subcriteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
														'val'	=> (isset($user_notes[$subcriteria['criteria_id']])?$user_notes[$subcriteria['criteria_id']] : $subcriteria['min_value']),
														'min' 	=> $subcriteria['min_value'],				// min
														'max' 	=> $subcriteria['max_value']				// max
														);
								$real_criteria_nb ++;
								
							}
						}
					}

					$user_global_note = $concours->get_img_globalnote_user($row['id'], $concours->concours_infos['id'], $user['id'], $user['ipguest']);
	
				array_push($img_array, array(
							'img_id' => $row['id'],
							'name'	=> $row['name'],
							'file'	=> $row['file'],
							'author'	=> $row['author'],
							'thumb'	=> DerivativeImage::url(IMG_XSMALL, $row),

							'url'	=> $url,
							'score'  => $array_note_user[$row['id']]	,
							'max_note' => $concours_maxnote,
							'note'  => ($user_global_note >= 0 ? $user_global_note : 0),
							'concours_comment' => $concours->get_img_comment_user($row['id'],  $concours->concours_infos['id'], $user['id'], $user['ipguest']),
							'change_note'	=> ($user_global_note == -1 OR $concours->my_config['concours_change_score'])  ? true : false,

						));

			
/*					
					$template->append( 'concours_note', array(
							'img_id' => $row['id'],
							'name'	=> $row['name'],
							'file'	=> $row['file'],
							'author'	=> $row['author'],
							'thumb'	=> DerivativeImage::url(IMG_XSMALL, $row),

							'url'	=> $url,
							'score'  => $array_note_user[$row['id']]	,
							'max_note' => $concours_maxnote,
							'note'  => ($user_global_note >= 0 ? $user_global_note : 0),
							'concours_comment' => $concours->get_img_comment_user($row['id'],  $concours->concours_infos['id'], $user['id'], $user['ipguest']),
							'change_note'	=> ($user_global_note == -1 OR $concours->my_config['concours_change_score'])  ? true : false,

						));
*/									
				}

			}

/*
			foreach ($img_array as $i=>$img)
			{
				echo "<br>;i=".$i;
				foreach ($img as $j=>$value)
				echo "<br>j=".$j." ->".$value.' ;';
				
			}
*/
			// Order photo by score 	
			if ($sortby == 'score')
			{	
				foreach (array_sort($img_array, 'note', SORT_DESC) as $i=>$img)
					$template->append( 'concours_note', $img);
			}
			else
			{	
				foreach ($img_array as $i=>$img)
				$template->append( 'concours_note', $img);
			}			

//			$template->append( 'concours_note', array_sort($img_array, 'note', SORT_DESC));

			$template->assign( 'TEXT_OVERLAY', $concours->my_config['text_overlay']);
			$template->assign('NB_CRITERIAS_CONCOURS', ( isset($real_criteria_nb) ? $real_criteria_nb : 0));
			// Envoi de la page

		}
	}

	$template->assign( 'SCORE_MODE', $concours->my_config['score_mode']);

	$template->assign('IMG_URL', CONCOURS_IMG_PATH);

	$template->set_filenames(array('concours_vote' =>  CONCOURS_ROOT.'/template/concours_vote.tpl'));
	$template->concat('PLUGIN_INDEX_CONTENT_BEGIN', $template->parse('concours_vote', true));
	  
	  
	  $template->assign('PLUGIN_INDEX_ACTIONS' , '
		<li><a href="' . make_index_url() . '" title="' . l10n('return to homepage') . '">
		  <img src="' . $template->get_themeconf('icon_dir') . '/home.png" class="button" alt="' . l10n('home') . '"/></a>
		</li>');

	if (is_admin())
	{
	  $template->assign('U_EDIT', PHPWG_ROOT_PATH . 'admin.php?page=plugin&amp;section=' . CONCOURS_DIR . '%2Fadmin%2Fadd_concours.php&amp;concours=' . $id_concours.'&amp;action=edit');
	}

	$template->clear_assign(array('U_MODE_POSTED', 'U_MODE_CREATED'));
}



function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

?>
