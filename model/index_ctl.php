<?php
include_once 'model/index_mdl.php';

class index_ctl extends index_mdl
{
	function __construct(){
		//first we check user login or not, otherwise redirect to login page
		global $user_data;
		if(isset($_SESSION['login_user_id']) && !empty($_SESSION['login_user_id'])){
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
		}

		if(isset($_REQUEST['action'])){
			$action = $_REQUEST['action'];
			if($action=='edit_profile_personal_details_post'){
				$this->edit_profile_personal_details_post();exit;
			}else if($action=='edit_profile_change_password_post'){
				$this->edit_profile_change_password_post();exit;
			}else if($action=='admin_logout'){
				$this->admin_logout();exit;
			}else if($action=='get_shop_installation_list_post'){
				$this->get_shop_installation_list_post();exit;
			}else if($action=='add_new_shop_install_token_post'){
				$this->add_new_shop_install_token_post();exit;
			}else if($action=='get_page_permission_list_post'){
				$this->get_page_permission_list_post();exit;
			}else if($action=='change_permission_status'){
				$this->change_permission_status();exit;
			}else if($action=='edit_shop_app_labels_post'){
				$this->edit_shop_app_labels_post();exit;
			}else if($action=='edit_shop_details'){
				$this->edit_shop_details();exit;
			}else if($action=='get_language_list_post'){
				$this->get_language_list_post();exit;
			}else if($action=='change_language_status'){
				$this->change_language_status();exit;
			}else if($action=='add_new_language_post'){
				$this->add_new_language_post();exit;
			}else if($action=='get_label_list_post'){
				$this->get_label_list_post();exit;
			}else if($action=='language_label_text_post'){
				$this->language_label_text_post();exit;
			}

			else if($action=='gs_get_shop_installation_list_post'){
				$this->gs_get_shop_installation_list_post();exit;
			}else if($action=='gs_add_new_shop_install_token_post'){
				$this->gs_add_new_shop_install_token_post();exit;
			}else if($action=='gs_get_page_permission_list_post'){
				$this->gs_get_page_permission_list_post();exit;
			}else if($action=='gs_change_permission_status') {
				$this->gs_change_permission_status();exit;
			}else if($action=='gs_edit_shop_details'){
				$this->gs_edit_shop_details();exit;
			}else if($action=='gs_get_label_list_post'){
				$this->gs_get_label_list_post();exit;
			}else if($action=='gs_language_label_text_post'){
				$this->gs_language_label_text_post();exit;
			}

			else if($action=='rb_get_shop_installation_list_post'){
				$this->rb_get_shop_installation_list_post();exit;
			}else if($action=='rb_add_new_shop_install_token_post'){
				$this->rb_add_new_shop_install_token_post();exit;
			}else if($action=='rb_get_page_permission_list_post'){
				$this->rb_get_page_permission_list_post();exit;
			}else if($action=='rb_change_permission_status') {
				$this->rb_change_permission_status();exit;
			}else if($action=='rb_edit_shop_details'){
				$this->rb_edit_shop_details();exit;
			}else if($action=='rb_get_label_list_post'){
				$this->rb_get_label_list_post();exit;
			}else if($action=='rb_language_label_text_post'){
				$this->rb_language_label_text_post();exit;
			}else if($action=='tile_3d_cb'){
				$this->tile_3d_cb();exit;
			}

			else if($action=='rb_add_edit_radiance_type_post'){
				$this->rb_add_edit_radiance_type_post();exit;
			}else if($action=='rb_radiance_type_display_change'){
				$this->rb_radiance_type_display_change();exit;
			}else if($action=='rb_change_radiance_type_order'){
				$this->rb_change_radiance_type_order();exit;
			}

			else if($action=='rb_add_edit_radiance_color_post'){
				$this->rb_add_edit_radiance_color_post();exit;
			}else if($action=='rb_radiance_color_display_change'){
				$this->rb_radiance_color_display_change();exit;
			}else if($action=='rb_get_color_by_type'){
				$this->rb_get_color_by_type();exit;
			}else if($action=='rb_change_radiance_color_order'){
				$this->rb_change_radiance_color_order();exit;
			}else if($action=='rb_get_shape_by_type'){
				$this->rb_get_shape_by_type();exit;
			}
			
			else if($action=='rb_add_edit_radiance_subshape_post'){
				$this->rb_add_edit_radiance_subshape_post();exit;
			}else if($action=='rb_radiance_subshape_display_change'){
				$this->rb_radiance_subshape_display_change();exit;
			}else if($action=='rb_get_subshape_by_shape'){
				$this->rb_get_subshape_by_shape();exit;
			}else if($action=='rb_change_radiance_subshape_order'){
				$this->rb_change_radiance_subshape_order();exit;
			}

			else if($action=='rb_add_edit_radiance_shape_post'){
				$this->rb_add_edit_radiance_shape_post();exit;
			}else if($action=='rb_radiance_shape_display_change'){
				$this->rb_radiance_shape_display_change();exit;
			}else if($action=='rb_change_radiance_shape_order'){
				$this->rb_change_radiance_shape_order();exit;
			}

			else if($action=='rb_add_edit_ring_size_chart_post'){
				$this->rb_add_edit_ring_size_chart_post();exit;
			}else if($action=='rb_change_ring_size_chart_order'){
				$this->rb_change_ring_size_chart_order();exit;
			}

			else if($action=='rb_add_edit_title_alter_post'){
				$this->rb_add_edit_title_alter_post();exit;
			}else if($action=='rb_delete_title_alter_post'){
				$this->rb_delete_title_alter_post();exit;
			}

			else if($action=='rb_delete_radiance_type'){
				$this->rb_delete_radiance_type();exit;
			}else if($action=='rb_delete_radiance_color'){
				$this->rb_delete_radiance_color();exit;
			}else if($action=='rb_delete_radiance_shape'){
				$this->rb_delete_radiance_shape();exit;
			}else if($action=='rb_delete_radiance_subshape'){
				$this->rb_delete_radiance_subshape();exit;
			}

			else if($action=='jl_get_shop_installation_list_post'){
				$this->jl_get_shop_installation_list_post();exit;
			}else if($action=='jl_add_new_shop_install_token_post'){
				$this->jl_add_new_shop_install_token_post();exit;
			}else if($action=='jl_variant_change_permission_status'){
				$this->jl_variant_change_permission_status();exit;
			}else if($action=='jl_get_page_permission_list_post'){
				$this->jl_get_page_permission_list_post();exit;
			}

			else if($action=='dl_get_shop_installation_list_post'){
				$this->dl_get_shop_installation_list_post();exit;
			}else if($action=='dl_add_new_shop_install_token_post'){
				$this->dl_add_new_shop_install_token_post();exit;
			}else if($action=='dl_get_page_permission_list_post'){
				$this->dl_get_page_permission_list_post();exit;
			}else if($action=='dl_change_permission_status') {
				$this->dl_change_permission_status();exit;
			}else if($action=='dl_edit_shop_details'){
				$this->dl_edit_shop_details();exit;
			}

			else if($action=='fetch_app_health_logs'){
				$this->fetchAppHealthLogs();exit;
			}

			else if($action=='natural_add_edit_module_origin_post'){
				$this->natural_add_edit_module_origin_post();exit;
			}else if($action=='natural_origin_display_change'){
				$this->natural_origin_display_change();exit;
			}else if($action=='natural_delete_origin'){
				$this->natural_delete_origin();exit;
			}

			else if($action=='labgrown_add_edit_module_origin_post'){
				$this->labgrown_add_edit_module_origin_post();exit;
			}else if($action=='labgrown_origin_display_change'){
				$this->labgrown_origin_display_change();exit;
			}else if($action=='labgrown_delete_origin'){
				$this->labgrown_delete_origin();exit;
			}

			else if($action=='rb_add_edit_custom_field_builder_post'){
				$this->rb_add_edit_custom_field_builder_post();exit;
			}else if($action=='rb_delete_custom_field_builder_post'){
				$this->rb_delete_custom_field_builder_post();exit;
			}else if($action=='rb_change_custom_field_order'){
				$this->rb_change_custom_field_order();exit;
			}
		}
	}
	
	public function admin_logout(){
		if(isset($_SESSION['login_user_id'])){ unset($_SESSION['login_user_id']); }
		if(isset($_SESSION['login_store_manager_id'])){ unset($_SESSION['login_store_manager_id']); };
		if(isset($_SESSION['login_store_master_id'])){ unset($_SESSION['login_store_master_id']); }
		session_destroy();

		$_SESSION['SUCCESS'] = 'TRUE';
		$_SESSION['MESSAGE'] = 'Successfully Logout.';
		header('location:login.php');
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
	public function edit_profile_personal_details_post(){
		$login_user_id = $_SESSION['login_user_id'];
		//check email exist or not
		$sql = 'SELECT id FROM `admin_master` WHERE email="'.trim($_POST['email']).'" AND id!="'.$login_user_id.'"';
		$email_exist =  parent::selectTable_f_mdl($sql);
		if(!empty($email_exist)){
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Email is already existed.';
		}else{
			$update_data = [
				'first_name' => trim($_POST['first_name']),
				'last_name' => trim($_POST['last_name']),
				'email' => trim($_POST['email'])
			];
			parent::updateTable_f_mdl('admin_master',$update_data,'id="'.$login_user_id.'"');

			$_SESSION['SUCCESS'] = 'TRUE';
			$_SESSION['MESSAGE'] = 'Profile updated successfully.';
		}

		header('location:index.php?do=profile');
	}
	public function edit_profile_change_password_post(){
		$login_user_id = $_SESSION['login_user_id'];

		$update_data = [
			'password' => md5(trim($_POST['password']))
		];
		parent::updateTable_f_mdl('admin_master',$update_data,'id="'.$login_user_id.'"');

		$_SESSION['SUCCESS'] = 'TRUE';
		$_SESSION['MESSAGE'] = 'Password changed successfully.';

		header('location:index.php?do=profile');
	}

	public function get_shop_installation_list_post(){
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

		$sql="
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1="
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$install_link = common::APP_INSTALL_URL.'?install_token='.$single['install_token'];
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['shop'].'</td>';
					/*$html .= '<td>'.$install_link.' ';
					$html .= '<button type="button" class="btn btn-xs btn-info copy_install_link" data-link="'.$install_link.'">Copy</button>';
					$html .= '</td>';*/
					$html .= '<td>'.($single['add_date']!=''?date('d M Y',$single['add_date']):'').'</td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
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
	public function add_new_shop_install_token_post(){
		if(isset($_POST['sit_shop']) && !empty($_POST['sit_shop'])){
			$shop = trim($_POST['sit_shop']);
			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="'.$shop.'"';
			$exist =  parent::selectTable_f_mdl($sql);
			if(empty($exist)){
				$token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];
				parent::insertTable_f_mdl('shop_install_token',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=shop_installation');
	}

	public function get_language_list_post(){
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
					language LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY language_master.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(language_master.id) as count
                FROM `language_master`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1="
                SELECT language_master.id, language_master.language, language_master.status
                FROM `language_master`
                WHERE 1
                $cond_keyword

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
			$html .= '<th>Language</th>';// class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Status</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					if($single['status']=='1'){
						$status_chk = 'checked';
					}else{
						$status_chk = '';
					}
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['language'].'</td>';
					$html .= '<td><input type="checkbox" class="status_class" data-on-text="Active" data-off-text="Inactive" data-id="'.$single['id'].'" data-bootstrap-switch '.$status_chk.'></td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
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
	public function change_language_status(){
		if(isset($_POST['id']) && isset($_POST['new_status'])){
			$update_data = [
				'status' => $_POST['new_status']
			];
			parent::updateTable_f_mdl('language_master',$update_data,'id="'.$_POST['id'].'"');
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function add_new_language_post(){
		if(isset($_POST['language']) && !empty($_POST['language'])){
			$language = trim($_POST['language']);
			$sql = 'SELECT id FROM `language_master` WHERE language="'.$language.'"';
			$exist =  parent::selectTable_f_mdl($sql);
			if(empty($exist)){
				$insert_data = [
					'language' => $language,
					'shortcode' => preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($language)),
					'status' => '1'
				];
				parent::insertTable_f_mdl('language_master',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Language is already existed.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=languages');
	}


	public function get_page_permission_list_post(){
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
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY search_page_permission.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(search_page_permission.id) as count
                FROM `search_page_permission`
                RIGHT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1="
                SELECT search_page_permission.id, search_page_permission.shop_id, search_page_permission.search_diamond_allow, search_page_permission.search_lab_grown_allow, search_page_permission.search_gemstone_allow, search_page_permission.preview_request_allow, search_page_permission.cert_open_in_new_tab_allow, search_page_permission.own_inventory_allow,
				shop_management.shop_name, shop_management.email
                FROM `search_page_permission`
                RIGHT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword

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

		$image_upload_url = str_replace('login.php','',common::APP_INSTALL_URL).'images/uploads/';

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
			$html .= '<th>Shop & Email</th>';// class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Natural Diamond</th>';
			$html .= '<th>Labgrown Diamond</th>';
			$html .= '<th>Gemstone</th>';
			$html .= '<th>Preview Request</th>';
			$html .= '<th>Cert open in New Tab</th>';
			$html .= '<th>Disable Auto Buy Request on VDB</th>';
			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$single['shop_id'].'"';
					$as_data = parent::selectTable_f_mdl($sql);
					$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$single['shop_id'].'"';
					$ets_data = parent::selectTable_f_mdl($sql);

					if($single['search_diamond_allow']=='1'){
						$search_diamond_allow_chk = 'Yes';
					}else{
						$search_diamond_allow_chk = 'No';
					}
					if($single['search_lab_grown_allow']=='1'){
						$search_lab_grown_allow_chk = 'Yes';
					}else{
						$search_lab_grown_allow_chk = 'No';
					}
					if($single['search_gemstone_allow']=='1'){
						$search_gemstone_allow_chk = 'Yes';
					}else{
						$search_gemstone_allow_chk = 'No';
					}
					if($single['preview_request_allow']=='1'){
						$preview_request_allow_chk = 'Yes';
					}else{
						$preview_request_allow_chk = 'No';
					}
					if($single['cert_open_in_new_tab_allow']=='1'){
						$cert_open_in_new_tab_allow_chk = 'Yes';
					}else{
						$cert_open_in_new_tab_allow_chk = 'No';
					}
					if($single['own_inventory_allow']=='1'){
						$own_inventory_allow_chk = 'Yes';
					}else{
						$own_inventory_allow_chk = 'No';
					}
					$sender_email = $single['email'];
					if(isset($ets_data[0]['email_sender_address']) && !empty($ets_data[0]['email_sender_address'])){
						$sender_email = $ets_data[0]['email_sender_address'];
					}

					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>';
					// if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
					// 	$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					// }
					$html .= ' '.$single['shop_name'].'<br><b>'.$sender_email.'</b>';
					$html .= '</td>';
					$html .= '<td>'.$search_diamond_allow_chk.'</td>';
					$html .= '<td>'.$search_lab_grown_allow_chk.'</td>';
					$html .= '<td>'.$search_gemstone_allow_chk.'</td>';
					$html .= '<td>'.$preview_request_allow_chk.'</td>';
					$html .= '<td>'.$cert_open_in_new_tab_allow_chk.'</td>';
					$html .= '<td>'.$own_inventory_allow_chk.'</td>';

					$html .= '<td>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					$html .= '<a href="index.php?do=page_shop_settings&shop_id='.$single['shop_id'].'" class="btn btn-sm btn-primary">Settings</a>';
					$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="5" align="center">No Record Found</td>';
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
	public function change_permission_status(){
		if(isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])){
			$search_id = $_POST['id'];
			$field = $_POST['field'];
			$status = $_POST['new_status'];

			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];
			parent::updateTable_f_mdl('search_page_permission',$update_data,'id="'.$_POST['id'].'"');

			# Below codes only for gemstone. Added gemstone settings
			if ($field=='search_gemstone_allow' && $status==1) {
				$sql = "SELECT shop_id, search_gemstone_allow  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::selectTable_f_mdl($sql);
				if (!empty($get_shop) && $get_shop[0]['search_gemstone_allow']==1) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_gemstone` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::insertShopidInSearchPageSettings_f_mdl($shop_id); // GEMSTONE
						$this->insertShopidInSearchSettingsGemstone_f($shop_id); // GEMSTONE
					}
				}
			}
			#END

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function edit_shop_details(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id']) ){
			$shop_id = $_POST['shop_id'];

			$sql = 'SELECT id FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
			$email_template_settings_data = parent::selectTable_f_mdl($sql);
			if(isset($email_template_settings_data[0]['id'])){
				$update_data = [
					'email_sender_address' => $_POST['sender_email']
				];
				parent::updateTable_f_mdl('email_template_settings',$update_data,'id="'.$email_template_settings_data[0]['id'].'"');
			}else{
				$insert_data = [
					'shop_id' => $shop_id,
					'email_sender' => '',
					'email_sender_address' => $_POST['sender_email'],
					'email_reciever_address' => '',
					'email_template' => '',
					'status' => '1',
				];
				parent::insertTable_f_mdl('email_template_settings',$insert_data);
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Saved successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function get_details_by_shop_id($shop_id){
		$sql = 'SELECT shop_name, email FROM shop_management WHERE id="'.$shop_id.'"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function check_labels_by_shop_id($shop_id){
		$sql = 'SELECT app_labels.*,
		(
		SELECT sal_label FROM `shop_app_labels` WHERE sal_shop_id="'.$shop_id.'" AND sal_al_id = app_labels.al_id LIMIT 1
		) as sal_label
		FROM app_labels';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_permission_by_shop_id($shop_id){
		$sql = 'SELECT * FROM search_page_permission WHERE shop_id="'.$shop_id.'"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_email_sender_address_by_shop_id($shop_id){
		$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function get_api_settings_by_shop_id($shop_id){
		$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::selectTable_f_mdl($sql);
		return $data;
	}
	public function edit_shop_app_labels_post(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id']) ){
			$shop_id = $_POST['shop_id'];
			$tab_view = $_POST['tab_view'];

			foreach($_POST as $key=>$val){
				if (strpos($key, 'sal_') !== false) {
					$al_id = str_replace('sal_','',$key);

					$sql = 'SELECT sal_id FROM `shop_app_labels` WHERE sal_shop_id="'.$shop_id.'" AND sal_al_id="'.$al_id.'"';
					$sal_exist = parent::selectTable_f_mdl($sql);
					if(isset($sal_exist[0]['sal_id'])){
						$update_data = [
							'sal_label' => $val
						];
						parent::updateTable_f_mdl('shop_app_labels',$update_data,'sal_id="'.$sal_exist[0]['sal_id'].'"');
					}else{
						$insert_data = [
							'sal_shop_id' => $shop_id,
							'sal_al_id' => $al_id,
							'sal_label' => $val
						];
						parent::insertTable_f_mdl('shop_app_labels',$insert_data);
					}
				}
			}


			$_SESSION['SUCCESS'] = 'TRUE';
			$_SESSION['MESSAGE'] = 'Saved successfully.';

			header('location:index.php?do=page_shop_settings&shop_id='.$shop_id.'&tab='.$tab_view);
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';

			header('location:index.php');
		}
	}
	public function get_label_list_post(){
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
					label LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY label_master.label ASC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(label_master.id) as count
                FROM `label_master`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::selectTable_f_mdl($sql);

		$sql1="
                SELECT label_master.id, label_master.label, label_master.status
                FROM `label_master`
                WHERE 1
                $cond_keyword

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

		$sql="SELECT id, language, shortcode FROM `language_master`";
		$language_list = parent::selectTable_f_mdl($sql);

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
			$html .= '<th>Label</th>';// class="sort_th" data-sort_field="shop_order_id"

			if(!empty($language_list)){
				foreach($language_list as $single_lang){
					$html .= '<th>'.$single_lang['language'].'</th>';
				}
			}

			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){

				$labels_ids = array_column($all_list,'id');
				$sql="SELECT id, language_master_id, label_master_id, label_text
				FROM `language_label_text`
				WHERE label_master_id IN(".implode(',',$labels_ids).")";
				$ll_list = parent::selectTable_f_mdl($sql);
				$final_ll_list = [];
				if(!empty($ll_list)){
					foreach($ll_list as $single_ll){
						$final_ll_list[$single_ll['language_master_id'].'_'.$single_ll['label_master_id']] = $single_ll;
					}
				}

				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['label'].'</td>';
					if(!empty($language_list)){
						foreach($language_list as $single_lang){
							$ll_text = '';
							if(isset($final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text'])){
								$ll_text = parent::sanitize($final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text']);
							}
							$html .= '<td class="cursor-pointer ll_edit_td" id="ll_edit_td_'.$single_lang['id'].'_'.$single['id'].'"
							data-language="'.$single_lang['language'].'"
							data-language_master_id="'.$single_lang['id'].'"
							data-label="'.$single['label'].'"
							data-label_master_id="'.$single['id'].'"
							data-label_text="'.$ll_text.'"
							>
							'.$ll_text.'</td>';
						}
					}
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
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
	public function language_label_text_post(){
		if(isset($_POST['language_master_id']) && !empty($_POST['language_master_id']) &&
			isset($_POST['label_master_id']) && !empty($_POST['label_master_id']) &&
			isset($_POST['label_text']) && !empty($_POST['label_text'])
		){
			$sql='SELECT id FROM `language_label_text`
			WHERE language_master_id="'.$_POST['language_master_id'].'"
			AND label_master_id="'.$_POST['label_master_id'].'"
			';
			$ll_exist = parent::selectTable_f_mdl($sql);
			if(!empty($ll_exist)){
				$update_data = [
					'label_text' => $_POST['label_text']
				];
				parent::updateTable_f_mdl('language_label_text',$update_data,'id="'.$ll_exist[0]['id'].'"');
			}else{
				$insert_data = [
					'language_master_id' => $_POST['language_master_id'],
					'label_master_id' => $_POST['label_master_id'],
					'label_text' => $_POST['label_text'],
					'status' => '1',
				];
				parent::insertTable_f_mdl('language_label_text',$insert_data);
			}
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Text changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function gs_get_shop_installation_list_post(){
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

		$sql="
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::gs_selectTable_f_mdl($sql);

		$sql1="
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::gs_selectTable_f_mdl($sql1);

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['shop'].'</td>';
					$html .= '<td>'.($single['add_date']!=''?date('d M Y',$single['add_date']):'').'</td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
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
	public function gs_add_new_shop_install_token_post(){
		if(isset($_POST['sit_shop']) && !empty($_POST['sit_shop'])){
			$shop = trim($_POST['sit_shop']);
			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="'.$shop.'"';
			$exist =  parent::gs_selectTable_f_mdl($sql);
			if(empty($exist)){
				$token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];
				parent::gs_insertTable_f_mdl('shop_install_token',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=gs_shop_installation');
	}
	public function gs_get_page_permission_list_post(){
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
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY search_page_permission.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(search_page_permission.id) as count
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::gs_selectTable_f_mdl($sql);

		$sql1="
                SELECT search_page_permission.id, search_page_permission.shop_id, search_page_permission.preview_request_allow, search_page_permission.cert_open_in_new_tab_allow, search_page_permission.own_inventory_allow,
				shop_management.shop_name, shop_management.email
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::gs_selectTable_f_mdl($sql1);

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

		$image_upload_url = str_replace('login.php','',common::GS_APP_INSTALL_URL).'images/uploads/';

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
			$html .= '<th>Shop & Email</th>';// class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Preview Request</th>';
			$html .= '<th>Cert open in New Tab</th>';
			$html .= '<th>Disable Auto Buy Request on VDB</th>';
			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$single['shop_id'].'"';
					$as_data = parent::gs_selectTable_f_mdl($sql);
					$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$single['shop_id'].'"';
					$ets_data = parent::selectTable_f_mdl($sql);

					if($single['preview_request_allow']=='1'){
						$preview_request_allow_chk = 'checked';
					}else{
						$preview_request_allow_chk = '';
					}
					if($single['cert_open_in_new_tab_allow']=='1'){
						$cert_open_in_new_tab_allow_chk = 'checked';
					}else{
						$cert_open_in_new_tab_allow_chk = '';
					}
					if($single['own_inventory_allow']=='1'){
						$own_inventory_allow_chk = 'checked';
					}else{
						$own_inventory_allow_chk = '';
					}
					$sender_email = $single['email'];
					if(isset($ets_data[0]['email_sender_address']) && !empty($ets_data[0]['email_sender_address'])){
						$sender_email = $ets_data[0]['email_sender_address'];
					}

					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>';
					if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
						$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					}
					$html .= ' '.$single['shop_name'].'<br><b>'.$sender_email.'</b>';
					$html .= '</td>';
					$html .= '<td><input type="checkbox" class="check_labels_by_shop_id" data-on-text="Yes" data-off-text="No" data-id="'.$single['id'].'" data-field="preview_request_allow" data-bootstrap-switch '.$preview_request_allow_chk.'></td>';
					$html .= '<td><input type="checkbox" class="prmsn_class" data-on-text="Yes" data-off-text="No" data-id="'.$single['id'].'" data-field="cert_open_in_new_tab_allow" data-bootstrap-switch '.$cert_open_in_new_tab_allow_chk.'></td>';
					$html .= '<td><input type="checkbox" class="prmsn_class" data-on-text="Yes" data-off-text="No" data-id="'.$single['id'].'" data-field="own_inventory_allow" data-bootstrap-switch '.$own_inventory_allow_chk.'></td>';

					$html .= '<td>';
					$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="6" align="center">No Record Found</td>';
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
	public function gs_change_permission_status(){
		if(isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])){
			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];
			parent::gs_updateTable_f_mdl('search_page_permission',$update_data,'id="'.$_POST['id'].'"');
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function gs_edit_shop_details(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id']) ){
			$shop_id = $_POST['shop_id'];

			$sql = 'SELECT id FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
			$email_template_settings_data = parent::selectTable_f_mdl($sql);
			if(isset($email_template_settings_data[0]['id'])){
				$update_data = [
					'email_sender_address' => $_POST['sender_email']
				];
				parent::updateTable_f_mdl('email_template_settings',$update_data,'id="'.$email_template_settings_data[0]['id'].'"');
			}else{
				$insert_data = [
					'shop_id' => $shop_id,
					'email_sender' => '',
					'email_sender_address' => $_POST['sender_email'],
					'email_reciever_address' => '',
					'email_template' => '',
					'status' => '1',
				];
				parent::insertTable_f_mdl('email_template_settings',$insert_data);
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Saved successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function gs_get_label_list_post(){
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
					label LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY label_master.label ASC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(label_master.id) as count
                FROM `label_master`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::gs_selectTable_f_mdl($sql);

		$sql1="
                SELECT label_master.id, label_master.label, label_master.status
                FROM `label_master`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::gs_selectTable_f_mdl($sql1);

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

		$sql="SELECT id, language, shortcode FROM `language_master`";
		$language_list = parent::gs_selectTable_f_mdl($sql);

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
			$html .= '<th>Label</th>';// class="sort_th" data-sort_field="shop_order_id"

			if(!empty($language_list)){
				foreach($language_list as $single_lang){
					$html .= '<th>'.$single_lang['language'].'</th>';
				}
			}

			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){

				$labels_ids = array_column($all_list,'id');
				$sql="SELECT id, language_master_id, label_master_id, label_text
				FROM `language_label_text`
				WHERE label_master_id IN(".implode(',',$labels_ids).")";
				$ll_list = parent::gs_selectTable_f_mdl($sql);

				$final_ll_list = [];
				if(!empty($ll_list)){
					foreach($ll_list as $single_ll){
						$final_ll_list[$single_ll['language_master_id'].'_'.$single_ll['label_master_id']] = $single_ll;
					}
				}

				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['label'].'</td>';
					if(!empty($language_list)){
						foreach($language_list as $single_lang){
							$ll_text = '';
							if(isset($final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text'])){
								$ll_text = $final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text'];
							}
							$html .= '<td class="cursor-pointer ll_edit_td" id="ll_edit_td_'.$single_lang['id'].'_'.$single['id'].'"
							data-language="'.$single_lang['language'].'"
							data-language_master_id="'.$single_lang['id'].'"
							data-label="'.$single['label'].'"
							data-label_master_id="'.$single['id'].'"
							data-label_text="'.$ll_text.'"
							>
							'.$ll_text.'</td>';
						}
					}
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
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
	public function gs_language_label_text_post(){
		if(isset($_POST['language_master_id']) && !empty($_POST['language_master_id']) &&
			isset($_POST['label_master_id']) && !empty($_POST['label_master_id']) &&
			isset($_POST['label_text']) && !empty($_POST['label_text'])
		){
			$sql='SELECT id FROM `language_label_text`
			WHERE language_master_id="'.$_POST['language_master_id'].'"
			AND label_master_id="'.$_POST['label_master_id'].'"
			';
			$ll_exist = parent::gs_selectTable_f_mdl($sql);
			if(!empty($ll_exist)){
				$update_data = [
					'label_text' => parent::sanitize($_POST['label_text'])
				];
				parent::gs_updateTable_f_mdl('language_label_text',$update_data,'id="'.$ll_exist[0]['id'].'"');
			}else{
				$insert_data = [
					'language_master_id' => $_POST['language_master_id'],
					'label_master_id' => $_POST['label_master_id'],
					'label_text' => parent::sanitize($_POST['label_text']),
					'status' => '1',
				];
				parent::gs_insertTable_f_mdl('language_label_text',$insert_data);
			}
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Text changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_shop_installation_list_post(){
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

		$sql="
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::rb_selectTable_f_mdl($sql);

		$sql1="
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::rb_selectTable_f_mdl($sql1);

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['shop'].'</td>';
					$html .= '<td>'.($single['add_date']!=''?date('d M Y',$single['add_date']):'').'</td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
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
	public function rb_add_new_shop_install_token_post(){
		if(isset($_POST['sit_shop']) && !empty($_POST['sit_shop'])){
			$shop = trim($_POST['sit_shop']);
			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="'.$shop.'"';
			$exist =  parent::rb_selectTable_f_mdl($sql);
			if(empty($exist)){
				$token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];
				parent::rb_insertTable_f_mdl('shop_install_token',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=rb_shop_installation');
	}
	public function rb_get_page_permission_list_post(){
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
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY search_page_permission.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(search_page_permission.id) as count
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::rb_selectTable_f_mdl($sql);

		$sql1="
                SELECT search_page_permission.id, search_page_permission.shop_id, search_page_permission.preview_request_allow, search_page_permission.search_diamond_allow,search_page_permission.search_lab_grown_allow,search_page_permission.search_gemstone_allow,search_page_permission.search_radiance_allow,search_page_permission.cert_open_in_new_tab_allow, search_page_permission.own_inventory_allow,
				shop_management.shop_name, shop_management.email
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::rb_selectTable_f_mdl($sql1);

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

		$image_upload_url = str_replace('login.php','',common::RB_APP_INSTALL_URL).'images/uploads/';

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
			$html .= '<th>Shop & Email</th>';// class="sort_th" data-sort_field="shop_order_id"

			$html .= '<th>Natural Diamond</th>';
			$html .= '<th>Labgrown Diamond</th>';
			$html .= '<th>Gemstone</th>';
			$html .= '<th>Radiance</th>';

			$html .= '<th style="display: none;">Preview Request</th>';
			$html .= '<th>Cert open in New Tab</th>';
			$html .= '<th>Disable Auto Buy Request on VDB</th>';
			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$single['shop_id'].'"';
					$as_data = parent::rb_selectTable_f_mdl($sql);
					$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$single['shop_id'].'"';
					$ets_data = parent::rb_selectTable_f_mdl($sql);

					if($single['search_diamond_allow']=='1'){
						$search_diamond_allow_chk = 'Yes';
					}else{
						$search_diamond_allow_chk = 'No';
					}
					if($single['search_lab_grown_allow']=='1'){
						$search_lab_grown_allow_chk = 'Yes';
					}else{
						$search_lab_grown_allow_chk = 'No';
					}
					if($single['search_gemstone_allow']=='1'){
						$search_gemstone_allow_chk = 'Yes';
					}else{
						$search_gemstone_allow_chk = 'No';
					}
					if($single['search_radiance_allow']=='1'){
						$search_radiance_allow_chk = 'Yes';
					}else{
						$search_radiance_allow_chk = 'No';
					}
					if($single['preview_request_allow']=='1'){
						$preview_request_allow_chk = 'Yes';
					}else{
						$preview_request_allow_chk = 'No';
					}
					if($single['cert_open_in_new_tab_allow']=='1'){
						$cert_open_in_new_tab_allow_chk = 'Yes';
					}else{
						$cert_open_in_new_tab_allow_chk = 'No';
					}
					if($single['own_inventory_allow']=='1'){
						$own_inventory_allow_chk = 'Yes';
					}else{
						$own_inventory_allow_chk = 'No';
					}
					$sender_email = $single['email'];
					if(isset($ets_data[0]['email_sender_address']) && !empty($ets_data[0]['email_sender_address'])){
						$sender_email = $ets_data[0]['email_sender_address'];
					}

					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>';
					if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
						$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					}
					$html .= ' '.$single['shop_name'].'<br><b>'.$sender_email.'</b>';
					$html .= '</td>';

					$html .= '<td>'.$search_diamond_allow_chk.'</td>';
					$html .= '<td>'.$search_lab_grown_allow_chk.'</td>';
					$html .= '<td>'.$search_gemstone_allow_chk.'</td>';
					$html .= '<td>'.$search_radiance_allow_chk.'</td>';
					$html .= '<td>'.$cert_open_in_new_tab_allow_chk.'</td>';
					$html .= '<td>'.$own_inventory_allow_chk.'</td>';

					$html .= '<td>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					$html .= '<a href="index.php?do=rb_page_shop_settings&shop_id='.$single['shop_id'].'" class="btn btn-sm btn-primary">Settings</a>';
					$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="9" align="center">No Record Found</td>';
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
	public function rb_change_permission_status(){
		if(isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])){
			$search_id = $_POST['id'];
			$field = $_POST['field'];
			$status = $_POST['new_status'];

			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];
			parent::rb_updateTable_f_mdl('search_page_permission',$update_data,'id="'.$_POST['id'].'"');

			# Below codes only for gemstone. Added gemstone settings
			if ($field=='search_diamond_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_natural` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::rb_insertShopidInSearchSettings_f_mdl($shop_id,'natural');
					}
				}
			}
			else if ($field=='search_lab_grown_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_lab_grown` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::rb_insertShopidInSearchSettings_f_mdl($shop_id,'labgrown');
					}
				}
			}
			else if ($field=='search_gemstone_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_gemstone` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::rb_insertShopidInSearchSettings_f_mdl($shop_id,'gemstone');
					}
				}
			}
			else if ($field=='search_radiance_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_radiance` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::rb_insertShopidInSearchSettings_f_mdl($shop_id,'radiance');
					}
				}
			}
			else if ($field=='quiz_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT qs_shop_id FROM `quiz_settings` WHERE qs_shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						$insert_data = [
							'qs_shop_id' => $shop_id,
							'qs_add_date' => time()
						];
						parent::rb_insertTable_f_mdl('quiz_settings',$insert_data);
					}
				}
			}
			#END


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_edit_shop_details(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id']) ){
			$shop_id = $_POST['shop_id'];

			$sql = 'SELECT id FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
			$email_template_settings_data = parent::rb_selectTable_f_mdl($sql);
			if(isset($email_template_settings_data[0]['id'])){
				$update_data = [
					'email_sender_address' => $_POST['sender_email']
				];
				parent::rb_updateTable_f_mdl('email_template_settings',$update_data,'id="'.$email_template_settings_data[0]['id'].'"');
			}else{
				$insert_data = [
					'shop_id' => $shop_id,
					'email_sender' => '',
					'email_sender_address' => $_POST['sender_email'],
					'email_reciever_address' => '',
					'email_template' => '',
					'status' => '1',
				];
				parent::rb_insertTable_f_mdl('email_template_settings',$insert_data);
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Saved successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_get_details_by_shop_id($shop_id){
		$sql = 'SELECT shop_name, email FROM shop_management WHERE id="'.$shop_id.'"';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_get_permission_by_shop_id($shop_id){
		$sql = 'SELECT * FROM search_page_permission WHERE shop_id="'.$shop_id.'"';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_get_email_sender_address_by_shop_id($shop_id){
		$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_get_api_settings_by_shop_id($shop_id){
		$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_get_label_list_post(){
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
					label LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY label_master.label ASC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(label_master.id) as count
                FROM `label_master`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::rb_selectTable_f_mdl($sql);

		$sql1="
                SELECT label_master.id, label_master.label, label_master.status
                FROM `label_master`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::rb_selectTable_f_mdl($sql1);

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

		$sql="SELECT id, language, shortcode FROM `language_master`";
		$language_list = parent::rb_selectTable_f_mdl($sql);

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
			$html .= '<th>Label</th>';// class="sort_th" data-sort_field="shop_order_id"

			if(!empty($language_list)){
				foreach($language_list as $single_lang){
					$html .= '<th>'.$single_lang['language'].'</th>';
				}
			}

			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){

				$labels_ids = array_column($all_list,'id');
				$sql="SELECT id, language_master_id, label_master_id, label_text
				FROM `language_label_text`
				WHERE label_master_id IN(".implode(',',$labels_ids).")";
				$ll_list = parent::rb_selectTable_f_mdl($sql);

				$final_ll_list = [];
				if(!empty($ll_list)){
					foreach($ll_list as $single_ll){
						$final_ll_list[$single_ll['language_master_id'].'_'.$single_ll['label_master_id']] = $single_ll;
					}
				}

				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['label'].'</td>';
					if(!empty($language_list)){
						foreach($language_list as $single_lang){
							$ll_text = '';
							if(isset($final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text'])){
								$ll_text = $final_ll_list[$single_lang['id'].'_'.$single['id']]['label_text'];
							}
							$html .= '<td class="cursor-pointer ll_edit_td" id="ll_edit_td_'.$single_lang['id'].'_'.$single['id'].'"
							data-language="'.$single_lang['language'].'"
							data-language_master_id="'.$single_lang['id'].'"
							data-label="'.$single['label'].'"
							data-label_master_id="'.$single['id'].'"
							data-label_text="'.$ll_text.'"
							>
							'.$ll_text.'</td>';
						}
					}
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
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
	public function rb_language_label_text_post(){
		if(isset($_POST['language_master_id']) && !empty($_POST['language_master_id']) &&
			isset($_POST['label_master_id']) && !empty($_POST['label_master_id']) &&
			isset($_POST['label_text']) && !empty($_POST['label_text'])
		){
			$sql='SELECT id FROM `language_label_text`
			WHERE language_master_id="'.$_POST['language_master_id'].'"
			AND label_master_id="'.$_POST['label_master_id'].'"
			';
			$ll_exist = parent::rb_selectTable_f_mdl($sql);
			if(!empty($ll_exist)){
				$update_data = [
					'label_text' => parent::sanitize($_POST['label_text'])
				];
				parent::rb_updateTable_f_mdl('language_label_text',$update_data,'id="'.$ll_exist[0]['id'].'"');
			}else{
				$insert_data = [
					'language_master_id' => $_POST['language_master_id'],
					'label_master_id' => $_POST['label_master_id'],
					'label_text' => parent::sanitize($_POST['label_text']),
					'status' => '1',
				];
				parent::rb_insertTable_f_mdl('language_label_text',$insert_data);
			}
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Text changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function tile_3d_cb() {
		$res = []; // Initialize response array
	
		// Check if required POST parameters are present and not empty
		if (
			isset($_POST['shop_id']) && !empty($_POST['shop_id']) &&
			isset($_POST['tile_3d_title']) && isset($_POST['tile_3d_button_text']) && isset($_POST['tile_3d_stock_num'])
		) {
			// Sanitize input data
			$shop_id = parent::sanitize($_POST['shop_id']);
			$tile_3d_title = parent::sanitize($_POST['tile_3d_title']);
			$tile_3d_button_text = parent::sanitize($_POST['tile_3d_button_text']);
			$tile_3d_stock_num = parent::sanitize($_POST['tile_3d_stock_num']);
	
			// Prepare update data
			$update_data = [
				'tile_3d_title' => $tile_3d_title,
				'tile_3d_button_text' => $tile_3d_button_text,
				'tile_3d_stock_num' => $tile_3d_stock_num
			];
			// Update database table SEARCH_PAGE_PERMISSION
			parent::rb_updateTable_f_mdl('SEARCH_PAGE_PERMISSION', $update_data, 'id="' . $shop_id . '"');

			// Set success response
			$res['SUCCESS'] = true;
			$res['MESSAGE'] = 'Data updated successfully.';
		} else {
			// Invalid request or missing parameters
			$res['SUCCESS'] = false;
			$res['MESSAGE'] = 'Invalid request or missing parameters.';
		}
	
		// Return JSON response
		echo json_encode($res);
		exit; // Ensure script terminates after sending response
	}
	
	
	

	public function rb_get_srmt_by_shop_id($shop_id){
		$sql = 'SELECT store_radiance_module_type.*, 
				( SELECT COUNT(srmc_id) FROM store_radiance_module_color WHERE srmc_srmt_id = store_radiance_module_type.srmt_id ) AS color_count, 
				( SELECT COUNT(srms_id) FROM store_radiance_module_shape WHERE srms_srmt_id = store_radiance_module_type.srmt_id ) AS shape_count 
				FROM store_radiance_module_type 
				WHERE srmt_shop_id = "'.$shop_id.'" 
				ORDER BY srmt_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_add_edit_radiance_type_post(){
		if(isset($_POST['srmt_shop_id']) && !empty($_POST['srmt_shop_id'])){
			$srmt_id = trim($_POST['srmt_id']);
			$srmt_shop_id = trim($_POST['srmt_shop_id']);
			if(!empty($srmt_id)){
				//update
				$update_data = [
					'srmt_label' => $_POST['srmt_label'],
					'srmt_short_code' => parent::handlize($_POST['srmt_label']),
					'srmt_vdb_value' => $_POST['srmt_vdb_value'],
					'srmt_modify_date' => time()
				];
				if(isset($_POST['srmt_uploaded_image']) && !empty($_POST['srmt_uploaded_image'])){
					$update_data['srmt_image'] = $_POST['srmt_uploaded_image'];
				}
				parent::rb_updateTable_f_mdl('store_radiance_module_type',$update_data,'srmt_id="'.$srmt_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$srmt_order = 1;
				$sql = 'SELECT MAX(srmt_order) as max_srmt_order FROM store_radiance_module_type WHERE srmt_shop_id="'.$srmt_shop_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_srmt_order']) && !empty($data[0]['max_srmt_order'])){
					$srmt_order = intval($data[0]['max_srmt_order'])+1;
				}

				$insert_data = [
					'srmt_shop_id' => $srmt_shop_id,
					'srmt_label' => $_POST['srmt_label'],
					'srmt_short_code' => parent::handlize($_POST['srmt_label']),
					'srmt_image' => $_POST['srmt_uploaded_image'],
					'srmt_order' => $srmt_order,
					'srmt_display' => 'show',
					'srmt_vdb_value' => $_POST['srmt_vdb_value'],
					'srmt_status' => '1',
					'srmt_add_date' => time(),
					'srmt_modify_date' => ''
				];
				parent::rb_insertTable_f_mdl('store_radiance_module_type',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_radiance_type_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'srmt_display' => $_POST['new_display']
			];
			parent::rb_updateTable_f_mdl('store_radiance_module_type',$update_data,'srmt_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_change_radiance_type_order(){
		if(isset($_POST['shop_id']) && isset($_POST['radiance_type_order'])){
			$shop_id = $_POST['shop_id'];
			$radiance_type_order_arr = json_decode($_POST['radiance_type_order'],1);
			foreach($radiance_type_order_arr as $single){
				if(isset($single['srmt_id']) && isset($single['order'])){
					$update_data = [
						'srmt_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('store_radiance_module_type',$update_data,'srmt_shop_id="'.$shop_id.'" AND srmt_id="'.$single['srmt_id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_color_by_type(){
		$srmt_id = $_POST['srmt_id'];
		$sql = 'SELECT srmc_id, srmc_srmt_id, srmc_label, srmc_image, srmc_order, srmc_display, srmc_vdb_value, store_radiance_module_type.srmt_label
		FROM store_radiance_module_color
		LEFT JOIN store_radiance_module_type ON store_radiance_module_type.srmt_id = store_radiance_module_color.srmc_srmt_id
		WHERE srmc_srmt_id="'.$srmt_id.'" ORDER BY srmc_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		if(!empty($data)){
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = '';
			$res['DATA'] = $data;
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'No records found.';
		}
		echo json_encode($res,1);
	}
	public function rb_add_edit_radiance_color_post(){
		if(isset($_POST['srmc_srmt_id']) && !empty($_POST['srmc_srmt_id'])){
			$srmc_id = trim($_POST['srmc_id']);
			$srmc_srmt_id = trim($_POST['srmc_srmt_id']);
			if(!empty($srmc_id)){
				//update
				$update_data = [
					'srmc_label' => $_POST['srmc_label'],
					'srmc_short_code' => parent::handlize($_POST['srmc_label']),
					'srmc_vdb_value' => $_POST['srmc_vdb_value'],
					'srmc_modify_date' => time()
				];
				if(isset($_POST['srmc_uploaded_image']) && !empty($_POST['srmc_uploaded_image'])){
					$update_data['srmc_image'] = $_POST['srmc_uploaded_image'];
				}
				parent::rb_updateTable_f_mdl('store_radiance_module_color',$update_data,'srmc_id="'.$srmc_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$srmc_order = 1;
				$sql = 'SELECT MAX(srmc_order) as max_srmc_order FROM store_radiance_module_color WHERE srmc_srmt_id="'.$srmc_srmt_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_srmc_order']) && !empty($data[0]['max_srmc_order'])){
					$srmc_order = intval($data[0]['max_srmc_order'])+1;
				}

				$insert_data = [
					'srmc_srmt_id' => $srmc_srmt_id,
					'srmc_label' => $_POST['srmc_label'],
					'srmc_short_code' => parent::handlize($_POST['srmc_label']),
					'srmc_image' => $_POST['srmc_uploaded_image'],
					'srmc_order' => $srmc_order,
					'srmc_display' => 'show',
					'srmc_vdb_value' => $_POST['srmc_vdb_value'],
					'srmc_status' => '1',
					'srmc_add_date' => time(),
					'srmc_modify_date' => ''
				];
				parent::rb_insertTable_f_mdl('store_radiance_module_color',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_radiance_color_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'srmc_display' => $_POST['new_display']
			];
			parent::rb_updateTable_f_mdl('store_radiance_module_color',$update_data,'srmc_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_change_radiance_color_order(){
		if(isset($_POST['shop_id']) && isset($_POST['radiance_color_order'])){
			$radiance_color_order_arr = json_decode($_POST['radiance_color_order'],1);
			foreach($radiance_color_order_arr as $single){
				if(isset($single['srmc_id']) && isset($single['order'])){
					$update_data = [
						'srmc_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('store_radiance_module_color',$update_data,'srmc_id="'.$single['srmc_id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_shape_by_type(){
		$srmt_id = $_POST['srmt_id'];
		$sql = 'SELECT srms_id, srms_srmt_id, srms_label, srms_image, srms_order, srms_display, srms_vdb_value, store_radiance_module_type.srmt_label,
				(SELECT COUNT(srmss_id) FROM store_radiance_module_sub_shape WHERE srmss_srms_id=store_radiance_module_shape.srms_id) as subshape_count
				FROM store_radiance_module_shape
				LEFT JOIN store_radiance_module_type ON store_radiance_module_type.srmt_id = store_radiance_module_shape.srms_srmt_id
				WHERE srms_srmt_id="'.$srmt_id.'" ORDER BY srms_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		if(!empty($data)){
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = '';
			$res['DATA'] = $data;
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'No records found.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_subshape_by_shape(){
		$srms_id = $_POST['srms_id'];
		$sql = 'SELECT srmss_id, srmss_srms_id, srmss_label, srmss_image, srmss_order, srmss_display, srmss_vdb_value, store_radiance_module_shape.srms_label
		FROM store_radiance_module_sub_shape
		LEFT JOIN store_radiance_module_shape ON store_radiance_module_shape.srms_id = store_radiance_module_sub_shape.srmss_srms_id
		WHERE srmss_srms_id="'.$srms_id.'" ORDER BY srmss_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		if(!empty($data)){
			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = '';
			$res['DATA'] = $data;
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'No records found.';
		}
		echo json_encode($res,1);
	}
	public function rb_add_edit_radiance_subshape_post(){
		if(isset($_POST['srmss_srms_id']) && !empty($_POST['srmss_srms_id'])){
			$srmss_id = trim($_POST['srmss_id']);
			$srmss_srms_id = trim($_POST['srmss_srms_id']);
			if(!empty($srmss_id)){
				//update
				$update_data = [
					'srmss_label' => $_POST['srmss_label'],
					'srmss_short_code' => parent::handlize($_POST['srmss_label']),
					'srmss_vdb_value' => $_POST['srmss_vdb_value'],
					'srmss_modify_date' => time()
				];
				if(isset($_POST['srmss_uploaded_image']) && !empty($_POST['srmss_uploaded_image'])){
					$update_data['srmss_image'] = $_POST['srmss_uploaded_image'];
				}
				parent::rb_updateTable_f_mdl('store_radiance_module_sub_shape',$update_data,'srmss_id="'.$srmss_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$srmss_order = 1;
				$sql = 'SELECT MAX(srmss_order) as max_srmss_order FROM store_radiance_module_sub_shape WHERE srmss_srms_id="'.$srmss_srms_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_srmss_order']) && !empty($data[0]['max_srmss_order'])){
					$srmss_order = intval($data[0]['max_srmss_order'])+1;
				}

				$insert_data = [
					'srmss_srms_id' => $srmss_srms_id,
					'srmss_label' => $_POST['srmss_label'],
					'srmss_short_code' => parent::handlize($_POST['srmss_label']),
					'srmss_image' => $_POST['srmss_uploaded_image'],
					'srmss_order' => $srmss_order,
					'srmss_display' => 'show',
					'srmss_vdb_value' => $_POST['srmss_vdb_value'],
					'srmss_status' => '1',
					'srmss_add_date' => time(),
					'srmss_modify_date' => ''
				];
				parent::rb_insertTable_f_mdl('store_radiance_module_sub_shape',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_radiance_subshape_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'srmss_display' => $_POST['new_display']
			];
			parent::rb_updateTable_f_mdl('store_radiance_module_sub_shape',$update_data,'srmss_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_change_radiance_subshape_order(){
		if(isset($_POST['shop_id']) && isset($_POST['radiance_subshape_order'])){
			$radiance_subshape_order_arr = json_decode($_POST['radiance_subshape_order'],1);
			foreach($radiance_subshape_order_arr as $single){
				if(isset($single['srmss_id']) && isset($single['order'])){
					$update_data = [
						'srmss_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('store_radiance_module_sub_shape',$update_data,'srmss_id="'.$single['srmss_id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_srms_by_shop_id($shop_id){
		$sql = 'SELECT store_radiance_module_shape.*,
		(SELECT COUNT(srmss_id) FROM store_radiance_module_sub_shape
 		WHERE srmss_srms_id=store_radiance_module_shape.srms_id
 		) as subshape_count
		FROM store_radiance_module_shape WHERE srms_shop_id="'.$shop_id.'" ORDER BY srms_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_add_edit_radiance_shape_post(){
		if(isset($_POST['srms_shop_id']) && !empty($_POST['srms_shop_id'])){
			$srms_id = trim($_POST['srms_id']);
			$srms_shop_id = trim($_POST['srms_shop_id']);
			$srms_srmt_id = trim($_POST['srms_srmt_id']);

			if(!empty($srms_id)){
				//update
				$update_data = [
					'srms_srmt_id' => $srms_srmt_id,
					'srms_label' => $_POST['srms_label'],
					'srms_short_code' => parent::handlize($_POST['srms_label']),
					'srms_vdb_value' => $_POST['srms_vdb_value'],
					'srms_modify_date' => time()
				];
				if(isset($_POST['srms_uploaded_image']) && !empty($_POST['srms_uploaded_image'])){
					$update_data['srms_image'] = $_POST['srms_uploaded_image'];
				}
				parent::rb_updateTable_f_mdl('store_radiance_module_shape',$update_data,'srms_id="'.$srms_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$srms_order = 1;
				$sql = 'SELECT MAX(srms_order) as max_srms_order FROM store_radiance_module_shape WHERE srms_srmt_id="'.$srms_srmt_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_srms_order']) && !empty($data[0]['max_srms_order'])){
					$srms_order = intval($data[0]['max_srms_order'])+1;
				}

				$insert_data = [
					'srms_srmt_id' => $srms_srmt_id,
					'srms_shop_id' => $srms_shop_id,
					'srms_label' => $_POST['srms_label'],
					'srms_short_code' => parent::handlize($_POST['srms_label']),
					'srms_image' => $_POST['srms_uploaded_image'],
					'srms_order' => $srms_order,
					'srms_display' => 'show',
					'srms_vdb_value' => $_POST['srms_vdb_value'],
					'srms_status' => '1',
					'srms_add_date' => time(),
					'srms_modify_date' => ''
				];
				parent::rb_insertTable_f_mdl('store_radiance_module_shape',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_radiance_shape_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'srms_display' => $_POST['new_display']
			];
			parent::rb_updateTable_f_mdl('store_radiance_module_shape',$update_data,'srms_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_change_radiance_shape_order(){
		if(isset($_POST['shop_id']) && isset($_POST['radiance_shape_order'])){
			$shop_id = $_POST['shop_id'];
			$radiance_shape_order_arr = json_decode($_POST['radiance_shape_order'],1);
			foreach($radiance_shape_order_arr as $single){
				if(isset($single['srms_id']) && isset($single['order'])){
					$update_data = [
						'srms_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('store_radiance_module_shape',$update_data,'srms_shop_id="'.$shop_id.'" AND srms_id="'.$single['srms_id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_add_edit_ring_size_chart_post(){
		if(isset($_POST['rsc_shop_id']) && !empty($_POST['rsc_shop_id'])){
			$rsc_id = trim($_POST['rsc_id']);
			$rsc_shop_id = trim($_POST['rsc_shop_id']);
			if(!empty($rsc_id)){
				//update
				$update_data = [
					'rsc_chart_title' => $_POST['rsc_chart_title'],
					'rsc_country_codes' => $_POST['rsc_country_codes'],
					'rsc_ring_sizes' => $_POST['rsc_ring_sizes'],
					'rsc_modify_date' => time()
				];
				parent::rb_updateTable_f_mdl('ring_size_chart',$update_data,'rsc_id="'.$rsc_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$rsc_order = 1;
				$sql = 'SELECT MAX(rsc_order) as max_rsc_order FROM ring_size_chart WHERE rsc_shop_id="'.$rsc_shop_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_rsc_order']) && !empty($data[0]['max_rsc_order'])){
					$rsc_order = intval($data[0]['max_rsc_order'])+1;
				}

				$insert_data = [
					'rsc_shop_id' => $rsc_shop_id,
					'rsc_chart_title' => $_POST['rsc_chart_title'],
					'rsc_country_codes' => $_POST['rsc_country_codes'],
					'rsc_ring_sizes' => $_POST['rsc_ring_sizes'],
					'rsc_order' => $rsc_order,
					'rsc_add_date' => time(),
					'rsc_modify_date' => ''
				];
				parent::rb_insertTable_f_mdl('ring_size_chart',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_get_ring_size_chart_by_shop_id($shop_id){
		$sql = 'SELECT ring_size_chart.*
 		FROM ring_size_chart WHERE rsc_shop_id="'.$shop_id.'" ORDER BY rsc_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_change_ring_size_chart_order(){
		if(isset($_POST['shop_id']) && isset($_POST['ring_size_chart_order'])){
			$shop_id = $_POST['shop_id'];
			$ring_size_chart_order_arr = json_decode($_POST['ring_size_chart_order'],1);
			foreach($ring_size_chart_order_arr as $single){
				if(isset($single['rsc_id']) && isset($single['order'])){
					$update_data = [
						'rsc_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('ring_size_chart',$update_data,'rsc_shop_id="'.$shop_id.'" AND rsc_id="'.$single['rsc_id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_add_edit_title_alter_post(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				//update

				$sql = 'SELECT id FROM vdb_item_title_alter WHERE shop_id="'.$shop_id.'" AND title_from="'.$_POST['title_from'].'" AND item_type="'.$_POST['item_type'].'" AND id!="'.$id.'"';
				$exist = parent::rb_selectTable_f_mdl($sql);
				if(!empty($exist)){
					$res['SUCCESS'] = 'FALSE';
					$res['MESSAGE'] = 'Label is already existed.';
				}else{
					$update_data = [
						'title_from' => $_POST['title_from'],
						'title_to' => $_POST['title_to'],
						'item_type' => $_POST['item_type']
					];
					parent::rb_updateTable_f_mdl('vdb_item_title_alter',$update_data,'id="'.$id.'"');
					$res['SUCCESS'] = 'TRUE';
					$res['MESSAGE'] = 'Updated successfully.';
				}
			}
			else{
				//insert

				$sql = 'SELECT id FROM vdb_item_title_alter WHERE shop_id="'.$shop_id.'" AND title_from="'.$_POST['title_from'].'" AND item_type="'.$_POST['item_type'].'"';
				$exist = parent::rb_selectTable_f_mdl($sql);

				if(!empty($exist)){
					$res['SUCCESS'] = 'FALSE';
					$res['MESSAGE'] = 'Label is already existed.';
				}else{
					$insert_data = [
						'shop_id' => $shop_id,
						'title_from' => $_POST['title_from'],
						'title_to' => $_POST['title_to'],
						'item_type' => $_POST['item_type']
					];
					parent::rb_insertTable_f_mdl('vdb_item_title_alter',$insert_data);
					$res['SUCCESS'] = 'TRUE';
					$res['MESSAGE'] = 'Added successfully.';
				}

			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_delete_title_alter_post(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('vdb_item_title_alter','id="'.$id.'" AND shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_get_title_alter_by_shop_id($shop_id){
		$sql = 'SELECT vdb_item_title_alter.*
 		FROM vdb_item_title_alter WHERE shop_id="'.$shop_id.'"';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}

	public function rb_delete_radiance_type(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('store_radiance_module_type','srmt_id="'.$id.'" AND srmt_shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_delete_radiance_shape(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('store_radiance_module_shape','srms_id="'.$id.'" AND srms_shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_delete_radiance_color(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('store_radiance_module_color','srmc_id="'.$id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_delete_radiance_subshape(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('store_radiance_module_sub_shape','srmss_id="'.$id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function jl_get_shop_installation_list_post(){
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

		$sql="
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::jl_selectTable_f_mdl($sql);

		$sql1="
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::jl_selectTable_f_mdl($sql1);

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['shop'].'</td>';
					$html .= '<td>'.($single['add_date']!=''?date('d M Y',$single['add_date']):'').'</td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
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


	public function jl_variant_change_permission_status(){
		if(isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])){
			$search_id = $_POST['id'];
			$field = $_POST['field'];
			$status = $_POST['new_status'];

			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];
			parent::rb_updateTable_f_mdl('shop_management',$update_data,'id="'.$_POST['id'].'"');

			# Below codes only for gemstone. Added gemstone settings
			if ($field=='shopify_product_variant_create_allow' && $status==1) {
				$sql = "SELECT shopify_product_variant_create_allow  FROM `shop_management` WHERE id=".$search_id;
				$get_shop = parent::rb_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shopify_product_variant_create_allow FROM `shop_management` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::rb_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::rb_insertShopidInSearchSettings_f_mdl($shop_id,'natural');
					}
				}
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}


	public function jl_add_new_shop_install_token_post(){
		if(isset($_POST['sit_shop']) && !empty($_POST['sit_shop'])){
			$shop = trim($_POST['sit_shop']);
			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="'.$shop.'"';
			$exist =  parent::jl_selectTable_f_mdl($sql);
			if(empty($exist)){
				$token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];
				parent::jl_insertTable_f_mdl('shop_install_token',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=jl_shop_installation');
	}
	public function jl_get_page_permission_list_post(){
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
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY shop_management.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(shop_management.id) as count
                FROM `shop_management`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::jl_selectTable_f_mdl($sql);

		$sql1="
                SELECT shop_management.id as shop_id, shop_management.shop_name, shop_management.email
                FROM `shop_management`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::jl_selectTable_f_mdl($sql1);

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

		$image_upload_url = str_replace('login.php','',common::JL_APP_INSTALL_URL).'images/uploads/';

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			$html .= '<th>Email</th>';// class="sort_th" data-sort_field="shop_order_id"

			//$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$single['shop_id'].'"';
					$as_data = parent::jl_selectTable_f_mdl($sql);
					$sender_email = $single['email'];

					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>';
					if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
						$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					}
					$html .= ' '.$single['shop_name'];
					$html .= '</td>';

					$html .= '<td>'.$sender_email.'</td>';

					//$html .= '<td>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					//$html .= '<a href="index.php?do=jl_page_shop_settings&shop_id='.$single['shop_id'].'" class="btn btn-sm btn-primary">Settings</a>';
					//$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="3" align="center">No Record Found</td>';
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

	public function dl_get_shop_installation_list_post(){
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

		$sql="
                SELECT count(id) as count
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::dl_selectTable_f_mdl($sql);

		$sql1="
                SELECT id, shop, install_token, add_date
                FROM `shop_install_token`
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::dl_selectTable_f_mdl($sql1);

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
			$html .= '<th>Shop</th>';// class="sort_th" data-sort_field="shop_order_id"
			//$html .= '<th>Installation Link</th>';
			$html .= '<th>Date</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>'.$single['shop'].'</td>';
					$html .= '<td>'.($single['add_date']!=''?date('d M Y',$single['add_date']):'').'</td>';
					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="4" align="center">No Record Found</td>';
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
	public function dl_add_new_shop_install_token_post(){
		if(isset($_POST['sit_shop']) && !empty($_POST['sit_shop'])){
			$shop = trim($_POST['sit_shop']);
			$sql = 'SELECT id FROM `shop_install_token` WHERE shop="'.$shop.'"';
			$exist =  parent::dl_selectTable_f_mdl($sql);
			if(empty($exist)){
				$token = str_replace('==','',base64_encode(rand(100000,999999).time()));
				$insert_data = [
					'shop' => $shop,
					'install_token' => $token,
					'add_date' => time()
				];
				parent::dl_insertTable_f_mdl('shop_install_token',$insert_data);
				$_SESSION['SUCCESS'] = 'TRUE';
				$_SESSION['MESSAGE'] = 'Added successfully.';
			}else{
				$_SESSION['SUCCESS'] = 'FALSE';
				$_SESSION['MESSAGE'] = 'Shop is already existed. Please check in list for installation link.';
			}
		}else{
			$_SESSION['SUCCESS'] = 'FALSE';
			$_SESSION['MESSAGE'] = 'Invalid request.';
		}

		header('location:index.php?do=dl_shop_installation');
	}
	public function dl_get_page_permission_list_post(){
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
					shop_management.shop_name LIKE '%$keyword%' OR
					shop_management.email LIKE '%$keyword%'
                )";
		}
		$cond_order = 'ORDER BY search_page_permission.id DESC';
		if(!empty($sort_field)){
			$cond_order = 'ORDER BY '.$sort_field.' '.$sort_type;
		}

		$sql="
                SELECT count(search_page_permission.id) as count
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword
            ";
		$all_count = parent::dl_selectTable_f_mdl($sql);

		$sql1="
                SELECT search_page_permission.id, search_page_permission.shop_id, search_page_permission.search_diamond_allow,search_page_permission.search_lab_grown_allow,
				shop_management.shop_name, shop_management.email
                FROM `search_page_permission`
                LEFT JOIN `shop_management` ON shop_management.id = search_page_permission.shop_id
                WHERE 1
                $cond_keyword

                $cond_order
                LIMIT $start,$end
            ";
		$all_list = parent::dl_selectTable_f_mdl($sql1);

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

		$image_upload_url = str_replace('login.php','',common::DL_APP_INSTALL_URL).'images/uploads/';

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
			$html .= '<th>Shop & Email</th>';// class="sort_th" data-sort_field="shop_order_id"

			$html .= '<th>Natural Diamond</th>';
			$html .= '<th>Labgrown Diamond</th>';

			$html .= '<th>Action</th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';

			if(!empty($all_list)){
				$sr = $sr_start;
				foreach($all_list as $single){
					$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$single['shop_id'].'"';
					$as_data = parent::dl_selectTable_f_mdl($sql);
					$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$single['shop_id'].'"';
					$ets_data = parent::dl_selectTable_f_mdl($sql);

					if($single['search_diamond_allow']=='1'){
						$search_diamond_allow_chk = 'Yes';
					}else{
						$search_diamond_allow_chk = 'No';
					}
					if($single['search_lab_grown_allow']=='1'){
						$search_lab_grown_allow_chk = 'Yes';
					}else{
						$search_lab_grown_allow_chk = 'No';
					}
					$sender_email = $single['email'];
					if(isset($ets_data[0]['email_sender_address']) && !empty($ets_data[0]['email_sender_address'])){
						$sender_email = $ets_data[0]['email_sender_address'];
					}

					$html .= '<tr>';
					$html .= '<td>'.$sr.'</td>';
					$html .= '<td>';
					if(isset($as_data[0]['shop_logo']) && !empty($as_data[0]['shop_logo'])){
						$html .= '<img src="'.$image_upload_url.$as_data[0]['shop_logo'].'" style="width:70px;">';
					}
					$html .= ' '.$single['shop_name'].'<br><b>'.$sender_email.'</b>';
					$html .= '</td>';

					$html .= '<td>'.$search_diamond_allow_chk.'</td>';
					$html .= '<td>'.$search_lab_grown_allow_chk.'</td>';
					
					$html .= '<td>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary upload_logo_btn" data-shop_id="'.$single['shop_id'].'">Upload Logo</button>';
					//$html .= '<button type="button" class="btn btn-sm btn-primary edit_shop_btn" data-shop_id="'.$single['shop_id'].'" data-sender_email="'.$sender_email.'">Edit Email</button>';
					$html .= '<a href="index.php?do=dl_page_shop_settings&shop_id='.$single['shop_id'].'" class="btn btn-sm btn-primary">Settings</a>';
					$html .= '</td>';

					$html .= '</tr>';
					$sr++;
				}
			}else{
				$html .= '<tr>';
				$html .= '<td colspan="5" align="center">No Record Found</td>';
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
	public function dl_change_permission_status(){
		if(isset($_POST['id']) && isset($_POST['new_status']) && isset($_POST['field'])){
			$search_id = $_POST['id'];
			$field = $_POST['field'];
			$status = $_POST['new_status'];

			$update_data = [
				$_POST['field'] => $_POST['new_status']
			];
			parent::dl_updateTable_f_mdl('search_page_permission',$update_data,'id="'.$_POST['id'].'"');

			if ($field=='search_diamond_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::dl_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_natural` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::dl_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::dl_insertShopidInSearchSettings_f_mdl($shop_id,'natural');
					}
				}
			}
			else if ($field=='search_lab_grown_allow' && $status==1) {
				$sql = "SELECT shop_id  FROM `search_page_permission` WHERE id=".$search_id;
				$get_shop = parent::dl_selectTable_f_mdl($sql);
				if (!empty($get_shop)) {
					$shop_id = $get_shop[0]['shop_id'];
					$sql1 = "SELECT shop_id FROM `search_page_settings_lab_grown` WHERE shop_id = ".$shop_id;
					$get_search_page = parent::dl_selectTable_f_mdl($sql1);
					if (empty($get_search_page)) {
						parent::dl_insertShopidInSearchSettings_f_mdl($shop_id,'labgrown');
					}
				}
			}
			#END


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Status changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function dl_edit_shop_details(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id']) ){
			$shop_id = $_POST['shop_id'];

			$sql = 'SELECT id FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
			$email_template_settings_data = parent::dl_selectTable_f_mdl($sql);
			if(isset($email_template_settings_data[0]['id'])){
				$update_data = [
					'email_sender_address' => $_POST['sender_email']
				];
				parent::dl_updateTable_f_mdl('email_template_settings',$update_data,'id="'.$email_template_settings_data[0]['id'].'"');
			}else{
				$insert_data = [
					'shop_id' => $shop_id,
					'email_sender' => '',
					'email_sender_address' => $_POST['sender_email'],
					'email_reciever_address' => '',
					'email_template' => '',
					'status' => '1',
				];
				parent::dl_insertTable_f_mdl('email_template_settings',$insert_data);
			}


			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Saved successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function dl_get_details_by_shop_id($shop_id){
		$sql = 'SELECT shop_name, email FROM shop_management WHERE id="'.$shop_id.'"';
		$data = parent::dl_selectTable_f_mdl($sql);
		return $data;
	}
	public function dl_get_permission_by_shop_id($shop_id){
		$sql = 'SELECT * FROM search_page_permission WHERE shop_id="'.$shop_id.'"';
		$data = parent::dl_selectTable_f_mdl($sql);
		return $data;
	}
	public function dl_get_email_sender_address_by_shop_id($shop_id){
		$sql = 'SELECT email_sender_address FROM email_template_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::dl_selectTable_f_mdl($sql);
		return $data;
	}
	public function dl_get_api_settings_by_shop_id($shop_id){
		$sql = 'SELECT shop_logo FROM api_settings WHERE shop_id="'.$shop_id.'"';
		$data = parent::dl_selectTable_f_mdl($sql);
		return $data;
	}

	protected function insertShopidInSearchSettingsGemstone_f($shop_id)
	{
		$sql = 'SELECT smm_id FROM `sorting_main_module` WHERE smm_type="GEMSTONE"';
		$smm_data = parent::selectTable_f_mdl($sql);
		$smmd_order = 1;
		foreach($smm_data as $single_smm){
			$sql = "SELECT smmd_id FROM `store_main_module_data_gemstone` WHERE smmd_shop_id = '".$shop_id."' and smmd_smm_id='".$single_smm['smm_id']."'";
			$smmExists = parent::selectSingleTable_f_mdl($sql);
			if(empty($smmExists)){
				$smmd_insert_data = [
					'smmd_shop_id' => $shop_id,
					'smmd_smm_id' => $single_smm['smm_id'],
					'smmd_display' => 'show',
					'smmd_order' => $smmd_order,
					'smmd_add_date' => time(),
				];
				parent::insertTable_f_mdl('store_main_module_data_gemstone',$smmd_insert_data);
				$smmd_order++;
			}

			$sql = 'SELECT ssm_id FROM `sorting_sub_module` WHERE ssm_smm_id="'.$single_smm['smm_id'].'"';
			$ssm_data = parent::selectTable_f_mdl($sql);
			if(!empty($ssm_data)){
				$ssmd_order = 1;
				foreach($ssm_data as $single_ssm){
					$sql = "SELECT ssm_id FROM `store_sub_module_data_gemstone` WHERE ssmd_shop_id = '".$shop_id."' and ssmd_ssm_id='".$single_ssm['ssm_id']."'";
					$ssmdExists = parent::selectSingleTable_f_mdl($sql);
					if(empty($ssmdExists)){
						$ssmd_insert_data = [
							'ssmd_shop_id' => $shop_id,
							'ssmd_ssm_id' => $single_ssm['ssm_id'],
							'ssmd_display' => 'show',
							'ssmd_order' => $ssmd_order,
							'ssmd_add_date' => time(),
						];
						parent::insertTable_f_mdl('store_sub_module_data_gemstone',$ssmd_insert_data);
						$ssmd_order++;
					}
					
					$sql = 'SELECT scm_id FROM `sorting_child_module` WHERE scm_ssm_id="'.$single_ssm['ssm_id'].'"';
					$scm_data = parent::selectTable_f_mdl($sql);
					if(!empty($scm_data)){
						$scmd_order = 1;
						foreach($scm_data as $single_scm){
							$sql = "SELECT scmd_id FROM `store_child_module_data_gemstone` WHERE scmd_shop_id= '".$shop_id."' and scmd_scm_id ='".$single_scm['scm_id']."'";
							$scmdExists = parent::selectSingleTable_f_mdl($sql);
							if(empty($scmdExists)){
								$scmd_insert_data = [
									'scmd_shop_id' => $shop_id,
									'scmd_scm_id' => $single_scm['scm_id'],
									'scmd_display' => 'show',
									'scmd_order' => $scmd_order,
									'scmd_add_date' => time(),
								];
								parent::insertTable_f_mdl('store_child_module_data_gemstone',$scmd_insert_data);
								$scmd_order++;
							}
						}
					}
				}
			}
		}
	}

	public function shopDiamondCounts() {
		$sql = "SELECT count(id) shop_counts FROM `shop_management` LIMIT 1";
		return parent::selectTable_f_mdl($sql);
	}

	public function shopRingCreatorCounts() {
		$sql = "SELECT count(id) shop_counts FROM `shop_management` LIMIT 1";
		return parent::rb_selectTable_f_mdl($sql);
	}

	public function shopJewelryLoaderCounts() {
		$sql = "SELECT count(id) shop_counts FROM `shop_management` LIMIT 1";
		return parent::jl_selectTable_f_mdl($sql);
	}
	
	public function fetchAppHealths() {
		$sql = "SELECT id, app_title, app_slug, status, DATE_FORMAT(created_at, '%b %d, %Y') AS created_at FROM `app_health`";
		return parent::hl_selectTable_f_mdl($sql);
	}

	public function fetchAppHealthLogs(){
		if(isset($_REQUEST['health_id']) && !empty($_REQUEST['health_id']) ){
			$health_id = $_REQUEST['health_id'];

			$sql = "SELECT status, reason, DATE_FORMAT(created_at, '%b %d, %Y') AS created_at FROM `app_logs` WHERE app_id = ".$health_id." ORDER BY `app_logs`.`id` DESC LIMIT 50";
			$app_log_data = parent::hl_selectTable_f_mdl($sql);

			$html = '';
			if(!empty($app_log_data)){
				foreach ($app_log_data as $key => $entry_value) {
					$class = 'bg-red';
					$class1 = 'fa-bug bg-red';
					if ($entry_value["status"]=="Active") {
						$class = 'bg-green';
						$class1 = 'fa-check bg-green';
					}
					$html .= '<div class="time-label">';
	                    $html .= '<span class="'.$class.'">'.$entry_value['created_at'].'</span>';
	                $html .= '</div>';
	                $html .= '<div>';
	                    $html .= '<i class="fa '.$class1.'"></i>';
	                    $html .= '<div class="timeline-item">';
	                        // <!-- <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span> -->
	                        // <!-- <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3> -->
	                        $html .= '<div class="timeline-body">'.$entry_value['reason'].'</div>';
	                    $html .= '</div>';
	                $html .= '</div>';
				}
				$html .= '<div>';
	                $html .= '<i class="fas fa-clock bg-gray"></i>';
	            $html .= '</div>';
			}
			if (!empty($html)) {
				$res['SUCCESS'] = 'TRUE';
				$res['DATA'] = ($html);
			}else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'No data found.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function get_natural_origin_by_shop_id($shop_id){
		$sql = 'SELECT * FROM store_module_origin WHERE smo_shop_id="'.$shop_id.'" ORDER BY smo_id ASC';
		return parent::selectTable_f_mdl($sql);
	}

	public function natural_add_edit_module_origin_post(){
		if(isset($_POST['smo_shop_id']) && !empty($_POST['smo_shop_id'])){
			$smo_id = trim($_POST['smo_id']);
			$smo_shop_id = trim($_POST['smo_shop_id']);
			if(!empty($smo_id)){
				//update
				$update_data = [
					'smo_label' => $_POST['smo_label'],
					'smo_short_code' => parent::handlize($_POST['smo_label']),
					'smo_vdb_value' => $_POST['smo_vdb_value'],
					'smo_modify_date' => time()
				];
				parent::updateTable_f_mdl('store_module_origin',$update_data,'smo_id="'.$smo_id.'"');

				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$insert_data = [
					'smo_shop_id' => $smo_shop_id,
					'smo_label' => $_POST['smo_label'],
					'smo_short_code' => parent::handlize($_POST['smo_label']),
					'smo_display' => 'show',
					'smo_vdb_value' => $_POST['smo_vdb_value'],
					'smo_status' => '1',
					'smo_add_date' => time(),
					'smo_modify_date' => ''
				];
				parent::insertTable_f_mdl('store_module_origin',$insert_data);
				
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function natural_origin_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'smo_display' => $_POST['new_display']
			];
			parent::updateTable_f_mdl('store_module_origin',$update_data,'smo_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function natural_delete_origin(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::deleteTable_f_mdl('store_module_origin','smo_id="'.$id.'" AND smo_shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function get_labgrown_origin_by_shop_id($shop_id){
		$sql = 'SELECT * FROM store_module_origin_lab_grown WHERE smo_shop_id="'.$shop_id.'" ORDER BY smo_id ASC';
		return parent::selectTable_f_mdl($sql);
	}

	public function labgrown_add_edit_module_origin_post(){
		if(isset($_POST['smo_shop_id']) && !empty($_POST['smo_shop_id'])){
			$smo_id = trim($_POST['smo_id']);
			$smo_shop_id = trim($_POST['smo_shop_id']);
			if(!empty($smo_id)){
				//update
				$update_data = [
					'smo_label' => $_POST['smo_label'],
					'smo_short_code' => parent::handlize($_POST['smo_label']),
					'smo_vdb_value' => $_POST['smo_vdb_value'],
					'smo_modify_date' => time()
				];
				parent::updateTable_f_mdl('store_module_origin_lab_grown',$update_data,'smo_id="'.$smo_id.'"');

				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$insert_data = [
					'smo_shop_id' => $smo_shop_id,
					'smo_label' => $_POST['smo_label'],
					'smo_short_code' => parent::handlize($_POST['smo_label']),
					'smo_display' => 'show',
					'smo_vdb_value' => $_POST['smo_vdb_value'],
					'smo_status' => '1',
					'smo_add_date' => time(),
					'smo_modify_date' => ''
				];
				parent::insertTable_f_mdl('store_module_origin_lab_grown',$insert_data);
				
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function labgrown_origin_display_change(){
		if(isset($_POST['id']) && isset($_POST['new_display'])){
			$id = $_POST['id'];
			$display = $_POST['new_display'];

			$update_data = [
				'smo_display' => $_POST['new_display']
			];
			parent::updateTable_f_mdl('store_module_origin_lab_grown',$update_data,'smo_id="'.$id.'"');

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Display changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function labgrown_delete_origin(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['dlt_id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::deleteTable_f_mdl('store_module_origin_lab_grown','smo_id="'.$id.'" AND smo_shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}

	public function rb_get_custom_field_builder_by_shop_id($shop_id){
		$sql = 'SELECT custom_field_builder.*
 		FROM custom_field_builder WHERE shop_id="'.$shop_id.'" ORDER BY cfb_order ASC';
		$data = parent::rb_selectTable_f_mdl($sql);
		return $data;
	}
	public function rb_delete_custom_field_builder_post(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				parent::rb_deleteTable_f_mdl('custom_field_builder','id="'.$id.'" AND shop_id="'.$shop_id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Deleted successfully.';
			}
			else{
				$res['SUCCESS'] = 'FALSE';
				$res['MESSAGE'] = 'Invalid request.';
			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_add_edit_custom_field_builder_post(){
		if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
			$id = trim($_POST['id']);
			$shop_id = trim($_POST['shop_id']);
			if(!empty($id)){
				//update
				$update_data = [
					'input_type' => $_POST['input_type'],
					'label_text' => $_POST['label_text'],
					'help_text' => $_POST['help_text'],
					'placeholder' => $_POST['placeholder'],
					'input_values' => $_POST['input_values'],
					'default_value' => $_POST['default_value'],
					'lineitem_property_key' => $_POST['lineitem_property_key'],
					'input_class' => $_POST['input_class'],
					'input_id' => $_POST['input_id'],
					'additional_price' => $_POST['additional_price'],
					'is_required' => $_POST['is_required'],
					'is_inline' => $_POST['is_inline']
				];
				parent::rb_updateTable_f_mdl('custom_field_builder',$update_data,'id="'.$id.'"');
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Updated successfully.';
			}
			else{
				//insert
				$cfb_order = 1;
				$sql = 'SELECT MAX(cfb_order) as max_cfb_order FROM custom_field_builder WHERE shop_id="'.$shop_id.'"';
				$data = parent::rb_selectTable_f_mdl($sql);
				if(isset($data[0]['max_cfb_order']) && !empty($data[0]['max_cfb_order'])){
					$cfb_order = intval($data[0]['max_cfb_order'])+1;
				}

				$insert_data = [
					'shop_id' => $shop_id,
					'input_type' => $_POST['input_type'],
					'label_text' => $_POST['label_text'],
					'help_text' => $_POST['help_text'],
					'placeholder' => $_POST['placeholder'],
					'input_values' => $_POST['input_values'],
					'default_value' => $_POST['default_value'],
					'lineitem_property_key' => $_POST['lineitem_property_key'],
					'input_class' => $_POST['input_class'],
					'input_id' => $_POST['input_id'],
					'additional_price' => $_POST['additional_price'],
					'is_required' => $_POST['is_required'],
					'is_inline' => $_POST['is_inline'],
					'cfb_order' => $cfb_order,
					'is_display' => 'show'
				];
				parent::rb_insertTable_f_mdl('custom_field_builder',$insert_data);
				$res['SUCCESS'] = 'TRUE';
				$res['MESSAGE'] = 'Added successfully.';

			}
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
	public function rb_change_custom_field_order(){
		if(isset($_POST['shop_id']) && isset($_POST['custom_field_order'])){
			$shop_id = $_POST['shop_id'];
			$custom_field_order_arr = json_decode($_POST['custom_field_order'],1);

			foreach($custom_field_order_arr as $single){
				if(isset($single['id']) && isset($single['order'])){
					$update_data = [
						'cfb_order' => $single['order']
					];
					parent::rb_updateTable_f_mdl('custom_field_builder',$update_data,'shop_id="'.$shop_id.'" AND id="'.$single['id'].'"');
				}
			}

			$res['SUCCESS'] = 'TRUE';
			$res['MESSAGE'] = 'Sorting changed successfully.';
		}else{
			$res['SUCCESS'] = 'FALSE';
			$res['MESSAGE'] = 'Invalid request.';
		}
		echo json_encode($res,1);
	}
}