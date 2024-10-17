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
		// Select products and variants that have not been synced with Shopify yet
		// $proSelect = "SELECT 
		// 	products.id AS product_id,
		// 	products.shop_id,
		// 	products.title AS product_title,
		// 	products.pro_description,
		// 	products.product_status,
		// 	products.product_type,
		// 	products.option_product,
		// 	products.vendor,
		// 	products.tags,
		// 	products.shopify_product_id,
		// 	products.created_at AS product_created_at,
		// 	products.updated_at AS product_updated_at,
		// 	variants.id AS variant_id,
		// 	variants.product_id,
		// 	variants.title AS variant_title,
		// 	variants.price AS variant_price,
		// 	variants.shopify_variant_id,
		// 	variants.created_at AS variant_created_at,
		// 	variants.updated_at AS variant_updated_at
		// FROM 
		// 	products
		// INNER JOIN 
		// 	variants ON products.id = variants.product_id 
		// WHERE products.shopify_product_id = '' 
		// AND variants.shopify_variant_id = '' 
		// LIMIT 1";
	 		$limit = 5;
		    // Select products and variants that have not been synced with Shopify yet
			$proSelect = "SELECT 
			products.id AS product_id,
			products.shop_id,
			products.title AS product_title,
			products.pro_description,
			products.product_status,
			products.product_type,
			products.option_product,
			products.vendor,
			products.tags,
			products.shopify_product_id,
			products.created_at AS product_created_at,
			products.updated_at AS product_updated_at,
			variants.id AS variant_id,
			variants.product_id,
			variants.title AS variant_title,
			variants.price AS variant_price,
			variants.shopify_variant_id,
			variants.created_at AS variant_created_at,
			variants.updated_at AS variant_updated_at
		FROM 
			products
		INNER JOIN 
			variants ON products.id = variants.product_id  
		WHERE 
			variants.shopify_variant_id = ''
		LIMIT $limit"; // Limit to 5 for processing at a time
		$all_product_list = parent::selectTable_f_mdl($proSelect);
		$varTitleArray = [];
		$productOptions = [];
		$variants = [];
		$optionNames = [];
	
		echo '<table border="1" cellpadding="5" cellspacing="0">';
		echo '<tr><th>Product Id</th><th>Product Shop Id</th><th>Product Title</th><th>Product Description</th><th>Product Status</th><th>Product Type</th><th>Product Options</th><th>Product Vendor</th><th>Product Tags</th><th>Shopify Product ID</th><th>Variant Product ID</th><th>Variant Tile</th><th>Variant Price</th><th>Shopify Variant ID</th></tr>';
		// Fetch all product options and variant titles
		foreach ($all_product_list as $key => $value) {
			echo '<tr>';
			echo "<td>" . $value['product_id'] . "</td>";
			echo "<td> " . $value['shop_id'] . "</td>";
			echo "<td>" . $value['product_title']. "</td>";
			echo "<td>" . $value['pro_description']. "</td>";
			echo "<td>" . $value['product_status']. "</td>";
			echo "<td>" . $value['product_type']. "</td>";
			echo "<td>" . $value['option_product']. "</td>";
			echo "<td>" . $value['vendor']. "</td>";
			echo "<td>" . $value['tags']. "</td>";
			echo "<td>" . $value['shopify_product_id']. "</td>";
			echo "<td>" . $value['product_id']. "</td>";
			echo "<td>" . $value['variant_title']. "</td>";
			echo "<td>" . $value['variant_price']. "</td>";
			echo "<td>" . $value['shopify_variant_id']. "</td>";
			echo '</tr>';

			
			$product_title = $value['product_title'];
			$product_desc = $value['pro_description'];
			$product_status = $value['product_status'];
			$product_type = $value['product_type'];
			$product_vendor = $value['vendor'];
			$product_tags = $value['tags'];

			$myStore = $value['shop_id'];
			$StorProductId = $value['shopify_product_id'];
			$variantTitle = $value['shopify_variant_id'];
	
			// Dynamically set option names based on product's `option_product`
			$optionNames = explode(',', $value['option_product']);
	
			// Collect variant titles
			$varTitleArray[] = explode('/', $value['variant_title']);
			$variantPrices[] = $value['variant_price'];
		}
		echo '</table>';
	
		// Initialize arrays to store unique values for each option
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

		
		if($StorProductId != '' && $variantTitle == ""){
			echo "<br><br>";
			$productId = 'gid://shopify/Product/8852608221421'; // Replace with the actual product ID
			// Construct the mutation query for creating product variants in bulk
			$queryBulkCreate = '{
				"query": "mutation productVariantsBulkCreate($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkCreate(productId: $productId, variants: $variants) { userErrors { field message } product { id options { id name values position optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } } }",
				"variables": {
					"productId": "' . $productId . '",
					"variants": ' . json_encode($variants) . '
				}
			}';
			echo $queryBulkCreate;
		}

		if($StorProductId == '' && $variantTitle == ""){
			// Construct the mutation query for creating a product with options
			$queryProductCreate = '{
				"query": "mutation CreateProductWithOptions($input: ProductInput!) { productCreate(input: $input) { userErrors { field message } product { id title description status productType vendor options { id name position values } variants(first: 5) { nodes { id title selectedOptions { name value } } } } } }",
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
			echo $queryProductCreate;
			echo "<br><br>";
			$productId = 'gid://shopify/Product/8852608221421'; // Replace with the actual product ID
			// Construct the mutation query for creating product variants in bulk
			$queryBulkCreate = '{
				"query": "mutation productVariantsBulkCreate($productId: ID!, $variants: [ProductVariantsBulkInput!]!) { productVariantsBulkCreate(productId: $productId, variants: $variants) { userErrors { field message } product { id options { id name values position optionValues { id name hasVariants } } } productVariants { id title selectedOptions { name value } } } }",
				"variables": {
					"productId": "' . $productId . '",
					"variants": ' . json_encode($variants) . '
				}
			}';
			echo $queryBulkCreate;
		}

		// Function to send a GraphQL query and get the response
		//echo $myStore;
		$MyStoresql = "SELECT id, shop, install_token FROM `shop_install_token` WHERE id = '$myStore'";
		//echo $sql;
        $MyStore_list = parent::selectTable_f_mdl($MyStoresql);
        // Include the view (page)
        //include('./pages/addproduct.php');  // Pass the $shops to the view
        if (!empty($MyStore_list)) {
         foreach($MyStore_list as $key => $storevalue){
             $shopToken = $storevalue['install_token'];
         }
        }
		//echo $shopToken;
		function executeGraphQLQuery($query) {
			$url = "https://your-shopify-store.myshopify.com/admin/api/2023-10/graphql.json";
			$headers = [
				"Content-Type: application/json",
				"X-Shopify-Access-Token: $shopToken"
			];

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

			$response = curl_exec($ch);
			curl_close($ch);

			return json_decode($response, true);
		}



		
	}
	
	
	
	
}	
