<?php

// Get all generated csv files stored on RESULT directory
function get_csvfile_result()
{
	$csvfile = array();
    if (is_dir(CONCOURS_RESULT_FOLDER) )
	{
		$dir = opendir(CONCOURS_RESULT_FOLDER);
		while ($file = readdir($dir)) 
		{
            // only csv file
			if ($file != '.' and $file != '..' and preg_match("/.csv/", $file)) 
            {
				$path = CONCOURS_RESULT_FOLDER . $file;
				if (!is_dir($path) and !is_link($path)) 
				{
					$concours_info = get_info_concours_from_csvfile($file);
					$csvfile[$file] = array(
						'name' => $file,
						'link' => $path,
						'conc_id' => (isset($concours_info['conc_id']) ? $concours_info['conc_id'] : "0"),
						'conc_name' => (isset($concours_info['conc_name']) ? $concours_info['conc_name'] : "N/A"),
						'conc_descr' => (isset($concours_info['conc_descr']) ? $concours_info['conc_descr'] : "N/A")
						);

	// Try to search on database if the concours is already present to recover name ans description					
				}
			}
		}
		closedir($dir);
		uasort($csvfile, 'name_compare');
	}
	return $csvfile;
}

// Get name and description of a concours with resulte file name
function get_info_concours_from_csvfile($csvfile = "")
{

	$query = 'SELECT id_concours as conc_id, CONC.name as conc_name, CONC.descr as conc_descr'
	.' FROM ' .CONCOURS_RESULT_TABLE
	.' INNER JOIN '.CONCOURS_TABLE.' AS CONC ON CONC.id = id_concours'
	.' WHERE file_name = "'.$csvfile .'"'
	.';';

	$result = pwg_query($query);
	if ($result)
		return pwg_db_fetch_assoc($result);
	else
		return false;
	
}


// check if a result is already present in the database
function has_result($concours_id)
{
	// recover all img_id from the category
	$query = 'SELECT DISTINCT(id_concours)'
	.' FROM ' .CONCOURS_RESULT_TABLE
	.' WHERE id_concours = '.$concours_id .';';
	
	$result = pwg_query($query);
	// For each images
	if (pwg_db_fetch_assoc($result))

		return true;
	else
		return false;

}
// check if a file is already generated and return the link
function has_file($concours_id)
{
	// recover all img_id from the category
	$query = 'SELECT DISTINCT(file_name)'
	.' FROM ' .CONCOURS_RESULT_TABLE
	.' WHERE id_concours = '.$concours_id .';';
	
	$result = pwg_query($query);
	// For each images
	if ($row = pwg_db_fetch_assoc($result))
		return $row['file_name'];
	else
		return false;

}

function get_nb_concours($type = null)
{
	switch ($type)
	{
		case 'prepared':
			return get_nb_prepared_concours();
			break;
		case 'active':
			return get_nb_active_concours();
			break;
		case 'closed':
			return get_nb_closed_concours();
			break;
		case 'closed-noresult':
		{
			$query = '
				SELECT count(distinct id) as nb_concours
				FROM ' . CONCOURS_TABLE 
				.' WHERE id>0'	// Do not take Concours 0 (default) 
				.' AND id NOT IN (SELECT id_concours FROM ' .CONCOURS_RESULT_TABLE.')'
				.';';

			$result = pwg_query($query);
			if ($result)
			{
				$row = pwg_db_fetch_array($result);
				return $row['nb_concours'];
			}
			else
				return 0;
			break;
		}
		default:
		{
			$query = '
				SELECT count(distinct id) as nb_concours
				FROM ' . CONCOURS_TABLE 
				.' WHERE id>0'	// Do not take Concours 0 (default) 
				.';';

			$result = pwg_query($query);
			if ($result)
			{
				$row = pwg_db_fetch_array($result);
				return $row['nb_concours'];
			}
			else
				return 0;
			break;
		}
	}

}

function get_nb_active_concours()
{
	$query = '
		SELECT count(distinct id) as nb_concours
		FROM ' . CONCOURS_TABLE.
		' WHERE time_to_sec(TIMEDIFF(begin_date, now())) < 0
		  AND time_to_sec(TIMEDIFF(now(), end_date)) < 0'
		.' AND id>0'	// Do not take Concours 0 (default) 
		.';';

	$result = pwg_query($query);
	if ($result)
	{
		$row = pwg_db_fetch_array($result);
		return $row['nb_concours'];
	}
	else
		return 0;
}


function get_nb_prepared_concours()
{
	$query = '
		SELECT count(distinct id) as nb_concours
		FROM ' . CONCOURS_TABLE .' 
		WHERE time_to_sec(TIMEDIFF(begin_date, now())) > 0'
		.' AND id>0'	// Do not take Concours 0 (default) 
		.';';

	$result = pwg_query($query);
	if ($result)
	{
		$row = pwg_db_fetch_array($result);
		return $row['nb_concours'];
	}
	else
		return 0;
}

function get_nb_closed_concours()
{
	$query = '
		SELECT count(distinct id) as nb_concours
		FROM ' . CONCOURS_TABLE .' 
		WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 '
		.' AND id>0'	// Do not take Concours 0 (default) 
		.';';

	$result = pwg_query($query);
	if ($result)
	{
		$row = pwg_db_fetch_array($result);
		return $row['nb_concours'];
	}
	else
		return 0;
}


// Get list of inactive concours
// return array with concours id
function get_inactive_concours()
{
	$concours_list=array();
	$query = '
		SELECT *
		FROM ' . CONCOURS_TABLE .' 
		WHERE time_to_sec(TIMEDIFF(begin_date, now())) > 0'
		.' AND id>0'	// Do not take Concours 0 (default) 
		.' ORDER BY id
		;';

	$result = pwg_query($query);
	while ($row = pwg_db_fetch_assoc($result))

	{
		array_push($concours_list, $row);
	}
	return $concours_list;
}

// Get list of active concours
// return array with concours id
function get_active_concours()
{
	$concours_list=array();
	$query = '
		SELECT *
		FROM ' . CONCOURS_TABLE .' 
		WHERE time_to_sec(TIMEDIFF(begin_date, now())) < 0
		AND time_to_sec(TIMEDIFF(now(), end_date)) < 0'
		.' AND id>0'	// Do not take Concours 0 (default) 
		.' ORDER BY id
		;';

	$result = pwg_query($query);
	while ($row = pwg_db_fetch_assoc($result))

	{
		array_push($concours_list, $row);
	}
	return $concours_list;
}

// Get list of closed concours
// return array with concours id
function get_closed_concours()
{
	$concours_list=array();
	$query = '
		SELECT *
		FROM ' . CONCOURS_TABLE .' 
		WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 '
		.' AND id>0'	// Do not take Concours 0 (default) 
		.'ORDER BY id'
		.';';

	$result = pwg_query($query);
	while ($row = pwg_db_fetch_assoc($result))
	{
		array_push($concours_list, $row);
	}
	return $concours_list;
}


function get_html_groups_selection(
  $groups,
  $fieldname,
  $selecteds = array()
  )
{
  global $conf;
  if (count ($groups) == 0 )
  {
    return '';
  }
  $output = '<div id="'.$fieldname.'">';
  $id = 1;
  foreach ($groups as $group)
  {
    $output.=

      '<input type="checkbox" name="'.$fieldname.'[]"'
      .' id="group_'.$id++.'"'
      .' value="'.$group['id'].'"'
      ;

    if (in_array($group['id'], $selecteds))
    {
      $output.= ' checked="checked"';
    }

    $output.=
      '><label>'
      .'&nbsp;'. $group['name']
      .'</label>'
      ."\n"
      ;
  }
  $output.= '</div>';

  return $output;
}


function get_all_groups()
{
$query = '
SELECT id, name
  FROM '.GROUPS_TABLE.'
  ORDER BY name ASC
;';
$result = pwg_query($query);

$groups = array();
	while ($row = pwg_db_fetch_assoc($result))
  {
    array_push($groups, $row);
  }

  uasort($groups, 'name_compare');
  return $groups;
}

?>