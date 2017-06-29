<?php
/**
 * Pass arguments to ajax.
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
require 'includes/application_top.php';
require_once DIR_FS_CATALOG . 'includes/classes/' . 'klarna/class.KlarnaCore.php';

/**
* Extend KlarnaUtils to get access to protected methods.
*
* @category Payment
* @package  Klarna_Module_OsCommerce
* @author   MS Dev <ms.modules@klarna.com>
* @license  http://opensource.org/licenses/BSD-2-Clause BSD2
* @link     http://integration.klarna.com
*/
class OscAjax
{
    /**
    * Constructor.
    * Takes information from GET and sends it to KlarnaAjax and
    * the Dispatcher.
    */
    public function __construct()
    {
        $country    = $_GET['country'];
        $option     = str_replace('klarna_box_', '', $_GET['type']);

        if ($option == "special") {
            $option = KiTT::SPEC;
        }

        KlarnaUtils::configureKiTT($option);
        KlarnaUtils::configureKlarna($option);

        $dispatcher = KiTT::ajaxDispatcher(
            new KiTT_Addresses(KiTT::api(KiTT::locale($country))),
            null
        );
        $dispatcher->dispatch();
    }
}

// call the constructor where the wanted things happen.
new OscAjax();
