<?php

$debugging = false;

    define('InAdmin', 1);
    $current_page = 'settings';
    include '../common.php';
    include INCLUDE_PATH . 'functions_admin.php';
    include INCLUDE_PATH . 'config/timezones.php';
    include 'loggedin.inc.php';
    
    $currentCurrency = $system->SETTINGS['currency'];
    $currentDate = getdate();
    
    $query = "SELECT date from " . $DBPrefix . "currency_rates ORDER BY date DESC";
    $db->direct_query($query);
    $last_date = $db->result();
    $ltimestamp = strtotime($last_date['date']);
    $tomorrow = mktime("15", "00", "00", date("n",$ltimestamp), date("j",$ltimestamp)+1, date("Y",$ltimestamp));
    print("Last date gotten: " . $last_date['date'] . "<br>");
    print("Tomorrow: " . date("Y/n/j H:i:s", $tomorrow) . "<br>");
    print("Current Date: " . date("Y/n/j H:i:s", $currentDate[0]) . "<br>");
    
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        if(($currentDate['wday']>0 && $currentDate['wday']<6) && $tomorrow < $currentDate[0]) {
            $XML = simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
            $currentRates = $XML->Cube->Cube->Cube;
            $currate_date = $XML->Cube->Cube['time'];
    
            $rate_date = substr($currate_date,0,4) . "-" . substr($currate_date,5,2) . "-" . substr($currate_date,8,2) . " " . date("H:m:s", $currentDate[0]);
            
            $query = "SELECT * FROM " . $DBPrefix . "currency_rates WHERE date = '" . $rate_date . "'";
            
            $db->direct_query($query);
            $results = $db->result();
            if(!$results){
                foreach($currentRates as $rate){
                    $currency_code = $rate['currency'];
                    $currency_rate = $rate['rate'];
                    
                    $query = "INSERT INTO " . $DBPrefix . "currency_rates (date, currency_code, rate) VALUES (
                        '" . $rate_date . "',
                        '" . $currency_code . "',
                        '" . $currency_rate . "')";
                    $db->direct_query($query);
                }
                $query = "INSERT INTO " . $DBPrefix . "currency_rates (date, currency_code, rate) VALUES (
                        '" . $rate_date . "',
                        'EUR',
                        '1')";
                    $db->direct_query($query);
            }
            $template->assign_block_vars('alerts', array('TYPE' => 'success', 'MESSAGE' => $MSG['currency_rates_updated']));
        } else {
            $template->assign_block_vars('alerts', array('TYPE' => 'warning', 'MESSAGE' => $MSG['currency_rates_not_updated']));
        }
    } 
    
    $query = "SELECT id, date, rate FROM " . $DBPrefix . "currency_rates WHERE currency_code = '" . $currentCurrency . "' ORDER BY date DESC";
    $db->direct_query($query);
    $result = $db->fetch();
    $last_date = $result['date'];
    $default_rate = $result['rate'];
    $query = "SELECT cr.id, cr.currency_code, cr.date, cr.rate, cc.name FROM " . $DBPrefix . "currency_rates cr
    LEFT JOIN " . $DBPrefix . "currency_codes cc ON(cr.currency_code = cc.code) 
    WHERE cr.date = '" . $last_date . "' ORDER BY cr.date, cr.currency_code";
    $db->direct_query($query);

    while($rate = $db->result()) {
        if($rate['currency_code'] !== $currentCurrency){
            $calculated_rate = $rate['rate'] / $default_rate;
            $currency_name = $rate['name'];
            $currency_code = $rate['currency_code'];
        
        $template->assign_block_vars('rates', array(
            'CCODE' => $currency_code,
            'CNAME' => $currency_name,
            'CRATE' => $calculated_rate
            ));
        }
    }
    


    $template->assign_vars(array(
        'RATEDATE' => $last_date,
        'DEFAULTCURRENCY' => $currentCurrency,
        'DEFAULTRATE' => $default_rate
        ));
    include 'header.php';
    $template->set_filenames(array(
            'body' => 'currencyrates.tpl'
            ));
    $template->display('body');
    include 'footer.php';
