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

use Xoops\Core\Database\Connection;
use Xoops\Core\Kernel\XoopsObject;
use Xoops\Core\Kernel\XoopsPersistableObjectHandler;

/**
 * Class XoocontactContact
 */
class XoocontactContact extends XoopsObject
{
    // constructor
    /**
     *
     */
    public function __construct()
    {
        $this->initVar('xoocontact_id', XOBJ_DTYPE_INT, 0, false, 11);
        $this->initVar('xoocontact_description', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('xoocontact_value', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('xoocontact_formtype', XOBJ_DTYPE_TXTBOX, '', true, 15);
        $this->initVar('xoocontact_valuetype', XOBJ_DTYPE_TXTBOX, '', true, 15);
        $this->initVar('xoocontact_default', XOBJ_DTYPE_TXTBOX, '', true, 15);
        $this->initVar('xoocontact_min_width', XOBJ_DTYPE_INT, 1, true, 1);
        $this->initVar('xoocontact_max_width', XOBJ_DTYPE_INT, 1, true, 1);
        $this->initVar('xoocontact_required', XOBJ_DTYPE_INT, 1, true, 1);
        $this->initVar('xoocontact_display', XOBJ_DTYPE_INT, 1, true, 1);
        $this->initVar('xoocontact_order', XOBJ_DTYPE_INT, 1, true, 3);

        // Pour autoriser le html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
    }

    /**
     * @return bool
     */
    public function setView()
    {
        $this->setVar('xoocontact_display', 1);

        return true;
    }

    /**
     * @return bool
     */
    public function setHide()
    {
        $this->setVar('xoocontact_display', 0);

        return true;
    }

    /**
     * @return bool
     */
    public function setRequired()
    {
        $this->setVar('xoocontact_required', 1);

        return true;
    }

    /**
     * @return bool
     */
    public function setNotRequired()
    {
        $this->setVar('xoocontact_required', 0);

        return true;
    }

    /**
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     *
     * @return array
     */
    public function getValues($keys = null, $format = null, $maxDepth = null)
    {
        XoopsLoad::load('xoopsload');
        $autoload = XoopsLoad::loadConfig('xoocontact');

        $ret = parent::getValues();
        if (in_array($this->getVar('xoocontact_id'), $autoload['can_be_hidden'])) {
            $ret['can_be_hidden'] = false;
        } else {
            $ret['can_be_hidden'] = true;
        }

        switch ($this->getVar('xoocontact_formtype', 'e')) {
            case 'select':
                $ret['xoocontact_value'] = unserialize($this->getVar('xoocontact_value', 'n'));
                break;
            case 'radio':
                $ret['xoocontact_value'] = unserialize($this->getVar('xoocontact_value', 'n'));
                break;
        }

        return $ret;
    }
}

/**
 * Class XoocontactXoocontactContactHandler
 */
class XoocontactContactHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param null|Connection $db
     */
    public function __construct(Connection $db = null)
    {
        parent::__construct($db, 'xoocontact_fields', 'XoocontactContact', 'xoocontact_id', 'xoocontact_description');
    }

    /**
     * @return array
     */
    public function renderAdminList()
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort('xoocontact_order');
        $criteria->setOrder('asc');

        return $this->getObjects($criteria, true, false);
    }

    /**
     * @param bool $asObject
     *
     * @return array
     */
    public function getDisplay($asObject = true)
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('xoocontact_display', 1));
        $criteria->setSort('xoocontact_order');
        $criteria->setOrder('asc');

        return $this->getObjects($criteria, true, $asObject);
    }
}