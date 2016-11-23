<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Sessionerna katalogen finns inte: ' . tep_session_save_path() . '. Sessioner fungerar inte förrän den här katalogen skapas.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Jag kan inte skriva till sessions mappen: ' . tep_session_save_path() . '. Sessioner fungerar inte förrän till rätt användaråtkomst är inställda.');
?>
