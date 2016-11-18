<?php
/*
  $Id$

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

  class cm_pwa_login {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_PWA_LOGIN_TITLE;
      $this->description = MODULE_CONTENT_PWA_LOGIN_DESCRIPTION;

      if ( defined('MODULE_CONTENT_PWA_LOGIN_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_PWA_LOGIN_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_PWA_LOGIN_STATUS == 'True');
      }
      
      if (!defined('MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS') || defined('MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS') && MODULE_HEADER_TAGS_DELETE_GUEST_ACCOUNT_STATUS != 'True' ) {
        $this->description = '<div class="secWarning">' . MODULE_CONTENT_PWA_LOGIN_HT_MODULE_WARNING . '</div>' . $this->description;
      }
      
    }

    function execute() {
      global $oscTemplate, $language;


      ob_start();
      include('includes/modules/content/' . $this->group . '/templates/pwa_login.php');
      $template = ob_get_clean();

      $oscTemplate->addContent($template, $this->group);
            
    }
    function isEnabled() {
      global $cart;
      $cart->content_type = $cart->get_content_type();
      if (!tep_session_is_registered('customer_id') && ($cart->count_contents() > 0) && (MODULE_CONTENT_PWA_LOGIN_STATUS == 'True') && (MODULE_CONTENT_PWA_LOGIN_VIRTUAL == 'True' || $cart->content_type == 'physical') ) {
    		return $this->enabled;
    	} else {
    		$this->enabled = false;
    	}
   }

    function check() {
      return defined('MODULE_CONTENT_PWA_LOGIN_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Login Form Module', 'MODULE_CONTENT_PWA_LOGIN_STATUS', 'True', 'Do you want to enable the login form module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Width', 'MODULE_CONTENT_PWA_LOGIN_CONTENT_WIDTH', 'Half', 'Should the content be shown in a full or half width container?', '6', '2', 'tep_cfg_select_option(array(\'Full\', \'Half\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Uninstall Remove Database columns', 'MODULE_CONTENT_PWA_LOGIN_REMOVE_DATA', 'False', 'Do you want to remove the pwa guest flag column when uninstall the module? (Guest orders will not be deleted, but will loose their guest order flags)', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_PWA_LOGIN_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '4', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, `set_function`) values ('Require Telephone Number', 'GUEST_CHECKOUT_TELEPHONE', 'True', 'Require Telephone Number?', 6, 5, '', now(),  'tep_cfg_select_option(array(\'True\', \'False\'),')");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, `set_function`) values ('Offer set password to guest', 'MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT', 'True', 'Do you wish to offer keep account and set password in checkout success page?', 6, 6, '', now(),  'tep_cfg_select_option(array(\'True\', \'False\'),')");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, `set_function`) values ('Allow guest checkout for virtual products', 'MODULE_CONTENT_PWA_LOGIN_VIRTUAL', 'False', 'Do you wish to allow guest checkout for orders containing virtual-downloadable products.<br>Also applies for mixed orders.', 6, 7, '', now(),  'tep_cfg_select_option(array(\'True\', \'False\'),')");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Exclude Payment Modules for Virtual Guest Orders', 'MODULE_CONTENT_PWA_LOGIN_PAYMENT_MODULES', '', 'The payment modules to exclude for guests and orders including virtual (downloadable) products.<br>Needs payment class to be modified, see Instructions Step 2.4.<br>Adding a new payment module, requires un-reinstall this module to update this list.', '6', '8', 'cm_pwa_login_show_payment_modules', 'cm_pwa_login_edit_payment_modules(', now())");

      include_once('includes/classes/language.php');
      $lng = new language;
      while (list($id, $value) = each($lng->catalog_languages)) {
      	$key = strtoupper($value['directory']);
        switch ($key) {
        	case 'ESPANOL':        
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pedido Invitado Nota e-mail " . $key . "', 'MODULE_CONTENT_PWA_EMAIL_WARNING_" . $key . "', 'NOTA: Esta dirección de correo electrónico ha sido enviado por un visitante de nuestra tienda online. Si no fuera este visitante, por favor, envíe un mensaje a: " . STORE_OWNER_EMAIL_ADDRESS . ". Gracias por su compra y tenga un buen día.', 'Definición de idioma usado en checkout_process.php', '6', '13', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pedido Invitado Nota pedidos virtuales " . $key . "', 'MODULE_CONTENT_PWA_DOWNLOAD_" . $key . "', 'Si tiene alguna dificultad para descargar el producto comprado, por favor, contáctenos en nuestra página de, <a class=\"btn btn-info\" role=\"button\" href=\"" . tep_catalog_href_link('contact_us.php') . "\">Contacto</a>.', 'Definición de idioma usado en \"Checkout Success\" y Correo de confirmación de pedido si incluye productos virtuales.', '6', '13', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Invitado " . $key . "', 'MODULE_CONTENT_PWA_GUEST_" . $key . "', 'Invitado', 'Definición de idioma usado en admin/orders.php', '6', '14', now())");
       		break;
        	case 'GERMAN':        
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Gastbestellung E-Mail Hinweis " . $key . "', 'MODULE_CONTENT_PWA_EMAIL_WARNING_" . $key . "', 'Achtung: Diese Email-Adresse wurde uns von einem Besucher unseres Online-Shops übermittelt. Falls Sie nicht dieser Besucher waren, senden Sie bitte eine Mitteilung an:  " . STORE_OWNER_EMAIL_ADDRESS . ".', 'Sprachdefinition für checkout_process.php', '6', '19', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Gastbestellung Hinweis bei virtuellen Produkten" . $key . "', 'MODULE_CONTENT_PWA_DOWNLOAD_" . $key . "', 'Wenn Sie Schwierigkeiten haben das gekaufte Produkt herunterzuladen, kontaktieren Sie uns bitte auf unserer <a class=\"btn btn-info\" role=\"button\" href=\"" . tep_catalog_href_link('contact_us.php') . "\">Kontakt</a> Seite', 'Sprachdefinition für \"Checkout Success\" und Bestätigungs Mail bei virtuellen Produkten.', '6', '19', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Gast " . $key . "', 'MODULE_CONTENT_PWA_GUEST_" . $key . "', 'Gast', 'Sprachdefinition für admin/orders.php', '6', '20', now())");
            break;
        	default:        
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Guest order e-mail warning " . $key . "', 'MODULE_CONTENT_PWA_EMAIL_WARNING_" . $key . "', 'NOTE: This email address has been submitted by a visitor to our online-shop. If you were not this visitor, please send a message to:  " . STORE_OWNER_EMAIL_ADDRESS . ". Thank you for your purchase and have a nice day.', 'Language definition used in checkout_process.php', '6', '25', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Guest order note for virtual products " . $key . "', 'MODULE_CONTENT_PWA_DOWNLOAD_" . $key . "', 'If you experience any difficulty to download the purchased product, please contact us on our <a class=\"btn btn-info\" role=\"button\" href=\"" . tep_catalog_href_link('contact_us.php') . "\">Contact Us</a> page', 'Language definition used in  \"Checkout Success\" and Order confirmation Mail if virtual products are included.', '6', '25', now())");
        		tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Guest " . $key . "', 'MODULE_CONTENT_PWA_GUEST_" . $key . "', 'Guest', 'Language definition used in admin/orders.php', '6', '26', now())");
        }
      }
      
      tep_db_query("alter table address_book add column `customers_guest` INT(1) NOT NULL DEFAULT '0' AFTER `customers_id`");
      if (tep_db_num_rows(tep_db_query("select * from information_schema.columns where table_schema='". DB_DATABASE . "' and table_name='orders' and column_name like 'customers_guest'")) != 1 ) {
        tep_db_query("alter table orders add column `customers_guest` INT(1) NOT NULL DEFAULT '0' AFTER `customers_address_format_id`");
      }
      tep_db_query("alter table customers add column `customers_guest` INT(1) NOT NULL DEFAULT '0' AFTER `customers_newsletter`");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
      tep_db_query("alter table address_book drop `customers_guest`");
      tep_db_query("alter table customers drop `customers_guest`");
      if ( defined('MODULE_CONTENT_PWA_LOGIN_REMOVE_DATA') && MODULE_CONTENT_PWA_LOGIN_REMOVE_DATA == 'True' ) {
        tep_db_query("alter table orders drop `customers_guest`");
      }
    }

    function keys() {
      include_once('includes/classes/language.php');
      $lng = new language;
      $KeysArray = array('MODULE_CONTENT_PWA_LOGIN_STATUS', 'MODULE_CONTENT_PWA_LOGIN_CONTENT_WIDTH', 'MODULE_CONTENT_PWA_LOGIN_REMOVE_DATA', 'MODULE_CONTENT_PWA_LOGIN_SORT_ORDER', 'GUEST_CHECKOUT_TELEPHONE', 'MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT', 'MODULE_CONTENT_PWA_LOGIN_VIRTUAL', 'MODULE_CONTENT_PWA_LOGIN_PAYMENT_MODULES');      
      while (list($id, $value) = each($lng->catalog_languages)) {
      	$key = strtoupper($value['directory']);
      	array_push($KeysArray, MODULE_CONTENT_PWA_EMAIL_WARNING_ . $key);
      	array_push($KeysArray, MODULE_CONTENT_PWA_DOWNLOAD_ . $key);
      	array_push($KeysArray, MODULE_CONTENT_PWA_GUEST_ . $key);
      }
      return $KeysArray;
    }
  }

  
// wholesaler_payment_modules Begin    
  function cm_pwa_login_show_payment_modules($text) {
    return nl2br(implode("\n", explode(';', $text)));
  }

  function cm_pwa_login_edit_payment_modules($values, $key) {
    global $PHP_SELF;

    $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
    $files_array = array();
	  if ($dir = @dir(DIR_FS_CATALOG . 'includes/modules/payment/')) {
	    while ($file = $dir->read()) {
	      if (!is_dir(DIR_FS_CATALOG . 'includes/modules/payment/' . $file)) {
	        if (substr($file, strrpos($file, '.')) == $file_extension) {
            $files_array[] = $file;
          }
        }
      }
      sort($files_array);
      $dir->close();
    }

    $values_array = explode(';', $values);
    $installed_values = explode(';', MODULE_PAYMENT_INSTALLED);

    $output = '';
    foreach ($files_array as $file) {
    	if ( in_array($file, $installed_values ) ) {
    		$output .= tep_draw_checkbox_field('cm_pwa_payment_module[]', $file, in_array($file, $values_array), null, True) . '&nbsp;' . tep_output_string($file) . '<br />';
    	}
    }

    if (!empty($output)) {
      $output = '<br />' . substr($output, 0, -6);
    }

    $output .= tep_draw_hidden_field('configuration[' . $key . ']', '', 'id="htrn_cm_pwa_payment_modules"');

    $output .= '<script>
                function htrn_cm_pwa_payment_update_cfg_value() {
                  var htrn_cm_pwa_payment_selected_modules = \'\';

                  if ($(\'input[name="cm_pwa_payment_module[]"]\').length > 0) {
                    $(\'input[name="cm_pwa_payment_module[]"]:checked\').each(function() {
                      htrn_cm_pwa_payment_selected_modules += $(this).attr(\'value\') + \';\';
                    });

                    if (htrn_cm_pwa_payment_selected_modules.length > 0) {
                      htrn_cm_pwa_payment_selected_modules = htrn_cm_pwa_payment_selected_modules.substring(0, htrn_cm_pwa_payment_selected_modules.length - 1);
                    }
                  }

                  $(\'#htrn_cm_pwa_payment_modules\').val(htrn_cm_pwa_payment_selected_modules);
                }

                $(function() {
                  htrn_cm_pwa_payment_update_cfg_value();

                  if ($(\'input[name="cm_pwa_payment_module[]"]\').length > 0) {
                    $(\'input[name="cm_pwa_payment_module[]"]\').change(function() {
                      htrn_cm_pwa_payment_update_cfg_value();
                    });
                  }
                });
                </script>';

    return $output;
  }
// wholesaler_payment_modules End
?>
