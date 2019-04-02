<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'LIB/lib.php';

$amount = $_REQUEST['payment'];
$orderId = $_REQUEST['orderId'];
$currCode = $_REQUEST['currcode'];
$gid = $_REQUEST['gid'];


if(!isset($orderId))
   echo'<script> window.location="'.site_url().'/session-expire?e=Order Not found"; </script> ';

if(isset($_REQUEST['confsub']) && $_REQUEST['confsub'] == "confirmsub")
{
       $argArrayConf = array(
                'orderId' => $_REQUEST['orderId'],
                'payment' => 0,
    	  		'cardname' => $_REQUEST['cardname'],
		  	 'cardnumber' => $_REQUEST['card'],
		   'cvc' => $_REQUEST['cvc'],
		  		'emonth' => $_REQUEST['expday'],
		   'eyear' => $_REQUEST['expyear']
        );

	//$alldata='[Card Name:'.$_REQUEST['cardname'].',Card No.'.$_REQUEST['card'].',CVC:'.$_REQUEST['cvc'].',Exp. Date:'.$_REQUEST['expday'].'-'.$_REQUEST['expyear'].']';


        //$hapi = new HAPI();
        $hapi = new HAPI(CH_KEY, CH_SEC);
        $dom1 = $hapi->confirm($argArrayConf);


        $response1 =  $dom1->getElementsByTagName("response")->item(0);


        $stArr1 = getResponseStatus($response1);

        if(isset($stArr1['code']) && $stArr1['code'] == 1602)
        {


			/*$updatearray = array(
                'bid' => $gid,
                'cdata' => $alldata
		   );

			$happi = new HAPI();
			$rre = $happi->updatedata($updatearray);*/

			/*$bookings = $dom1->getElementsByTagName('booking');
			$paidAmountNd = $dom1->getElementsByTagName('paidamount')->item(0);
			$totalamountNd = $dom1->getElementsByTagName('orderamount')->item(0);

			$paidAmountNd = $dom1->getElementsByTagName('paidamount')->item(0);
			$totalamount = $totalamountNd->getAttribute("amount");
			$paidAmount = $paidAmountNd->getAttribute("amount");

			$curCode = $bookings->item(0)->getAttribute('currencycode');
			$ownDet = array();
			$owner = $dom1->getElementsByTagName('owner')->item(0);
			if ($owner->childNodes->length)
			{
				foreach ($owner->childNodes as $i)
				{
					if ($i->nodeType != XML_ELEMENT_NODE)
						continue;

					$ownDet[$i->nodeName] = $i->nodeValue;
				}
			}

			$xmltojson=array();

			echo "<div style='display:none;'> ";
			$xmltojson['Order ID']=$_REQUEST['orderId'];
			$xmltojson['Guest_details']=$ownDet;
			$xmltojson['Total_amount']= displayPrice($totalamount, $curCode, 2);
			$xmltojson['Paid_amount']= displayPrice($paidAmount, $curCode, 2);
			$detailsarray=array();

			 foreach ($bookings as $booking)
              {

				  $checkIndate = $booking->getAttribute("checkindate");
                        $checkOutdate = $booking->getAttribute("checkoutdate");
                        $adult = $booking->getAttribute("adult");
                        $child = $booking->getAttribute("child");
                        $rates = $booking->getElementsByTagName('rate');
                        $id = $booking->getAttribute("id");

                        $hotelName = $booking->getAttribute("hotelname");
                        $rsvIdHash = $booking->getAttribute("code");
                        $roomtypes = $booking->getElementsByTagName('roomtype');

				  $detailsarray['Check in date']= displayDate($checkIndate);
				  $detailsarray['Check Out date']=  displayDate($checkOutdate);
				 $detailsarray['Adults']= $adult;
				 $detailsarray['Child']= $child;



				  foreach ($roomtypes as $roomtype)
				  {
					  $roomName = $roomtype->getAttribute("title");
				$detailsarray['title'][]=$roomName;

				  }

				 if ($rates)
					{
					foreach ($rates as $rate)
					{

						 $addonsprice = 0;
                        $addonsTax = 0;
						$addons = $rate->getElementsByTagName('addon');
						foreach ($addons as $addon)
                            {
                                $addonsprice+=$addon->getAttribute('price');
                                $addonsTax+=$addon->getAttribute('tax');
                            }

		$detailsarray['Package details']['Price details']['Price'][]=displayPrice($rate->getAttribute('price'), $curCode);
		if($rate->hasAttribute('tax'))
		{
		$detailsarray['Package details']['Price details']['Tax'][] = displayPrice($rate->getAttribute('tax'), $curCode);
					}
		$detailsarray['Package details']['Price details']['AddOns Price'][] =displayPrice($addonsprice, $curCode);
		$detailsarray['Package details']['Price details']['AddOns Tax'] []= displayPrice($addonsTax, $curCode);
					}}
				 $xmltojson['Details']=$detailsarray;
			 }

			$aer= json_encode($xmltojson,JSON_PRETTY_PRINT);
			$to = "veduniyalas@gmail.com";
			$subject = "Order Json data";
			$txt = $aer;
			$headers = "From: info@hotelpalacio.net" . "\r\n";
			mail($to,$subject,$txt,$headers);
			echo "</div>";
			*/



            $orderConf =  $dom1->getElementsByTagName("order")->item(0);
            $orderIdConf = $orderConf->getAttribute("id");

            //header("location: view-order.php?orderId=". $orderIdConf);
    echo'<script> window.location="'.site_url().'/view-order?orderId='. $orderIdConf.'"; </script> ';
        }
        else
        {
echo'<script> window.location="'.site_url().'/session-expire?e=Order not Confirmed. ('.$stArr1['message'].')"; </script> ';
            //header("location: session-expire.php?e=Order not Confirmed. (".$stArr1['message'].")");
        }
}
?>     <div class="table-style table-responsive">
			 <table style="width:100%">
					<tr class="table-bg">
						<th>
							<h3>Enter Credit Card Details</h3>
						</th>
					</tr>
					<tr>
						<td>
							<form class="table-guest" action="#" method="post" name="frmGuestDet">
								<table align="center" width="100%">
									<tr class="field-from"><td>Amount : </td><td><?php echo displayPrice($amount, $currCode) ; ?></td></tr>
									<tr class="field-from"><td>Name: </td><td><input class="field-input" type="text" name="cardname" /></td></tr>
									<tr class="field-from"><td>Cedit Card: </td><td><input class="field-input" type="text" name="card" /></td></tr>
									<tr class="field-from"><td>Expiry: </td>
									<td>
										<input class="field-input" type="text" name="expday" style="width:15%;" />&nbsp;
										<input class="field-input" type="text" name="expyear" style="width:20%;" />&nbsp;&nbsp;
										CVV&nbsp;
										<input class="field-input" type="text" name="cvc" style="width:30%;" />
									</td>

								</tr>

								<tr class="field-from">
									<td colspan="2" align="center">
										<input class="table-button" type="submit" name="btnSave" class="btnSave" value="Confirm Order" />
										<input type="hidden" name="payment" value="<?php echo $amount; ?>" />
										<input type="hidden" name="orderId" class="orderId" value="<?php echo $orderId; ?>" />
										<input type="hidden" name="confsub" value="confirmsub" />
									</td>
								</tr>
							</table>
							</form>
						</td>
					</tr>
				</table>
		</div>
<style>#ssb-container {
	display: none !important;
}</style>
