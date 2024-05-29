<?php

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

$service = &$arr[0];
$service->addMethod('pwg.ConcoursPhoto.Podium_onCat', 'ConcoursPhoto_ws_Podium_onCat',
	array(
		'ConcoursID'=>array('default'=>0,'type'=>WS_TYPE_INT|WS_TYPE_POSITIVE),
		'message'=>array('default'=>false, 'type'=>WS_TYPE_BOOL),
	),
	'Activate Podium results on Category'
);

/**
 * Function called by Javascript
 * @param Array Parameters passed through Javascript
 * @param
 * @return String the preview of the email
 */
function ConcoursPhoto_ws_Podium_onCat($params, $service) 
{
	
	update_concoursfield('Podium_onCat', $params['id'], $params['value']);
	
}



// update field on database for a concours_id
function update_concoursfield($field_id, $concours_id = null , $field_value = null )
{
	if ($concours_id!== null and $field_value !== null)
	{

		$query = "UPDATE " . CONCOURS_TABLE . "
					SET "
					 . $field_id." = ". $field_value 
					 .
					" WHERE id = ".($concours_id !== NULL ? $concours_id : $this->concours_id)."
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
?>