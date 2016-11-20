<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_CONTENT_PAYPAL_LOGIN_TITLE', 'Logga in med PayPal');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DESCRIPTION', 'Aktivera Logga in med PayPal med sömlös kassan för PayPal Express Checkout betalningar<br /><br /><img src="images/icon_info.gif" border="0" />&nbsp;<a href="http://library.oscommerce.com/Package&en&paypal&oscom23&log_in" target="_blank" style="text-decoration: underline; font-weight: bold;">Visa online Dokumentation</a><br /><br /><img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.paypal.com" target="_blank" style="text-decoration: underline; font-weight: bold;">Besök PayPal Webbplats</a>');

  define('MODULE_CONTENT_PAYPAL_LOGIN_TEMPLATE_TITLE', 'Logga in med PayPal');
  define('MODULE_CONTENT_PAYPAL_LOGIN_TEMPLATE_CONTENT', 'Har ett PayPal-konto? Säker inloggning med PayPal för att handla ännu snabbare!');
  define('MODULE_CONTENT_PAYPAL_LOGIN_TEMPLATE_SANDBOX', 'Testläge: Sandbox-servern är vald.');

  define('MODULE_CONTENT_PAYPAL_LOGIN_ERROR_ADMIN_CURL', 'Denna modul kräver cURL är aktiverat i PHP och kommer inte att läsa förrän det har aktiverats på denna webbserver.');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ERROR_ADMIN_CONFIGURATION', 'Denna modul kommer inte att läsa förrän klient-ID och Hemliga parametrar har konfigurerats. Redigera och konfigurera inställningarna för den här modulen.');

  define('MODULE_CONTENT_PAYPAL_LOGIN_LANGUAGE_LOCALE', 'sv-se');

  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_GROUP_personal', 'Personlig information');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_GROUP_address', 'Adressinformation');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_GROUP_account', 'Kontoinformation');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_GROUP_checkout', 'Snabb Kassa');

  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_full_name', 'Fullständigt namn');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_date_of_birth', 'Födelsedatum');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_age_range', 'Åldersrekommendation');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_gender', 'Kön');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_email_address', 'E-postadress');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_street_address', 'Gatuadress');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_city', 'Stad');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_state', 'Delstat');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_country', 'Land');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_zip_code', 'Postnummer');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_phone', 'Telefonnummer');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_account_status', 'Kontostatus (verifierad)');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_account_type', 'Kontotyp');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_account_creation_date', 'Datum då kontot har skapats');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_time_zone', 'Tidszon');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_locale', 'Locale');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_language', 'Språk');
  define('MODULE_CONTENT_PAYPAL_LOGIN_ATTR_seamless_checkout', 'Seamless Checkout');

  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_LINK_TITLE', 'Test API serveranslutning');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_TITLE', 'API Serveranslutningstest');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_GENERAL_TEXT', 'Testa anslutningen till servern ..');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_BUTTON_CLOSE', 'Stäng');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_TIME', 'Anslutning Tid:');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_SUCCESS', 'Framgång!');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_FAILED', 'Misslyckades! Läs igenom Verifiera SSL-certifikat inställningar och försök igen.');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_CONNECTION_ERROR', 'Ett fel inträffade. Uppdatera sidan, granska inställningarna och försök igen.');

  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_LINK_TITLE', 'Visa PayPal Applikationsadresser');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_TITLE', 'PayPal Applikationsadresser');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_RETURN_TEXT', 'Omdirigera / Retur URL:');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_PRIVACY_TEXT', 'Vår Integritetspolicy URL:');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_TERMS_TEXT', 'Användaravtalet URL:');
  define('MODULE_CONTENT_PAYPAL_LOGIN_DIALOG_URLS_BUTTON_CLOSE', 'Stäng');
?>
