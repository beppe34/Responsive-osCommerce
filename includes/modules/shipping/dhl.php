<?php

/*
Original code by T. Almroth www.tim-international.net

Modified  by I. Arman www.glokalit.com
*/

	class dhl {
		var $code, $title, $description, $icon, $enabled;

		function dhl() {
	
			$this->code = 'dhl';
		
			$this->moduleinfo = array(
				'name'        => 'Frakt',
				'description' => 'Den här modulen erbjuder dina kunder alternativet att välja leverans via DHL och beräknar frakten efter en vikttabell.<br><br>Frakten ärver momsen från varorna, och om varorna omfattas av olika skattesatser beräknas kostnadens moms proportionellt.<br><br>OBS! Tag hänsyn till att DHL har maxvikt på 31,5 kg fär kollin, varvid du kan behöva aktivera den inbyggda funktionen i osCommerce att dela upp stora ordrar i flera kollin (ex >31kg).');
			
			if (basename($_SERVER['PHP_SELF']) == 'modules.php') {
				
				$this->title     = $this->moduleinfo['name'];
				
				$this->description = $this->moduleinfo['description'];

			} else {
				
				$this->title     = $this->moduleinfo['name'];
				
		}
		
			$this->icon = '';
			
			$this->enabled     = ((MODULE_SHIPPING_DHL_EUROPACK_STATUS == 'Ja') ? true : false);
                        if($this->enabled==false){
                            $this->enabled     = ((MODULE_SHIPPING_DHL_SERVICEPOINT_STATUS == 'Ja') ? true : false);
                        }
                        if($this->enabled==false){
                            $this->enabled     = ((MODULE_SHIPPING_DHL_PACKET_STATUS == 'Ja') ? true : false);
                        }
			
			$this->sort_order  = MODULE_SHIPPING_DHL_EUROPACK_SORT_ORDER;
                        $this->tax_class = MODULE_SHIPPING_ZONES_TAX_CLASS;
		
		}

		function quote($method = '') {
			global $order, $shipping_weight, $shipping_num_boxes,$total_volume,$total_weight;
		
			$dest_country = $order->delivery['country']['iso_code_2'];
			
			if (MODULE_SHIPPING_DHL_EUROPACK_DISPLAYWEIGHT_STATUS == 'Ja') $weight_specification = ' ('. $shipping_num_boxes .' x '. $shipping_weight .' kg)';	  
			
			if (in_array($dest_country, explode(',', MODULE_SHIPPING_DHL_EUROPACK_ZON1_COUNTRIES))) {
					
					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON1_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;				
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
					
					if (!$method || $method == 'europack')
					$shipping_methods[] = array(
						'id' => 'europack',
						'title' => MODULE_SHIPPING_DHL_EUROPACK_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON1_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'europackgogreen')
						$shipping_methods[] = array(
							'id' => 'europackgogreen',
							'title' => MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}			
				
			} elseif (in_array($dest_country, explode(',', MODULE_SHIPPING_DHL_EUROPACK_ZON2_COUNTRIES))) {
					
					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON2_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
					
					if (!$method || $method == 'europack')
					$shipping_methods[] = array(
						'id' => 'europack',
						'title' => MODULE_SHIPPING_DHL_EUROPACK_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON2_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'europackgogreen')
						$shipping_methods[] = array(
							'id' => 'europackgogreen',
							'title' => MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}					
				
			} elseif (in_array($dest_country, explode(',', MODULE_SHIPPING_DHL_EUROPACK_ZON3_COUNTRIES))) {
					
					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON3_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
					
					if (!$method || $method == 'europack')
					$shipping_methods[] = array(
						'id' => 'europack',
						'title' => MODULE_SHIPPING_DHL_EUROPACK_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON3_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'europackgogreen')
						$shipping_methods[] = array(
							'id' => 'europackgogreen',
							'title' => MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}					
				
			} elseif (in_array($dest_country, explode(',', MODULE_SHIPPING_DHL_EUROPACK_ZON4_COUNTRIES))) {
					
					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON4_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
					
					if (!$method || $method == 'europack')
					$shipping_methods[] = array(
						'id' => 'europack',
						'title' => MODULE_SHIPPING_DHL_EUROPACK_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_EUROPACK_ZON4_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'europackgogreen')
						$shipping_methods[] = array(
							'id' => 'europackgogreen',
							'title' => MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}					
				
			} elseif ($dest_country == 'SE') {
			
				if (MODULE_SHIPPING_DHL_SERVICEPOINT_STATUS == 'Ja') {


                                        $dhl_shippingweight = $total_volume * DHL_FRAKTSATS;
                                        IF($dhl_shippingweight>$shipping_weight)
                                            $shipping_weight = $dhl_shippingweight;

//                                        echo 'total volym       =' . $total_volume . ' </br>';
//                                        echo 'total_vikt        =' . $total_weight . ' </br>';
//                                        echo 'shippingweight    =' . $shipping_weight . ' </br>';
//                                        echo 'dhl_shippingweight=' . $dhl_shippingweight . ' </br>';
//                                        echo 'dhl fraktsats     =' . DHL_FRAKTSATS . ' </br>';

					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_SERVICEPOINT_SE_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
// if($order->customer['firstname']=='hemfinahem'){
// echo  '</br>firsnamte' . $order->customer['firstname'] . '</br>';
//                                        echo '$gross  =' . $gross . ' </br>';
//                                        echo '$tax    =' . $tax . ' </br>';
//                                        echo '$net    =' . $net . ' </br>';
// }                                        
					if (!$method || $method == 'servicepoint')
					$shipping_methods[] = array(
						'id' => 'servicepoint',
						'title' => MODULE_SHIPPING_DHL_SERVICEPOINT_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_SERVICEPOINT_SE_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'servicepointgogreen')
						$shipping_methods[] = array(
							'id' => 'servicepointgogreen',
							'title' => MODULE_SHIPPING_DHL_SERVICEPOINT_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}
				
				}
				
				if (MODULE_SHIPPING_DHL_PACKET_STATUS == 'Ja') {
				
					$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_PACKET_SE_TABLE, ($shipping_weight * $shipping_num_boxes)) + MODULE_SHIPPING_DHL_HANDLING;
					$tax = $this->calculate_proportional_tax($gross);
					$net = $gross + $tax;
					
					if (!$method || $method == 'packet')
					$shipping_methods[] = array(
						'id' => 'packet',
						'title' => MODULE_SHIPPING_DHL_PACKET_TEXT_WAY . $weight_specification,
						'cost' => $gross
					);
					
					if (MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS == 'Ja') {
					
						$gross = $this->calculate_table_cost(MODULE_SHIPPING_DHL_PACKET_SE_TABLE, ($shipping_weight * $shipping_num_boxes));
						$gross += ($gross * 0.02); // 2% gogreen
						$gross += MODULE_SHIPPING_DHL_HANDLING;					
						$tax = $this->calculate_proportional_tax($gross);
						$net = $gross + $tax;
					
						if (!$method || $method == 'packetgogreen')
						$shipping_methods[] = array(
							'id' => 'packetgogreen',
							'title' => MODULE_SHIPPING_DHL_PACKET_GOGREEN_TEXT_WAY . $weight_specification,
							'cost' => $gross
						);
						
					}
				
				}
			
			} else {
				
				return false;
			
			}
		
			$this->quotes = array(
				'id' => $this->code,
				'module' => 'Fraktas:',
				'methods' => $shipping_methods,
				'tax' => ($tax/$gross)*100
			);
			
			if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
			
			return $this->quotes;
		}
	
		function calculate_proportional_tax($cost) {
			global $order;
			
			foreach ($order->products as $product) {
// echo var_dump($product) . '</br>';
				$tax_groups[$product['tax_description']]['sum'] += $product['qty'] * ($product['final_price']);
				$tax_groups[$product['tax_description']]['tax'] = $product['tax'];
				$subtotal += $product['qty'] * $product['final_price'];
			}
                        
			foreach($tax_groups as $tax_group => $value) {
// echo var_dump($value) . "'</br>";                            
				$taxclass_tax += $cost * ($value['sum']/$subtotal) * ($value['tax']/100);
                                $tax += $taxclass_tax;
// echo '$taxclass_tax: ' . $taxclass_tax . '$tax: ' . $tax . ' </br>';
			}
			
			return $tax;
		}

		function calculate_table_cost($table, $weight) {
			$table = array_reverse(explode("|" , $table));
			foreach ($table as $entry) {
				$entry = explode(':', $entry);
				if ($weight <= $entry[0]) {
					$this_cost = $entry[1];
				}
			}			
			return $this_cost;
		}
	
		function check() {
			if (!isset($this->_check)) {
				$check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DHL_EUROPACK_STATUS'");
				$this->_check = tep_db_num_rows($check_query);
			}
			return $this->_check;
		}

		function install() {
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Tj�nsten aktiverad?', 'MODULE_SHIPPING_DHL_EUROPACK_STATUS', 'Ja', 'Vill du erbjuda leveranser via DHL - EUROPACK?', '6', '0', 'tep_cfg_select_option(array(\'Ja\', \'Nej\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Tj�nsten aktiverad?', 'MODULE_SHIPPING_DHL_PACKET_STATUS', 'Ja', 'Vill du erbjuda leveranser via DHL - PACKET?', '6', '0', 'tep_cfg_select_option(array(\'Ja\', \'Nej\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Tj�nsten aktiverad?', 'MODULE_SHIPPING_DHL_SERVICEPOINT_STATUS', 'Ja', 'Vill du erbjuda leveranser via DHL - SERVICEPOINT?', '6', '0', 'tep_cfg_select_option(array(\'Ja\', \'Nej\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Tillval DHL:s GOGREEN till�g p� 2%', 'MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS', 'Ja', 'Vill du erbjuda alternativet?', '6', '1', 'tep_cfg_select_option(array(\'Ja\', \'Nej\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Hanteringskostnad', 'MODULE_SHIPPING_DHL_HANDLING', '20', 'Om du �nskar ta ut en avift f�r hanteringen. Beloppet skall anges exklusive moms.', '6', '3', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r EUROPACK zon 1', 'MODULE_SHIPPING_DHL_EUROPACK_ZON1_TABLE', '1:333|2:349|3:362|4:375|5:387|6:397|7:406|8:414|9:422|10:432|11:438|12:445|13:452|14:458|15:464|16:469|17:475|18:481|19:487|20:492|21:497|22:502|23:508|24:514|25:519|26:523|27:528|28:532|29:537|30:541|31:545|31.5:547', '', '6', '4', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r EUROPACK zon 2', 'MODULE_SHIPPING_DHL_EUROPACK_ZON2_TABLE', '1:400|2:415|3:431|4:446|5:461|6:470|7:481|8:491|9:500|10:510|11:518|12:526|13:534|14:541|15:548|16:555|17:562|18:569|19:575|20:581|21:586|22:592|23:598|24:603|25:608|26:613|27:618|28:622|29:626|30:630|31:634|31.5:637', '', '6', '5', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r EUROPACK zon 3', 'MODULE_SHIPPING_DHL_EUROPACK_ZON3_TABLE', '1:536|2:555|3:575|4:595|5:614|6:625|7:636|8:647|9:658|10:668|11:678|12:686|13:695|14:704|15:712|16:721|17:730|18:739|19:747|20:756|21:764|22:771|23:780|24:787|25:794|26:802|27:810|28:817|29:825|30:832|31:841|31.5:845', '', '6', '5', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r EUROPACK zon 4', 'MODULE_SHIPPING_DHL_EUROPACK_ZON4_TABLE', '1:650|2:674|3:699|4:722|5:746|6:764|7:782|8:798|9:816|10:834|11:845|12:855|13:867|14:877|15:889|16:899|17:910|18:921|19:932|20:943|21:953|22:962|23:973|24:982|25:992|26:1002|27:1012|28:1021|29:1032|30:1041|31:1051|31.5:1057', '', '6', '5', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r SERVICEPOINT', 'MODULE_SHIPPING_DHL_SERVICEPOINT_SE_TABLE', '3:75|5:93|10:121|15:156|20:174|30:183', '', '6', '5', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Pristabell f�r PACKET', 'MODULE_SHIPPING_DHL_PACKET_SE_TABLE', '3:101|4:114|5:120|6:128|7:138|8:147|9:154|10:158|15:177|20:224|25:248|30:275', '', '6', '5', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('L�nder i Europa', 'MODULE_SHIPPING_DHL_EUROPACK_ZON1_COUNTRIES', 'DK,NO,FI', 'ISO2-koder f�r l�nder i zon 1 (exkluderande Sverige). Separera med kommatecken.', '6', '6', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('L�nder i Europa', 'MODULE_SHIPPING_DHL_EUROPACK_ZON2_COUNTRIES', 'NL,BE,LU,DE,EE,LV,LT,GB', 'ISO2-koder f�r l�nder i zon 2 (exkluderande Sverige). Separera med kommatecken.', '6', '6', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('L�nder i Europa', 'MODULE_SHIPPING_DHL_EUROPACK_ZON3_COUNTRIES', 'PL,FR,IE,CH,AT', 'ISO2-koder f�r l�nder i zon 3 (exkluderande Sverige). Separera med kommatecken.', '6', '6', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('L�nder i Europa', 'MODULE_SHIPPING_DHL_EUROPACK_ZON4_COUNTRIES', 'CZ,HU,IT,ES,SI,SK,PT', 'ISO2-koder f�r l�nder i zon 4 (exkluderande Sverige). Separera med kommatecken.', '6', '6', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Viktspecifikation?', 'MODULE_SHIPPING_DHL_EUROPACK_DISPLAYWEIGHT_STATUS', 'Nej', 'Vill du visa antal kollin samt leveransvikt bredvid alternativet (ex 1 x 1.3 kg)? Detta kan vara bra om du vill se vilken vikt osCommerce skickat till modulen.', '6', '7', 'tep_cfg_select_option(array(\'Ja\', \'Nej\'), ', now())");
			tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sortering', 'MODULE_SHIPPING_DHL_EUROPACK_SORT_ORDER', '0', 'Ange plats i modulernas sorteringsordning.', '6', '11', now())");
		}

		function remove() {
			tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
		}

		function keys() {
			return array(
				'MODULE_SHIPPING_DHL_EUROPACK_STATUS',
				'MODULE_SHIPPING_DHL_PACKET_STATUS',
				'MODULE_SHIPPING_DHL_SERVICEPOINT_STATUS',
				'MODULE_SHIPPING_DHL_HANDLING',
				'MODULE_SHIPPING_DHL_EUROPACK_GOGREEN_STATUS',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON1_TABLE',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON2_TABLE',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON3_TABLE',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON4_TABLE',
				'MODULE_SHIPPING_DHL_SERVICEPOINT_SE_TABLE',
				'MODULE_SHIPPING_DHL_PACKET_SE_TABLE',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON1_COUNTRIES',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON2_COUNTRIES',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON3_COUNTRIES',
				'MODULE_SHIPPING_DHL_EUROPACK_ZON4_COUNTRIES',
				'MODULE_SHIPPING_DHL_EUROPACK_DISPLAYWEIGHT_STATUS',
				'MODULE_SHIPPING_DHL_EUROPACK_SORT_ORDER'
			);
		}
	
	}

?>