<?php
include_once 'model/permission_mdl.php';

class permission_ctl extends permission_mdl
{
    public $permission = [];
    function __construct(){
        $this->permission =  $this->getUserPermission();
    }

    public function getUserPermission(){
        if (isset($_SESSION['login_user_id']) && !empty($_SESSION['login_user_id'])){
            $sql1="SELECT id, permission
            FROM `admin_master` where id = " .$_SESSION['login_user_id'];
            $admin = parent::selectTable_f_mdl($sql1);
            if (isset($admin[0]['permission']) && !empty($admin[0]['permission'])) {
                $permission = json_decode($admin[0]['permission']);
                $permission = array_column($permission, 'permission', 'module_shortcode');
                return $permission;
            } else {
                return [];
            }
        }
    }
}
