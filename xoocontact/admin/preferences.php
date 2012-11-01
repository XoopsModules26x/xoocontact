<?php
/**
 * Xooghost module
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
 * @package         Xooghost
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

include dirname(__FILE__) . '/header.php';

$admin_page = new XoopsModuleAdmin();
$admin_page->renderNavigation( basename($_SERVER['SCRIPT_NAME']) );

switch ($op) {
    if (!$xoops->security->check()) {
        $xoops->redirect("preferences.php", 3, implode('<br />', $xoops->security->getErrors()));
    }

    $xoocontact_welcome     = $system->CleanVars($_POST, 'xoocontact_welcome', '', 'string');
    $xoocontact_copymessage = $system->CleanVars($_POST, 'xoocontact_copymessage', 0, 'int');

    // Write configuration file
    include_once dirname( dirname ( __FILE__ ) ) . '/class/xoopreferences.php';
    $object = new XooPreferences();
    foreach ( array_keys($_POST) as $k) {
    $object->writeConfig( $config );
    $xoops->redirect("preferences.php", 3, _AM_XOO_CONTACT_SAVED);
    break;

    $form = $xoops->getModuleForm(null, 'preferences', 'xoocontact');
    $form->PreferencesForm();
    $form->render();
}
include dirname(__FILE__) . '/footer.php';
?>