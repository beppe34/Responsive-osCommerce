<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Logga in');
define('NAVBAR_TITLE_2', 'Glömt lösenordet');

define('HEADING_TITLE', 'Jag har glömt lösenordet!');

define('TEXT_MAIN', 'Om du har glömt lösenordet så skriv in din e-postadress nedanför så skickar vi ett nytt lösenord till din e-postadress.');

define('TEXT_PASSWORD_RESET_INITIATED', 'Kontrollera din e-post för instruktioner om hur du byter lösenord. Instruktionerna innehåller en länk som är giltigt endast i 24 timmar eller tills ditt lösenord har uppdaterats.');

define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Error: Den e-postadress hittades inte i våra register, var god försök igen.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Nytt lösenord');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Ett nytt lösenord har begärts från ' . $REMOTE_ADDR . '.' . "\n\n" . 'Ditt nya lösenord till \'' . STORE_NAME . '\' är:' . "\n\n" . '   %s' . "\n\n");
define('EMAIL_PASSWORD_RESET_SUBJECT', STORE_NAME . ' - Nytt lösenord');
define('EMAIL_PASSWORD_RESET_BODY', 'Ett nytt lösenord har begärts från ' . STORE_NAME . '.' . "\n\n" . 'Följ nedstående länk för att ändra ditt lösenord:' . "\n\n" . '%s' . "\n\n" . 'Denna länk är giltig i 24 timmar.' . "\n\n" . 'Behöver du hjälp? Skicka dina frågor till: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('ERROR_ACTION_RECORDER', 'Error: En återställning av lösenord länk har redan skickats. Försök igen om % minuter.');
?>