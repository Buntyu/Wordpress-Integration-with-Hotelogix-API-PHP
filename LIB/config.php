<?php
#20111214 #1581:sougata

$apiDomain = 'https://crs.staygrid.com';   //https://staygrid.com https://crs.staygrid.com/ws/web
//$apiDomain = 'https://crs.hotelogix.net';

define('CH_KEY',"E44239583B00C0FF9EE630C4197968F639413EC4"); //example : -DJgWHKkNK9BPwlBqBYJ1W24bkDNNk
define('CH_SEC',"012332317ACA619F818FB9B8E98A10191D4D515A");  //example : FinuUCgSTRC4XHdqQdKfVm3JQVBefh

if($apiDomain == '')
{
    echo "Api Domain Not available. Incomplete configuration.";
    die;
}

if(CH_KEY == "" || CH_SEC == "")
{
    echo "Consumer Key or Secret is missing. Incomplete configuration.";
    die;
}

//echo '<!--'.$serverPath.' -->';

$serverPath = $apiDomain."/ws/web/";

define('WSSERVER_URL',$serverPath);

?>
