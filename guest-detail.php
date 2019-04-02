<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
#201201160211 #1631:sougata
include 'LIB/lib.php';
error_reporting(0);
if(isset($_POST['btnSave']))
{
    $argArray = array();

    foreach($_POST as $k => $posdata)
    {
        if($k != 'btnSave')
            $argArray[$k] = $posdata;
    }

    //$hapi = new HAPI();
    $hapi = new HAPI(CH_KEY, CH_SEC);

    // calling save order
    $dom = $hapi->save($argArray);
    //print $dom->saveHTML();

    $response =  $dom->getElementsByTagName("response")->item(0);
    $stArr = getResponseStatus($response);

    #20111219:arup #1581 add gateway page
    #201201200421 #1743:sougata add total depositamount
    if(isset($stArr['code']) && $stArr['code'] == 1600)
    {
        $order =  $dom->getElementsByTagName("order")->item(0);
        $orderId = $order->getAttribute("id");

        $bookings = $dom->getElementsByTagName('booking');
    	 foreach ($bookings as $booking)             {
 $gid = $booking->getAttribute("id");
 }

        $curCode = $bookings->item(0)->getAttribute('currencycode');

        //getting deposit amount
        $deposittotalNode = $dom->getElementsByTagName("deposittotal")->item(0);
        $depositAmount = $deposittotalNode->getAttribute('amount');

        echo'<script> window.location="'.site_url().'/gateway?orderId='.$orderId.'&payment='.$_SESSION['total'].'&currcode='.$curCode.'&gid='.$gid.'"; </script>';
		//header("location: gateway.php?orderId=".$orderId."&payment=".$depositAmount."&currcode=".$curCode);

    }
    else
    {
		echo'<script> window.location="'.site_url().'/session-expire?e=Order not saved. ('.$stArr['message'].'"; </script> ';
        //header("location: session-expire.php?e=Order not saved. (".$stArr['message'].")");
    }

}
?>
<style>#ssb-container {
	display: none !important;
}</style>
<div class="table-style table-responsive">
         <table width="100%">
                <tr class="table-bg">
                    <th>
                        <h3>Guest Detail</h3>
                    </th>
                </tr>
                <tr>
                    <td>
                        <form class="table-guest" action="" method="post" name="frmGuestDet">
							<table style="width:100%">
								<tr class="field-from"><td>First Name: </td><td><input class="field-input" type="text" name="fname" /></td></tr>
								<tr class="field-from"><td>Last Name: </td><td><input class="field-input" type="text" name="lname" /></td></tr>
								<tr class="field-from"><td>Email: </td><td><input class="field-input" type="text" name="email" /></td></tr>
								<tr class="field-from"><td>Phone: </td><td><input class="field-input" type="text" name="phone" /></td></tr>
								<tr class="field-from"><td>Mobile: </td><td><input class="field-input" type="text" name="mobile" /></td></tr>

								<tr class="field-from"><td>Country Name: </td><td><input class="field-input" type="text" name="country" /></td></tr>
								<?php /*<tr class="field-from"><td>Country Code: </td><td><input class="field-input" type="text" name="countryCode" value="IN"/></td></tr>

								<tr class="field-from"><td>State Name: </td><td><input class="field-input" type="text" name="state" value="noida"/></td></tr>
								<tr class="field-from"><td>State Code: </td><td><input class="field-input" type="text" name="stateCode" value="UP"/></td></tr>
								*/ ?>
								<tr class="field-from"><td>Address: </td><td><input class="field-input" type="text" name="address" /></td></tr>
								<tr class="field-from"><td>City: </td><td><input class="field-input" type="text" name="city" /></td></tr>
								<tr class="field-from"><td>Zip Code: </td><td><input class="field-input" type="text" name="zip" /></td></tr>
								<tr class="field-from"><td></td><td><input class="table-button" type="submit" value="Proceed to Payment" name="btnSave" /></td></tr>
							</table>
                        </form>
                    </td>
				</tr>
        </table>
	</div>
