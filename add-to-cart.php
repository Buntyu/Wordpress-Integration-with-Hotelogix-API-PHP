<?php
#20111210 #1581:sougata
include("LIB/lib.php");


if(isset($_REQUEST['itemId']) &&  $_REQUEST['itemId']!='')
{
   // $hapiObj = new HAPI();
    $hapiObj = new HAPI(CH_KEY, CH_SEC);

    $xmlDom = $hapiObj->add2cart($_REQUEST['itemId']);

    $resDom = $xmlDom->getElementsByTagName('response')->item(0);

    $rsS = getResponseStatus($resDom);

    if($rsS['code'] == 1500)
    {
         echo'<script> window.location="'.site_url().'/cart"; </script> ';
    }else
    {
        print $rsS['message'];
        //echo 'carttest';
        die;
    }
}else
{
    echo'<script> window.location="'.site_url().'/search-result"; </script> ';
}

?>
