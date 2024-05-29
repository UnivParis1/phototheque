<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>
<div class="concours">
	<fieldset> 
		<legend>{'concours_audit_page'|@translate}</legend> 
		<fieldset> 
			<legend>{'concours_infos'|@translate}</legend> 
		<table align="left">
				<td align = "left">
					{'concours_name'|@translate} : <b>{$CONCOURS.NAME}</b>
					<br>{'concours_descr'|@translate} : <b>{$CONCOURS.DESCR}</b>
					<br>{'concours_activ_from'|@translate} <b>{$CONCOURS.BEGIN_DATE}</b> {'concours_activ_to'|@translate} <b>{$CONCOURS.END_DATE}</b>
					<br>{'concours_method'|@translate} : <b>{$CONCOURS.METHOD}</b>
				</td>
			</tr>
		</table>
		</fieldset>
		<fieldset> 
	<form method="post" action="" class="properties"  ENCTYPE="multipart/form-data">
		{'concours_username_selection'|@translate} : </b>
			<select name="user_list">
			{foreach $user_list as $user_list1}
				<option value="{$user_list1.ID}" {$user_list1.SELECTED}>{$user_list1.NAME}</option>
			{/foreach}
			</select>
		<input type="submit" name="Submit" value="{'Submit'|@translate}" />
	</form>
		<table align="left">
			<tr><td colspan="4"><br></td></tr>
			 {foreach $concours_note as $concours_note1}
				<tr>
					<td><b><i> {if $concours_note1.nbvotant != 0}
								({$concours_note1.rang}{if $concours_note1.rang == 1}{'concours_1st'|@translate}
													 {elseif $concours_note1.rang == 2}{'concours_2nd'|@translate}
													 {elseif $concours_note1.rang == 3}{'concours_3rd'|@translate}
													 {else}{'concours_4th'|@translate}{/if}
								)
								{else}(N/A){/if}&nbsp;&nbsp;</i></b></td>
					<td>
						<b>Photo Id : {$concours_note1.img_id}&nbsp;&nbsp;</b>
					</td>		
					<td>
						<a href="{$concours_note1.url}"> 
						<img class="thumbnail" src="{$concours_note1.thumb}" alt="{$concours_note1.name}" title="{$concours_note1.name}"/> 
						</a>
						<div align="left">
						<br><u>{'concours_name'|@translate}</u> : {$concours_note1.name}
						<br><u>{'concours_author'|@translate}</u> : {$concours_note1.author}
						<br><u>{'concours_addedby'|@translate}</u> : {$concours_note1.addedby}
						</div>
					</td>
					<td align="left">
					<fieldset>
						<i>{'concours_note'|@translate} : <b>{$concours_note1.note}</b>&nbsp;&nbsp;</i>
						<br><i>{'concours_moyenne'|@translate} : <b>{$concours_note1.moyenne}</b>&nbsp;&nbsp;</i>
						{if ($CONCOURS.METHODNB > 2)}
						<br>{'concours_warn_moderation'|@translate}
						{/if}
						<br><i>{'concours_nbvotant'|@translate} : {$concours_note1.nbvotant}&nbsp;&nbsp;</i>
					</fieldset>
					</td>
				</tr>
				<tr><td colspan="2"></td>
					<td><hr></td>
					<td></td>
				</tr>
			{/foreach}

		</table>
		</fieldset> 
	</fieldset> 

</div>
