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
 */
use XoopsModules\Xoocontact;

include __DIR__ . '/header.php';

switch ($op) {
    case 'view':
        $field = $contactHandler->get($xoocontact_id);
        $field->setView();
        $contactHandler->insert($field);
        $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
        break;
    case 'hide':
        $field = $contactHandler->get($xoocontact_id);
        $field->setHide();
        $contactHandler->insert($field);
        $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
        break;
    case 'req':
        $field = $contactHandler->get($xoocontact_id);
        $field->setRequired();
        $contactHandler->insert($field);
        $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
        break;
    case 'notreq':
        $field = $contactHandler->get($xoocontact_id);
        $field->setNotRequired();
        $contactHandler->insert($field);
        $xoops->redirect('index.php', 5, _AM_XOO_CONTACT_SAVED);
        break;
    default:
        // teaser
        $xoops->header();
        $xoops->theme()->addStylesheet('modules/xoocontact/assets/css/moduladmin.css');

        // Get xoocontact_fields handler & datas
        $fields = $contactHandler->renderAdminList();
        $xoops->tpl()->assign('fields', $fields);

        $admin_page = new \Xoops\Module\Admin();
        $admin_page->displayNavigation('index.php');

        $admin_page->addInfoBox(_AM_XOO_CONTACT_MANAGER);
        $admin_page->addInfoBoxLine($xoops->tpl()->fetch('admin:xoocontact/xoocontact_admin_fields_manager.tpl'));

        $admin_page->displayIndex();
        break;
}
include __DIR__ . '/footer.php';
