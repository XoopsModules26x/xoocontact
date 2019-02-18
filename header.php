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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xoocontact
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 */
use Xoops\Core\Request;
use XoopsModules\Xoocontact;

include dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/class' . '/mail.php';

XoopsLoad::load('system', 'system');
$system = \System::getInstance();

$xoops = \Xoops::getInstance();

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

$op = Request::getCmd('op', 'default');

$helper = \XoopsModules\Xoocontact\Helper::getInstance();
$contactConfig = $helper->loadConfig();
//$contactHandler = $helper->getHandler('Contact');
if (true != (null === $contactHandler ||
      $contactHandler instanceof \XoopsModules\Xoocontact\ContactHandler)) {
    $contactHandler = $helper->getHandler('Contact');
}
