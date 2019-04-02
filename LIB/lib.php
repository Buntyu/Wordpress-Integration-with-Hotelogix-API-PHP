<?php
//session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(session_id() == '')
{
    session_id("crsclienttest");
}
#20111210 #1581:sougata
#20111213 #1581:sougata
#20111214 #1581:sougata
#20111229 #1581:sougata change session name to keep fd session
ob_start();
if((!isset($_SESSION['hapiAccessKey']) || !isset($_SESSION['hapiAccessSec']))
        && basename($_SERVER['SCRIPT_FILENAME']) != 'index.php')
{
  header('location:session-expire.php?e=Session Expired.');
}

include("config.php");
include("service.php");

?>
<div class="heading-title vhome">
    <a href="<?php echo site_url(); ?>/search-order">Search Order</a>
    <a href="<?php echo site_url(); ?>/cart">View Cart</a>
</div>
<?php
function my_xml2array($contents)
{
    $xml_values = array();
    $parser = xml_parser_create('');
    if(!$parser)
        return FALSE;

    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values)
        return array();

    $xml_array = array();
    $last_tag_ar =& $xml_array;
    $parents = array();
    $last_counter_in_tag = array(1=>0);
    foreach ($xml_values as $data)
    {
        switch($data['type'])
        {
            case 'open':
                $last_counter_in_tag[$data['level']+1] = 0;
                $new_tag = array('name' => $data['tag']);
                if(isset($data['attributes']))
                    $new_tag['attributes'] = $data['attributes'];
                if(isset($data['value']) && trim($data['value']))
                    $new_tag['value'] = trim($data['value']);
                $last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag;
                $parents[$data['level']] =& $last_tag_ar;
                $last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++];
                break;
            case 'complete':
                $new_tag = array('name' => $data['tag']);
                if(isset($data['attributes']))
                    $new_tag['attributes'] = $data['attributes'];
                if(isset($data['value']) && trim($data['value']))
                    $new_tag['value'] = trim($data['value']);

                $last_count = count($last_tag_ar)-1;
                $last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag;
                break;
            case 'close':
                $last_tag_ar =& $parents[$data['level']];
                break;
            default:
                break;
        };
    }
    return $xml_array;
}

function displayPrice($price,$currCode,$decimals = 2)
{
    if($price=='')
        $price = 0.00;
    return number_format($price, $decimals)." ".$currCode;
}
function getResponseStatus($xmlDomNode)
{
    $retArr = array();
    $retArr['code'] = $xmlDomNode->getElementsByTagName('status')->item(0)->getAttribute('code');
    $retArr['message'] = $xmlDomNode->getElementsByTagName('status')->item(0)->getAttribute('message');

    return $retArr;

}

function displayDate($date)
{
    if($date=='')
        return '';
    $date = new DateTime($date);
    return  $date->format('D M d, Y');
}
#201201160211 #1631:sougata
function createBookingPolicyStr($bookingNode, $currCode)
{

    $chargeType = $bookingNode->getAttribute('chargetype');
    $charge = $bookingNode->getAttribute('charge');
    $depositType = $bookingNode->getAttribute('deposittype');
    $depositAmount = $bookingNode->getAttribute('depositamount');

    $str = "";
    $str1 = "";

    #20111216:arup #1581 add check for credit card guarantee, change spelling
    if($chargeType == 'FV')
        $str1 = displayPrice($charge, $currCode) ." deposit";
    else if($chargeType == 'RN')
        $str1 = $charge ." Room Night";
    else
        $str1 =$charge."%  deposit";

    if($depositType == 'NA')
    {
        $str = "No Deposit";
    }
    elseif($depositType == 'CCD')
    {
        $str = "Credit Card Required with";
    }
    elseif($depositType == 'CCG')
    {
        $str = "Credit card guarantee";
    }
    elseif($depositType == 'CCR')
    {
        $str = "Credit Card Required with";
    }
    elseif($depositType == 'DEP')
    {
        $str = "Credit Card Required with ";
    }

    if($depositType == 'CCD' || $depositType == 'CCR' || $depositType == 'DEP')
    {
        $str = $str." ".$str1. " <br/>Deposit Amount: ".displayPrice($depositAmount, $currCode);
    }

    return '<span style="font-size:10px;">'.$str.'</span>';


}
