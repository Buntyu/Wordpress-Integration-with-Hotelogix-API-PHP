<?php



$roomTypes = $hotel->getElementsByTagName('roomtype');

$cnt=1;
foreach ($roomTypes as $roomType)
{
?>
    <table class="standard" width="100%">
        <?php if($cnt==1) { ?>
		
		<tr class="table-bg">
            <td align="center"><strong>Room Type</strong></td >
            <td align="center"><strong>
				Package Details</strong>
			</td>
        </tr>
		
		<?php } $cnt=$cnt+1; ?>
		
		<tr>
			<td align="left" valign="top" >
		
				<span>
					<strong>
						<?php 
 
						echo $roomType->getAttribute('title') 
								. ' [Min Rate: ' 
								. displayPrice($roomType->getAttribute('minRate'),$curCode) 
								. ']';
						?>
					</strong></span>
				</br>
				<?php
					#201201030615 #1641:sougata changes for fixing error in availibility check
					echo "<font color=red>No of Room Left: ".$roomType->getAttribute('availableroom')."</font>";
				?>
				</br>
				
			<table>
			  <tr >
				<td class="vimg">
				   <span class="amenityh">Base Occupancy: </span>
					<span class="amenityd"><?php
					echo $roomType->getAttribute('basepax');?> Person</span> <br>
				  <span class="amenityh">Maximum Occupancy: </span>
					<span class="amenityd"><?php echo $roomType->getAttribute('maxpax');?></span>
				  <br>
				  <span class="amenityh">Minimum Room(s): </span>
					<span class="amenityd"><?=$roomType->getAttribute('minrooms')?></span>
				  </td>
				<td class="vimg vimgs">
					
				 <?php 
				$as= $roomType->getElementsByTagName('img');
				  $aty=$as->item(1);
				 $vedimg= $aty->getAttribute('src');
 
				?>
					
				<div class="fusion-column-wrapper" style="diaplay:none;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
				<div class="imageframe-align-center">
				<div class="imageframe-liftup">
				<span class="fusion-imageframe imageframe-none imageframe-5">
				<a href="<?php echo $vedimg; ?>" class="fusion-lightbox" data-rel="iLightbox[landscape]" data-title="landscape3" title="landscape3" data-caption="">
				<img src="<?php echo $vedimg; ?>" alt="" class="img-responsive wp-image-460" width="100px" height="100px">
				</a>
				</span>
				</div>
				</div>
				<div class="fusion-clearfix"></div>
				</div>
				
				  </td>
			  </tr>
			</table>



			  </td >


			  <td valign="top">
				  <?php
				  $showSelect = true;
				  $rates = $roomType->getElementsByTagName('rate');
				  include('sr-rate-display.php');
				  ?>                      
			  </td>
		</tr>

    </table>
<?php
}
?>