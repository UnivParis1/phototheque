<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>
<p>
{'concours_admin_title'|@translate}
</p>
	<fieldset>
	<legend>{'default_criteria'|@translate}</legend>
	</fieldset>

	{if count($concours_criteria)}
		<table class="table2" width="97%">
			<thead>
				<tr class="throw">
					<td width="5%">{'concours_id'|@translate}</td>
					<td width="15%">{'concours_name'|@translate}</td>
					<td width="50%">{'concours_descr'|@translate}</td>
					<td width="5%">{'concours_min_value'|@translate}</td>
					<td width="5%">{'concours_max_value'|@translate}</td>
					<td width="5%">{'concours_coef'|@translate}</td>
					<td width="10%">{'concours_actions'|@translate}</td>
				</tr>
			</thead>
			<tbody>
				 {foreach $concours_criteria as $concours_criteria1}
					{if $smarty.foreach.foreach_concours_criteria.iteration is even}
						<tr class="row1">
					{else}	
						<tr class="row2">
					{/if}
						<td>{$concours_criteria1.id}</td>		
						<td>
							{if $concours_criteria1.level == 1}
								<b>{$concours_criteria1.name}</b>
							{else}
								&nbsp;&nbsp;<i>{$concours_criteria1.name}</i>
							{/if}
						</td>		
						<td>{$concours_criteria1.lib}</td>		
						{if !$concours_criteria1.nosub}
							<td colspan="3">&nbsp;</td>		
						{else}
							<td>{$concours_criteria1.min}</td>		
							<td>{$concours_criteria1.max}</td>		
							<td>{$concours_criteria1.pond}</td>		
						{/if}
						<td>
						{if isset($concours_criteria1.U_EDIT)}
							<a href="{$concours_criteria1.U_EDIT}" title="{'criteria_edit'|@translate}"><img src="{$themeconf.admin_icon_dir}/category_edit.png" class="button" alt="{'criteria_edit'|@translate}"/></a>
							&nbsp;
						{/if}
						{if isset($concours_criteria1.U_DELETE)}
							<a href="{$concours_criteria1.U_DELETE}" title="{'criteria_delete'|@translate}" onclick="return confirm('{'Are you sure?'|@translate|@escape:javascript}');"><img src="{$themeconf.admin_icon_dir}/delete.png" class="button" alt="{'criteria_delete'|@translate}" /></a>
						{/if}
						{if $concours_criteria1.level == 1}
							<a href="{$concours_criteria1.U_ADD}" title="{'subcriteria_add'|@translate}" ><img src="{$IMG_URL}add.png" width="30" class="button" alt="{'subcriteria_add'|@translate}" /></a>
						{/if}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		<fieldset>
			<div class="concours_no_criteria">
				{'concours_no_criteria'|@translate}
			</div>
		</fieldset>
	{/if}
	<fieldset>
		<form method="post" id="add">
		<p><input type="submit" name="add" value="{'concours_add_criteria'|@translate}" />
	</fieldset>

	</form>	
