<?php
#20111214 #1581:sougata
include("LIB/lib.php");
//$hapi = new HAPI();
$hapi = new HAPI(CH_KEY, CH_SEC);
$orderId = $_REQUEST['orderId'];
$itemId = $_REQUEST['itemId'];


if(!isset($orderId))
{
   echo'<script> window.location="'.site_url().'/session-expire?e=Order Id Not found"; </script> ';
   //header("location: session-expire.php?e=Order Id Not found");
}
if(!isset($itemId))
{
   echo'<script> window.location="'.site_url().'/session-expire?e=Order Item Not Found"; </script> ';
   //header("location: session-expire.php?e=Order Item Not Found");
}

if(isset($_POST["ispost"]) && $_POST["ispost"]==1)
{
    $charge = $_POST["txtCharge"];
    $description = $_POST["txtDesc"];
    $cancelDom = $hapi->cancelOrderItem(array(
                                'orderId'=>$orderId,
                                'reservationId'=>$itemId,
                                'cancelCharge'=>$charge,
                                'description'=>$description
                                )
                            );

    //header("location: view-order.php?orderId=$orderId");
    echo'<script> window.location="'.site_url().'/view-order?orderId='.$orderId.'"; </script> ';
}


//$hapi = new HAPI();
$hapi = new HAPI(CH_KEY, CH_SEC);
$dom = $hapi->getCancellationCharge(array('orderId' => $orderId,'reservationId' => $itemId));
print $dom->saveXML();
//
//
//$dom = new DOMDocument();
//$dom->load("cancelcharge.xml");
//print_r($dom->saveXML());

$responseStatus = $dom->getElementsByTagName('status')->item(0)->getAttribute("code");
$cancelAmount = $dom->getElementsByTagName('charge')->item(0)->getAttribute("amount");


if ($responseStatus != 1605)
{
    echo "There is reponse error! ";
    die();
}

?>
<html>
    <body>
        <form method="post" >
            <table border="1" style="width:50%;border-width :1;border-style: none;"
                   cellspacing="2" cellpadding="5" align="center">
                <tr>
                    <td align="center" colspan="2" ><strong>Cancellation Policy for Reservation :: <?php echo $itemId ?></strong></td>
                </tr>
                <tr>
                    <td width="60%"><b>Policy Cancellation Amount</b><input type="hidden" id="ispost" name="ispost" value="1"/> </td>
                    <td width="40%"><?php echo $cancelAmount ?></td>
                </tr>
                <tr>
                    <td width="60%"><b>Cancellation Amount</b></td>
                    <td width="40%"><input type="text" id="txtCharge" name="txtCharge" value="<?php echo $cancelAmount ?>"/></td>
                </tr>
                <tr>
                    <td width="60%"><b>Cancellation Description</b></td>
                    <td width="40%"><input type="text" id="txtDesc" name="txtDesc" value=""/></td>
                </tr>
                <tr height="50px">
                    <td width="60%"></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="60%" align="right"><input type="submit"   value="Cancel Reservation"/></td>
                    <td width="40%"><input type="button" onclick="javascript:window.history.back();"
                                           value="Back"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>


