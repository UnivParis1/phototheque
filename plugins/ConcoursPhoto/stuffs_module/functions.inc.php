<?php
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');


// NB of days between 2 dates "AAAA-MM-JJ HH:hh:ss"
function NbJours($debut, $fin) {

  $tDeb = explode("-", substr($debut,0,strpos($debut, ' ')));
  $tFin = explode("-", substr($fin,0,strpos($fin, ' ')));

  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - 
          mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
  
  return(($diff / 86400));

}

?>