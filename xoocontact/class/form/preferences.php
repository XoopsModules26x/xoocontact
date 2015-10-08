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
class XoocontactPreferencesForm extends Xoops\Form\ThemeForm
{
    /**
     * @param string $config
     *
     * @internal param null $obj
     */
    public function __construct($config)
    {
        extract($config);
        parent::__construct('', 'form_preferences', 'preferences.php', 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        $tabtray = new Xoops\Form\TabTray('', 'uniqueid');

        /**
         * Main page
         */
        //welcome
        $tab1 = new Xoops\Form\Tab(_XOO_CONFIG_MAINPAGE, 'tabid-1');

        //xoocontact_welcome
        $tab1->addElement(new Xoops\Form\TextArea(_XOO_CONFIG_MESSAGE, 'xoocontact_welcome', $xoocontact_welcome, 12, 12));

        //xoocontact_main
        $tab1->addElement(new Xoops\Form\RadioYesNo(_XOO_CONFIG_COPYMESSAGE, 'xoocontact_copymessage', $xoocontact_copymessage));

        $tabtray->addElement($tab1);
        $this->addElement($tabtray);

        /**
         * Buttons
         */
        $button_tray = new Xoops\Form\ElementTray('', '');
        $button_tray->addElement(new Xoops\Form\Hidden('op', 'save'));

        $button = new Xoops\Form\Button('', 'submit', XoopsLocale::A_SUBMIT, 'submit');
        $button->setClass('btn btn-success');
        $button_tray->addElement($button);

        $button_2 = new Xoops\Form\Button('', 'reset', XoopsLocale::A_RESET, 'reset');
        $button_2->setClass('btn btn-warning');
        $button_tray->addElement($button_2);

        $button_3 = new Xoops\Form\Button('', 'cancel', XoopsLocale::A_CANCEL, 'button');
        $button_3->setExtra("onclick='javascript:history.go(-1);'");
        $button_3->setClass('btn btn-danger');
        $button_tray->addElement($button_3);

        $this->addElement($button_tray);
    }
}
