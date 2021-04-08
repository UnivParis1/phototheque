{combine_script id='jquery.nivo.slider' path=$EXTENDED_DESC_PATH|cat:'template/nivoslider/jquery.nivo.slider.js' require='jquery' load='footer'}
{combine_css id='nivoslider' path=$EXTENDED_DESC_PATH|cat:'template/nivoslider/nivo-slider.css'}
{combine_css id='nivoslider_theme' path=$EXTENDED_DESC_PATH|cat:'template/nivoslider/default.css'}

{if $SLIDER.control_thumbs}
{html_style}
#slider{$SLIDER.id} .nivo-controlNav.nivo-thumbs-enabled img {ldelim}
  width: {$SLIDER.thumbs_size}px; height: {$SLIDER.thumbs_size}px;
}
{/html_style}
{/if}

{if $SLIDER.elastic}
{assign var=slider_full_height value=0}
{else}
{assign var=slider_full_height value=$SLIDER.img_size.h}
{/if}
{assign var=slider_full_width value=0}

<div id="slider{$SLIDER.id}" class="slider-wrapper theme-default">
  <div class="nivoSlider">
  {foreach from=$SLIDER.elements item=thumbnail name=slider}{strip}
    {assign var=derivative value=$pwg->derivative($SLIDER.derivative_params, $thumbnail.src_image)}
    {if $SLIDER.control_thumbs}{assign var=derivative_thumb value=$pwg->derivative_url($SLIDER.derivative_params_thumb, $thumbnail.src_image)}{/if}
    {if !$derivative->is_cached()}
      {combine_script id='jquery.ajaxmanager' path='themes/default/js/plugins/jquery.ajaxmanager.js' load='footer'}
      {combine_script id='thumbnails.loader' path='themes/default/js/thumbnails.loader.js' require='jquery.ajaxmanager' load='footer'}
    {/if}

    <img {if $derivative->is_cached()}src="{$derivative->get_url()}"{else}src="" data-src="{$derivative->get_url()}"{/if} alt="{$thumbnail.TN_ALT}" {$derivative->get_size_htm()} {if $SLIDER.title}title="<a href='{$thumbnail.URL}'>{$thumbnail.NAME|replace:'"':"'"}</a>"{/if} {if $SLIDER.control_thumbs}data-thumb="{$derivative_thumb}"{/if}>

    {assign var=derivative_size value=$derivative->get_size()}
    {math assign=slider_full_width equation="max(x,y)" x=$slider_full_width y=$derivative_size[0]}
    {if $SLIDER.elastic}
      {math assign=slider_full_height equation="max(x,y)" x=$slider_full_height y=$derivative_size[1]}
    {else}
      {math assign=slider_full_height equation="min(x,y)" x=$slider_full_height y=$derivative_size[1]}
    {/if}
    {if $smarty.foreach.slider.first}
      {assign var=slider_init_width value=$derivative_size[0]}
      {assign var=slider_init_height value=$derivative_size[1]}
    {/if}
  {/strip}
  {/foreach}
  </div>
</div>

{footer_script require='jquery.nivo.slider'}
(function($){ldelim}
  var $slider = $("#slider{$SLIDER.id} .nivoSlider");

  $slider.nivoSlider({ldelim}
    pauseTime: {$SLIDER.speed}*1000,
    animSpeed: {$SLIDER.speed}*1000/6,
    effect: '{$SLIDER.effect}',
    directionNav: {if $SLIDER.arrows}true{else}false{/if},{*intval($SLIDER.arrows)*}
    controlNav: {if $SLIDER.control}true{else}false{/if},{*intval($SLIDER.control)*}
    controlNavThumbs: {if $SLIDER.control_thumbs}true{else}false{/if},{*intval($SLIDER.control_thumbs)*}
    beforeChange: function() {ldelim}
      if ($slider.data('nivo:vars').currentImage.attr('src') == "") {ldelim}
        return false;
      }
      {if $SLIDER.elastic}
      $slider.css({ldelim} height: 'auto' });
      {/if}
    }
  });

  $slider.parent().css({ldelim}
    height: {$slider_full_height}{if $SLIDER.control_thumbs}+20+{$SLIDER.thumbs_size}{elseif $SLIDER.control}+40{/if},
    width: {$slider_full_width}
  });
  $slider.css({ldelim}
    height: {if $SLIDER.elastic}{$slider_init_height}{else}{$slider_full_height}{/if},
    width: {$slider_init_width}
  });
}(jQuery));
{/footer_script}