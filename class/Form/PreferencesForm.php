<?php

namespace XoopsModules\Xoocontact\Form;

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
use XoopsModules\Xoocontact;

/**
 * Class PreferencesForm
 * @package XoopsModules\Xoocontact\Form
 */
class PreferencesForm extends \Xoops\Form\ThemeForm
{
    /**
     * @param string|array $config
     *
     * @internal param null $obj
     */
    public function __construct($config)
    {
        extract($config);
        parent::__construct('', 'form_preferences', 'preferences.php', 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        $tabTray = new \Xoops\Form\TabTray('', 'uniqueid');

        $xoocontact_welcome = Request::getString('xoocontact_welcome', '', 'POST');
        $xoocontact_copymessage = Request::getInt('xoocontact_copymessage', 0, 'POST');

        /**
         * Main page
         */
        //welcome
        $tab1 = new \Xoops\Form\Tab(_XOO_CONFIG_MAINPAGE, 'tabid-1');

        //xoocontact_welcome
        $tab1->addElement(new \Xoops\Form\TextArea(_XOO_CONFIG_MESSAGE, 'xoocontact_welcome', $xoocontact_welcome, 12, 12));

        //xoocontact_main
        $tab1->addElement(new \Xoops\Form\RadioYesNo(_XOO_CONFIG_COPYMESSAGE, 'xoocontact_copymessage', $xoocontact_copymessage));

        $tabTray->addElement($tab1);
        $this->addElement($tabTray);

        /**
         * Buttons
         */
        $buttonTray = new \Xoops\Form\ElementTray('', '');
        $buttonTray->addElement(new \Xoops\Form\Hidden('op', 'save'));

        $buttonSubmit = new \Xoops\Form\Button('', 'submit', \XoopsLocale::A_SUBMIT, 'submit');
        $buttonSubmit->setClass('btn btn-success');
        $buttonTray->addElement($buttonSubmit);

        $buttonReset = new \Xoops\Form\Button('', 'reset', \XoopsLocale::A_RESET, 'reset');
        $buttonReset->setClass('btn btn-warning');
        $buttonTray->addElement($buttonReset);

        $buttonCancel = new \Xoops\Form\Button('', 'cancel', \XoopsLocale::A_CANCEL, 'button');
        $buttonCancel->setExtra("onclick='javascript:history.go(-1);'");
        $buttonCancel->setClass('btn btn-danger');
        $buttonTray->addElement($buttonCancel);

        $this->addElement($buttonTray);
    }
}
