<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>
<p>
{'concours_admin_title'|@translate}
</p>
<form method="post" action="" class="properties"  ENCTYPE="multipart/form-data">
<fieldset>
	<legend>{'manage_criteria'|@translate}</legend>
	 <table border="1">
		<tr>
			<td><b>{'concours_id'|@translate}</b></td>
			<td>{$criteria_id}</td>
		</tr>

		<tr>
			<td><b>{'concours_name'|@translate}</b></td>
			<td width="50">{if $action != "edit"} 
				<input type="text" size="50" maxlength="50" value="{$criteria_name}" name="criteria_name"/></td>
				{else}{$criteria_name}{/if}
			</td>
		</tr>
		<tr>
			<td><b>{'concours_descr'|@translate}</b></td>
			<td width="255">{if $action != "edit"} 
				<input type="text" size="65" maxlength="255" value="{$criteria_lib}" name="criteria_lib"/></td>
				{else}{$criteria_lib}{/if}
			</td>
		</tr>
			<td><b>{'concours_min_value'|@translate}</b></td>
			<td>{if $action != "edit"} 
				<input type="text" size="5" maxlength="5" value="{$criteria_min}" name="criteria_min"/></td>
				{else}{$criteria_min}{/if}
			</td>
		</tr>
			<td><b>{'concours_max_value'|@translate}</b></td>
			<td>{if $action != "edit"} 
				<input type="text" size="5" maxlength="5" value="{$criteria_max}" name="criteria_max"/></td>
				{else}{$criteria_max}{/if}
			</td>
		</tr>
			<td><b>{'concours_coef'|@translate}</b></td>
			<td>{if $action != "edit"} 
				<input type="text" size="5" maxlength="5" value="{$criteria_pond}" name="criteria_pond"/></td>
				{else}{$criteria_pond}{/if}
			</td>
		</tr>
	</table>

	<p><input type="submit" name="submit" value="{'concours_criteria_submit'|@translate}" />
		
</fieldset>
</form>