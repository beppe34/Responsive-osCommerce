<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Modified for KISS Image Thumbnailer r19 August 2015 by @raiwa

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!isset($_GET['products_id'])) {
    tep_redirect(tep_href_link('index.php'));
  }

  require('includes/languages/' . $language . '/product_info.php');

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

  require('includes/template_top.php');

  if ($product_check['total'] < 1) {
?>

<div class="contentContainer">
  <div class="contentText">
    <div class="alert alert-warning"><?php echo TEXT_PRODUCT_NOT_FOUND; ?></div>
  </div>

  <div class="pull-right">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'fa fa-angle-right', tep_href_link('index.php')); ?>
  </div>
</div>

<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.products_gtin from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$_GET['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = '<del>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</del> <span class="productSpecialPrice" itemprop="price" content="' . $currencies->display_raw($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = '<span itemprop="price" content="' . $currencies->display_raw($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '">' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    }

    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
      $products_price .= '<link itemprop="availability" href="http://schema.org/PreOrder" />';
    } elseif ((STOCK_CHECK == 'true') && ($product_info['products_quantity'] < 1)) {
      $products_price .= '<link itemprop="availability" href="http://schema.org/OutOfStock" />';
    } else {
      $products_price .= '<link itemprop="availability" href="http://schema.org/InStock" />';
    }

    $products_price .= '<meta itemprop="priceCurrency" content="' . tep_output_string($currency) . '" />';

    $products_name = '<a href="' . tep_href_link('product_info.php', 'products_id=' . $product_info['products_id']) . '" itemprop="url"><span itemprop="name">' . $product_info['products_name'] . '</span></a>';

    if (tep_not_null($product_info['products_model'])) {
      $products_name .= '<br /><small>[<span itemprop="model">' . $product_info['products_model'] . '</span>]</small>';
    }
?>

<?php echo tep_draw_form('cart_quantity', tep_href_link('product_info.php', tep_get_all_get_params(array('action')). 'action=add_product', 'NONSSL'), 'post', 'class="form-horizontal" role="form"'); ?>

<div itemscope itemtype="http://schema.org/Product">

<div class="page-header">
  <div class="row">  
    <h1 class="col-sm-8"><?php echo $products_name; ?></h1>
    <h2 class="col-sm-4 text-right-not-xs" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><?php echo $products_price; ?></h2>
  </div>
</div>

<?php
  if ($messageStack->size('product_action') > 0) {
    echo $messageStack->output('product_action');
  }
?>

<div class="contentContainer">
  <div class="contentText">

<?php
    if (tep_not_null($product_info['products_image'])) {

     //KIss IMAGE BEGIN    
      //echo tep_image('images/' . $product_info['products_image'], NULL, NULL, NULL, 'itemprop="image" style="display:none;"');
      echo tep_image('images/' . $product_info['products_image'], NULL, KISSIT_MAIN_PRODUCT_IMAGE_WIDTH, KISSIT_MAIN_PRODUCT_IMAGE_HEIGHT, 'itemprop="image" style="display:none;"');
     //
      
      $photoset_layout = (int)MODULE_HEADER_TAGS_PRODUCT_COLORBOX_LAYOUT;

      $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");
      $pi_total = tep_db_num_rows($pi_query);

      if ($pi_total > 0) {
?>

    <div class="piGal pull-right" data-imgcount="<?php echo $photoset_layout; ?>">

<?php
        $pi_counter = 0;
        $pi_html = array();

        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;

          if (tep_not_null($pi['htmlcontent'])) {
            $pi_html[] = '<div id="piGalDiv_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div>';
          }

// KISS Image BEGIN          
//          echo tep_image('images/' . $pi['image'], '', '', '', 'id="piGalImg_' . $pi_counter . '"');
            list($width, $height) = file_exists('images/' . $pi['image'])? getimagesize('images/' . $pi['image']) : array(150,150); 
            echo tep_image('images/' . $pi['image'], addslashes($product_info['products_name']) . ' ' . $pi_counter, (($pi_counter > 1 )? round(KISSIT_MAIN_PRODUCT_IMAGE_WIDTH/(($pi_total <= 5)? $pi_total-1 : 5)) : KISSIT_MAIN_PRODUCT_IMAGE_WIDTH), (($pi_counter > 1 )? round(KISSIT_MAIN_PRODUCT_IMAGE_HEIGHT/(($pi_total <= 5)? $pi_total-1 : 5)) : KISSIT_MAIN_PRODUCT_IMAGE_HEIGHT), 'id="piGalImg_' . $pi_counter . '" '. ((KISSIT_MAIN_PRODUCT_WATERMARK_SIZE > 0)? preg_replace('%<img width="[0-9 ]+" height="[0-9 ]+" src="(.*)title=.+%', 'data-highres="$1', tep_image('images/' . $pi['image'], null, $width, $height)) : 'data-highres="'. 'images/' . $pi['image'] . '"'));
//KISS Image END
        }
?>

    </div>

<?php
        if ( !empty($pi_html) ) {
          echo '    <div style="display: none;">' . implode('', $pi_html) . '</div>';
        }
// KISS Image begin        
      } else {
      	list($width, $height) = file_exists('images/' . $product_info['products_image'])? getimagesize('images/' . $product_info['products_image']) : array(150,150); 
?>

    <div class="piGal pull-right">
      <?php echo tep_image('images/' . $product_info['products_image'], addslashes($product_info['products_name']), KISSIT_MAIN_PRODUCT_IMAGE_WIDTH, KISSIT_MAIN_PRODUCT_IMAGE_HEIGHT, ((KISSIT_MAIN_PRODUCT_WATERMARK_SIZE > 0)? preg_replace('%<img width="[0-9 ]+" height="[0-9 ]+" src="(.*)title=.+%', 'data-highres="$1', tep_image('images/' . $product_info['products_image'], null, $width, $height)) : 'data-highres="'. 'images/' . $product_info['products_image'] . '"')); ?>
    </div>
      
<!-- // KISS Image end -->
<?php
      }
    }
?>

<div itemprop="description">
  <?php echo stripslashes($product_info['products_description']); ?>
</div>

              <?php
}
//++++ QT Pro: End Changed Code
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
//++++ QT Pro: Begin Changed code
      $products_id=(preg_match("/^\d{1,10}(\{\d{1,10}\}\d{1,10})*$/",$_GET['products_id']) ? $_GET['products_id'] : (int)$_GET['products_id']); 
      require(DIR_FS_CATALOG .  'includes/classes/pad_' . PRODINFO_ATTRIBUTE_PLUGIN . '.php');
      $class = 'pad_' . PRODINFO_ATTRIBUTE_PLUGIN;
      $pad = new $class($products_id);
      echo $pad->draw();
    }

//Display a table with which attributecombinations is on stock to the customer?
if(PRODINFO_ATTRIBUTE_DISPLAY_STOCK_LIST == 'True'): require("includes/modules/qtpro_stock_table.php"); endif;

//++++ QT Pro: End Changed Code
?>


    <div class="clearfix"></div>

<?php
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>

    <div class="alert alert-info"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></div>

<?php
    }
?>

  </div>

<?php
    $reviews_query = tep_db_query("select count(*) as count, avg(reviews_rating) as avgrating from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$_GET['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and reviews_status = 1");
    $reviews = tep_db_fetch_array($reviews_query);

    if ($reviews['count'] > 0) {
      echo '<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"><meta itemprop="ratingValue" content="' . $reviews['avgrating'] . '" /><meta itemprop="ratingCount" content="' . $reviews['count'] . '" /></span>';
    }
?>

  <div class="buttonSet row">
    <div class="col-xs-6"><?php echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : ''), 'fa fa-commenting', tep_href_link('product_reviews.php', tep_get_all_get_params())); ?></div>
    <div class="col-xs-6 text-right"><?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'fa fa-shopping-cart', null, 'primary', null, 'btn-success btn-product-info btn-buy'); ?></div>
  </div>

  <div class="row">
    <?php echo $oscTemplate->getContent('product_info'); ?>
  </div>

<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include('includes/modules/also_purchased_products.php');
    }

    if ($product_info['manufacturers_id'] > 0) {
      $manufacturer_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$product_info['manufacturers_id'] . "'");
      if (tep_db_num_rows($manufacturer_query)) {
        $manufacturer = tep_db_fetch_array($manufacturer_query);
        echo '<span itemprop="manufacturer" itemscope itemtype="http://schema.org/Organization"><meta itemprop="name" content="' . tep_output_string($manufacturer['manufacturers_name']) . '" /></span>';
      }
    }
?>

</div>

</div>

</form>

<?php
  
  require('includes/template_bottom.php');
  require('includes/application_bottom.php');
?>
