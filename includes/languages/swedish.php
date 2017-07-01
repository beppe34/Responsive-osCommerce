<?php
/*
  $Id: $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'sv_SE.ISO_8859-1');

define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', ''); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_FORMAT', 'mm/dd/yy'); // see http://docs.jquery.com/UI/Datepicker/formatDate

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

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'SEK');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="SV"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Skapa ett konto');
define('HEADER_TITLE_MY_ACCOUNT', 'Mitt konto&nbsp;');
define('HEADER_TITLE_CART_CONTENTS', 'Varukorgen');
define('HEADER_TITLE_CHECKOUT', 'Kassa&nbsp;&nbsp;&nbsp;');
define('HEADER_TITLE_TOP', '<i class="fa fa-home"><span class="sr-only">Hem</span></i>');
define('HEADER_TITLE_CATALOG', 'Katalog');
define('HEADER_TITLE_LOGOFF', 'Logga Ut');
define('HEADER_TITLE_LOGIN', 'Logga In');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'sidvisningar sedan');

// text for gender
define('MALE', 'Man');
define('FEMALE', 'Kvinna');
define('MALE_ADDRESS', 'Herr.');
define('FEMALE_ADDRESS', 'Fru.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'yyyy-mm-dd');

// categories box text in includes/boxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Kategorier');

// manufacturers box text in includes/boxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Tillverkare');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Nyheter');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Snabbsök');
define('BOX_SEARCH_TEXT', 'Använd nyckelord för att hitta den produkt du söker efter.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Avancerad sökning');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Erbjudande');

// reviews box text in includes/boxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Recensioner');
define('BOX_REVIEWS_WRITE_REVIEW', 'Skriv en recension om denna produkt!');
define('BOX_REVIEWS_NO_REVIEWS', 'Det finns för tillfället inga recensioner');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '% av 5 Stjärnor!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Varukorgen');
define('BOX_SHOPPING_CART_EMPTY', 'Din varukorg är tom');

// order_history box text in includes/boxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Beställningshistorik');

// best_sellers box text in includes/boxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Bästsäljare');
define('BOX_HEADING_BESTSELLERS_IN', 'Bästsäljare i<br>&nbsp;&nbsp;');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Underrättelse');
define('BOX_NOTIFICATIONS_NOTIFY', 'Underrätta mig om uppdateringar om <b>%</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Underrätta mig inte om uppdateringar <b>%s</b>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Tillverkarinfo');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Hemsida');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Andra produkter');

// languages box text in includes/boxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Språk');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Valutor');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_INFORMATION_PRIVACY', 'Köpinformation');
define('BOX_INFORMATION_CONDITIONS', 'Köpvilkor');
define('BOX_INFORMATION_SHIPPING', 'Frakt & Returer');
define('BOX_INFORMATION_CONTACT', 'Kontakta oss');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Tipsa en vän');
define('BOX_TELL_A_FRIEND_TEXT', 'Tipsa en vän om den här produkten.');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Leveransadress');
define('CHECKOUT_BAR_PAYMENT', 'Betalningssätt');
define('CHECKOUT_BAR_CONFIRMATION', 'Bekräftelse');
define('CHECKOUT_BAR_FINISHED', 'Klart!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Välj');
define('TYPE_BELOW', 'Skriv nedan');

//credit class, gift vouchers and coupon codes
define('VOUCHER_BALANCE', 'Presentkort Saldo');
define('BOX_HEADING_GIFT_VOUCHER', 'Present/rabatt kort Konto');
define('GV_FAQ', 'Presentkort FAQ');
define('IMAGE_REDEEM_VOUCHER', 'Rabattkupong');
define('ERROR_REDEEMED_AMOUNT', 'Grattis, du har fått rabatt ');
define('ERROR_NO_REDEEM_CODE', 'Du angav inte en rabattkod.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Ogiltig present/rabattkort kod');
define('TABLE_HEADING_CREDIT', 'Rabatt kupong');
define('GV_HAS_VOUCHERA', 'Du har pengar i ditt presentkorts-konto. Ifall du önskar <br>
                           kan du titta på ditt konto <a class="pageResults" href="');
define('GV_HAS_VOUCHERB', '"><b>email</b></a> till någon');
define('ENTRY_AMOUNT_CHECK_ERROR', 'Du har inte tillräckligt saldo för att skicka beloppet.');
define('BOX_SEND_TO_FRIEND', 'Skicka presentkort');
define('VOUCHER_REDEEMED', 'Rabatt/presenkort användt');
define('CART_COUPON', 'Kupong :');
define('CART_COUPON_INFO', 'mer info');
define('MODULE_BOXES_INFORMATION_GV','Present/Rabatt kort');

// javascript messages
define('JS_ERROR', 'Fel finns i formuläret!\n Var vänlig rätta följande:\n\n');

define('JS_REVIEW_TEXT', '* The \'Recensionen\' måste bestå av minst ' . REVIEW_TEXT_MIN_LENGTH . ' tecken.\n');
define('JS_REVIEW_RATING', '* Du måste betygssätta produkten som du recenserar.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Välj betalningssätt.\n');

define('JS_ERROR_SUBMITTED', 'Formuläret är redan skickat. Tryck på OK och vänta på att processen är klar.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Välj betalningssätt för din order.');

define('CATEGORY_COMPANY', 'Företagsuppgifter');
define('CATEGORY_PERSONAL', 'Personuppgifter');
define('CATEGORY_ADDRESS', 'Din adress');
define('CATEGORY_CONTACT', 'Dina kontaktinformationer');
define('CATEGORY_OPTIONS', 'Alternativ');
define('CATEGORY_PASSWORD', 'Ditt lösenord');

define('ENTRY_COMPANY', 'Företagets namn:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Kön:');
define('ENTRY_GENDER_ERROR', 'Välj kön.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Förnamn:');
define('ENTRY_FIRST_NAME_ERROR', 'Förnamnet måste bestå av minst ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' tecken.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Efternamn:');
define('ENTRY_LAST_NAME_ERROR', 'Efternamnet måste bestå av minst ' . ENTRY_LAST_NAME_MIN_LENGTH . ' tecken.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Personnummer:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Personnummret måste vara i formatet: MM/DD/YYYY (eg 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (eg. 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-postadress:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Din E-postadressen måste bestå av minst ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' tecken.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Din E-postadress verkar inte vara korrekt - kontrollera den igen.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'E-postadressen finns redan - logga in med den E-postadressen eller ange en annan E-postadress.');
define('ENTRY_EMAIL_ADDRESS_TEXT', 'E-mail adress');
define('ENTRY_STREET_ADDRESS', 'Gatuadress:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Gatuadressen måste bestå av minst ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' tecken.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Förort:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Postnummer:');
define('ENTRY_POST_CODE_ERROR', 'Postnummret måste bestå av minst ' . ENTRY_POSTCODE_MIN_LENGTH . ' tecken.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Postort:');
define('ENTRY_CITY_ERROR', 'Postorten måste bestå av minst ' . ENTRY_CITY_MIN_LENGTH . ' tecken.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Delstat:');
define('ENTRY_STATE_ERROR', 'Delstaten måste bestå av minst ' . ENTRY_STATE_MIN_LENGTH . ' tecken.');
define('ENTRY_STATE_ERROR_SELECT', 'Välj en delstat i dropdown menyn.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_COUNTRY_ERROR', 'Välj land i dropdown menyn.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Telefonnummret måste bestå av minst ' . ENTRY_TELEPHONE_MIN_LENGTH . ' tecken.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Faxnummer:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Nyhetsbrev/SMS:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Prenumerera');
define('ENTRY_NEWSLETTER_NO', 'Avsluta prenumeration');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Lösenord:');
define('ENTRY_PASSWORD_ERROR', 'Lösenordet måste bestå av minst ' . ENTRY_PASSWORD_MIN_LENGTH . ' tecken.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Lösenordsbekräftelsen måste stämma överens med ditt lösenord.');
define('ENTRY_PASSWORD_TEXT', 'Lösenord');
define('ENTRY_PASSWORD_CONFIRMATION', 'Bekräfta lösenordet:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Nuvarande lösenord:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Lösenordet måste bestå av minst ' . ENTRY_PASSWORD_MIN_LENGTH . ' tecken.');
define('ENTRY_PASSWORD_NEW', 'Nytt lösenord:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ditt nya lösenord måste bestå av minst ' . ENTRY_PASSWORD_MIN_LENGTH . ' tecken.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Bekräftelsen av lösenordet måste stämma överens med ditt lösenord.');
define('PASSWORD_HIDDEN', '--DOLT--');

define('FORM_REQUIRED_INFORMATION', '* Obligatoriska uppgifter');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Resultatsidor:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Visar <strong>%d</strong> till <strong>%d</strong> (av <strong>%d</strong> produkter)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Visar <strong>%d</strong> till <strong>%d</strong> (av <strong>%d</strong> ordrar)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Visar <strong>%d</strong> till <strong>%d</strong> (av <strong>%d</strong> recensioner)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Visar <strong>%d</strong> till <strong>%d</strong> (av <strong>%d</strong> nya varor)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Visar <strong>%d</strong> till <strong>%d</strong> (av <strong>%d</strong> specialerbjudanden)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Första sidan');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Förra sidan');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Nästa sida');
define('PREVNEXT_TITLE_LAST_PAGE', 'Sista sidan');
define('PREVNEXT_TITLE_PAGE_NO', 'Sida %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Föregående set av %d sidor');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Nästa set av %d sidor');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;Första');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;Föregående]');
define('PREVNEXT_BUTTON_NEXT', '[Nästa&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'Sista&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Add Address');
define('IMAGE_BUTTON_ADD_ADDRESS', 'Lägg till adress');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Adressbok');
define('IMAGE_BUTTON_BACK', 'Tillbaka');
define('IMAGE_BUTTON_BUY_NOW', 'Köp nu');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Ändra adress');
define('IMAGE_BUTTON_CHECKOUT', 'Kassa');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Bekräfta order');
define('IMAGE_BUTTON_CONTINUE', 'Fortsätt');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Fortsätt handla');
define('IMAGE_BUTTON_DELETE', 'Ta bort');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Redigera kontot');
define('IMAGE_BUTTON_HISTORY', 'Order historik');
define('IMAGE_BUTTON_LOGIN', 'Logga in');
define('IMAGE_BUTTON_IN_CART', 'Lägg till varukorgen');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notifieringar');
define('IMAGE_BUTTON_QUICK_FIND', 'Snabbsök');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Ta bort notifieringar');
define('IMAGE_BUTTON_REVIEWS', 'Recensioner');
define('IMAGE_BUTTON_SEARCH', 'Sök');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Fraktsätt');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Tipsa en vän');
define('IMAGE_BUTTON_UPDATE', 'Uppdatera');
define('IMAGE_BUTTON_REMOVE', 'Radera');
define('IMAGE_BUTTON_UPDATE_CART', 'Uppdatera varukorg');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Lämna Betyg');

define('SMALL_IMAGE_BUTTON_DELETE', 'Ta bort');
define('SMALL_IMAGE_BUTTON_EDIT', 'Redigera');
define('SMALL_IMAGE_BUTTON_VIEW', 'Visa');
define('SMALL_IMAGE_BUTTON_BUY', 'Köp');

define('ICON_ARROW_RIGHT', 'mer');
define('ICON_CART', 'I varukorgen');
define('ICON_ERROR', 'Fel');
define('ICON_SUCCESS', 'Lyckats');
define('ICON_WARNING', 'Varning');

define('TEXT_GREETING_PERSONAL', 'Välkommen tillbaka <span class="greetUser">%s!</span> Vill du se vilka <a href="%s"><u>nya produkter</u></a> som finns att köpa?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Om du inte är %s, please <a href="%s"><u>logga in</u></a> med dina kontouppgifter.</small>');
define('TEXT_GREETING_GUEST', 'Välkommen <span class="greetUser">Gäst!</span> Vill du <a href="%s"><u>logga in</u></a>? Eller vill du <a href="%s"><u>skapa ett nytt konto</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Sortera produkter ');
define('TEXT_DESCENDINGLY', 'nedåtstigande');
define('TEXT_ASCENDINGLY', 'uppåtstigande');
define('TEXT_BY', ' av ');

define('TEXT_REVIEW_BY', 'av %s');
define('TEXT_REVIEW_WORD_COUNT', '%s ord');
define('TEXT_REVIEW_RATING', 'Betyg: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Skrivet datum: %s');
define('TEXT_NO_REVIEWS', 'Det finns för tillfället inga recensioner.');

define('TEXT_NO_NEW_PRODUCTS', 'Det finns för tillfället inga produkter.');

define('TEXT_UNKNOWN_TAX_RATE', 'Okänd moms');

define('TEXT_REQUIRED', '<span class="errorText">Obligatoriskt/span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> Cannot send the email through the specified SMTP server. Please check your php.ini setting and correct the SMTP server if necessary.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/install. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php. This is a potential security risk - please set the right user permissions on this file.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . tep_session_save_path() . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . tep_session_save_path() . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this php feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Utgångsdatumet på ditt kreditkort har passerats.<br>Kontrollera datumet och försök igen.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Kreditkortsnummret du skrev in är ogiltigt.<br>Kontrollera nummret och försök igen.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Dom 4 första siffrorna i nummret är: %s<br>Om det nummret är korrekt så accepterar vi inte den typen av kreditkort.<br>Om det är fel så försök igen.');

define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . tep_href_link('index.php') . '">' . STORE_NAME . '</a><br>Powered by <a href="http://www.oscommerce.com" target="_blank">osCommerce</a>');

//BEGIN : IOSC Switch view labels
define('TEXT_SHOW_VIEW_1', '');
define('TEXT_SHOW_VIEW_2', ' View');
define('TEXT_CLASSIC_VIEW', 'CLASSIC');
define('TEXT_MOBILE_VIEW', '<b>MOBILE</b>');
//END : IOSC Switch view labels
// http://www.linuxuk.co.uk - Notify when back in stock. Start
define('NOTIFY_MESSAGE', 'Du får ett bekräftelsemejl för denna notifiering.');
define('MESSAGE_ALREADY_NOTIFIED', 'När ');
define('ALREADY_NOTIFIED', 'Notifiering mottagen.');
define('ALREADY_NOTIFIED_MESSAGE', 'Du kommer att få ett meddelande när varan finns i lager, du kommer få ett mejl snart.');
define('CLICK_TO_CLOSE', 'Stäng [X]');
define('NOTIFY_EMAIL','Din email adress: ');
define('NOTIFY_NAME', 'Ditt namn: ');
define('MESSAGE_1', 'Meddela mig när ');
define('MESSAGE_2', ' finns åter i lager.');
define('NOTIFY_EMAIL_SUBJECT', 'En kund vill bli meddelad när produkten finns i lager.');
define('NOTIFY_EMAIL_WELCOME', 'Produkten åter i lager!');
define('NOTIFY_EMAIL_NAME', 'Kund namn: ');
define('NOTIFY_EMAIL_EMAIL','Kund E Mail Address: ');
define('NOTIFY_EMAIL_PNAME', 'Produktnamn: ') ;
define('NOTIFY_REQUESTED', 'Produkt länk: ');
define('NOTIFY_EMAIL_SUBJECT2', 'Bekräftelse av varulager notifiering.');
define('CUSTOMER_NOTIFIED', 'Tack för ditt intresse.');
define('CUSTOMER_NOTIFIED1', 'Vi meddelar dig med ett mejl när produkten åter kommer i lager. Läs detaljer nedan;');
define('CUSTOMER_NOTIFIED2', 'Produkt namn: ');
define('CUSTOMER_NOTIFIED3', 'Kontakta oss närsomhelst, vår mejladress är: ');
define('CUSTOMER_NOTIFIED4', 'Tack! Ha en fin dag!');
define('NOTIFY_REQUESTED_IMAGE' , 'Produkt bild: ');
define('NOTIFY_HTML_OFF', 'HTML email is not enabled, please set to true to use this linked feature');
define('SN_STOCK_MESSAGE', 'Tack, din önskan om varulager notifiering har tagits emot - du får ett meddelande när varan åter finns i lager.');
define('SN_EMAIL_NOTIFICATIONS', 'Visa / Radera mina varulager notifieringar.');
define('SN_LOGIN_HEAD', 'Kund?');
define('SN_LOGIN', 'Genom att logga in så kan du hantera dina notifieringar och använda andra funktioner, eller så kan du skapa ett konto.');
define('SN_GUEST_NAME', 'Gäst');
define('SN_THANK_YOU', 'Tack, när ');
define('SN_BACK_IN_STOCK', ' åter finns i lager så meddelar vi dig med ett mejl.');
// http://www.linuxuk.co.uk - Notify when back in stock. End
// category views
define('TEXT_VIEW', 'Visa: ');
define('TEXT_VIEW_LIST', ' Lista');
define('TEXT_VIEW_GRID', ' Tabell');

// search placeholder
define('TEXT_SEARCH_PLACEHOLDER','Sök');

// message for required inputs
define('FORM_REQUIRED_INFORMATION', '<span class="fa fa-asterisk text-danger"></span> Obligatorisk information');
define('FORM_REQUIRED_INPUT', '<span><span class="fa fa-asterisk form-control-feedback text-danger"></span></span>');

// reviews
define('REVIEWS_TEXT_RATED', 'Rated %s by <cite title="%s" itemprop="author">%s</cite>');
define('REVIEWS_TEXT_AVERAGE', 'Average rating based on <span itemprop="ratingCount">%s</span> review(s) %s');
define('REVIEWS_TEXT_TITLE', 'Vad våra kunder säger...');

// grid/list
define('TEXT_SORT_BY', 'Sortera ');
// moved from index
define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Produkt');
define('TABLE_HEADING_MANUFACTURER', 'Tillverkare');
define('TABLE_HEADING_QUANTITY', 'Antal');
define('TABLE_HEADING_PRICE', 'Pris');
define('TABLE_HEADING_WEIGHT', 'Vikt');
define('TABLE_HEADING_BUY_NOW', 'Köp nu');
define('TABLE_HEADING_LATEST_ADDED', 'Senaste produkt');

// product notifications
define('PRODUCT_SUBSCRIBED', '%s has been added to your Notification List');
define('PRODUCT_UNSUBSCRIBED', '%s has been removed from your Notification List');
define('PRODUCT_ADDED', '%s har lagts i din varukorg');
define('PRODUCT_REMOVED', '%s har tagits bort från din varukorg');

// bootstrap helper
define('MODULE_CONTENT_BOOTSTRAP_ROW_DESCRIPTION', '');
