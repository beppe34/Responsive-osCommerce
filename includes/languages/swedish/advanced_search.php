<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Avancerad sökning');
define('NAVBAR_TITLE_2', 'Sökresultat');

define('HEADING_TITLE_1', 'Avancerad sökning');
define('HEADING_TITLE_2', 'Sökresultat');

define('HEADING_SEARCH_CRITERIA', 'Sökfilter');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Sök också i beskrivningen');
define('ENTRY_CATEGORIES', 'Kategorier:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'Inkludera subkategorier');
define('ENTRY_MANUFACTURERS', 'Tillverkare:');
define('ENTRY_PRICE_FROM', 'Pris från:');
define('ENTRY_PRICE_TO', 'Pris till:');
define('ENTRY_DATE_FROM', 'Datum från:');
define('ENTRY_DATE_TO', 'Datum till:');

define('ENTRY_PRICE_FROM_TEXT', '');
define('ENTRY_PRICE_TO_TEXT', '');
define('ENTRY_DATE_FROM_TEXT', '');
define('ENTRY_DATE_TO_TEXT', '');

define('TEXT_SEARCH_HELP_LINK', '<u>Sökhjälp</u> [?]');

define('TEXT_ALL_CATEGORIES', 'Alla kategorier');
define('TEXT_ALL_MANUFACTURERS', 'Alla tillverkare');

define('HEADING_SEARCH_HELP', 'Sökhjälp');
define('TEXT_SEARCH_HELP', 'Sökorden kan separeras med AND och/eller OR för ett bättre sökresultat.<br><br>Till exempel, <u>Microsoft AND mus</u> ger ett sökresultat som innehåller både Microsoft och mus. Men, <u>mus OR keyboard</u>, skulle ge ett sökresultat som innehåller båda orden eller bara ett av orden.<br><br>Exakt sökresultat fås om du kapslar in orden med dubbelapostrofer.<br><br>Till exempel, <u>"bärbar dator"</u> skulle ge resultatet att exakt den strängen skulle visas.<br><br>Parenteser kan användas för att ytterligare precisera sökresultatet.<br><br>Till exempel, <u>Microsoft and (keyboard or mouse or "visual basic")</u>.');
define('TEXT_CLOSE_WINDOW', '<u>Stäng fönstret</u> [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Modell');
define('TABLE_HEADING_PRODUCTS', 'Produktnamn');
define('TABLE_HEADING_MANUFACTURER', 'Tillverkare');
define('TABLE_HEADING_QUANTITY', 'Antal');
define('TABLE_HEADING_PRICE', 'Pris');
define('TABLE_HEADING_WEIGHT', 'Vikt');
define('TABLE_HEADING_BUY_NOW', 'Köp nu');

define('TEXT_NO_PRODUCTS', 'Det finns inga produkter som matchar sökkriteriet.');

define('ERROR_AT_LEAST_ONE_INPUT', 'Åtminstone ett sökfält måste fyllas i.');
define('ERROR_INVALID_FROM_DATE', 'Ej giltigt \"Från datum\".');
define('ERROR_INVALID_TO_DATE', 'Ej giltigt \"Till datum\".');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', '\"Till datum\" måste vara lika med eller senare än \"Från datum\".');
define('ERROR_PRICE_FROM_MUST_BE_NUM', '\"Pris från\" måste vara ett nummer.');
define('ERROR_PRICE_TO_MUST_BE_NUM', '\"Pris till\" måste vara ett nummer.');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', '\"Pris till\" måste vara högre eller lika med \"Pris från\".');
define('ERROR_INVALID_KEYWORDS', 'Felaktigt sökkriterium.');
?>
