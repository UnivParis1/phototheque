{combine_css path= 'plugins/ConcoursPhoto/template/overlay.css'}

{if $SCORE_MODE ==1}
{combine_css path= 'plugins/ConcoursPhoto/template/rating1.css'}
{/if}



{if $deadline_type == 1}

	{combine_css path= 'plugins/ConcoursPhoto/template/concours-1.css'}

	{literal}
	<script type="text/javascript">
	const second = 1000,
		  minute = second * 60,
		  hour = minute * 60,
		  day = hour * 24;

{/literal}
{if isset($begin_concours)}
	let countDown = new Date('{$begin_concours}').getTime(),
{else}  
	let countDown = new Date('{$end_concours}').getTime(),
{/if}
{literal}
		x = setInterval(function() {

		  let now = new Date().getTime(),
			  distance = countDown - now;

		  document.getElementById('days').innerText = Math.floor(distance / (day)),
			document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
			document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
			document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
		  
		}, second)


	</script>
{/literal}





	<div class="concours">
		<form  method="post" action="{$CONCOURS_F_ACTIONS}" class="concours"> 
		<div class="counter">
{if isset($begin_concours)} <div id="head">{'concours_begin'|@translate}</div> {else}  <div id="head">{'concours_deadline'|@translate}</div> {/if}
		  <ul>
			<li><span id="days"></span>{'concours_deadline_days'|@translate}</li>
			<li><span id="hours"></span>{'concours_deadline_hours'|@translate}</li>
			<li><span id="minutes"></span>{'concours_deadline_mins'|@translate}</li>
			<li><span id="seconds"></span>{'concours_deadline_secs'|@translate}</li>
		  </ul>
		</div>


{elseif $deadline_type == 2}


	{strip}

		{combine_css path='plugins/ConcoursPhoto/template/concours-2.css'}
		{combine_script id='moment' load='footer' path='plugins/ConcoursPhoto/template/moment.js'}
		{combine_script id='vue.min' load='footer' path='plugins/ConcoursPhoto/template/vue.min.js'}
		{combine_script id='deadline' load='footer' require='vue.min' path='plugins/ConcoursPhoto/template/deadline.js'}
	{/strip}

	<div class="concours">
		<form  method="post" action="{$CONCOURS_F_ACTIONS}" class="concours"> 
		<div class="counter">
{if isset($begin_concours)} <div class="countdown-head">{'concours_begin'|@translate}</div> {else}  <div class="countdown-head">{'concours_deadline'|@translate}</div> {/if}
	{literal}
	<div id="countdown">
		<div id="countdown">
	{/literal}
{if isset($begin_concours)} <countdown duration="{$begin_concours_min} second"></countdown> {else}  <countdown duration="{$end_concours_min} second"></countdown> {/if}
	{literal}
		</div>
	</div>

	<template id="countdown-template">
		<div class="countdown">
			<div class="blockdeadline" :class="clDays">
				<div class="digit">{{ days | two_digits }}</div>
	{/literal}
				<div class="text">{'concours_deadline_days'|@translate}</div>
	{literal}
			</div>
			<div class="blockdeadline" :class="clHours">
				<div class="digit">{{ hours | two_digits }}</div>
	{/literal}
				<div class="text">{'concours_deadline_hours'|@translate}</div>
	{literal}
			</div>
			<div class="blockdeadline" :class="clMinutes">
				<div class="digit">{{ minutes | two_digits }}</div>
	{/literal}
				<div class="text">{'concours_deadline_mins'|@translate}</div>
	{literal}
			</div>
			<div class="blockdeadline" :class="clSeconds">
				<div class="digit">{{ seconds | two_digits }}</div>
	{/literal}
				<div class="text">{'concours_deadline_secs'|@translate}</div>
			</div>
		</div>
	</template>



{else if $deadline_type == 0}

<div class="concours">
	<form  method="post" action="{$CONCOURS_F_ACTIONS}" class="concours"> 
{/if}




	<fieldset> 
		<legend>{'concours_infos'|@translate}</legend> 
	<table align="left">
		<tr>
			<td >
				{'concours_name'|@translate} : <b>{$CONCOURS.NAME}</b>
				<br>{'concours_descr'|@translate} : <b>{$CONCOURS.DESCR}</b>
				<br>{'concours_activ_from'|@translate} <b>{$CONCOURS.BEGIN_DATE}</b> {'concours_activ_to'|@translate} <b>{$CONCOURS.END_DATE}</b>
			</td>
		</tr>
		<tr>
			<td>
			<form method="post" id="concours_SORT">
				<label>
					{'Sort order'|@translate}
					<select name="concours_sort_order">
						<option value="" label="{'default'|@translate}" {if $sort_order==''}selected="selected"{/if}>{'default'|@translate}</option>
						<option value="score" label="{'concours_displaybyscore'|@translate}" {if $sort_order=='score'}selected="selected"{/if}>{'concours_displaybyscore'|@translate}</option>
					</select>
				</label>
				<label>
					&nbsp;
					<input type="submit" name="concours_SORT_submit" value="{'Submit'|@translate}" />
				</label>
			</form>
			</td>
		</tr>
	</table>
	</fieldset>
	<fieldset> 
		<legend>{'concours_notation'|@translate}</legend> 
	
	<table class="table" width="95%" border="1">
		<thead>
			<tr class="throw" >
				<td>Photo</td>
				<td colspan=3>CONCOURS</td>
			</tr>
		</thead>
		<tbody>
	{foreach $concours_note as $concours_note1}
			<tr>
				<td width=500 rowspan={$NB_CRITERIAS_CONCOURS+2} align="center">Photo {$concours_note1.img_id}<br>
					<a href="{$concours_note1.url}"> 
					<img class="thumbnail" src="{$concours_note1.thumb}" alt="{$concours_note1.name}" title="{$concours_note1.name}"/> 
					</a>
					<br><u>{'concours_name'|@translate}</u> : {$concours_note1.name}<br><br>
					<u>{'concours_global_user_note'|@translate}</u> : <b>{$concours_note1.note} / {$concours_note1.max_note}</b>&nbsp;
                	{if $SCORE_MODE ==1}

						<fieldset class="rating1" align="left">
						{for $var={$concours_note1.max_note} to 1 step -1}
							<input type="radio" id="star_{$concours_note1.img_id}__{$var}" name="{$concours_note1.img_id}_" value="{$var}" {if $var==$concours_note1.note}checked="checked"{/if} disabled="disabled" />
							<label class = "full" for="star_{$concours_note1.img_id}__{$var}" title="{$var}"></label>			
							<input type="radio" id="star_{$concours_note1.img_id}__{$var-1}_half" name="{$concours_note1.img_id}_" value="{$var-0.5}" {if $var-0.5==$concours_note1.note}checked="checked"{/if} disabled="disabled"/>
							<label class = "half" for="star_{$concours_note1.img_id}__{$var-1}_half" title="{$var-0.5}"></label>			
						{/for}
						</fieldset>			
					{/if}

				</td>
				<td colspan="4"></td>
			</tr>
			 {foreach $concours_note1.score as $concours_criteria1}
			<tr>

				<td>&nbsp;{$concours_criteria1.name}&nbsp;</i></td>
				{if $concours_criteria1.nosub}
					<td width=250>
	{if !$concours_note1.change_note}
		<div class="container_mod">
	{/if}
					{if $SCORE_MODE == 0} 
					<input type="text" size="4" maxlength="4" value="{$concours_criteria1.val}" name="{$concours_note1.img_id}_{$concours_criteria1.id}" />	
					{elseif $SCORE_MODE ==1}
						<fieldset class="rating">
						{for $var={$concours_criteria1.max} to {$concours_criteria1.min + 1} step -1}
							<input type="radio" id="star_{$concours_note1.img_id}_{$concours_criteria1.id}_{$var}" name="{$concours_note1.img_id}_{$concours_criteria1.id}" value="{$var}" {if $var==$concours_criteria1.val}checked="checked"{/if} {if !$concours_note1.change_note}disabled="disabled"{/if}/>
							<label class = "full" for="star_{$concours_note1.img_id}_{$concours_criteria1.id}_{$var}" title="{$var}"></label>			
							<input type="radio" id="star_{$concours_note1.img_id}_{$concours_criteria1.id}_{$var-1}_half" name="{$concours_note1.img_id}_{$concours_criteria1.id}" value="{$var-0.5}" {if $var-0.5==$concours_criteria1.val}checked="checked"{/if} {if !$concours_note1.change_note}disabled="disabled"{/if}/>
							<label class = "half" for="star_{$concours_note1.img_id}_{$concours_criteria1.id}_{$var-1}_half" title="{$var-0.5}"></label>			
						{/for}
						</fieldset>			
					{/if}
	{if !$concours_note1.change_note}
	  <div class="middle_mod">
		<div class="text_mod">{$TEXT_OVERLAY}</div><br>
	  </div>
	</div>
	{/if}	
					</td>
					<td width=30><i>(Min={$concours_criteria1.min}&nbsp;;Max={$concours_criteria1.max})&nbsp;</i></td>
					
				{else}
					<td colspan="2">&nbsp;</td>		
				{/if}

			</tr>
			{/foreach}

			<tr>
				<td colspan="4">{'concours_comment_short'|@translate} : 

				<textarea cols="75" rows="1" name="{$concours_note1.img_id}_concours_comment" id="concours_comment" {if !$concours_note1.change_note}disabled="disabled"{/if}>{$concours_note1.concours_comment}</textarea>


				</td>
			</tr>
			<tr>
			<td colspan=5>&nbsp;</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

	<p>
		<input type="submit" name="concours_submit" value="{'concours_save'|@translate}" />
	</p>
	
	</fieldset>

</div>
