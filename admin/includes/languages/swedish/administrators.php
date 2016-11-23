<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Administrators');

define('TABLE_HEADING_ADMINISTRATORS', 'Administrators');
define('TABLE_HEADING_HTPASSWD', 'Säkrad med htpasswd');
define('TABLE_HEADING_ACTION', 'Åtgärd');

define('TEXT_INFO_INSERT_INTRO', 'Ange den nya administratören med tillhörande data');
define('TEXT_INFO_EDIT_INTRO', 'Gör alla nödvändiga ändringar');
define('TEXT_INFO_DELETE_INTRO', 'Är du säker på att du vill ta bort denna administratör?');
define('TEXT_INFO_HEADING_NEW_ADMINISTRATOR', 'Ny administratör');
define('TEXT_INFO_USERNAME', 'Användarnamn:');
define('TEXT_INFO_NEW_PASSWORD', 'Nytt lösenord:');
define('TEXT_INFO_PASSWORD', 'Lösenord:');
define('TEXT_INFO_PROTECT_WITH_HTPASSWD', 'Skydda med htaccess/htpasswd');

define('ERROR_ADMINISTRATOR_EXISTS', 'Fel: Administratör finns redan.');

define('HTPASSWD_INFO', '<strong>Additional Protection With htaccess/htpasswd</strong><p>This osCommerce Online Merchant Administration Tool installation is not additionally secured through htaccess/htpasswd means.</p><p>Enabling the htaccess/htpasswd security layer will automatically store administrator username and passwords in a htpasswd file when updating administrator password records.</p><p><strong>Please note</strong>, if this additional security layer is enabled and you can no longer access the Administration Tool, please make the following changes and consult your hosting provider to enable htaccess/htpasswd protection:</p><p><u><strong>1. Edit this file:</strong></u><br /><br />' . DIR_FS_ADMIN . '.htaccess</p><p>Remove the following lines if they exist:</p><p><i>%s</i></p><p><u><strong>2. Delete this file:</strong></u><br /><br />' . DIR_FS_ADMIN . '.htpasswd_oscommerce</p>');
define('HTPASSWD_SECURED', '<strong>Additional Protection With htaccess/htpasswd</strong><p>This osCommerce Online Merchant Administration Tool installation is additionally secured through htaccess/htpasswd means.</p>');
define('HTPASSWD_PERMISSIONS', '<strong>Additional Protection With htaccess/htpasswd</strong><p>This osCommerce Online Merchant Administration Tool installation is not additionally secured through htaccess/htpasswd means.</p><p>The following files need to be writable by the web server to enable the htaccess/htpasswd security layer:</p><ul><li>' . DIR_FS_ADMIN . '.htaccess</li><li>' . DIR_FS_ADMIN . '.htpasswd_oscommerce</li></ul><p>Reload this page to confirm if the correct file permissions have been set.</p>');
?>