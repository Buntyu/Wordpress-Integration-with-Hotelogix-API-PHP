<?php
#20111213 #1581:sougata
#20111214 #1581:sougata
#20111214 #1581:sougata
#201201160211 #1631:sougata
include("LIB/lib.php");

$orderId = trim($_REQUEST['orderId']);

if (!isset($orderId))
{
    echo'<script> window.location="'.site_url().'/session-expire?e=Order Id Not found"; </script> ';
    //header("location: session-expire.php?e=Order Id Not found");
}

//$hapi = new HAPI();
$hapi = new HAPI(CH_KEY, CH_SEC);

$dom = $hapi->getOrder(array('orderId' => $orderId));
$resDom = $dom->getElementsByTagName('response')->item(0);
$rsS = getResponseStatus($resDom);
if ($rsS['code'] != 1800)
{
    print "Invalid Order!";
    die;
}
#201201171105 #1631:sougata
$ownDet = array();
$owner = $dom->getElementsByTagName('owner')->item(0);
if ($owner->childNodes->length)
{
    foreach ($owner->childNodes as $i)
    {
        if ($i->nodeType != XML_ELEMENT_NODE)
            continue;

        $ownDet[$i->nodeName] = $i->nodeValue;
    }
}

     $test = $dom->getElementsByTagName('preference')->item(0);
echo '<div style="display:none;">';
print_r($test);
echo '</div>';
$bookings = $dom->getElementsByTagName('booking');
$order = $dom->getElementsByTagName('order')->item(0);



$totalamountNd = $dom->getElementsByTagName('orderamount')->item(0);
#201201200421 #1743:sougata change for decimal place
$paidAmountNd = $dom->getElementsByTagName('paidamount')->item(0);

$totalamount = $totalamountNd->getAttribute("amount");
$paidAmount = $paidAmountNd->getAttribute("amount");

$curCode = $bookings->item(0)->getAttribute('currencycode');
?>
<style>#ssb-container {
	display: none !important;
}</style>
        <table class="view-order table-responsive" style="width:100%">
            <tr>
                <th>
                    <table class="country">
                    <tr>
                        <td width="40%" nowrap="">
                            <strong>Name:</strong> <span> <?php echo $ownDet['fname']." ".$ownDet['lname'];?> </span>
                            <br><strong>Email:</strong> <?php echo $ownDet['email']?>
                            <br><strong>Phone:</strong> <?php echo $ownDet['phone']?>
                            <br><strong>Mobile:</strong> <?php echo $ownDet['mobile']?>
                            <br><strong>Country:</strong> <?php echo $ownDet['country']?>
                            <br><strong>State:</strong> <?php echo $ownDet['state']?>
                            <br><strong>Address:</strong> <?php echo $ownDet['address']?>
                            <br><strong>City:</strong> <?php echo $ownDet['city']?>
                            <br><strong>Zip:</strong> <?php echo $ownDet['zip']?>
                        </td>
                        <td>
                            <strong>Order Detail -</strong> <?php echo $orderId; ?>
                            <br/><strong>Total Amount:</strong> <?php echo displayPrice($totalamount, $curCode, 2) ?>
                            <br/><strong>Paid Amount:</strong> <?php echo displayPrice($paidAmount, $curCode, 2) ?>
                        </td>
                    </tr>
                    </table>
                </th>
            </tr>

            <tr>
                <th>
                    <?php
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
                        $statusCode = $booking->getAttribute("statuscode");
                        ?>
                        <table class="simple-table" width="100%">
                            <tr class="table-bg">
                                <td  width="20%"><strong>Room Type</strong></td >
                                <td width="50%"><strong>Booking Details</strong></td>
                                <td width="15%"><strong>Status</strong></td>
                                <td width="15%"><strong>Action</strong></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" >
                                    <span>Hotel: <?php echo $hotelName; ?></span><br/>
                                    <span>Rsv ID#: <?php echo $rsvIdHash; ?></span><br/>
                                    <span>Check In: <?php echo displayDate($checkIndate); ?></span><br/>
                                    <span>Check Out: <?php echo displayDate($checkOutdate); ?></span><br/>
                                    <span>Adult: <?php echo $adult; ?></span><br/>
                                    <span>Child: <?php echo $child; ?></span><br/>
                                    <br/>
                                    <span>RoomType:</span>
                                    <table class="booking-detains">
                                        <?php
                                        foreach ($roomtypes as $roomtype)
                                        {
                                            echo "<tr><td>";

                                            $roomName = $roomtype->getAttribute("title");
                                            ?>
                                            <span><?php echo $roomName; ?></span>
                                            <?php
                                            echo "</td></tr>";
                                        }
                                        ?>
                                    </table>
                                </td >
                                <td class="booking-detains">
                                    <?php
                                    $showSelect = FALSE;
                                    include('sr-rate-display.php');
                                    ?>
                                </td>
                                <td>
                                    <?php echo $statusCode; ?>
                                </td>
                                <td width="10%">
                                    <?php
                                    if ($statusCode != 'CANCEL')
                                    {
                                        ?>
                                        <a href="cancel-order?orderId=<?php echo $orderId ?>&itemId=<?php echo $id ?>">
                                            CANCEL</a>&nbsp;
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
                </th>
            </tr>
        </table>


    </body>
</html>
