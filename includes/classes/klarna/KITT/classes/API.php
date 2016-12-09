<?php
/**
 * API extension
 *
 * PHP Version 5.3
 *
 * @category  Payment
 * @package   KiTT
 * @author    MS Dev <ms.modules@klarna.com>
 * @copyright 2012 Klarna AB (http://klarna.com)
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2
 * @link      http://integration.klarna.com/
 */

/**
 * Extending the API in order to easily support updating version
 *
 * @category  Payment
 * @package   KiTT
 * @author    MS Dev <ms.modules@klarna.com>
 * @copyright 2012 Klarna AB (http://klarna.com)
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2
 * @link      http://integration.klarna.com/
 */
class KiTT_API extends Klarna
{

    /**
     * Constructor
     *
     * @param KiTT_Config $config configuration
     * @param KiTT_Locale $locale locale
     */
    public function __construct(KiTT_Config $config, KiTT_Locale $locale)
    {

        parent::__construct();

        $country = $locale->getCountryCode();

        $partialConfig = array(
            'eid' => $config->get("sales_countries/{$country}/eid"),
            'secret' => $config->get("sales_countries/{$country}/secret"),
            'country' => $country,
            'currency' => $locale->getCurrencyCode(),
            'language' => $locale->getLanguageCode(),
        );

        // Optional override of the xmlrpc target server.
        if (defined('KITT_KRED_OVERRIDE')) {
            $partialConfig['url'] = constant('KITT_KRED_OVERRIDE');
        }

        $module = $config->get("module");
        $version = $config->get("version");
        $this->VERSION = "PHP:{$module}:{$version}";
        $klarnaConfig = array_merge($partialConfig, $config->get('api'));
        $this->setConfig($klarnaConfig);
    }

}
