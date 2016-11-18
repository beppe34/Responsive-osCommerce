<?php
/*
  $Id$

  Modified for:
  Purchase without Account for Bootstrap
  Version 2.3 BS 
  by @raiwa 
  info@oscaddons.com
  www.oscaddons.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  class cm_cs_pwa_products_purchased {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_TITLE;
      $this->description = MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_DESCRIPTION;

      if ( defined('MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $customer_id, $order_id, $navigation;
      
      if (tep_session_is_registered('customer_is_guest')){
        $navigation->set_snapshot();
        // flag guest order
        tep_db_query("update orders set customers_guest = '1' where customers_id = '" . (int)$customer_id . "'");
        if ( isset($_GET['action']) && ($_GET['action'] == 'update') ) {
          // redirect to set password if selected
          if ( defined('MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT') && MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT == 'True' && isset($_POST['pwa_account']) && ($_POST['pwa_account'] == 'true') ) {
            tep_redirect(tep_href_link('/ext/modules/content/account/set_password.php', '', 'SSL'));
          } else {
            // delete guest account if selected
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
        } elseif ( (!defined('MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT') || MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT != 'True') && DOWNLOAD_ENABLED != 'true' ) {
            // delete guest account if selected
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
        
        // get product info to display
        $products_query = tep_db_query("select products_id, products_name from orders_products where orders_id = '" . (int)$order_id . "' order by products_name");
        while ($products = tep_db_fetch_array($products_query)) {
          if ( !isset($products_displayed[$products['products_id']]) ) {
            $products_displayed[$products['products_id']] = '<div><label> ' . $products['products_name'] . '</label></div>';
          }
        }

        $products_guest .= implode('', $products_displayed);
        
        // offer to keep account and set password       
        if ( defined('MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT') && MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT == 'True' ) {
        $products_guest_radio = '<div class="form-group has-feedback">
                                   <div class="col-sm-12">
                                     <label class="radio-inline">'
                                     .  tep_draw_radio_field('pwa_account', 'true', NULL, 'required aria-required="true"') . ' ' . MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_TEXT_SET_PASSWORD . 
                                '    </label>
                                   </div>
                                   <div class="col-sm-12">
                                     <label class="radio-inline">' . 
                                      tep_draw_radio_field('pwa_account', 'false') . ' ' . MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_TEXT_DELETE_ACCOUNT . 
                                '    </label> 
                                   </div>
                                 </div>';
        } else {
          $products_guest_radio = '';
        }
        

        ob_start();
        include('includes/modules/content/' . $this->group . '/templates/pwa_products_purchased.php');
        $template = ob_get_clean();

        $oscTemplate->addContent($template, $this->group);
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable PWA Checkout Module', 'MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_STATUS', 'True', 'Must enable if PWA Login module is active to integrate within checkout success page.', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.  Due to disabling product notifications, this module requires being installed above said module.', '6', '3', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_STATUS','MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_SORT_ORDER');
    }
  }
?>