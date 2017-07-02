<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2017 osCommerce

  Released under the GNU General Public License
  
  Categories Menu XS v1.2
*/

  class cm_header_catmenu_xs {
    var $code;
    var $group;
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function __construct() {
      $this->code = get_class($this);
      $this->group = basename(dirname(__FILE__));

      $this->title = MODULE_CONTENT_HEADER_CATMENU_XS_TITLE;
      $this->description = MODULE_CONTENT_HEADER_CATMENU_XS_DESCRIPTION;
		
      if ( defined('MODULE_CONTENT_HEADER_CATMENU_XS_STATUS') ) {
        $this->sort_order = MODULE_CONTENT_HEADER_CATMENU_XS_SORT_ORDER;
        $this->enabled = (MODULE_CONTENT_HEADER_CATMENU_XS_STATUS == 'True');
      }
    }
  
    function execute() {
      global $oscTemplate;
	  
      ob_start();
      include('includes/modules/content/' . $this->group . '/templates/catmenu_xs.php');
      $data = ob_get_clean();

      $oscTemplate->addContent($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CONTENT_HEADER_CATMENU_XS_STATUS');
    }

    function install() {
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Header Horizontal Menu Module', 'MODULE_CONTENT_HEADER_CATMENU_XS_STATUS', 'True', 'Do you want to enable the Horizontal Menu content module?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Transition', 'MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION', 'Default', 'Select transition mode.', '6', '2', 'tep_cfg_select_option(array(\'Default\', \'Trans1\', \'Trans2\', \'Trans3\', \'Trans4\'), ', now())");
      tep_db_query("insert into configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CONTENT_HEADER_CATMENU_XS_SORT_ORDER', '120', 'Sort order of display. Lowest is displayed first.<br /><em>*Default is 120.', '6', '7', now())");
    }

    function remove() {
      tep_db_query("delete from configuration where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CONTENT_HEADER_CATMENU_XS_STATUS', 
				   'MODULE_CONTENT_HEADER_CATMENU_XS_TRANSITION', 
				   'MODULE_CONTENT_HEADER_CATMENU_XS_SORT_ORDER');
    }
  }
  
  //added function
    function build_hoz_xs($class='') {
		global $cPath, $level;

		$OSCOM_CategoryTree = new explode_category_tree_xs();
		$data = $OSCOM_CategoryTree->getExTree_xs();

		return $data;
	}

