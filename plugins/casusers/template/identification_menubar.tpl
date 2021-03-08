{if $id == "mbIdentification" and isset($U_LOGIN)}
    {html_style}
    dl#mbIdentification dd:first-of-type { padding-bottom:0 !important; }
    #mbIdentification .casu { margin:0 1px; }
    input.casu { background: url("{$casu_conf.casu_logo}"); background-repeat: no-repeat; background-size: contain;  background-position: center; width: 200px ; height: 64px ; border: none;}
    legend.casu { font-size: 12px; }
    {/html_style}

    <dd>
        <form id="quickconnect" method="get" action="{$U_LOGIN}">
            <fieldset style="text-align:center;">
                <legend class="casu">{'CAS Simple Auth'|translate}</legend>
                {strip}
                    <input type="hidden" name="redirect" value="{$smarty.server.REQUEST_URI|@urlencode}">
                    <input type="submit" name="authCASU" class="casu" value="" />
                {/strip}
            </fieldset>
        </form>
    </dd>
{/if}