<style>
    #xo-header {
        background-color: #fff;
        border-bottom: 2px solid #e96619;
        min-height: 80px;
    }

    #xo-logo {
        float: left;
    }

    #xo-message {
        font-family: "Lucida Grande", Verdana, sans-serif;
        line-height: 1.5em;
        float: left;
        margin-left: 10px;
        vertical-align: center;
    }

    #xo-content {
        clear: both;
        margin: 10px 0;
    }

    #xo-footer {
        border-top: 2px solid #e96619;
    }
</style>
<div id="xo-header">
    <div id="xo-logo">
        <a href="{XOOCONTACT_SITE_URL}" title=""><img src="{XOOCONTACT_SITE_URL}/modules/xoocontact/assets/images/xoocontact_logo.png" alt=""/></a>
    </div>
    <div id="xo-message">
        Bonjour {XOOCONTACT_VALUE1} {XOOCONTACT_VALUE2} {XOOCONTACT_VALUE3},<br/>
        Nous vous remercions de votre intérêt pour notre site <a href="{XOOCONTACT_SITE_URL}" title="">{XOOCONTACT_SITE_NAME}</a>.<br/>
        Votre message a été envoyé à notre webmaster.<br/>
    </div>
</div>
<div id="xo-content">
    <table>
        <tr>
            <td>{XOOCONTACT_FIELD2} - {XOOCONTACT_FIELD3}</td>
            <td> :</td>
            <td>{XOOCONTACT_VALUE1} {XOOCONTACT_VALUE2} {XOOCONTACT_VALUE3}</td>
        </tr>
        <tr>
            <td>{XOOCONTACT_FIELD4}</td>
            <td> :</td>
            <td>{XOOCONTACT_VALUE4}</td>
        </tr>
        <tr>
            <td>{XOOCONTACT_FIELD5}</td>
            <td> :</td>
            <td>{XOOCONTACT_VALUE5}</td>
        </tr>
        <tr>
            <td>{XOOCONTACT_FIELD6}</td>
            <td> :</td>
            <td>{XOOCONTACT_VALUE6}</td>
        </tr>
        <tr>
            <td>{XOOCONTACT_FIELD7}</td>
            <td> :</td>
            <td>{XOOCONTACT_VALUE7}</td>
        </tr>
    </table>
</div>
<div id="xo-footer"></div>
