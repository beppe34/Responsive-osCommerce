<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Valutor');

define('TABLE_HEADING_CURRENCY_NAME', 'Valuta');
define('TABLE_HEADING_CURRENCY_CODES', 'Kod');
define('TABLE_HEADING_CURRENCY_VALUE', 'Värde');
define('TABLE_HEADING_ACTION', 'Åtgärd');

define('TEXT_INFO_EDIT_INTRO', 'Vänligen gör nödvändiga ändringar');
define('TEXT_INFO_CURRENCY_TITLE', 'Titel:');
define('TEXT_INFO_CURRENCY_CODE', 'Kod:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Symbol vänster:');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Symbol höger:');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Decimaltecken:');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Tusental tecken:');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Antal decimaler:');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'Senast uppdaterad:');
define('TEXT_INFO_CURRENCY_VALUE', 'Värde:');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Visningsexempel:');
define('TEXT_INFO_INSERT_INTRO', 'Ange din nya valuta med tillhörande värden');
define('TEXT_INFO_DELETE_INTRO', 'Är du säker på att du vill radera denna valuta?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'Ny valuta');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'Redigera valuta');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'Radera valuta');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (kräver en manuell uppdatering av valutavärden)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Växlingskursen för %s (%s) uppdaterades via %s.');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'Fel: Standardvalutan kan inte tas bort. Välj en annan valuta som standardvaluta och försök igen.');
define('ERROR_CURRENCY_INVALID', 'Fel: Växlingskursen för %s (%s) uppdaterades inte via %s. Är det en ogiltig valutakod?');
define('WARNING_PRIMARY_SERVER_FAILED', 'Varning: Den primära servern för växlingskurs (%s) misslyckades att uppdatera %s (%s) - Försöker med den sekundära servern.');
?>
