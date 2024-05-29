{combine_css path= 'plugins/ConcoursPhoto/template/overlay.css'}


{if $SCORE_MODE ==1}
{combine_css path= 'plugins/ConcoursPhoto/template/rating1.css'}
{/if}


{if $concours_infos.deadline_type == 1}

	{combine_css path= 'plugins/ConcoursPhoto/template/concours-1.css'}

	{literal}
	<script type="text/javascript">
	const second = 1000,
		  minute = second * 60,
		  hour = minute * 60,
		  day = hour * 24;

	let countDown = new Date({/literal}'{$concours_infos.end_date}'{literal}).getTime(),
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
		  <div id="head">{'concours_deadline'|@translate}</div>
		  <ul>
			<li><span id="days"></span>{'concours_deadline_days'|@translate}</li>
			<li><span id="hours"></span>{'concours_deadline_hours'|@translate}</li>
			<li><span id="minutes"></span>{'concours_deadline_mins'|@translate}</li>
			<li><span id="seconds"></span>{'concours_deadline_secs'|@translate}</li>
		  </ul>
		</div>


{elseif $concours_infos.deadline_type == 2}


	{strip}

		{combine_css path='plugins/ConcoursPhoto/template/concours-2.css'}
		{combine_script id='moment' load='footer' path='plugins/ConcoursPhoto/template/moment.js'}
		{combine_script id='vue.min' load='footer' path='plugins/ConcoursPhoto/template/vue.min.js'}
		{combine_script id='deadline' load='footer' require='vue.min' path='plugins/ConcoursPhoto/template/deadline.js'}
	{/strip}

	<div class="concours">
		<form  method="post" action="{$CONCOURS_F_ACTIONS}" class="concours"> 
		<div class="counter">
	<div class="countdown-head">{'concours_deadline'|@translate}</div>
	{literal}

		<div id="countdown">
	{/literal}
		<countdown duration="{$concours_infos.end_concours_min} second"></countdown>
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



{else if $concours_infos.deadline_type == 0}

<div class="concours">
	<form  method="post" action="{$CONCOURS_F_ACTIONS}" class="concours"> 
{/if}

	<fieldset> 
		<legend>Concours Photo</legend> 

{if !$CONCOURS_CHANGE_SCORE}
<div class="container_mod">
{/if}
		
	<table>
		<tr>
			<td align="left" colspan="2"><b>Concours : {$concours_infos.name}&nbsp;</b>
			<i>({$concours_infos.descr})</i>&nbsp;
			</td>
            <td align="right" colspan="3">
                {'concours_global_user_note'|@translate} : <b>{$concours_infos.note}</b> / {$concours_infos.max_note} &nbsp;
                	{if $SCORE_MODE ==1}
						<fieldset class="rating1" align="left">
						{for $var={$concours_infos.max_note} to 1 step -1}
							<input type="radio" id="star_{$concours_infos}__{$var}" name="{$concours_infos}_" value="{$var}" {if $var==$concours_infos.note}checked="checked"{/if} disabled="disabled" />
							<label class = "full" for="star_{$concours_infos}__{$var}" title="{$var}"></label>			
							<input type="radio" id="star_{$concours_infos}__{$var-1}_half" name="{$concours_infos}_" value="{$var-0.5}" {if $var-0.5==$concours_infos.note}checked="checked"{/if} disabled="disabled"/>
							<label class = "half" for="star_{$concours_infos}__{$var-1}_half" title="{$var-0.5}"></label>			
						{/for}
						</fieldset>
					{/if}

            </td>

		</tr>
		<tr><td colspan="5"><br></td></tr>
		 {foreach $concours_criteria as $concours_criteria1}
			<tr align="left">
			{if $concours_criteria1.level == 1}
				<td align="left" colspan="2"><b><u>{$concours_criteria1.name}</u></b>&nbsp;
					(<b><i>{$concours_criteria1.lib}</i></b>)&nbsp;&nbsp;</td>		
			{else}
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>		
				<td><i>{$concours_criteria1.name}&nbsp;&nbsp;</i></td>
			{/if}
			{if $concours_criteria1.level == 1}
				<td align="left" >&nbsp;</td>
			{else}
				<td><i>{$concours_criteria1.lib}&nbsp;&nbsp;</i></td>
			{/if}
			{if $concours_criteria1.nosub}
			<td width=200>
			{if $SCORE_MODE == 0}
			<input type="text" size="4" maxlength="4" value="{$concours_criteria1.val}" name="{$concours_criteria1.id}" {if !$CONCOURS_CHANGE_SCORE}disabled="disabled"{/if}/>
			{elseif $SCORE_MODE ==1}
			
			<fieldset class="rating">
			{for $var={$concours_criteria1.max} to {$concours_criteria1.min + 1} step -1}
				<input type="radio" id="star_{$concours_criteria1.id}_{$var}" name="{$concours_criteria1.id}" value="{$var}" {if $var==$concours_criteria1.val}checked{/if}  {if !$CONCOURS_CHANGE_SCORE}disabled="disabled"{/if}/>
				<label class = "full" for="star_{$concours_criteria1.id}_{$var}" title="{$var}"></label>			
				<input type="radio" id="star_{$concours_criteria1.id}_{$var-1}_half" name="{$concours_criteria1.id}" value="{$var-0.5}" {if $var-0.5==$concours_criteria1.val}checked{/if} {if !$CONCOURS_CHANGE_SCORE}disabled="disabled"{/if}/>
				<label class = "half" for="star_{$concours_criteria1.id}_{$var-1}_half" title="{$var-0.5}"></label>			
			{/for}
			</fieldset>			
			
{******
			<section id="rateConcours" class="ratingConcours">
			{for $var={$concours_criteria1.max} to {$concours_criteria1.min} step -1}
			  <input type="radio" id="star_{$concours_criteria1.id}_{$var}" name="{$concours_criteria1.id}" value="{$var}" {if $var==$concours_criteria1.val}checked{/if}/>
			  <label for="star_{$concours_criteria1.id}_{$var}" title="{$var}">&#9733;</label>
			{/for}
			</section>
******}


			{/if}
			</td>
			
			<td><i>(Min={$concours_criteria1.min}&nbsp;;Max={$concours_criteria1.max})&nbsp;</i></td>
			{else}
				<td colspan="2">&nbsp;</td>		
			{/if}
			</tr>
		{/foreach}
		<tr><td colspan="5"><br></td></tr>
		<tr>
			<td colspan="2">{'concours_comment'|@translate}&nbsp;</td>
			<td colspan="3">
			<textarea cols="50" rows="4" name="concours_comment" id="concours_comment" {if !$CONCOURS_CHANGE_SCORE}disabled="disabled"{/if}>{$CONCOURS_COMMENT}</textarea>
			</td>
		</tr>		

	
{if !$CONCOURS_CHANGE_SCORE}
  <div class="middle_mod">
    <div class="text_mod">{$TEXT_OVERLAY}</div><br>
    <div class="text_mod">{$TEXT_OVERLAY}</div><br>
  </div>
{/if}
	</table>
{if !$CONCOURS_CHANGE_SCORE}
</div>{/if}

	<p>
    {if $CONCOURS_CHANGE_SCORE}
	<input type="submit" name="concours_submit" value="{'concours_save'|@translate}" />
	<input type="submit" name="concours_raz" value="{'concours_RAZ'|@translate}" onclick="return confirm('{'Are you sure?'|@translate|@escape:'javascript'}');">
    {/if}
	</p>	
	</fieldset> 
	</form> 

</div>
