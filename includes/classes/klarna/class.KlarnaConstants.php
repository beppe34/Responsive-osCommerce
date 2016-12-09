<?php
/**
 * Class to handle the OSC constants (that are configured in the backend)
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */

/**
 * Class to handle static constants.
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class KlarnaConstant
{

    /**
    * return merchant id for specified countrty and payment option.
    *
    * @param string $option  payment method
    * @param string $country country
    *
    * @return int|null
    */
    public static function merchantID($option, $country)
    {
        $eidstring = "";
        switch ($option) {
        case KiTT::PART:
            $eidstring = "MODULE_PAYMENT_PCKLARNA_EID_";
            break;
        case KiTT::SPEC:
            $eidstring = "MODULE_PAYMENT_SPECKLARNA_EID_";
            break;
        case KiTT::INVOICE:
            $eidstring = "MODULE_PAYMENT_KLARNA_EID_";
            break;
        default:
            return null;
        }

        $eidstring .= strtoupper($country);
        if (defined($eidstring)) {
            return (int) constant($eidstring);
        }
        return null;
    }


    /**
    * return shared secret for specified countrty and payment option.
    *
    * @param string $option  payment method
    * @param string $country country
    *
    * @return string|null
    */
    public static function secret($option, $country)
    {
        $secretstring = "";
        switch ($option) {
        case KiTT::PART:
            $secretstring = "MODULE_PAYMENT_PCKLARNA_SECRET_";
            break;
        case KiTT::SPEC:
            $secretstring = "MODULE_PAYMENT_SPECKLARNA_SECRET_";
            break;
        case KiTT::INVOICE:
            $secretstring = "MODULE_PAYMENT_KLARNA_SECRET_";
            break;
        default:
            return null;

        }

        $secretstring .= strtoupper($country);
        if (defined($secretstring)) {
            return constant($secretstring);
        }
        return null;
    }

    /**
     * Returns the AGB link
     *
     * @param string $option  payment option
     * @param string $country country
     *
     * @return AGB Link specified in backend, or null if not set.
     */
    public static function agb($option, $country)
    {
        $country = strtoupper($country);
        switch ($option) {
        case KiTT::PART:
            if (defined("MODULE_PAYMENT_PCKLARNA_AGB_LINK_{$country}")) {
                return constant(
                    "MODULE_PAYMENT_PCKLARNA_AGB_LINK_{$country}"
                );
            }
        case KiTT::SPEC:
            if (defined("MODULE_PAYMENT_SPECKLARNA_AGB_LINK_{$country}")) {
                return constant(
                    "MODULE_PAYMENT_SPECKLARNA_AGB_LINK_{$country}"
                );
            }
        case KiTT::INVOICE:
            if (defined("MODULE_PAYMENT_KLARNA_AGB_LINK_{$country}")) {
                return constant(
                    "MODULE_PAYMENT_KLARNA_AGB_LINK_{$country}"
                );
            }
        }
        return "";
    }

    /**
     * Get the mode for the given payment option.
     *
     * @param string $option invoice, spec or part
     *
     * @return int Klarna::LIVE or Klarna::BETA
     */
    public static function mode($option)
    {
        switch ($option) {
        case KiTT::PART:
            return (strtolower(MODULE_PAYMENT_PCKLARNA_LIVEMODE) == "true")
                ? Klarna::LIVE : Klarna::BETA;
        case KiTT::SPEC:
            return (strtolower(MODULE_PAYMENT_SPECKLARNA_LIVEMODE) == "true")
                ? Klarna::LIVE : Klarna::BETA;
        case KiTT::INVOICE:
            return (strtolower(MODULE_PAYMENT_KLARNA_LIVEMODE) == "true")
                ? Klarna::LIVE : Klarna::BETA;
        default:
            return null;
        }
    }


    /**
     * Check to see if given country is activated for given payment option.
     *
     * @param string $option  payment option
     * @param string $country country
     *
     * @return boolean
     */
    public static function isActivated($option, $country)
    {
        $_activated = self::getActivated($option);

        return in_array(
            strtoupper($country),
            $_activated
        );
    }

    /**
     * retrieve the URI for pclass storage.
     *
     * @return array
     */
    public static function pcURI()
    {
        return array(
            'user' => DB_SERVER_USERNAME,
            'passwd' => DB_SERVER_PASSWORD,
            'dsn' => DB_SERVER,
            'db' => DB_DATABASE,
            'table' => 'klarna_pclasses'
        );
    }

    /**
     * get activated countries for a specific payment option as an array
     *
     * @param string $option payment option
     *
     * @return array
     */
    public static function getActivated($option)
    {
        switch (strtolower($option)) {
        case KiTT::PART:
            return explode(
                ",",
                MODULE_PAYMENT_PCKLARNA_ACTIVATED_COUNTRIES
            );
        case KiTT::SPEC:
            return explode(
                ",",
                MODULE_PAYMENT_SPECKLARNA_ACTIVATED_COUNTRIES
            );
        case KiTT::INVOICE:
            return explode(
                ",",
                MODULE_PAYMENT_KLARNA_ACTIVATED_COUNTRIES
            );
        default:
            return array();
        }
    }

    /**
     * Check if logged in as admin
     *
     * @return true if logged in as admin
     */
    public static function isAdmin()
    {
        return (defined('DIR_WS_ADMIN'));
    }

    /**
     * Assert that the current shop installation is the legacy version 2.2rc2a
     *
     * @return bool
     */
    public static function isLegacyShop()
    {
        $version = str_replace(" ", "", strtolower(PROJECT_VERSION));
        return strpos($version, "2.2") !== false;
    }


    /**
    * Checks if the module setting is set to enabled.
    *
    * @param string $option payment option
    *
    * @return boolean  true if the specified payment option is enabled
    */
    public static function isEnabled($option)
    {
        switch ($option) {
        case KiTT::PART:
            return (strtolower(MODULE_PAYMENT_PCKLARNA_STATUS) == 'true');
        case KiTT::SPEC:
            return (strtolower(MODULE_PAYMENT_SPECKLARNA_STATUS) == 'true');
        case KiTT::INVOICE:
            return (strtolower(MODULE_PAYMENT_KLARNA_STATUS) == 'true');
        default:
            return false;
        }
    }

    /**
     * Get the instanced payment modules configured orderstatus id.
     *
     * @param string $option payment option
     *
     * @return int
     */
    public static function getOrderStatusId($option)
    {
        $id = 0;
        switch ($option) {
        case KiTT::INVOICE:
            $id = MODULE_PAYMENT_KLARNA_ORDER_STATUS_ID;
            break;
        case KiTT::PART:
            $id = MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_ID;
            break;
        case KiTT::SPEC:
            $id = MODULE_PAYMENT_SPECKLARNA_ORDER_STATUS_ID;
            break;
        }

        if ((int)$id > 0) {
            return $id;
        }

        return DEFAULT_ORDERS_STATUS_ID;
    }

    /**
     * Get the instanced payment modules configured pending orderstatus id.
     *
     * @param string $option payment option
     *
     * @return int
     */
    public static function getPendingOrderStatusId($option)
    {
        $id = 0;
        switch ($option) {
        case KiTT::INVOICE:
            $id = MODULE_PAYMENT_KLARNA_ORDER_STATUS_PENDING_ID;
            break;
        case KiTT::PART:
            $id = MODULE_PAYMENT_PCKLARNA_ORDER_STATUS_PENDING_ID;
            break;
        case KiTT::SPEC:
            $id = MODULE_PAYMENT_SPECKLARNA_ORDER_STATUS_PENDING_ID;
            break;
        }

        if ((int)$id > 0) {
            return $id;
        }

        return DEFAULT_ORDERS_STATUS_ID;
    }
}
