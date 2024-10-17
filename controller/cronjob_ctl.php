<?php
include_once 'model/cronjob_mdl.php';

class cronjob_ctl extends cronjob_mdl
{
	private static $site_log;

	function __construct()
	{
		
		if (isset($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
			if ($action == 'createshopifyproduct') {
				$this->createshopifyproduct();
				exit;
			} 
		}
	}

	public function createshopifyproduct() {
		$limit = 1;
		$proSelect  = "SELECT id, shop_id, title, pro_description, product_status, product_type, option_product, vendor, tags, shopify_product_id FROM `products` where shopify_product_id = '' LIMIT $limit";
		$all_product_list = parent::selectTable_f_mdl($proSelect);
		$varTitleArray = [];
		$productOptions = [];
		$variants = [];
		$optionNames = [];
		foreach ($all_product_list as $key => $productValue) {
			$prtoductTbl_id = $productValue['id'];
			$shop_id = $productValue['shop_id'];
			$product_title = $productValue['title'];
			$product_desc = $productValue['pro_description'];
			$product_status = $productValue['product_status'];
			$product_type = $productValue['product_type'];
			$product_vendor = $productValue['vendor'];
			$product_tags = $productValue['tags'];
			$shopify_product_id = $productValue['shopify_product_id'];

			//$option_product = $value['option_product'];
			$optionNames = explode(',', $productValue['option_product']);
			// Initialize arrays to store unique values for each option
			

			// $variantSelect = "SELECT id, product_id, title, price, shopify_variant_id FROM `variants` where product_id = '$prtoductTbl_id'";
			// $all_variant_list = parent::selectTable_f_mdl($variantSelect);
			// echo '<pre>';
			// print_r($all_variant_list);
			// echo '</pre>';
		}
		echo '<pre>';
			print_r($all_product_list);
			echo '</pre>';
		$variantSelect = "SELECT id, product_id, title, price, shopify_variant_id FROM `variants` where product_id = '$prtoductTbl_id'";
		$all_variant_list = parent::selectTable_f_mdl($variantSelect);
		foreach ($all_variant_list as $key => $variantValue) {
			$varTitleArray[] = explode('/', $variantValue['title']);
			$variantPrices[] = $variantValue['price'];
		}
		// echo '<pre>';
		// 	print_r($all_variant_list);
		// 	echo '</pre>';
		$uniqueOptions = [
			$optionNames[0] => [],
			$optionNames[1] => [],
			$optionNames[2] => []
		];

		// Build product options and avoid repetition of values
		foreach ($varTitleArray as $variantTitles) {
			// Add unique values for the first option (e.g., Size)
			if (!in_array(['name' => trim($variantTitles[0])], $uniqueOptions[$optionNames[0]])) {
				$uniqueOptions[$optionNames[0]][] = ['name' => trim($variantTitles[0])];
			}
	
			// Add unique values for the second option (e.g., Color)
			if (!in_array(['name' => trim($variantTitles[1])], $uniqueOptions[$optionNames[1]])) {
				$uniqueOptions[$optionNames[1]][] = ['name' => trim($variantTitles[1])];
			}
	
			// Add unique values for the third option (e.g., Material)
			if (!in_array(['name' => trim($variantTitles[2])], $uniqueOptions[$optionNames[2]])) {
				$uniqueOptions[$optionNames[2]][] = ['name' => trim($variantTitles[2])];
			}
		}
	
		// Create product options for Shopify mutation
		$productOptions = [
			["name" => trim($optionNames[0]), "values" => $uniqueOptions[$optionNames[0]]],
			["name" => trim($optionNames[1]), "values" => $uniqueOptions[$optionNames[1]]],
			["name" => trim($optionNames[2]), "values" => $uniqueOptions[$optionNames[2]]]
		];
		// Assign first array element's name and values to variables
		$firstOptionName = $productOptions[0]['name'];
		$firstOptionValues = $productOptions[0]['values'][0]['name'];
		// Output the result
		echo "<br>";
		echo "First Option Name: " . $firstOptionName . "<br>";
		echo "First Option Values: " . $firstOptionValues . "<br>";
		// Prepare variant data
		foreach ($varTitleArray as $index => $combination) {
			
			$variants[] = [
				'optionValues' => [
					['name' => trim($combination[0]), 'optionName' => trim($optionNames[0])],
					['name' => trim($combination[1]), 'optionName' => trim($optionNames[1])],
					['name' => trim($combination[2]), 'optionName' => trim($optionNames[2])],
				],
				'price' => $variantPrices[$index]
			];
		}


		// Construct the mutation query for creating a product with options
		$queryProductCreate = '{
			"query": "mutation CreateProductWithOptions($input: ProductInput!) { productCreate(input: $input) { userErrors { field message } product { id variants(first: 1) { nodes { id } } } } }",
			"variables": {
				"input": {
					"title": "' . $product_title . '",
					"descriptionHtml": "' . $product_desc . '",
					"status": "' . $product_status . '",  
					"productType": "' . $product_type . '",
					"vendor": "' . $product_vendor . '",
					"tags": "' . $product_tags . '",
					"productOptions": ' . json_encode($productOptions) . '
				}
			}
		}';
		//echo $queryProductCreate;

		/*
		$productId = 'gid://shopify/Product/8852608221421'; // Replace with the actual product ID
		$standAlonVarinat = 'gid://shopify/ProductVariant/47240259404013'; // Replace with the actual first variant ID
		$OptionTempName = "Temp1"; // First variant option value temprory change to avoid duplicate product variant error
		$OptionTempValue = ""; // product created in Store first Option value
		// Construct the mutation query for creating product variants in bulk
		$queryBulkCreate = '{
			"query": "mutation productVariantsBulkCreate($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkCreate(productId: $productId, variants: $variants) { userErrors { field message } product { id options { id name values position optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } } }",
			"variables": {
				"productId": "' . $productId . '",
				"variants": ' . json_encode($variants) . '
			}
		}';

		$productVariantsUpdate = '{
			"query": "mutation UpdateProductVariantsOptionValuesInBulk($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkUpdate(productId: $productId, variants: $variants) { product { id title options { id position name values optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } userErrors { field message } } }",
			"variables": {
				"productId": "gid://shopify/Product/8853051474157",
				"variants": [
				{
					"id": "'.$standAlonVarinat.'",
					"optionValues": [
					{
						"name": "'.$OptionTempName.'",
						"optionName": "'.$OptionTempValue.'"
					}
					]
				}
				]
			}
			}';

			$productDeleteFirstVariant = '{
			"query": "mutation productVariantsBulkDelete($productId: ID!, $variantsIds: [ID!]!) { productVariantsBulkDelete(productId: $productId, variantsIds: $variantsIds) { product { id } userErrors { field message } } }",
			"variables": {
				"productId": "' . $productId . '",
				"variantsIds": [
				"'.$standAlonVarinat.'"
				]
			}
			}';
			*/
			
			// Fetch store information
			$MyStoresql = "SELECT id, shop, install_token FROM `shop_install_token` WHERE id = '$shop_id'";
			$MyStore_list = parent::selectTable_f_mdl($MyStoresql);
			//$bulkTile = [];
			if (!empty($MyStore_list)) {
				foreach($MyStore_list as $key => $storevalue){
					$shopToken = $storevalue['install_token'];
					$myshopURL = $storevalue['shop'];
				}
				
				$newURLs = "https://".$myshopURL."/admin/api/2024-10/graphql.json";

				// Define the function to execute the GraphQL query
				function executeGraphQLQuery($url, $shopToken, $query) {
					$headers = [
						"Content-Type: application/json",
						"X-Shopify-Access-Token: $shopToken"
					];

					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

					$response = curl_exec($ch);

					if(curl_errno($ch)) {
						echo 'Curl error: ' . curl_error($ch);
					}

					curl_close($ch);

					return json_decode($response, true);
				}

				// Start Product Execute query with all Option and values
				$ProductCreateResponse = executeGraphQLQuery($newURLs, $shopToken, $queryProductCreate);

				// Handle and display errors or result
				if (isset($ProductCreateResponse['errors'])) {
					echo "GraphQL errors: ";
					print_r($ProductCreateResponse['errors']);
				} else {
					//echo "Product creation response: <br>";
					//print_r($ProductCreateResponse);
					//echo $ProductCreateResponse;
					//$getProductandVariantID = json_decode($ProductCreateResponse, true);
					$productIdNew = $ProductCreateResponse['data']['productCreate']['product']['id'];
					$standAlonVarinatNew = $ProductCreateResponse['data']['productCreate']['product']['variants']['nodes'][0]['id'];

				}
				// End Product Execute query with all Option and values

				$productId = $productIdNew; // Replace with the actual product ID
				$standAlonVarinat = $standAlonVarinatNew; // Replace with the actual first variant ID
				$OptionTempName = "Temp1"; // First variant option value temprory change to avoid duplicate product variant error
				$OptionTempValue = $firstOptionName; // product created in Store first Option value
				// Update first variant option value
				$productVariantsUpdate = '{
					"query": "mutation UpdateProductVariantsOptionValuesInBulk($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkUpdate(productId: $productId, variants: $variants) { product { id title options { id position name values optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } userErrors { field message } } }",
					"variables": {
						"productId": "'.$productId.'",
						"variants": [
						{
							"id": "'.$standAlonVarinat.'",
							"optionValues": [
							{
								"name": "'.$OptionTempName.'",
								"optionName": "'.$OptionTempValue.'"
							}
							]
						}
						]
					}
					}';

					$updateResponse = executeGraphQLQuery($newURLs, $shopToken, $productVariantsUpdate);
    
					// Handle the response for variant update
					if (isset($updateResponse['errors'])) {
						echo "Error updating variant: ";
						print_r($updateResponse['errors']);
					} else {
						echo "Variant updated successfully!";
					}

				// Construct the mutation query for creating product variants in bulk
				$queryBulkCreate = '{
					"query": "mutation productVariantsBulkCreate($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkCreate(productId: $productId, variants: $variants) { userErrors { field message } product { id options { id name values position optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } } }",
					"variables": {
						"productId": "' . $productId . '",
						"variants": ' . json_encode($variants) . '
					}
				}';
				$bulkCreateResponse = executeGraphQLQuery($newURLs, $shopToken, $queryBulkCreate);
    
				// Handle the response for bulk creation
				if (isset($bulkCreateResponse['errors'])) {
					echo "Error creating bulk variants: ";
					print_r($bulkCreateResponse['errors']);
				} else {
					echo "<br>Bulk variants created successfully!<br>";
					//print_r($bulkCreateResponse);
					//$bulkTile = $bulkCreateResponse['data']['productVariantsBulkCreate']['product']['productVariants'];
					//$productVariants = $array['data']['productVariantsBulkCreate']['product']['productVariants'];
				}
				// Delete the first variant
				$productDeleteFirstVariant = '{
				"query": "mutation productVariantsBulkDelete($productId: ID!, $variantsIds: [ID!]!) { productVariantsBulkDelete(productId: $productId, variantsIds: $variantsIds) { product { id } userErrors { field message } } }",
				"variables": {
					"productId": "' . $productId . '",
					"variantsIds": [
					"'.$standAlonVarinat.'"
					]
				}
				}';
				$deleteResponse = executeGraphQLQuery($newURLs, $shopToken, $productDeleteFirstVariant);
    
				// Handle the response for variant deletion
				if (isset($deleteResponse['errors'])) {
					echo "Error deleting first variant: ";
					print_r($deleteResponse['errors']);
				} else {
					echo "First variant deleted successfully!";
				}

				echo '<pre>';
				print_r($bulkCreateResponse);
				echo '</pre>';

				echo "<br><br><br>";

				// Variant Table: VarientID Update in the local db 
				//$productVariants = $array['data']['productVariantsBulkCreate']['productVariants'];
				$updated_at = date('Y-m-d H:i:s');
				foreach ($bulkCreateResponse['data']['productVariantsBulkCreate']['productVariants'] as $variant) {
					$shopify_variant_id = $variant['id']; // Get each variant ID
					$Variantupdate_data = [
						'shopify_variant_id' => $shopify_variant_id,
						'updated_at' => $updated_at
					];

					$Variantwhere_condition = 'title = "' . $variant['title']. '"'; // Ensure $productID corresponds to the correct product
					
					$result = parent::updateTable_f_mdl('variants', $Variantupdate_data, $Variantwhere_condition);

					if ($result) {
						echo "Update successful for variant <br>";
					} else {
						echo "Update failed for variant <br>";
					}
				}
				//Product Table: ProductID  Update in the local db
				$Productupdate_data = [
					'shopify_product_id' => $productId,
					'updated_at' => $updated_at
				];
				//echo var_dump($update_data);
				$Productwhere_condition = 'id = ' . intval($prtoductTbl_id);

				// Call the method to perform the update
				$Productresult = parent::updateTable_f_mdl('products', $Productupdate_data, $Productwhere_condition);
				if ($Productresult) {
					echo "Update successful for variant ID: $productId.<br>";
				} else {
					echo "Update failed for variant ID: $productId.<br>";
				}


			} else {
				echo "No store found with ID: $shop_id";
			}

		
	}
	
	
	
	
}	
