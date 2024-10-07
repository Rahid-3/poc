<?php include_once("model/common.php");

	session_start();
	ob_start();
	if(isset($_GET["stkn"]) || isset($_GET["sp_nm"]))
	{
		/*$sessionName = common::STORE_LOGIN_SESSION_FIRST_KEY.$_GET["stkn"];
		unset($_SESSION[$sessionName]);*/
		
		session_unset(); 
		session_destroy();
		
		if(isset($_GET["sp_nm"])){
			header("location:/login.php?shop=".$_GET["sp_nm"]);
			exit;
		}
		else{
			header("location:/login.php");
			exit;
		}
	}
	else
	{
		session_unset(); 
		session_destroy();
	}
	header("location:/login.php");
	exit;
?>