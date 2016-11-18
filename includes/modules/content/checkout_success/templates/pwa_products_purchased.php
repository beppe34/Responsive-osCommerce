<div class="panel panel-success">
  <div class="panel-heading"><?php echo MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_TEXT_PRODUCTS; ?></div>
  <div class="panel-body">
    <p class="productsNotifications">
      <?php echo $products_guest; ?>
    </p>
	</div>
</div>
<?php 
  if ( defined('MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT') && MODULE_CONTENT_PWA_LOGIN_KEEP_ACCOUNT == 'True' ) {
?>
    <div class="panel panel-success">
      <div class="panel-heading"><?php echo MODULE_CONTENT_CHECKOUT_SUCCESS_PWA_PRODUCTS_PURCHASED_TEXT_GUEST_ACCOUNT; ?></div>
      <div class="panel-body">
        <p class="productsNotifications">
          <?php echo $products_guest_radio; ?>
        </p>
        <p class="productsNotifications">
          <?php echo $products_guest_continue; ?>
        </p>
      </div>
    </div>
<?php 
  }
?>
