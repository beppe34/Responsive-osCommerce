<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Databas Backuphantering');

define('TABLE_HEADING_TITLE', 'Titel');
define('TABLE_HEADING_FILE_DATE', 'Datum');
define('TABLE_HEADING_FILE_SIZE', 'Storlek');
define('TABLE_HEADING_ACTION', 'Åtgärd');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Ny backup');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Återställ lokal');
define('TEXT_INFO_NEW_BACKUP', 'Avbryt inte backup processen som kan ta några minuter.');
define('TEXT_INFO_UNPACK', '<br><br>(efter att filen packats upp ur arkivet)');
define('TEXT_INFO_RESTORE', 'Avbryt inte återställningsprocessen.<br><br>Ju större backupen är, desto längre tid tar återställningen!<br><br>Om möjligt, använd MySQL klienten.<br><br>T.ex:<br><br><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Avbryt inte återställningsprocessen.<br><br>Ju större backupen är, desto längre tid tar återställningen!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Den uppladdade filen måste vara en rå sql (text) fil.');
define('TEXT_INFO_DATE', 'Datum:');
define('TEXT_INFO_SIZE', 'Storlek:');
define('TEXT_INFO_COMPRESSION', 'Kompression:');
define('TEXT_INFO_USE_GZIP', 'Använd GZIP');
define('TEXT_INFO_USE_ZIP', 'Använd ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Ingen kompression (Ren SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Endast nerladdnind (spara inte på servern)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Bäst med en HTTPS anslutning');
define('TEXT_DELETE_INTRO', 'Är du säker på att du vill radera denna backup?');
define('TEXT_NO_EXTENSION', 'Ingen');
define('TEXT_BACKUP_DIRECTORY', 'Backup katalog');
define('TEXT_LAST_RESTORATION', 'Senaste återställning:');
define('TEXT_FORGET', '(<u>glöm</u>)');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Fel: Backup katalogen finns inte. Sätt detta i configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE',  'Fel: Backup katalogen är skrivskyddad.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE',    'Fel: Nerladdningslänken kan inte accepteras.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Lyckades: Det seanste återställningsdatumet har rensats.');
define('SUCCESS_DATABASE_SAVED',       'Lyckades: Databasen har sparats.');
define('SUCCESS_DATABASE_RESTORED',    'Lyckades: Databasen har återställts.');
define('SUCCESS_BACKUP_DELETED',       'Lyckades: Backupen har raderats.');
?>
