<?php
#20111213 #1581:sougata
#201201160211 #1631:sougata
include("LIB/lib.php");
//$hapiObj = new HAPI();
$hapiObj = new HAPI(CH_KEY, CH_SEC);

$cartXmlDom = $hapiObj->loadCart();
//print $cartXmlDom->saveXML();
?>
<script>
    function openWin(itemId,attached){
	window.open('get-addons?itemId='+itemId+"&attached="+attached, 'ado', "width=500,height=500,scrollbars=yes");}
</script>
<style>#ssb-container {
	display: none !important;
}</style>
<?php
$hotels = $cartXmlDom->getElementsByTagName('hotel');

        if(isset($_REQUEST['m']))
            echo urldecode($_REQUEST['m']);
        ?>

        <?php
        foreach ($hotels as $hotel)
        {

            $currCode = $hotel->getAttribute('currencycode');
            ?>
			<div class="table-responsive cart">
				<table class="simple-table">
					<tr class="table-bg">
						<td width="10%"><strong>Room Type</strong></td>
						<td width="30%"><strong>Package/Rate Detail</strong></td>
						<td width="15%"><strong>Arrival-Departure</strong></td>
						<td><strong>Person(s)</strong></td>
						<td><strong>Price</strong></td>
						<td><strong>Room(s)</strong></td>
						<td><strong>Amount</strong></td>
						<td width="10%"><strong>Action</strong></td>
					</tr>
						<?php include('cart-item.php'); ?>
				</table>
			</div>
            <?php
        }
        ?>
        <br>
       <div class="centre-button">
            <a class="table-button" href="<?php echo site_url(); ?>/search-result" class="link-details" > Add Rooms </a>&nbsp;&nbsp;&nbsp;
            <a class="table-button" href="<?php echo site_url(); ?>/guest-detail" class="link-details" >Proceed Guest Details ></a>
        </div>
