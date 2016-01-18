<{include file="admin:system/admin_navigation.tpl"}>
<{include file="admin:system/admin_tips.tpl"}>
<{include file="admin:system/admin_buttons.tpl"}>

<table class="outer">
    <thead>
    <tr>
        <th class="txtcenter"><{$smarty.const._AM_XOO_CONTACT_FIELD_NAME}> / <{$smarty.const._AM_XOO_CONTACT_FIELD_VALUE}></th>
        <th class="txtcenter"><{$smarty.const._AM_XOO_CONTACT_DESCRIPTION}></th>
        <th class="txtcenter"><{$smarty.const._AM_XOO_CONTACT_VALUE}></th>
        <th class="txtcenter"><{$smarty.const._AM_XOO_CONTACT_REQUIRED}></th>
        <th class="txtcenter"><{$smarty.const._AM_XOO_CONTACT_DISPLAY}></th>
    </tr>
    </thead>

    <{foreach from=$fields item=field}>
        <tr class="<{cycle values="even,odd"}>">
            <td class="txtleft bold">XOOCONTACT_FIELD<{$field.xoocontact_id}> / XOOCONTACT_VALUE<{$field.xoocontact_id}></td>
            <td class="txtleft bold"><{$field.xoocontact_description}></td>

            <td class="txtleft">
                <{if $field.xoocontact_value}>
                    <{foreach from=$field.xoocontact_value item=data name=foo}>
                        <{$data}>
                        <{if $smarty.foreach.foo.last == false}>
                            &nbsp;/&nbsp;
                        <{/if}>
                    <{/foreach}>
                <{/if}>
            </td>

            <td class="txtcenter">
                <{if ( $field.can_be_hidden )}>
                    <{if ( $field.xoocontact_required )}>
                        <a href="index.php?op=notreq&amp;xoocontact_id=<{$field.xoocontact_id}>"
                           title="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"><img src="<{xoImgUrl 'media/xoops/images/icons/16/on.png'}>" alt="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"></a>
                    <{else}>
                        <a href="index.php?op=req&amp;xoocontact_id=<{$field.xoocontact_id}>" title="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"><img src="<{xoImgUrl 'media/xoops/images/icons/16/off.png'}>" alt="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"></a>
                    <{/if}>
                <{else}>
                    <img src="<{xoImgUrl 'media/xoops/images/icons/16/on.png'}>" alt="On">
                <{/if}>

            <td class="txtcenter">
                <{if ( $field.can_be_hidden )}>
                    <{if ( $field.xoocontact_display )}>
                        <a href="index.php?op=hide&amp;xoocontact_id=<{$field.xoocontact_id}>" title="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"><img src="<{xoImgUrl 'media/xoops/images/icons/16/on.png'}>" alt="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"></a>
                    <{else}>
                        <a href="index.php?op=view&amp;xoocontact_id=<{$field.xoocontact_id}>" title="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"><img src="<{xoImgUrl 'media/xoops/images/icons/16/off.png'}>" alt="<{$smarty.const._AM_XOO_CONTACT_VIEW_HIDE}>"></a>
                    <{/if}>
                <{else}>
                    <img src="<{xoImgUrl 'media/xoops/images/icons/16/on.png'}>" alt="On">
                <{/if}>
            </td>
        </tr>
    <{/foreach}>
</table>
