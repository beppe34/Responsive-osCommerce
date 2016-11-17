<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2016 osCommerce

  Released under the GNU General Public License

  Discount Code 4.1 BS
*/

  require('includes/application_top.php');

  $discount = 0;
  if (MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    include('includes/classes/order.php');
    $order = new order;
	
    include('includes/languages/' . $language . '/modules/order_total/ot_discount.php');
    include('includes/modules/order_total/ot_discount.php');
    $ot_discount = new ot_discount;
    $ot_discount->process();
  }

  tep_session_close();

  echo $discount > 0 ? 1 : 0;
  exit();
?>
