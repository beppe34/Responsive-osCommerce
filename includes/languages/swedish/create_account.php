<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Skapa ett konto');

define('HEADING_TITLE', 'Kontoinformation');

define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>OBS:</b></font></small> Om du redan har ett konto hos oss, vänligen logga in på <a href="%s"><u>den här sidan</u></a>.');

define('EMAIL_SUBJECT', 'Välkommen till ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Hej Herr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Hej Fru. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Hej %s' . "\n\n");
define('EMAIL_WELCOME', 'Vi välkommnar dig till <strong>' . STORE_NAME . '</strong>.' . "\n\n");
define('EMAIL_TEXT', 'Du kan nu ta del av <strong>olika tjänster</strong> som vi har att erbjuda. Några av dom tjänsterna är:' . "\n\n" . '<li><b>Permanent varukorg</b> - Alla varor som läggs i varukorgen kommer att finnas kvar online tills du tar bort dom, eller går till kassan med dom.' . "\n" . '<li><b>Adressbok</b> - Vi kan även skicka dina varor till en annan adress än din egen, det är perfekt ifall du vill skicka en födelsedagspresent direkt till den som fyller år.' . "\n" . '<li><b>Orderhistorik</b> - Se din orderhistorik på alla varor du har köpt hos oss.' . "\n" . '<li><b>Produktrecensioner</b> - Dela med dig av vad du tycker om produkterna med till andra kunder.' . "\n\n");
define('EMAIL_CONTACT', 'För att få hjälp med någon av våra tjänster så kan du e-posta butiksägaren: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<strong>OBS:</strong> Den här e-postadressen har registrerats av en av våra kunder. Om det inte är du som har registrerat dig som kund hos oss så kan du e-posta ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
/* CCGV ADDED - BEGIN */
define('EMAIL_GV_INCENTIVE_HEADER', "\n\n" .'As part of our welcome to new customers, we have sent you an e-Gift Voucher worth %s');
define('EMAIL_GV_REDEEM', 'The redeem code for the e-Gift Voucher is %s, you can enter the redeem code when checking out while making a purchase');
define('EMAIL_GV_LINK', 'or by following this link ');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations, to make your first visit to our online shop a more rewarding experience we are sending you an e-Discount Coupon.' . "\n" .
                                        ' Below are details of the Discount Coupon created just for you' . "\n");
define('EMAIL_COUPON_REDEEM', 'To use the coupon enter the redeem code which is %s during checkout while making a purchase');

/* CCGV ADDED - END */
?>
