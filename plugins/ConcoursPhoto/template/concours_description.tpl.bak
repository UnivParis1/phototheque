

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


	{/literal}
	</script>

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
{/if}


{if isset($global_vote_link)}
	<div class="global_score">
	<a href="{$global_vote_link}" title="{'concours_global_score_title'|@translate}"><img src="{$IMG_URL}concours.png" width="40"/><b>{'concours_global_score'|@translate}<b><img src="{$IMG_URL}concours.png" width="40"/></a><br>

	</div>
{/if}
