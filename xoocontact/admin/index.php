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
 * @version         $Id$
 */

include dirname(__FILE__) . '/header.php';

// Get xoocontact_fields handler & datas
$xoocontact_handler = $xoops->getModuleHandler('xoocontact', 'xoocontact');

switch ($op) {    case 'view':
    $field = $xoocontact_handler->get($xoocontact_id);
    $field->setView();
    $xoocontact_handler->insert($field);
    $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
    break;

    case 'hide':
    $field = $xoocontact_handler->get($xoocontact_id);
    $field->setHide();
    $xoocontact_handler->insert($field);
    $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
    break;

    case 'req':
    $field = $xoocontact_handler->get($xoocontact_id);
    $field->setRequired();
    $xoocontact_handler->insert($field);
    $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
    break;

    case 'notreq':
    $field = $xoocontact_handler->get($xoocontact_id);
    $field->setNotRequired();
    $xoocontact_handler->insert($field);
    $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
    break;

    default:    // heaser
    $xoops->header();
    $xoops->theme->addStylesheet('modules/xoocontact/css/moduladmin.css');

    // Get xoocontact_fields handler & datas
    $xoocontact_handler = $xoops->getModuleHandler('xoocontact', 'xoocontact');
    $fields = $xoocontact_handler->renderAdminList();
    $xoops->tpl->assign('fields', $fields);

    $admin_page = new XoopsModuleAdmin();

    $admin_page->addInfoBox(_AM_XOO_CONTACT_MANAGER);
    $admin_page->addInfoBoxLine( $xoops->tpl->fetch('db:xoocontact_fields_manager.html') );

    $admin_page->renderNavigation('index.php');
    $admin_page->renderIndex();
    $xoops->footer();
    break;
}
?>