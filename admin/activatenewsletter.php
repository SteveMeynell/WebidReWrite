<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2017 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/

define('InAdmin', 1);
$current_page = 'users';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include 'loggedin.inc.php';

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // clean submission and update database
    $system->writesetting('newsletter', $_POST['newsletter'], 'int');

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['newsletter_settings_updated']));
}

loadblock($MSG['activate_newsletter'], $MSG['activate_newsletter_explain'], 'batch', 'newsletter', $system->SETTINGS['newsletter'], array($MSG['yes'], $MSG['no']));

$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['25_0010'],
        'PAGENAME' => $MSG['25_0079']
        ));

include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';
