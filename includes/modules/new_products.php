<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($num_new_products > 0) {

    $new_prods_content = NULL;

    while ($new_products = tep_db_fetch_array($new_products_query)) {
      $new_prods_content .= '<div class="col-sm-3 col-md-3 col-ld-3" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/Product">';
      $new_prods_content .= '  <div class="thumbnail equal-height">';
      $new_prods_content .= '    <a style="text-decoration:none;" itemprop="url" href="' . tep_href_link('product_info.php', 'products_id=' . $new_products['products_id']) . '">' . tep_image('images/' . $new_products['products_image'], $new_products['products_name'], 400, 600, 'itemprop="image"') . '';
      $new_prods_content .= '    <div class="caption">';
      $new_prods_content .= '      <p class="text-center"><span itemprop="name">' . substr($new_products['products_name'],0,22) . '</span></p>';
      $new_prods_content .= '      <!-- hr -->';
      $new_prods_content .= '      <p class="text-center" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span itemprop="price" content="' . $currencies->display_raw($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '">' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span></p>';
      $new_prods_content .= '    </div></a>';
      $new_prods_content .= '  </div>';
      $new_prods_content .= '</div>';
    }
?>

  <!-- h3><?php // echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h3 -->

  <div class="row" itemtype="http://schema.org/ItemList">
    <meta itemprop="numberOfItems" content="<?php echo (int)$num_new_products; ?>" />
    <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>
