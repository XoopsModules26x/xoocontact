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

include __DIR__ . '/header.php';

switch ($op) {
    case 'submit':
        if (!$xoops->security()->check()) {
            $xoops->redirect('index.php', 3, implode('<br>', $xoops->security()->getErrors()));
        }

        XoopsLoad::load('xoopscaptcha');
        $xoopsCaptcha = \XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $xoops->redirect('index.php', 3, $xoopsCaptcha->getMessage());
        }

        $contact = [];
        $myts = \MyTextSanitizer::getInstance();
        $fields = $contactHandler->getDisplay();
        foreach ($fields as $k => $field) {
            $contact[$k] = $field->getValues();
            if ('mail' === $field->getVar('xoocontact_formtype')) {
                $temp = Request::getString('xoocontact_field' . $k, '', 'POST');
                if (!($temp = $xoops->checkEmail($myts->stripSlashesGPC($temp)))) {
                    $xoops->redirect('index.php', 3, _XOO_CONTACT_INVALIDMAIL);
                }
            }
            //            $contact[$k]['xoocontact_data'] = $system->cleanVars($_POST, 'xoocontact_field' . $k, $field->getVar('xoocontact_default'), $field->getVar('xoocontact_valuetype'));
            $contact[$k]['xoocontact_data'] = Request::getVar('xoocontact_field' . $k, $fieldObj->getVar('xoocontact_default'), 'POST', $fieldObj->getVar('xoocontact_valuetype'));
        }

        $toContact = Request::getInt('message_copy', 0, 'POST');

        $messageSent = '';
        // Mail to webmaster
        $WebmasterMailer = new Xoocontact\Mail();
        if ($WebmasterMailer->sendToWebmaster($contact)) {
            $messageSent .= sprintf(_XOO_CONTACT_MESSAGESENT, $xoopsConfig['sitename']) . '<br>' . _XOO_CONTACT_THANKYOU;
        }
        unset($WebmasterMailer);

        // Mail to visitor
        $ContactMailer = new Xoocontact\Mail();
        if ($toContact) {
            if ($ContactMailer->sendToContact($contact)) {
                $messageSent .= '<br>' . sprintf(_XOO_CONTACT_SENTASCONFIRM, '');
            }
        }
        unset($ContactMailer);
        $xoops->redirect('index.php', 3, $messageSent);
        break;
    case 'default':
    default:
        $xoops->header('xoocontact_form.tpl');
        $xoops->theme()->addStylesheet('modules/xoocontact/assets/css/module.css');

        $xoops->tpl()->assign('moduletitle', $xoops->module->name());
        $xoops->tpl()->assign('welcome', $contactConfig['xoocontact_welcome']);
        $xoops->tpl()->assign('security', $xoops->security()->createToken());

        //        $form = $xoops->getModuleForm(null, 'contact', 'xoocontact');
        //        $form->ContactForm();
        $form = new \XoopsModules\Xoocontact\Form\ContactForm();
        $form->display();

        $xoops->footer();
        break;
}
