<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Förskottsbetalning');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Ett E-mejl skickas till din registrerade E-mejl adress med betalningsinformation:&nbsp;<br><br>OBSERVERA!! Glöm inte att märka betalningen med ditt KUND_ORDERNUMMER som framgår av mejlet.<br><br>Beställningen skickas så fort vi erhållit full betalning.');
//  Totaldesign AB' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br /><br />Send To:<br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Your order will not ship until we receive payment.
//  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Make Payable To: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nSend To:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until we receive payment.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', '\nGör en insättning till: Totaldesign AB\n\n'. MODULE_PAYMENT_MONEYORDER_PAYTO . '\n eller Bankkonto:  clearingnummer:8420-2 kontonummer: 943 870 901-7 i Swedbank \n OBSERVERA!!  Märk betalningen med Kund_Order nr: ' . ORDERNUMMER . '. <STRONG>\n\nBeställningen skickas så fort vi erhållit full betalning.</STRONG>');

  ?>
