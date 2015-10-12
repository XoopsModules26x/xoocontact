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

/**
 * Class XoocontactMail
 */
class XoocontactMail
{
    // constructor
    /**
     *
     */
    public function __construct()
    {
        $xoops             = Xoops::getInstance();
        $this->customPath  = \XoopsBaseConfig::get('themes-path') . $xoops->getConfig('theme_set') . '/modules/xoocontact/language/' . $xoops->getConfig('language') . '/mail_template';
        $this->defaultPath = \XoopsBaseConfig::get('root-path') . '/modules/xoocontact/language/' . $xoops->getConfig('language') . '/mail_template';

        $this->webmasterMail = $xoops->getConfig('adminmail');
        $this->webmasterName = $xoops->getConfig('sitename');

        $this->xoopsMailer = $xoops->getMailer();
        $this->xoopsMailer->useMail();
        $this->xoopsMailer->setHTML(true);
        $this->xoopsMailer->assign('XOOCONTACT_SITE_URL', \XoopsBaseConfig::get('url'));
        $this->xoopsMailer->assign('XOOCONTACT_SITE_NAME', $xoops->getConfig('sitename'));
        $this->xoopsMailer->setSubject($xoops->getConfig('sitename') . ' - ' . _XOO_CONTACT_CONTACTFORM);
    }

    /**
     * @param $contact
     *
     * @return bool
     */
    public function sendToContact($contact)
    {
        $this->setVariables($contact);
        $this->setTemplate('xoocontact_contact.tpl');
        $this->xoopsMailer->setToEmails($this->contact_mail);
        $this->xoopsMailer->setFromEmail($this->webmasterMail);
        $this->xoopsMailer->setFromName($this->webmasterName);

        return $this->xoopsMailer->send();
    }

    /**
     * @param $contact
     *
     * @return bool
     */
    public function sendToWebmaster($contact)
    {
        $this->setVariables($contact);
        $this->setTemplate('xoocontact_webmaster.tpl');
        $this->xoopsMailer->setToEmails($this->webmasterMail);
        $this->xoopsMailer->setFromEmail($this->contact_mail);

        return $this->xoopsMailer->send();
    }

    /**
     * @param $template
     */
    private function setTemplate($template)
    {
        if (file_exists($this->customPath . '/' . $template)) {
            $this->xoopsMailer->setTemplateDir($this->customPath);
        } else {
            $this->xoopsMailer->setTemplateDir($this->defaultPath);
        }
        $this->xoopsMailer->setTemplate($template);
    }

    /**
     * @param $contact
     */
    private function setVariables($contact)
    {
        foreach ($contact as $k => $v) {
            $this->xoopsMailer->assign('XOOCONTACT_FIELD' . $k, $v['xoocontact_description']);
            $this->xoopsMailer->assign('XOOCONTACT_VALUE' . $k, $v['xoocontact_data']);

            switch ($v['xoocontact_formtype']) {
                case 'select':
                    $this->xoopsMailer->assign('XOOCONTACT_VALUE' . $k, $v['xoocontact_value'][$v['xoocontact_data']]);
                    break;

                case 'radio':
                    $this->xoopsMailer->assign('XOOCONTACT_VALUE' . $k, $v['xoocontact_value'][$v['xoocontact_data']]);
                    break;

                case 'mail':
                    $this->contact_mail = $v['xoocontact_data'];
                    break;
            }
        }
    }
}
