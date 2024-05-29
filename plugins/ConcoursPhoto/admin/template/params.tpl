{footer_script}{literal}
function detecter(){
    if(document.getElementById('concours_change_score').checked){
        document.getElementById('text_overlay_concours').style.display='none';
    }
    else{
        document.getElementById('text_overlay_concours').style.display='inline';
    }
}{/literal}{/footer_script}


<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>
<p>
{'concours_admin_title'|@translate}
</p>
<form method="post" action="" class="general">
<fieldset>
	<legend>{'concours_params'|@translate}</legend>
	<div id="ConcoursParams">

<TABLE border="0" ALIGN="LEFT">

	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="active_menubar" {$SHOW_MENUBAR}/> {'concours_show_menubar'|@translate} 
		    <br/>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		  {'concours_nb_concours_menubar'|@translate}
		  <select id="nbconcours_menubar" name="nbconcours_menubar">
			 {foreach $NBCONCOURS as $NBCONCOURS1}
			  <option value="{$NBCONCOURS1.ID}" {$NBCONCOURS1.SELECTED}>{$NBCONCOURS1.NAME}</option>
			{/foreach}
		  </select>

	     </TD>
	</TR>
	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="mask_author" {$MASK_AUTHOR}/> {'concours_mask_author'|@translate} 
		    <br/>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="mask_meta" {$MASK_META}/> {'concours_mask_meta'|@translate} 
		    <br/>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="thumb_note" {$THUMB_NOTE}/> {'concours_thumb_note'|@translate} 
		    <br/>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="check_exaequo" {$CHECK_EXAEQUO}/> {'concours_check_exaequo'|@translate} 
		    <br/>
		</TD>
	<TR>
		<TD colspan="3">
		  {'concours_author_vote'|@translate}
		  <select id="AUTHOR_MODE" name="AUTHOR_MODE">
			 {foreach $AUTHOR_MODE as $AUTHOR_MODE1}
			  <option value="{$AUTHOR_MODE1.ID}" {$AUTHOR_MODE1.SELECTED}>{$AUTHOR_MODE1.NAME}</option>
			{/foreach}
		  </select>

	     </TD>
	</TR>
	
	<TR>
		<TD colspan="3">
			<i>
 	         <ul>
 	         <li style="list-style-type: none;">{'concours_author_vote_detail0'|@translate}</li>
 	         <li style="list-style-type: none;">{'concours_author_vote_detail1'|@translate}</li>
 	         <li style="list-style-type: none;">{'concours_author_vote_detail2'|@translate}</li>
 	         <li style="list-style-type: none;">{'concours_author_vote_detail3'|@translate}</li>
			  </ul>
			</i>		    
		    <br/>
		</TD>
	</TR>	

 	<TR>
		<TD >
		    <input type="checkbox" name="concours_change_score" id="concours_change_score" {$CHANGE_SCORE} onclick="detecter()" /> {'concours_change_score'|@translate} 
		</TD>
		<TD colspan="2">
			<div id="text_overlay_concours" >
			({'concours_overlay_text'|@translate} : <textarea name="text_overlay" id ="text_overlay" rows="1" cols="10" style="width:90%;">{$TEXT_OVERLAY}</textarea>)
		    <br/>
			</div>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		  {'concours_deadline_param'|@translate}
		  <select id="concours_deadline" name="concours_deadline" >
			 {foreach $DEADLINE as $DEADLINE1}
			  <option value="{$DEADLINE1.ID}" {$DEADLINE1.SELECTED}>{$DEADLINE1.NAME}</option>
			{/foreach}
		  </select>

	     </TD>
	</TR>
 	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="mask_thumbnail" {$MASK_THUMB}/> {'mask_thumbnail'|@translate} 
		    <br/>
		</TD>
	</TR>
 	<TR>
		<TD colspan="3">
		    <input type="checkbox" name="active_global_score_page" {$GLOBAL_SCORE}/> {'concours_global_score_admin'|@translate} 
		    <br/>
		</TD>
	</TR>
	<TR>
		<TD colspan="3">
		  {'concours_score_mode'|@translate}
		  <select id="score_mode" name="score_mode">
			 {foreach $SCORE_MODE as $SCORE_MODE1}
			  <option value="{$SCORE_MODE1.ID}" {$SCORE_MODE1.SELECTED}>{$SCORE_MODE1.NAME}</option>
			{/foreach}
		  </select>

	     </TD>
	</TR>
	
</table>
</div>
<br/>
</fieldset>
 
<p><input type="submit" name="submit" value="{'concours_submit'|@translate}" />
</p>
</form>


<fieldset>
	<legend>{'concours_result_files'|@translate}</legend>
</br>
<table align="left">
	<tr>
		<td colspan="2"  align="left">
		{'concours_result_file_list'|@translate}
		</td>
	</tr>
	{if count($FILE)}
	 {foreach $FILE as $FILE1}
		<tr align="left">
			<td>
				<a href="{$FILE1.LINK}">{$FILE1.NAME}</a>
			</td>
			<td>
				Concours <b>{$FILE1.CONC_NAME}</b> {if $FILE1.CONC_ID != 0}({$FILE1.CONC_ID}){/if} : <i>{$FILE1.CONC_DESCR}</i>
			</td>
		</tr>
	  {/foreach}
	 {else}
		<tr>
		<td colspan="2" align="left">
			<b>{'concours_no_result_file'|@translate}</b>
			</td>
		</tr>
			
	 {/if}
</table>
</fieldset>