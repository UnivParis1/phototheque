<?php
/*
 * Plugin Name: ConcoursPhoto
 * File :  maintain.inc.php  
 */

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

function plugin_install() 
{
	global $prefixeTable, $conf;
	$query = 'SHOW TABLES LIKE "' . $prefixeTable . 'concours"';
	$result = pwg_query($query);
	if (!pwg_db_fetch_row($result))
	{

	// Concours description
		$q = 'CREATE TABLE IF NOT EXISTS  `' . $prefixeTable . 'concours` (
				`id` smallint(5) NOT NULL,
				`create_date` datetime NOT NULL,
				`name` text NOT NULL,
				`descr` varchar(255) default NULL,
				`begin_date` datetime NOT NULL,
				`end_date` datetime NOT NULL,
				`category` smallint(5) default NULL,
				`groups` varchar(255) default NULL,
				`method` smallint(5) default 1 NOT NULL,
				`guest` Boolean default FALSE,
				`admin` Boolean default FALSE,
				`Podium_onCat` Boolean default FALSE,
				
				PRIMARY KEY  (`id`)
				) DEFAULT CHARSET=utf8;';
		pwg_query($q);

	// Concours description detail (criterias)
		$q = 'CREATE TABLE IF NOT EXISTS  `' . $prefixeTable . 'concours_detail` (
				`id` smallint(5) NOT NULL,
				`id_concours` smallint(5) NOT NULL,
				`criteria_id` smallint(5) NOT NULL,
				`name` text NOT NULL,
				`descr` varchar(255) default NULL,
				`min_value` int default 0,
				`max_value` int default 0,
				`ponderation` int default 1,
				`uppercriteria` smallint(5) default NULL,
				
				PRIMARY KEY  (`id`),
				FOREIGN KEY (`id_concours`) REFERENCES ' . $prefixeTable . 'concours(id)
				) DEFAULT CHARSET=utf8;';
		pwg_query($q);


	// Concours notation (by users)
		$q = 'CREATE TABLE IF NOT EXISTS  `' . $prefixeTable . 'concours_data` (
				`id` smallint(5) NOT NULL,
				`id_concours` smallint(5) NOT NULL,
				`user_id` smallint(5) NOT NULL,
				`create_date` datetime NOT NULL,
				`img_id` smallint(5) NOT NULL,
				`datas` longtext default NULL,
				`comment` longtext default NULL,				
				`ipguest` longtext default NULL,
				PRIMARY KEY  (`id`)
				) DEFAULT CHARSET=utf8;';
		pwg_query($q);
		
	// Concours result (synthesis)
		$q = 'CREATE TABLE IF NOT EXISTS  `' . $prefixeTable . 'concours_result` (
				`id_concours` smallint(5) NOT NULL,
				`img_id` smallint(5) NOT NULL,
				`date` datetime NOT NULL,
				`note` float default 0,
				`datas` longtext default NULL,
				`file_name` longtext default NULL,
				`moyenne` float default 0,
				`moderation1` float default 0,
				`moderation2` float default 0,
				`nbvotant` smallint(5) default 0,
				
				PRIMARY KEY  (`img_id`, `id_concours`),
				FOREIGN KEY (`id_concours`) REFERENCES ' . $prefixeTable . 'concours(id)				
				) DEFAULT CHARSET=utf8;';
		pwg_query($q);
		
	// Default values  insertion
		$result = pwg_query('select 1 FROM `'.$prefixeTable . 'concours`'.' WHERE id = 0;');
		if (!pwg_db_num_rows($result))
		{
			$q = "INSERT INTO `" . $prefixeTable . "concours` 
						( `id`,
						`create_date`, 
						`name`, 
						`descr`, 
						`begin_date`, 
						`end_date`, 
						`category`, 
						`groups`)
					VALUES (0, now(), 'Default', 'default values', now(), now(), NULL, NULL);";
			pwg_query($q);
		}
		// Default values for criterias (concours_id=0)
		$result = pwg_query('select 1 FROM `'.$prefixeTable . 'concours_detail`'.' WHERE id_concours = 0;');
		if (!pwg_db_num_rows($result))
		{
			$q = "INSERT INTO `" . $prefixeTable . "concours_detail` 
						(`id`,
						`id_concours` , 
						`criteria_id` , 
						`name`, 
						`descr`, 
						`min_value`, 
						`max_value`, 
						`ponderation` ,
						`uppercriteria`)
					VALUES (1, 0, 1, 'Artistique', 'Artistique', 0, 10, 1, NULL),
					 (2, 0, 2, 'Respect du sujet', 'Sujet en rapport avec le theme', 0, 1, 1, 1),
					 (3, 0, 3, 'Sujet bien identifié', 'Sans ambiguite', 0, 2, 1, 1),
					 (4, 0, 4, 'Traitement du sujet', 'Expression/Attitude/mouvement', 0, 2, 1, 1),
					 (5, 0, 5, 'Mise en valeur du sujet', 'Cadrage/Harmonie de la composition/Esthetique de l\'image/Choix de l\'eclairage', 0, 5, 1, 1),

					 (6, 0, 6, 'Technique', 'Technique', 0, 6, 1, NULL),
					 (7, 0, 7, 'Nettete de l\'image', 'Etagement des plans/Pique de l\'image', 0, 3, 1, 6),
					 (8, 0, 8, 'Rendu des couleurs (ou gris)', 'Teintes/Staurations', 0, 1, 1, 6),
					 (9, 0, 9, 'Exposition', 'Equilibre hautes/basses lumieres', 0, 2, 1, 6),

					 (10, 0, 10, 'Coup de coeur', 'coup de coeur', 0, 4, 1, NULL),
					 (11, 0, 11, 'Emotion spontanee', 'emotion spontanee', 0, 2, 1, 10),
					 (12, 0, 12, 'Adhesion au choix artistique', 'Adhesion au choix artistique', 0, 2, 1, 10);";
				 
			pwg_query($q);
		}
	}
	
	// new column on concours on piwigo 2.0.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "guest";');
//		echo "SHOW COLUMNS FROM ."$prefixeTable."concours LIKE 'guest';";
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_100();
	// new column on concours on piwigo 2.9.1
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "admin";');
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_290();

	// new column on concours on piwigo 11.0.2
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "Podium_onCat";');
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_1102();

	// new column on concours_result on piwigo 2.0.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours_result` LIKE "moyenne";');
	if (!pwg_db_num_rows($result))
	  upgrade_concoursresult_from_100();
	// new column on concours_result on piwigo 2.9.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours_result` LIKE "moderation1";');
	if (!pwg_db_num_rows($result))
	  upgrade_concoursresult_from_200();
  


	$result = pwg_query('select 1 FROM `'.$prefixeTable . 'config`'.' WHERE param = "concoursphoto";');
//		echo "SHOW COLUMNS FROM ."$prefixeTable."concours LIKE 'guest';";
	if (!pwg_db_num_rows($result))
	{
		$q = '
		INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
		VALUES ("concoursphoto","","Configuration Concours Photo")
		;';
		pwg_query($q);
	}
}


function plugin_activate() 
{
  global $prefixeTable;


	$query = 'SHOW TABLES LIKE "' . $prefixeTable . 'concours"';
	$result = pwg_query($query);
	if (!pwg_db_fetch_row($result))
	{
	  $this->plugin_install();
	}

	// new column on concours on piwigo 2.0.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "guest";');
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_100();
	// new column on concours on piwigo 2.9.1
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "admin";');
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_290();
	// new column on concours on piwigo 11.0.2
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours` LIKE "Podium_onCat";');
	if (!pwg_db_num_rows($result))
	  upgrade_concours_from_1102();

	// new column on concours_result on piwigo 2.0.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours_result` LIKE "moyenne";');
	if (!pwg_db_num_rows($result))
	  upgrade_concoursresult_from_100();
	// new column on concours_result on piwigo 2.9.0
	$result = pwg_query('SHOW COLUMNS FROM `'.$prefixeTable.'concours_result` LIKE "moderation1";');
	if (!pwg_db_num_rows($result))
	  upgrade_concoursresult_from_200();
  
}

  function plugin_update()
  {
	$this->plugin_install();
  }
  

function plugin_uninstall() 
{
	global $prefixeTable;

	$q = 'DROP TABLE ' . $prefixeTable . 'concours_result, 
	' . $prefixeTable . 'concours_detail, 
	' . $prefixeTable . 'concours_data,
	' . $prefixeTable . 'concours	;';
	pwg_query($q);

	$q = '
	  DELETE FROM '.CONFIG_TABLE.'
	  WHERE param="concoursphoto" LIMIT 1
	;';
	pwg_query($q);

}




	

// Add new parameter in database in version 1.0.1:
// - moy : moyenne of global note with all participant
// - nbvotant : nb of vote for an image
// - method = type of rank calculation (1-> total; 2-> moyenne)
function upgrade_concoursresult_from_100()
{
	global $prefixeTable;
	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours_result
	ADD `moyenne` float default 0 AFTER `note`,
	ADD `nbvotant` smallint(5) default 0 AFTER `moyenne`
	;';

	pwg_query($query);
	
	// TODO : Recalcul the moyenne and the nb of participation if the table still exist for the selected concours

	$query = 'ALTER TABLE ' . $prefixeTable . 'concours
	ADD	`method` smallint(5) default 1 NOT NULL
	;';

	pwg_query($query);
  
}

// Add new parameter in database in version 2.9.0:
// - moderation1 : global result with method moderation 1
// - moderation2 : global result with method moderation 1
function upgrade_concoursresult_from_200()
{
	global $prefixeTable;
	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours_result
	ADD `moderation1` float default 0 AFTER `moyenne`,
	ADD `moderation2` float default 0 AFTER `moderation1`
	;';

	pwg_query($query); 
}



// Add new parameter in database in version 2.0.0:
// - guest : boolean to allow guest to use this function (concours)
function upgrade_concours_from_100()
{
	global $prefixeTable;
	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours
	ADD `guest` boolean default FALSE AFTER `method`
	;';

	pwg_query($query);
 	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours_data
	ADD `ipguest` longtext default NULL AFTER `comment`
	;';

	pwg_query($query);
 
}
// Add new parameter in database in version 2.9.1:
// - admin : boolean to allow admin  to access to contest( even if he's not in a contest)
function upgrade_concours_from_290()
{
	global $prefixeTable;
	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours
	ADD `admin` boolean default FALSE AFTER `guest`
	;';

	pwg_query($query);
}


// Add new parameter in database in version 11.0.3:
// - Podium_onCat : Add Podium on category page (after result)
function upgrade_concours_from_1102()
{
	global $prefixeTable;
	// Add new parameters
	$query = 'ALTER TABLE ' . $prefixeTable . 'concours
	ADD `Podium_onCat` boolean default FALSE AFTER `admin`
	;';

	pwg_query($query); 
}


?>