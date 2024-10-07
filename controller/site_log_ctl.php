<?php
include_once 'model/site_log_mdl.php';

class site_log_ctl extends site_log_mdl{

    // construct
    function __construct() {
        /*if(isset($_SESSION['login_user_id']) && !empty($_SESSION['login_user_id'])){
            $user_data = $this->check_user_by_id($_SESSION['login_user_id']);
        }else{
            //below code is set query param in redirect-url. $_SERVER['QUERY_STRING'] is not working due to some reason.
            $qs = '';
            if(isset($_GET) && !empty($_GET)){
                foreach($_GET as $k=>$v){
                    $qs .= $k.'='.$v.'&';
                }
            }
            $qs = trim($qs,'&');

            $_SESSION['REDIRECT_URL'] = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].($qs!=''?'?'.$qs:'');

            header('location:login.php');
            exit;
        }*/

        if(isset($_REQUEST['action'])){
            $action = $_REQUEST['action'];
            if($action=='get_app_logs_list_post'){
                $this->get_app_logs_list_post();exit;
            }
        }
    }

    public function check_user_by_id($id){
        $sql = 'SELECT * FROM `admin_master` WHERE status="1" AND id="'.$id.'"';
        $user_data = parent::selectTable_f_mdl($sql);
        if(isset($user_data) && !empty($user_data)){
            $_SESSION['login_user_id'] = $user_data[0]['id'];
            return $user_data;
        }else{
            session_destroy();
            header('location:login.php');
        }
    }

    public function get_all_admin_dropdown(){
        $sql = 'SELECT id, first_name, last_name FROM `admin_master` WHERE is_super_admin="1" ORDER BY first_name';
        $data = parent::selectTable_f_mdl($sql);
        return $data;
    }
    public function get_all_shop_dropdown(){
        $sql = 'SELECT id, shop_name FROM `shop_management` ORDER BY shop_name';
        $data = parent::selectTable_f_mdl($sql);
        return $data;
    }

    public function rb_get_all_shop_dropdown(){
        $sql = 'SELECT id, shop_name FROM `shop_management` ORDER BY shop_name';
        $data = parent::rb_selectTable_f_mdl($sql);
        return $data;
    }

    public function get_app_logs_list_post(){
        //fixed, no change for any module
        $record_count=0;
        $page=0;
        $current_page=1;
        $rows='10';
        $keyword='';
        if( (isset($_REQUEST['rows']))&&(!empty($_REQUEST['rows'])) ){
            $rows=$_REQUEST['rows'];
        }
        if( (isset($_REQUEST['keyword']))&&(!empty($_REQUEST['keyword'])) ){
            $keyword=$_REQUEST['keyword'];
        }
        if( (isset($_REQUEST['current_page']))&&(!empty($_REQUEST['current_page'])) ){
            $current_page=$_REQUEST['current_page'];
        }
        $start=($current_page-1)*$rows;
        $end=$rows;
        $sort_field = '';
        if(isset($_POST['sort_field']) && !empty($_POST['sort_field'])){
            $sort_field = $_POST['sort_field'];
        }
        $sort_type = '';
        if(isset($_POST['sort_type']) && !empty($_POST['sort_type'])){
            $sort_type = $_POST['sort_type'];
        }
        //end fixed, no change for any module

        $cond_keyword = '';
        if(isset($keyword) && !empty($keyword)){
            $cond_keyword = "AND (
					shop LIKE '%$keyword%'
                )";
        }
        $cond_order = 'ORDER BY id DESC';
        if(!empty($sort_field)){
            $cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
        }

        $cond_user_id = '';
        if(isset($_POST['search_user']) && !empty($_POST['search_user'])){
            $cond_user_id = " AND user_id = '".$_POST['search_user']."'";
        }
        $cond_app = '';
        if(isset($_POST['search_app']) && !empty($_POST['search_app'])){
            $cond_app = " AND app = '".$_POST['search_app']."'";
        }
        $cond_shop = '';
        if(isset($_POST['search_shop']) && !empty($_POST['search_shop'])){
            $cond_shop = " AND shop = '".$_POST['search_shop']."'";
        }
        $cond_operation = '';
        if(isset($_POST['search_operation']) && !empty($_POST['search_operation'])){
            $cond_operation = " AND operation = '".$_POST['search_operation']."'";
        }

        $sql="
                SELECT count(id) as count
                FROM `admin_site_log`
                WHERE 1
                $cond_keyword
                $cond_user_id
                $cond_app
                $cond_shop
                $cond_operation
            ";
        $all_count = parent::selectTable_f_mdl($sql);

        $sql1="
                SELECT admin_site_log.id, shop, app, operation, module, log_message, payload, admin_site_log.created_on, ipaddress, first_name, last_name
                FROM `admin_site_log`
                LEFT JOIN admin_master ON admin_master.id = admin_site_log.user_id
                WHERE 1
                $cond_keyword
                $cond_user_id
                $cond_app
                $cond_shop
                $cond_operation

                $cond_order
                LIMIT $start,$end
            ";
        $all_list = parent::selectTable_f_mdl($sql1);

        if( (isset($all_count[0]['count']))&&(!empty($all_count[0]['count'])) ){
            $record_count=$all_count[0]['count'];
            $page=$record_count/$rows;
            $page=ceil($page);
        }
        $sr_start=0;
        if($record_count>=1){
            $sr_start=(($current_page-1)*$rows)+1;
        }
        $sr_end=($current_page)*$rows;
        if($record_count<=$sr_end){
            $sr_end=$record_count;
        }

        if(isset($_POST['pagination_export']) && $_POST['pagination_export']=='Y'){
            /*if(isset($all_list) && !empty($all_list)){
                $date_formate=Config::get('constant.DATE_FORMATE');
                $file_full_path = public_path().Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv";
                $file_full_url = asset(Config::get('constant.DOWNLOAD_TABLE_LOCATION')."downloaded_table_".time().".csv");
                $file_for_download_data = fopen($file_full_path,"w");
                fputcsv($file_for_download_data,array('#','Name','Email','Mobile','Add Date'));
                $i=$sr_start;
                foreach ($all_list as $single){
                    if($single->add_date!=''){
                        $add_date = date($date_formate, $single->add_date);
                    }else{
                        $add_date = '';
                    }
                    fputcsv($file_for_download_data,array(
                        $i,
                        $single->first_name.' '.$single->last_name,
                        $single->email,
                        $single->mobile,
                        $add_date
                    ));
                    $i++;
                }
                fclose($file_for_download_data);
                $this->param['SUCCESS']='TRUE';
                $this->param['file_full_url']=$file_full_url;
            }else{
                $this->param['SUCCESS']='FALSE';
            }
            echo json_encode($this->param,1);*/
        }
        else{
            $html = '';
            $html .= '<div class="row">';
            $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-bordered table-hover">';

            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>#</th>';
            $html .= '<th>User</th>';
            $html .= '<th>App</th>';
            $html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
            $html .= '<th>Operation</th>';
            $html .= '<th>Module</th>';
            $html .= '<th>IP Address</th>';
            $html .= '<th>Date</th>';
            $html .= '</tr>';
            $html .= '</thead>';

            $html .= '<tbody>';

            if(!empty($all_list)){
                $sr = $sr_start;
                foreach($all_list as $single){
                    $html .= '<tr>';
                    $html .= '<td>'.$sr.'</td>';
                    $html .= '<td>'.$single['first_name'].' '.$single['last_name'].'</td>';
                    $html .= '<td>'.$single['app'].'</td>';
                    $html .= '<td>'.$single['shop'].'</td>';
                    $html .= '<td>'.$single['operation'].'</td>';
                    $html .= '<td>'.$single['module'].'</td>';
                    $html .= '<td>'.$single['ipaddress'].'</td>';
                    $html .= '<td>'.($single['created_on']!=''?date('d M Y',strtotime($single['created_on'])):'').'</td>';
                    $html .= '</tr>';
                    $sr++;
                }
            }else{
                $html .= '<tr>';
                $html .= '<td colspan="8" align="center">No Record Found</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            $res['DATA'] = $html;
            $res['page_count'] = $page;
            $res['record_count']=$record_count;
            $res['sr_start']=$sr_start;
            $res['sr_end']=$sr_end;
            echo json_encode($res,1);
        }
    }

    public function insert_log($shop, $app, $operation, $module, $updated_fields='', $log_message='', $payload=[], $login_user_id='') {
        if ($this->debugMode == false) {
            return true;
        }
        $this->shop = $shop;
        $this->app = $app;
        $this->user_id = !empty($login_user_id) ? $login_user_id : @$_SESSION['login_user_id'];
        $this->operation = $operation;
        $this->module = $module;
        $this->updated_fields = $updated_fields;
        $this->log_message = $log_message;
        $this->payload = !empty($payload)?json_encode($payload,1):"";
        $this->created_on = date('Y-m-d H:i:s');
        $this->ipaddress = $_SERVER['REMOTE_ADDR'];
        $this->insertLog();
    }

}
 