<?php
/*
  $Id$ explode_category_tree_xs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2017 osCommerce
  
  extended class author: G.L. Walker
  Copyright (c) 2017 G.L. Walker
  
  Released under the GNU General Public License
  
  Categories Menu XS v1.2
*/
  class explode_category_tree_xs extends category_tree {
    
    var $parent_group_start_string = null,
	    $parent_group_end_string = null,
		$parent_group_apply_to_root = false,
		$root_start_string = '<li>',
		$root_end_string = '</li>',
		$parent_start_string = '<ul class="dl-submenu">',
		$parent_end_string = '</ul>',
		$child_start_string = '<li>',
		$child_end_string = '</li>';
		
    function _buildHoz_xs($parent_id, $level = 0) {
		$result = '';
      if(isset($this->_data[$parent_id])) {
        foreach($this->_data[$parent_id] as $category_id => $category) {
          if($this->breadcrumb_usage === true) {
            $category_link = $this->buildBreadcrumb($category_id);
          } else {
            $category_link = $category_id;
          }
          if(($this->follow_cpath === true) && in_array($category_id, $this->cpath_array)) {
            $link_title = $this->cpath_start_string . $category['name'] . $this->cpath_end_string;
          } else {
            $link_title = $category['name'];
          }

		  if (isset($this->_data[$category_id]) && ($level != 0)) {
// HAS MORE SUBCATEGORIES			  
            $result .= '<li><a href="#">';	   
          } elseif(isset($this->_data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level + 1))) {
// PARENT HAS CHILD CATEGORIES			  
            $result .= $this->root_start_string;
            $result .= '<a href="#">';          			
          } else {
// NO SUBCATEGORIES			  
            $result .= $this->child_start_string;
            $result .= '<a href="' . tep_href_link('index.php', 'cPath=' . $category_link) . '">';
            $caret = false;
          }
		  $caret = '';
          $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level);
// CATEGORY NAMES		  
          $result .= $link_title . (($caret != false) ? $caret : null) . '</a>';

		  
          if(isset($this->_data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level + 1))) {
            // show parent category link //	    
			$root_link_title =  '<strong><span class="fa fa-list fa-lg"></span>&nbsp;' . $link_title . '</span></strong>';
						
            $result .= $this->parent_start_string;
            $result .= '<li><a href="' . tep_href_link('index.php', 'cPath=' . $category_link) . '">' . $root_link_title . '</a></li>';
            $result .= $this->_buildHoz_xs($category_id, $level + 1);
            $result .= $this->parent_end_string;
            $result .= $this->child_end_string;
          } else {
            $result .= $this->root_end_string;
          }
        }
      }
      return $result;
    }
    function getExTree_xs() {
      return $this->_buildHoz_xs($this->root_category_id);
    }
  }
/* end explode_category_tree_xs */
?>