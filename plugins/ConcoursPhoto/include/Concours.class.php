<?php
/*
 * Plugin Name: ConcoursPhoto
 * File :  Concours.class.php  
 */
 
 
include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');

global $user, $conf;

class Concours
{
	var $concours_id = null;
	var $concours_infos = array();
	
	// General configuration parameters
	var $my_config = array();
	var $user_groups = array();
	var $debug = false;


	/**
	 * Class constructor with concours id. 
	 * Return NULL if not existing or create it
	 */
	function __construct($concours_id = null, $force_creation = NULL) 
	{
		if ($concours_id !== null)
		{		
			$this->concours_id = (int)$concours_id;
			$this->get_concours($concours_id);
		}
		// Load general parameters
		$this->load_config();
	}

	
	/**
	 * Load configuration from database
	 * Assign value to the variable $config
	 */
	function load_config() {
		$query = 'SELECT value FROM '.CONFIG_TABLE.' WHERE param="concoursphoto";';
		$result = pwg_query($query);

	    if(isset($result)) {
			$row = pwg_db_fetch_row($result);
			if(is_string($row[0])) {
				$this->my_config = unserialize(($row[0]));
			}
	    }
	if ($this->debug)  
	    foreach ($this->my_config as $key => $value) 
		{
		    echo "my_config[".$key."] = ".$value."\n";
		}    
	    $this->load_default_config();
	}
	
	
	/**
	 * Load default configuration, initialize default values of params
	 */
	private function load_default_config()
	{
	    include CONCOURS_INC_PATH.'default_values.inc.php';
	    foreach ($concours_default_values as $key => $value) 
		{
		    if (!isset($this->my_config[$key]))		$this->my_config[$key] = $value;
		}
	}

	// Save  general configuration to config_database
	function save_config()
	{
		$query = '
		  REPLACE INTO '.CONFIG_TABLE.'
		  VALUES(
			\'concoursphoto\',
			\''.serialize($this->my_config).'\',
			\'Configuration Concours Photo\')
		;';

		$result = pwg_query($query);

		if($result) 
		  return true;
		else
		  return false;
	}
	
	/**
	 * Save the current configuration (ie the value of $config) to the database
	 */
	function set_config() {
		conf_update_param('concoursphoto', pwg_db_real_escape_string(serialize($this->my_config)));
	}
	
	
	// Retrieve user groups 
	function get_user_groups()
	{
		global $user;
		$query = 'SELECT group_id FROM ' . USER_GROUP_TABLE . ' WHERE user_id = ' . $user['id'] . ';';

		$result = pwg_query($query);
		while ($row = pwg_db_fetch_array($result))
		{
		  array_push($this->user_groups, $row['group_id']);
		}

	}

	// create a concours and store it to db.
	// return id for concours.
	function create_concours()
	{}

	// Get informations array for  a concours id
	function get_concours($concours_id = null)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_TABLE .' 
				WHERE id =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) . '
				LIMIT 1
			';

			$result = pwg_query($query);
			if ($result)
				$this->concours_infos = pwg_db_fetch_array($result);
		}

	}


	// save informations on database for a concours_id
	function save_concours($concours_id = null)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
							
			$query = "INSERT INTO " . CONCOURS_TABLE . "
						( `id`,
						`create_date`, 
						`name`, 
						`descr`, 
						`begin_date`, 
						`end_date`, 
						`category`, 
						`groups`,
						`method`,
						`guest`,
						`admin`
                        
						)
					VALUES (".($concours_id !== NULL ? $concours_id : $this->concours_id).", now(), 
							\"".$this->concours_infos['name']."\", \"".$this->concours_infos['descr']."\",
							\"".$this->concours_infos['begin_date']."\", \"".$this->concours_infos['end_date']."\", 
							".$this->concours_infos['category'].", ".$this->concours_infos['groups'].",
							".$this->concours_infos['method'].", ".($this->concours_infos['guest'] ? "TRUE" : "FALSE").",
							".($this->concours_infos['admin'] ? "TRUE" : "FALSE")."
							);";
			if (pwg_query($query) != null)
				return true;
			else
				return false;
		}
		else		
			return false;
	}

	// update informations on database for a concours_id
	function update_concours($concours_id = null)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{

			$query = "UPDATE " . CONCOURS_TABLE . "
						SET 
						create_date = now(), 
						name = \"".$this->concours_infos['name']."\", 
						descr = \"".$this->concours_infos['descr']."\", 
						begin_date = \"".$this->concours_infos['begin_date']."\", 
						end_date = \"".$this->concours_infos['end_date']."\", 
						category = ".$this->concours_infos['category'].", 
						groups = ".$this->concours_infos['groups'].",
						method = ".$this->concours_infos['method'].",
						guest = ".($this->concours_infos['guest'] ? "TRUE" : "FALSE").",
						admin = ".($this->concours_infos['admin'] ? "TRUE" : "FALSE").",
						Podium_onCat = ".($this->concours_infos['Podium_onCat'] ? "TRUE" : "FALSE")."
						WHERE id = ".($concours_id !== NULL ? $concours_id : $this->concours_id)."
						;";
			pwg_query($query);
			if (pwg_query($query) != null)
				return true;
			else
				return false;
		}
		else		
			return false;
	
	}
	
	// update field on database for a concours_id
	function update_concoursfield($field_id, $concours_id = null, $field_value = null)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{

			$query = "UPDATE " . CONCOURS_TABLE . "
						SET 
						" . $field_id." = ". ($field_value != NULL ? $field_value : $this->concours_infos[$field_id] ) . "
						
						WHERE id = ".($concours_id !== NULL ? $concours_id : $this->concours_id)."
						;";
			pwg_query($query);
			if (pwg_query($query) != null)
				return true;
			else
				return false;
		}
		else		
			return false;
	
	}

	// delete concours from db (and all sub informations such as details, vote and result
	function delete_concours($concours_id = null)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
		
			$query = '
				DELETE
				FROM ' . CONCOURS_RESULT_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				';
			pwg_query($query);
			$query = '
				DELETE
				FROM ' . CONCOURS_DATA_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				';
			pwg_query($query);
			$query = '
				DELETE
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				';
			pwg_query($query);
			$query = '
				DELETE
				FROM ' . CONCOURS_TABLE .' 
				WHERE id =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				';
			pwg_query($query);
		}
		else
			return false;
		
	}

	
	// delete all closed concours from db 
	function delete_allclosed_concours()
	{
		$concours_list=array();
		$query = '
			SELECT id
			FROM ' . CONCOURS_TABLE .' 
			WHERE time_to_sec(TIMEDIFF(now(), end_date)) > 0 
			AND  id>0;';

		$result = pwg_query($query);
		while ($row = pwg_db_fetch_assoc($result))
		{
			$this->delete_concours($row['id']);
		}
	}

			
	// today's date is between open and close date of concours?
	function is_active($concours_id = NULL)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT id
				FROM ' . CONCOURS_TABLE .' 
				WHERE id =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) . '
				AND time_to_sec(TIMEDIFF(begin_date,now())) < 0
				AND time_to_sec(TIMEDIFF(now(), end_date)) < 0
				';

			$result = pwg_query($query);
			if ($result != NULL)
				return true;
			else
				return false;
		}
		else
			return NULL;
	}

	// today's date is not between open and close date of concours?
	function is_closed($concours_id = NULL)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT id
				FROM ' . CONCOURS_TABLE .' 
				WHERE id =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) . '
				AND time_to_sec(TIMEDIFF(now(), end_date)) > 0
				';

			$result = pwg_query($query);
			if ($result != NULL)
				return true;
			else
				return false;
		}
		else
			return NULL;
	}

	// Get high value of concours (max score for each criterias)
	function get_MaxScore_concours($concours_id = null)
	{
		$max = 0;
		$query = '
			SELECT criteria_id, max_value, ponderation, uppercriteria
			FROM ' . CONCOURS_DETAIL_TABLE .' 
			WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
			ORDER BY criteria_id
			';
		$result = pwg_query($query);
		while ($row = pwg_db_fetch_array($result))
		{
			if ($row['uppercriteria'] != NULL || !$this->is_criterias_contains_sub($row['criteria_id'])) // subcriteria or uppercriteria without sub
				$max += $row['max_value']*$row['ponderation'];
		}
		return $max;


	}	
	
	// Get criterias that are stored on db for default mode (concours_id = 0)
	function get_default_criterias()
	{
		$criterias = $this->get_criterias_list(0);
		$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id
					FROM ' . CONCOURS_DETAIL_TABLE . ' ;';
		list($next_element_id) = pwg_db_fetch_array(pwg_query($query));

		foreach ($criterias as $criteria)
		{		
			
			$query = 'INSERT INTO '.CONCOURS_DETAIL_TABLE.'
						(id, id_concours, criteria_id, name, descr, min_value, max_value, ponderation, uppercriteria)'
						.'VALUES ('.$next_element_id.', '.$this->concours_id.', '
						.$criteria['criteria_id'].', "'.$criteria['name'].'", "'
						.$criteria['descr'].'", '.$criteria['min_value'].', '
						.$criteria['max_value'].', '.$criteria['ponderation'].', '
						.($criteria['uppercriteria'] ? $criteria['uppercriteria'] : 'NULL').')
						;';
			
				$result = pwg_query($query);

			$next_element_id = $next_element_id +1;
		}
	}

	// Get criterias from a concours
	function get_criterias_list($concours_id = NULL)
	{
		$criteria_list = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				ORDER BY criteria_id
				';
			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
			{
				array_push($criteria_list, $row);
			}
			return $criteria_list;
		}
		else
			return $criteria_list;
	}

	// Get list of the fist level criterias
	function get_firstlevel_criterias($concours_id = NULL)
	{
		$criteria_list = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				AND uppercriteria IS NULL
				ORDER BY criteria_id
				';
			$result = pwg_query($query);
			
			while ($row = pwg_db_fetch_array($result))
				array_push($criteria_list, $row);
			return $criteria_list;
		}
		else
			return $criteria_list;
	}

	// check if a criteria contains subcriterias
	function is_criterias_contains_sub($criteria_id, $concours_id = NULL)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT criteria_id
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				AND uppercriteria = '.$criteria_id.'
				';
			$result = pwg_query($query);
			if(pwg_db_fetch_array($result))
				return true;
			else
				return false;
		}
		return NULL;
	}
	
	
	// Get list of subcriterias from a criteria_id
	function get_subcriterias($criteria_id, $concours_id = NULL)
	{
		$criteria_list = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				AND uppercriteria = '.$criteria_id.'
				ORDER BY criteria_id
				';
			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
			{
				array_push($criteria_list, $row);
			}
			return $criteria_list;
		}
		else
			return $criteria_list;
	}
	
	// Get a detail from a criteria 
	function get_criteria($criteria_id, $concours_id = NULL)
	{
		$criteria = array();

		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours = '. ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				AND criteria_id =' . $criteria_id . '
				';
			$result = pwg_query($query);
			
            $criteria = pwg_db_fetch_array($result);
		}
		return $criteria;
	
	}

	// Get a detail from a criteria 
	function get_criteria_by_id($id)
	{
		$criteria = array();

		$query = '
			SELECT *
			FROM ' . CONCOURS_DETAIL_TABLE .' 
			WHERE id =' . $id . '
			';
		$result = pwg_query($query);
		
		$criteria = pwg_db_fetch_array($result);
		return $criteria;
	
	}

	// Add a criteria to a concours
	// Datas is an array and contains all infos.
	// Return the criteria id
	function add_criteria($datas, $concours_id = NULL)
	{
		// determines the criteria_id 
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id
						FROM ' . CONCOURS_DETAIL_TABLE . ' ;';
			list($next_element_id) = pwg_db_fetch_array(pwg_query($query));

			$query = 'SELECT IF(MAX(criteria_id)+1 IS NULL, 1, MAX(criteria_id)+1) AS next_criteria_id
						FROM ' . CONCOURS_DETAIL_TABLE . '
					  WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id ) . ' ;';
			list($next_criteria_id) = pwg_db_fetch_array(pwg_query($query));
			
			$query = '
			INSERT INTO ' . CONCOURS_DETAIL_TABLE .'
				(`id`,
				`id_concours`,
				`criteria_id`,
				`name`,
				`descr`,
				`min_value`,
				`max_value`,
				`ponderation`,
				`uppercriteria`)
				VALUES (
				'.$next_element_id.', '.($concours_id !== null ? $concours_id : $this->concours_id ).',
				'.$next_criteria_id.', "'.$datas['name'].'", "'.$datas['descr'].'", '.$datas['min_value'].'
				, '.$datas['max_value'].', '.$datas['ponderation'].'
				, '.($datas['uppercriteria'] ? $datas['uppercriteria'] : 'NULL').'
				);';

			pwg_query($query);
			if ($this->debug) echo $query."\n";
	
		}
	}
	
	// Update a criteria to a concours
	// Datas is an array and contains all infos.
	function update_criteria($datas, $concours_id = NULL)
	{
		// determines the criteria_id 
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				UPDATE ' . CONCOURS_DETAIL_TABLE .'
				SET 
				name = "'.$datas['name'].'",
				descr = "'.$datas['descr'].'",
				min_value = '.$datas['min_value'].',
				max_value = '.$datas['max_value'].',
				'.($datas['uppercriteria'] == false ? '' : 'uppercriteria = '.($datas['uppercriteria'] ? $datas['uppercriteria'].',' : 'NULL ,')).'
				ponderation = '.$datas['ponderation'].'
				WHERE id = '.$datas['id'].';';

			pwg_query($query);
		}		
	}
	

	// Delete a criteria from a concours
	function delete_criteria($criteria_id, $concours_id = NULL)
	{
		if ($concours_id!== null or $this->concours_id !== null)
		{
		
			$query = '
				DELETE
				FROM ' . CONCOURS_DETAIL_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
				AND criteria_id = '.$criteria_id.'
				';
			$result = pwg_query($query);
			
			if($result)
				return true;
			else
				return false;
		}
		else
			return null;

	}
	
	// Delete a criteria (with id) from a concours
	function delete_criteria_by_id($id)
	{
	
		$query = '
			DELETE
			FROM ' . CONCOURS_DETAIL_TABLE .' 
			WHERE id =' . $id . '
			';
		$result = pwg_query($query);

	}	

	// check if a result is already present in the database
	function is_result_present($concours_id = null)
	{
		// recover all img_id from the category
		$query = 'SELECT DISTINCT(id_concours)'
		.' FROM ' .CONCOURS_RESULT_TABLE
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id ).';';
		
		$result = pwg_query($query);
		// For each images
		if (pwg_db_fetch_array($result))
			return true;
		else
			return false;
	
	}
	
	
	
// TESTTEST 
	// function to return the number of images for a concours 
	function nb_img_by_concours($concours_id = NULL)
	{

		
		// nb of users who vote for each image (for a selected concours
		$query = 'SELECT count(img.id) AS NBIMG '
				.' FROM ' . IMAGES_TABLE.' AS img'
				.' INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON img.id = ic.image_id'
				.' INNER JOIN '.CATEGORIES_TABLE.' AS cat ON ic.category_id = cat.id'
				.' INNER JOIN '.CONCOURS_TABLE.' AS conc ON conc.category = cat.id'
					.' WHERE conc.id = '.($concours_id !== null ? $concours_id : $this->concours_id )
				.';';
				
		$result = pwg_query($query);
		if ($row = pwg_db_fetch_array($result))
		{
			return $row['NBIMG'];
		}
        			
		return 0;
	}

	
	// function to return the number of votes for a concours by images
	function nb_votes_by_img($concours_id = NULL)
	{
		
		// nb of users who vote for each image (for a selected concours
		$query = 'SELECT img_id, COUNT(DISTINCT user_id) AS NBVOTE FROM ' . CONCOURS_DATA_TABLE 
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id )
        .' AND ipguest IS NULL'
		.' GROUP BY img_id '
		.';';
				
		$result = pwg_query($query);
		$nbvotes = array();
		while ($row = pwg_db_fetch_array($result))
		{
			$nbvotes[$row['img_id']] = $row['NBVOTE'];
		}
        
        // Add guest infos
        $query = 'SELECT img_id, COUNT(DISTINCT ipguest) AS NBVOTE FROM ' . CONCOURS_DATA_TABLE 
        .' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id )
        .' AND ipguest IS NOT NULL'
        .' GROUP BY img_id '
        .';';
                
        $result = pwg_query($query);
        while ($row = pwg_db_fetch_array($result))
	
            if (!isset($nbvotes[$row['img_id']]))
                $nbvotes[$row['img_id']] = $row['NBVOTE'];
            else
                $nbvotes[$row['img_id']] += $row['NBVOTE'];
			
		return $nbvotes;
	}

	
	
	// Get All user that are vote  for guest who have vote (IP Stores in db) in a concours
	function get_user_list($concours_id = NULL)
	{
		global $conf;
        $userid = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT distinct(user_id)
				FROM ' . CONCOURS_DATA_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id ) . '
                AND ipguest IS  NULL
				AND user_id !='.$conf['guest_id']

				.' ORDER BY user_id
				';
			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
			{
				array_push($userid, $row['user_id']);
			}
		}
		return $userid;
	}
	
	
	// Get All iaddr for guest who have vote (IP Stores in db) in a concours
	function get_guest_list($concours_id = NULL)
	{
		global $conf;
        $ipguest = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
				SELECT distinct(ipguest)
				FROM ' . CONCOURS_DATA_TABLE .' 
				WHERE id_concours =' . ($concours_id !== null ? $concours_id : $this->concours_id )
                .' AND user_id = '.$conf['guest_id']
                .' AND ipguest IS NOT NULL
				ORDER BY ipguest
				';
			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
			{
				array_push($ipguest, $row['ipguest']);
			}
            if ($this->debug)
            {
                foreach ($ipguest as $ip)
                    echo "IP=".$ip."\n";
            }

			return $ipguest;
		}
		else
			return $ipguest;
	}
    
	
	// After concours is completed (closed date is passed), generate the result and store it to DB
	function create_result($concours_id = NULL)
	{
        global $conf;
		// var which contains id=img_id and val =global note
		$global_note = array();
		// FOR MODERATION
		// var which contains id=user_id and val =global note
		$vote_by_user = array();
		$amplitiudeMINmax = 999; // MIN of all max score (for each users)
		$amplitiudeMAXmin = -999; // MIN of all max score (for each users)
		$REFaverage = 0; 	// reference average (average between amplitiudeMINmax and amplitiudeMAXmin)
		$global_note_mod1 = array();
		$global_note_mod2 = array();
		
		if ($concours_id!== null or $this->concours_id !== null)
		{
			// only for closed concours and not already result generated
			if ($this->is_closed($concours_id) AND ! $this->is_result_present($concours_id))
			{
			
				// array with the number of vote by image for the concours. Needed for the moyenne
				$nbvotes = $this->nb_votes_by_img($concours_id);
				
		
				$user_id = array();
				// vars not initialized
				if ($this->concours_infos == array())
					$this->get_concours();
				$category = $this->concours_infos['category'];
				
				// Get all user_id from a concours
				$query = 'SELECT DISTINCT user_id'
				.' FROM ' .CONCOURS_DATA_TABLE
				.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id )
                .' AND user_id <> '.$conf['guest_id']
				.';';
				$result = pwg_query($query);

				while ($row = pwg_db_fetch_array($result))
					array_push($user_id, $row['user_id']);

                // Add guest info is present
                $ipguest = array();
                if ($concours_id!== null or $this->concours_id !== null)
				{
					if ($this->debug)
						echo "Check IPGUEST";
                    $ipguest = $this->get_guest_list(($concours_id !== null ? $concours_id : $this->concours_id ));
				}

				
				// recover all img_id from the category
				$query = 'SELECT DISTINCT(image_id)'
				.' FROM ' .IMAGE_CATEGORY_TABLE
				.' WHERE category_id = '.$category.';';
				
				$nb_image_concours = 0;
				$result = pwg_query($query);
				// For each images
				while ($row = pwg_db_fetch_array($result))
				{
					$nb_image_concours++;
		
					foreach ($user_id as $i => $userid)
					{
						$img_note_user = $this->get_img_globalnote_user($row['image_id'], null, $userid);
						
						if (!isset($global_note[$row['image_id']]))
							$global_note[$row['image_id']] = 0;
					// FOR MODERATION
					// store the nb of vote for each user
						if ($img_note_user >= 0) // user has made a vote
						{
							if (!isset($vote_by_user[$userid]['nbvote']))
								$vote_by_user[$userid]['nbvote'] = 0;
							
							$vote_by_user[$userid]['nbvote'] ++;	// update vote counter
						
							$global_note[$row['image_id']] +=  $img_note_user	;		
						

						// FOR MODERATION
							// store the total of note for the same user
							if (!isset($vote_by_user[$userid]['totalvote']))
								$vote_by_user[$userid]['totalvote'] = 0;
							$vote_by_user[$userid]['totalvote'] +=  $img_note_user;
							// FOR MODERATION
							// store min/max for each user
							if (!isset($vote_by_user[$userid]['min'])) 	$vote_by_user[$userid]['min'] = 999;
							if (!isset($vote_by_user[$userid]['max'])) 	$vote_by_user[$userid]['max'] = 0;
							
							
							if ($vote_by_user[$userid]['min'] > $img_note_user) $vote_by_user[$userid]['min'] = $img_note_user;
							if ($vote_by_user[$userid]['max'] < $img_note_user) $vote_by_user[$userid]['max'] = $img_note_user;
						}						
					
					}
                    // Add guest scores if present
					foreach ($ipguest as $i => $userid)
					{
						
						$img_note_user = $this->get_img_globalnote_user($row['image_id'], null, null, $userid);	// $userid contains the ip address for the guest!
						if (!isset($global_note[$row['image_id']]))
							$global_note[$row['image_id']] = 0;

					// FOR MODERATION
					// store the nb of vote for each guest (with ipaddr)
						if ($img_note_user >= 0) // user has made a vote
						{
							if (!isset($vote_by_user[$userid]['nbvote']))
								$vote_by_user[$userid]['nbvote'] = 0;
							
							$vote_by_user[$userid]['nbvote'] ++;	// update vote counter
						
							$global_note[$row['image_id']] +=  $img_note_user	;		
						

						// FOR MODERATION
							// store the total of note for the same user
							if (!isset($vote_by_user[$userid]['totalvote']))
								$vote_by_user[$userid]['totalvote'] = 0;
							$vote_by_user[$userid]['totalvote'] +=  $img_note_user;
							// FOR MODERATION
							// store min/max for each user
							if (!isset($vote_by_user[$userid]['min'])) 	$vote_by_user[$userid]['min'] = 999;
							if (!isset($vote_by_user[$userid]['max'])) 	$vote_by_user[$userid]['max'] = 0;
							
							
							if ($vote_by_user[$userid]['min'] > $img_note_user) $vote_by_user[$userid]['min'] = $img_note_user;
							if ($vote_by_user[$userid]['max'] < $img_note_user) $vote_by_user[$userid]['max'] = $img_note_user;
						}						

					}
				}

				// FOR MODERATION
				// calcul the average by user and min/max global
				foreach ($user_id as $i => $userid)
				{
					$vote_by_user[$userid]['average'] = $vote_by_user[$userid]['totalvote']/$vote_by_user[$userid]['nbvote'];
					$vote_by_user[$userid]['lowerAmp'] = $vote_by_user[$userid]['min'];
					// calcul the max value of the concours (for the moderation)
					$vote_by_user[$userid]['upperAmp'] = $this->get_MaxScore_concours() - $vote_by_user[$userid]['max'];
					
					$vote_by_user[$userid]['minLevel'] = $vote_by_user[$userid]['average'] - $vote_by_user[$userid]['lowerAmp'];
					$vote_by_user[$userid]['maxLevel'] = $vote_by_user[$userid]['average'] + $vote_by_user[$userid]['upperAmp'];
					if ($amplitiudeMINmax > $vote_by_user[$userid]['maxLevel']) $amplitiudeMINmax = $vote_by_user[$userid]['maxLevel'];
					if ($amplitiudeMAXmin < $vote_by_user[$userid]['minLevel']) $amplitiudeMAXmin = $vote_by_user[$userid]['minLevel'];				
				}

				// calcul the average by guest and min/max global
				foreach ($ipguest as $i => $userid)
				{
					$vote_by_user[$userid]['average'] = $vote_by_user[$userid]['totalvote']/$vote_by_user[$userid]['nbvote'];
					$vote_by_user[$userid]['lowerAmp'] = $vote_by_user[$userid]['min'];
					// calcul the max value of the concours (for the moderation)
					$vote_by_user[$userid]['upperAmp'] = $this->get_MaxScore_concours() - $vote_by_user[$userid]['max'];
					
					$vote_by_user[$userid]['minLevel'] = $vote_by_user[$userid]['average'] - $vote_by_user[$userid]['lowerAmp'];
					$vote_by_user[$userid]['maxLevel'] = $vote_by_user[$userid]['average'] + $vote_by_user[$userid]['upperAmp'];
					if ($amplitiudeMINmax > $vote_by_user[$userid]['maxLevel']) $amplitiudeMINmax = $vote_by_user[$userid]['maxLevel'];
					if ($amplitiudeMAXmin < $vote_by_user[$userid]['minLevel']) $amplitiudeMAXmin = $vote_by_user[$userid]['minLevel'];				

				}


				// FOR MODERATION
				// calcul the reference average 
				$calcultemp = (int)($amplitiudeMINmax+$amplitiudeMAXmin)/2+0.5;
				if ((int)(($amplitiudeMINmax+$amplitiudeMAXmin)/2+0.5) > $amplitiudeMAXmin)
				{
					if ((int)(($amplitiudeMINmax+$amplitiudeMAXmin)/2+0.5) < $amplitiudeMINmax)
						$REFaverage = (int)(($amplitiudeMINmax+$amplitiudeMAXmin)/2+0.5);
					else
						$REFaverage = $amplitiudeMINmax;
				}
				else
					$REFaverage = $amplitiudeMAXmin;
				
					
				// FOR MODERATION
				// calcul the moderation scopr for each users
				foreach ($user_id as $i => $userid)
					$vote_by_user[$userid]['moderation'] = $REFaverage - $vote_by_user[$userid]['average'];

				// FOR MODERATION
				// calcul the moderation scopr for each guest ($ipguest)
				foreach ($ipguest as $i => $userid)
					$vote_by_user[$userid]['moderation'] = $REFaverage - $vote_by_user[$userid]['average'];
					
				// FOR MODERATION
				// need to parse again image for new calcul with moderation
				// moderation 1 => For each photo without note (user = author or user != author but no vote) add each user avaerage to the total of note and calcul the average 
				// moderation 2 => For each photo with note, adapt/change all the value with the moderation value : user note + moderation. 

				// parse again all img_id from the category
				$query = 'SELECT DISTINCT(image_id)'
				.' FROM ' .IMAGE_CATEGORY_TABLE
				.' WHERE category_id = '.$category.';';
				
				$result = pwg_query($query);
				// For each images
				while ($row = pwg_db_fetch_array($result))
				{
					// for each user
					foreach ($user_id as $i => $userid)
					{
						if (!isset($global_note_mod1[$row['image_id']]))
							$global_note_mod1[$row['image_id']] = 0;
						$globalnote_user = $this->get_img_globalnote_user($row['image_id'], null, $userid, null, 1, $vote_by_user[$userid]['average']);

						$global_note_mod1[$row['image_id']] += ($globalnote_user >= 0 ? $globalnote_user : 0) 	;

						if (!isset($global_note_mod2[$row['image_id']]))
							$global_note_mod2[$row['image_id']] = 0;
						$globalnote_user = $this->get_img_globalnote_user($row['image_id'], null, $userid, null, 2, $vote_by_user[$userid]['moderation']);

						$global_note_mod2[$row['image_id']] +=  ($globalnote_user >= 0 ? $globalnote_user : 0) 	;		
					}
					
					// for each guest
					foreach ($ipguest as $i => $userid)
					{
						if (!isset($global_note_mod1[$row['image_id']]))
							$global_note_mod1[$row['image_id']] = 0;
						$globalnote_user = $this->get_img_globalnote_user($row['image_id'], null, null, $userid, 1, $vote_by_user[$userid]['average']);	// userid contains the ip addr for the guest

						$global_note_mod1[$row['image_id']] += ($globalnote_user >= 0 ? $globalnote_user : 0) 	;

						if (!isset($global_note_mod2[$row['image_id']]))
							$global_note_mod2[$row['image_id']] = 0;
						$globalnote_user = $this->get_img_globalnote_user($row['image_id'], null, null, $userid, 2, $vote_by_user[$userid]['moderation']);

						$global_note_mod2[$row['image_id']] +=  ($globalnote_user >= 0 ? $globalnote_user : 0) 	;		
					}

					
				}
					
				
				// update database and store result into RESULT table
				// note = global note
				$IMGmoyenne = 0;
				$IMGmoyenneModeration1 = 0;
				$IMGmoyenneModeration2 = 0;
				
				foreach ($global_note as $id => $val)
				// id contains the image id
				{
					$IMGmoyenne = (isset($nbvotes[$id]) && $nbvotes[$id] != 0 ? $val/$nbvotes[$id] : 0);
					// Moderation

					$IMGmoyenneModeration1 = ($nb_image_concours != 0 ? $global_note_mod1[$id]/$this->nb_user_by_concours() : 0);	// all photos have note 
					$IMGmoyenneModeration2 = (isset($nbvotes[$id]) && $nbvotes[$id] != 0 ? $global_note_mod2[$id]/$nbvotes[$id] : 0);	// only voted photos are used
					
					$query = 'INSERT INTO  ' . CONCOURS_RESULT_TABLE .'(`id_concours`, `img_id`, `date` , `note`, `moyenne`, 
					`moderation1`, `moderation2`,
					`nbvotant` )
							VALUES ('.($concours_id !== null ? $concours_id : $this->concours_id )
									 .', '.$id 
									 .', now() '
									 .', '.$val
									 .', '.$IMGmoyenne
									 .', '.$IMGmoyenneModeration1
									 .', '.$IMGmoyenneModeration2
									 .', '.(isset($nbvotes[$id]) ? $nbvotes[$id] : 0)
									 .');';
				$result = pwg_query($query);	 
					
				}
			}
			else
				return false;
		}
		else
			return false;
	}
	
	
	// Get array with nb of vote for each user of a concours_id
	function nb_user_by_concours($concours_id = NULL)
	{
		$nbusertotal = 0;
		// user 
		$query = 'SELECT count(distinct(user_id)) as nb_user FROM ' . CONCOURS_DATA_TABLE .'
				WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id).'
				AND ipguest IS NULL
			  ;';
		$result = pwg_query($query);
		if ($result)
		{
			$row = pwg_db_fetch_array($result);
			$nbusertotal += $row['nb_user'];
		}
		// guest
		$query = 'SELECT count(distinct(ipguest)) as nb_user FROM ' . CONCOURS_DATA_TABLE .'
				WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id).'
				AND ipguest IS NOT NULL
			  ;';
		$result = pwg_query($query);
		if ($result)
		{
			$row = pwg_db_fetch_array($result);
			$nbusertotal +=  $row['nb_user'];
		}
		return $nbusertotal;
		
	}
	
	
	// Check if an image's author OR addebBy is the same as the actual user
	// depending the config param 
	function check_img_user($img_id)
	{
		global $user;


		$query = '
			SELECT id,author, added_by
			FROM ' . IMAGES_TABLE .' 
			WHERE id =' . $img_id . '
			';

		$result = pwg_query($query);
if ($this->debug) echo $query."\n<br>";
		if ($result)
		{
			$row = pwg_db_fetch_array($result);
			$authorid = get_userid($row['author']);
			$addedbyid = $row['added_by'];


/*
echo "img ID=".$row['id']."<br>";	 
echo ">>>auteur=".$row['author']."<br>"; 	
echo ">>>authorid=".$authorid."<br>"; 
echo ">>>addedbyid=".$addedbyid."<br>";	 
echo ">>>Type_compare=".$this->my_config['author_vote_available'].'<br>';
*/


			switch ($this->my_config['author_vote_available'])
			{
			
				case 0 : // no check (allow to vote for all photos)
					return false;
					
				case 1 : // check between author and user
					if ($authorid)	// Author name present as username
					{
						if ($authorid == $user['id'])
							return true;
						else
							return false;
					}
					else
					{
						// check if author name = user name 
						$AuthorArray = strip_punctuation2($row['author']);
						$UserArray = strip_punctuation2($user['username']);
						// Patch if author is empty
						if (empty($AuthorArray))
							return false;
				
						if (count(array_intersect($AuthorArray, $UserArray)) == count ($AuthorArray)) // found 				
							return true;
						else
							return false;
					}
	
					
				case 2 : // check between author and user
					if (isset($addedbyid) AND $addedbyid == $user['id'])
						return true;
					else
						return false;
				case 3 : // check between author OR addedby and user
					// Check Author 
					if ($authorid AND $authorid == $user['id'])	// Author name present as username
					{
//						echo " > > > Auteur OK1 <br>";
							return true;
					}
					else
					{
						// check if author name = user name 
						$AuthorArray = strip_punctuation2($row['author']);
						$UserArray = strip_punctuation2($user['username']);								
						if (!empty($AuthorArray) AND (count(array_intersect($AuthorArray, $UserArray)) == count ($AuthorArray))) // found 				
						{
//							echo " > > > Auteur OK2 <br>";
							return true;
						}
					}			
					// check addebBy
					if (isset($addedbyid) AND $addedbyid == $user['id'])
					{
//						echo " > > >ADDED OK <br>";
						return true;
					}
//					echo " > > > FASLSE <br>";
					return false;

				default :
//					echo " > > > FASLSE <br>";
					return false;
				
			}

		}
		return false;
	}
	

	// Add tpl to picture.php page to display concours informations and vote
	function display_concours_to_picture()
	{
		// Step0 : if user = guest, check the concours param and store ip address to user name.
		// Step1 : concours is defined to this category AND concours is open AND user is authorized to access to this category (thru group)
		// Step1 bis : dont show concours if check author or added_by id is the samie as used_id (depending the param)
		// Step 2 : Recover stored informations in db for this user
		// Step 3 : Complete tpl information
		// Step 4 : concat tpl
		
		global $page, $user, $template, $conf;

		// Get user group.
		$this->get_user_groups();

		$concours = array();

        // STEP 0 
		$user['ipguest'] = null;

		// Check if the user is a guest only
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
        
        
		// disable author name  on image which are present in a concours.
		// check the categories where the current image is present and disable the author name 
		if (isset($this->my_config['mask_author']) && $this->my_config['mask_author'] == true)
		{
			// Get all categories where the current image is present
			$query = '
			SELECT category_id,uppercats,commentable,global_rank
			  FROM '.IMAGE_CATEGORY_TABLE.'
				INNER JOIN '.CATEGORIES_TABLE.' ON category_id = id
			  WHERE image_id = '.$page['image_id'].'
			  ;';
			$result = pwg_query($query);
			$related_categories = array();
			while ($row = pwg_db_fetch_array($result))
			{
			  array_push($related_categories, $row['category_id']);
			}
			//
            //echo related_categories;
            if (count($related_categories))
            {
                // Request for all concours prepared & actived on each categories
                $query = '
                    SELECT *
                    FROM ' . CONCOURS_TABLE .' 
                    WHERE category IN ('.implode(',', $related_categories).')
                    AND time_to_sec(TIMEDIFF(now(), end_date)) < 0
                ';
                $result = pwg_query($query);
                // If one or more concours are found, the author name is masked 
                if ($result && pwg_db_fetch_array($result))
                    $template->assign('INFO_AUTHOR',l10n('concours_img_author'));
            }
		}

	// End disable author name


		if (($page['section']) == 'categories' AND !empty($page['category']))
		{
			// Step 1
            
			$query = '
				SELECT *
				FROM ' . CONCOURS_TABLE .' 
				WHERE category =' . $page['category']['id'] . '
				AND time_to_sec(TIMEDIFF(begin_date,now())) < 0
				AND time_to_sec(TIMEDIFF(now(), end_date)) < 0
				';

			$result = pwg_query($query);

			while ($row = pwg_db_fetch_array($result))
			{
				if (!is_a_guest() AND !empty($row['groups']))
				{

					if (is_admin() AND $row['admin'])	// allow admin 
						$concours = $row;
					else
					{		
						$authorized_groups = explode(',', $row['groups']);
						if (array_intersect($this->user_groups, $authorized_groups) == array())
							continue;
						// If no group is parameter for that concours  ==> available for all registered users
						$concours = $row;
					}
				}
                else 
					
   					$concours = $row;
			}
			//------------
			// Step 1 bis
			// Actual user is  the author of the picture ==>end
			// for the image, check (depending the config) if user = author or addedby or none
			if ($this->check_img_user($page['current_item']))
			{
				return;
			}
				
			// Check if user is guest and if guest is allowed
			if (is_a_guest() AND array_key_exists('guest', $concours) AND !$concours['guest'])
				return;
			// Check if user is admin and if admin is allowed
			if (is_admin() AND (!isset($concours['admin']) OR (isset($concours['admin']) AND !$concours['admin'])))
				return;
			
			//------------
			// Step 2
			if ($concours != array())
			{
				// If user validate the notation
				if (isset($_POST['concours_submit']))
				{
         
//                    array_push($page['infos'] , l10n('concours_vote_saved'));
                    
					$user_note = "";
					
					// concat all the notes to save on db
					$firstcriterias = $this->get_firstlevel_criterias($concours['id']);
					foreach ($firstcriterias as $criteria)
					{
						// First without sub criterias
						if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours['id'] ))
						{
							// Check value 
							$value = str_replace(",",".",(isset($_POST[$criteria['criteria_id']]) ? $_POST[$criteria['criteria_id']] : floatval($criteria['min_value'])));
							$value = str_replace(" ","",$value);
							$value = floatval($value);
							if ($value < floatval($criteria['min_value']))
								$value = floatval($criteria['min_value']);
							if ($value > floatval($criteria['max_value']))
								$value = floatval($criteria['max_value']);

							$user_note .= (strlen($user_note) != 0 ? ";" : "").$criteria['criteria_id']."=".$value;
						}
						else
						{
							$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours['id'] );
							foreach ($secondcriterias as $subcriteria)
							{
								// Check value 
								$value = str_replace(",",".",(isset($_POST[$subcriteria['criteria_id']]) ? $_POST[$subcriteria['criteria_id']] : floatval($subcriteria['min_value'] )));
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
				
					$this->store_img_note_user($page['current_item'], $user_note, $concours['id'], $user['ipguest']);
					$this->store_img_comment_user($page['current_item'], $_POST['concours_comment'], $concours['id'], $user['ipguest']);
				}

				// If user want to erase notes
				if (isset($_POST['concours_raz']))
				{
					$this->delete_img_note_user($page['current_item'], $concours['id'], $user['ipguest']);
					$user_notes = array();
				}
				else
				{
					// Recover previous note in DB (if exists)
					$user_notes = $this->get_img_note_user($page['current_item'], $concours['id'], $user['id'], $user['ipguest']);
				}
				
				// Comment is not RAZ, always restore				
				$comment = $this->get_img_comment_user($page['current_item'], $concours['id'], $user['id'], $user['ipguest']);

				//------------
				// Step 3
				// Recover all 1st level criterias
				$firstcriterias = $this->get_firstlevel_criterias($concours['id']);
				foreach ($firstcriterias as $criteria)
				{
					// First without sub criterias
					if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours['id'] ))
					{
						$template->append( 'concours_criteria', array(
								'nosub'	=> true,
								'level'	=> 1,
								'id' 	=> $criteria['criteria_id'],				// id du critere
								'name' 	=> $criteria['name'],				// id du critere
								'lib'	=> $criteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
								'val'	=> (isset($user_notes[$criteria['criteria_id']])?$user_notes[$criteria['criteria_id']] : $criteria['min_value']),		//  valeur du critere
								'min' 	=> $criteria['min_value'],				// min
								'max' 	=> $criteria['max_value']				// max
							));
					}
					else
					{
						$template->append( 'concours_criteria', array(
								'nosub'	=> false,
								'level'	=> 1,
								'id' 	=> $criteria['criteria_id'],				// id du critere
								'name' 	=> $criteria['name'],				// id du critere
								'lib'	=> $criteria['descr']
							));
						$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours['id'] );
						foreach ($secondcriterias as $subcriteria)
						{
							$template->append( 'concours_criteria', array(
									'nosub'	=> true,
									'level'	=> 2,
									'id' 	=> $subcriteria['criteria_id'],				// id du critere
									'name' 	=> $subcriteria['name'],				// id du critere
									'lib'	=> $subcriteria['descr'], //.'(min='$criteria['min_value'].';max='.$criteria['min_value'].')',			// libelle du critrer
									'val'	=> (isset($user_notes[$subcriteria['criteria_id']])?$user_notes[$subcriteria['criteria_id']] : $subcriteria['min_value']),
									'min' 	=> $subcriteria['min_value'],				// min
									'max' 	=> $subcriteria['max_value']				// max
								));
							
						}
					}

				}
				// Add the comment
				$template->assign( 'CONCOURS_COMMENT', $comment);

				// if a user has already vote for this photo, check if the score change is allowed


                if ($user_notes == array() OR $this->my_config['concours_change_score'])  // Allow user to change his vote after a validation
                    $template->assign( 'CONCOURS_CHANGE_SCORE', true);
                else
                    $template->assign( 'CONCOURS_CHANGE_SCORE', false);
                
				$noteuser = $this->get_img_globalnote_user($page['current_item'], $concours['id'], null, $user['ipguest']);
				// Add concours informations on template
				$template->assign( 'concours_infos', array(
							'name'	=> $concours['name'],
							'descr'	=> $concours['descr'],
                            'note'  => ($noteuser >= 0 ? $noteuser : 0 ),
							'begin_date' => $concours['begin_date'],
							'end_date' => $concours['end_date'],
							'end_concours_min' => (strtotime($concours['end_date'])-time())	,
							'max_note' => $this->get_concours_maxnote($concours['id']),
							'deadline_type' => $this->my_config['concours_deadline']
								));
				

				$template->assign( 'SCORE_MODE', $this->my_config['score_mode']);
				$template->assign( 'TEXT_OVERLAY', $this->my_config['text_overlay']);
			
				$template->set_filenames(array('concours' =>  CONCOURS_ROOT.'/template/concours.tpl'));
				$template->concat('COMMENT_IMG', $template->parse('concours', true));

				$template->assign('INFO_AUTHOR',l10n('concours_img_author'));
			}
		}
	}

	
	// RAZ notation from user to db
	// fill criterias notes to 0 in DB
	// return false if error
	function delete_img_note_user($img_id, $concours_id = NULL, $ipguest = null, $userid=null)
	{
		global $user;
		
		if ($concours_id === null)
			if ($this->concours_id !== null)
				$concours_id = $this->concours_id;
			else
				return false;
				
		$query = '
		DELETE FROM ' . CONCOURS_DATA_TABLE .'
		WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id ).'
		AND user_id = '.($userid == null ? $user['id'] : $userid).' 
		AND img_id = '.$img_id.
		($ipguest ? ' AND ipguest = "'.$ipguest.'"' : '')            
		.';';

		return pwg_query($query);

	}
	
	
	// RAZ notation from user to db
	// fill criterias notes to 0 in DB
	// return false if error
	function RAZ_img_note_user($img_id, $concours_id = NULL, $ipguest = null)
	{
		$user_note = "";
		if ($concours_id === null)
			if ($this->concours_id !== null)
				$concours_id = $this->concours_id;
			else
				return false;
				
		$firstcriterias = $this->get_firstlevel_criterias($concours_id);
		foreach ($firstcriterias as $criteria)
		{
			// First without sub criterias
			if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
				$user_note .= (strlen($user_note) != 0 ? ";" : "").$criteria['criteria_id']."=".$criteria['min_value'];
			else
			{
				$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours_id );
				foreach ($secondcriterias as $subcriteria)
					$user_note .= (strlen($user_note) != 0 ? ";" : "").$subcriteria['criteria_id']."=".$subcriteria['min_value'];
			}
		}
		if (strlen($user_note) != 0)
		{
			$this->store_img_note_user($img_id, $user_note, $concours_id, $ipguest);
			return true;
		}
		else
			return false;
	}

	// Store notation from user to db
	// save with format "criteria_id=note;criteria_id=note..." for data	
	function store_img_note_user($img_id, $datas, $concours_id = NULL, $ipguest = null)
	{
		global $user;
		if ($this->get_img_note_user( $img_id, $concours_id, $user['id'], $ipguest) == array() )
		{
			$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id  FROM ' . CONCOURS_DATA_TABLE . ' ;';
			list($next_element_id) = pwg_db_fetch_array(pwg_query($query));

			$query = '
			INSERT INTO ' . CONCOURS_DATA_TABLE .'
				(`id`,
				`id_concours` ,
				`user_id` ,
				`create_date` ,
				`img_id` ,
				`datas`'.
                ($ipguest ? ',`ipguest` ' : '')

                .')
			VALUES ( '.$next_element_id.','
			.($concours_id !== null ? $concours_id : $this->concours_id ) .'
			, '. $user['id'] .', now(), '.$img_id.', "'.$datas.'"'
            .($ipguest ? ',"'.$user['ipguest'].'"' : '')
            .');';
		}
		else
		{
			$query = '
			UPDATE ' . CONCOURS_DATA_TABLE .'
			SET datas = "'.$datas.'", create_date = now()
			WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id ).'
			AND user_id = '.$user['id'].' 
			AND img_id = '.$img_id.
            ($ipguest ? ' AND ipguest = "'.$ipguest.'"' : '')            
            .';';
		}
		pwg_query($query);
	
	}
	
	// get notation's user from db
	// Return an array with :
	// Criteria_id ==> value
	// Note : criterias with subcriterias are not saved and not restored. They are calculated for global result
	function get_img_note_user($img_id, $concours_id = NULL, $user_id = null, $ipguest = null)
	{
		global $user, $conf;
		$img_note = array();
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
			SELECT datas
			FROM ' . CONCOURS_DATA_TABLE .' 
			WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) 
			. ($ipguest == null ? ' AND user_id = '. ($user_id !== null ? $user_id : $user['id'])
			   : ' AND user_id = '.$conf['guest_id'] .' AND ipguest = "'.$ipguest.'"')
			.' AND img_id = '. $img_id 
			.';';
            ($ipguest ? ' AND ipguest = "'.$ipguest.'"' : '')
			.';';
			$result = pwg_query($query);
			
			while ($row = pwg_db_fetch_array($result))

			{
				$datas = explode(";",$row['datas']);
				foreach ($datas as $val)
				{
					if (strpos($val, '=') !== FALSE)
						$img_note[substr($val, 0, strpos($val, '='))]=substr($val, strpos($val, '=')+1);
				}
			}
			
			return $img_note;
		}
		else
			return array();
	}



	// Return the max note for a concours 
	function get_concours_maxnote($concours_id = NULL)
	{

		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
			SELECT SUM(max_value) AS TOTAL
			FROM ' . CONCOURS_DETAIL_TABLE .' 
			WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id)
			.' AND uppercriteria IS NULL' 
			.';';
			
			$result = pwg_query($query);
			if ($this->debug)					echo "query=".$query."<br>\n";
			
			if ($row = pwg_db_fetch_array($result))
			{
				return $row['TOTAL'];
			}
			else 
			return -1;
			
		}

	
	}


	
	// get notation's user from db
	// Return the global note for a picture id from a user
	// if moderationMode = 1, the 'moderation' contains the GlobalAverage for all the concours
	// if moderationMode = 2, the 'moderation' contains the user moderation for all image that are voted by
	// return -1 if there is no vote for that user
	function get_img_globalnote_user($img_id, $concours_id = NULL, $user_id = null, $ipguest = null, $moderationMode = 0, $moderation = 0)
	{
		global $user, $conf;
		$img_note = array();
		$global_user_note = -1;
		$note_found = false;
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
			SELECT datas
			FROM ' . CONCOURS_DATA_TABLE .' 
			WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) 
			. ($ipguest == null ? ' AND user_id = '. ($user_id !== null ? $user_id : $user['id'])
			   : ' AND user_id = '.$conf['guest_id'] .' AND ipguest = "'.$ipguest.'"')
			.' AND img_id = '. $img_id 
			.';';
			$result = pwg_query($query);
			if ($this->debug)					echo "query=".$query."<br>\n";
			
			while ($row = pwg_db_fetch_array($result))
			{
				$global_user_note = 0; // init note if one vote is present
				$note_found = true;
				$datas = explode(";",$row['datas']);
				foreach ($datas as $val)
				{
					if (strpos($val, '=') !== FALSE)
						$img_note[substr($val, 0, strpos($val, '='))]=substr($val, strpos($val, '=')+1);
				}
			}
			
			$firstcriterias = $this->get_firstlevel_criterias($concours_id);
			foreach ($firstcriterias as $criteria)
			{
				// First without sub criterias
				if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
				{
					if (isset($img_note[$criteria['criteria_id']]))
						$global_user_note += (int)$criteria['ponderation'] * (float)$img_note[$criteria['criteria_id']];
				}
				else
				{
					$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours_id );
					foreach ($secondcriterias as $subcriteria)
					{
						if (isset($img_note[$subcriteria['criteria_id']]))
						$global_user_note += (int)$subcriteria['ponderation'] * (float)$img_note[$subcriteria['criteria_id']];
					}
				}
			}
			
			// MODERATION 
				// moderation 1 => For each photo without note (user = author or user != author but no vote) add each user avaerage to the total of note and calcul the average 
				// moderation 2 => For each photo with note, adapt/change all the value with the moderation value : user note + moderation. 
			
			if ($user_id !== null) // only for user 
			{
				if ($moderationMode == 1 && !$note_found)
				{		// Moderation1
					$global_user_note = $moderation;
				}
				elseif ($moderationMode == 2 && $note_found)
				{	// Moderation2
					$global_user_note += $moderation;
				}		
				
				
			}
			return $global_user_note;
		}
		else
			return array();
		
		
	}

	// Store comment from user to db
	function store_img_comment_user($img_id, $datas, $concours_id = NULL, $ipguest = null)
	{
		global $user;
		if (($comment = $this->get_img_note_user( $img_id, $concours_id, null, $ipguest)) == false)
		{
			$query = 'SELECT IF(MAX(id)+1 IS NULL, 1, MAX(id)+1) AS next_element_id  FROM ' . CONCOURS_DATA_TABLE . ' ;';
			list($next_element_id) = pwg_db_fetch_array(pwg_query($query));

			$query = '
			INSERT INTO ' . CONCOURS_DATA_TABLE .'
				(`id`,
				`id_concours` ,
				`user_id` ,
				`create_date` ,
				`img_id` ,
				`comment`'
                .($ipguest ? ' `ipguest`' : '').
                ')
			VALUES ( '.$next_element_id.','
			.($concours_id !== null ? $concours_id : $this->concours_id ) .'
			, '. $user['id'] .', now(), '.$img_id.', "'.$datas.'");';
		}
		else
		{
			$query = '
			UPDATE ' . CONCOURS_DATA_TABLE .'
			SET comment = "'.$datas.'", create_date = now()
			WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id ).'
			AND user_id = '.$user['id'].' 
			AND img_id = '.$img_id.
            ($ipguest ? ' AND ipguest = "'.$ipguest.'"' : '')
            .';';
		}
			pwg_query($query);
	}
	
	
	// Get comment on an image for a user
	function get_img_comment_user($img_id, $concours_id = NULL, $user_id = null, $ipguest = null)
	{
		global $user;
		$datas = false;
		if ($concours_id!== null or $this->concours_id !== null)
		{
			$query = '
			SELECT comment
			FROM ' . CONCOURS_DATA_TABLE .' 
			WHERE id_concours =' . ($concours_id !== NULL ? $concours_id : $this->concours_id) . '
			AND user_id = '. ($user_id !== null ? $user_id : $user['id']).'
			AND img_id = '. $img_id .
            ($ipguest ? ' AND ipguest = "'.$ipguest.'"' : '')
			.';';

			$result = pwg_query($query);
			
			while ($row = pwg_db_fetch_array($result))
				$datas = $row['comment'];
		}
		return $datas;
	}
	
	
	// Generate csv file for a closed concours with result generated
	function generate_csv($concours_id = NULL)
	{
        global $conf;
		$file = "rang, id_concours,method, img_id, img_name, img_file, date, note, moyenne, nbvotant, datas\r\n";

		if (!(isset($this->concours_infos['method'])))
			$this->concours_infos['method'] = 1;
			
		// recover all img_id from the category
		$query = 'SELECT id_concours,method, img_id, IMG.name, IMG.file, date, note, moyenne, nbvotant, datas'
		.' FROM ' .CONCOURS_RESULT_TABLE
		.' INNER JOIN ' . CONCOURS_TABLE.' AS CONC on CONC.id = id_concours'
		.' INNER JOIN ' . IMAGES_TABLE.' AS IMG on IMG.id = img_id'
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id );
		
		if ($this->concours_infos['method'] == 1)	// total
			$query .= ' ORDER BY note DESC';
		elseif ($this->concours_infos['method'] == 2)	// moyenne
			$query .= ' ORDER BY moyenne DESC';
		
		$query .=';';
		
		$result = pwg_query($query);
		// For each images
		$rang = 1;
		while ($row = pwg_db_fetch_array($result))
		{
			$file .= ($row['nbvotant'] != 0 ? $rang : 'N/A').', '
					.$row['id_concours'].', '
					.$row['method'].', '
					.$row['img_id'].', '
					.$row['name'].', '
					.$row['file'].', '
					.$row['date'].', '
					.$row['note'].', '
					.$row['moyenne'].', '
					.$row['nbvotant'].', '
					.($row['datas'] != null ? $row['datas'] : '')
					."\r\n";
			$rang ++;
		}
				
		return $file;
	
		
	}

	// Generate csv file for a closed concours with result generated and all users informations 
	function generate_detail_csv($concours_id = NULL)
	{
        global $conf;
		$MethodType = "0";
		if ($concours_id === null)
			$concours_id = $this->concours_id;
		// Prepare the list of criteria
		$criteria_list = "";
		$firstcriterias = $this->get_firstlevel_criterias($concours_id);
		$ident1 = 1;
		foreach ($firstcriterias as $criteria)
		{
			// format (id:name)
			$criteria_list .= (strlen($criteria_list) ? "," : "")
								.$ident1.":".$criteria['name']
								."(id=".$criteria['criteria_id'].")";
			// First wit sub criterias
			if ($this->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
			{
				$ident2 = 1;
				$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours_id );
				foreach ($secondcriterias as $subcriteria)
				{
					// format (id:name)
					$criteria_list .= (strlen($criteria_list) ? "," : "")
									  .$ident1.".".$ident2
									  .":".$subcriteria['name']."(id=".$subcriteria['criteria_id'].")";
					$ident2 ++;
				}
			}
			$ident1++;
		}
		$user_list = array();
		$users_criteria = "";
        
        
		// Get all the users who have notes for the concours
		$query = 'SELECT distinct(user_id), USER.username'
		.' FROM ' .CONCOURS_DATA_TABLE
		.' INNER JOIN ' . USERS_TABLE.' AS USER on USER.id = user_id'
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id )
        // Dont take the guest informations because 
        .' AND user_id <> '.$conf['guest_id']
        .' ORDER BY username ASC'
		.';';
		$result = pwg_query($query);
		// For each user
		while ($row = pwg_db_fetch_array($result))
		{
			array_push($user_list, $row);
			$users_criteria .= (strlen($users_criteria) ? "," : "")."user, user_global_note, comment, ".$criteria_list;
		}
        
        $ipguest = array();
        // Get guest info (if available)
        if ($this->concours_infos['guest'])
        {
            $ipguest = $this->get_guest_list();
            // For each guest
            foreach ( $ipguest as $i => $userid ) //on parcours le tableau 
            {
                $users_criteria .= (strlen($users_criteria) ? "," : "")."user, user_global_note, comment, ".$criteria_list;                
            }        
        }

		
		// All informations in csv format
		$file = "rang, id_concours, method, nom_concours, date_debut, date_fin, date_export, img_id, img_name, img_file, img_author, note, moyenne, moderation1, moderation2, nbvotant, datas,"
		.$users_criteria 
		."\r\n";

		// nb of users who vote for each image

	// NOT NEEDED, INFO STORE IN DATABASE 'RESULT'
		$nbvotes = $this->nb_votes_by_img($concours_id);

		// recover all img_id from the category
		if (!(isset($this->concours_infos['method'])))
			$this->concours_infos['method'] = 1;
		$query = 'SELECT id_concours, method, img_id, IMG.name, IMG.file, IMG.author, date, note, moyenne, moderation1, moderation2, nbvotant, datas, comment'
		.' FROM ' .CONCOURS_RESULT_TABLE
		.' INNER JOIN ' . CONCOURS_TABLE.' AS CONC on CONC.id = id_concours'
		.' INNER JOIN ' . IMAGES_TABLE.' AS IMG on IMG.id = img_id'
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id );
		
		switch ($this->concours_infos['method'])
		{
		case 1 :	// total
			$query .= ' ORDER BY note DESC';
			$MethodType = "1-Sum";
			break;
		case  2 :	// moyenne
			$query .= ' ORDER BY moyenne DESC';
			$MethodType = "2-Average";
			break;
		case  3 :	// moderation1
			$query .= ' ORDER BY moderation1 DESC';
			$MethodType = "3-Average(Mod1)";
			break;
		case  4 :	// moderation2
			$query .= ' ORDER BY moderation2 DESC';
			$MethodType = "4-Average(Mod2)";
			break;
		}
				
		$query .=';';
		
		$result = pwg_query($query);
		// For each images
		$rang = 1;
        $previousNote = $previousMoy = 0;

		while ($row = pwg_db_fetch_array($result))
		{
            // Check and verify for exaequo
            if ($this->my_config['check_exaequo'])
            {
                if ( ($this->concours_infos['method'] == 1	// total
                       AND ($row['note'] == $previousNote))
                     OR  ($this->concours_infos['method'] == 2	// moyenne
                          AND ($row['moyenne'] == $previousMoy)))
                {
                    $rang --;          
                }
            }
            
			$file .= ($row['nbvotant'] != 0 ? $rang : 'N/A').', '
					.$row['id_concours'].', '
					.$MethodType.', '
					.str_replace(",", "",$this->concours_infos['name']).', '
					.$this->concours_infos['begin_date'].', '
					.$this->concours_infos['end_date'].', '
					.$row['date'].', '

					.$row['img_id'].', '
					.str_replace(",", "",$row['name']).', '
					.$row['file'].', '
					.$row['author'].', '
					.$row['note'].', '
					.$row['moyenne'].', '
					.$row['moderation1'].', '
					.$row['moderation2'].', '
					.$row['nbvotant'].', '
					.($row['datas'] != null ? $row['datas'] : '')
					;
			foreach ($user_list as $uuser)
			{

				$comment = $this->get_img_comment_user($row['img_id'], $concours_id, $uuser['user_id']);
			
				$user_note = $this->get_img_note_user($row['img_id'], $concours_id, $uuser['user_id']);
				
				$user_global_note = $this->get_img_globalnote_user($row['img_id'], $concours_id, $uuser['user_id']);
				$file .= ', '.$uuser['username'].', '.($user_global_note >= 0 ? $user_global_note  : 0)
						.', '.($comment != false ? str_replace(array(",","\r\n", "\n", "\r"), " ",$comment) : '')
						.', '
						;

				$user_note_by_crit = "";
				foreach ($firstcriterias as $criteria)
				{
					// First without sub criterias
					if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
					{
						$user_note_by_crit .= (strlen($user_note_by_crit) ? "," : "").(isset($user_note[$criteria['criteria_id']]) ? $user_note[$criteria['criteria_id']] : ' ');
					}
					else
					{
						$user_note_by_subcrit = "";
						$subcrit_note = 0;
						$user_has_vote = false;
						$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours_id );
						foreach ($secondcriterias as $subcriteria)
						{
							if (isset($user_note[$subcriteria['criteria_id']]))		$user_has_vote = true;
							$user_note_by_subcrit .= (strlen($user_note_by_subcrit) ? "," : "").(isset($user_note[$subcriteria['criteria_id']]) ? $user_note[$subcriteria['criteria_id']] : ' ');
							$subcrit_note += (int)$subcriteria['ponderation'] * (float)(isset($user_note[$subcriteria['criteria_id']]) ? $user_note[$subcriteria['criteria_id']] : 0);

						}
						$user_note_by_crit .= (strlen($user_note_by_crit) ? "," : "").($user_has_vote ? $subcrit_note : ' ').",".$user_note_by_subcrit;
					}
				}
				$file .= $user_note_by_crit;

			}

            // Add guest infos (if present)
			foreach ($ipguest as $ipguestt)
			{
				$comment = $this->get_img_comment_user($row['img_id'], $concours_id, $conf['guest_id'], $ipguestt);
			
				$user_note = $this->get_img_note_user($row['img_id'], $concours_id, $conf['guest_id'], $ipguestt);
				$user_global_note = $this->get_img_globalnote_user($row['img_id'], $concours_id, $conf['guest_id'], $ipguestt);
				
				$file .= ', Guest('.$ipguestt.'), '.($user_global_note >= 0 ? $user_global_note : 0)
						.', '.($comment != false ? str_replace(array(",","\r\n", "\n", "\r"), " ",$comment) : '')
						.', '
						;

				$user_note_by_crit = "";
				foreach ($firstcriterias as $criteria)
				{
					// First without sub criterias
					if (!$this->is_criterias_contains_sub($criteria['criteria_id'],$concours_id ))
					{
						$user_note_by_crit .= (strlen($user_note_by_crit) ? "," : "").(isset($user_note[$criteria['criteria_id']]) ? $user_note[$criteria['criteria_id']] : ' ');
					}
					else
					{
						$user_note_by_subcrit = "";
						$subcrit_note = 0;
						$user_has_vote = false;
						$secondcriterias = $this->get_subcriterias($criteria['criteria_id'], $concours_id );
						foreach ($secondcriterias as $subcriteria)
						{
							if (isset($user_note[$subcriteria['criteria_id']]))		$user_has_vote = true;
							$user_note_by_subcrit .= (strlen($user_note_by_subcrit) ? "," : "").(isset($user_note[$subcriteria['criteria_id']]) ? $user_note[$subcriteria['criteria_id']] : ' ');
							$subcrit_note += (int)$subcriteria['ponderation'] * (float)(isset($user_note[$subcriteria['criteria_id']]) ? $user_note[$subcriteria['criteria_id']] : 0);

						}
						$user_note_by_crit .= (strlen($user_note_by_crit) ? "," : "").($user_has_vote ? $subcrit_note : ' ').",".$user_note_by_subcrit;
					}
				}
				$file .= $user_note_by_crit;

			}
            
			$file .="\r\n";
			$rang ++;
            $previousNote = $row['note'];
            $previousMoy = $row['moyenne'];

		}
		return utf8_decode($file);
	
		
	}
	
	
	// Save csv datas to physical file
	function save_file($file,$concours_id = NULL)
	{
		// check if already saved file
		if ($filename = $this->get_file_name($concours_id))
			return $filename;
		else
		{
			$dirpath = CONCOURS_RESULT_FOLDER;

			$filename = date('Ymd')."_concours".($concours_id !== null ? $concours_id : $this->concours_id ).".csv";
			if (!is_dir($dirpath)) 
				@mkdir($dirpath);
			if (file_exists($dirpath. $filename))
				unlink($dirpath. $filename);

			$fh = fopen($dirpath. $filename, 'w') or die("can't open file");
			fwrite($fh, $file);
			fclose($fh);

			//update result database with filename
			$query = "UPDATE " . CONCOURS_RESULT_TABLE . "
						SET 
						file_name = \"".$filename."\"
						WHERE id_concours= ".($concours_id !== NULL ? $concours_id : $this->concours_id)."
						;";
			pwg_query($query);
			
			return $filename;
		}
	}		

	// Get result file name from db
	function get_file_name($concours_id = NULL)
	{
		$query = 'SELECT distinct(file_name)'
		.' FROM ' .CONCOURS_RESULT_TABLE
		.' WHERE id_concours = '.($concours_id !== null ? $concours_id : $this->concours_id )
		.';';
		$result = pwg_query($query);
		if ($result)
		{
			$row = pwg_db_fetch_array($result);		
			if ($row)
				return $row['file_name'];
			else
				return false;
		}
	}

	// Get csv datas from a saved file
	function get_file($concours_id = NULL)
	{
		$filename = CONCOURS_RESULT_FOLDER.
		$size = filesize($filename);
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.$size);
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');

		$file = @fopen($filename, ‘rb’);
		if ($file) {
			// stream the file and exit the script when complete
			fpassthru($file);
		}
	}
	
	// DEPRECATED Piwigo 11 Activation page administration
/*
	function concours_admin_menu($menu)
	{
	    array_push($menu,
	       array(
	            'NAME' => CONCOURS_NAME,
	            'URL' => get_root_url().'admin.php?page=plugin-'.CONCOURS_DIR.'-manage'
	        ) 
	    );
	    return $menu;
	}
*/
	
	// register Concours Menubar
	public function register_blocks( $menu_ref_arr )
	{
		$menu = & $menu_ref_arr[0];
		if ($menu->get_id() != 'menubar' OR $this->my_config['active_menubar'] == false)
		  return;
		$menu->register_block( new RegisteredBlock( 'CONCOURS_menu', 'concours', 'ConcoursPhoto'));
	}

    // initialise menubar's menu.     called by menubar object when making menu
	public function blockmanager_apply( $menu_ref_arr )
	{

		global $user, $template;
		$menu = & $menu_ref_arr[0];

		if ($this->user_groups == array())
			$this->get_user_groups();
		
		if ( ($block = $menu->get_block( 'CONCOURS_menu' ) ) != null )
		{
			$menu_list=array();

			if(is_admin())
			{

			array_push($menu_list,
			  array(
				'NAME' => l10n('concours_admin_add'),
				'TITLE' => l10n('concours_admin_add'),
				'URL' => PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . '-add_concours&amp;action=new',
				'REL' => ""
			  )
			);
 			
			}

			// recover all img_id from the category
			$query = 'SELECT distinct(id_concours), groups, guest, admin, CONC.name'
			.' FROM ' .CONCOURS_RESULT_TABLE
			.' INNER JOIN '.CONCOURS_TABLE. ' AS CONC ON CONC.id = id_concours'
			.' ORDER BY id DESC'
			.';';
			
			$result = pwg_query($query);
			$nb_concours = 1;
			
			// For each concours
			while ($row = pwg_db_fetch_assoc($result))

			{
				
				if ($nb_concours > $this->my_config['nbconcours_menubar'])
					break;
					
                $conc_to_show = false;  // Default ==> dont show
                
                // Guest OR admin
				if ((is_a_guest() AND $row['guest'])
					OR (is_admin() AND $row['admin']))
                    $conc_to_show = true;
                // Group present
				
				
                elseif (!empty($row['groups']))
				{
					$authorized_groups = explode(',', $row['groups']);
					if (array_intersect($this->user_groups, $authorized_groups) != array()) 
                        $conc_to_show = true;
                }
                // Allowed for any user (logged)
                elseif (empty($row['groups']))
                    $conc_to_show = true;
                
                if ($conc_to_show)
					{
					$nb_concours ++;

					array_push($menu_list,
					  array(
						'NAME' => $row['name'],
						'TITLE' => $row['name'],
						'URL' => './index.php?/concours/'.$row['id_concours'],
						'EDIT' => (is_admin()? PHPWG_ROOT_PATH . 'admin.php?page=plugin-' . CONCOURS_DIR . 'add_concours&amp;concours=' . $row['id_concours'].'&amp;action=modify':"")
					  )
					);
				}
			}

		  if (count($menu_list))
		  {
			  $block->template = CONCOURS_ROOT.'/template/concours_menu.tpl';
			  $block->data = $menu_list;
		  }
		}
	}

	function section_init_concours()
	{
		global $tokens, $page;
		if ($tokens[0] == 'concours')
		  $page['section'] = 'concours';
		elseif ($tokens[0] == 'concours_vote')
		  $page['section'] = 'concours_vote';
	}
	
	function index_concours()
	{
		global $page;
		if (isset($page['section']) and $page['section'] == 'concours')
		{
			include(CONCOURS_PATH . 'publish.php');
		}
	}

	function index_vote_concours()
	{
		global $page;
		if (isset($page['section']) and $page['section'] == 'concours_vote')
		{
			include(CONCOURS_PATH . 'concours_vote.php');
		}
	}
	
	
  // Show the global note under the thumbnail
  function thumbnail_note($tpl_var, $pictures) 
  {
	global $page, $user, $template;
	$this->get_user_groups();

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

	if (($page['section']) == 'categories' AND !empty($page['category']))
	{
		
		$concours = array();

		$query = '
			SELECT *
			FROM ' . CONCOURS_TABLE .' 
			WHERE category =' . $page['category']['id'] 
// comment to load prepared contests and opened contests				. ' AND time_to_sec(TIMEDIFF(begin_date,now())) < 0'
			. ' AND time_to_sec(TIMEDIFF(now(), end_date)) < 0';

		$result = pwg_query($query);
		// DEBUG
		if ($this->debug) echo $query."\n";
		// END DEBUG
		while ($row = pwg_db_fetch_array($result))
		{				
			if ((strtotime($row['begin_date'])-time() > 0) AND $this->my_config['mask_thumbnail'])
			{
			// disable picture if contest is prepared for all users
			  $i=0;
			  while ($i<count($tpl_var))
			  {
				  array_splice($tpl_var, $i, 1);
				  array_splice($pictures, $i, 1);
			  }	
			$concours = $row;
				
			}
			elseif (is_admin() AND $row['admin'])
				$concours = $row;
			elseif (!is_a_guest() AND !empty($row['groups']))
			{
				$authorized_groups = explode(',', $row['groups']);
				if (array_intersect($this->user_groups, $authorized_groups) == array()) 
					continue;
				$concours = $row;
			}
			
			// If no group is parameter for that concours  ==> available for all registered users
			else
				$concours = $row;		
		}
		

		if (count($concours))
		{		
			// Add timeline for all users.
			if (strtotime($concours['begin_date'])-time() > 0)
			{
				$template->assign('begin_concours_min', (strtotime($concours['begin_date'])-time()));
				$template->assign('deadline_type',$this->my_config['concours_deadline']);
				$template->assign('begin_concours', $concours['begin_date']);
			}
			else
			{
				// Check if user is guest and if guest is allowed
				if ((is_a_guest() AND $concours['guest']) 
					OR (is_admin() AND $concours['admin'])
					OR !is_a_guest())
				{
			 
					// check if contest is concours not already open (date begin > now)

				
					
						foreach($tpl_var as $cle=>$valeur) 
						{
							// show only if the author is not the active user

							$AuthorArray = strip_punctuation2($tpl_var[$cle]['author']);
							$AddedByID = ($tpl_var[$cle]['added_by']);
							$UserArray = strip_punctuation2($user['username']);

							if ($this->my_config['author_vote_available']  == 0 // Allow to vote for all photos (and also show his score)
							    OR ($this->my_config['author_vote_available'] == 1 // check between author and user
							        AND (empty($AuthorArray) OR count(array_intersect($AuthorArray, $UserArray)) != count ($AuthorArray))  // Author is the same as user name 
							        ) 	
							    OR ($this->my_config['author_vote_available'] == 2 // check between author and user
							        AND (!isset($AddedByID) OR ($user['id'] != $AddedByID))  // Addedby is the same as user name 
							        ) 
							    OR ($this->my_config['author_vote_available'] == 3 // check between author OR addedby and user
							        AND (!isset($AddedByID) OR ($user['id'] != $AddedByID))  // Addedby is the same as user name 
							        AND (empty($AuthorArray) OR count(array_intersect($AuthorArray, $UserArray)) != count ($AuthorArray))  // Author is the same as user name 
							        ) 
							   )

							{
								if ($this->my_config['thumb_note'])	 // display thumbnail note only if option is activated
								{
									$user_global_note = $this->get_img_globalnote_user($tpl_var[$cle]['id'], $concours['id'], $user['id'], $user['ipguest']);
									$tpl_var[$cle]['NAME'] = $tpl_var[$cle]['NAME'].'('.l10n('thumbnail_global_note').': '.($user_global_note >= 0 ? $user_global_note : 0).')';
								}
							}
						}
						
						// Add deadline on description page 	
						$template->assign('end_concours', $concours['end_date']);
						$template->assign('end_concours_min', (strtotime($concours['end_date'])-time()));
						$template->assign('deadline_type',$this->my_config['concours_deadline']);
						if (isset($this->my_config['active_global_score_page']) AND $this->my_config['active_global_score_page'])	// only if option is activated
							$template->assign('global_vote_link', PHPWG_ROOT_PATH . 'index.php?/concours_vote/'.$concours['id']);
				}
				
			}
			$template->assign('IMG_URL', CONCOURS_IMG_PATH);
			
			$template->set_filenames(array('concours_description' =>  CONCOURS_ROOT.'/template/concours_description.tpl'));
			$template->concat('CONTENT_DESCRIPTION', $template->parse('concours_description', true));

		}
	}
	
    return $tpl_var;
  }

	function concours_stuffs_module($modules)
	{
		array_push($modules, array(
		'path' => CONCOURS_PATH.'stuffs_module/',
		'name' => l10n('concours_stuffs_name'),
		'description' => l10n('concours_stuffs_description'),
		)
		);
		return $modules;
	}	
	
	
	
	function add_contest_desc()
	{	


		include_once CONCOURS_PATH.'/stuffs_module/functions.inc.php';
		global $page, $user, $template;


		if (($page['section']) == 'categories' AND !empty($page['category']))
		{

			if ($concoursID = $this->concoursID_on_cat())
			{

				if ($this->is_result_present($concoursID))
				{

					$concours = new Concours($concoursID);
					if ($concours->concours_infos['Podium_onCat'])
					{
						$block = array();
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
										'NB_VOTANT' => count($concours->get_user_list($concours->concours_infos['id']))+count($concours->get_guest_list($concours->concours_infos['id']))
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
//							'AUTHOR' => $result['author'],
							'AUTHOR' => (strlen($result['author']) === 0 ? get_username($result['added_by']): $result['author']),
							'TN_SRC' => DerivativeImage::thumb_url($result),
							'XSMALL_SRC' => DerivativeImage::url(IMG_XSMALL, $result),	
							'XXSMALL_SRC' => DerivativeImage::url(IMG_XXSMALL, $result),	
							'URL'	=> $url

						);
						$rank++;
						}

						$block['contests'][$concours->concours_infos['id']]['nb_results'] = $NB_RESULTS;

						$template->assign('block', $block);
						$template->assign('IMG_URL', CONCOURS_IMG_PATH);


						$template->set_filenames(array('concours_description' =>  CONCOURS_ROOT.'/template/concours_description-podium.tpl'));
						$template->concat('PLUGIN_INDEX_CONTENT_BEFORE', $template->parse('concours_description', true));
					}
				}
			}

		}	

		
	}


	// retun concours id for the category (if present)
	function concoursID_on_cat($category = NULL)
	{
		global $page;
		$concours_present = false;
		if (!isset($category))	// param not present
		{
			if (($page['section']) == 'categories' AND !empty($page['category']))
					$category = $page['category']['id'] ;
		}

		if (isset($category))
		{
			$query = '
				SELECT id
				FROM ' . CONCOURS_TABLE .' 
				WHERE category =' . $category ;

			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
				return $row['id'];
		}
		return false;
	}



	// Check if a concours is present (prepared or actived) for the category and user group
	function concours_present_cat($category = NULL, $no_date = NULL)
	{
		global $page;
		$concours_present = false;
		if (!isset($category))	// param not present
		{
			if (($page['section']) == 'categories' AND !empty($page['category']))
					$category = $page['category']['id'] ;
		}

		if (isset($category))
		{
			$query = '
				SELECT *
				FROM ' . CONCOURS_TABLE .' 
				WHERE category =' . $category . '
                AND time_to_sec(TIMEDIFF(now(), end_date)) < 0
				';

			$result = pwg_query($query);
			while ($row = pwg_db_fetch_array($result))
				return true;
		}
		return false;
	}


	// Disable Metatdata to picture for a prepared or active concours
	function disable_meta_to_picture()
	{
		if (isset($this->my_config['mask_meta']) && $this->my_config['mask_meta'] == true)
		{
			if ($this->concours_present_cat())
				pwg_set_session_var('show_metadata', 0 );
		}
	}

	
}

function strip_punctuation($string) {
    $string = strtolower($string);	// lower case
    $string = preg_replace("/\p{P}+/", "", $string); // remove punctuation
    $string = preg_replace("/\p{Nd}+/", "", $string); // remove numeric
    $string = preg_replace("/[\p{Z}\t\r\n\v\f]+/", "", $string); // remove spaces
    $string = str_replace(" +", "", $string);	// remove space
//echo "stripPunct=".$string."!\n";
    return $string;
}

// return array
function strip_punctuation2($string) {
    $string = strtolower($string);	// lower case
    $string = preg_replace("/\p{P}+/", " ", $string); // remove punctuation by space
    $string = preg_replace("/\p{Nd}+/", "", $string); // remove numeric
    $string = preg_replace("/[\p{Z}\t\r\n\v\f]+/", " ", $string); // remove spaces by spaces (only 1)
//    $string = str_replace(" +", "", $string);	// remove space
	$stringArray = $returnValue = preg_split('/\\W/', $string, -1, PREG_SPLIT_NO_EMPTY);

    return $stringArray;
}



?>
