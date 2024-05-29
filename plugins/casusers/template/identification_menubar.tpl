{if $id == "mbIdentification" and isset($U_LOGIN)}
    {html_style}
    dl#mbIdentification dd:first-of-type { padding-bottom:0 !important; }
    #mbIdentification .casu { margin:0 1px; }
    button.casu { center; width: 200px; border: none; margin: 0; padding: 0;}
    img.casu { padding: 0; margin: 0; width: 100%;}
    legend.casu { font-size: 12px; }
    hr.casu { padding: 0.5rem; }
    {/html_style}
    <dd>
        <form id="quickconnect" method="get" action="{$U_LOGIN}">
            <fieldset style="text-align:center;">
                <legend class="casu">{'CAS Simple Auth'|translate}</legend>
                {strip}
                            <input type="hidden" name="redirect" value="{$smarty.server.REQUEST_URI|@urlencode}">
                            <button type="submit" name="authCASU" class="casu" value=""><img class="casu" src="{$casu_conf.casu_logo}" alt="{$casu_conf.casu_logo_alt}" /></button>
                        {if $casu_conf.casu_altaccess}
                            <hr class="casu"/>
                                <button class="casualt" type="submit" name="noCAS" value="noCAS">{$casu_conf.casu_altaccess_text}</button>
                        {/if}
                {/strip}
            </fieldset>
        </form>
    </dd>
{/if}