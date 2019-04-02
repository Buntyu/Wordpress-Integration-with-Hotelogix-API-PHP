<?php
#20111213 #1581:sougata
#20111213 #1581:sougata
#20111214 #1581:sougata
#201201160211 #1631:sougata
$bookings = $hotel->getElementsByTagName('booking');
foreach ($bookings as $booking)
{
    $roomType = $booking->getElementsByTagName('roomtype')->item(0);
    $rate = $booking->getElementsByTagName('rate')->item(0);
    $addons = $rate->getElementsByTagName('addon');

    #20111215:arup #1581 add booking policy node
    $bookingNode = $booking->getElementsByTagName('bookingpolicy')->item(0);
    ?>


    <tr>
        <td>
            <?php echo $roomType->getAttribute('title'); ?>
        </td>
                
		<td>
			<span>
				<?php echo
				$rate->getAttribute('title'); ?>
			</span>
			
			<?php
				$descrt = $rate->getElementsByTagName('description')->item(0)->nodeValue;
				if($descrt)
				{
					echo "<br><font color=green size=2>Description :".$descrt."</font>";
				}
			?>
			<span>

					<?php
					$incls = $rate->getElementsByTagName('inclusion');
					$inclIdsArr=array();
					if ($incls->item(0))
					{
						echo '<br>Inclusions: ';
						foreach ($incls as $incl)
						{
							$inclIdsArr[] = $incl->getAttribute('id');
							echo '<span>' . $incl->getAttribute('title') . '</span>, ';
						}
					}
					?>
				</span>


			<span>
					<?php
					$ams = $roomType->getElementsByTagName('amenity');
					if ($ams->item(0))
					{
						echo '<br>Amenities: ';
						$amstr ='';
						foreach ($ams as $am)
						{
							$amstr.=$am->getAttribute('title').", ";                                        
							
						}
						echo '<span>' . rtrim($amstr,", ") . '</span>';
					}
					?>
			</span>                  


		
               
                <?php
                $addonIdsArr  =array();
                if ($addons->item(0))
                {
                    $addStr = '';
                    
                    foreach ($addons as $addon)
                    {
                        $addStr.=$addon->getAttribute("title") . ", ";
                        $addonIdsArr[]=$addon->getAttribute("id");
                    }
                    ?>
                            Add-Ons: <span><?php echo rtrim($addStr,', '); ?></span>  
                    <?php
                }
                ?>
		</td>
            
        <td>
            <?php
            echo displayDate($booking->getAttribute('checkindate')) . " to " . displayDate($booking->getAttribute('checkoutdate'));
            ?>
        </td>
		
        <td>
			Adults:
            <?php echo $booking->getAttribute('adult'); ?>    
            Children: 
            <?php echo $booking->getAttribute('child'); ?>
                  
                
                <!-- <tr>
                    <td align="left">Infant:</td>
                    <td align="left">
                        <?php echo $booking->getAttribute('infant'); ?>
                    </td>
                </tr> -->

        </td>
        
		<td>
            <?php echo displayPrice($rate->getAttribute('price'), $currCode); ?>
		</td>

        
        <td style="text-align:center;">
            1
        </td>
        <td width="20%">

           
                            <?php
								$total=$rate->getAttribute('price')+$rate->getAttribute('tax');
                                echo displayPrice($rate->getAttribute('price'), $currCode);
                                echo "<br>Tax: ".displayPrice($rate->getAttribute('tax'), $currCode);
                                echo "<br/>".createBookingPolicyStr($bookingNode, $currCode);
                            ?>
                       
                 <?php
                if ($addons->item(0))
                {
                    $addTotPrice=0;
                    $addTotTax=0;
                    foreach ($addons as $addon)
                    {
                        $addTotPrice+=$addon->getAttribute("price");
                        $addTotTax+=$addon->getAttribute("tax");
                    }
                    ?>
                    <div>
                        Add-Ons: 
							<?php  
								echo displayPrice($addTotPrice, $currCode);
								echo "<br>Add-Ons Tax: ". displayPrice($addTotTax, $currCode);
								$total=$total+$addTotPrice+$addTotTax;
								?>
                    </div>
                    <?php
                }
                $_SESSION['total']=$total;
                $addInclArr = array_merge($inclIdsArr,$addonIdsArr);              
                $attachedIncls = implode(',', $addInclArr);
                ?>
        </td>
		
        <td>
            <a href="<?php echo site_url(); ?>/delete-cart-item?itemId=<?php echo $booking->getAttribute('id'); ?>" class="table-button"> Remove </a>
            <br />
            <br />
        
            <a href="javascript:void(0);" class="table-button addonbtn" 
               onclick="openWin('<?php echo $booking->getAttribute('id'); ?>','<?php echo $attachedIncls; ?>')" > Add-Ons </a>

		</td>

    <?php
}