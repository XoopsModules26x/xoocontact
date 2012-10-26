<?php
/**
 * Xoocontact module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xoocontact
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id: index.php 24 2012-10-15 14:58:15Z Laurent $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class Xoocontact extends XoopsObject
{
    // constructor
	public function __construct()
	{
		$this->initVar('xoocontact_id'           , XOBJ_DTYPE_INT     , 0            , false , 11);
		$this->initVar('xoocontact_description'  , XOBJ_DTYPE_TXTBOX  , ''           , true  , 255);
		$this->initVar('xoocontact_value'        , XOBJ_DTYPE_TXTBOX  , ''           , true  , 255);
		$this->initVar('xoocontact_formtype'     , XOBJ_DTYPE_TXTBOX  , ''           , true  , 15);
		$this->initVar('xoocontact_valuetype'    , XOBJ_DTYPE_TXTBOX  , ''           , true  , 15);
		$this->initVar('xoocontact_default'      , XOBJ_DTYPE_TXTBOX  , ''           , true  , 15);
		$this->initVar('xoocontact_min_width'    , XOBJ_DTYPE_INT     , 1            , true  , 1);
		$this->initVar('xoocontact_max_width'    , XOBJ_DTYPE_INT     , 1            , true  , 1);
		$this->initVar('xoocontact_required'     , XOBJ_DTYPE_INT     , 1            , true  , 1);
		$this->initVar('xoocontact_display'      , XOBJ_DTYPE_INT     , 1            , true  , 1);
		$this->initVar('xoocontact_order'        , XOBJ_DTYPE_INT     , 1            , true  , 3);

        // Pour autoriser le html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

    private function Xoocontact()
    {
        $this->__construct();
    }

    public function setView()
    {
        $this->setVar('xoocontact_display', 1);
        return true;
    }

    public function setHide()
    {        $this->setVar('xoocontact_display', 0);
        return true;
    }

    public function setRequired()
    {
        $this->setVar('xoocontact_required', 1);
        return true;
    }

    public function setNotRequired()
    {
        $this->setVar('xoocontact_required', 0);
        return true;
    }

    public function toArray()
    {        XoopsLoad::load('xoopsload');
        $autoload = XoopsLoad::loadConfig( 'xoocontact' );

        $ret = $this->getValues();
        if (in_array($this->getVar('xoocontact_id'), $autoload['can_be_hidden'])) {            $ret['can_be_hidden'] = false;
        } else {            $ret['can_be_hidden'] = true;
        }

        switch ( $this->getVar('xoocontact_formtype','e') ) {            case 'select':
            $ret['xoocontact_value'] = unserialize( $this->getVar('xoocontact_value','n') );
            break;
            case 'radio':
            $ret['xoocontact_value'] = unserialize( $this->getVar('xoocontact_value','n') );
            break;
        }
        return $ret;
    }

    public function getForm( &$contact_form )
    {        global $xoops, $system;        $myts = MyTextSanitizer::getInstance();

        $ele = '';
        $title = $this->getVar('xoocontact_description');
        $field = 'xoocontact_field' . $this->getVar('xoocontact_id');
        $value = $system->cleanVars($_POST, $field, $this->getVar('xoocontact_default'), $this->getVar('xoocontact_valuetype'));

        switch ($this->getVar('xoocontact_formtype')) {
            case 'textbox':
            $ele = new XoopsFormText($title, $field, $this->getVar('xoocontact_min_width'), $this->getVar('xoocontact_max_width'), $value);
            break;

            case 'mail':
            $ele = new XoopsFormMail($title, $field, $this->getVar('xoocontact_min_width'), $this->getVar('xoocontact_max_width'), $value);
            break;

            case 'url':
            $ele = new XoopsFormUrl($title, $field, $this->getVar('xoocontact_min_width'), $this->getVar('xoocontact_max_width'), $value);
            break;

            case 'textarea':
            $ele = new XoopsFormTextArea($title, $field, $value, $this->getVar('xoocontact_min_width'), $this->getVar('xoocontact_max_width'));
            break;

            case 'dhtmltextarea':
            $ele = new XoopsFormDhtmlTextArea($title, $field, $value, $this->getVar('xoocontact_min_width'), $this->getVar('xoocontact_max_width'));
            break;

            case 'editor':
            $editor_configs=array();
            $editor_configs['name'] = $field;
            $editor_configs['value'] = $value;
            $editor_configs['rows'] = 3;
            $editor_configs['cols'] = 100;
            $editor_configs['width'] = '80%';
            $editor_configs['height'] = '500px';
            $editor_configs['editor'] = $xoops->getModuleConfig('xoocontact_editor', 'xoocontact');
            $ele = new XoopsFormEditor($title, $field, $editor_configs);
            break;

            case 'select':
            $options = unserialize( $this->getVar('xoocontact_value','n') );
            $ele = new XoopsFormSelect($title, $field, $value);
            $ele->addOptionArray($options);
            break;

            case 'select_multi':
            $options = unserialize( $this->getVar('xoocontact_value','n') );
            $ele = new XoopsFormSelect($title, $field, $value, count($options), true);
            $ele->addOptionArray($options);
            break;

            case 'radio':
            $ele = new XoopsFormRadio($title, $field, $value);
            $options = unserialize( $this->getVar('xoocontact_value','n') );
            $ele->addOptionArray($options);
            break;

            case 'yesno':
            $ele = new XoopsFormRadioYN($title, $field, $value, _YES, _NO);
            break;

            case 'hidden':
            $ele = new XoopsFormHidden( $field, $myts->htmlspecialchars( $this->getVar('xoocontact_value','e') ) );
            break;

            case 'line_break':
            $contact_form->insertBreak('<center>' . $title . '</center>','');
            break;
        }

        return $ele;
    }
}

class XoocontactXoocontactHandler extends XoopsPersistableObjectHandler
{
    public function __construct(&$db)
    {
        parent::__construct($db, 'xoocontact_fields', 'Xoocontact', 'xoocontact_id', 'xoocontact_description');
    }

    public function renderAdminList()
    {        $criteria = new CriteriaCompo();
        $criteria->setSort( 'xoocontact_order' );
        $criteria->setOrder( 'asc' );

        return $this->getObjects($criteria, null, false);
    }

    public function getDisplay( $asObject = true )
    {        $criteria = new CriteriaCompo();
        $criteria->add( new Criteria('xoocontact_display', 1) ) ;
        $criteria->setSort( 'xoocontact_order' );
        $criteria->setOrder( 'asc' );

        return $this->getObjects($criteria, true, $asObject);
    }

    public function renderForm()
    {        global $xoops, $xoopsModule;
        $xoops->tpl->assign('test', $xoops->getModuleConfig('xoocontact_message', 'xoocontact') );
        $xoops->theme->addStylesheet('modules/xoocontact/css/module.css');
        $fields = $this->getDisplay();

        $contact_form = new XoopsThemeForm($xoopsModule->name(), 'xoocontact_form', 'index.php', 'post', true, 'horizontal');

        foreach ($fields as $k => $field) {            $ele = $field->getForm( $contact_form );
            if ( is_object( $ele ) && (is_subclass_of($ele, 'XoopsFormElement') || is_subclass_of($ele, 'XoopsFormTextArea'))) {                $contact_form->addElement($ele, $field->getVar('xoocontact_required') );            }        }
        if ( $xoops->getModuleConfig('xoocontact_copymessage', 'xoocontact')) {            $contact_form->addElement( new XoopsFormRadioYN(_XOO_CONTACT_COPYMESSAGE, 'message_copy', 0), true );
        }

        $contact_form->addElement(new XoopsFormCaptcha(null,null,false), true);

        $button_tray = new XoopsFormElementTray('&nbsp;', '&nbsp;');
        $button_tray->addElement(new XoopsFormHidden('op', 'submit'));
        $button_tray->addElement(new XoopsFormButton('', '', _XOO_CONTACT_SUBMIT, 'submit'));
        $contact_form->addElement($button_tray);
        $contact_form->render();
    }
}
?>