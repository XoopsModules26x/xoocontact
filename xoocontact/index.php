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
 * @version         $Id: index.php 24 2012-10-15 14:58:15Z Laurent $
 */

include dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php';

switch ($op) {
    case 'submit':
    if ( !$xoops->security->check() ) {        $xoops->redirect('index.php', 3, implode('<br />', $xoops->security->getErrors()));
    }

    XoopsLoad::load('xoopscaptcha');
    $xoopsCaptcha = XoopsCaptcha::getInstance();
    if ( !$xoopsCaptcha->verify() ) {        $xoops->redirect('index.php', 3, $xoopsCaptcha->getMessage());
    }

    $contact = array();
    $myts = MyTextSanitizer::getInstance();
    $fields = $xoocontact_handler->getDisplay();
    foreach( $fields as $k => $field ) {        $contact[$k] = $field->toArray();        if ( $field->getVar('xoocontact_formtype') == 'mail' ) {            if ( !( $_POST['xoocontact_field' . $k] = $xoops->checkEmail( $myts->stripSlashesGPC($_POST['xoocontact_field' . $k]) ) ) ) {
                $xoops->redirect('index.php', 3, _XOO_CONTACT_INVALIDMAIL);
            }
        }
        $contact[$k]['xoocontact_data'] = $system->cleanVars($_POST, 'xoocontact_field' . $k, $field->getVar('xoocontact_default'), $field->getVar('xoocontact_valuetype'));
    }

    $toContact = $system->cleanVars($_POST, 'message_copy', 0, 'int');

    $messagesent = '';
    // Mail to webmaster
    $WebmasterMailer = new XoocontactMail();
    if ( $WebmasterMailer->sendToWebmaser( $contact ) ) {
        $messagesent .= sprintf(_XOO_CONTACT_MESSAGESENT, $xoopsConfig['sitename']) . '<br />' . _XOO_CONTACT_THANKYOU;
    }
    unset($WebmasterMailer);
    // Mail to visitor
    $ContactMailer = new XoocontactMail();
    if ( $toContact ) {        if ( $ContactMailer->sendToContact( $contact ) ) {            $messagesent .= '<br />' . sprintf(_XOO_CONTACT_SENTASCONFIRM, '' );
        }
    }
    unset($ContactMailer);
    $xoops->redirect('index.php', 3, $messagesent);
    break;

    case 'default':
    default:
    $xoops->header('xoocontact_form.html');
    $xoocontact_handler->renderForm();
    $xoops->footer();
    break;
}
?>