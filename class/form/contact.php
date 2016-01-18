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
 */

use Xoops\Core\Request;

/**
 * Class XoocontactContactForm
 */
class XoocontactContactForm extends Xoops\Form\ThemeForm

{
    /**
     * @internal param null $obj
     */
    public function __construct()
    {
    }

    /**
     * Maintenance Form
     *
     * @return void
     */
    public function contactForm()
    {
        $contactModule  = XooContact::getInstance();
        $contactConfig  = $contactModule->loadConfig();
        $contactHandler = $contactModule->contactHandler();

        parent::__construct('', 'xoocontact_form', 'index.php', 'post', true, 'horizontal');

        $fields = $contactHandler->getDisplay();
        foreach ($fields as $k => $field) {
            $ele = $this->getForm($field);
            if (is_object($ele) && (is_subclass_of($ele, 'Xoops\Form\Element') || is_subclass_of($ele, 'Xoops\Form\TextArea'))) {
                $this->addElement($ele, $field->getVar('xoocontact_required'));
            }
        }

        if ($contactConfig['xoocontact_copymessage']) {
            $this->addElement(new Xoops\Form\RadioYesNo(_XOO_CONTACT_COPYMESSAGE, 'message_copy', 0), true);
        }

        $this->addElement(new Xoops\Form\Captcha(null, null, false), true);

        $buttonTray = new Xoops\Form\ElementTray('&nbsp;', '&nbsp;');
        $buttonTray->addElement(new Xoops\Form\Hidden('op', 'submit'));
        $buttonTray->addElement(new Xoops\Form\Button('', '', _XOO_CONTACT_SUBMIT, 'submit'));
        $this->addElement($buttonTray);
    }

    /**
     * @param $fieldObj
     *
     * @return string|\Xoops\Form\DhtmlTextArea|\Xoops\Form\Editor|\Xoops\Form\Mail|\Xoops\Form\Text|\Xoops\Form\TextArea|\Xoops\Form\Url
     */
    public function getForm($fieldObj)
    {
        $system          = System::getInstance();
        $contactModule  = XooContact::getInstance();
        $contactConfig  = $contactModule->loadConfig();
        $contactHandler = $contactModule->contactHandler();

        $myts = MyTextSanitizer::getInstance();

        $ele = '';

        $title = $fieldObj->getVar('xoocontact_description');
        $field = 'xoocontact_field' . $fieldObj->getVar('xoocontact_id');
//        $value = $system->cleanVars($_POST, $field, $fieldObj->getVar('xoocontact_default'), $fieldObj->getVar('xoocontact_valuetype'));
        $value = Request::getVar($field, $fieldObj->getVar('xoocontact_default'), 'POST', $fieldObj->getVar('xoocontact_valuetype'));

        switch ($fieldObj->getVar('xoocontact_formtype')) {
            case 'textbox':
                $ele = new Xoops\Form\Text($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
                break;

            case 'mail':
                $ele = new Xoops\Form\Mail($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
                break;

            case 'url':
                $ele = new Xoops\Form\Url($title, $field, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'), $value);
                break;

            case 'textarea':
                $ele = new Xoops\Form\TextArea($title, $field, $value, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'));
                break;

            case 'dhtmltextarea':
                $ele = new Xoops\Form\DhtmlTextArea($title, $field, $value, $fieldObj->getVar('xoocontact_min_width'), $fieldObj->getVar('xoocontact_max_width'));
                break;

            case 'editor':
                $editorConfigs           = array();
                $editorConfigs['name']   = $field;
                $editorConfigs['value']  = $value;
                $editorConfigs['rows']   = 3;
                $editorConfigs['cols']   = 100;
                $editorConfigs['width']  = '80%';
                $editorConfigs['height'] = '500px';
                $editorConfigs['editor'] = $contactConfig['xoocontact_editor'];
                $ele                      = new Xoops\Form\Editor($title, $field, $editorConfigs);
                break;

            case 'select':
                $options = unserialize($fieldObj->getVar('xoocontact_value', 'n'));
                $ele     = new Xoops\Form\Select($title, $field, $value);
                $ele->addOptionArray($options);
                break;

            case 'select_multi':
                $options = unserialize($fieldObj->getVar('xoocontact_value', 'n'));
                $ele     = new Xoops\Form\Select($title, $field, $value, count($options), true);
                $ele->addOptionArray($options);
                break;

            case 'radio':
                $ele     = new Xoops\Form\Radio($title, $field, $value);
                $options = unserialize($fieldObj->getVar('xoocontact_value', 'n'));
                $ele->addOptionArray($options);
                break;

            case 'yesno':
                $ele = new Xoops\Form\RadioYesNo($title, $field, $value, XoopsLocale::YES, XoopsLocale::NO);
                break;

            case 'hidden':
                $ele = new Xoops\Form\Hidden($field, $myts->htmlSpecialChars($fieldObj->getVar('xoocontact_value', 'e')));
                break;

            case 'line_break':
                $fieldObj->insertBreak('<div style=\'text-align: center;\'>' . $title . '</div>', '');
                break;
        }

        return $ele;
    }
}
