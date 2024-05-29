<ul>
	<li>
		<span class="property">{'CR_select_contest'|@translate}</span>
		<select name="contest_id" size="5" {if $VISILBLE} disabled {/if}>
		{foreach from=$contests item=contest}
			<option value="{$contest.ID}" {if $contest.SELECTED}selected="selected"{/if}>{$contest.ID} - {$contest.NAME}</option>
		{/foreach}
		</select>
	</li>
	<li>
		<span class="property">{'lastcoms_nb_cadres'|@translate}</span>
		{html_options name=nb_per_line options=$NB_PER_LINE.OPTIONS selected=$NB_PER_LINE.SELECTED}
	</li>
</ul>