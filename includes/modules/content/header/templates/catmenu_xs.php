<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
  
  Categories Menu XS v1.2
*/
?>
<link rel="stylesheet" type="text/css" href="ext/menu_xs/css/component.css" />
<script src="ext/menu_xs/js/modernizr.custom.js"></script>
<script src="ext/menu_xs/js/jquery.dlmenu.js"></script>
<?php include('includes/classes/catmenu_xs.php'); ?>
<div id="catMenu" class="col-sm-12 tsimi-color">
	<div id="dl-menu" class="dl-menuwrapper visible-sm visible-xs" style="z-index:10000;">
		<button class="dl-trigger btn tsimi-color-button"><i class="fa fa-chevron-down"></i> <?php echo TEXT_COLLAPSE_MENU_XS; ?></button>
		<ul class="dl-menu">
			<?php echo build_hoz_xs(); ?>
		</ul>
	</div><!-- /dl-menuwrapper -->
<div class="clearfix"></div>
<br />
</div>
<?php if(MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION == 'Default') {?>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu();
	});
</script>
<?php } elseif(MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION == 'Trans1') { ?>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
		});
	});
</script>
<?php } elseif(MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION == 'Trans2') { ?>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
		});
	});
</script>
<?php } elseif(MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION == 'Trans3') { ?>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { classin : 'dl-animate-in-3', classout : 'dl-animate-out-3' }
		});
	});
</script>
<?php } elseif(MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION == 'Trans4') { ?>
<script>
	$(function() {
		$( '#dl-menu' ).dlmenu({
			animationClasses : { classin : 'dl-animate-in-4', classout : 'dl-animate-out-4' }
		});
	});
</script>
<?php } ?>