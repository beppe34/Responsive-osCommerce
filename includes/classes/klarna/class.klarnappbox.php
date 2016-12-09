<?php
/**
 * PartPayment widget
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
 * Class handling the proper showing of the partpayment box.
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
class Klarna_PPbox
{
    /**
     * @var KiTT_Locale
     */
    private $_locale;

    /**
     * @var KiTT_Installment_Controller_Abstract
     */
    private $_controller;

    /**
     * Constructor
     *
     * @param KiTT_Locale                          $locale     Locale to use
     * @param KiTT_Installment_Controller_Abstract $controller Installment controller
     */
    public function __construct(
        KiTT_Locale $locale, KiTT_Installment_Controller_Abstract $controller
    ) {
        $this->_locale = $locale;
        $this->_controller = $controller;
    }

    /**
     * Get the locale used
     *
     * @return KiTT_Locale
     */
    public function locale()
    {
        return $this->_locale;
    }

    /**
     * Check if the payment option is enabled
     *
     * @return bool
     */
    public function enabled()
    {
        $country = $this->_locale->getCountryCode();

        if (!KlarnaConstant::isEnabled('part', $country)) {
            Klarna::printDebug(__METHOD__, "Module is disabled");
            return false;
        }

        if (!KlarnaConstant::isActivated('part', $country)) {
            Klarna::printDebug(__METHOD__, "Country is disabled");
            return false;
        }

        if (!$this->_controller->isAvailable()) {
            Klarna::printDebug(__METHOD__, "Widget is unavailable");
            return false;
        }

        return true;
    }

    /**
     * Show the necessary javascripts and css files required for
     * the installment widget
     *
     * @return string
     */
    public function show()
    {
        $templateLoader = KiTT::templateLoader($this->_locale);

        $cssLoader = $templateLoader->load('css.mustache');
        $jsLoader = $templateLoader->load('javascript.mustache');

        $kittExternal = KlarnaUtils::getExternalKiTTPath();

        $styles = array(
            'includes/classes/klarna/template/css/oscstyle.css',
            'ext/modules/payment/klarna/productprice/style.css',
            "{$kittExternal}/pp/v1.0/pp.css"
        );
        if (KlarnaConstant::isLegacyShop()) {
            $styles[] = "includes/classes/klarna/template/css/klarna22rc2a.css";
        }

        $result = "";
        $result .= $cssLoader->render(array('styles' => $styles));

        $result .= $jsLoader->render(
            array(
                "scripts" => array(
                    "{$kittExternal}/core/v1.0/js/klarna.min.js",
                    "{$kittExternal}/res/v1.1/js/klarna.lib.js",
                    "{$kittExternal}/pp/v1.0/js/productprice.js"
                )
            )
        );

        $result .= $this->_controller->createWidget()->show();

        return $result;
    }
}
