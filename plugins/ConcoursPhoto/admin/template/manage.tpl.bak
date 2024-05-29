{footer_script}{literal}
jQuery('#Podium_onCat').change(function() {
 
 
 
$.post( 
    'plugins/ConcoursPhoto/admin/podium.php', // location of your php script
    { name: "bob", user_id: 1234 }, // any data you want to send to the script
    function( data ){  // a function to deal with the returned information

        $( 'body ').append( data );

    }); 
     var checked = $(this).attr('checked');
     alert('Data was saved in db!');
     if(checked){
      var value = $(this).val();
           alert(value);

      $.post('plugins/ConcoursPhoto/admin/podium.php', { value:value }, function(data){
          if(data == 1){
             // Do something or do nothing :-)
             alert('OKOK!');
          }
      });
   }
});
{/literal}
{/footer_script}

<div class="titrePage">
  <h2>{$CONCOURS_VERSION}</h2>
</div>
<p>
{'concours_admin_title'|@translate}
</p>


	<fieldset>
		<legend>{'manage_concours'|@translate}</legend>
		<form method="post" id="add_concours_submit">
		<div class="concours_last_line">
			<span>{$nb_concours_total} </span></br></br>
			<span><input type="submit" name="add_concours_submit" value="{'concours_add'|@translate}" /></span>
		</div>
		</form>
	</fieldset>

	<fieldset>
		<legend>{'Filter'|@translate}</legend>
		<form method="post" id="concours_form_filter" action="{$MANAGE_URL}">
			<span>
				<label>
					{'Status'|@translate}
					<select name="concours_status">
						<option value="all" label="------------">------------</option>
						<option value="active" label="{'active_concours'|@translate}" {if $concours_filter.status=='active'}selected="selected"{/if}>{'active_concours'|@translate}</option>
						<option value="prepared" label="{'prepared_concours'|@translate}" {if $concours_filter.status=='prepared'}selected="selected"{/if}>{'prepared_concours'|@translate}</option>
						<option value="closed" label="{'closed_concours'|@translate}" {if $concours_filter.status=='closed'}selected="selected"{/if}>{'closed_concours'|@translate}</option>
						<option value="closed-noresult" label="{'closed-noresult_concours'|@translate}" {if $concours_filter.status=='closed-noresult'}selected="selected"{/if}>{'closed_concours'|@translate}</option>
					</select>
				</label>
			</span>
			<span>
				<label>
					{'Sort by'|@translate}
					<select name="concours_sort_by">
						<option value="default" label="------------">------------</option>
						<option value="id" label="{'concours_id2'|@translate}" {if $concours_filter.sort_by=='id'}selected="selected"{/if}>{'concours_id2'|@translate}</option>
						<option value="name" label="{'concours_name'|@translate}" {if $concours_filter.sort_by=='name'}selected="selected"{/if}>{'concours_name'|@translate}</option>
						<option value="create_date" label="{'concours_create_date'|@translate}" {if $concours_filter.sort_by=='create_date'}selected="selected"{/if}>{'concours_create_date'|@translate}</option>
						<option value="begin_date" label="{'concours_begin_date'|@translate}" {if $concours_filter.sort_by=='begin_date'}selected="selected"{/if}>{'concours_begin_date'|@translate}</option>
						<option value="end_date" label="{'concours_end_date'|@translate}" {if $concours_filter.sort_by=='end_date'}selected="selected"{/if}>{'concours_end_date'|@translate}</option>
					</select>
				</label>
			</span>		
			<span>
				<label>
					{'Sort order'|@translate}
					<select name="concours_sort_order">
						<option value="asc" label="{'ascending'|@translate}" {if $concours_filter.sort_order=='asc'}selected="selected"{/if}>{'ascending'|@translate}</option>
						<option value="desc" label="{'descending'|@translate}" {if $concours_filter.sort_order=='desc'}selected="selected"{/if}>{'descending'|@translate}</option>
					</select>
				</label>
			</span>
			<span>
				<label>
					{'concours_nb_concours_page'|@translate}
					<input type="text" maxlength="3" size="3" name="concours_nb_concours_page" id="concours_nb_concours_page" value="{$concours_nb_concours_page}" />
				</label>
			</span>
			<span>
				<label>
					&nbsp;
					<input type="submit" name="concours_form_filter_submit" value="{'Submit'|@translate}" />
				</label>
			</span>
			<span>
				<div>
					<img src="{$IMG_URL}prepared-0.png"  width="20"/>&nbsp;{if $concours_filter.status=='prepared'}<b>{'prepared_concours'|@translate}</b>&nbsp;{else}{'prepared_concours'|@translate}&nbsp;{/if}
					<img src="{$IMG_URL}actived-1.png"  width="20"/> {if $concours_filter.status=='active'}<b>{'active_concours'|@translate}&nbsp;</b>{else}{'active_concours'|@translate}&nbsp;{/if}
					<img src="{$IMG_URL}closed-2.png"  width="20" /> {if $concours_filter.status=='closed' or $concours_filter.status=='closed-noresult'}<b>{'closed_concours'|@translate}&nbsp;</b>{else}{'closed_concours'|@translate}&nbsp;{/if}
				</div>
			</span>
		</form>
	</fieldset>
	{if count($concours_list)}
		<form method="post" id="concours_form_delete">
			<table class="table2" width="97%">
				<thead>
					<tr class="throw">
						<td>&nbsp;</td>
						<td>{'concours_status'|@translate}</td>
						<td>{'concours_id2'|@translate}</td>
						<td>{'concours_name'|@translate}</td>
						<td>{'concours_descr'|@translate}</td>
						<td>{'concours_create_date'|@translate}</td>
						<td>{'concours_begin_date'|@translate}</td>
						<td>{'concours_end_date'|@translate}</td>
						<td style="width:150px">{'concours_actions'|@translate}</td>
{******
						<td style="width:80px">>{'concours_podium'|@translate}</td>
******}
						<td style="width:80px"><img src="{$IMG_URL}trophee-1.png" width="20" ><img src="{$IMG_URL}trophee-2.png" width="20"><img src="{$IMG_URL}trophee-3.png" width="20"></td>
					</tr>
				</thead>
				<tbody>
					{foreach from=$concours_list item=concours_list1 name=foreach_concours_list1}
						{if $smarty.foreach.foreach_concours_list1.iteration is even}
							<tr class="row1">
						{else}	
							<tr class="row2">
						{/if}
							<td><input type="checkbox" name="concours_to_delete[]" value="{$concours_list1.ID}"></td>
							<td align=center><img src="{$IMG_URL}prepared-{$concours_list1.STATUS1}.png" {if $concours_list1.STATUS1 == 0}width="35"{else}width="27"{/if} />
							<img src="{$IMG_URL}actived-{$concours_list1.STATUS1}.png" {if $concours_list1.STATUS1 == 1}width="35"{else}width="27"{/if}/>
							<img src="{$IMG_URL}closed-{$concours_list1.STATUS1}.png"  {if $concours_list1.STATUS1 == 2}width="35"{else}width="27"{/if}  /></td>		
							<td>{$concours_list1.ID}</td>		
							<td>{if $concours_list1.STATUS1}<a href="{$concours_list1.U_AUDIT}" target="_blank" title="{'concours_audit1'|@translate}">{$concours_list1.NAME}</a>
								{else}{$concours_list1.NAME} 
								{/if}
								<br>[{'concours_nbphotos'|@translate}: <b>{$concours_list1.NBIMG}</b> / <i>{'concours_nbscore'|@translate}: <b>{$concours_list1.NB_VOTE}</b></i>]</td>		
							<td>{$concours_list1.DESC}</td>		
							<td>{$concours_list1.CREATE_DATE}</td>		
							<td>{$concours_list1.BEGIN_DATE}</td>		
							<td>{$concours_list1.END_DATE}</td>		
							<td>
								<a href="{$concours_list1.U_EDIT}" title="{'concours_edit'|@translate}"><img src="{$themeconf.admin_icon_dir}/category_edit.png" class="button" alt="{'concours_edit'|@translate}"/></a>
							{if $concours_list1.STATUS1 == 2} 
								{if $concours_list1.U_RESULT != ''}<a href="{$concours_list1.U_RESULT}" title="{'concours_result'|@translate}"><img src="{$IMG_URL}generate-1.png" width="30" class="button" alt="{'concours_result'|@translate}" /></a>{else}<img src="{$IMG_URL}generate-0.png" width="30" class="button" alt="{'concours_result'|@translate}" />{/if}
								{if $concours_list1.U_FILE != ''}<a href="{$concours_list1.U_FILE}" title="{'concours_file'|@translate}"><img src="{$IMG_URL}file-1.png" width="30" class="button" alt="{'concours_file'|@translate}" /></a>{else}<img src="{$IMG_URL}file-0.png" width="30" class="button" alt="{'concours_file'|@translate}" />{/if}
							{else}
							<img src="{$IMG_URL}generate-0.png" width="30" class="button" alt="{'concours_file'|@translate}" />
							<img src="{$IMG_URL}file-0.png" width="30" class="button" alt="{'concours_file'|@translate}" />
							{/if}
								<a href="{$concours_list1.U_DELETE}" title="{'concours_delete'|@translate}" onclick="return confirm('{'Are you sure?'|@translate|@escape:javascript}');"><img src="{$themeconf.admin_icon_dir}/category_delete.png" class="button" alt="{'concours_delete'|@translate}" /></a>
							</td>
							<td align="center"> 
								<a href="{$concours_list1.U_PODIUM}" title="{if $concours_list1.SHOWPODIUM==1}{'concours_podium'|@translate}{else}{'concours_nopodium'|@translate}{/if}"><img src="{$IMG_URL}trophee{if $concours_list1.SHOWPODIUM==1}OK{else}KO{/if}.png" width="20" class="button" alt="{if $concours_list1.SHOWPODIUM==1}{'concours_podium'|@translate}{else}{'concours_nopodium'|@translate}{/if}" /></a> </td>		
						</tr>
					{/foreach}
				</tbody>
			</table>
			{if !empty($navbar)}{include file='navigation_bar.tpl'|@get_extent:'navbar'}{/if}
			<fieldset>
				<legend>{'concours_delete_selected'|@translate}</legend>
				<div class="concours_line">
					<span><input type="checkbox" name="concours_delete_closed" id="concours_delete_closed" value="1"></span>
					<span><label for="concours_delete_closed">{'concours_delete_all_closed'|@translate}</label></span>
				</div>
				<div class="concours_last_line">
					<span><input type="checkbox" name="concours_to_delete_sure" id="concours_to_delete_sure" value="1"></span>
					<span><label for="concours_to_delete_sure">{'Are you sure?'|@translate}</label></span>
					<span><input type="submit" name="delete_selected_submit" value="{'concours_delete'|@translate}" /></span>
				</div>
			</fieldset>
		</form>
	{else}
		<fieldset>
			<div class="concours_no_concours">
				<b>{$no_concours}</b>
			</div>
		</fieldset>
	{/if}


	
