<?php
/*
 * Plugin Name: ConcoursPhoto
 * File :  default_values.inc.php  
 */

$concours_default_values['active_menubar'] = true; // Activate menubar view
$concours_default_values['nbconcours_menubar'] = 3;	// Nb of last published concours show on concours menubar
$concours_default_values['mask_author'] =   true; // Mask author for prepared concours or active concours
$concours_default_values['mask_meta'] =     false; // Mask meta for prepared concours or active concours
$concours_default_values['thumb_note'] = true; // Display global note (for user) under thumbnail
$concours_default_values['check_exaequo'] = false; // Check exaequo and display the same rank
//$concours_default_values['author_vote_available'] = false; // Dont allow author to vote for his own photo
$concours_default_values['author_vote_available'] = 0; // 0: Disable check between curent user and Author/AddedBy info for a photo ==> All user cound vote  
													   // 1: Check between "Author" (of photo) and "User" 
													   // 2: Check between "AddedBy" (of photo) and "User" 
													   // 3: Check between "Author" OR "AddedBy" and "User" 

$concours_default_values['concours_change_score']   = true; // Allow a user to change his score afer a validation
$concours_default_values['concours_deadline']   = 2; // 0: dont show deadline; 1: deadline version 1; 2: deadline version 2
$concours_default_values['mask_thumbnail']   = true; // Mask thumbnail on category page before the contest start
$concours_default_values['nb_concours_page']   = 10; // nb of contest by page (on admin page)
$concours_default_values['active_global_score_page']   = false; // activate global page for vote/score (all image in 1 page)
$concours_default_values['score_mode']   = 1; // score mode. 0: text box / 1: stars 
$concours_default_values['text_overlay']   = "Vote déjà enregistré <br>"; // text to display when the score is already present and the option concours_change_score is false (allow the user to change the score after vote) 

?>