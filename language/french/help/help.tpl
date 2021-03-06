<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl 'modules/xoocontact/assets/css/help.css'}>">

<div class="help txtcenter">
    <div class="help-submenu floatright txtleft">
        <ul>
            <li><a href="#description" title=""><{$smarty.const._HELP_DESCRIPTION_TITLE}></a></li>
            <li><a href="#developer" title=""><{$smarty.const._HELP_DEVELOPER_TITLE}></a></li>
            <li><a href="#install" title=""><{$smarty.const._HELP_INSTALL_TITLE}></a></li>
            <!--
                        <li><a href="#uninstall" title=""><{$smarty.const._HELP_UNINSTALL_TITLE}></a></li>
            -->
            <li><a href="#tutorial" title=""><{$smarty.const._HELP_TUTORIAL_TITLE}></a></li>
        </ul>
    </div>

    <div class="floatleft">
        <img src="<{$xoops_url}>/modules/<{$module->getVar('dirname')}>/<{$module->getInfo('image')}>" alt="<{$module->getVar('name')}>" title="<{$module->getVar('name')}>">
    </div>

    <div class="help-title floaleft">
        <h2><{$module->getVar('name')}></h2>
        <{if $module->getInfo('paypal')}>
            <form class="help-paypal" id="paypal-form" name="_xclick" action="https://www.paypal.com/fr/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <{foreach from=$module->getInfo('paypal') item=value key=key}>
                    <{if is_numeric($value)}>
                        <input type="hidden" name="<{$key}>" value="<{$value}>">
                    <{else}>
                        <input type="hidden" name="<{$key}>" value="<{$value}>">
                    <{/if}>
                <{/foreach}>
                <img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" onclick="$('#paypal-form').submit()" alt="PayPal - The safer, easier way to pay online!">
            </form>
        <{/if}>
    </div>
</div>
<div class="clear"></div>

<a name="description"></a>
<div class="help-item">
    <div class="help-title">
        <{$smarty.const._HELP_DESCRIPTION_TITLE}>
    </div>
    <div>
        <{$module->getInfo('description')}>
        <br>
        Version : <{$module->getInfo('version')}>&nbsp;<{$module->getInfo('module_status')}>&nbsp;(<{$module->getInfo('release_date')}>)
    </div>
</div>

<a name="Developer"></a>
<div class="help-item">
    <div class="help-title">
        <{$smarty.const._HELP_DEVELOPER_TITLE}>
    </div>
    <{if $module->getInfo('module_website_url')}>
        <div class="spacer marg5">
            <a href="http://<{$module->getInfo('module_website_url')}>" rel="external" title=""><{$module->getInfo('module_website_name')}></a>
        </div>
    <{/if}>
</div>

<a name="install"></a>
<div class="help-item">
    <div class="help-title">
        <{$smarty.const._HELP_INSTALL_TITLE}>
    </div>
    <div>
        <{$smarty.const._HELP_INSTALL_CONTENT}>
    </div>
</div>

<!--
<a name="uninstall"></a>
<div class="help-item">
    <div class="help-title">
        <{$smarty.const._HELP_UNINSTALL_TITLE}>
    </div>
    <div>
        <{$smarty.const._HELP_UNINSTALL_CONTENT}>
    </div>
</div>
-->

<a name="tutorial"></a>
<div class="help-item">
    <div class="help-title">
        <{$smarty.const._HELP_TUTORIAL_TITLE}>
    </div>
    <div>
        <{$smarty.const._HELP_TUTORIAL_CONTENT}>
    </div>
</div>
