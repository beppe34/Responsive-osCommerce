<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
  
  Horizontal Categories Menu BS v1.3.1
*/

include('includes/classes/catmenu.php'); 
?>
<?php if(MODULE_CONTENT_HEADER_CATMENU_XS_STATUS == 'True') { 
		echo '<div id="catMenu" class="col-sm-12 hidden-xs hidden-sm">';
	  } else {
		echo '<div id="catMenu" class="col-sm-12">';
	  } 
?>
	 <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
		<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
			<span class="sr-only">Toggle Navigation</span>
			<i class="fa fa-chevron-down"></i> <?php echo TEXT_COLLAPSE_MENU; ?>
		</button>
      </div>
      <div class="collapse navbar-collapse" id="bs-navbar-collapse">
          <?php echo build_hoz(); ?>
      </div>
    </nav>
</div>
<style>
.dropdown-submenu { 
  position:relative;
}
.dropdown-menu > .dropdown > .dropdown-menu, .dropdown-submenu > .dropdown-menu {
  top:0;
  left:100%;
  margin-top:-6px;
  -webkit-border-radius:0 6px 6px 6px;
  -moz-border-radius:0 6px 6px 6px;
  border-radius:0 6px 6px 6px
}
.dropdown-menu > .dropdown > a:after, .dropdown-submenu > a:after {
  display: inline-block;
  content: "\f0da";
  font-family: FontAwesome;
  margin-left: 10px;
  color: #cccccc;
}
.dropdown-submenu:hover > a:after {
  color:#555;
}
.menu_custom_width {
 min-width: 200px;
}
</style>
<script>
$(document).ready(function(){
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation(); 
      $(this).parent().siblings().removeClass('open');
      $(this).parent().toggleClass('open');
    });
});
</script>