{if !$ed_image.selected_derivative->is_cached()}
{combine_script id='jquery.ajaxmanager' path='themes/default/js/plugins/jquery.ajaxmanager.js' load='footer'}
{combine_script id='thumbnails.loader' path='themes/default/js/thumbnails.loader.js' require='jquery.ajaxmanager' load='footer'}
{/if}

<img {if $ed_image.selected_derivative->is_cached()}src="{$ed_image.selected_derivative->get_url()}" {$ed_image.selected_derivative->get_size_htm()} {else}src="{$ROOT_URL}{$themeconf.img_dir}/ajax-loader-big.gif" data-src="{$ed_image.selected_derivative->get_url()}"{/if} alt="{$ed_image.ALT_IMG}">