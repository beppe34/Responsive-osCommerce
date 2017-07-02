<?php
/*
  $Id$ explode_category_tree

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2017 osCommerce
  
  extended class author: G.L. Walker
  Copyright (c) 2017 G.L. Walker
  
  Released under the GNU General Public License
  
  Horizontal Categories Menu BS v1.3.1
*/
  class explode_category_tree extends category_tree {
    
    var $parent_group_start_string = null,
	    $parent_group_end_string = null,
		$parent_group_apply_to_root = false,
		$root_start_string = '<li class="dropdown">',
		$root_end_string = '</li>',
		$parent_start_string = '<ul class="dropdown-menu">',
		$parent_start_string_img = '<ul class="dropdown-menu menu_custom_width">',
		$parent_end_string = '</ul>',
		$child_start_string = '<li>',
		$child_end_string = '</li>';
		
    function _buildHoz($parent_id, $level = 0) {
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
            $result .= '<li class="dropdown dropdown-submenu"><a href="#" tabindex="-1" class="dropdown-toggle" data-toggle="dropdown">';
            $caret = '';
          } elseif(isset($this->_data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level + 1))) {
            $result .= $this->root_start_string;
            $result .= '<a href="#" tabindex="-1" class="dropdown-toggle" data-toggle="dropdown">';
            $caret =   ' <span class="fa fa-caret-down"></span>';
            			
          } else {
            $result .= $this->child_start_string;
            $result .= '<a href="' . tep_href_link('index.php', 'cPath=' . $category_link) . '">';           
            $caret = false;
          }
		  
          $result .= str_repeat($this->spacer_string, $this->spacer_multiplier * $level);
  		  if (MODULE_CONTENT_HEADER_CATMENU_IMAGE == 'True') {
			$result .=  tep_image('images/' . $category['image'], $category['name'], SMALL_IMAGE_WIDTH*0.5, SMALL_IMAGE_HEIGHT*0.5, 'style="display:inline-block;"') . '&nbsp;' . $link_title . (($caret != false) ? $caret : null) . '</a>';
		  } else {
			$result .= $link_title . (($caret != false) ? $caret : null) . '</a>';  
		  }
          if(isset($this->_data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level + 1))) {
            // show parent category link //
		    if (MODULE_CONTENT_HEADER_CATMENU_PARENT_LINK == 'True') {
				if (MODULE_CONTENT_HEADER_CATMENU_IMAGE == 'True') {
					$root_link_title = tep_image('images/' . $category['image'], $category['name'], SMALL_IMAGE_WIDTH*0.5, SMALL_IMAGE_HEIGHT*0.5, 'style="display:inline-block;"') . '&nbsp;' . $link_title;
				} else {
					$root_link_title =  '<span><span class="fa fa-list"></span>&nbsp;' . $link_title . '</span>';
				}
			}
			if (MODULE_CONTENT_HEADER_CATMENU_IMAGE == 'True') {
				$result .= $this->parent_start_string_img;
			} else {
				$result .= $this->parent_start_string;
			}
            $result .= '<li><a href="' . tep_href_link('index.php', 'cPath=' . $category_link) . '"><strong>' . $root_link_title . '</strong></a></li>';
			// divider added for clarity //
			if (MODULE_CONTENT_HEADER_CATMENU_DEVIDER == 'True') {
				$result .= '<li class="divider"></li>';
			}   
			$result .= $this->_buildHoz($category_id, $level + 1);
            $result .= $this->parent_end_string;
            $result .= $this->child_end_string;
          } else {
            $result .= $this->root_end_string;
          }
        }
      }
      return $result;
    }
    function getExTree() {
      return $this->_buildHoz($this->root_category_id);
    }
  }
/* end explode_category_tree */
?>