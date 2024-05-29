{combine_css id="ed" path=$EXTENDED_DESC_PATH|cat:'template/admin/style.css'}
{combine_script id="ed" require="jquery" load="async" path=$EXTENDED_DESC_PATH|cat:'template/admin/script.js'}

<div id="configContent">
{if !isset($EXTDESC_HELP)}
  <fieldset class="mainConf">
    <legend>{'Documentation'|translate}</legend>
    <ul>
      <li><a href="{$EXTDESC_ADMIN}-lang">{$EXTDESC_TITLES.lang}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-extdesc">{$EXTDESC_TITLES.extdesc}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-cat_photo">{$EXTDESC_TITLES.cat_photo}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-slider">{$EXTDESC_TITLES.slider}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-hide">{$EXTDESC_TITLES.hide}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-redirect">{$EXTDESC_TITLES.redirect}</a></li>
      <li><a href="{$EXTDESC_ADMIN}-logged">{$EXTDESC_TITLES.logged}</a></li>
    </ul>
  </fieldset>

{else}
  <h2>ExtendedDescription</h2>
  
  <p style="text-align:left;margin-left:1em;">
    <a href="{$EXTDESC_ADMIN}"><- {'Back'|translate}</a>
  </p>
  
  <fieldset class="mainConf">
    <legend>{$EXTDESC_TITLES[$EXTDESC_PAGE]}</legend>
    {$EXTDESC_HELP}
  </fieldset>
{/if}
</div>