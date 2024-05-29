<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
include_once CONCOURS_PATH.'/stuffs_module/functions.inc.php';

global $template;

// Publish the result on a global page.
// Mode global ==> simply display global result
// Mode full ==> display global result and user notations

$ap_id = explode('concours/' , $_SERVER['REQUEST_URI']);
$id_concours = $ap_id[1];

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

		$template->assign( 'CONCOURS', array(
				'ID'	=> $concours->concours_infos['id'],
				'NAME'	=> $concours->concours_infos['name'],
				'DESCR'	=> $concours->concours_infos['descr'],
				'BEGIN_DATE'	=> $concours->concours_infos['begin_date'],
				'END_DATE'	=> $concours->concours_infos['end_date'],
				'METHOD'	=> l10n("concours_method".$concours->concours_infos['method']),
				'METHODNB'	=> $concours->concours_infos['method'],
				'DAYS'		=> NbJours($concours->concours_infos['begin_date'], $concours->concours_infos['end_date']),
				'NB_VOTANT' => count($concours->get_user_list($concours->concours_infos['id']))+count($concours->get_guest_list($concours->concours_infos['id'])),
				'NBIMG'		=> $concours->nb_img_by_concours($concours->concours_infos['id'])
				
				));


$category = $concours->concours_infos['category'];

if (!(isset($concours->concours_infos['method'])))
	$concours->concours_infos['method'] = 1;

$query = 'SELECT DISTINCT(img.id), img.name, img.file, img.path, img.author, img.added_by,
		  ic.category_id, cat.name AS catname, conc.note, conc.moyenne, conc.moderation1, conc.moderation2, conc.nbvotant'
		.' FROM ' . IMAGES_TABLE.' AS img'
		.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON img.id = ic.image_id'
		.' INNER JOIN '.CATEGORIES_TABLE.' AS cat ON ic.category_id = cat.id'
		.' INNER JOIN '.CONCOURS_RESULT_TABLE.' AS conc ON conc.img_id = img.id'
		.' WHERE ic.category_id = '.$concours->concours_infos['category']
		.' AND conc.id_concours = '.$concours->concours_infos['id'];

		
switch ($concours->concours_infos['method'])
{
	case 1 :// total
		$query .= ' ORDER BY note DESC';
		break;
	case 2 :// moyenne
		$query .= ' ORDER BY moyenne  DESC';
		break;
	case 3 :// moderation1
		$query .= ' ORDER BY moderation1 DESC';
		break;
	case 4 :// moderation2
		$query .= ' ORDER BY moderation2 DESC';
		break;
}


$query .=';';
//		.' ORDER by note DESC;';
$result = pwg_query($query);
$rang = 1;
$previousNote = $previousMoy = 0;
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

    // Check the exaequos
    if ($concours->my_config['check_exaequo'])
    {
        if ( ($concours->concours_infos['method'] == 1	// total
               AND ($row['note'] == $previousNote))
             OR  ($concours->concours_infos['method'] == 2	// moyenne
                  AND ($row['moyenne'] == $previousMoy))
             OR  ($concours->concours_infos['method'] == 3	// moderation1
                  AND ($row['moderation1'] == $previousMoy))
             OR  ($concours->concours_infos['method'] == 4	// moderation2
                  AND ($row['moderation2'] == $previousMoy)))
				  
        {
//            echo "Rang=".$rang."\n";
            $rang --;
            
        }
    }
	$usernote = $concours->get_img_globalnote_user($row['id'], null, null, $user['ipguest']);
	$template->append( 'concours_note', array(
			'img_id' => $row['id'],
			'name'	=> $row['name'],
			'file'	=> $row['file'],
			'author'	=> (strlen($row['author']) === 0 ? get_username($row['added_by']): $row['author']),
			'addedby'  =>  get_username($row['added_by']),
			'rang'	=> $rang,
//			'thumb'	=> DerivativeImage::thumb_url($row),
			'thumb'	=> DerivativeImage::url(IMG_XXSMALL, $row),
			'url'	=> $url,
			'note' 	=> ($row['note'] == 0 ? 'N/A' :$row['note']),
			'moyenne' 	=> ($row['moyenne'] == 0 ? 'N/A' : round($row['moyenne'] , 2)),
			'moderation1' 	=> ($row['moderation1'] == 0 ? 'N/A' : round($row['moderation1'], 2) ),
			'moderation2' 	=> ($row['moderation2'] == 0 ? 'N/A' : round($row['moderation2'], 2)),			
			'nbvotant' 	=> $row['nbvotant'],
			'usernote'	=> ($usernote < 0 ? "N/A" : $usernote)
			
		));
    $rang ++;
    
//    echo "Rang=".$rang."\n";
    $previousNote = $row['note'];
    $previousMoy = $row['moyenne'];

}
// Envoi de la page
$template->assign(array(
  'TITLE' => "Concours : ".$concours->concours_infos['name']));

$template->assign('IMG_URL', CONCOURS_IMG_PATH);

$template->set_filenames(array('concours_result' =>  CONCOURS_ROOT.'/template/result.tpl'));
$template->concat('PLUGIN_INDEX_CONTENT_BEGIN', $template->parse('concours_result', true));
  
  
  $template->assign('PLUGIN_INDEX_ACTIONS' , '
    <li><a href="' . make_index_url() . '" title="' . l10n('return to homepage') . '">
      <img src="' . $template->get_themeconf('icon_dir') . '/home.png" class="button" alt="' . l10n('home') . '"/></a>
    </li>');

if (is_admin())
{
  $template->assign('U_EDIT', PHPWG_ROOT_PATH . 'admin.php?page=plugin&amp;section=' . CONCOURS_DIR . '%2Fadmin%2Fadd_concours.php&amp;concours=' . $id_concours.'&amp;action=edit');
}

$template->clear_assign(array('U_MODE_POSTED', 'U_MODE_CREATED'));


?>
