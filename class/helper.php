<?php

namespace XoopsModules\Xoocontact;

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
use Xoops\Module\Helper\HelperAbstract;
use XoopsLoad;
use XoopsModules\Xoocontact;

/**
 * Class Helper
 * @package XoopsModules\Xoocontact
 */
class Helper extends HelperAbstract
{
    public $debug;

    /**
     * @internal param $debug
     * @param bool $debug
     */
    protected function __construct($debug = false)
    {
        $this->debug = $debug;
        $this->dirname = basename(dirname(__DIR__));
    }

    /**
     * Init the module
     *
     * @return null|void
     */
    public function init()
    {
        $this->setDirname(basename(dirname(__DIR__)));
        $this->loadLanguage('preferences');
    }

    /**
     * @return mixed
     */
    public function loadConfig()
    {
//        XoopsLoad::load('xoopreferences', $this->dirname);

        return Xoocontact\Preferences::getInstance()->getConfig();
    }

//    /**
//     * @return \XoopsModules\Xoocontact\Helper
//     */
//    public function contactHandler()
//    {
//        return $this->getHandler('Contact');
//    }

    /**
     * @param bool $debug
     *
     * @return \XoopsModules\Xoocontact\Helper
     */
    public static function getInstance($debug = false)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($debug);
        }

        return $instance;
    }

    /**
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * Get an Object Handler
     *
     * @param string $name name of handler to load
     *
     * @return bool|\XoopsObjectHandler|\XoopsPersistableObjectHandler
     */
    public function getHandler($name)
    {
        $ret = false;
//        /** @var Connection $db */
        $db = \XoopsDatabaseFactory::getConnection();
        $class = '\\XoopsModules\\' . ucfirst(mb_strtolower(basename(dirname(__DIR__)))) . '\\' . $name . 'Handler';
        $ret = new $class($db);

        return $ret;
    }
}
