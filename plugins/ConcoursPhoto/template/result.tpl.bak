<div class="concours">
	<fieldset> 
		<legend>{'concours_infos'|@translate}</legend> 
	<table align="left">
			<td >
				{'concours_name'|@translate} : <b>{$CONCOURS.NAME}</b> [{$CONCOURS.DAYS} {'jours'|@translate} - {$CONCOURS.NBIMG} {'concours_nbphotos'|@translate} - <i>{$CONCOURS.NB_VOTANT} {'concours_nbscore'|@translate}]</i>
				<br>{'concours_descr'|@translate} : <b>{$CONCOURS.DESCR}</b>
				<br>{'concours_activ_from'|@translate} <b>{$CONCOURS.BEGIN_DATE}</b> {'concours_activ_to'|@translate} <b>{$CONCOURS.END_DATE}</b>
				<br>{'concours_method'|@translate} : <b>{$CONCOURS.METHOD}</b>
				<br>

			</td>
		</tr>
	</table>
	</fieldset>
	<fieldset> 
		<legend>{'concours_result_page'|@translate}</legend> 
	<table>
		<tr><td colspan="5"><br></td></tr>
		 {foreach $concours_note as $concours_note1}
			<tr>
				<td><b><i> {if $concours_note1.nbvotant != 0}
                            ({$concours_note1.rang}{if $concours_note1.rang == 1}{'concours_1st'|@translate}
												 {elseif $concours_note1.rang == 2}{'concours_2nd'|@translate}
												 {elseif $concours_note1.rang == 3}{'concours_3rd'|@translate}
												 {else}{'concours_4th'|@translate}{/if}
							)
                            {else}(N/A){/if}&nbsp;&nbsp;</i></b></td>
				<td><b>Photo {$concours_note1.img_id}&nbsp;&nbsp;</b></td>		
				<td align="center">
					<a href="{$concours_note1.url}"> 
					<img class="thumbnail" src="{$concours_note1.thumb}" alt="{$concours_note1.name}" title="{$concours_note1.name}"/> 
					</a>
					<div align="left">
                    <br><u>{'concours_name'|@translate}</u> : {$concours_note1.name}
                    <br><u>{'concours_author'|@translate}</u> : {$concours_note1.author}
					</div>
				</td>
				<td>
				<fieldset>
					{if ($CONCOURS.METHODNB == 1)}
						<i><b>{'concours_note'|@translate} : {$concours_note1.note}</b>&nbsp;&nbsp;</i>
					{else}
						<i>{'concours_note'|@translate} : {$concours_note1.note}&nbsp;&nbsp;</i>
					{/if}
					{if ($CONCOURS.METHODNB == 2)}
						<br><i><b>{'concours_moyenne'|@translate} : {$concours_note1.moyenne}</b>&nbsp;&nbsp;</i>
					{else}
						<br><i>{'concours_moyenne'|@translate} : {$concours_note1.moyenne}&nbsp;&nbsp;</i>
					{/if}
					{if ($CONCOURS.METHODNB == 3)}
						<br><i><b>{'concours_moderation1'|@translate} : {$concours_note1.moderation1}</b>&nbsp;&nbsp;</i>
					{else}
						<br><i>{'concours_moderation1'|@translate} : {$concours_note1.moderation1}&nbsp;&nbsp;</i>
					{/if}
					{if ($CONCOURS.METHODNB == 4)}
						<br><i><b>{'concours_moderation2'|@translate} : {$concours_note1.moderation2}</b>&nbsp;&nbsp;</i>
					{else}
						<br><i>{'concours_moderation2'|@translate} : {$concours_note1.moderation2}&nbsp;&nbsp;</i>
					{/if}
					<br>
					<br><i>{'concours_nbvotant'|@translate} : {$concours_note1.nbvotant}&nbsp;&nbsp;</i>
					<br>
					<br>  ==> {'concours_usernote'|@translate} : <b>{$concours_note1.usernote}</b>&nbsp;&nbsp;
				</fieldset>
				</td>
				{if $concours_note1.rang > 3}
				<td>&nbsp;</td>
				{else}
				<td><img src="{$IMG_URL}trophee-{$concours_note1.rang}.png" width="75" height="75"></td>
				{/if}
			</tr>
       		<tr><td colspan="2"></td>
                <td ><hr></td>
                <td colspan="2"></td>
            </tr>

		{/foreach}

	</table>
	</fieldset> 

</div>
