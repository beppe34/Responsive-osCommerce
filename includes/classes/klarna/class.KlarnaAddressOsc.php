<?php
/**
 * Address handling functions
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
require_once "class.KlarnaCore.php";

/**
 * Address handling class.
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class KlarnaAddressOsc
{

    /**
     * Helper function to get keys from an array
     *
     * @param string $key     The key to search for
     * @param array  $array   The array to search in
     * @param mixed  $default The default return value
     *
     * @return mixed
     */
    private function _key($key, array $array, $default = "")
    {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }

    /**
    * Build a KlarnaAddr from an osCommerce order address array, and takes
    * missing information from $_POST (collected from our checkout).
    *
    * @param array $oscAddr oscommerce order address array
    *
    * @return KlarnaAddr klarnaAddr object
    */
    public function oscAddressToKlarnaAddr($oscAddr)
    {
        $country = $this->_key("country", $oscAddr, array());
        $iso_code_2 = $this->_key("iso_code_2", $country);
        $logic = KiTT::countryLogic(KiTT::locale($iso_code_2));
        if ($logic->shippingSameAsBilling()) {
            $splitAddr = KiTT_Addresses::splitStreet(
                $this->_key("street_address", $oscAddr), $logic->getSplit()
            );
            $street = $this->_key("street", $splitAddr);
            $houseno = $this->_key("house_number", $splitAddr);
            $housext = $this->_key("house_extension", $splitAddr);
        } else {
            $street = $this->_key("street_address", $oscAddr);
            $houseno = "";
            $housext = "";
        }
        $address = new KlarnaAddr(
            KiTT_String::encode($this->_key("klarna_email", $_POST)),
            KiTT_String::encode($this->_key("klarna_phone", $_POST)),
            KiTT_String::encode($this->_key("klarna_phone", $_POST)),
            KiTT_String::encode($this->_key("firstname", $oscAddr)),
            KiTT_String::encode($this->_key("lastname", $oscAddr)),
            "",
            KiTT_String::encode($street),
            KiTT_String::encode($this->_key("postcode", $oscAddr)),
            KiTT_String::encode($this->_key("city", $oscAddr)),
            KiTT_String::encode($iso_code_2),
            KiTT_String::encode($houseno),
            KiTT_String::encode($housext)
        );
        return $address;
    }

    /**
     * Match an address from the checkout with an address from getAddress, and
     * return the matching address.
     *
     * @param string $option payment method
     *
     * @return object KlarnaAddr object
     */
    public function getMatchingAddress($option)
    {
        $pno = $this->_key("klarna_{$option}_pno", $_POST);

        $_SESSION['klarna_data']['pno'] = $pno;
        $_SESSION['klarna_data']['phone'] = $this->_key(
            "klarna_{$option}_phone_number", $_POST
        );
        $address = new KlarnaAddr;
        $KITTaddr = new KiTT_Addresses(KiTT::api(KiTT::locale('SE')));

        $address = $KITTaddr->getMatchingAddress(
            $pno,
            $this->_key("klarna_{$option}_address_key", $_POST)
        );
        $address->setTelno($this->_key("klarna_{$option}_phone_number", $_POST));
        $address->setCellno($this->_key("klarna_{$option}_phone_number", $_POST));
        $address->setEmail($this->_key("klarna_email", $_POST));

        return $address;
    }

    /**
     * Convert a given array to a KlarnaAddr object.
     *
     * @param array  $array   an array of customer data
     * @param string $country the customers country
     *
     * @return KlarnaAddr object
     */
    public function buildKlarnaAddressFromArray($array, $country)
    {
        $address = new KlarnaAddr(
            "",
            KiTT_String::encode($this->_key("phone_number", $array)),
            KiTT_String::encode($this->_key("phone_number", $array)),
            KiTT_String::encode($this->_key("first_name", $array)),
            KiTT_String::encode($this->_key("last_name", $array)),
            "",
            KiTT_String::encode($this->_key("street", $array)),
            KiTT_String::encode($this->_key("zipcode", $array)),
            KiTT_String::encode($this->_key("city", $array)),
            $country,
            KiTT_String::encode($this->_key("house_number", $array)),
            KiTT_String::encode($this->_key("house_extension", $array))
        );

        if ($this->_key("klarna_invoice_type", $array) == "company") {
            $address->isCompany = true;
            $address->setCompanyName(
                KiTT_String::encode($this->_key("company_name", $array))
            );
        }
        return $address;
    }

    /**
     * Handle the values from the checkout (in the _POST) so we can save and
     * use them later.
     *
     * @param string $option 'inv', 'part' or 'spec'
     *
     * @return array
     */
    public function addressArrayFromPost($option)
    {
        return array(
            "gender" => $this->_key("klarna_{$option}_gender", $_POST),
            "pno" => $this->_key("klarna_{$option}_pno", $_POST),
            "first_name" => $this->_key("klarna_{$option}_first_name", $_POST),
            "last_name" => $this->_key("klarna_{$option}_last_name", $_POST),
            "street" => $this->_key("klarna_{$option}_street", $_POST),
            "house_number" => $this->_key("klarna_{$option}_house_number", $_POST),
            "zipcode" => $this->_key("klarna_{$option}_zipcode", $_POST),
            "house_extension" => $this->_key(
                "klarna_{$option}_house_extension", $_POST
            ),
            "reference" => $this->_key("klarna_{$option}_reference", $_POST),
            "city" => $this->_key("klarna_{$option}_city", $_POST),
            "phone_number" => $this->_key("klarna_{$option}_phone_number", $_POST),
            "company_name" => $this->_key("klarna_{$option}_company_name", $_POST),
            "klarna_invoice_type" => $this->_key(
                "klarna_{$option}_invoice_type", $_POST
            )
        );
    }

    /**
     * Build an oscommerce address Array from a KlarnaAddr object.
     *
     * @param object $address KlarnaAddr object
     *
     * @return array oscommerce address
     */
    public function klarnaAddrToOscAddr($address)
    {
        global $order;
        return array(
            'firstname' => KiTT_String::decode($address->getFirstName()),
            'lastname' => KiTT_String::decode($address->getLastName()),
            'street_address' => KiTT_String::decode(
                $address->getStreet() . ' ' . $address->getHouseNumber() .
                ' ' . $address->getHouseExt()
            ),
            'postcode' => KiTT_String::decode($address->getZipCode()),
            'city' => KiTT_String::decode($address->getCity()),
            'telephone' => KiTT_String::decode($address->getTelNo()),
            'email_address' => KiTT_String::decode($address->getEmail()),
            'company' => KiTT_String::decode($address->getCompanyName()),

            //Set same country information as delivery
            'state' => $order->delivery['state'],
            'zone_id' => $order->delivery['zone_id'],
            'country_id' => $order->delivery['country_id'],
            'country' => array(
                'id' => $order->delivery['country']['id'],
                'title' => $order->delivery['country']['title'],
                'iso_code_2' => $order->delivery['country']['iso_code_2'],
                'iso_code_3' => $order->delivery['country']['iso_code_3']
            )
        );
    }
}
