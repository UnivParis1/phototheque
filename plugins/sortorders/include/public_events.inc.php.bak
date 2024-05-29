<?php
defined('SORTORDERS_PATH') or die('Hacking attempt!');

function get_choosen_sort_orders($orders)
{
  global $conf, $page;

  array_push($orders, array(l10n('Random'), 'RAND()', true)); 
  
  $to_remove = array();
  foreach($conf['sortorders']['disabled'] as $disabled)
    foreach($orders as $order)
      if(str_replace(' ', '_', $order[1]) == $disabled)
        array_push($to_remove, $order[1]);

  return array_filter($orders, function($v) use($to_remove) {return !in_array($v[1], $to_remove);}); 
}
