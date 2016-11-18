<?php
/*
  $Id$

  Purchase without Account for Bootstrap
  Version 2.0 BS 
  by @raiwa 
  info@oscaddons.com
  www.oscaddons.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  class ht_pwa_delete_guest_account {
    var $code = 'ht_pwa_delete_guest_account';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->title = MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_TITLE;
      $this->description = MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $PHP_SELF, $sessiontoken, $navigation, $customer_id, $messageStack;
      
      // check if guest account (e-mail) exists and remove if a new guest account is created
      if ( basename($PHP_SELF) == 'create_account.php' && isset($_POST['action']) && ($_POST['action'] == 'process') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken ) )  {
        if (tep_db_num_rows(tep_db_query("select * from information_schema.columns where table_schema='". DB_DATABASE . "' and table_name='orders' and column_name like 'customers_guest'")) == 1 ) {
          $email_address = tep_db_prepare_input($_POST['email_address']);
          $check_guest_query = tep_db_query("select customers_id from customers where customers_email_address = '". tep_db_input($email_address) . "' and customers_guest = '1'");
          $check_guest = tep_db_fetch_array($check_guest_query);
          if ( tep_not_null($check_guest) ) {
            tep_db_query("delete from customers where customers_id = '". $check_guest['customers_id'] . "' and customers_guest = '1'");
            tep_db_query("delete from address_book where customers_id = '". $check_guest['customers_id'] . "' and customers_guest = '1'");
// reload the page after deleting previous guest account for a new e-mail exist check
?>
<script>
location.reload();
</script>
<?php
          }
        }
      }
      
      // do things if a guest comes from checkout success
 	    if ( tep_session_is_registered('customer_is_guest') && isset($navigation->snapshot) && $navigation->snapshot['page'] == 'checkout_success.php' ) {
        if ( defined('MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT') && MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT == 'True' && 
             basename($PHP_SELF) == 'account.php' && strpos($messageStack->output('account'), 'alert-success') ) { 
          // Unregister and remove guest from customers table if password is successful set
          tep_session_unregister('customer_is_guest');
          tep_db_query("update customers set customers_guest = '0' where customers_id = '" . (int)$customer_id . "'");
        } elseif ( basename($PHP_SELF) != 'download.php' && basename($PHP_SELF) != 'set_password.php' && substr(basename($PHP_SELF), 0, 8) != 'checkout' ) {
          // else delete guest account
 	        tep_db_query("delete from customers where customers_id = '" . (int)$customer_id . "' and customers_guest = '1'");
          tep_db_query("delete from address_book where customers_id = '" . (int)$customer_id . "'");
          tep_db_query("delete from customers_info where customers_info_id = '" . (int)$customer_id . "'");
  
          tep_session_unregister('customer_default_address_id');
          tep_session_unregister('customer_first_name');
          tep_session_unregister('customer_country_id');
          tep_session_unregister('customer_zone_id');
          tep_session_unregister('customer_id');
          tep_session_unregister('customer_is_guest');
        }
 
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable delete PWA Guest Account Module?', 'MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS', 'True', 'In Create account, check if a guest account with the same e-mail exists and remove it.', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS',
                   'MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_SORT_ORDER'
                  );
    }
  }
?>