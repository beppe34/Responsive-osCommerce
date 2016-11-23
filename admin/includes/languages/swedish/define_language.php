<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Definiera språk');

define('TABLE_HEADING_FILES', 'Filer');
define('TABLE_HEADING_WRITABLE', 'Skrivbar');
define('TABLE_HEADING_LAST_MODIFIED', 'Senast ändrad');

define('TEXT_EDIT_NOTE', '<strong>Redigerar Definitioner</strong><br /><br />Each language definition is set using the PHP <a href="http://www.php.net/define" target="_blank">define()</a> function in the following manner:<br /><br /><nobr>define(\'TEXT_MAIN\', \'<span style="background-color: #FFFF99;">This text can be edited. It\\\'s really easy to do!</span>\');</nobr><br /><br />The highlighted text can be edited. As this definition is using single quotes to contain the text, any single quotes within the text definition must be escaped with a backslash (eg, It\\\'s).');

define('TEXT_FILE_DOES_NOT_EXIST', 'Fil finns inte.');

define('ERROR_FILE_NOT_WRITEABLE', 'Fel: Kan inte skriva till denna fil. Vänligen ändra rättigheterna på: %s');
?>
