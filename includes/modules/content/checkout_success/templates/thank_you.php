<?php
/*
  Modified for:
  Purchase without Account for Bootstrap
  Version 2.1 BS 
  by @raiwa 
  info@oscaddons.com
  www.oscaddons.com
*/
?>  
<div class="panel panel-success">
  <div class="panel-heading">
    <?php echo MODULE_CONTENT_CHECKOUT_SUCCESS_TEXT_THANKS_FOR_SHOPPING; ?>
  </div>
  <div class="panel-body">
    <p><?php echo MODULE_CONTENT_CHECKOUT_SUCCESS_TEXT_SUCCESS; ?></p>
<!--PWA guest checkout BEGIN-->
<?php
    if ( tep_session_is_registered('customer_id') && !tep_session_is_registered('customer_is_guest') ) {
?>  
      <p><?php echo sprintf(MODULE_CONTENT_CHECKOUT_SUCCESS_TEXT_SEE_ORDERS, tep_href_link('account_history.php', '', 'SSL')); ?></p>
<?php
}
?>
<!--PWA guest checkout END-->
    <p><?php echo sprintf(MODULE_CONTENT_CHECKOUT_SUCCESS_TEXT_CONTACT_STORE_OWNER, tep_href_link('contact_us.php')); ?></p>
  </div>
</div>
