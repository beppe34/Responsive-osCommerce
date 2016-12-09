<?php
/**
 * Handle setting of paths and encoding in one place
 *
 * PHP Version 5.2
 *
 * @category Payment
 * @package  Klarna_Module_OsCommerce
 * @author   MS Dev <ms.modules@klarna.com>
 * @license  http://opensource.org/licenses/BSD-2-Clause BSD2
 * @link     http://integration.klarna.com
 */
if (!defined('DIR_KLARNA')) {
    define('DIR_KLARNA', dirname(__FILE__) . '/');
}

require_once 'class.oscformat.php';
require_once 'class.KlarnaConstants.php';
require_once 'class.KlarnaUtils.php';

// This is to prevent XMLRPC from overwriting a variable that osCommerce uses.
if (isset($i)) {
    $_i = $i;
}

/**
 * Dependencies from {@link http://phpxmlrpc.sourceforge.net/}
 *
 * Ugly include due to problems in XMLRPC lib (external)
 */
require_once DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc';
require_once DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc';

// Restore OScommerces variable.
if (isset($_i)) {
    $i = $_i;
}

require_once 'api/Klarna.php';
require_once 'api/pclasses/mysqlstorage.class.php';

require_once 'KITT/classes/KiTT.php';

// The OsCommerce platform stores the charset used in it's CHARSET constant.
// We want to use this for our KlarnaString class as the platformEncoding.
// If the charset is reported as 'iso-8859-1', testing has shown it to actually
// be cp1252 (a Microsoft implementation of ISO-8859-1).
if (strtoupper(constant('CHARSET')) == 'ISO-8859-1') {
    KiTT_String::$platformEncoding = 'cp1252';
} else {
    KiTT_String::$platformEncoding = strtoupper(constant('CHARSET'));
}

class KlarnaCore {
    public static function getCurrentVersion() {
        return '2.2.3';
    }
}
