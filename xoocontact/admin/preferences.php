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

include __DIR__ . '/header.php';

switch ($op) {
    case 'save':
        if (!$xoops->security()->check()) {
            $xoops->redirect('preferences.php', 3, implode('<br />', $xoops->security()->getErrors()));
        }

        $xoocontact_welcome     = Xoops\Core\Request::getString('xoocontact_welcome', '', 'POST');
        $xoocontact_copymessage = Xoops\Core\Request::getInt('xoocontact_copymessage', 0, 'POST');

        // Write configuration file
        $object = XooContactPreferences::getInstance();
        $object->writeConfig($object->Prepare2Save());
        $xoops->redirect('preferences.php', 3, _XOO_CONFIG_SAVED);
        break;

    default:
        $form = $contact_module->getForm($contact_config, 'preferences');
        $form->display();
}
include __DIR__ . '/footer.php';
