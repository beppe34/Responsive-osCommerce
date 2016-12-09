<?php
/**
 * Invoice Fee Module
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */

require_once DIR_FS_CATALOG . 'includes/classes/klarna/class.KlarnaCore.php';

/**
 * Klarna Order Total (Invoice Fee) module.
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class ot_klarna_fee
{
    var $title, $output;

    private $_country;
    private $_lang;

    /**
    * Constructor
    */
    function __construct()
    {
        global $order;
        $this->code = 'ot_klarna_fee';
        $this->_country = $order->delivery['country']['iso_code_2'];
        $this->_utils = new KlarnaUtils($this->_country);
        $this->_lang = KlarnaUtils::getLanguageCode();

        // Configure KiTT
        $this->_utils->configureKiTT();

        $invFee = htmlentities(
            $this->_utils->translate('ot_klarna_title', $this->_lang),
            ENT_COMPAT,
            'UTF-8'
        );

        if (KlarnaConstant::isAdmin() && !isset($_GET['action'])) {
            echo "<link href='" .
                KlarnaUtils::getExternalKiTTPath() .
            "/res/v1.1/images.css' type='text/css' rel='stylesheet'/>";
            $this->title
                = "<span class='klarna_icon'></span> Klarna - {$invFee}";
        } else {
            $this->title = $invFee;
        }

        $this->description = $this->_utils->translate(
            'ot_klarna_title', $this->_lang
        );
        $this->description
            .= "<br />All invoice fees should be set in that countries currency";
        $this->enabled = MODULE_KLARNA_FEE_STATUS;
        $this->sort_order = MODULE_KLARNA_FEE_SORT_ORDER;
        $this->tax_class = MODULE_KLARNA_FEE_TAX_CLASS;
        $this->output = array();
    }

    /**
    * Show information
    *
    * @return void
    */
    function process()
    {
        global $order, $currencies;

        $od_amount = $this->calculateInvoiceFee();

        //Disable module when $od_amount is <= 0
        if ($od_amount <= 0) {
            $this->enabled = false;
            return;
        }

        $this->output[] = array(
            'title' => $this->title . ':',
            'text' => $currencies->format($od_amount),
            'value' => $od_amount
        );

        $order->info['total'] += $od_amount;
    }


    /**
     * Get the invoice fee converted to the store base currency value.
     *
     * This is needed because OsCommerce always calculates with the base currency
     * and then formates the price to the chosen currency when displaying the prices
     * on .ie the order total
     *
     * @return double
     */
    private function _getConvertedInvoiceFee()
    {
        global $currencies, $currency;

        return $this->_utils->getInvoiceFee() / $currencies->get_value($currency);
    }

    /**
    * Calculate the invoice fee and add the invoice fee tax to the order total
    * if it has one.
    *
    * @return float
    */
    public function calculateInvoiceFee()
    {
        global $order, $payment, $customer_zone_id, $customer_country_id;

        if ($payment !== "klarna_invoice") {
            return 0;
        }

        $fee = $this->_getConvertedInvoiceFee();

        if ($fee === 0) {
            return $fee;
        }

        $feeTax = 0;
        if (MODULE_KLARNA_FEE_TAX_CLASS > 0) {
            $rate = tep_get_tax_rate(MODULE_KLARNA_FEE_TAX_CLASS);
            $feeExclTax = ($fee / ($rate / 100 + 1));
            $feeTax = ($fee - $feeExclTax);

            $tax_desc = tep_get_tax_description(
                MODULE_KLARNA_FEE_TAX_CLASS,
                $customer_country_id, $customer_zone_id
            );
            $order->info['tax_groups']["$tax_desc"] += $feeTax;
            $order->info['tax'] += $feeTax;
        }

        if (DISPLAY_PRICE_WITH_TAX === "true") {
            return $fee;
        }

        $order->info['total'] += $feeTax;

        return $fee - $feeTax;

    }

    /**
    * Check if module is installed/activated
    *
    * @return int   Installation status
    */
    function check()
    {
        if (!isset($this->check)) {
            $check_query = tep_db_query(
                "SELECT configuration_value FROM " . TABLE_CONFIGURATION .
                " where configuration_key = 'MODULE_KLARNA_FEE_STATUS'"
            );
            $this->check = tep_db_num_rows($check_query);
        }

        return $this->check;
    }

    /**
    * Installation function
    *
    * @return void
    */
    function install()
    {
        tep_db_query(
            "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
            "configuration_title, configuration_key, configuration_value, ".
            "configuration_description, configuration_group_id, set_function, ".
            "date_added) ".
            "VALUES ('0','Display Total', 'MODULE_KLARNA_FEE_STATUS', 'true', ".
            "'Do you want to display the payment charge', '6', ".
            "'tep_cfg_select_option(array(\'true\', \'false\'), ', now())"
        );

        tep_db_query(
            "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
            "configuration_title, configuration_key, configuration_value, ".
            "configuration_description, configuration_group_id, set_function, ".
            "date_added) ".
            "VALUES ('1','Charge Type', 'MODULE_KLARNA_FEE_MODE', 'fixed', ".
            "'Invoice charge is fixed or based  on the order total.', '6', ".
            "'tep_cfg_select_option(array(\'fixed\', \'price\'), ', now())"
        );

        foreach (KiTT::supportedCountries() as $country) {
            $flag = "<span class=\'klarna_flag_" . strtolower($country) . "\'></span>";
            tep_db_query(
                "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
                "configuration_title, configuration_key, configuration_value, ".
                "configuration_description, configuration_group_id, date_added) ".
                "VALUES ('2','{$flag} {$country} Fixed invoice charge', ".
                "'MODULE_KLARNA_FEE_FIXED_{$country}', '20', ".
                "'Fixed invoice charge (inc. VAT).', '6', now())"
            );
            tep_db_query(
                "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
                "configuration_title, configuration_key, configuration_value, ".
                "configuration_description, configuration_group_id, date_added) ".
                "VALUES ('3','{$flag} {$country} Charge Table', ".
                "'MODULE_KLARNA_FEE_TABLE_{$country}', '200:20,500:10,10000:5', ".
                "'The invoice charge is based on the total cost. ".
                "Example: 200:20,500:10,10000:5,etc.. Up to 200 charge 20, from ".
                "there to 500 charge 10, etc', '6', now())"
            );
        }

        tep_db_query(
            "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
            "configuration_title, configuration_key, configuration_value, ".
            "configuration_description, configuration_group_id, use_function, ".
            "set_function, date_added) ".
            "VALUES ('4','Tax Class', 'MODULE_KLARNA_FEE_TAX_CLASS', '0', ".
            "'Use the following tax class on the payment charge.', '6', ".
            "'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())"
        );

        tep_db_query(
            "INSERT INTO " . TABLE_CONFIGURATION . " (sort_order, ".
            "configuration_title, configuration_key, configuration_value, ".
            "configuration_description, configuration_group_id, date_added) ".
            "VALUES ('5','Sort Order', 'MODULE_KLARNA_FEE_SORT_ORDER', '0', ".
            "'Sort order of display.', '6', now())"
        );
    }

    /**
    * Uninstall function
    *
    * @return void
    */
    function remove()
    {
        $keys = '';
        $keys_array = $this->keys();
        for ( $i = 0; $i < sizeof($keys_array); $i++ ) {
            $keys .= "'" . $keys_array[$i] . "',";
        }
        $keys = substr($keys, 0, -1);

        tep_db_query(
            "delete from " . TABLE_CONFIGURATION .
            " where configuration_key in (" . $keys . ")"
        );
    }

    /**
    * Constants
    *
    * @return array     constants configured
    */
    function keys()
    {
        $keys = array(
            'MODULE_KLARNA_FEE_STATUS',
            'MODULE_KLARNA_FEE_MODE',
        );
        foreach (KiTT::supportedCountries() as $country) {
            $keys[] = "MODULE_KLARNA_FEE_FIXED_{$country}";
            $keys[] = "MODULE_KLARNA_FEE_TABLE_{$country}";
        }
        $keys[] = 'MODULE_KLARNA_FEE_TAX_CLASS';
        $keys[] = 'MODULE_KLARNA_FEE_SORT_ORDER';

        return $keys;
    }
}
