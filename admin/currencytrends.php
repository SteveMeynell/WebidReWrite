<?php

$debugging = false;

    define('InAdmin', 1);
    $current_page = 'settings';
    include '../common.php';
    include INCLUDE_PATH . 'functions_admin.php';
    include INCLUDE_PATH . 'config/timezones.php';
    include 'loggedin.inc.php';
    
    // Data check
if (!isset($_REQUEST['id'])) {
    $URL = $_SESSION['RETURN_LIST'];
    header('location: ' . $URL);
    exit;
}
    
    
    if (isset($_REQUEST['id'])){
        
        $query = "SELECT date, rate FROM " . $DBPrefix . "currency_rates WHERE currency_code = :code ORDER BY date";
        $params = array();
        $params[] = array(':code', $_REQUEST['id'], 'str');
        $db->query($query,$params);
        $rates = $db->fetchall();
        $template->assign_vars(array(
            'CCODE' => $_REQUEST['id'],
            'CNAME' =>'Currency Name'
            ));
        $HTML = '';
        //print_r($rates);
        $rate_max = max(array_column($rates, 'rate'));
        $rate_min = min(array_column($rates, 'rate'));
        print("sum: " . array_sum(array_column($rates, 'rate')) . "<br>");
        print("count: " . count($rates). "<br>");
        print("mean: " . array_sum(array_column($rates, 'rate'))/count($rates) . "<br>");
        foreach($rates as $rate) {
            $rate_percent = ($rate['rate']/$rate_max)*100;
            print("subtract: " . ($rate_max - $rate['rate']) . "<br>");
            print($rate_percent . "<br>");
            
            $HTML .= '<div class="progress progress-bar-vertical">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="' . $rate_min . '" aria-valuemax="' . $rate_max . '" style="height: ' . $rate_percent . '%;"></div>
    </div>';
            $template->assign_block_vars('rates', array(
            'CDATE' => $rate['date'],
            'CRATE' => $rate['rate']
            ));
            
        }
    }
    
    
/*    $HTML = '
    <div class="progress progress-bar-vertical">
        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 40%;"></div>
    </div>
    <div class="progress progress-bar-vertical">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 60%;"></div>  
    </div>
    <div class="progress progress-bar-vertical">
        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 80%;"></div>  
    </div>
    <div class="progress progress-bar-vertical">
        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 95%;"></div>  
    </div>
    ';
*/
    $template->assign_vars(array(
        'CHART' => $HTML
        ));
    
include 'header.php';
$template->set_filenames(array(
        'body' => 'currencytrends.tpl'
        ));
$template->display('body');
include 'footer.php';
