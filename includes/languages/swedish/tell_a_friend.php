<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Tipsa en vän');

define('HEADING_TITLE', 'Tipsa en vän om \'%s\'');

define('FORM_TITLE_CUSTOMER_DETAILS', 'Dina uppgifter');
define('FORM_TITLE_FRIEND_DETAILS', 'Din väns uppgifter');
define('FORM_TITLE_FRIEND_MESSAGE', 'Ditt meddelande');

define('FORM_FIELD_CUSTOMER_NAME', 'Ditt namn:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Din e-postadress:');
define('FORM_FIELD_FRIEND_NAME', 'Din väns namn:');
define('FORM_FIELD_FRIEND_EMAIL', 'Din väns e-postadress:');

define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Ditt meddelande om <b>%s</b> har skickats till <b>%s</b>.');

define('TEXT_EMAIL_SUBJECT', 'Din vän %s vill tipsa dig om den här produkten från %s');
define('TEXT_EMAIL_INTRO', 'Hej %s!' . "\n\n" . 'Din vän, %s, tror att du kunde vara intresserad av %s från %s.');
define('TEXT_EMAIL_LINK', 'För att se produkten kan du klicka på länken under eller kopiera in länken i din webbläsare:' . "\n\n" . '%s');
define('TEXT_EMAIL_SIGNATURE', 'Hälsningar' . "\n\n" . '%s');

define('ERROR_TO_NAME', 'Felmeddelande: Du måste skriva din väns namn.');
define('ERROR_TO_ADDRESS', 'Felmeddelande: Din väns e-postadress måste vara en riktig e-postadress.');
define('ERROR_FROM_NAME', 'Felmeddelande: Du måste skriva ditt namn.');
define('ERROR_FROM_ADDRESS', 'Felmeddelande: Din e-postadress måste vara en riktig e-postadress.');
define('ERROR_ACTION_RECORDER', 'Fel: Ett mail har redan blivit skickad. Vänligen försök igen om %s minutes.');
?>
