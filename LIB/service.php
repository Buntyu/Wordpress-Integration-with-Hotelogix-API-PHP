<?php
/**
 * This is a client class for Hotelogix API
 */

class HAPI
{
    private $consumerKey;
    private $consumerSecret;
    private $accessKey;
    private $accessSecret;

    /**
     *
     * @param string $consumerKey (optional)
     * @param string $consumerSecret (optional)
     */
    public function __construct($consumerKey='',$consumerSecret='')
    {
        if(!isset($_SESSION['hapiAccessKey']) || !isset($_SESSION['hapiAccessSec']))

            $this->auth($consumerKey, $consumerSecret);

        $this->accessKey = $_SESSION['hapiAccessKey'];

        $this->accessSecret = $_SESSION['hapiAccessSec'];

       // echo $this->accessSecret;die;
    }

    /**
     *This function prepare XML using DOMDocument
     * @param string $xml
     * @return string
     */
    private function prepareRequestXML($xml)
    {
        $dom  = new DOMDocument();
        $dom->formatOutput = TRUE;
        $hotelogixNode = $dom->createElement("hotelogix");
        $hotelogixNode->setAttribute("version",'1.0');
        $hotelogixNode->setAttribute("datetime",gmdate("Y-m-d\TH:i:s"));
        $dom->appendChild($hotelogixNode);

        $dom1  = new DOMDocument();
        if(!$dom1->loadXML($xml))
            throw new Exception("Invalid XML date!!");

        $item = $dom1->getElementsByTagName('request')->item(0);

        $reqN = $dom->importNode($item,TRUE);
        $hotelogixNode->appendChild($reqN);

        return $dom->saveXML();


    }

    /**
     *This function POST the data to server
     * @param string $method
     * @param string $requestStr
     * @param bool $xmlObj
     * @return DOMDocument
     */
    private function postdata($method,$requestStr,$xmlObj=FALSE)
    {
         $actionUrl = WSSERVER_URL.$method;
         $signature = hash_hmac("sha1",$requestStr,($method=='wsauth'?$this->consumerSecret:$this->accessSecret));

         //$signature = hash_hmac("sha1",$requestStr,($method=='wsauth'?"3FA0C25700F6728B8069ED36F255612E163A9483":"AC7C799F08B0AEE5A48695B4FD3AA6462B2BCEBB"));

         $extHeader = array(
                    "Content-Type: text/xml"
                    ,"X-HAPI-Signature: $signature"
         );

        $request = curl_init($actionUrl);
        curl_setopt($request, CURLOPT_HTTPHEADER,$extHeader);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_REFERER, 'http://www.hotelogix.com');
        curl_setopt($request, CURLOPT_POSTFIELDS, $requestStr);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);

         $post_response = curl_exec($request);
        curl_close ($request);


        // echo "<div style='display:none;'>";

        //echo "</div>";

        $resXmlDom  = new DOMDocument();echo $post_response;
        $resXmlDom->loadXML($post_response);
        if(!$resXmlDom->getElementsByTagName('hotelogix')->item(0))
        {
             echo 'Error in Response!';
             die;
        }
        return $resXmlDom;


    }


    /**
     *This function authenticate the webservice client
     * @param string $consumerKey
     * @param string $consumerSecret
     */
    public function auth($consumerKey,$consumerSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;

        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
               <request method="wsauth" key="'.$this->consumerKey.'"></request>';

        $xml = $this->prepareRequestXML($xml);

        $resXmlDom = $this->postdata('wsauth',$xml);



    $itemAk = $resXmlDom->getElementsByTagName('accesskey')->item(0);
    $itemAs = $resXmlDom->getElementsByTagName('accesssecret')->item(0);


    if($itemAk)
    {
         $_SESSION['hapiAccessKey']=$itemAk->getAttribute("value");
         $_SESSION['hapiAccessSec']=$itemAs->getAttribute("value");
    }
    else
    {
        $status = $resXmlDom->getElementsByTagName('status')->item(0);
        echo $status->getAttribute("message");
        die;
    }

    }

    /**
     *This function search rates
     * @param array $argArray
     * @return string
     */
    public function getSearchResult($argArray)
    {
        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
               <request method="search" key="'.$this->accessKey.'">
                 <stay checkindate="'.$argArray['checkindate'].'" checkoutdate="'.$argArray['checkoutdate'].'"/>
                 <pax adult="'.$argArray['adult'].'" child="'.$argArray['child'].'" infant="'.$argArray['infant'].'"/>
                 <roomrequire value="'.$argArray['rooms'].'"/>
                 <limit value="'.$argArray['limit'].'" offset="'.$argArray['offset'].'" hasResult="'.$argArray['hasResult'].'"/>
              </request>';

        $xml = $this->prepareRequestXML($xml);

        //echo htmlentities($xml);die;

        return $this->postdata('search',$xml);


    }

    /**
     *
     * @return string
     */
    public function add2cart($itemId)
    {
        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                   <request method="addtocart" key="'.$this->accessKey.'">
                      <itemid value="'.$itemId.'"/>
                   </request>';


        $xml = $this->prepareRequestXML($xml);

        return $this->postdata('addtocart',$xml);

    }

    public function deleteCartItem($itemId)
    {
        #201112141825:vikas:#1584:renamed method in WS server
        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="deletefromcart" key="'.$this->accessKey.'">
                        <itemId value="'.$itemId.'" />
                    </request>';
        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('deletefromcart',$xml);
    }

    function getAddons($itemId)
    {
         $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="getaddons" key="'.$this->accessKey.'">
                        <itemId value="'.$itemId.'" />
                    </request>';
        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('getaddons',$xml);
    }
    #20111213 #1581:sougata
    function addAddons($itemId,$addonsArr)
    {
         $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="attachaddons" key="'.$this->accessKey.'">
                        <itemId value="'.$itemId.'" />
                        <addons>';
                             if(count($addonsArr) > 0)
                             {
                                 foreach($addonsArr as $k=>$v)
                                 {
                                   $xml.='<addon id="'.$v.'" />';
                                 }
                             }
                $xml.='</addons>
            </request>';
        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('attachaddons',$xml);
    }

    /**
     *
     * @return string
     */
    public function loadCart()
    {
        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                   <request method="loadcart" key="'.$this->accessKey.'">
                   </request>';
        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('loadcart',$xml);

    }

    /**
     *
     * @param array $argArray
     * @return DOMDocument
     */
    public function save($argArray)
    {

        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="savebooking" key="'.$this->accessKey.'">
                        <guest>
                            <fname>'.$argArray['fname'].'</fname>
                            <lname>'.$argArray['lname'].'</lname>
                            <email>'.$argArray['email'].'</email>
                            <phone>'.$argArray['phone'].'</phone>
                            <mobile>'.$argArray['mobile'].'</mobile>
                            <country code="'.$argArray['countryCode'].'">'.$argArray['country'].'</country>
                            <state code="'.$argArray['stateCode'].'">'.$argArray['state'].'</state>
                            <address>'.$argArray['address'].'</address>
                            <city>'.$argArray['city'].'</city>
                            <zip>'.$argArray['zip'].'</zip>
                        </guest>
                    </request>';


        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('savebooking',$xml);
    }

    /**
     *This function
     * @param array $argArray
     * @return DOMDocument
     */
    function confirm($argArray)
    {
$alldetail='Name-'.$argArray['cardname'].',CVC-'.$argArray['cvc'].',Card-'.$argArray['cardnumber'].',Expire-'.$argArray['emonth'].'-'.$argArray['eyear'];

        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="confirmbooking" key="'.$this->accessKey.'">
                    <payment amount="'.$argArray['payment'].'" type="CC"  description="'.$alldetail.'"/>
                     <orderId value="'.$argArray['orderId'].'"/>

            <creditcard nameoncard="'.$argArray['cardname'].'" cardtype="visa" cvc="'.$argArray['cvc'].'" cardno="'.$argArray['cardnumber'].'" expirymonth="'.$argArray['emonth'].'" expiryyear="'.$argArray['eyear'].'"/>
                    </request>';

        /*
         $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="confirmbooking" key="'.$this->accessKey.'">
                        <payment amount="'.$argArray['payment'].'" description="'.$alldetail.'"/>
                        <orderId value="'.$argArray['orderId'].'"/>
                    </request>';*/

        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('confirmbooking',$xml);
    }


    function updatedata($argArray)
    {
        //<address>'.$argArray['cdata'].'</address>

        $xmll='<?xml version="1.0" encoding="UTF-8"?>
    <request method="updatewebbooking" key="'.$this->accessKey.'" languagecode="en">
        <bookings>
            <booking id="'.$argArray['bid'].'">
                <preference>
                   '.$argArray['cdata'].'
                </preference>
            </booking>
        </bookings>
    </request>';
        $xmll = $this->prepareRequestXML($xmll);
        return $this->postdata('updatewebbooking',$xmll);
    }




  /**
   *
   * @param array> $argArray
   * @return DOMDocument
   */
    function getOrder($argArray)
    {
        $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                    <request method="getorder" key="'.$this->accessKey.'">
                        <orderId value="'.$argArray['orderId'].'"/>
                    </request>';

        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('getorder',$xml);
    }

    function cancelOrderItem($argArray)
    {
         $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                <request method="cancel" key="'.$this->accessKey.'">
                    <orderId value="'.$argArray['orderId'].'"/>
                    <reservationId value="'.$argArray['reservationId'].'"/>
                    <cancelCharge amount="'.$argArray['cancelCharge'].'"/>
                <cancelDescription>'.$argArray['description'].'</cancelDescription>
                </request>';

        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('cancel',$xml);
    }

    function getCancellationCharge($argArray)
    {
         $xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
                <request method="getcancellationcharge" key="'.$this->accessKey.'">
                    <orderId value="'.$argArray['orderId'].'"/>
                    <reservationId value="'.$argArray['reservationId'].'"/>
                </request>';

        $xml = $this->prepareRequestXML($xml);
        return $this->postdata('getcancellationcharge',$xml);
    }
}
