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
use Xoops\Core\Request;
use XoopsModules\Xoocontact;

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

$op = '';
if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}
if (isset($_GET)) {
    foreach ($_GET as $k => $v) {
        ${$k} = $v;
    }
}

$script_name = basename(Request::getString('SCRIPT_NAME', 'index', 'SERVER'), '.php'); //$_SERVER['SCRIPT_NAME'], '.php');

XoopsLoad::load('system', 'system');
$system = \System::getInstance();

$xoops = \Xoops::getInstance();
if ('about' !== $script_name) {
    $xoops->header('xoocontact_admin_' . $script_name . '.tpl');
} else {
    $xoops->header();
}
$xoops->theme()->addStylesheet('modules/xoocontact/assets/css/moduladmin.css');

$admin_page = new \Xoops\Module\Admin();
if ('about' !== $script_name && 'index' !== $script_name) {
    $admin_page->renderNavigation(basename(Request::getString('SCRIPT_NAME', 'index', 'SERVER')));
} elseif ('index' !== $script_name) {
    $admin_page->displayNavigation(basename(Request::getString('SCRIPT_NAME', 'index', 'SERVER')));
}

$helper = \XoopsModules\Xoocontact\Helper::getInstance();
$contactConfig = $helper->loadConfig();

//$contactHandler = $helper->getHandler('Contact');
if (true != ($contactHandler instanceof \XoopsModules\Xoocontact\ContactHandler)) {
    $contactHandler = $helper->getHandler('Contact');
}
