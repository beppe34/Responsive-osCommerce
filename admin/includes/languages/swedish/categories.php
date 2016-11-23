<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Produkter');
define('HEADING_TITLE_SEARCH', 'Sök:');
define('HEADING_TITLE_GOTO', 'Gå till:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Produkter');
define('TABLE_HEADING_ACTION', 'Åtgärd');
define('TABLE_HEADING_STATUS', 'Status');

define('TEXT_NEW_PRODUCT', 'Ny produkt i &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Kategorier:');
define('TEXT_SUBCATEGORIES', 'Underkategorier:');
define('TEXT_PRODUCTS', 'Produkter:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Pris:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Skatteklass:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Genomsnittsbetyg:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Antal/Mängd:');
define('TEXT_DATE_ADDED', 'Tillagd den:');
define('TEXT_DATE_AVAILABLE', 'Tillgänglig från:');
define('TEXT_LAST_MODIFIED', 'Senast ändrad:');
define('TEXT_IMAGE_NONEXISTENT', 'BILD FINNS INTE');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Infoga en ny kategori eller produkt i denna nivå.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'För mer information, gå till denna produkts <a href="http://%s" target="_blank"><u>webbsida</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'Denna produkt lades till vår katalog den %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Denna produkt kommer att finnas i lager den %s.');

define('TEXT_EDIT_INTRO', 'Vänligen utför de nödvändiga ändringarna');
define('TEXT_EDIT_CATEGORIES_ID',    'Kategori ID:');
define('TEXT_EDIT_CATEGORIES_NAME',  'Kategori namn:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Kategori bild:');
define('TEXT_EDIT_SORT_ORDER', 'Sorteringsordning:');

define('TEXT_INFO_COPY_TO_INTRO', 'Välj en ny kategori som du vill kopiera denna produkt till');

define('TEXT_INFO_HEADING_NEW_CATEGORY',   'Ny kategori');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Redigera kategori');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Radera kategori');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Flytta kategori');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Radera produkt');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Flytta produkt');
define('TEXT_INFO_HEADING_COPY_TO', 'Kopiera till');

define('TEXT_DELETE_CATEGORY_INTRO', 'Är du säker på att du vill radera denna kategori?');
define('TEXT_DELETE_PRODUCT_INTRO',  'Är du säker på att du vill radera denna produkt permanent?');

define('TEXT_DELETE_WARNING_CHILDS',   '<b>VARNING:</b> Det finns %s (under-)kategorier som fortfarande är länkade till denna kategori!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>VARNING:</b> Det finns %s produkter som fortfarande är länkade till denna kategori!');

define('TEXT_MOVE_PRODUCTS_INTRO',   'Välj vilken kategori du vill att <b>%s</b> skall ligga under');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Välj vilken kategori du vill att <b>%s</b> skall ligga under');
define('TEXT_MOVE', 'Flytta <strong>%s</strong> till:');

define('TEXT_NEW_CATEGORY_INTRO', 'Fyll i följande information för den nya kategorin');
define('TEXT_CATEGORIES_NAME', 'Kategorinamn:');
define('TEXT_CATEGORIES_IMAGE', 'Kategori bild:');
define('TEXT_SORT_ORDER', 'Sorteringsordning:');

define('TEXT_PRODUCTS_STATUS', 'Produktstatus:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Tillgänglig datum:');
define('TEXT_PRODUCT_AVAILABLE', 'I lager');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Slut i lager');
define('TEXT_PRODUCTS_MANUFACTURER', 'Produkttillverkare:');
define('TEXT_PRODUCTS_NAME', 'Produktnamn:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Produktbeskrivning:');
define('TEXT_PRODUCTS_QUANTITY', 'Produkt kvantitet:');
define('TEXT_PRODUCTS_MODEL', 'Artikelnummer:');
define('TEXT_PRODUCTS_IMAGE', 'Produkt bild:');
define('TEXT_PRODUCTS_MAIN_IMAGE', 'Huvudbild');
define('TEXT_PRODUCTS_LARGE_IMAGE', 'Storbild');
define('TEXT_PRODUCTS_LARGE_IMAGE_HTML_CONTENT', 'HTML innehåll (för popup)');
define('TEXT_PRODUCTS_ADD_LARGE_IMAGE', 'Lägg till storbild');
define('TEXT_PRODUCTS_LARGE_IMAGE_DELETE_TITLE', 'Ta bort stora produktbilden?');
define('TEXT_PRODUCTS_LARGE_IMAGE_CONFIRM_DELETE', 'Vänligen bekräfta borttagningen av den stora produktbild.');
define('TEXT_PRODUCTS_URL', 'Produkt URL:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(utan http://)</small>');
define('TEXT_PRODUCTS_PRICE_NET', 'Produktpris (Netto):');
define('TEXT_PRODUCTS_PRICE_GROSS', 'Produkt Price (Brutto):');
define('TEXT_PRODUCTS_WEIGHT', 'Produktvikt:');

define('EMPTY_CATEGORY', 'Tom kategori');

define('TEXT_HOW_TO_COPY', 'Kopieringsmetod:');
define('TEXT_COPY_AS_LINK', 'Produktlänk');
define('TEXT_COPY_AS_DUPLICATE', 'Dublettprodukt');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Error: Can not link products in the same category.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Error: Catalog images directory is not writeable: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Error: Catalog images directory does not exist: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT', 'Error: Category cannot be moved into child category.');

// http://www.linuxuk.co.uk - Notify when back in stock. Start
 define('HTML_NOTIFICATION1', 'Hej ');
 define('HTML_NOTIFICATION2', ',' . "\n\n" . 'Enligt din ');
 define('HTML_NOTIFICATION3', ' önskan om varulager notifiering, så kan vi nu meddela att ' . '<a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'product_info.php' . '?products_id=');
 define('HTML_NOTIFICATION4', '</a>' . ' åter finns i lager.  Besök ' . '<a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG);
 define('HTML_NOTIFICATION5', '</a>' . ' ifall du fortfarande är intresserad.' . "\n\n" . 'Din produkt notifiering för ');
 define('HTML_NOTIFICATION6', ' har tagits bort.  Ifall du önskar andra meddelanden gällande denna ');
 define('HTML_NOTIFICATION7', ', måste du ' . '<a href="' . HTTPS_CATALOG_SERVER . DIR_WS_CATALOG . 'login.php' . '">' . 'logga in' . '</a>' . ' till ditt ');
 define('HTML_NOTIFICATION8', ' konto, hitta produkten ' . '<a href="' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'product_info.php' . '?products_id=');
 define('HTML_NOTIFICATION9', '</a>' . ' , och klicka på ' . '<i>' . 'meddelande' . '</i>' . ' knappen.' . "\n\n" . 'Med vänliga hälsningar från ');
 define('TEXT_NOTIFICATION1', 'Hej ');
 define('TEXT_NOTIFICATION2', ',' . "\n\n" . 'Enligt din ');
 define('TEXT_NOTIFICATION3', ' önskan om varulager notifiering, så kan vi nu meddela att ');
 define('TEXT_NOTIFICATION4', ' åter finns i lager.  Besök ' . HTTP_CATALOG_SERVER . DIR_WS_CATALOG . ' ifall du fortfarande är intresserad.' . "\n\n" . 'Din produkt notifiering för ');
 define('TEXT_NOTIFICATION5', ' har tagits bort. ');
 define('TEXT_NOTIFICATION6', '');
 define('TEXT_NOTIFICATION7', '');
 define('TEXT_NOTIFICATION8', ' Med vänliga hälsningar från ');
 define('EMAIL_SUBJECT', 'Produkt åter i lager: ');
 // http://www.linuxuk.co.uk - Notify when back in stock. End
?>
