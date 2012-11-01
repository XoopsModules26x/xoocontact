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
 * @package         Xoocontact
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XoocontactContactForm extends XoopsThemeForm

{
    /**
     * @param null $obj
     */
    public function __construct()
    {    }

    /**
     * Maintenance Form
     * @return void
     */
    public function ContactForm()
    {        global $xoops, $xoocontact_handler;

        include_once dirname(dirname ( __FILE__ )) . '/xoopreferences.php';
        $config = new XooPreferences();
        $xooContact_config = $config->config;

        parent::__construct('', "xoocontact_form", "index.php", 'post', true, 'horizontal');

        $fields = $xoocontact_handler->getDisplay();
        foreach ($fields as $k => $field) {
            $ele = $this->getForm( $field );
            if ( is_object( $ele ) && (is_subclass_of($ele, 'XoopsFormElement') || is_subclass_of($ele, 'XoopsFormTextArea'))) {                $this->addElement( $ele, $field->getVar('xoocontact_required') );
            }
        }

        if ( $xooContact_config['xoocontact_copymessage']) {
            $this->addElement( new XoopsFormRadioYN(_XOO_CONTACT_COPYMESSAGE, 'message_copy', 0), true );
        }

        $this->addElement( new XoopsFormCaptcha(null,null,false), true );

        $button_tray = new XoopsFormElementTray('&nbsp;', '&nbsp;');
        $button_tray->addElement(new XoopsFormHidden('op', 'submit'));
        $button_tray->addElement(new XoopsFormButton('', '', _XOO_CONTACT_SUBMIT, 'submit'));
        $this->addElement($button_tray);
    }

    public function getForm( $fieldObj )
    {
        global $xoops, $system, $xooContact_config;
        $myts = MyTextSanitizer::getInstance();

        $ele = '';

        $title = $fieldObj->getVar('xoocontact_description');
        $field = 'xoocontact_field' . $fieldObj->getVar('xoocontact_id');
        $value = $system->cleanVars($_POST, $field, $fieldObj->getVar('xoocontact_default'), $fieldObj->getVar('xoocontact_valuetype'));

        switch ($fieldObj->getVar('xoocontact_formtype')) {
            case 'textbox':
            $ele = new XoopsFormText($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
            break;

            case 'mail':
            $ele = new XoopsFormMail($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
            break;

            case 'url':
            $ele = new XoopsFormUrl($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
            break;

            case 'textarea':
            $ele = new XoopsFormTextArea($title, $field, $value, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'));
            break;

            case 'dhtmltextarea':
            $ele = new XoopsFormDhtmlTextArea($title, $field, $value, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'));
            break;

            case 'editor':
            $editor_configs=array();
            $editor_configs['name'] = $field;
            $editor_configs['value'] = $value;
            $editor_configs['rows'] = 3;
            $editor_configs['cols'] = 100;
            $editor_configs['width'] = '80%';
            $editor_configs['height'] = '500px';
            $editor_configs['editor'] = $xooContact_config['xoocontact_editor'];
            $ele = new XoopsFormEditor($title, $field, $editor_configs);
            break;

            case 'select':
            $options = unserialize( $fieldObj->getVar('xoocontact_value','n') );
            $ele = new XoopsFormSelect($title, $field, $value);
            $ele->addOptionArray($options);
            break;

            case 'select_multi':
            $options = unserialize( $fieldObj->getVar('xoocontact_value','n') );
            $ele = new XoopsFormSelect($title, $field, $value, count($options), true);
            $ele->addOptionArray($options);
            break;

            case 'radio':
            $ele = new XoopsFormRadio($title, $field, $value);
            $options = unserialize( $fieldObj->getVar('xoocontact_value','n') );
            $ele->addOptionArray($options);
            break;

            case 'yesno':
            $ele = new XoopsFormRadioYN($title, $field, $value, _YES, _NO);
            break;

            case 'hidden':
            $ele = new XoopsFormHidden( $field, $myts->htmlspecialchars( $fieldObj->getVar('xoocontact_value','e') ) );
            break;

            case 'line_break':
            $fieldObj->insertBreak('<center>' . $title . '</center>','');
            break;
        }
        return $ele;
    }
}
?>