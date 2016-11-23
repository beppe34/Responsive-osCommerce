<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Orderstatus');

define('TABLE_HEADING_ORDERS_STATUS', 'Orderstatus');
define('TABLE_HEADING_PUBLIC_STATUS', 'Allmän Status');
define('TABLE_HEADING_DOWNLOADS_STATUS', 'Nerladdnings Status');
define('TABLE_HEADING_ACTION', 'Åtgärd');

define('TEXT_INFO_EDIT_INTRO', 'Vänligen gör den nödvändiga ändringarna');
define('TEXT_INFO_ORDERS_STATUS_NAME', 'Orderstatus:');
define('TEXT_INFO_INSERT_INTRO', 'Ange den nya orderstatusen med tillhörande data');
define('TEXT_INFO_DELETE_INTRO', 'Är du säker på att du vill ta bort denna orderstatus?');
define('TEXT_INFO_HEADING_NEW_ORDERS_STATUS', 'Ny orderstatus');
define('TEXT_INFO_HEADING_EDIT_ORDERS_STATUS', 'Redigera orderstatus');
define('TEXT_INFO_HEADING_DELETE_ORDERS_STATUS', 'Radera orderstatus');

define('TEXT_SET_PUBLIC_STATUS', 'Visa ordern till kunden på denna orderstatus nivå');
define('TEXT_SET_DOWNLOADS_STATUS', 'Tillåt nedladdning av virtuella produkter på denna orderstatus nivå');

define('ERROR_REMOVE_DEFAULT_ORDER_STATUS', 'Fel: Standard orderstatus kan inte tas bort. Välj en annan orderstatus som standard, och prova igen.');
define('ERROR_STATUS_USED_IN_ORDERS',       'Fel: Denna orderststus används för närvarande i orders.');
define('ERROR_STATUS_USED_IN_HISTORY',      'Fel: Denna orderststus används för närvarande i orderstatus historiken.');
?>