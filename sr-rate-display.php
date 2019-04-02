<?php
#20111213 #1581:sougata
#20111214 #1581:sougata
#201201160211 #1631:sougata
if ($rates)
{
    foreach ($rates as $rate)
    {
        if ($showSelect)
            $bookingPol = $rate->getElementsByTagName('bookingpolicy')->item(0);
        ?>
        <table style="width:100%;">
            <tr>
                <td>
                    <?php
		
                    echo $rate->getAttribute('title');
		
					
		
		
                    $descrt = $rate->getElementsByTagName('description')->item(0)->nodeValue;
                    if($descrt)
                    {
                        echo "<br><font color=green size=2>Description :".$descrt."</font>";
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
                    ?>
                </td>
                <td>
                    <?php
                    echo displayPrice($rate->getAttribute('price'), $curCode);
                    if($rate->hasAttribute('tax'))
                    {
                        echo "<br/>Tax: ";
                        echo displayPrice($rate->getAttribute('tax'), $curCode);
                    }
                    if (!$showSelect)
                    {
                        echo "<br/>Add-Ons: ";
                        echo displayPrice($addonsprice, $curCode);
                        echo "<br/>Add-Ons Tax: ";
                        echo displayPrice($addonsTax, $curCode);
                    }

                    if ($showSelect)
                    {
                        echo "<br/>";
                        echo createBookingPolicyStr($bookingPol, $curCode);
                    }
                    ?>
                </td>

                <td>
                    <?php
                    if ($showSelect)
                    {
                        ?>
						   <a class="table-button" href="<?php echo site_url(); ?>/add-to-cart/?itemId=<?php echo $rate->getAttribute('id') ?>">SELECT</a>
                        <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
        
        <?php
    }
}