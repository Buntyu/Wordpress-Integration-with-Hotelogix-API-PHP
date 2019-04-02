<?php
#201201160211 #1631:sougata
include("LIB/lib.php");
if (isset($_REQUEST['itemId']))
{
    $adi = array();
    if(isset($_REQUEST['addchk']))
        $adi = $_REQUEST['addchk'];

    //$hapiObj = new HAPI();
    $hapiObj = new HAPI(CH_KEY, CH_SEC);
    $xmlDom = $hapiObj->addAddons($_REQUEST['itemId'], $adi);


    $resDom = $xmlDom->getElementsByTagName('response')->item(0);
    $rsS = getResponseStatus($resDom);
    //print_r($rsS);
    ?>
    <script language="javascript">
      window.opener.location.href="cart.php?m=<?php echo urlencode($rsS['message']);?>";
      window.opener.location.href="<?php echo site_url(); ?>/cart";
        window.close();
    </script>
    <?php

}
else
{
     echo'<script> window.location="'.site_url().'/session-expire?e=Error in request"; </script> ';
}
