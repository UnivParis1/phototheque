{include file='include/autosize.inc.tpl'}
{include file='include/datepicker.inc.tpl'}

{literal}
<script type="text/javascript">
  pwg_initialization_datepicker("#start_day", "#start_month", "#start_year", "#start_linked_date", null, null, null);
  pwg_initialization_datepicker("#end_day", "#end_month", "#end_year", "#end_linked_date", null, null, null);
</script>
{/literal}

<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>

<form method="post" action="" class="properties"  ENCTYPE="multipart/form-data">

<fieldset>
	<legend>{'concours_add'|@translate}</legend>
	<table>

		<tr><td colspan="4"><br></td></tr>

		<tr>
			<td><b>{'concours_id'|@translate}&nbsp;&nbsp;</b></td>
			<td colspan="3">{$CONCOURS.ID}</td>
		</tr>
{if (isset($action) && ($action == 'modify_crit' || $action == 'edit'))}
		<tr>
			<td><b>{'concours_name'|@translate}&nbsp;&nbsp;</b></td>
			<td colspan="3">{$CONCOURS.NAME}</td>
		</tr>

		<tr>
			<td><b>{'concours_descr'|@translate}&nbsp;&nbsp;</b></td>
			<td colspan="3">{$CONCOURS.DESCR}</td>
		</tr>

		<tr>
          <td>
            <b>{'concours_date_from'|@translate}</b>
          </td>
          <td colspan="3">
            <b>{$START_DAY_SELECTED} / {$START_MONTH_SELECTED} / {$START_YEAR} - {$START_HOUR} : {$START_MIN}</b>
          </td>
        </tr>
		<tr>
          <td>
            <b>{'concours_date_end'|@translate}</b>
          </td>
          <td colspan="3">
            <b>{$END_DAY_SELECTED} / {$END_MONTH_SELECTED} / {$END_YEAR} - {$END_HOUR} : {$END_MIN}</b>
          </td>
        </tr>
		<tr>
			<td><b>{'concours_method'|@translate} &nbsp;&nbsp;</b></td>
			<td colspan = "3"> 		
				<select name="concours_method" {if !isset($result_not_generated)}disabled="disabled"{/if}>
				{foreach $concours_method as $concours_method1}
					<option value="{$concours_method1.ID}" {$concours_method1.SELECTED}>{$concours_method1.NAME}</option>
				{/foreach}
				</select>
			</td>
			
        </tr>
		
		<tr>
			<td colspan="4">
			<b>{'concours_category_select'|@translate}</b>
			<select  name="cat_selection" disabled="disabled">
			 {foreach $category_selection as $category_selection1}
			  <option value="{$category_selection1.ID}" {$category_selection1.SELECTED}>{$category_selection1.NAME}</option>
			{/foreach}
			</select>
			</td>
		</tr>
{else}
		<tr>
			<td><b>{'concours_name'|@translate}&nbsp;&nbsp;</b></td>
			<td colspan="3"><input  type="text" size="50" maxlength="50" value="{$CONCOURS.NAME}" name="concours_name"/></td>
		</tr>

		<tr><td colspan="4"><br></td></tr>

		<tr>
			<td><b>{'concours_descr'|@translate}&nbsp;&nbsp;</b></td>
			<td colspan="3"><input  type="text" size="65" maxlength="255" value="{$CONCOURS.DESCR}" name="concours_descr"/></td>
		</tr>

		<tr><td colspan="4"><br></td></tr>

		{if isset($group_perm)}
		<tr><td colspan="4"><br></td></tr>
		<tr>
			<td><b>{'concours_authorized_group'|@translate} &nbsp;&nbsp;</b></td>
			<td colspan="3">{$group_perm.GROUPSELECTION}</td>
        </tr>
		{/if}
        <TR>
            <TD colspan="4">
                <input type="checkbox" name="guest" {$CONCOURS.GUEST}/> {'concours_allow_guest'|@translate} 
                <br/>
            </TD>
        </TR>
        <TR>
            <TD colspan="4">
                <input type="checkbox" name="admin" {$CONCOURS.ADMIN}/> {'concours_allow_admin'|@translate} 
                <br/>
            </TD>
        </TR>
        
        <tr><td colspan="4"><br></td></tr>
		<tr>
			<td colspan="4"><b><i><u>{'concours_activation_date'|@translate}</u></i></b></td>
        </tr>

		<tr>
          <td>
            <b>{'concours_date_from'|@translate}</b>
          </td>
          <td>
              <select id="start_day" name="start_day">
                <option value="0">--</option>
                {section name=day start=1 loop=32}
                <option value="{$smarty.section.day.index}" {if $smarty.section.day.index==$START_DAY_SELECTED}selected="selected"{/if}>{$smarty.section.day.index}</option>
                {/section}
              </select>
              <select id="start_month" name="start_month">
              {html_options options=$month_list selected=$START_MONTH_SELECTED}
              </select>
              <input id="start_year" name="start_year" value="{$START_YEAR}" type="text" size="4" maxlength="4" >
              <input id="start_linked_date" name="start_linked_date" type="hidden" size="10" disabled="disabled"/>
          </td>
          <td align="right">
            <b>{'concours_hour_from'|@translate}</b>
          </td>
          <td>
              <select id="start_hour" name="start_hour">
                {section name=hour start=0 loop=24}
                <option value="{$smarty.section.hour.index}" {if $smarty.section.hour.index==$START_HOUR}selected="selected"{/if}>{$smarty.section.hour.index}</option>
                {/section}
              </select>
              <select id="start_min" name="start_min">
                {section name=min start=0 loop=60}
                <option value="{$smarty.section.min.index}" {if $smarty.section.min.index==$START_MIN}selected="selected"{/if}>{$smarty.section.min.index}</option>
                {/section}
              </select>
          </td>
        </tr>
        <tr>
          <td>
            <b>{'concours_date_end'|@translate}</b></li>
          </td>
          <td>
              <select id="end_day" name="end_day">
                <option value="0">--</option>
                {section name=day start=1 loop=32}
                <option value="{$smarty.section.day.index}" {if $smarty.section.day.index==$END_DAY_SELECTED}selected="selected"{/if}>{$smarty.section.day.index}</option>
                {/section}
              </select>
              <select id="end_month" name="end_month">
              {html_options options=$month_list selected=$END_MONTH_SELECTED}
              </select>
              <input id="end_year" name="end_year" value="{$END_YEAR}" type="text" size="4" maxlength="4" >
              <input id="end_linked_date" name="end_linked_date" type="hidden" size="10" disabled="disabled"/>
          </td>
          <td align="right">
            <b>{'concours_hour_to'|@translate}</b>
          </td>
          <td>
              <select id="end_hour" name="end_hour">
                {section name=hour start=0 loop=24}
                <option value="{$smarty.section.hour.index}" {if $smarty.section.hour.index==$END_HOUR}selected="selected"{/if}>{$smarty.section.hour.index}</option>
                {/section}
              </select>
              <select id="end_min" name="end_min">
                {section name=min start=0 loop=60}
                <option value="{$smarty.section.min.index}" {if $smarty.section.min.index==$END_MIN}selected="selected"{/if}>{$smarty.section.min.index}</option>
                {/section}
              </select>
          </td>
           
        </tr>

		<tr>
			<td><b>{'concours_method'|@translate} &nbsp;&nbsp;</b></td>
			<td colspan = "3"> 		
				<select name="concours_method">
				{foreach $concours_method as $concours_method1}
					<option value="{$concours_method1.ID}" {$concours_method1.SELECTED}>{$concours_method1.NAME}</option>
				{/foreach}
				</select>
			</td>
			
        </tr>
        <tr><td colspan="4"><br></td></tr>

		<tr>
			<td colspan="4">
			<b>{'concours_category_select'|@translate}</b>
			<select  name="cat_selection">
			 {foreach $category_selection as $category_selection1}
			  <option value="{$category_selection1.ID}" {$category_selection1.SELECTED}>{$category_selection1.NAME}</option>
			{/foreach}
			</select>
			</td>
		</tr>
        <TR>
            <TD colspan="4">
                <b>{'concours_show_podium'|@translate}</b> <input type="checkbox" name="Podium_onCat" {$CONCOURS.SHOWPODIUM}/> 
                <br/>
            </TD>
        </TR>
{/if}
		</table>
</fieldset>
{if (isset($action) && ($action == 'modify_crit' || $action == 'edit'))}
		<fieldset>
		<legend>{'concours_criterias'|@translate}</legend>
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
					{if $action != 'edit'}
					<td width="10%">{'concours_actions'|@translate}</td>
					{/if}
				</tr>
			</thread>
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
					{if $action != 'edit'}
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
					{/if}
				</tr>
			{/foreach}
		</table>
	{else}
		<fieldset>
			<div class="concours_no_criteria">
				{'concours_no_criteria'|@translate}
			</div>
		</fieldset>

	{/if}
	{if $action != 'edit'}
		<p><input type="submit" name="add" value="{'concours_add_criteria'|@translate}" />
	{/if}

{/if}	
<p><input class="submit" type="submit" value="{'Submit'|@translate}" name="submit" /></p>
</form>