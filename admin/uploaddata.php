<?php
// Upload data to database files

    
$debugging = false;

    define('InAdmin', 1);
    $current_page = 'tools';
    include '../common.php';
    include INCLUDE_PATH . 'functions_admin.php';
    include 'loggedin.inc.php';
    
    if (isset($_POST['action']) && $_POST['action'] == 'upload') {
        $myfile = fopen($_FILES['myFile']['tmp_name'], "r") or die("Unable to open file!");
        fclose($myfile);
        $jupload = json_decode(file_get_contents($_FILES['myFile']['tmp_name']), true);

        if($_POST['table'] == "currency_codes") {
            foreach($jupload as $currency) {
                $query = "SELECT COUNT(id) as count FROM " . $DBPrefix . $_POST['table'] . " WHERE code = '" . $currency['code'] . "'";
                $db->direct_query($query);
                $count = $db->result();
                if ($count['count'] == 0){
                    $query = "INSERT INTO " . $DBPrefix . $_POST['table'] .
                    " SET code = :code, name = :name, name_plural = :name_plural, decimal_digits = :decimal_digits, rounding = :rounding ";
                    $params = array();
                    $params[] = array(':code', $currency['code'], 'str');
                    $params[] = array(':name', $currency['name'], 'str');
                    $params[] = array(':name_plural', $currency['name_plural'], 'str');
                    $params[] = array(':decimal_digits', $currency['decimal_digits'], 'int');
                    $params[] = array(':rounding', $currency['rounding'], 'float');
                    $db->query($query, $params);
                }
            }
        }
        if ($_POST['table'] == 'countries') {
            foreach($jupload as $country) {
                if($country['ISO3166-1-Alpha-3']!=NULL){
                    $query = "SELECT COUNT(country_id) as count FROM " . $DBPrefix . $_POST['table'] . " WHERE country_code3D = '" . $country['ISO3166-1-Alpha-3'] . "'";
                    $db->direct_query($query);
                    $count = $db->result();
                    if ($count['count'] == 0){
                        $query = "INSERT INTO " . $DBPrefix . $_POST['table'] .
                        " SET country = :country_name, country_code2d = :code2d, country_code3d = :code3d, capital = :capital, currency_code = :currency_code, currency_name = :currency_name";
                        $params = array();
                        $params[] = array(':country_name', $country['CLDR display name'], 'str');
                        $params[] = array(':code2d', $country['ISO3166-1-Alpha-2'], 'str');
                        $params[] = array(':code3d', $country['ISO3166-1-Alpha-3'], 'str');
                        $params[] = array(':capital', $country['Capital'], 'str');
                        $params[] = array(':currency_code', $country['ISO4217-currency_alphabetic_code'], 'str');
                        $params[] = array(':currency_name', $country['ISO4217-currency_name'], 'str');
                        $db->query($query, $params);
                    } else {
                        print("nothing................<br>");
                    }
                }
            }
        }
        
        
        if($_POST['table'] == "city_codes") {
            $counter = 0;
            foreach($jupload as $city) {
                $query = "SELECT COUNT(city.id) as count FROM " . $DBPrefix . $_POST['table'] . " city " .
                " LEFT JOIN " . $DBPrefix . "countries countries ON (countries.country = '" . $system->cleanvars($city['country']) . "') " . 
                " WHERE city.name = '" . $system->cleanvars($city['name']) . "'";
                $db->direct_query($query);
                $count = $db->result();
                if ($count['count'] == 0){
                    $query = "SELECT country_code3D as country_code FROM " . $DBPrefix . "countries WHERE country = '" . $system->cleanvars($city['country']) . "'";
                    $db->direct_query($query);
                    $countryCode = $db->result();
                    $query = "INSERT INTO " . $DBPrefix . $_POST['table'] .
                    " (country, country_code, name, subcountry, geonameid)
                    VALUES(:country, :country_code, :name, :subcountry, :geonameid)";
                    $params = array();
                    $params[] = array(':country', $system->cleanvars($city['country']), 'str');
                    $params[] = array(':country_code', $system->cleanvars($countryCode['country_code']), 'str');
                    $params[] = array(':name', $system->cleanvars($city['name']), 'str');
                    $params[] = array(':subcountry', $system->cleanvars($city['subcountry']), 'str');
                    $params[] = array(':geonameid', $system->cleanvars($city['geonameid']), 'int');
                    $db->query($query, $params);
                    $error = $db->result();
                    $counter +=1;
                } else {
                }
            }
            print ($counter . " Added");
        }
        
        if($_POST['table'] == "province_codes") {
            $counter = 0;
            foreach($jupload as $country) {
                //$provinces = json_decode(file_get_contents('), true);
                
                $query = "SELECT country_id FROM " . $DBPrefix . "countries WHERE country_code2D = '" . $country['code'] . "'";
                $db->direct_query($query);
                $result = $db->result();
                if ($result['country_id'] != NULL) {
                    if(isset($country['filename'])) {
                        print("<br><br>Country: " . $country['name'] . "<br>");
                        $myfile = fopen(ADMIN_UPLOAD_PATH . "/countries/" . $country['filename'] . ".json", "r") or die("Unable to open file!");
                        fclose($myfile);
                        $provinces = json_decode(file_get_contents(ADMIN_UPLOAD_PATH . "/countries/" . $country['filename'] . ".json"), true);
                        foreach($provinces as $province) {
                            $query = "INSERT INTO " . $DBPrefix . "province_code
                             (country_id, code, name)
                             VALUES(:countryid, :provcode, :provname)";
                            $params = array();
                            $params[] = array(':countryid', $system->cleanvars($result['country_id']), 'int');
                            $params[] = array(':provcode', $system->cleanvars($province['code']), 'str');
                            $params[] = array(':provname', $system->cleanvars($province['name']), 'str');
                            $db->query($query, $params);
                            $error = $db->result();
                            $counter +=1;
                            print("Province Code: " . $province['code'] . "<br>");
                            print("Province Name: " . $province['name'] . "<br>");
                            print("Country Table ID: " . $result['country_id'] . "<br>");
                        }
                    }
                }
            }
        }

        $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['file_uploaded']));
    }
    
    
    
    
    $template->assign_vars(array(
        'SITEURL' => $system->SETTINGS['siteurl']
        ));
    
    include 'header.php';
    $template->set_filenames(array(
            'body' => 'uploaddata.tpl'
            ));
    $template->display('body');
    include 'footer.php';