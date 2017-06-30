<?php
/**
 * Shared class of utils
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
require_once "class.KlarnaAddressOsc.php";
include_once(DIR_FS_CATALOG . 'includes/classes/log.php');
/**
 * Klarna Utils Class, containing shared functions.
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class KlarnaUtils
{
    private $_country;
    private static $_kLang;

    private static $_countryMap = array();
    private static $_languageMap = array();

    public static $prefillData;

    /**
     * The constructor
     *
     * @param string|int $country alpha-2 country code or KlarnaCountry constant.
     *
     * @return void
     */
    public function __construct($country = null)
    {
\log::w("KlarnaUtils.php __construct Session: " . $_SESSION['klarna_data']['serial_addr']);
        if ($country === null) {
            $country = self::getCountryByID(STORE_COUNTRY);
        } else if (is_numeric($country)) {
            $country = KlarnaCountry::getCode($country);
        } else {
            $country = strtolower($country);
        }
        $this->_country = $country;
    }

    /**
     * Configure KiTT
     *
     * @param string $option payment option
     *
     * @return void
     */
    public static function configureKiTT($option = null)
    {
\log::w("KlarnaUtils.php configureKiTT Session: " . $_SESSION['klarna_data']['serial_addr']);
        // KiTT Configuration
        $mode = KlarnaConstant::mode($option);
        $configuration = array(
            'default' => STORE_COUNTRY,
            'module' => 'osCommerce',
            'version' => KlarnaCore::getCurrentVersion(),
            'api' => array(
                'mode' => ($mode === null) ? Klarna::BETA : $mode,
                'pcStorage' => 'mysql',
                'pcURI' => KlarnaConstant::pcURI()
            ),
            'paths' => array(
                'kitt' => DIR_KLARNA . '/KITT/',
                'lang' => DIR_KLARNA . '/KITT/data/language.json',
                'extra_templates' => DIR_KLARNA . 'template/',
                'lookup' => DIR_KLARNA . '/KITT/data/lookupTable.json',
                'input' => DIR_KLARNA . '/KITT/data/inputFields.json'
            ),
            'web' => array(
                'root' => self::getWebRoot(),
                'js' => self::getWebRoot() . 'ext/jquery/klarna/',
                'ajax' => self::getWebRoot() . 'klarnaAjax.php'
            ),
            'collapse' => true,
            'selector' => ".moduleRow, .moduleRowSelected, input[name=payment]"
        );

        KiTT::configure($configuration);
        KiTT::setFormatter(new oscFormat);
    }

    /**
     * Set an instance of the API.
     *
     * @param Klarna $klarna Klarna API object
     *
     * @return void
     */
    public function setApi($klarna)
    {
        $this->_klarna = $klarna;
    }

    /**
    * Checking for newer version at klarnas website.
    * If a new version is found it outputs information about it as HTML.
    *
    * @return void
    */
    public function checkForLatestVersion()
    {
\log::w("KlarnaUtils.php checkForLatestVersion Session: " . $_SESSION['klarna_data']['serial_addr']);                        
        $sURL = 'http://static.klarna.com:80/external/msbo/' .
            'osc231.latestversion.txt';
        $version = KlarnaCore::getCurrentVersion();
        $latest = @file_get_contents($sURL);
        $templateLoader = KiTT::templateLoader(KiTT::Locale($this->_country));
        if (version_compare($latest, $version, '>') ) {
            $latestVersion = $templateLoader->load('newversion.mustache');
            echo $latestVersion->render(
                array('version' => $version, 'latest' => $latest)
            );
        }
    }

    /**
     * Retrieve the language code chosen/used by the store. Defaults to the
     * store default language.
     *
     * @return string
     */
    public static function getLanguageCode()
    {
        global $languages_id, $lng;
\log::w("KlarnaUtils.php getLanguageCode Session: " . $_SESSION['klarna_data']['serial_addr']);                

        if (is_array($lng)) {
            foreach ($lng->catalog_languages as $code => $language) {
                if ($language['id'] === $languages_id) {
                    return $code;
                }
            }
        }
        return self::getLanguageByID($languages_id);
    }

    /**
     * Attempt to guess customer country to determine if things should be shown.
     *
     * @param string $option payment option
     *
     * @return string or null
     */
    public static function deduceCountry($option)
    {
        global $currency, $customer_country_id;
\log::w("KlarnaUtils.php deduceCountry Session: " . $_SESSION['klarna_data']['serial_addr']);        
        $addr = null;
        if ($customer_country_id !== null) {
            $addr = new KlarnaAddr();
            $addr->setCountry(self::getCountryByID($customer_country_id));
        }

        $lang = self::getLanguageCode();
        self::configureKiTT($option);
        self::configureKlarna($option);

        return KiTT::locator()->locate($currency, $lang, $addr);
    }

    /**
    * Get the WebRoot of the store.
    *
    * @return string   the web root uri.
    */
    public static function getWebRoot()
    {
\log::w("KlarnaUtils.php getWebRoot Session: " . $_SESSION['klarna_data']['serial_addr']);        
        global $request_type;
        return (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) .
            DIR_WS_CATALOG;
    }

    /**
    * Get the path to the image dir for the module.
    *
    * @return string   the img root uri.
    */
    public static function getExternalKiTTPath()
    {
        return '//cdn.klarna.com/public/kitt';
    }

    /**
    * Used for error encodings.
    *
    * @param string        $string    string to encode
    * @param boolean|array $translate to translate or not
    * @param boolean       $protected protected or not
    *
    * @return string
    */
    public function klarnaOutputString(
        $string, $translate = false, $protected = false
    ) {
\log::w("KlarnaUtils.php klarnaOutputString Session: " . $_SESSION['klarna_data']['serial_addr']);                
        if ($protected == true) {
            return htmlspecialchars($string);
        }
        if ($translate == false) {
            return tep_parse_input_field_data(
                $string, array('"' => '&quot;')
            );
        }
        return tep_parse_input_field_data($string, $translate);
    }

    /**
     * Get language iso-2 code by oscommerce ID from the database
     *
     * @param int $id language id
     *
     * @return string
     */
    public static function getLanguageByID($id)
    {
\log::w("KlarnaUtils.php getLanguageByID Session: " . $_SESSION['klarna_data']['serial_addr']);        
        if (isset(self::$_languageMap[$id])) {
            return self::$_languageMap[$id];
        }
        $query = tep_db_query(
            "SELECT code, languages_id FROM languages"
        );
        while ($res = tep_db_fetch_array($query)) {
            self::$_languageMap[$res['languages_id']] = $res['code'];
        }
        return self::$_languageMap[$id];
    }

    /**
     * Get country iso-2 code by oscommerce ID from the database
     *
     * @param int $id country id
     *
     * @return string
     */
    public static function getCountryByID($id)
    {
\log::w("KlarnaUtils.php getCountryByID Session: " . $_SESSION['klarna_data']['serial_addr']);        
        if (isset(self::$_countryMap[$id])) {
            return self::$_countryMap[$id];
        }
        $query = tep_db_query(
            "SELECT countries_iso_code_2, countries_id FROM countries"
        );
        while ($res = tep_db_fetch_array($query)) {
            self::$_countryMap[$res['countries_id']] = $res['countries_iso_code_2'];
        }
        return self::$_countryMap[$id];
    }

    /**
    * Get the wanted country.
    * Fallback to getting from database based on $_SESSION variable
    *
    * @param object|array $arg order object/array
    *
    * @return string ISO-3166-1 alpha 2 code
    */
    public static function getCountry($arg)
    {
\log::w("KlarnaUtils.php getCountry Session: " . $_SESSION['klarna_data']['serial_addr']);
        if (is_object($arg) && is_array($arg->delivery)) {
            $arg = $arg->delivery;
        }
        if (is_array($arg)) {
            if (is_array($arg['country'])
                && isset($arg['country']['iso_code_2'])
            ) {
                return $arg['country']['iso_code_2'];
            }
            if (!is_array($arg['country'])) {
                return $arg['country'];
            }
        }
        if (isset($arg['country_id'])) {
            return self::getCountryByID($arg['country_id']);
        }
        $customers_id = (int) $_SESSION['customer_id'];
        $address_id = (int) $_SESSION['billto'];
        $query = tep_db_query(
            "SELECT `entry_country_id` FROM `address_book` ".
            "WHERE `customers_id`={$customers_id} AND ".
            "`address_book_id`={$address_id}"
        );
        $result = tep_db_fetch_array($query);

        return self::getCountryByID($result['entry_country_id']);
    }

    /**
     * Get invoice fee for given country.
     *
     * @return int|float invoice fee for given country.
     */
    public function getInvoiceFee()
    {
\log::w("KlarnaUtils.php getInvoiceFee Session: " . $_SESSION['klarna_data']['serial_addr']);                
        $country = strtoupper($this->_country);
        if (MODULE_KLARNA_FEE_MODE == 'fixed') {
            if (defined("MODULE_KLARNA_FEE_FIXED_{$country}")) {
                return constant("MODULE_KLARNA_FEE_FIXED_{$country}");
            }
            return 0;
        }
        if (defined("MODULE_KLARNA_FEE_TABLE_{$country}")) {
            $fee_table = constant("MODULE_KLARNA_FEE_TABLE_{$country}");
            $table = explode(",", $fee_table);

            $size = sizeof($table);
            $amount = $this->getCartSum();
            foreach ($table as $rule) {
                list($limit, $cost) = explode(":", $rule);
                if ($amount <= $limit) {
                    return $cost;
                }
            }
        }
        return 0;
    }

    /**
     * Clear errors
     *
     * @return void
     */
    public function clearErrors()
    {
        unset($_SESSION['klarna_error']);
    }

    /**
    * Set the Error Message and which box caused it.
    *
    * @param string $errorString error message
    * @param string $errorBox    payment box, invoice, part or spec
    *
    * @return void
    */
    public function setError($errorString, $errorBox)
    {
        $_SESSION['klarna_error']['message'] = addslashes($errorString);
        $_SESSION['klarna_error']['box'] = $errorBox;
    }

    /**
    * Get errors from the Session Variable
    *
    * @return string error message stored in session
    */
    public function getError()
    {
        return htmlentities(
            $_SESSION['klarna_error']['message'], ENT_COMPAT, 'UTF-8'
        );
    }

    /**
    * Get the box where the error occured.
    *
    * @return string payment box that caused the error; invoice, part or spec
    */
    public function getErrorOption()
    {
        return $_SESSION['klarna_error']['box'];
    }

    /**
    * Populate an array with customer information
    *
    * @param object $order osCommerce order object
    *
    * @return array
    */
    public function collectKlarnaData($order)
    {
        global $customer_id;
\log::w("KlarnaUtils.php collectKlarnaData Session: " . $_SESSION['klarna_data']['serial_addr']);        

        $klarna_data = array();

        $klarna_data['phone_number'] = $order->customer['telephone'];
        $klarna_data['email_address'] = $order->customer['email_address'];
        $klarna_data['reference']= $order->delivery['firstname'] . " " .
            $order->delivery['lastname'];

        $logic = KiTT::countryLogic(KiTT::locale($this->_country));

        $address = KiTT_Addresses::splitStreet(
            $order->delivery['street_address'], $logic->getSplit()
        );
        $klarna_data = array_merge($klarna_data, $address);

        if ($logic->needDateOfBirth()) {
            // Get date of birth
            $customer_query = tep_db_query(
                "SELECT DATE_FORMAT(customers_dob, ".
                "'%d%m%Y') AS customers_dob from " .
                TABLE_CUSTOMERS . " where customers_id = '" .
                (int)$customer_id."'"
            );

            $customer = tep_db_fetch_array($customer_query);
            $dob = $customer['customers_dob'];

            $klarna_data['birth_year'] = substr($dob, 4, 4);
            $klarna_data['birth_month'] = substr($dob, 2, 2);
            $klarna_data['birth_day'] = substr($dob, 0, 2);
        }

        $klarna_data['first_name'] = $order->delivery['firstname'];
        $klarna_data['last_name'] = $order->delivery['lastname'];
        $klarna_data['city'] = $order->delivery['city'];
        $klarna_data['zipcode'] = $order->delivery['postcode'];
        $klarna_data['company_name'] = $order->delivery['company'];

        foreach ($klarna_data as $key => $value) {
            $klarna_data[$key] = KiTT_String::encode($value, null, 'UTF-8');
        }

        return $klarna_data;
    }

    /**
    * Get values for the HTML prefilling from the session if we happen to be
    * returning from a failed purchase.
    *
    * @return array values for the HTML prefilling
    */
    public function getValuesFromSession()
    {
\log::w("KlarnaUtils.php getValuesFromSession Session: " . $_SESSION['klarna_data']['serial_addr']);        
        if (isset($_SESSION['klarna_data'])) {
            self::$prefillData = $_SESSION['klarna_data'];
            unset($_SESSION['klarna_data']);
        }

        $fields = array(
            'first_name',
            'last_name',
            'street',
            'city',
            'zipcode',
            'phone_number',
            'company_name',
            'reference',
            'pno',
            'house_extension',
            'house_number',
            'gender',
            'birth_year',
            'birth_month',
            'birth_day',
            'invoice_type'
        );

        $array = array();

        // split the pno to date of birth
        if (array_key_exists('pno', self::$prefillData)) {
            $dob = self::$prefillData['pno'];
            self::$prefillData['birth_year'] = substr($dob, 4, 4);
            self::$prefillData['birth_month'] = substr($dob, 2, 2);
            self::$prefillData['birth_day'] = substr($dob, 0, 2);
        }

        foreach ($fields as $field) {
            if (array_key_exists($field, self::$prefillData)
                && self::$prefillData[$field] !== ""
                && self::$prefillData[$field] !== null
            ) {
                $array[$field] = KiTT_String::encode(
                    self::$prefillData[$field], null, 'UTF-8'
                );
                if ($field === 'gender') {
                    $array['gender'] = intval(self::$prefillData['gender']);
                }
            }
        }

        return $array;
    }

    /**
    * addTransaction call
    *
    * @param int    $paymentPlan pclass id
    * @param object $addrs       KlarnaAddr object
    * @param string $option      invoice, part or spec
    *
    * @return void
    */
    public function addTransaction($paymentPlan, $addrs, $option)
    {
        global $order, $currencies, $currency, $$link;

        $addrHandler = new KlarnaAddressOsc;
        // Fixes potential security problem.
        $order->delivery = array_merge(
            $order->delivery,
            $addrHandler->klarnaAddrToOscAddr($addrs)
        );

        // $_POST doesn't have phone number anymore, so it won't be
        // properly set by buildOsCommerceAddress
        $order->delivery['telephone'] = $addrs->getTelno();
        $order->billing['telephone'] = $addrs->getTelno();
        $order->customer['telephone'] = $addrs->getTelno();
        $addrs->setEmail($order->customer['email_address']);

        $pno = $_POST['klarna_pno'];

        $reference = KiTT_String::encode($_POST['klarna_reference']);

        if ($option == KiTT::PART) {
            $pSID = (int) MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID;
        } else if ($option == KiTT::SPEC) {
            $pSID = (int) MODULE_PAYMENT_SPECKLARNA_ORDER_STATUS_PENDING_ID;
        } else {
            $pSID = (int) MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID;
        }

        if ($_POST["klarna_{$option}_invoice_type"] == 'company'
            || $addrs->isCompany
        ) {
            // Company purchase, set the firstname in osCommerce to the reference
            // So we don't lose it.
            $order->delivery['firstname'] = KiTT_String::decode($reference);
            // set Ref: comment to make sure KO finds it
            $this->_klarna->setComment("Ref: " . $reference);

            // Set First and Last name so KO doesn't complain one is missing.
            $name = explode(' ', $reference, 2);
            $addrs->setFirstName((strlen($name[0]>0)) ? $name[0] : " ");
            if (strlen($name[1]) > 0) {
                $addrs->setLastName($name[1]);
            } else {
                $addrs->setLastName(" ");
            }

            //Set Company to order
            $order->delivery['company'] = KiTT_String::decode(
                $addrs->getCompanyName()
            );
        } else {
            $order->delivery['company'] = '';
        }
        if (strlen($order->info['comments']) > 0) {
            $this->_klarna->addComment(
                KiTT_String::encode($order->info['comments'])
            );
        }
        $this->_klarna->setReference($reference, "");

        $shipping = $addrs;
        $gender = null;

        $logic = KiTT::countryLogic(KiTT::locale($this->_country));

        if ($logic->needGender()) {
            $gender = $_POST['klarna_gender'];
        }
        if ($logic->shippingSameAsBilling()) {
            $billing = $shipping;
            $order->billing = $order->delivery;
        } else {
            $billing = $addrHandler->oscAddressToKlarnaAddr($order->billing);
        }

        $cval = $currencies->get_value($currency);

        try {
            $this->_klarna->setAddress(KlarnaFlags::IS_SHIPPING, $shipping);
            $this->_klarna->setAddress(KlarnaFlags::IS_BILLING, $billing);

            $result = $this->_klarna->reserveAmount(
                $pno,
                $gender,
                ($order->info["total"] * $cval),
                KlarnaFlags::NO_FLAG,
                $paymentPlan
            );

            if ($result[1] == KlarnaFlags::PENDING && $pSID > 0) {
                $q = "SELECT orders_status_name FROM " . TABLE_ORDERS_STATUS .
                    " WHERE orders_status_id = ". $pSID;
                $osq = tep_db_query($q);
                $os = tep_db_fetch_array($osq);
                $_SESSION['klarna_orderstatus'] = $os['orders_status_name'];
            }

            // insert address in address book to get correct address in
            // confirmation mail (or fetch correct address from address book
            // if it exists)
            $q = "SELECT countries_id FROM " . TABLE_COUNTRIES .
                " WHERE countries_iso_code_2 = '{$country}'";

            $check_country_query = tep_db_query($q);
            $check_country = tep_db_fetch_array($check_country_query);

            $cid = $check_country['countries_id'];

            $q = "SELECT address_book_id FROM " . TABLE_ADDRESS_BOOK .
                " WHERE customers_id = '" . (int)$customer_id .
                "' AND entry_firstname = '" .
                hvi_real_escape_string($order->delivery['firstname']) .
                "' AND entry_lastname = '" .
                hvi_real_escape_string($order->delivery['lastname']) .
                "' AND entry_street_address = '" .
                hvi_real_escape_string($order->delivery['street_address']) .
                "' AND entry_postcode = '" .
                hvi_real_escape_string($order->delivery['postcode']) .
                "' AND entry_city = '" .
                hvi_real_escape_string($order->delivery['city']) .
                "' AND entry_company = '" .
                hvi_real_escape_string($order->delivery['company']) . "'";
            $check_address_query = tep_db_query($q);
            $check_address = tep_db_fetch_array($check_address_query);
            if (is_array($check_address) && count($check_address) > 0) {
                $sendto = $billto = $check_address['address_book_id'];
            } else {
                $sql_data_array = array(
                    'customers_id' => $customer_id,
                    'entry_firstname' => $order->delivery['firstname'],
                    'entry_lastname' => $order->delivery['lastname'],
                    'entry_company' => $order->delivery['company'],
                    'entry_street_address' => $order->delivery['street_address'],
                    'entry_postcode' => $order->delivery['postcode'],
                    'entry_city' => $order->delivery['city'],
                    'entry_country_id' => $cid
                );

                tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
                $sendto = $billto = tep_db_insert_id();
            }
            $_SESSION['klarna_refno'] = $result[0];
        } catch(KlarnaException $e) {
            if ($e instanceof Klarna_ArgumentNotSetException
                || $e instanceof Klarna_InvalidPNOException
            ) {
                $this->setError(
                    htmlentities(
                        $this->translate('error_title_2'), ENT_COMPAT, 'UTF-8'
                    ),
                    $option
                );
            } else {
                $this->setError(
                    htmlentities($e->getMessage()) . " (#" . $e->getCode() . ")",
                    $option
                );
            }

            tep_redirect(
                $this->errorLink(
                    'checkout_payment.php', '', 'SSL', true, false
                )
            );
        }
    }


    /**
    * Handle the $_POST variable and return a KlarnaAddr object
    *
    * @param string $option payment option, invoice, part or spec
    *
    * @return KlarnaAddr address object
    */
    public function handlePost($option)
    {
\log::w("KlarnaUtils.php handlePost Session: " . $_SESSION['klarna_data']['serial_addr']);        
        $addrHandler = new KlarnaAddressOsc;
        $errors = array();
        $lang = self::getLanguageCode();

        $logic = KiTT::countryLogic(KiTT::locale($this->_country));

        $address = new KlarnaAddr();

        $aKlarnaAddress = $addrHandler->addressArrayFromPost($option);
        $_SESSION['klarna_data'] = $aKlarnaAddress;

        if ($logic->useGetAddresses()) {
            try {
                $address = $addrHandler->getMatchingAddress($option);
            } catch (KlarnaException $e) {
                $message = $e->getMessage();
                if ($e instanceof Klarna_ArgumentNotSetException) {
                    $message = $this->translate("error_title_2", $lang);
                }
                $this->setError(
                    htmlentities($message) . " (#" . $e->getCode() . ")",
                    $option
                );
                tep_redirect(
                    $this->errorLink(
                        'checkout_payment.php', '', 'SSL', true, false
                    )
                );
            }
        } else {
            try {
                $address = $addrHandler->buildKlarnaAddressFromArray(
                    $aKlarnaAddress, $this->_country
                );
            } catch(Exception $e) {
                $this->setError(
                    htmlentities(
                        $e->getMessage()
                    ) . " (#" . $e->getCode() . ")",
                    $option
                );
                tep_redirect(
                    $this->errorLink(
                        'checkout_payment.php', '', 'SSL', true, false
                    )
                );
            }

            if ($logic->needConsent()
                && $_POST["klarna_{$option}_consent"] != 'consent'
            ) {
                $errors[] = "no_consent";
            }

            if ($logic->needDateOfBirth()) {
                $_SESSION['klarna_data']["pno"]
                    = $_POST["klarna_{$option}_birth_day"] .
                    $_POST["klarna_{$option}_birth_month"] .
                    $_POST["klarna_{$option}_birth_year"];

                $_SESSION['klarna_data']['gender']
                    = $_POST["klarna_{$option}_gender"];
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $err) {
                $translated[] = $this->translate($err, $lang);
            }

            $this->setError(
                htmlentities(
                    implode(',', $translated),
                    ENT_COMPAT,
                    'UTF-8'
                ),
                $option
            );
            tep_redirect(
                $this->errorLink('checkout_payment.php', "", "SSL")
            );
        }

        return $address;
    }

    /**
     * Build osCommerce's hidden fields that are required for it to keep
     * it's _POST variable
     *
     * @param object $addr          KlarnaAddr object
     * @param string $invoiceType   invoice type
     * @param int    $paymentPlan   pclass id
     * @param string $email_address email address
     * @param string $reference     reference
     *
     * @return string   the hidden fields string
     */
    public function hiddenFieldString(
        $addr, $invoiceType, $paymentPlan, $email_address, $reference
    ) {
        global $order;

        $pno = $_SESSION['klarna_data']['pno'];
        $gender = $_SESSION['klarna_data']['gender'];

        $process_button_string
            = tep_draw_hidden_field('addr_num', 1, true, '').
            tep_draw_hidden_field("klarna_pno", $pno).
            tep_draw_hidden_field("klarna_street", $addr->getStreet()).
            tep_draw_hidden_field("klarna_postno", $addr->getZipCode()).
            tep_draw_hidden_field("klarna_city", $addr->getCity()).
            tep_draw_hidden_field("klarna_phone", $addr->getTelno()).
            tep_draw_hidden_field("klarna_phone2", $addr->getCellno()).
            tep_draw_hidden_field("klarna_email", $email_address).
            tep_draw_hidden_field("klarna_invoice_type", $invoiceType).
            tep_draw_hidden_field("klarna_house", $addr->getHouseNumber()) .
            tep_draw_hidden_field("klarna_houseext", $addr->getHouseExt()) .
            tep_draw_hidden_field("klarna_reference", $reference) .
            tep_draw_hidden_field("klarna_gender", $gender).
            tep_draw_hidden_field("klarna_paymentPlan", $paymentPlan);
        return $process_button_string;

    }

    /**
    * Get the value of the cart
    *
    * @return float
    */
    public function getCartSum()
    {
        global $order, $currencies, $currency;

        if (KlarnaConstant::isAdmin()) {
            return;
        }

        $cval = $currencies->get_value($currency);

        $shippingCost = $this->_getShippingCost();

        if ($order == null) {
            return $shippingCost + ($cval * $_SESSION['cart']->total);
        }

        $totalSum = 0;
        foreach ($order->products as $product) {
            $totalSum += ($cval * $product['final_price']
                * (1 + $product['tax'] / 100)) * $product['qty'];
        }
        return $shippingCost + $totalSum;
    }

    /**
     * Get the shipping cost. Will return the cost based on the config
     * flag DISPLAY_PRICE_WITH_TAX
     *
     * @return double
     */
    private function _getShippingCost()
    {
        global $currencies, $currency, $shipping;

        $cval = $currencies->get_value($currency);
        $shippingCost = $cval * $shipping["cost"];

        if (DISPLAY_PRICE_WITH_TAX == "false") {
            return $shippingCost;
        }

        $taxRate = $this->_getShippingTaxRate($shipping["id"]);
        return ($shippingCost * ($taxRate / 100 + 1));
    }

    /**
     * Get the shipping tax rate. It relies on there beeing a global $order object
     * in order to get the country and zone id used for tep_get_tax_rate
     *
     * @param array $shippingId The global shipping methods id key
     *
     * @return double
     */
    private function _getShippingTaxRate($shippingId)
    {
        global $order;

        $method = @explode('_', $shippingId);
        $delZoneId = ($order->delivery['zone_id'] > 0)
                    ? $order->delivery['zone_id']
                    : null;
        return tep_get_tax_rate(
            $this->_getShippingTaxClass($method[0]),
            $order->delivery['country']['id'],
            $delZoneId
        );
    }

    /**
     * Return the shipping tax class
     *
     * @param string $method The pament method
     *
     * @return int
     */
    private function _getShippingTaxClass($method)
    {
        $method = strtoupper($method);
        $constant = "MODULE_SHIPPING_{$method}_TAX_CLASS";
        if (defined($constant)) {
            return constant($constant);
        }
        return 0;
    }

    /**
     * Calculate order total and save it away.
     *
     * We need to access to all additional charges, ie the order_totals list, in
     * the before_process() function but at that point order_totals->process
     * hasn't been run.
     *
     * @return array order_total_array
     */
    public function getOrderTotal()
    {
        global $order_total_modules, $klarna_ot, $order, $shipping;

        $orderTotalModules = $order_total_modules->modules;
        $klarnaOrderTotals = array();

        if (!is_array($orderTotalModules)) {
            return $klarnaOrderTotals;
        }

        $ignore = array(
            'ot_tax',
            'ot_subtotal',
            'ot_total'
        );

        foreach ($orderTotalModules as $value) {
            $className = substr($value, 0, strrpos($value, '.'));
            $class = $GLOBALS[$className];

            // If the module class isn't an object, move along
            if (!is_object($class)) {
                continue;
            }

            // It this module isn't enabled, move along.
            if (!$class->enabled) {
                continue;
            }

            // Check if the module should be ignored. This is so that we don't add
            // the sub_total, order_total and tax_total to our goods list
            if (in_array($class->code, $ignore)) {
                continue;
            }

            $output = $class->output;
            if (sizeof($output) == 0) {
                continue;
            }

            $taxClass = null;
            foreach ($class->keys() as $constant) {
                if (strlen(strstr($constant, "TAX_CLASS")) > 0) {
                    $taxClass = constant($constant);
                    continue;
                }
            }

            $taxRate = 0;
            $delCountryId = $order->delivery['country']['id'];
            $delZoneId = ($order->delivery['zone_id'] > 0)
                            ? $order->delivery['zone_id']
                            : null;

            if ($taxClass !== null) {
                $taxRate = tep_get_tax_rate(
                    $taxClass, $delCountryId, $delZoneId
                );
            }

            foreach ($output as $orderTotal) {
                $orderTotal["rate"] = $taxRate;
                $klarnaOrderTotals[$className] = $orderTotal;
            }

            //Set Shipping VAT
            if ($className == 'ot_shipping') {
                $taxRate = $this->_getShippingTaxRate($shipping["id"]);
                $klarnaOrderTotals[$className]["rate"] = $taxRate;
            }
        }

        return $klarnaOrderTotals;
    }

    /**
     * Remove $_POST data we don't want.
     *
     * @param string $opt payment option shorthand, inv part or spec
     *
     * @return void
     */
    private function _cleanSpecificPost($opt)
    {
        unset($_POST["klarna_{$opt}_fname"]);
        unset($_POST["klarna_{$opt}_lname"]);
        unset($_POST["klarna_{$opt}_gender"]);
        unset($_POST["klarna_{$opt}_pno"]);
        unset($_POST["klarna_{$opt}_street"]);
        unset($_POST["klarna_{$opt}_house"]);
        unset($_POST["klarna_{$opt}_postno"]);
        unset($_POST["klarna_{$opt}_city"]);
        unset($_POST["klarna_{$opt}_phone"]);
        unset($_POST["klarna_{$opt}_email"]);
        unset($_POST["klarna_{$opt}_paymentPlan"]);
        unset($_POST["klarna_{$opt}_reference"]);
        unset($_POST["klarna_{$opt}_shipment_address"]);
        unset($_POST["klarna_{$opt}_houseext"]);
    }

    /**
     * Remove unwanted data from the POST variable
     *
     * @return void
     */
    public function cleanPost()
    {
\log::w("KlarnaUtils.php cleanPost Session: " . $_SESSION['klarna_data']['serial_addr']);        
\log::w("KlarnaUtils.php cleanPost backtrace:\n " . $this->debug_string_backtrace());
        unset($_SESSION['klarna_data']);
        if ($_POST['payment'] != 'klarna_invoice') {
            $this->_cleanSpecificPost('invoice');
        }
        if ($_POST['payment'] != 'klarna_speccamp') {
            $this->_cleanSpecificPost('spec');
        }
        if ($_POST['payment'] != 'klarna_partpayment') {
            $this->_cleanSpecificPost('part');
        }
    }

    function debug_string_backtrace() { 
        ob_start(); 
        debug_print_backtrace(); 
        $trace = ob_get_contents(); 
        ob_end_clean(); 

        // Remove first item from backtrace as it's this function which 
        // is redundant. 
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1); 

        // Renumber backtrace items. 
        $trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace); 

        return $trace; 
    }     
    /**
     * Translate a string from the languagepack.
     *
     * @param string                    $sTitle title of the wanted translation.
     * @param KlarnaLanguage|int|string $lang   language to translate to.
     *
     * @return string the translated string.
     */
    public function translate($sTitle, $lang = null)
    {
        return KiTT::translator(
            KiTT::locale($this->_country, $lang)
        )->translate($sTitle);
    }

    /**
     * Build the cart to be used for the purchase.
     *
     * @param string $estoreUser  estoreUser identifier
     * @param object $order       osCommerce order object
     * @param string $option      invoice, part or spec
     * @param string $code        payment code
     * @param int    $paymentPlan pclass id
     *
     * @return void
     */
    public function buildCart($estoreUser, $order, $option, $code, $paymentPlan)
    {

        // global $klarna_ot;
        $cv = $order->info['currency_value'];

        if ($option == KiTT::PART) {
            $artno = MODULE_PAYMENT_PCKLARNA_ARTNO;
        } else if ($option == KiTT::SPEC) {
            $artno = MODULE_PAYMENT_SPECKLARNA_ARTNO;
        } else {
            $artno = MODULE_PAYMENT_KLARNA_ARTNO;
        }
        // Add all the articles to the goodslist
        foreach ($order->products as $product) {

            $tax = $product['tax'] / 100;
            $price = $cv * ($product['final_price']
                + ($product['final_price'] * $tax));

            $attributes = "";
            if (isset($product['attributes'])) {
                foreach ($product['attributes'] as $attr) {
                    $attributes = $attributes . ", " . $attr['option'] . ": " .
                        $attr['value'];
                }
            }

            $artnumber = $product[$artno];
            if ($artno == 'id' || $artno == '') {
                $artnumber = tep_get_prid($product['id']);
            }

            $this->_klarna->addArticle(
                KiTT_String::encode($product['qty']),
                KiTT_String::encode($artnumber),
                KiTT_String::encode(
                    strip_tags(
                        $product['name'] . $attributes
                    )
                ),
                KiTT_String::encode($price),
                KiTT_String::encode(number_format($tax*100, 2)),
                0,
                KlarnaFlags::INC_VAT
            );
        }

        // Then the extra charges like shipping and invoicefee and
        // discount.
        $klarna_ot = $_SESSION['klarna_ot'];
        $extra = $klarna_ot['code_entries'];

        // If someone tries to set a pclass value to -1 using firebug, force
        // an invoice fee on them.
        if ($paymentPlan < 0) {
            $code = "klarna";
        }
        // Go over all the order total modules that are active for this order
        // and add them.
        foreach ($klarna_ot as $key => $item) {
            $flags = KlarnaFlags::INC_VAT;
            if ($key === "ot_shipping") {
                $flags |= KlarnaFlags::IS_SHIPMENT;
            } else if ($key === "ot_klarna_fee") {
                $flags |= KlarnaFlags::IS_HANDLING;
            }

            if (DISPLAY_PRICE_WITH_TAX === "false") {
                $item["value"] *= (($item["rate"] / 100) + 1);
            }

            $title = rtrim($item["title"], ':');
            $this->_klarna->addArticle(
                1,
                "",
                html_entity_decode($title, ENT_COMPAT, KiTT_String::$klarnaEncoding),
                ($cv * $item["value"]),
                $item["rate"],
                0,
                $flags
            );
        }
    }

    /**
     * Try to guess the country.
     *
     * @return KlarnaCountry constant
     */
    public static function guessCountry()
    {
        global $currency;
        //If logged in, grab country.
        if (tep_session_is_registered('customer_country_id')) {
            return KlarnaCountry::fromCode(
                self::getCountryByID($_SESSION['customer_country_id'])
            );
        } else {
            // not logged in, guess from selected currency
            $_currency = Klarna::getCurrencyForCode($currency);
            // if it's euro, use store country
            if ($_currency == KlarnaCurrency::EUR) {
                return KlarnaCountry::fromCode(
                    self::getCountryByID(STORE_COUNTRY)
                );
            } else {
                switch ($_currency) {
                case KlarnaCurrency::SEK:
                    return KlarnaCountry::SE;
                    break;
                case KlarnaCurrency::NOK:
                    return KlarnaCountry::NO;
                    break;
                case KlarnaCurrency::DKK:
                    return KlarnaCountry::DK;
                    break;
                default:
                    break;
                }
            }
        }
    }

    /**
     * Configure available Klarna countries in KiTT
     *
     * @param string $option payment option
     *
     * @return void
     */
    public static function configureKlarna($option)
    {
        foreach (KlarnaConstant::getActivated($option) as $country) {
            $eid = KlarnaConstant::merchantID($option, $country);
            $secret = KlarnaConstant::secret($option, $country);
            // if eid or secret is 0, "" or null, ignore this country.
            if (!$eid || !$secret) {
                continue;
            }

            KiTT::configure(
                array(
                    "sales_countries/{$country}" => array(
                        "eid" => $eid,
                        "secret" => $secret
                    )
                )
            );
        }
    }

    /**
     * Show the PClasses
     *
     * @param array  $eid_array array of eids and secrets
     * @param string $option    payment option
     *
     * @return void
     */
    public function showPClasses($eid_array, $option)
    {
        self::configureKlarna($option);

        if ($_GET['get_pclasses'] == true) {
            $pcstorage = new MySQLStorage;
            $pcstorage->clear(KlarnaConstant::pcURI());
        }
        $data = array();
        $country_data = array();
        foreach (KlarnaConstant::getActivated($option) as $country) {
            $country = strtolower($country);
            try {
                $api = KiTT::api(KiTT::locale($country));

                if ($_GET['get_pclasses'] == true) {
                    $api->fetchPClasses();
                }
                foreach ($api->getPClasses() as $pclass) {
                    $country_data['country'][] = array(
                        'country' => $country,
                        'id' => $pclass->getId(),
                        'months' => $pclass->getMonths(),
                        'interestrate' => $pclass->getInterestRate(),
                        'invoicefee' => $pclass->getInvoiceFee(),
                        'startfee' => $pclass->getStartFee(),
                        'minamount' => $pclass->getMinAmount(),
                        'description' => $pclass->getDescription()
                    );
                }

            } catch (Exception $e) {
                $data['error']['country'][] = array(
                    'country' => $country,
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                );
            }
        }

        $data['success'] = $country_data;
        $templateLoader = KiTT::templateLoader(KiTT::Locale($this->_country));
        $fetch = $templateLoader->load('fetched_pclasses.mustache');
        echo $fetch->render($data);
    }

    /**
     * Check if pclasses for given option exists and show warning if it doesn't
     *
     * @param string $option 'part' or 'spec'
     *
     * @return void
     */
    public function checkForPClasses($option)
    {
        $sql = "";
        $module = "";
        if ($option == 'part') {
            $module = 'Part Payment Module';
            $sql = "type <> 2";
        } elseif ($option == 'spec') {
            $module = 'Special Campaigns Module';
            $sql = "type = 2";
        } else {
            return;
        }
        if (KlarnaConstant::isEnabled($option, $this->_country)) {
            // instantiate MySQLStorage to ensure the table exists
            $pcURI = KlarnaConstant::pcURI();
            $pcstorage = new MySQLStorage;
            $pcstorage->load($pcURI);

            $count = tep_db_num_rows(
                tep_db_query(
                    "SELECT type FROM klarna_pclasses WHERE {$sql}"
                )
            );
            if ($count == 0 && !isset($_GET['get_pclasses']) && !isset($_GET['action'])) {
                $templateLoader = KiTT::templateLoader(
                    KiTT::Locale($this->_country)
                );
                $no_pclasses = $templateLoader->load('no_pclasses.mustache');
                echo $no_pclasses->render(array('module' => $module));
            }
        }
    }

    /**
     * Prepare to fetch pclasses by building an array of eid and secrets
     *
     * @param string $option 'part' or 'spec'
     *
     * @return array
     */
    public function prepareFetch($option)
    {
        $countries = "";
        // Fethcing the pclasses
        if ($option == 'part') {
            $countries = explode(
                ",", strtolower(MODULE_PAYMENT_PCKLARNA_ACTIVATED_COUNTRIES)
            );
        } else if ($option == 'spec') {
            $countries = explode(
                ",", strtolower(MODULE_PAYMENT_SPECKLARNA_ACTIVATED_COUNTRIES)
            );
        } else {
            return;
        }
        // Set the array
        $eid_array = array();

        foreach ($countries as $country) {
            $eid_array[$country]['eid'] = KlarnaConstant::merchantID(
                $option, $country
            );
            $eid_array[$country]['secret'] = KlarnaConstant::secret(
                $option, $country
            );
        }
        return $eid_array;
    }

    /**
     * protected output string
     *
     * @param string $string string
     *
     * @return string
     */
    public function klarnaOutputStringProtected($string)
    {
        return klarnaOutputString($string, false, true);
    }

    /**
    * Creates a SEO safe error link.
    *
    * @param string $page               page
    * @param string $parameters         parameters
    * @param string $connection         connection
    * @param bool   $add_session_id     add session id
    * @param bool   $search_engine_safe SEO friendly
    *
    * @return string
    */
    public function errorLink(
        $page = '', $parameters = '', $connection = 'NONSSL',
        $add_session_id = true, $search_engine_safe = true
    ) {
        global $request_type, $session_started, $SID;

        if (!tep_not_null($page)) {
            die(
                '<br><br><font color="#f3014d"><b>Error!</b></font><br><br>'.
                '<b>Unable to determine the page link!<br><br>'
            );
        }

        if ($connection == 'NONSSL') {
            $link = HTTP_SERVER . DIR_WS_HTTP_CATALOG;
        } else if ($connection == 'SSL') {
            if (ENABLE_SSL == true) {
                $link = HTTPS_SERVER . DIR_WS_CATALOG;
            } else {
                $link = HTTP_SERVER . DIR_WS_CATALOG;
            }
        } else {
            die(
                '<br><br><font color="#f3014d"><b>Error!</b></font><br><br>'.
                '<b>Unable to determine connection method on a link!<br><br>'.
                'Known methods: NONSSL SSL</b><br><br>'
            );
        }

        if (tep_not_null($parameters)) {
            $link .= $page . '?' . $this->klarnaOutputString($parameters);
            $separator = '&';
        } else {
            $link .= $page;
            $separator = '?';
        }
        while ((substr($link, -1) == '&') || (substr($link, -1) == '?')) {
            $link = substr($link, 0, -1);
        }

        // Add the session ID when moving from different HTTP and HTTPS servers,
        // or when SID is defined
        if ( ($add_session_id == true) && ($session_started == true)
            && (SESSION_FORCE_COOKIE_USE == 'False')
        ) {
            if (tep_not_null($SID)) {
                $_sid = $SID;
            } else if ((($request_type == 'NONSSL') && ($connection == 'SSL')
                && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL')
                && ($connection == 'NONSSL') )
            ) {
                if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
                    $_sid = tep_session_name() . '=' . tep_session_id();
                }
            }
        }

        if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
            && ($search_engine_safe == true)
        ) {
            while (strstr($link, '&&')) {
                $link = str_replace('&&', '&', $link);
            }

            $link = str_replace('?', '/', $link);
            $link = str_replace('&', '/', $link);
            $link = str_replace('=', '/', $link);

            $separator = '?';
        }

        if (isset($_sid)) {
            $link .= $separator . $_sid;
        }
        return $link;
    }

    /**
     * Update orderstatuses in the database
     *
     * @param int $customer The order status id to show the customer
     * @param int $admin    The order status id to show in the administration page
     *
     * @return void
     */
    public function updateOrderDatabase($customer, $admin)
    {
        global $insert_id, $$link;

        $orderid = hvi_real_escape_string($insert_id);
        $refno = hvi_real_escape_string($_SESSION['klarna_refno']);

        $sql_data_arr = array(
            'orders_id' => $orderid,
            'orders_status_id' => $customer,
            'comments' => "Accepted by Klarna. Reference #: {$refno}",
            'customer_notified' => 1,
            'date_added' => date("Y-m-d H:i:s")
        );
        tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_arr);

        $has_ordernum_table = tep_db_fetch_array(
            tep_db_query(
                "SELECT COUNT(*) ".
                "FROM information_schema.tables ".
                "WHERE table_schema = '" . DB_DATABASE . "' ".
                "AND table_name = 'klarna_ordernum';"
            )
        );
        $has_ordernum_table = $has_ordernum_table['COUNT(*)'];

        if ($has_ordernum_table > 0) {
            tep_db_query(
                "INSERT INTO `klarna_ordernum` (orders_id, klarna_ref) ".
                "VALUES ({$orderid}, {$refno})"
            );
        }
        // Set pending status and hide it from customer.
        if (isset($_SESSION['klarna_orderstatus'])) {
            $sql_data_arr = array(
                'orders_id' => $orderid,
                'orders_status_id' => $admin,
                'comments' => "Klarna Orderstatus",
                'customer_notified' => 0,
                'date_added' => date("Y-m-d H:i:s")
            );
            tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_arr);
        }

        try {
            $this->_klarna->setEstoreInfo(KiTT_String::encode($orderid));
            $this->_klarna->update($refno);
        } catch (KlarnaException $e) {
            Klarna::printDebug(__METHOD__ , $e->getMessage());
        }

        //Delete Session with user details
        unset($_SESSION['klarna_data']);
        unset($_SESSION['klarna_refno']);
        unset($_SESSION['klarna_orderstatus']);
    }

    /**
    * install module
    *
    * @param array $configuration configuration array
    *
    * @return void
    */
    public function installModule($configuration)
    {
        $default = $this->getDefaultArray();

        tep_db_query(
            'CREATE TABLE IF NOT EXISTS `klarna_ordernum` ('.
            '`orders_id` INT NOT NULL , '.
            '`klarna_ref` VARCHAR( 50 ) NOT NULL , '.
            'UNIQUE ( `orders_id` ), '.
            'FOREIGN KEY ( `orders_id` ) REFERENCES ' .
            TABLE_ORDERS . ' ( `orders_id` )' .
            ');'
        );

        foreach ($configuration as $config) {
            $merged = array_merge($default, $config);
// \log::w("Klarna Utils install: merged\n" . print_r($merged,true));
$arrayvalmerged = array_values($merged);
// \log::w("Klarna Utils install: merged\n" . print_r($arrayvalmerged,true));

            $query_string = implode(', ', array_keys($merged));
            $query_values = implode(
                '", "', array_map(
                    "mysql_real_escape_string", array_values($merged)
                )
            );
            $query_values = "\"" . $arrayvalmerged[0] . "\",";
            $query_values .= "\"" . $arrayvalmerged[1] . "\",";
            $query_values .= "\"" . $arrayvalmerged[2] . "\",";
            $query_values .= "\"" . $arrayvalmerged[3] . "\",";
            $query_values .= "\"" . $arrayvalmerged[4] . "\",";
            $query_values .= "\"" . $arrayvalmerged[5] . "\",";
            $query_values .= "\"" . $arrayvalmerged[6] . "\",";
            $query_values .= "\"" . $arrayvalmerged[7] . "\",";
            $query_values .= "\"" . $arrayvalmerged[8] . "\"";

// \log::w("Klarna Utils install:\n" . "INSERT INTO ". TABLE_CONFIGURATION .
 //               "({$query_string}) VALUES ({$query_values})");
            tep_db_query(
                "INSERT INTO ". TABLE_CONFIGURATION .
                "({$query_string}) VALUES ({$query_values})"
            );
        }
    }

    /**
    * Get the default array for installation method.
    *
    * @return array with default values
    */
    public function getDefaultArray()
    {
        return array(
            'configuration_title' => 'null',
            'configuration_key' => 'null',
            'configuration_value' => '',
            'configuration_description' => 'null',
            'configuration_group_id' => 'null',
            'sort_order' => 'null',
            'use_function' => '',
            'set_function' => '',
            'date_added' => 'now()'
        );
    }

    /**
    * Get the configuration array to be inserted into the database.
    *
    * @param string $option invoice,part or spec
    * @param int    $newId  id of new order status
    *
    * @return array configuration array for specified payment option
    */
    public function getConfigArray($option, $newId)
    {
        $module = '';
        switch ($option) {
        case 'part':
            $module = "MODULE_PAYMENT_PCKLARNA_";
            $option = "Part Payment";
            break;
        case 'spec':
        case 'special':
            $module = "MODULE_PAYMENT_SPECKLARNA_";
            $option = "Special Campaign";
            break;
        case 'invoice':
        default:
            $module = "MODULE_PAYMENT_KLARNA_";
            $option = "Invoice";
            break;
        }

        $configs = array(
            array(
                'configuration_title' => 'Enable Klarna Module',
                'configuration_key' => "{$module}STATUS",
                'configuration_value' => 'True',
                'configuration_description' =>
                    'Do you want to accept Klarna payments?',
                'configuration_group_id' => '6',
                'sort_order' => '0',
                'set_function' =>
                    'tep_cfg_select_option(array(\'True\', \'False\'), '
            ),
            array(
                'configuration_title' => 'Check for latest version',
                'configuration_key' => "{$module}LASTESTVERSION",
                'configuration_value' => 'True',
                'configuration_description' =>
                    'Do you want show an notification message on the module '.
                    'page when a newer version of this module is available?',
                'configuration_group_id' => '6',
                'sort_order' => '0',
                'set_function' =>
                    'tep_cfg_select_option(array(\'True\', \'False\'), '
            ),
            array(
                'configuration_title' => 'Payment Zone',
                'configuration_key' => "{$module}ZONE",
                'configuration_value' => '0',
                'configuration_description' =>
                    'If a zone is selected, only enable this payment method for '.
                    'that zone.',
                'configuration_group_id' => '6',
                'sort_order' => '2',
                'use_function' => 'tep_get_zone_class_title',
                'set_function' => 'tep_cfg_pull_down_zone_classes('
            ),
            array(
                'configuration_title' => 'Product artno attribute (id or model)',
                'configuration_key' => "{$module}ARTNO",
                'configuration_value' => 'id',
                'configuration_description' =>
                    'Use the following product attribute for ArtNo.',
                'configuration_group_id' => '6',
                'sort_order' => '8',
                'set_function' =>
                    'tep_cfg_select_option(array(\'id\', \'model\'), '
            ),
            array(
                'configuration_title' => 'Sort order of display.',
                'configuration_key' => "{$module}SORT_ORDER",
                'configuration_value' => '0',
                'configuration_description' =>
                    'Sort order of display. Lowest is displayed first.',
                'configuration_group_id' => '6',
                'sort_order' => '20'
            ),
            array(
                'configuration_title' => 'Set Order Status',
                'configuration_key' => "{$module}ORDER_STATUS_ID",
                'configuration_value' => '0',
                'configuration_description' =>
                    'Set the status of orders made with this payment module '.
                    'to this value.',
                'configuration_group_id' => '6',
                'sort_order' => '20',
                'set_function' => 'tep_cfg_pull_down_order_statuses(',
                'use_function' => 'tep_get_order_status_name'
            ),
            array(
                'configuration_title' => 'Set Pending Order Status',
                'configuration_key' =>
                    "{$module}ORDER_STATUS_PENDING_ID",
                'configuration_value' => $newId,
                'configuration_description' =>
                    'Set the status of orders made with this payment module '.
                    '(with PENDING result) to this value.',
                'configuration_group_id' => '6',
                'sort_order' => '11',
                'set_function' => 'tep_cfg_pull_down_order_statuses(',
                'use_function' => 'tep_get_order_status_name'
            ),
            array(
                'configuration_title' => 'Live Server',
                'configuration_key' => "{$module}LIVEMODE",
                'configuration_value' => 'True',
                'configuration_description' =>
                    'Do you want to use Klarna LIVE server (true) or '.
                    'BETA server (false)?',
                'configuration_group_id' => '6',
                'sort_order' => '21',
                'set_function' =>
                    'tep_cfg_select_option(array(\'True\', \'False\'), '
            ),
            array(
                'configuration_title' => 'Activated countries',
                'configuration_key' =>
                    "{$module}ACTIVATED_COUNTRIES",
                'configuration_value' =>
                    implode(',', KiTT::supportedCountries()),
                'configuration_description' =>
                    'For which countries do you wish to offer Klarna ' . $option .
                    ' services? (separated by comma)',
                'configuration_group_id' => '6',
                'sort_order' => '14'
            ),

        );

        foreach (KiTT::supportedCountries() as $country) {
            $countryLogic = KiTT::countryLogic(KiTT::locale($country));

            $flags = "<span class='klarna_flag_" . strtolower($country) . "'></span>";
            $configs[] = array(
                'configuration_title' => "{$flags} {$country} Shared secret",
                'configuration_key' => "{$module}SECRET_{$country}",
                'configuration_description' =>
                    'Shared secret to use with the Klarna service (provided by Klarna)',
                'configuration_group_id' => '6',
                'sort_order' => '3'
            );
            $configs[] = array(
                'configuration_title' => "{$flags} {$country} Merchant ID",
                'configuration_key' => "{$module}EID_{$country}",
                'configuration_value' => '0',
                'configuration_description' =>
                    'Merchant ID to use for the Klarna service (provided by Klarna)',
                'configuration_group_id' => '6',
                'sort_order' => '1'
            );
            if ($countryLogic->needAGB()) {
                $configs[] = array(
                    'configuration_title' => "{$flags} {$country} AGB link",
                    'configuration_key' => "{$module}AGB_LINK_{$country}",
                    'configuration_value' => 'http://',
                    'configuration_description' =>
                        'The link to the shops Terms and Conditions',
                    'configuration_group_id' => '',
                    'sort_order' => ''
                );
            }
        }

        return $configs;
    }
}
