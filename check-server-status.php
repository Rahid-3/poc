<?php
	include 'model/config.php';
	$config = new Config();

	try {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => common::HL_APP_INSTALL_URL.'server-status.php',
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 10,
		  	CURLOPT_CONNECTTIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => false,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "GET",
		  	CURLOPT_HTTPHEADER => array(),
		));
		
		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get Status code like 200
		$curl_errno = curl_errno($curl);
		$curl_error = curl_error($curl);
		curl_close($curl);
	
		$headers = apache_request_headers();
		if ($curl_errno > 0) {
			$status = 'Down';
			$message = $curl_error;
		} else {
			$status = 'Active';
			$message = $response;
		}

		$app_health = $config->hl_getAppHealth_f_mdl();
		$updateRes = $config->hl_updateTable_f_mdl('app_health', array('status' => $status), 'app_slug="local-vdb-app-v2-new-html"');
		if ($updateRes['isSuccess'] == 1) {
			$data = array( 'app_id' => $app_health['id'], 'status' => $status, 'reason' => $message);
			$config->hl_insertTable_f_mdl('app_logs', $data);
		}
	} catch (\Throwable $e) {
		echo'<pre>';
		print_r($e);
		exit();
	}
?>