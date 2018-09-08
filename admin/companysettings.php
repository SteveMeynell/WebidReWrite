<?php
/*
 * Setting page for all information dealing with the websites company
 *
*/

define('InAdmin', 1);
$current_page = 'settings';
include '../common.php';
include INCLUDE_PATH . 'functions_admin.php';
include INCLUDE_PATH . 'config/timezones.php';
include 'loggedin.inc.php';



// POST section
if (isset($_POST['action'])&& $_POST['action'] == 'update') {
    // Clean submission and update
    $companyName = $system->cleanvars($_POST['companyname']);
    $companyAddress = $system->cleanvars($_POST['company_address']);
    $companyCity = $system->cleanvars($_POST['company_city']);
    $companyProvince = $system->cleanvars($_POST['company_province']);
    $companyCountry = $system->cleanvars($_POST['company_country']);
    $companyPostal = $system->cleanvars($_POST['company_postal']);
    $companyPhone = $system->cleanvars($_POST['company_phone']);
    $companyFacebook = $system->cleanvars($_POST['company_facebook']);
    $companyTwitter = $system->cleanvars($_POST['company_twitter']);
    $companyOther = $system->cleanvars($_POST['company_other']);

    $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['company_settings_updated']));
} else {
    // get information from database
    //$selectsetting = '18';
}

$query = "SELECT country_id, country FROM " . $DBPrefix . "countries ORDER BY country";
$db->direct_query($query);


while($company_countries = $db->fetch()) {
    $country_list[$company_countries['country_id']] = $company_countries['country'];
    //print_r($company_countries);
}

// general settings
loadblock($MSG['company_settings'], '', '', '', '', array(), true);
loadblock($MSG['company_name'], $MSG['company_name_explain'], 'text', 'companyname', '');
loadblock($MSG['company_location_settings'], '', '', '', '', array(), true);
loadblock($MSG['company_address'], $MSG['company_address_explain'], 'textarea', 'company_address');
loadblock($MSG['company_city'], $MSG['company_city_explain'], 'text', 'company_city');
loadblock($MSG['company_province'], $MSG['company_province_explain'], '<SELECT></SELECT>', 'company_province');

loadblock($MSG['company_country'], $MSG['company_country_explain'], generateSelect('company_country', $country_list));
loadblock($MSG['company_postal'], $MSG['company_postal_explain'], 'text', 'company_postal');
loadblock($MSG['company_phone'], $MSG['company_phone_explain'], 'text', 'company_phone');
loadblock($MSG['company_social_settings'], '', '', '', '', array(), true);
loadblock($MSG['company_facebook'], $MSG['company_facebook'], 'text', 'company_facebook');
loadblock($MSG['company_twitter'], $MSG['company_twitter'], 'text', 'company_twitter');
loadblock($MSG['company_other'], $MSG['company_other'], 'text', 'company_other');

// Assign template block variables
$template->assign_block_vars('some_variable', array(
    
    ));

// Assign template variables
$template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl'],
        'TYPENAME' => $MSG['5142'],
        'PAGENAME' => $MSG['company_settings']
    ));

// Display section
include 'header.php';
$template->set_filenames(array(
        'body' => 'adminpages.tpl'
        ));
$template->display('body');
include 'footer.php';