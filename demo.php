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
    //header('location:session-expire.php');
}

//$hapiObj = new HAPI();
$hapiObj = new HAPI(CH_KEY, CH_SEC);

$xmlDom = $hapiObj->getSearchResult($arg);
$hotels = $xmlDom->getElementsByTagName('hotel');


foreach ($hotels as $hotel)
{

    $curCode = $hotel->getAttribute('currencycode');
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
					<table>
						<tr>
							<td>
								<?php
									$rsS = getResponseStatus($hotel);
									if($rsS['code'] == 1400)
									{
										include('sr-roomtype-display.php');
									}else
									{
										echo $rsS['message'];
									}
									?>
							</td>
						</tr>
					</table>
				</div>
			</div>
    <?php
}
?>
<style>#ssb-container {
	display: none !important;
}</style>
