<!-- Show the title of the plugin -->
<div class="titlePage">
    <h2>{'CASU Simple Auth'|@translate}</h2>
</div>

<!-- Show content in a nice box -->
<form method="post" action="" class="properties">
 
    <fieldset id="commentsConf">
        <ul>
            <li>
                <label>Full Hostname of your CAS Server : <input type="text" name="casu_host" value="{$casu_host}"></label>
            </li>
            <li>
                <label>Context of the CAS Server : <input type="text" name="casu_context" value="{$casu_context}"></label>
            </li>
            <li>
                <label>Port of your CAS server. Normally for a https server it's 443 : <input type="text" name="casu_port" value="{$casu_port}"></label>
            </li>
            <li>
                <label>Image for the connexion menu (url, relative to the piwigo root) : <input type="text" name="casu_logo" value="{$casu_logo}"></label>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="casu_ssl" {if $casu_ssl}checked="checked"{/if}>
                    <b>{' For quick testing you can disable SSL validation of the CAS server. THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION. VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!'|translate}</b>
                </label>
            </li>
            <li>
                <label>Path to the ca chain that issued the cas server certificate : <input type="text" name="casu_ca" value="{$casu_ca}"></label>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <ul>
            <li><label>Login attribute : <input type="text" name="casu_login" value="{$casu_login}"></label></li>
            <li>Groups : 
                <ul>
                    {foreach from=$casu_groups key=group item=regexp}
                        <li><label>attr : <input type="text" name="casu_groups[{$group}][name]" value="{$group}"</label>  <label>Processing : <input type="text" name="casu_groups[{$group}][regexp]" value="{$regexp}"</label></li> 
                    {/foreach}
                    <li><label>attr : <input type="text" name="casu_groups[new][name]" value=""</label>  <label>Processing : <input type="text" name="casu_groups[new][regexp]" value=""</label></li> 

                </ul>

            </li>
        </ul>

    <p style="text-align:left;"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>
</form>


</fieldset>