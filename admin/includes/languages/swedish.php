<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_ALL, array('en_US.UTF-8', 'en_US.UTF8', 'enu_usa'));
define('DATE_FORMAT_SHORT', '%Y-%m-%d');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'Y-m-d'); // this is used for date()
define('PHP_DATE_TIME_FORMAT', 'Y-m-d H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', ''); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('JQUERY_DATEPICKER_FORMAT', 'yy-mm-dd'); // see http://docs.jquery.com/UI/Datepicker/formatDate

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="sv"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'osCommerce Online Merchant Administration Tool');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Support Sida');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Katalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'Man');
define('FEMALE', 'Kvinna');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// configuration box text in includes/boxes/configuration.php
define('BOX_HEADING_CONFIGURATION', 'Konfiguration');
define('BOX_CONFIGURATION_MYSTORE', 'Min butik');
define('BOX_CONFIGURATION_LOGGING', 'Loggning');
define('BOX_CONFIGURATION_CACHE', 'Cache');
define('BOX_CONFIGURATION_ADMINISTRATORS', 'Administratör');
define('BOX_CONFIGURATION_STORE_LOGO', 'Butiks Logga');

// modules box text in includes/boxes/modules.php
define('BOX_HEADING_MODULES', 'Moduler');

// categories box text in includes/boxes/catalog.php
define('BOX_HEADING_CATALOG', 'Katalog');
define('BOX_CATALOG_CATEGORIES_PRODUCTS', 'Kategorier/Produkter');
define('BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES', 'Produktattribut');
define('BOX_CATALOG_MANUFACTURERS', 'Tillverkare');
define('BOX_CATALOG_REVIEWS', 'Recensioner');
define('BOX_CATALOG_SPECIALS', 'Erbjudande');
define('BOX_CATALOG_PRODUCTS_EXPECTED', 'Väntade produkter');

// customers box text in includes/boxes/customers.php
define('BOX_HEADING_CUSTOMERS', 'Kunder');
define('BOX_CUSTOMERS_CUSTOMERS', 'Kunder');

// orders box text in includes/boxes/orders.php
define('BOX_HEADING_ORDERS', 'Orders');
define('BOX_CUSTOMERS_ORDERS', 'Order');
define('BOX_ORDERS_ORDERS', 'Order');

// taxes box text in includes/boxes/taxes.php
define('BOX_HEADING_LOCATION_AND_TAXES', 'Platser / Skatter');
define('BOX_TAXES_COUNTRIES', 'Länder');
define('BOX_TAXES_ZONES', 'Zoner');
define('BOX_TAXES_GEO_ZONES', 'Skattezoner');
define('BOX_TAXES_TAX_CLASSES', 'Skatteklasser');
define('BOX_TAXES_TAX_RATES', 'Skattesatser');

// reports box text in includes/boxes/reports.php
//++++ QT Pro: Begin Changed code
define('BOX_REPORTS_STATS_LOW_STOCK_ATTRIB', 'Varulager Report');
//++++ QT Pro: End Changed Code
define('BOX_HEADING_REPORTS', 'Rapporter');
define('BOX_REPORTS_DAILY_SALES', 'Försäljning per dag');
define('BOX_REPORTS_PRODUCTS_VIEWED', 'Visade produkter');
define('BOX_REPORTS_PRODUCTS_PURCHASED', 'Köpta produkter');
define('BOX_REPORTS_ORDERS_TOTAL', 'Kunders ordertotaler');

// tools text in includes/boxes/tools.php
define('BOX_TOOLS_QTPRODOCTOR', 'QTPro Doctor');
define('BOX_HEADING_TOOLS', 'Verktyg');
define('BOX_TOOLS_ACTION_RECORDER', 'Action Övervakning');
define('BOX_TOOLS_BACKUP', 'Databas backup');
define('BOX_TOOLS_BANNER_MANAGER', 'Bannerhantering');
define('BOX_TOOLS_CACHE', 'Cache kontroll');
define('BOX_TOOLS_DEFINE_LANGUAGE', 'Definiera språk');
define('BOX_TOOLS_MAIL', 'Skicka e-post');
define('BOX_TOOLS_NEWSLETTER_MANAGER', 'Hantera nyhetsbrev');
define('BOX_TOOLS_SEC_DIR_PERMISSIONS', 'Säkerhet Katalogrättigheter');
define('BOX_TOOLS_SERVER_INFO', 'Server Info');
define('BOX_TOOLS_VERSION_CHECK', 'Version Kontroll');
define('BOX_TOOLS_WHOS_ONLINE', 'Vem är online');

// localizaion box text in includes/boxes/localization.php
define('BOX_HEADING_LOCALIZATION', 'Lokalisering');
define('BOX_LOCALIZATION_CURRENCIES', 'Valutor');
define('BOX_LOCALIZATION_LANGUAGES', 'Språk');
define('BOX_LOCALIZATION_ORDERS_STATUS', 'Orderstatus');

//credit class, gift vouchers and discount coupons
define('BOX_HEADING_GV_ADMIN', 'Presentkort/rabattkoder');
define('BOX_GV_ADMIN_QUEUE', 'Presentkort kö');
define('BOX_GV_ADMIN_MAIL', 'Maila presentkort');
define('BOX_GV_ADMIN_SENT', 'Presentkort skickat');
define('BOX_COUPON_ADMIN','Coupon Admin');
define('IMAGE_RELEASE', 'Använda presentkort');
define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> presentkort)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> kuponger)');
define('TEXT_VALID_PRODUCTS_LIST', 'Products List');
define('TEXT_VALID_PRODUCTS_ID', 'Products ID');
define('TEXT_VALID_PRODUCTS_NAME', 'Products Name');
define('TEXT_VALID_PRODUCTS_MODEL', 'Products Model');
define('TEXT_VALID_CATEGORIES_LIST', 'Categories List');
define('TEXT_VALID_CATEGORIES_ID', 'Category ID');
define('TEXT_VALID_CATEGORIES_NAME', 'Category Name');

// javascript messages
define('JS_ERROR', 'Fel har uppstått i hanteringen av ditt formulär!\nVänligen ändra följande:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Den nya produkten måste ha ett pris\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Det nya produktalternativet behöver ett pris-prefix\n');

define('JS_PRODUCTS_NAME', '* Den nya produkten behöver ett namn\n');
define('JS_PRODUCTS_DESCRIPTION', '* Den nya produkten behöver en beskrivning\n');
define('JS_PRODUCTS_PRICE', '* Den nya produkten behöver ett pris värde\n');
define('JS_PRODUCTS_WEIGHT', '* Den nya produkten behöver viktvärde\n');
define('JS_PRODUCTS_QUANTITY', '* Den nya produkten behöver antalsvärde\n');
define('JS_PRODUCTS_MODEL', '* Den nya produkten behöver modellvärde\n');
define('JS_PRODUCTS_IMAGE', '* Den nya produkten behöver en bild\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Denna produkt måste ha ett nytt pris\n');

define('JS_GENDER', '* \'Kön\' måste väljas.\n');
define('JS_FIRST_NAME', '* \'Förnamn\' måste vara minst ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' tecken långt.\n');
define('JS_LAST_NAME', '* \'Efternamn\' måste vara minst ' . ENTRY_LAST_NAME_MIN_LENGTH . ' tecken långt.\n');
define('JS_DOB', '* \'Födelsedatum\' måste ha formatet: mm/dd/åååå (månad/dag/är).\n');
define('JS_EMAIL_ADDRESS', '* \'E-postadress\' måste vara minst ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' tecken långt.\n');
define('JS_ADDRESS', '* \'Gatuadress\' m�ste vara minst ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' tecken långt.\n');
define('JS_POST_CODE', '* \'Postnummer\' måste vara minst ' . ENTRY_POSTCODE_MIN_LENGTH . ' tecken långt.\n');
define('JS_CITY', '* \'Ort\' måste vara minst ' . ENTRY_CITY_MIN_LENGTH . ' tecken långt.\n');
define('JS_STATE', '* \'Delstat\' måste vara valt.\n');
define('JS_STATE_SELECT', '-- Välj ovan --');
define('JS_ZONE', '* \'Delstat\' måste väljas ur listan för detta land.');
define('JS_COUNTRY', '* \'Land\' måste väljas.\n');
define('JS_TELEPHONE', '* \'Telefonnummer\' måste vara minst ' . ENTRY_TELEPHONE_MIN_LENGTH . ' tecken l�ngt.\n');
define('JS_PASSWORD', '* \'L�senord\' och \'Bekräfta\' värdena måste vara lika och vara minst ' . ENTRY_PASSWORD_MIN_LENGTH . ' tecken långa.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Order nummer %s finns inte!');

define('CATEGORY_PERSONAL', 'Personlig');
define('CATEGORY_ADDRESS', 'Adress');
define('CATEGORY_CONTACT', 'Kontakt');
define('CATEGORY_COMPANY', 'Företag');
define('CATEGORY_OPTIONS', 'Alternativ');

define('ENTRY_GENDER', 'Kön:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">krävs</span>');
define('ENTRY_FIRST_NAME', 'Förnamn:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' tecken</span>');
define('ENTRY_LAST_NAME', 'Efternamn:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_LAST_NAME_MIN_LENGTH . ' tecken</span>');
define('ENTRY_DATE_OF_BIRTH', 'Födelsedatum:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(t.ex. 05/21/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'E-postadress:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' tecken</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">E-postadressen verkar inte vara giltig!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Denna e-postadressen finns redan!</span>');
define('ENTRY_COMPANY', 'Företagsnamn:');
define('ENTRY_STREET_ADDRESS', 'Gatuadress:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' tecken</span>');
define('ENTRY_SUBURB', 'Stadsdel/förort:');
define('ENTRY_POST_CODE', 'Postnummer:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_POSTCODE_MIN_LENGTH . ' tecken</span>');
define('ENTRY_CITY', 'Ort:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_CITY_MIN_LENGTH . ' tecken</span>');
define('ENTRY_STATE', 'Delstat:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">krävs</span>');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_COUNTRY_ERROR', '');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">min ' . ENTRY_TELEPHONE_MIN_LENGTH . ' tecken</span>');
define('ENTRY_FAX_NUMBER', 'Faxnummer:');
define('ENTRY_NEWSLETTER', 'Nyhetsbrev:');
define('ENTRY_NEWSLETTER_YES', 'Prenumererar');
define('ENTRY_NEWSLETTER_NO', 'Prenumererar inte');

// images
define('IMAGE_ANI_SEND_EMAIL', 'Skickar e-post');
define('IMAGE_BACK', 'Tillbaka');
define('IMAGE_BACKUP', 'Backup');
define('IMAGE_CANCEL', 'Avbryt');
define('IMAGE_CONFIRM', 'Bekräfta');
define('IMAGE_COPY', 'Kopiera');
define('IMAGE_COPY_TO', 'Kopiera till');
define('IMAGE_DETAILS', 'Detaljer');
define('IMAGE_DELETE', 'Radera');
define('IMAGE_EDIT', 'Redigera');
define('IMAGE_EMAIL', 'E-post');
define('IMAGE_FILE_MANAGER', 'Filhanterare');
define('IMAGE_ICON_STATUS_GREEN', 'Aktiv');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Aktivera');
define('IMAGE_ICON_STATUS_RED', 'Inaktiv');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Inaktivera');
define('IMAGE_ICON_INFO', 'Info');
define('IMAGE_INSERT', 'Infoga');
define('IMAGE_LOCK', 'Lås');
define('IMAGE_MODULE_INSTALL', 'Installera modul');
define('IMAGE_MODULE_REMOVE', 'Ta bort modul');
define('IMAGE_MOVE', 'Flytta');
define('IMAGE_QTSTOCK', 'Varulager');
define('IMAGE_NEW_BANNER', 'Ny banner');
define('IMAGE_NEW_CATEGORY', 'Ny kategory');
define('IMAGE_NEW_COUNTRY', 'Nytt land');
define('IMAGE_NEW_CURRENCY', 'Ny valuta');
define('IMAGE_NEW_FILE', 'Ny fil');
define('IMAGE_NEW_FOLDER', 'Ny mapp');
define('IMAGE_NEW_LANGUAGE', 'Nytt språk');
define('IMAGE_NEW_NEWSLETTER', 'Nytt nyhetsbrev');
define('IMAGE_NEW_PRODUCT', 'Ny produkt');
define('IMAGE_NEW_TAX_CLASS', 'Ny skatteklass');
define('IMAGE_NEW_TAX_RATE', 'Ny skattesats');
define('IMAGE_NEW_TAX_ZONE', 'Ny skattezon');
define('IMAGE_NEW_ZONE', 'Ny zon');
define('IMAGE_ORDERS', 'Orders');
define('IMAGE_ORDERS_INVOICE', 'Faktura');
define('IMAGE_ORDERS_PACKINGSLIP', 'Packsedel');
define('IMAGE_PREVIEW', 'F�rhandsgranska');
define('IMAGE_RESTORE', 'Återställ');
define('IMAGE_RESET', 'Nollställ');
define('IMAGE_SAVE', 'Spara');
define('IMAGE_SEARCH', 'Sök');
define('IMAGE_SELECT', 'Välj');
define('IMAGE_SEND', 'Skicka');
define('IMAGE_SEND_EMAIL', 'Skicka e-post');
define('IMAGE_UNLOCK', 'Lås upp');
define('IMAGE_UPDATE', 'Uppdatera');
define('IMAGE_UPDATE_CURRENCIES', 'Uppdatera valutakurs');
define('IMAGE_UPLOAD', 'Ladda upp');

define('ICON_CROSS', 'Falskt');
define('ICON_CURRENT_FOLDER', 'Nuvarande mapp');
define('ICON_DELETE', 'Radera');
define('ICON_ERROR', 'Fel');
define('ICON_FILE', 'Fil');
define('ICON_FILE_DOWNLOAD', 'Ladda ner');
define('ICON_FOLDER', 'Mapp');
define('ICON_LOCKED', 'Låst');
define('ICON_PREVIOUS_LEVEL', 'Föregående nivå');
define('ICON_PREVIEW', 'Förhandsgranska');
define('ICON_STATISTICS', 'Statistik');
define('ICON_SUCCESS', 'Lyckades');
define('ICON_TICK', 'Sant');
define('ICON_UNLOCKED', 'Upplöst');
define('ICON_WARNING', 'Varning');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Sida %s av %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS',           'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> banners)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES',         'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> länder)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS',         'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> kunder)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES',        'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> valutor)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES',         'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> språk)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS',     'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> tillverkare)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS',       'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> nyhetsbrev)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS',            'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS',     'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> orders status)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS',          'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> produkter)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> väntadeprodukter)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS',           'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> produktrecensioner)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS',          'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> produkts med erbjudande)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES',       'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> skatteklasser)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES',         'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> skattezoner)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES',         'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> skattesatser)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES',             'Visar <b>%d</b> till <b>%d</b> (av <b>%d</b> zoner)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> zones)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'standard');
define('TEXT_SET_DEFAULT', 'Sätt som standard');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Krävs</span>');

define('TEXT_CACHE_CATEGORIES', 'Kategoriruta');
define('TEXT_CACHE_MANUFACTURERS', 'Tillverkarruta');
define('TEXT_CACHE_ALSO_PURCHASED', 'Köpte också-ruta');

define('TEXT_NONE', '--Ingen--');
define('TEXT_TOP', 'Topp');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fel: Målet finns inte.');
define('ERROR_DESTINATION_NOT_WRITEABLE',  'Fel: Målet är skrivskyddat.');
define('ERROR_FILE_NOT_SAVED',             'Fel: Filuppladdning sparades inte.');
define('ERROR_FILETYPE_NOT_ALLOWED',       'Fel: Typ av filuppladdning ej tillåten.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Lyckades: Filuppladdning sparades.');
define('WARNING_NO_FILE_UPLOADED',      'Varning: Ingen fil uppladdad.');
// http://www.linuxuk.co.uk - Notify when back in stock. Start
define('BOX_REPORTS_STOCK_ALERT', 'Lager notifiering');
define('BOX_CUSTOMERS_NOTIFTY','Lager notifiering');
// http://www.linuxuk.co.uk - Notify when back in stock. End
// BOF Order Maker
define('IMAGE_CREATE_ORDER', 'Create');
define('BOX_CUSTOMERS_CREATE_ORDER', 'Create Order');
// EOF Order Maker
// BOF Create Account 
define('BOX_CUSTOMERS_CREATE_ACCOUNT', 'Create Customer');
// EOF Create Account

define('BOX_HEADING_AAS', 'Alternativ Admin');
?>
