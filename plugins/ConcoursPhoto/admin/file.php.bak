<?php

$filename = $_GET['file'];

$dirpath = "../result/";
		
$size = filesize($dirpath. $filename);

header('Content-Type: application/octet-stream');
header('Content-Length: '.$size);
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');

readfile($dirpath. $filename);

?>
