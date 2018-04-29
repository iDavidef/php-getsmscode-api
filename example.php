<?php
require_once('getsmscode.php');

$api = new getsmscode('your_username', 'your token'); //username = email, token can be found on the homepage @ getsmscode.com
echo 'My balance is: '.$api->get_balance(); //echo balance

//get a chinese (+86) number for Telegram
$number = $api->get_number(10, 'cn');
echo 'Requested phone number is +'.$number.PHP_EOL;
//loop until an sms received
echo 'Waiting code...'.PHP_EOL;
$sms = $api->get_sms($number, 10, 'cn');
while($sms === false) {
    sleep(5);
    $sms = $api->get_sms($number, 10, 'cn');
}
//echo the received sms
echo 'Got sms: '.$sms.PHP_EOL;
echo PHP_EOL;

//get a brazil (+55) number for Telegram
$number = $api->get_number(10, 'br');
echo 'Requested phone number is +'.$number.PHP_EOL;
//loop until an sms received
echo 'Waiting code...'.PHP_EOL;
$sms = $api->get_sms($number, 10, 'br');
while(!$sms) {
    sleep(5);
    $sms = $api->get_sms($number, 10, 'br');
}
//echo the received sms
echo 'Got sms: '.$sms.PHP_EOL;
