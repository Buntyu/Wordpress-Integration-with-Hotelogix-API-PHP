<style>
    .price-table .table-button {
    display: block;
    width: 135px;
    text-align: center;
    margin: 0px 0px -4px 0;
    padding: 5px 0 !important;
}
.amenityd, .amenityh {
    font-size: 13px;

}
    .ctitle {
    font-size: 13px;
}
.usd {
    color: #464646;
    font-weight: bold;
    font-size: 16px;
}

.moredata {
    display: inline-block;
    width: 30%;
    margin-right: 15px;
    vertical-align: text-top;
}

.vvprice {
    font-size: 33px;
    line-height: 46px;
    color: #464646;
    font-weight: bold;
}


@media screen and (max-width: 510px) and (min-width: 438px) {
   .moredata {
    width: 45% !important;
}
}
@media screen and (max-width: 437px) {
   .moredata {
    width: 100% !important;
}
}

</style>

<?php
include("LIB/lib.php");


#201201160211 #1631:sougata

if (isset($_POST['from']))
{

    $arg = array(
        'checkindate' => $_POST['from']
        , 'checkoutdate' => $_POST['to']
        , 'adult' => $_POST['adult']
        , 'child' => $_POST['child']
        , 'infant' => 0
        , 'rooms' => 1
        , 'limit' => 200
        , 'offset' => 0
        , 'hasResult' => 0
    );

    $_SESSION['searchPost'] = $_POST;



}else if(isset($_SESSION['searchPost']) && $_SESSION['searchPost']!='')
{
   $arg = array(
        'checkindate' => $_SESSION['searchPost']['from']
        , 'checkoutdate' => $_SESSION['searchPost']['to']
        , 'adult' => $_SESSION['searchPost']['adult']
        , 'child' => $_SESSION['searchPost']['child']
        , 'infant' => 0
        , 'rooms' => 1
        , 'limit' => 200
        , 'offset' => 0
        , 'hasResult' => 1
    );


}else
{
   // header('location:session-expire.php');

}



//$hapiObj = new HAPI();

$hapiObj = new HAPI(CH_KEY, CH_SEC);

$xmlDom = $hapiObj->getSearchResult($arg);

//echo 'hotelplacio5';die;

$hotels = $xmlDom->getElementsByTagName('hotel');

foreach ($hotels as $hotel)
{

    $curCode = $hotel->getAttribute('currencycode');

//=-====-=======================Search result Head Gray section=========================================//
    ?>

            <div class="price-table">
                <div class="search-tittle">
                <span>
                    <?php
                        echo 'Search value:';
                        echo displayDate($arg['checkindate']).' to ';
                        echo displayDate($arg['checkoutdate']). ' With Adult:'.$arg['adult'].' Child:'.$arg['child'];
                    ?>
                </span>

                <?php
                    echo '<strong>'
                            . $hotel->getAttribute('title')
                            . '</strong> [Min Rate: '
                            . displayPrice($hotel->getAttribute('minRate'),$curCode)
							. ']';
					?>
				</div>
				<div class="table-responsive">

								<?php
									$rsS = getResponseStatus($hotel);

									if($rsS['code'] == 1400)
									{

//=-====-==============================================================================//

$roomTypes = $hotel->getElementsByTagName('roomtype');

$cnt=1;
foreach ($roomTypes as $roomType)
{
?>
								<?php if($cnt==1) { ?>

								<?php } $cnt=$cnt+1; ?>
<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth" style="background-color: #ffffff;background-position: center center;background-repeat: no-repeat;border: 1px solid #efefef;padding: 11px 0 12px 18px;margin: 10px 0;">
<div class="fusion-builder-row fusion-row ">

<div class="fusion-layout-column vimagelightbox fusion_builder_column fusion_builder_column_2_5  fusion-two-fifth fusion-column-first 2_5" style="margin-top:0px;margin-bottom:20px;width:40%;padding-top:9px;width:calc(40% - ( ( 4% ) * 0.4 ) );margin-right: 3%;">
<span class="fusion-imageframe imageframe-bottomshadow imageframe-1 element-bottomshadow hover-type-zoomin" style="width: 100%;">

	 <?php
 $i=(rand(10,100));
				$as= $roomType->getElementsByTagName('img');
				  $aty=$as->item(1);
				 $vedimg= $aty->getAttribute('src');
 $filename= basename($vedimg);
  $pathimg='https://www.hotelpalacio.net/mainimages/'.$filename;
				?>

				<div class="fusion-column-wrapper" style="diaplay:none;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
				<div class="imageframe-align-center">
				<div class="imageframe-liftup" style="width: 100% !important;">
				<span class="fusion-imageframe imageframe-none imageframe-5" style="width: 100%;">
				<a href="<?php echo $pathimg; ?>" class="fusion-lightbox" data-rel="iLightbox[<?php echo $i ; ?>]" data-title="landscape3" title="landscape3" data-caption="">
				<img src="<?php echo $pathimg; ?>" alt="" class="img-responsive wp-image-460" width="100%" >
				</a>
				</span>
				</div>
				</div>
				<div class="fusion-clearfix"></div>
				</div>

	</span><div class="fusion-clearfix"></div>

</div>

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_3_5  fusion-three-fifth fusion-column-last 3_5" style="margin-top:0px;margin-bottom:0px;width:60%;width:calc(60% - ( ( 4% ) * 0.6 ) );">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">

<div class="fusion-title title fusion-title-size-one fusion-border-below-title" style="margin-top:0px;margin-bottom:10px;">
<h2 class="title-heading-left" data-fontsize="44" data-lineheight="51" style="font-size: 24px;">
	<span><strong>
<?php
 echo $roomType->getAttribute('title')
	 . '<span class="vhead"> [Min Rate: '
	 . displayPrice($roomType->getAttribute('minRate'),$curCode)
	 . ']</span>';
?>
</strong></span>
</h2>
<div class="title-sep-container">
<div class="title-sep sep-single" style="border-color:#e0dede;">
</div></div></div>


<div class="fusion-builder-row fusion-builder-row-inner fusion-row ">


<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style="margin-top: 0px;margin-bottom: 7px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );margin-right:0%;">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">

	<?php
 #201201030615 #1641:sougata changes for fixing error in availibility check
 echo '<i class="fa fa-check-circle" style="font-size:14px;color:#cbaa5c;margin-right: 4px;"></i><span style="font-size: 14px;color: red;">No of Room Left: '.$roomType->getAttribute('availableroom').'</span>';
						?>
						<br>

					<i class="fa fa-check-circle" style="font-size:14px;color: #cbaa5c;margin-right: 4px;"></i><span class="amenityh">Base Occupancy: </span>
					<span class="amenityd"><?php
 echo $roomType->getAttribute('basepax');?> Person</span> <br>

</div>
</div>






<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last fusion-one-half fusion-column-last 1_2" style="margin-top: 0px;margin-bottom: 7px;width:50%;width:calc(50% - ( ( 4% ) * 0.5 ) );">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
	<i class="fa fa-check-circle" style="font-size:14px;color: #cbaa5c;margin-right: 4px;"></i><span class="amenityh">Maximum Occupancy: </span>
					<span class="amenityd"><?php echo $roomType->getAttribute('maxpax');?></span>
					<br>
					<i class="fa fa-check-circle" style="font-size:14px;color: #cbaa5c;margin-right: 4px;"></i><span class="amenityh">Minimum Room(s): </span>
					<span class="amenityd"><?=$roomType->getAttribute('minrooms')?></span>
</div>
</div>

</div>

	<!--=---=--=-=-=------>


	<!------------Full width------------>
	<!---==================-=-=--== Accordions-==-=-=-====================================---->
<ul class="fusion-checklist fusion-checklist-1" style="font-size:13px;line-height:22.1px;"><li class="fusion-li-item"><span style="height:22.1px;width:22.1px;margin-right:9.1px;" class="icon-wrapper circle-no"><i class="fusion-li-icon fa fa-bed" style="color:#cbaa5c;"></i></span>
</li><li class="fusion-li-item"><span style="height:22.1px;width:22.1px;margin-right:9.1px;" class="icon-wrapper circle-no"><i class="fusion-li-icon fa fa-wifi" style="color:#cbaa5c;"></i></span>
</li>
<li class="fusion-li-item"><span style="height:22.1px;width:22.1px;margin-right:9.1px;" class="icon-wrapper circle-no"><i class="fusion-li-icon fa fa-television" style="color:#cbaa5c;"></i></span></li>
<li class="fusion-li-item"><span style="height:22.1px;width:22.1px;margin-right:9.1px;" class="icon-wrapper circle-no">
<i class="fusion-li-icon fa fa-coffee" style="color:#cbaa5c;"></i>
</span></li>
<li class="fusion-li-item"><span style="height:22.1px;width:22.1px;margin-right:9.1px;" class="icon-wrapper circle-no">
<i class="fusion-li-icon fa fa-shower" style="color:#cbaa5c;"></i>
</span></li></ul>
<div class="fusion-builder-row fusion-builder-row-inner fusion-row ">
<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_1  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style="margin-top: 0px;margin-bottom: 20px;width:50%;width:calc(90% - ( ( 4% ) * 0.5 ) );margin-right:0%;">
<div class="accordian fusion-accordian">
<div class="panel-group" id="accordion-2862-1">
<div class="fusion-panel panel-default" style="border:none;">
<div class="panel-heading">
<h4 class="panel-title toggle" data-fontsize="18" data-lineheight="30"><a data-toggle="collapse" data-parent="#accordion-2862-1" data-target="#<?php $a=rand(10,1000);  echo $a;?>" href="#4cca742c0e2978d99" class="collapsed" ><div class="fusion-toggle-icon-wrapper"><i class="fa-fusion-box"></i></div><div class="fusion-toggle-heading" style="margin-left: 29px !important;">More About This Room</div></a></h4>
</div>
<div id="<?php echo $a; ?>" class="panel-collapse collapse" style="height: 0px;">

<div class="panel-body toggle-content">
<h2 style="margin-bottom: 0px; background: rgb(216, 183, 105) none repeat scroll 0% 0%; padding: 6px 0px 6px 16px; width: 93%; color: white;font-size: 16px;">Room Services</h2>
	<?php
	$amenity= $roomType->getElementsByTagName('amenity');

 foreach ($amenity as $amenities)
 {
 $dataamt= $amenities->getAttribute('title');
		echo  '<div class="moredata"><i class="fa fa-check-circle" style="font-size:14px;color:#cbaa5c;margin-right: 4px;"></i> <span class="amenityh">'.$dataamt.'</span></div>';
 }
	?>
<style type="text/css" scoped="scoped"> }</style>
</div>
</div>

</div></div>
	</div>
</div>
</div>
<div style="border-bottom: 1px solid #e5e4e3;width: 82%;margin-bottom: 0;margin-top: -17px;"></div>
<!----------Accordions End---------->
	<!------------------------>

<div class="fusion-builder-row fusion-builder-row-inner fusion-row ">

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-first fusion-one-half fusion-column-first 1_2" style="margin-top: 0px;margin-bottom: 0px;width:50%;width:calc(57% - ( ( 4% ) * 0.5 ) );margin-right:4%;font-size: 13px;">

<?php
	 $showSelect = true;
 $rates = $roomType->getElementsByTagName('rate');
 //=============
if ($rates)
{
    foreach ($rates as $rate)
    {
        if ($showSelect)
            $bookingPol = $rate->getElementsByTagName('bookingpolicy')->item(0);

                    $vtitle= $rate->getAttribute('title');
				//echo '<span class="ctitle">'.$vtitle.'</span>';



                    $descrt = $rate->getElementsByTagName('description')->item(0)->nodeValue;
                    if($descrt)
                    {
                       // echo "<br><font color=green size=2>Description :".$descrt."</font><br>";
                    }

                    $incls = $rate->getElementsByTagName('inclusion');
                    if ($incls->item(0))
                    {
                        echo '<br>Inclusions: ';
                        $inclSt = '';
                        foreach ($incls as $incl)
                        {
                            $inclSt.=$incl->getAttribute('title').", ";


                        }
                        echo '<span class="small-text">'
                        . rtrim($inclSt,", ") . '</span>';
                    }


                    if (!$showSelect)
                    {
                        $addonsprice = 0;
                        $addonsTax = 0;
                        $addons = $rate->getElementsByTagName('addon');
                        if ($addons->item(0))
                        {
                            echo '<br>Add-ons: ';
                            foreach ($addons as $addon)
                            {
                                $addonsprice+=$addon->getAttribute('price');
                                $addonsTax+=$addon->getAttribute('tax');
                                echo '<span class="small-text">' . $addon->getAttribute('title')
                                . '</span>, ';
                            }
                        }
                    }




					echo '<span style="display: block;font-size: 13px;line-height: 0;margin-left: 4px;color: #747474;">From</span>';
                    $vvprice= number_format($rate->getAttribute('price'), 2);

					echo '<span class="vvprice">'.$vvprice.'</span> <span class="usd">USD</span> / ';

                    if($rate->hasAttribute('tax'))
                    {
                        echo '<span class="vtaxtxt">Tax:</span><span class="vtax"> ';
                        echo displayPrice($rate->getAttribute('tax'), $curCode);
						echo "</span>";
					}
                    if (!$showSelect)
                    {
                        echo "<br/>Add-Ons: ";
                        echo displayPrice($addonsprice, $curCode);
                        echo "<br/>Add-Ons Tax: ";
                        echo displayPrice($addonsTax, $curCode);
                    }
?>
</div>

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_2  fusion-one-half fusion-column-last fusion-one-half fusion-column-last 1_2" style="margin-top: 0px;margin-bottom: 0px;width:50%;width:calc(39% - ( ( 4% ) * 0.5 ) );">
<?php


                    if ($showSelect)
                    {
                        ?>

						   <a class="table-button" href="<?php echo site_url(); ?>/add-to-cart/?itemId=<?php echo $rate->getAttribute('id') ?>">SELECT</a>
                        <?php
                    }
		if ($showSelect)
                    {

                        echo createBookingPolicyStr($bookingPol, $curCode);
                    }

    }
}

 //=================
					?>
</div>

</div>




<div class="fusion-clearfix"></div>
</div>
</div>

</div></div>
<div class="fusion-clearfix"></div>


<?php
}
//==============================================================///

									}else
									{
										echo $rsS['message'];
									}
									?>

				</div>
			</div>
    <?php
}
?>
<style>#ssb-container {
	display: none !important;
}</style>
