<?php
/*
 $Id: ht_theme_switcher.php 1.5.3 20150323 Kymation $

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2016 osCommerce

 Released under the GNU General Public License
 */


	class ht_theme_switcher {
		public $version = '1.5.3';
		public $code;
		public $group;
		public $title;
		public $description;
		public $sort_order;
		public $enabled = false;

		////
		// Class constructor to set values at instantiation
		function __construct() {
      $this->code = get_class( $this );
      $this->group = basename( dirname( __FILE__ ) );
      
		  $this->title = MODULE_HEADER_TAGS_THEME_SWITCHER_TITLE;
			$this->description = MODULE_HEADER_TAGS_THEME_SWITCHER_DESCRIPTION;

			if ( defined('MODULE_HEADER_TAGS_THEME_SWITCHER_STATUS') ) {
				$this->sort_order = MODULE_HEADER_TAGS_THEME_SWITCHER_SORT_ORDER;
				$this->enabled = (MODULE_HEADER_TAGS_THEME_SWITCHER_STATUS == 'True');
			}
		}

		////
		// Output a header tag
		public function execute() {
			global $oscTemplate;

			$theme_name = 'css';
			if( MODULE_HEADER_TAGS_THEME_SWITCHER_THEME != '' ) {
				$theme_name = MODULE_HEADER_TAGS_THEME_SWITCHER_THEME;
			}

			$theme_text = '<link href="ext/bootstrap/' . $theme_name . '/bootstrap.min.css" rel="stylesheet">' . PHP_EOL;

			$oscTemplate->addBlock( $theme_text, $this->group );
		}

		////
		// Check whether the module is enabled
		public function isEnabled() {
			return $this->enabled;
		}

		////
		// Check the module's status
		public function check() {
			return defined( 'MODULE_HEADER_TAGS_THEME_SWITCHER_STATUS' );
		}

		////
		// Install the module and check for correct installation of related files/directories
		public function install() {
      // Standard configuration install
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added ) values ( 'Module Version', 'MODULE_HEADER_TAGS_THEME_SWITCHER_VERSION', '" . $this->version . "', 'The version of this module that you are running.', '6', '0', '', 'tep_cfg_disabled(', now() ) ");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Theme Switcher', 'MODULE_HEADER_TAGS_THEME_SWITCHER_STATUS', 'True', 'Do you want to be able to select a theme here?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_THEME_SWITCHER_SORT_ORDER', '1', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Theme', 'MODULE_HEADER_TAGS_THEME_SWITCHER_THEME', 'css', 'Select the theme that you want to use.', '6', '5', 'tep_cfg_pull_down_themes(', now())" );

      // Special functions to check for missing files and version conflicts
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added ) values ( '', 'MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_TEST',  '',  '', '6', '9', 'tep_theme_check', 'tep_cfg_do_nothing(', now() ) ");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added ) values ( '', 'MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP_MODIFIED',  '',  '', '6', '11', 'tep_template_top_check', 'tep_cfg_do_nothing(', now() ) ");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added ) values ( '', 'MODULE_HEADER_TAGS_THEME_SWITCHER_LANGUAGE_FILE_TEST',  '',  '', '6', '12', 'tep_language_file_check', 'tep_cfg_do_nothing(', now() ) ");
		}

		////
		// Uninstall the module
		public function remove() {
			tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
		}

		////
		// Generate the keys array of constant names
		public function keys() {
			$keys = array();

			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_VERSION';
			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_STATUS';
			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_SORT_ORDER';
			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_THEME';

			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_TEST';
			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP_MODIFIED';
			$keys[] = 'MODULE_HEADER_TAGS_THEME_SWITCHER_LANGUAGE_FILE_TEST';

			return $keys;
		}

	} // end class



	/////////////////////////////////////////////////////////////////////////////////////////////////
	//
	//    The following are functions, not class methods
	//
	/////////////////////////////////////////////////////////////////////////////////////////////////

	////
	// Multi-level array sort function (From the PHP manual)
	if (!function_exists('array_msort')) {
		function array_msort( $array, $cols ) {
			$colarr = array ();
			foreach ($cols as $col => $order) {
				$colarr[$col] = array ();
				foreach ($array as $k => $row) {
          $colarr[$col]['_' . $k] = strtolower($row[$col]);
				}
			}
			$params = array ();
			foreach ($cols as $col => $order) {
				$params[] = & $colarr[$col];
				$order = (array) $order;
				foreach ($order as $order_element) {
					//pass by reference, as required by php 5.3
					$params[] = & $order_element;
				}
			}
			call_user_func_array('array_multisort', $params);
			$ret = array ();
			$keys = array ();
			$first = true;
			foreach ($colarr as $col => $arr) {
				foreach ($arr as $k => $v) {
					if ($first) {
						$keys[$k] = substr($k, 1);
					}
					$k = $keys[$k];

					if (!isset ($ret[$k])) {
						$ret[$k] = $array[$k];
					}

					$ret[$k][$col] = $array[$k][$col];
				}
				$first = false;
			}
			return $ret;
		} // function array_msort
  } // if (!function_exists

	
	////
	// Get a list of the files or directories in a directory
	if (!function_exists('tep_get_directory_list')) {
		function tep_get_directory_list( $directory, $file = true, $exclude = array() ) {
			$d = dir( $directory );
			$list = array ();
			while ($entry = $d->read()) {
				if ($file == true) { // We want a list of files, not directories
					$parts_array = explode('.', $entry);
					// There may be more than one dot, so find the last one
					$last = count( $parts_array ) - 1;
					$extension = $parts_array[$last];
					// Don't add files or directories that we don't want
					if( $entry != '.' && $entry != '..' && $entry != '.htaccess' && $extension != 'php') {
						if( !is_dir( $directory . "/" . $entry ) ) {
							$list[] = $entry;
						}
					}
				} else { // We want the directories and not the files
					if (is_dir($directory . "/" . $entry) && $entry != '.' && $entry != '..') { // && $entry != 'i18n'
						if (count($exclude) == 0 || !in_array($entry, $exclude)) {
							$list[] = array (
                'id' => $entry,
                'text' => $entry
							);
						}
					}
				}
			} // while ($entry
			$d->close();

			return $list;
		}
	}

	////
	// Generate a pulldown menu of the available themes
	if (!function_exists('tep_cfg_pull_down_themes')) {
		function tep_cfg_pull_down_themes( $theme_name, $key = '' ) {
			$themes_array = array ();
			$theme_directory = DIR_FS_CATALOG . 'ext/bootstrap';

			if (file_exists( $theme_directory ) && is_dir( $theme_directory ) ) {
				$name = ( ( $key ) ? 'configuration[' . $key . ']' : 'configuration_value' );

				$exclude = array( 'js', 'fonts' );
				$themes_array = tep_get_directory_list( $theme_directory, false, $exclude );

			  $themes_array = array_msort( $themes_array, array( 'id' => SORT_ASC ) );
			  $themes_array = array_values( $themes_array );
			  sort( $themes_array );
			}

			return tep_draw_pull_down_menu( $name, $themes_array, $theme_name );
		}
	}


	////
	// Check whether the selected theme's directory exists
	if( !function_exists( 'tep_theme_check' ) ) {
		function tep_theme_check() {
			// The theme directory is hard-coded in the rest of osC, so...
			$theme_directory = DIR_FS_CATALOG . 'ext/bootstrap';

			if( file_exists( $theme_directory ) && is_dir( $theme_directory ) ) {
				// Exclude directories that are not themes
				$exclude = array( 'js', 'fonts' );
			  
				// Get an array of all of the theme directories
				$themes_array = tep_get_directory_list( $theme_directory, false, $exclude );

				// Step through the themes and check for a match with the selected theme
				foreach( $themes_array as $theme ) {
					if( $theme['text'] == MODULE_HEADER_TAGS_THEME_SWITCHER_THEME ) {
						//The theme folder exists, so return success and quit
						return tep_image( DIR_WS_ICONS . 'tick.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_FOUND . '</span>';
						break;
					}
				}

			} // if( file_exists

			// The theme was not found, so return an error message
			return tep_image( DIR_WS_ICONS . 'cross.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold; color:red;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_MISSING . '</span>';
		} // function theme_check
	} // if( !function_exists




	////
	// Check whether the selected theme CSS file exists
	if( !function_exists( 'tep_theme_version_check' ) ) {
		function tep_theme_version_check() {
			// The jQuery UI directory is hard-coded in the rest of osC, so...
			$theme_directory = DIR_FS_CATALOG . 'ext/jquery/ui/' . MODULE_HEADER_TAGS_THEME_SWITCHER_THEME;

			if( file_exists( $theme_directory ) && is_dir( $theme_directory ) ) {
				// Get an array of all of the files in the theme directory
				$themes_array = tep_get_directory_list( $theme_directory );

				// Step through the files and check for a match with the selected version of the CSS file
				foreach( $themes_array as $theme_css ) {
					if( $theme_css == 'jquery-ui-' . MODULE_HEADER_TAGS_THEME_SWITCHER_JQUERY_UI_VERSION . '.min.css' ) {
						//The correct version exists, so return success and quit
						return tep_image( DIR_WS_ICONS . 'tick.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_VERSION_FOUND . '</span>';
						break;
					}
				}

			} // if( file_exists

			// The jQuery file was not found, so return an error message
			return tep_image( DIR_WS_ICONS . 'cross.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold; color:red;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_THEME_VERSION_MISSING . '</span>' . $jquery_directory;
		} // function theme_check
	} // if( !function_exists


	////
	// Check whether includes/template_top.php has been modified/replaced
	if( !function_exists( 'tep_template_top_check' ) ) {
		function tep_template_top_check() {
			$filename = DIR_FS_CATALOG . DIR_WS_INCLUDES . 'template_top.php';
			if( file_exists( $filename ) ) {
				// Read the file into an array, one line per element
				$file_array = file( $filename );

				// Step through the files and check for a match with the selected version of the CSS file
				foreach ($file_array as $line) {
					// Check if the line matches one of the lines that should be removed
					if( trim( $line ) == '<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.8.6.css" />' ||
					trim( $line ) == '<script type="text/javascript" src="ext/jquery/jquery-1.4.2.min.js"></script>' ||
					trim( $line ) == '<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.6.min.js"></script>' ) {
						// One or more lines exist, so return error and quit
						return tep_image( DIR_WS_ICONS . 'cross.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold; color:red;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP_NOT_MODIFIED . '</span>' . $jquery_directory;
						break;
					}
				}

			} else {
				// The file was not found, so return an error
				return tep_image( DIR_WS_ICONS . 'cross.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold; color:red;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP_NOT_MODIFIED . '</span>' . $jquery_directory;

			} // if( file_exists

			// The lines were not found in the file, so return a success message
			return tep_image( DIR_WS_ICONS . 'tick.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP . '</span>';
		} // function theme_check
	} // if( !function_exists  MODULE_HEADER_TAGS_THEME_SWITCHER_TEMPLATE_TOP_MODIFIED


  ////
  // Check whether the language file for this module exists
  // We should only need to check the Admin language, so that is hardwired as $language
  if( !function_exists( 'tep_language_file_check' ) ) {
    function tep_language_file_check() {
      global $language;
    	
      $language_file = DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/header_tags/ht_theme_switcher.php';

      if( file_exists( $language_file ) && is_file( $language_file ) ) {
        return tep_image( DIR_WS_ICONS . 'tick.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_LANGUAGE_FILE_FOUND . '</span>';
      } // if( file_exists

      // The language file was not found, so return an error message
      return tep_image( DIR_WS_ICONS . 'cross.gif', '', '16', '16', 'style="vertical-align:middle;"' ) . ' <span style="vertical-align:middle; font-weight:bold; color:red;">' . MODULE_HEADER_TAGS_THEME_SWITCHER_LANGUAGE_FILE_MISSING . '</span>' . $jquery_directory;
    } // function tep_language_file_check
  } // if( !function_exists
	

  ////
  // Function to prevent boxes showing for the output-only test functions
  if( !function_exists( 'tep_cfg_do_nothing' ) ) {
    function tep_cfg_do_nothing() {
      return '';
    }
  }


	////
	// This should already exist in admin/includes/functions/general.php, but seems to be missing in some copies
	if( !function_exists( 'tep_get_languages' ) ) {
		function tep_get_languages() {
			$languages_query = tep_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
			while ($languages = tep_db_fetch_array($languages_query)) {
				$languages_array[] = array('id' => $languages['languages_id'],
                                   'name' => $languages['name'],
                                   'code' => $languages['code'],
                                   'image' => $languages['image'],
                                   'directory' => $languages['directory']);
			}

			return $languages_array;
		}
	}


  ////
  // Function to show a disabled entry (Value is shown but cannot be changed)
  if( !function_exists( 'tep_cfg_disabled' ) ) {
    function tep_cfg_disabled( $value ) {
      return tep_draw_input_field( 'configuration_value', $value, ' disabled' );
    }
  }
