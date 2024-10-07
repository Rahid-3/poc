<?php
session_start();
ob_start();

include_once 'common.php';

class config extends common
{
	private $hostName = common::DB_HOST_NAME;
	private $dbName = common::DB_NAME;
	private $userName = common::DB_USERNAME;
	private $password = common::DB_PASSWORD;


	public function sanitize($string) {
		$string = filter_var($string, FILTER_SANITIZE_STRING);
		$string = trim($string);
		$string = stripslashes($string);
		$string = strip_tags($string);
		$string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);

		$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		$string = strtr( $string, $unwanted_array );

		$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $string);

		return $string;
	}
	function handlize($string){
		$handle = $string;

		$handle = trim($handle);
		$handle = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $handle);//remove non pritable characters
		$handle = str_replace(' ', '-', $handle); // Replaces all spaces with hyphens.
		$handle = preg_replace('/[^A-Za-z0-9\-]/', '', $handle);//remove all symbols
		$handle = strtolower($handle);  //convert to lower case

		checkDblHyphen:
		if (strpos($handle, '--') !== false) {
			$handle = str_replace('--', '-', $handle); // Replaces all -- with -.
			goto checkDblHyphen;
		}

		return $handle;
	}
	
	protected function connect(){
		return mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);
	}
	protected function disconnect($link){
		$link->close();
	}
	public function getShopCredentials_f_mdl($shop,$isReturn=false){
		$mysql = $this->connect();

		$resultArray = array();

		$sql = "SELECT shop_name, token
		FROM `shop_management`
		WHERE shop_name='".$shop."'
		";
		$stmt = $mysql->prepare($sql);

		//$stmt->bind_param("is", $this->master_collections_id, $this->customer_id);

		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0){
			$stmt->bind_result($shop_name, $token);
			while($stmt->fetch()){
				$innerArray = array();
				$innerArray["shop_name"] = $shop_name;
				$innerArray["token"] = $token;
				$resultArray[] = $innerArray;
			}

			$stmt->free_result();
		}

		$stmt->close();
		$this->disconnect($mysql);
		if($isReturn){
			return $resultArray;
		}else{
			common::sendJson($resultArray);
		}
	}
	public function selectTable_f_mdl($sql){
		$mysql = $this->connect();
		$resultArray = array();
		if($GetResult = $mysql->query($sql)) {
			while($row = mysqli_fetch_assoc($GetResult)){
				$resultArray[] = $row;
			}
			$GetResult->free();
		}
		$this->disconnect($mysql);
		return $resultArray;
	}
	public function selectSingleTable_f_mdl($sql){
		$mysql = $this->connect();
		$resultArray = array();
		if($GetResult = $mysql->query($sql)) {
			while($row = mysqli_fetch_assoc($GetResult)){
				$resultArray[] = $row;
			}
			$GetResult->free();
		}
		$this->disconnect($mysql);
		return $resultArray;
	}
	public function insertTable_f_mdl($table,$data){
		$mysql = $this->connect();
		$resultArray = array();

		$q = "INSERT INTO `" . $table . "` ";
		$v = '';
		$k = '';
		foreach ($data as $key => $val) :
			$val = str_replace("'","\'",$val);
			$k .= "`$key`, ";
			if (strtolower($val) == 'null')
				$v .= "NULL, ";
			elseif (strtolower($val) == 'now()')
				$v .= "NOW(), ";
			else
				$v .= "'" . $val . "', ";
		endforeach;
		$q .= "(" . rtrim($k, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
		$stmt = $mysql->prepare($q);
		$stmt->execute();
		$stmt->free_result();
		if($mysql->insert_id > 0) {
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Inserted successfully.";
			$resultArray["insert_id"] = $mysql->insert_id;
		}
		else {
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! There was some issues. Please try again after sometime or refresh page.";
		}
		$stmt->close();
		$this->disconnect($mysql);
		return $resultArray;
	}
	public function updateTable_f_mdl($table,$data,$where){
		$mysql = $this->connect();
		$resultArray = array();

		$q = "UPDATE `" . $table . "` SET ";
		foreach ($data as $key => $val) :
			$val = str_replace("'","",$val);
			if (strtolower($val) == 'null')
				$q .= "`$key` = NULL, ";
			elseif (strtolower($val) == 'now()')
				$q .= "`$key` = NOW(), ";
			elseif (strtolower($val) == 'default()')
				$q .= "`$key` = DEFAULT($val), ";
			elseif (preg_match("/^inc\((\-?[\d\.]+)\)$/i", $val, $m))
				$q.= "`$key` = `$key` + $m[1], ";
			else
				$q .= "`$key`='" . $val . "', ";
		endforeach;
		$q = rtrim($q, ', ') . ' WHERE ' . $where . ';';

		$stmt = $mysql->prepare($q);
		//$stmt->bind_param("siii", $this->brand_name, $this->status, $this->id, $this->SHOP_ID);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Changes saved successfully.";
		} else{
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! you haven't update anything.";
		}
		$this->disconnect($mysql);
		return $resultArray;
	}
	public function deleteTable_f_mdl($table, $where = '') {
		$mysql = $this->connect();
		$resultArray = array();

		$q = !$where ? 'DELETE FROM ' . $table : 'DELETE FROM ' . $table . ' WHERE ' . $where;
		$stmt = $mysql->prepare($q);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Deleted successfully.";
		} else{
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! you haven't delete anything.";
		}
		$this->disconnect($mysql);
		return $resultArray;
	}

	protected function rb_connect(){
		return mysqli_connect($this->rb_hostName, $this->rb_userName, $this->rb_password, $this->rb_dbName);
	}
	protected function rb_disconnect($link){
		$link->close();
	}
	public function rb_getShopCredentials_f_mdl($shop,$isReturn=false){
		$mysql = $this->rb_connect();

		$resultArray = array();

		$sql = "SELECT shop_name, token
		FROM `shop_management`
		WHERE shop_name='".$shop."'
		";
		$stmt = $mysql->prepare($sql);

		//$stmt->bind_param("is", $this->master_collections_id, $this->customer_id);

		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0){
			$stmt->bind_result($shop_name, $token);
			while($stmt->fetch()){
				$innerArray = array();
				$innerArray["shop_name"] = $shop_name;
				$innerArray["token"] = $token;
				$resultArray[] = $innerArray;
			}

			$stmt->free_result();
		}

		$stmt->close();
		$this->rb_disconnect($mysql);
		if($isReturn){
			return $resultArray;
		}else{
			common::sendJson($resultArray);
		}
	}
	public function rb_selectTable_f_mdl($sql){
		$mysql = $this->rb_connect();
		$resultArray = array();
		if($GetResult = $mysql->query($sql)) {
			while($row = mysqli_fetch_assoc($GetResult)){
				$resultArray[] = $row;
			}
			$GetResult->free();
		}
		$this->rb_disconnect($mysql);
		return $resultArray;
	}
	public function rb_insertTable_f_mdl($table,$data){
		$mysql = $this->rb_connect();
		$resultArray = array();

		$q = "INSERT INTO `" . $table . "` ";
		$v = '';
		$k = '';
		foreach ($data as $key => $val) :
			$val = str_replace("'","\'",$val);
			$k .= "`$key`, ";
			if (strtolower($val) == 'null')
				$v .= "NULL, ";
			elseif (strtolower($val) == 'now()')
				$v .= "NOW(), ";
			else
				$v .= "'" . $val . "', ";
		endforeach;
		$q .= "(" . rtrim($k, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
		$stmt = $mysql->prepare($q);
		$stmt->execute();
		$stmt->free_result();
		if($mysql->insert_id > 0) {
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Inserted successfully.";
			$resultArray["insert_id"] = $mysql->insert_id;
		}
		else {
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! There was some issues. Please try again after sometime or refresh page.";
		}
		$stmt->close();
		$this->rb_disconnect($mysql);
		return $resultArray;
	}
	public function rb_updateTable_f_mdl($table,$data,$where){
		$mysql = $this->rb_connect();
		$resultArray = array();

		$q = "UPDATE `" . $table . "` SET ";
		foreach ($data as $key => $val) :
			$val = str_replace("'","",$val);
			if (strtolower($val) == 'null')
				$q .= "`$key` = NULL, ";
			elseif (strtolower($val) == 'now()')
				$q .= "`$key` = NOW(), ";
			elseif (strtolower($val) == 'default()')
				$q .= "`$key` = DEFAULT($val), ";
			elseif (preg_match("/^inc\((\-?[\d\.]+)\)$/i", $val, $m))
				$q.= "`$key` = `$key` + $m[1], ";
			else
				$q .= "`$key`='" . $val . "', ";
		endforeach;
		$q = rtrim($q, ', ') . ' WHERE ' . $where . ';';
		
		$stmt = $mysql->prepare($q);
		//$stmt->bind_param("siii", $this->brand_name, $this->status, $this->id, $this->SHOP_ID);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Changes saved successfully.";
		} else{
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! you haven't update anything.";
		}
		$this->rb_disconnect($mysql);
		return $resultArray;
	}
	public function rb_deleteTable_f_mdl($table, $where = '') {
		$mysql = $this->rb_connect();
		$resultArray = array();

		$q = !$where ? 'DELETE FROM ' . $table : 'DELETE FROM ' . $table . ' WHERE ' . $where;
		$stmt = $mysql->prepare($q);
		$stmt->execute();
		if($stmt->affected_rows > 0){
			$resultArray["isSuccess"] = "1";
			$resultArray["msg"] = "Deleted successfully.";
		} else{
			$resultArray["isSuccess"] = "0";
			$resultArray["msg"] = "Oops! you haven't delete anything.";
		}
		$this->rb_disconnect($mysql);
		return $resultArray;
	}



}
?>