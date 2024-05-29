{combine_css id="ed" path=$EXTENDED_DESC_PATH|cat:'template/admin/style.css'}
{combine_script id="ed" require="jquery" load="async" path=$EXTENDED_DESC_PATH|cat:'template/admin/script.js'}

<div id="configContent">
  <fieldset class="mainConf">
    <legend>{$EXTDESC_TITLES[$EXTDESC_PAGE]}</legend>
    {$EXTDESC_HELP}
  </fieldset>
</div>