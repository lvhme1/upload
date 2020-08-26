<?php
namespace Listener;

require "core.php";

require('PaypalIPN.php');

use PaypalIPN;

$ipn = new PaypalIPN();

// Use the sandbox endpoint during testing.
//$ipn->useSandbox();
$verified = $ipn->verifyIPN();
if ($verified) {
    // The IPN is verified, process it
	
    $item_name = $_POST['item_name'];
    $item      = strstr($item_name, '-', true);
    $pieces    = explode(' - ', $item_name);
    $username  = array_pop($pieces);
    $txn_id    = $_POST['txn_id'];
    $date      = date("d F Y");
    $time      = date("H:i");
    
    $querysv = mysqli_query($connect, "SELECT * FROM `paid_services` WHERE `service`='$item' LIMIT 1");
    $countsv = mysqli_num_rows($querysv);
    
    $querysvu = mysqli_query($connect, "SELECT * FROM `players` WHERE `username`='$username' LIMIT 1");
    $countsvu = mysqli_num_rows($querysvu);
    
    if ($countsv > 0 && $countsvu > 0) {
        $rowsv  = mysqli_fetch_assoc($querysv);
        $rowsvu = mysqli_fetch_assoc($querysvu);
        
        $service_id     = $rowsv['id'];
        $service_type   = $rowsv['type'];
        $service_amount = $rowsv['amount'];
        $plr_id         = $rowsvu['id'];
        
        if ($service_type == 'getmoney') {
            $givemoney = mysqli_query($connect, "UPDATE `players` SET money=money+'$service_amount' WHERE `username`='$username'");
            $succquery = mysqli_query($connect, "INSERT INTO `payments` (player_id, service_id, txn_id, date, time) VALUES ('$plr_id', '$service_id', '$txn_id', '$date', '$time')");
        } elseif ($service_type == 'getgold') {
            $givegold  = mysqli_query($connect, "UPDATE `players` SET gold=gold+'$service_amount' WHERE `username`='$username'");
            $succquery = mysqli_query($connect, "INSERT INTO `payments` (player_id, service_id, txn_id, date, time) VALUES ('$plr_id', '$service_id', '$txn_id', '$date', '$time')");
        } elseif ($service_type == 'energyrefill') {
            $refillfuel = mysqli_query($connect, "UPDATE `players` SET energy='100' WHERE `username`='$username'");
            $succquery  = mysqli_query($connect, "INSERT INTO `payments` (player_id, service_id, txn_id, date, time) VALUES ('$plr_id', '$service_id', '$txn_id', '$date', '$time')");
        } elseif ($service_type == 'vip') {
            $setvip    = mysqli_query($connect, "UPDATE `players` SET `role`='VIP' WHERE `username`='$username'");
            $succquery = mysqli_query($connect, "INSERT INTO `payments` (player_id, service_id, txn_id, date, time) VALUES ('$plr_id', '$service_id', '$txn_id', '$date', '$time')");
        }
        
    }
}

//Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");

@$ref = $_SERVER['HTTP_REFERER'];
if (strpos($ref, 'paypal.com') !== false) {
    echo 'Purchase verified!';
    echo '<br />The resource is received.';
	echo '<meta http-equiv="refresh" content="1; url=home.php" />';
}

echo '<meta http-equiv="refresh" content="1; url=home.php" />';
?>