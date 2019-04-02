<?php
#20111213 #1581:sougata
#201201160211 #1631:sougata
include("LIB/lib.php");
//$h = new HAPI();
$h = new HAPI(CH_KEY, CH_SEC);

$xmlDom = $h->getAddons($_REQUEST['itemId']);
//print $xmlDom->saveXML();
$curCode = '';
$addons = $xmlDom->getElementsByTagName('addon');

if($addons->item(0))
{
    $curCode = $addons->item(0)->getAttribute('currencyCode');
}

$attached = $_REQUEST['attached'];
$attachedArr = explode(",", $attached);
?>
<style>#ssb-container {
    display: none !important;
}</style>
        <form method="POST" action="<?php echo site_url(); ?>/add-addons" name="frm" id="frm">
            <input type="hidden" name="itemId" value="<?php echo $_REQUEST['itemId']?>"/>
			<div class="table-responsive cart">
				<table style="width:100%;" class="simple-table">
					<tr class="table-bg">
						<td>&nbsp;</td>
						<td><strong>Inclusions</strong></td>
						<td><strong>Description</strong></td>
						<td><strong>Price</strong></td>
					</tr>
					<?php
					if($addons->length>0)
					{
						foreach ($addons as $addon)
						{
							$checked = '';
							if(in_array($addon->getAttribute("id") , $attachedArr))
									$checked = ' checked="checked" ';
							?>
							<tr>
								<td width="6%">
									<input type="checkbox" <?php echo $checked;?> name="addchk[]"
										   value="<?php echo $addon->getAttribute("id") ?>" /></td>

								<td width="24%">
								   <?php echo $addon->getAttribute('title'); ?><br>
									<span class="colorgrey01" style="font-size:10px;"></span>
								</td>
								<td width="39%">
									<?php echo $addon->getAttribute('description'); ?></td>
								<td width="13%">
									<?php echo displayPrice($addon->getAttribute('price'), $curCode); ?><br></td>

							</tr>
							<?php
						}
					?>
					<tr class="table-bg">
						<td colspan="4" align="center">
							<input class="table-button" type="button" name="btnAddons" value="Add" onclick="addAddonsfrmSubmit()"/>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
        </form>
