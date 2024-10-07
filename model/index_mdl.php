<?php
include_once 'model/config.php';

class index_mdl extends config
{
	protected function getSortingSearchResultList_f_mdl($search_type) 
	{
		$sql = "SELECT id, lable, short_code FROM `sorting_search_result_list_module` WHERE type='$search_type'";
		$search_result = parent::selectTable_f_mdl($sql);

		$sorting_search_arr = array();
		if(!empty($search_result)){
			$index = 1;
			foreach($search_result as $key => $sorting_item){
				$sorting_search_arr[] = array(
					'module' => $sorting_item['short_code'],
					'display' => 'show',
					'order' => $index
				);
				$index++;
			}
		}
		return json_encode($sorting_search_arr);
	}

	protected function getSortingDetailData_f_mdl($search_type) 
	{
		$sql = "SELECT id, lable, short_code FROM `sorting_detail_data_module` WHERE type='$search_type'";
		$detail_data = parent::selectTable_f_mdl($sql);

		$sorting_search_arr = array();
		if(!empty($detail_data)){
			$index = 1;
			foreach($detail_data as $key => $sorting_item){
				$sorting_search_arr[] = array(
					'module' => $sorting_item['short_code'],
					'display' => 'show',
					'order' => $index
				);
				$index++;
			}
		}
		return json_encode($sorting_search_arr);
	}
	
	protected function insertShopidInSearchPageSettings_f_mdl($shop_id)
	{
		$purchase_request_message = 'I have a sale for this item. Please send this to me right away.';

		#region - Add Default Settings For GEMSTONE
		$gemstone_module_search_result_data = $this->getSortingSearchResultList_f_mdl('GEMSTONE');
		$gemstone_module_sorting_detail_data = $this->getSortingDetailData_f_mdl('GEMSTONE');

		$gemstone_module_search_result_list = !empty($gemstone_module_search_result_data)?$gemstone_module_search_result_data:'';
		$gemstone_module_detail_data = !empty($gemstone_module_sorting_detail_data)?$gemstone_module_sorting_detail_data:'';

		$mysql = parent::connect();
		mysqli_set_charset($mysql, "utf-8");
		$stmt = $mysql->prepare("INSERT INTO search_page_settings_gemstone(shop_id,module_search_result_list,module_detail_data,purchase_request_message) VALUES(?,?,?,?)");
		$stmt->bind_param("ssss", $shop_id, $gemstone_module_search_result_list, $gemstone_module_detail_data, $purchase_request_message);
		$stmt->execute();
		parent::disconnect($mysql);
		#endregion
	}

}