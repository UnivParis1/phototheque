{footer_script require='jquery'}{literal}
jQuery().ready(function() {
  jQuery("#downloadSizeLink").click(function() {
	  var elt = jQuery("#downloadSizeBox");

    elt.css("left", Math.min( jQuery(this).offset().left, jQuery(window).width() - elt.outerWidth(true) - 5))
      .css("top", jQuery(this).offset().top + jQuery(this).outerHeight(true))
      .toggle();

    return false;
  });

  jQuery("#downloadSizeBox").on("mouseleave click", function() {
    jQuery(this).hide();
  });
});
{/literal}{/footer_script}

{literal}
<style>
.downloadSizeDetails {font-style:italic; font-size:80%;}
</style>
{/literal}

<div id="downloadSizeBox" class="switchBox" style="display:none">
  <div class="switchBoxTitle">{'Download'|@translate} - {'Photo sizes'|@translate}</div>
  {foreach from=$current.unique_derivatives item=derivative key=derivative_type}
  <a href="{$DLSIZE_URL}{$derivative_type}" rel="nofollow">
    {$derivative->get_type()|@translate}<span class="downloadSizeDetails"> ({$derivative->get_size_hr()})</span>
  </a><br>
  {/foreach}
  {if isset($DLSIZE_ORIGINAL)}
  <a href="{$DLSIZE_ORIGINAL}" rel="nofollow">{'Original'|@translate}<span class="downloadSizeDetails"> ({$DLSIZE_ORIGINAL_SIZE_HR})</span></a>
  {/if}
</div>
