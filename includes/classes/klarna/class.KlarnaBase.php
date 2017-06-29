<?php
/**
 * Base module extended by all payment options.
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */

require_once 'class.KlarnaCore.php';

/**
 * Klarna Base Module
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class KlarnaBase
{
    /**
     *
     * @var Klarna
     */
    private $_klarna;

    /**
     * The merchant it
     *
     * @var int
     */
    private $_eid;

    /**
     * The secret for merchant
     *
     * @var string
     */
    private $_secret;

    /**
     * The address object for the customer
     *
     * @var KlarnaAddr
     */
    private $_addrs;

    /**
     * The Klarna Standard Register API
     *
     * @var _checkout
     */
    private $_checkout;

    /**
     * Klarna data as an associative array
     * @var array
     */
    private $_klarna_data;

    /**
     * KlarnaUtils object
     */
    private $_utils;

    /**
     * Klarna Payment Option
     */
    private $_option;

    /**
     * KiTT_Locale
     */
    private $_locale;

    /**
     * @var KiTT_CountryLogic
     */
    protected $logic;


    /**
     * ensure javascript only runs once
     *
     * @var boolean
     */
    private static $_hasRun;

    /**
     * The constructor
     *
     * @param string $option 'part', 'spec' or 'invoice'
     *
     * @return void
     */
    public function __construct($option)
    {
        global $order, $currency, $customer_country_id;

        $this->api_version = KlarnaCore::getCurrentVersion();
        $this->jQuery = false;
        $this->enabled = true;

        $this->_option = $option;

        $country = KlarnaUtils::deduceCountry($option);
        $lang = KlarnaUtils::getLanguageCode();

        $this->_country = $country;

        $this->_utils = new KlarnaUtils($country);

        $this->_locale = KiTT::locale($country, $lang, $currency);

        $this->logic = KiTT::countryLogic($this->_locale);

        if (KlarnaConstant::isAdmin() && !isset($_GET['action'])) {
            echo "<link href='" . KlarnaUtils::getExternalKiTTPath() .
            "/res/v1.1/images.css' type='text/css' rel='stylesheet'/>";
            $this->_checkForLatestVersion();
        }

        //Set the title for the payment method. This will be displayed on the
        //confirmation page and the backend order view.
        $this->title = $this->_title();
        $this->description = $this->_buildDescription();

        $merchantID = KlarnaConstant::merchantID($option, $country);
        $secret = KlarnaConstant::secret($option, $country);

        if (!$merchantID || !$secret) {
            $this->enabled = false;
        }

        try {
            $this->setupModule();
        } catch (KiTT_Exception $e) {
            if (!KlarnaConstant::isAdmin()) {
                $this->enabled == false;
            }
        }
    }

    /**
     * Setup the payment module for usage.
     *
     * @return void
     */
    protected function setupModule()
    {
        global $order;

        KlarnaUtils::configureKlarna($this->_option);
        if ($this->_country === null) {
            return;
        }
        // Pass the api instance to the utils object.
        $this->_utils->setApi(KiTT::api(KiTT::locale($this->_country)));

        $this->order_status = KlarnaConstant::getOrderStatusId($this->_option);

        // if order is an object instead of an array, we're returning after
        // a purchase. Then we want to call update_status.
        if (is_object($order)) {
            $this->update_status();
        }

        $this->form_action_url = tep_href_link(
            'checkout_process.php', '', 'SSL', false
        );

        $this->enabled = $this->_isEnabled();
    }

    /**
     * Update Status
     *
     * @return void
     */
    public function updateStatus()
    {
        global $order;

        if ($this->_isInvoice()) {
            $zone = (int) MODULE_PAYMENT_KLARNA_ZONE;
        } else if ($this->_isPart()) {
            $zone = (int) MODULE_PAYMENT_PCKLARNA_ZONE;
        } else if ($this->_isSpec()) {
            $zone = (int) MODULE_PAYMENT_SPECKLARNA_ZONE;
        }

        if ( $this->enabled == true && $zone > 0) {
            $check_flag = false;
            $check_query = tep_db_query(
                "select zone_id from " .
                TABLE_ZONES_TO_GEO_ZONES .
                " where geo_zone_id = '" .
                $zone .
                "' and zone_country_id = '" .
                $order->delivery['country']['id'] .
                "' order by zone_id"
            );

            while ($check = tep_db_fetch_array($check_query)) {
                if ($check['zone_id'] < 1) {
                    $check_flag = true;
                    break;
                } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
                    $check_flag = true;
                    break;
                }
            }

            if ($check_flag == false) {
                $this->enabled = false;
            }
        }
    }

    /**
     * This function outputs the payment method title/text and if required, the
     * input fields.
     *
     * @return array Data to present in page
     */
    public function selection()
    {
        global $order, $customer_id, $currencies;

        if (!$this->_isEnabled()) {
            return;
        }
        // Add CSS and Javascript just once.
        if (!self::$_hasRun) {
            $templateLoader = KiTT::templateLoader($this->_locale);
            $cssLoader = $templateLoader->load('css.mustache');
            $jsLoader = $templateLoader->load('javascript.mustache');

            $kittExternal = KlarnaUtils::getExternalKiTTPath();
            $styles = array(
                "{$kittExternal}/res/v1.1/checkout.css",
                "ext/modules/payment/klarna/checkout/style.css"
            );

            if (KlarnaConstant::isLegacyShop()) {
                $styles[] = "includes/classes/klarna/template/css/klarna22rc2a.css";
            }

            self::$_hasRun = true;
            echo $jsLoader->render(
                array(
                    "scripts" => array(
                        "{$kittExternal}/core/v1.0/js/klarna.min.js",
                        "{$kittExternal}/res/v1.1/js/klarna.lib.js",
                        "{$kittExternal}/res/v1.1/js/checkout.js"
                    )
                )
            );

            echo $cssLoader->render(array('styles' => $styles));
        }

        KiTT::configuration()->set(
            'agb_link', KlarnaConstant::agb($this->_option, $this->_country)
        );

        $co = KiTT::checkoutController($this->_locale, $this->_utils->getCartSum());

        $view = $co->getOption($this->_option);

        if (!$view->isAvailable()) {
            return;
        }

        $view->setPaymentFee(round($this->_utils->getInvoiceFee(), 2));
        $view->setPaymentId($this->code);
        // Have we returned from a failed purchase?
        if ($this->_utils->getErrorOption() == $this->_option) {
            $view->setError(html_entity_decode($this->_utils->getError()));
            $this->_utils->clearErrors();
            if (array_key_exists('klarna_paymentPlan', $_SESSION)) {
                $view->selectPClass(intval($_SESSION['klarna_paymentPlan']));
            }
        }
        $this->title = $this->_buildTitle($view);

        $this->_klarna_data = $this->_utils->collectKlarnaData($order);
        $this->_klarna_data['country'] = $this->_country;

        if (isset($_SESSION['klarna_data']) || isset(KlarnaUtils::$prefillData)) {
            $this->_klarna_data = array_merge(
                $this->_klarna_data,
                $this->_utils->getValuesFromSession()
            );
        }

        $view->prefill($this->_klarna_data);

        return array(
            'id' => $this->code,
            'module' => $this->title,
            'fields' => array(
                array(
                    'title' => '',
                    'field' => $view->show()
                )
            )
        );
    }

    /**
     * This function implements any checks of any conditions after payment
     * method has been selected.
     *
     * @return void
     */
    public function preConfirmationCheck()
    {
        global $order;

        $addressHandler = new KlarnaAddressOsc;

        $this->_utils->cleanPost();

        $this->_addrs = $this->_utils->handlePost($this->_option);

        if ($this->_isPart() || $this->_isSpec()) {
            $this->_paymentPlan = $_SESSION['klarna_paymentPlan']
                = (int)$_POST["klarna_{$this->_option}_paymentPlan"];
        } else {
            $this->_paymentPlan = -1;
        }

        $order->delivery = array_merge(
            $order->delivery, $addressHandler->klarnaAddrToOscAddr(
                $this->_addrs
            )
        );

        if ($this->logic->shippingSameAsBilling()) {
            $order->billing = $order->delivery;
        }

        $_SESSION['klarna_data']['serial_addr'] = serialize($this->_addrs);

    }

    /**
     * Implements any checks or processing on the order information before
     * proceeding to payment confirmation.
     *
     * @return array
     */
    public function confirmation()
    {
        $country = strtolower($this->_locale->getCountryCode());
        $url_base = "<a href='http://www.klarna.com' target='_blank'>";
        $desc = '';
        if ($this->_isInvoice()) {
            $type = 'invoice';
        }
        if ($this->_isPart()) {
            $type = 'account';
        }
        if ($this->_isSpec()) {
            $type = 'special';
            $desc = '<br>' . KiTT::api($this->_locale)->getPClass(
                $_POST['klarna_spec_paymentPlan']
            )->getDescription();
        }
        $css = "<link href='" . KlarnaUtils::getExternalKiTTPath() .
            "/res/v1.1/images.css' type='text/css' rel='stylesheet'/>";
        $logo = <<<LOGO
<div class='klarna_payment_info'>
    <span class='klarna_logo_{$type}_{$country}'></span>
</div>
LOGO;
        $title = "{$css}<br />{$url_base}{$logo}</a>{$desc}";
        return array('title' => $title);
    }

    /**
     * Outputs the html form hidden elements sent as POST data to the payment
     * gateway.
     *
     * @return string
     */
    public function processButton()
    {
        global $order, $shipping, $klarna_ot, $customer;

        $invoiceType = $_POST["klarna_{$this->_option}_invoice_type"];
        $reference = $_POST["klarna_{$this->_option}_reference"];

        $process_button_string = $this->_utils->hiddenFieldString(
            $this->_addrs,
            $invoiceType,
            $this->_paymentPlan,
            $order->customer['email_address'],
            $reference
        );

        if ($this->_addrs->isCompany) {
            $process_button_string .= tep_draw_hidden_field(
                'klarna_fname',
                $order->delivery['firstname']
            ) . tep_draw_hidden_field(
                'klarna_lname',
                $order->delivery['lastname']
            );
        } else {
            $process_button_string .= tep_draw_hidden_field(
                'klarna_fname',
                $this->_addrs->getFirstName()
            ) . tep_draw_hidden_field(
                'klarna_lname',
                $this->_addrs->getLastName()
            );
        }

        $_SESSION['klarna_ot'] = $this->_utils->getOrderTotal();
        $_SESSION['klarna_data']['invoice_type'] = $invoiceType;

        $process_button_string .= tep_draw_hidden_field(
            tep_session_name(),
            tep_session_id()
        );

        return $process_button_string;
    }

    /**
     * Build the cart and do the actual call to Klarna Online
     *
     * @return void
     */
    public function beforeProcess()
    {
        global $order, $customer_id, $currency, $currencies, $sendto, $billto,
            $klarna_ot;

        $this->_paymentPlan = $_POST['klarna_paymentPlan'];

        $this->_utils->buildCart(
            $customer_id,
            $order,
            $this->_option,
            $this->code,
            $this->_paymentPlan
        );

        $this->_addrs = unserialize($_SESSION['klarna_data']['serial_addr']);

        $this->_utils->addTransaction(
            $this->_paymentPlan,
            $this->_addrs,
            $this->_option
        );
    }

    /**
     * Update order comments
     *
     * @return false
     */
    public function afterProcess()
    {
        global $order;

        $status = strtolower($_SESSION['klarna_orderstatus']);

        $customer = KlarnaConstant::getOrderStatusId($this->_option);

        $admin = $customer;
        if (strpos($status, "pending") !== false) {
            $admin = KlarnaConstant::getPendingOrderStatusId($this->_option);
        }

        $order->info['order_status'] = $customer;

        $this->_utils->updateOrderDatabase($customer, $admin);

        return false;
    }

    /**
     * get error message.
     *
     * @return array     error title and error message
     */
    public function getError()
    {
        $error = $this->_utils->getError();
        return array(
            'title' => html_entity_decode(
                KiTT::translator($this->_locale)->translate('error_klarna_title')
            ),
            'error' => $error
        );
    }

    /**
     * Check if module is enabled
     *
     * @return int   1 if enabled
     */
    public function check()
    {
        $key = '';
        if ($this->_isInvoice()) {
            $key = 'MODULE_PAYMENT_KLARNA_STATUS';
        } else if ($this->_isPart()) {
            $key = 'MODULE_PAYMENT_PCKLARNA_STATUS';
        } else if ($this->_isSpec()) {
            $key = 'MODULE_PAYMENT_SPECKLARNA_STATUS';
        }
        if (!isset($this->_check)) {
            $check_query = tep_db_query(
                "SELECT configuration_value FROM " .
                TABLE_CONFIGURATION .
                " WHERE configuration_key = " .
                "'{$key}'"
            );
            $this->_check = tep_db_num_rows($check_query);
        }
        return $this->_check;
    }

    /**
     * Install script
     *
     * @return void
     */
    public function install()
    {
        $sql = tep_db_query(
            "SELECT orders_status_id FROM " . TABLE_ORDERS_STATUS .
            " ORDER BY orders_status_id DESC LIMIT 1"
        );
        $result = tep_db_fetch_array($sql);

        $newId = (int) $result['orders_status_id'] + 1;

        $moduleName = '';
        if ($this->_isInvoice()) {
            $moduleName = 'Invoice';
            $newId = 16;
        } else if ($this->_isPart()) {
            $moduleName = 'Part Payment';
            $newId = 18;
        } else if ($this->_isSpec()) {
            $moduleName = 'Campaign';
        }

//        tep_db_query(
//            "INSERT INTO " . TABLE_ORDERS_STATUS .
//            " (orders_status_id, orders_status_name, public_flag) ".
//            "VALUES ('$newId', 'Klarna Pending [{$moduleName}]', 0)"
//        );

        $configuration = $this->_utils->getConfigArray($this->_option, $newId);
require_once(DIR_FS_CATALOG. 'includes/classes/log.php');        
\log::w("Klarna base configuration:\n" . print_r($configuration,true));
        $this->_utils->installModule($configuration);
    }

    /**
     * Uninstall script
     *
     * @return void
     */
    public function remove()
    {
        $moduleName = '';
        $type = '';
        if ($this->_isInvoice()) {
            $moduleName = 'Invoice';
        } else if ($this->_isPart()) {
            $moduleName = 'Part Payment';
            $type = 'type <> 2';
        } else if ($this->_isSpec()) {
            $moduleName = 'Campaign';
            $type = 'type = 2';
        }

        tep_db_query(
            "DELETE FROM " . TABLE_CONFIGURATION .
            " WHERE configuration_key in ('" .
            implode("', '", $this->keys()) . "')"
        );

        tep_db_query(
            "DELETE FROM " . TABLE_ORDERS_STATUS .
            " WHERE orders_status_name = 'Klarna Pending [{$moduleName}]'"
        );

        if ($this->_isPart() || $this->_isSpec()) {
            tep_db_query("DELETE FROM klarna_pclasses WHERE {$type}");
        }
    }

    /**
     * Get/Show information about pclasses for the admin.
     *
     * @return void
     */
    protected function adminInfo()
    {
        $filename = explode('?', basename($_SERVER['REQUEST_URI'], 0));
        if ($filename[0] == "modules.php") {
            $this->_utils->checkForPClasses($this->_option);
            if ($_GET['view_pclasses'] == true
                || $_GET['get_pclasses'] == true
            ) {
                $eid_array = $this->_utils->prepareFetch($this->_option);
                $this->_utils->showPClasses($eid_array, $this->_option);
            }
        }
    }

    /**
     * Check if the instance of this object is for the invoice module.
     *
     * @return boolean
     */
    private function _isInvoice()
    {
        return $this->_option == 'invoice';
    }

    /**
     * Check if the instance of this object is for the special campaigns module.
     *
     * @return boolean
     */
    private function _isSpec()
    {
        return $this->_option == 'spec';
    }

    /**
     * Check if the instance of this object is for the part payment module.
     *
     * @return boolean
     */
    private function _isPart()
    {
        return $this->_option == 'part';
    }

    /**
     * Build the apropriate title for each module.
     *
     * @param KiTT_Payment_Option $view payment option object
     *
     * @return string
     */
    private function _buildTitle($view)
    {
        $title = htmlentities($view->getTitle(), ENT_COMPAT, 'UTF-8');
        $extra = htmlentities($view->getExtra(), ENT_COMPAT, 'UTF-8');

        $result = "<span style='float: left;'>{$title}</span>";
        if (strlen($extra) > 0) {
            $result .= "<span style='float: right;'>{$extra}</span>";
        }
        return $result;
    }

    /**
     * Build the apropriate description for the admin page.
     *
     * @return string
     */
    private function _buildDescription()
    {
        $logo = "<span class='klarna_logo_small'></span>";
        $desc = '';
        if ($this->_isInvoice()) {
            $desc = KiTT::translator($this->_locale)->translate(
                'INVOICE_TEXT_DESCRIPTION'
            );
        } elseif ($this->_isPart()) {
            $desc = KiTT::translator($this->_locale)->translate(
                'PARTPAY_TEXT_DESCRIPTION'
            );
        } elseif ($this->_isSpec()) {
            $desc = KiTT::translator($this->_locale)->translate(
                'SPEC_TEXT_DESCRIPTION'
            );
        }

        $description
            = "<div style='float: right;'>{$logo}</div>" .
            "<div style='clear: both;'>{$desc}</div><br/><br/>" .
            "<img src='images/icon_popup.gif' border='0' />&nbsp;" .
            "<a href='https://www.klarna.com' target='_blank' ".
            "style='text-decoration: underline; font-weight: bold;'>".
            "Visit Klarna's Website</a>";

        if (KlarnaConstant::isAdmin()
            && KlarnaConstant::isEnabled(
                $this->_option, $this->_country
            )
            && ($this->_isPart() || $this->_isSpec())
        ) {
            $description
                .= '<br/><br/><img src="images/icon_info.gif" border="0">&nbsp;<b>' .
                'Click <a href="modules.php?set=payment&module=' . $this->code .
                '&get_pclasses=true" style="text-decoration: underline; '.
                'font-weight: bold;">here</a> to update your pclasses</b><br />';
        }

        return $description;
    }

    /**
     * Check for latest version.
     *
     * @return void
     */
    private function _checkForLatestVersion()
    {
        if (($this->_isInvoice()
            && strtolower(MODULE_PAYMENT_KLARNA_LASTESTVERSION) == 'true')
            || ($this->_isSpec()
            && strtolower(MODULE_PAYMENT_SPECKLARNA_LASTESTVERSION) == 'true')
            || ($this->_isPart()
            && strtolower(MODULE_PAYMENT_PCKLARNA_LASTESTVERSION) == 'true')
        ) {
            $this->_utils->checkForLatestVersion();
        }
    }

    /**
     * Build and return the title for the admin backend.
     *
     * @return string
     */
    private function _title()
    {
        $tulip = '';
        if (KlarnaConstant::isAdmin()) {
            $tulip = '<span class="klarna_icon"> </span>';
        }
        if ($this->_isInvoice()) {
            return $tulip . KiTT::translator($this->_locale)->translate(
                'MODULE_INVOICE_TEXT_TITLE'
            );
        }
        if ($this->_isPart()) {
            return $tulip . KiTT::translator($this->_locale)->translate(
                'MODULE_PARTPAY_TEXT_TITLE'
            );
        }
        if ($this->_isSpec()) {
            return $tulip . KiTT::translator($this->_locale)->translate(
                'MODULE_SPEC_TEXT_TITLE'
            );
        }
    }

    /**
     * Check if the instanced payment module should be shown.
     *
     * @return boolean
     */
    private function _isEnabled()
    {
        if ($this->enabled
            && KlarnaConstant::isActivated(
                $this->_option, $this->_country
            )
            && KlarnaConstant::isEnabled(
                $this->_option, $this->_country
            )
        ) {
            return true;
        }
        return false;
    }
}
