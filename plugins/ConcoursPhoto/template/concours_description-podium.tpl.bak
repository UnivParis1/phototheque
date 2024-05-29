<div class="global_score">

	<ul class="thumbnail">
		{foreach from=$block.contests item=contest}
			<div class="podium">
				<div class="description">
					<div class="CR_text">
					<h3>{'concours_result_txt'|@translate} <a href="{$contest.URL}">{$contest.NAME} <img src="{$IMG_URL}generate.png" width="30" class="button" alt="{'concours_result'|@translate}" /></a> </h3>
						{$contest.BEGIN_DATE} - {$contest.END_DATE}
						<span class="CR_finished">[{$contest.DAYS} {'jours'|@translate} - <i>{$contest.NB_VOTANT} {'concours_nbscore'|@translate}]</i></span>
							<i>{$contest.DESCR}</i><br>
							<div id="CR_podium_cat">
								{foreach from=$contest.RESULTS item=result}
								{if $result.RANK <= 3}
								{if $result.RANK == 2}
									<div class="podium_23">
								{/if}
									<div class="podium_{$result.RANK}">
										<div class="illustration">
											<a href="{$result.URL}"> 
											<img class="thumbnail" src="{$result.XXSMALL_SRC}" alt="{$result.NAME}" title="{$result.NAME}"/> 
											</a><br>({$result.RANK}{if $result.RANK == 1}{'concours_1st'|@translate}{elseif $result.RANK == 2}{'concours_2nd'|@translate}{elseif $result.RANK == 3}{'concours_3rd'|@translate}{/if} - <u>{$result.AUTHOR}</u>)<br>
										</div>
									</div>
								{if $result.RANK == 3 OR ($result.RANK == 2 AND $contest.nb_results == 2)}
									</div>
								{/if} <!-- au cas ou il n'y a que deux résultats -->
								{/if}
							{/foreach}
							</div>
					</div>
				</div>
			</div>
		{/foreach}
	</ul>

</div>
