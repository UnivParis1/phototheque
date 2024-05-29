<ul class="thumbnail">
	{foreach from=$block.contests item=contest}
	<li class="{$block.CLASS} {$block.SIZE_CLASS} {if !$contest.VISIBLE}novisible{/if}">
		<div class="podium_block">
			<div class="illustration">
				<a href="{$contest.URL}">
				{if $contest.STATUS != 'finished' AND !empty($contest.LOGO)}
					<img src="{$contest.LOGO}" alt="{$contest.NAME}" style="max-height:120px;max-width:120px;">
				{elseif !empty($contest.RESULTS.1.TN_SRC)}
					<img src="{$contest.RESULTS.1.TN_SRC}" alt="{$contest.NAME|@replace:'"':' '}">
				{/if}
				</a>
			</div>
			<div class="description">
				<h3> <a href="{$contest.URL}"> {$contest.NAME} <img src="{$block.IMG_URL}generate.png" width="30" class="button" alt="{'concours_result'|@translate}" /></a> </h3>
				<div class="CR_text">
					<p class="Nb_images">{$contest.BEGIN_DATE} - {$contest.END_DATE}</p>
					<span class="CR_finished">[{$contest.DAYS} {'jours'|@translate} - {$contest.NBIMG} {'concours_nbphotos'|@translate} - <i>{$contest.NB_VOTANT} {'concours_nbscore'|@translate}]</i></span>
					
					<p>
						<i>{$contest.DESCR}</i><br>
						<div id="CR_podium">
							{foreach from=$contest.RESULTS item=result}
							{if $result.RANK <= 3}
							{if $result.RANK == 2}
								<div class="podium_23">
							{/if}
									<div class="podium_{$result.RANK}">
										<div class="illustration">
														<a href="{$result.URL}"> 
														<img class="thumbnail" src="{if $result.RANK == 1}{$result.XSMALL_SRC}{else}{$result.XXSMALL_SRC}{/if}" alt="{$result.NAME}" title="{$result.NAME}"/> 
														</a><br>({$result.RANK}{if $result.RANK == 1}{'concours_1st'|@translate}{elseif $result.RANK == 2}{'concours_2nd'|@translate}{elseif $result.RANK == 3}{'concours_3rd'|@translate}{/if} - <u>{$result.AUTHOR}</u>)<br>
										</div>
									</div>
							{if $result.RANK == 3 OR ($result.RANK == 2 AND $contest.nb_results == 2)}
								</div>
							{/if} <!-- au cas ou il n'y a que deux résultats -->
							{/if}

						{/foreach}
						</div>
					</p>
				</div>
			</div>
		</div>
	</li>
	{/foreach}
</ul>



