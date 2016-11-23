<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Bannerhantering');

define('TABLE_HEADING_BANNERS', 'Banners');
define('TABLE_HEADING_GROUPS', 'Grupper');
define('TABLE_HEADING_STATISTICS', 'Visningar / Klick');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Åtgärd');

define('TEXT_BANNERS_TITLE', 'Bannertitel:');
define('TEXT_BANNERS_URL', 'Banner URL:');
define('TEXT_BANNERS_GROUP', 'Banner grupp:');
define('TEXT_BANNERS_NEW_GROUP', ', eller ange en ny bannergrupp nedan');
define('TEXT_BANNERS_IMAGE', 'Bild:');
define('TEXT_BANNERS_IMAGE_LOCAL', ', eller ange en lokal fil nedan');
define('TEXT_BANNERS_IMAGE_TARGET', 'Bild mål (Spara till):');
define('TEXT_BANNERS_HTML_TEXT', 'HTML text:');
define('TEXT_BANNERS_EXPIRES_ON', 'Utgår datum:');
define('TEXT_BANNERS_OR_AT', ', eller till');
define('TEXT_BANNERS_IMPRESSIONS', 'intryck/visningar.');
define('TEXT_BANNERS_SCHEDULED_AT', 'Schemalagd till:');
define('TEXT_BANNERS_BANNER_NOTE', '<b>Bannernetingar:</b><ul><li>Använd en bild eller en HTML text för bannern - inte båda.</li><li>HTML text har prioritet över en bild</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>Bildnoteringar:</b><ul><li>Uppladdningskatalogen(erna) måste ha korrekta användar- (skriv) rättigheter satta!</li><li>Fyll inte i \'Spara till\' fältet om du inte laddar upp bilden till webbservern (t.ex. om du använder en lokal (på servern) bild).</li><li>\'Spara till\' fältet måste vara en befintlig katalog med ett avslutande snedstreck (t.ex. banners/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>Utgångsnoteringar:</b><ul><li>Endast ett av de två fälten skall fyllas i</li><li>Om inte bannern skall utgå automatiskt, lämna då dessa fält tomma</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>Schemeläggning noteringar:</b><ul><li>Om ett schema är satt kommer bannern att bli aktiverad på det datumet.</li><li>Alla schemalagda banners är märkta som inaktiva tills deras datum är inne, då kommer de att markeras som aktiva.</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', 'Tillagd datum:');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'Schemalagd till: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'Utgår datum: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'Utgår vid: <b>%s</b> intryck');
define('TEXT_BANNERS_STATUS_CHANGE', 'Statusändring: %s');

define('TEXT_BANNERS_DATA', 'D<br>A<br>T<br>A');
define('TEXT_BANNERS_LAST_3_DAYS', 'Senaste 3 dagarna');
define('TEXT_BANNERS_BANNER_VIEWS', 'Bannervisningar');
define('TEXT_BANNERS_BANNER_CLICKS', 'Bannerklick');

define('TEXT_INFO_DELETE_INTRO', 'Är du säker på att du vill radera denna banner?');
define('TEXT_INFO_DELETE_IMAGE', 'Radera bannerbild');

define('SUCCESS_BANNER_INSERTED', 'Lyckades: Bannern infogad.');
define('SUCCESS_BANNER_UPDATED',  'Lyckades: Bannern uppdaterad.');
define('SUCCESS_BANNER_REMOVED',  'Lyckades: Bannern raderad.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Lyckades: Bannerns status har uppdaterats.');

define('ERROR_BANNER_TITLE_REQUIRED', 'Fel: Bannertitel krävs.');
define('ERROR_BANNER_GROUP_REQUIRED', 'Fel: Bannergrupp krävs.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Fel: Målkatalogen finns inte: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE',  'Fel: Målkatalogen är skrivskyddad: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST',   'Fel: Bilden finns inte.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'Fel: Bilden kan inte raderas.');
define('ERROR_UNKNOWN_STATUS_FLAG',    'Fel: Okänd statusflagga.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Fel: Graf-katalogen finns inte. Skapa en \'graphs\' katalog under \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE',  'Fel: Graf-katalogen är skrivskyddad.');

?>

