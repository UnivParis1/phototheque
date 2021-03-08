{combine_css path=$SORTORDERS_PATH|@cat:"admin/template/style.css"}

<div class="titlePage">
	<h2>SortOrders</h2>
</div>

<form method="post" action="" class="properties">
<fieldset>
  <legend>{'Active sort orders'|translate}</legend>
  {foreach from=$sort_ids item=ids name=item}
    <label>    
      <input type="checkbox" name="{$ids}" {if !$sortorders.disabled || ! in_array($ids, $sortorders.disabled)}checked="checked"{/if}>
      <b>{$sort_names[$smarty.foreach.item.index]}</b>
    </label>
    <br/>
  {/foreach}  

</fieldset>

<p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>

</form>
