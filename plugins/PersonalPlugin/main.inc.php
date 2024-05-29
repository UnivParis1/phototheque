<?php
/*
Plugin Name: Plugin Personnel
Version: 1.0
Description: Plugin Personnel
Plugin URI: http://piwigo.org
Author:
Author URI:
*/



add_event_handler('init', 'no_metadata_for_guests');
function no_metadata_for_guests() {
  global $user;
  if (is_a_guest()) {
    pwg_set_session_var('show_metadata', false);
  }
}

//remove mail footer
add_event_handler('loc_end_page_tail', 'removecontact');
function removecontact() {
  global $template;
   
  $template->clear_assign('CONTACT_MAIL');
}

//lancer un slider auto si $_GET['showmustgoon']
add_event_handler('loc_begin_index','showmustgoon');
function showmustgoon() {
global $template;

 $script_content = <<<EOT

    $( window ).on( "load", function() {
         startPhotoSwipe(0);
  $('.pswp__button--autoplay')[0].click();
    });

EOT;
  if(isset($_GET['showmustgoon']))
  {
 $template->block_footer_script(array('require' => 'jquery'), $script_content);
  }
}


?>