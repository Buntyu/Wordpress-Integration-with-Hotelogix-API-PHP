<?php
include("LIB/lib.php");
if(isset($_REQUEST['itemId']) &&  $_REQUEST['itemId']!='')
{
    //$hapiObj = new HAPI();
    $hapiObj = new HAPI(CH_KEY, CH_SEC);
    $xmlDom = $hapiObj->deleteCartItem($_REQUEST['itemId']);

    $resDom = $xmlDom->getElementsByTagName('response')->item(0);
    $rsS = getResponseStatus($resDom);
    if($rsS['code'] == 1502)
    {
         echo'<script> window.location="'.site_url().'/cart"; </script> ';
    }else
    {
        print $rsS['message'];
        die;
    }
}else
{
    echo'<script> window.location="'.site_url().'/search-result"; </script> ';
}

?>
