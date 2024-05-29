<dt>{'Concours'|@translate}</dt>
<dd>
	<ul>{strip}
	{foreach from=$block->data item=link}
		{if is_array($link)}
			<li><a href="{$link.URL}" title="{$link.TITLE}"{if isset($link.REL)} {$link.REL}{/if}>{$link.NAME}</a>{if isset($link.COUNTER)} ({$link.COUNTER}){/if}
            {if $link.edit!=""} [<a href="{$link.edit}">{"concours_admin_edit"|@translate}</a>]
            {/if}
            </li>

		{/if}
	{/foreach}
	{/strip}</ul>
</dd>




