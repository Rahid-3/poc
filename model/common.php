<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class common{

    const DB_HOST_NAME = "localhost";
    const DB_NAME = "shopify-2k-variants-creation";
    const DB_USERNAME = "root"; 
    const DB_PASSWORD = "";
    const APP_INSTALL_URL = "";
    const APP_NAME = "bulk-product-variants";

 
    public $moduleList = [];
    // public $userPermission = [];
    public function __construct() {
        $this->moduleList[] = ["module_title" => "Admin", "module_shortcode"=>"admin"];
        $this->moduleList[] = ["module_title" => "App logs", "module_shortcode"=>"app_logs"];
        $this->moduleList[] = ["module_title" => "Diamond Shop Installtion", "module_shortcode"=>"diamond_shop_installation"];
        // Start Comment by R Dev
        // $this->moduleList[] = ["module_title" => "main option", "module_shortcode"=>"main_option"];
        // $this->moduleList[] = ["module_title" => "sub option", "module_shortcode"=>"sub_option"];
        // End Comment by R Dev
        $this->moduleList[] = ["module_title" => "product", "module_shortcode"=>"product"];
        $this->moduleList[] = ["module_title" => "addproduct", "module_shortcode"=>"addproduct"];

    }
}
?>