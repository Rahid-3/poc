<?php
include_once 'model/config.php';

class site_log_mdl extends config
{
    // parameters
    public $id = '';
    public $shop = '';
    public $app = '';
    public $user_id = '';
    public $operation = '';
    public $module = '';
    public $updated_fields = '';
    public $log_message = '';
    public $is_deleted = '';
    public $payload = '';
    public $created_on = '';
    public $debugMode = true;
    public $ipaddress = '';

    public function insertLog(){
        $mysql = parent::connect();
		$stmt = $mysql->prepare("INSERT INTO admin_site_log(app,shop,user_id, operation, module, updated_fields, log_message, payload, created_on, ipaddress) VALUES(?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("ssisssssss", $this->app, $this->shop, $this->user_id, $this->operation, $this->module, $this->updated_fields, $this->log_message, $this->payload, $this->created_on, $this->ipaddress);
		$stmt->execute();
		parent::disconnect($mysql);
	}
}