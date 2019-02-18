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
 * @package         Xoocontact
 * @since           2.6.0
 * @author          Laurent JEN (Aka DuGris)
 * @version         $Id$
 */

/**
 * @return bool
 */
function xoops_module_install_xoocontact()
{
    $xoops = \Xoops::getInstance();
    xoocontact_mkdirs($xoops->path(\XoopsBaseConfig::get('var-path')) . '/configs/xoocontact');

    //    XoopsLoad::addMap(array('banners' => dirname(__DIR__) . '/class/helper.php'));
    //    $helper = Banners::getInstance();

//    $path = dirname(__DIR__);
//    XoopsLoad::addMap([
//                          \XoopsModules\Xoocontact\Helper::class => $path . '/class/Helper.php',
//                      ]);
//    $helper         = \XoopsModules\Xoocontact\Helper::getInstance();
//    $contactHandler = $helper->getHandler('Contact');

    require_once dirname(__DIR__) . '/preloads/autoloader.php';

    return true;
}

/**
 * @param              $pathname
 * @param mixed|string $pathout
 *
 * @return bool
 */
function xoocontact_mkdirs($pathname, $pathout = XOOPS_ROOT_PATH)
{
    $xoops = \Xoops::getInstance();
    $pathname = mb_substr($pathname, mb_strlen(\XoopsBaseConfig::get('root-path')));
    $pathname = str_replace(DIRECTORY_SEPARATOR, '/', $pathname);

    $dest = $pathout;
    $paths = explode('/', $pathname);

    foreach ($paths as $path) {
        if (!empty($path)) {
            $dest = $dest . '/' . $path;
            if (!is_dir($dest)) {
                if (!mkdir($dest, 0755) && !is_dir($dest)) {
                    return false;
                }
                xoocontact_copyfile(\XoopsBaseConfig::get('uploads-path'), 'index.html', $dest);
            }
        }
    }

    return true;
}

/**
 * @param $folder_in
 * @param $source_file
 * @param $folder_out
 *
 * @return bool
 */
function xoocontact_copyfile($folder_in, $source_file, $folder_out)
{
    if (!is_dir($folder_out)) {
        if (!xoocontact_mkdirs($folder_out)) {
            return false;
        }
    }

    // Simple copy for a file
    if (is_file($folder_in . '/' . $source_file)) {
        return copy($folder_in . '/' . $source_file, $folder_out . '/' . basename($source_file));
    }

    return false;
}
