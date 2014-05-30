<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Nav_controller extends CI_Controller{
		public function __construct(){
			parent::__construct();	
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model("navmodel/nav_model");
		}
		/**
		 * [进入首页]
		 * @return [null] [直接进入首页]
		 */
		public function index(){
			$all_hyperlink = $this->nav_model->get_allhyperlink();
			$this->load->view("nav/index.html",$all_hyperlink);
		}

		public function is_login()
		{
			$user_status = $this->session->userdata('is_login');
			if ($user_status =='YES') {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * [进入添加链接的页面，进入前先检查是否已经登录]
		 */
		public function add()
		{
			if ($this->is_login()) {
				$this->load->view('nav/add.html');
			} else {
				$this->please_login();
			}
		}

		public function manage()
		{
			$all_hyperlink = $this->nav_model->get_allhyperlink();
			if ($this->is_login()) {
				$this->load->view('nav/manage.html',$all_hyperlink);
			} else {
				$this->please_login();
			}

		}

		public function modify()
		{
			if ($this->is_login()) {
				$old_hyperlink = $this->nav_model->get_onehyperlink($_REQUEST['hyperlink_id']);
				$row = $old_hyperlink->row();
				$data = array('hyperlink_name' => $row->hyperlink_name, 
							  'hyperlink_content' => $row->hyperlink_content,
							  'hyperlink_type' => $row->hyperlink_type,
							  'hyperlink_id' => $row->hyperlink_id
					);

				$this->load->view('nav/modify.html',$data);
			} else {
				$this->please_login();
			}
		}

		public function delete()
		{
			$hyperlink_id = $_REQUEST['hyperlink_id'];

			if ($this->is_login()) {
				if ($this->nav_model->delete_hyperlink($hyperlink_id)) {
					$this->index();
				} else {
					$this->modify();
				}
			} else {
				$this->please_login();
			}
		}

		/**
		 * [修改链接内容]
		 */
		public function update()
		{
			$new_hyperlink = array('hyperlink_id' => $_POST['hyperlink_id'],
									'hyperlink_name' => $_POST['hyperlink_name'],
									'hyperlink_content' => $_POST['hyperlink_content'],
									'hyperlink_type' => $_POST['hyperlink_type'],
								);
			if ($this->nav_model->update_hyperlink($_POST['hyperlink_id'],$new_hyperlink)){
				$this->index();
			} else {
				$this->send_errormessage('更新数据失败!');
			}
		}

		public function login()
		{
			$this->load->view('nav/login.html');
		}

		public function info(){
			$this->load->view('nav/info.html');
		}

		public function setbg()
		{
			if ($this->is_login()) {
				$this->load->view('nav/setbg.html');
			} else {
				$this->please_login();
			}
			
		}

		public function changebg(){
			if ($this->is_login()) {
				$cookie_bg = $_REQUEST['id'];
				setcookie('bg_id',$cookie_bg,time()+604800);
				$this->setbg();			
			} else {
				$this->send_errormessage('更改背景图片发生错误！');
			}
			

		}
		/**
		 * [检查用户名和密码是否正确，如果正确加入session，保存用户名和登录状态]
		 */
		public function login_check(){
			$is_right = $this->nav_model->login_check($_POST['user_name'],$_POST['user_password']);
			if ($is_right) {
				$session_data = array('user_name' => $_POST['user_name'],
									  'is_login' => 'YES'
				 					);
				$this->session->set_userdata($session_data);//设置session

				$this->load->view("nav/add.html");
			} else {
				$this->send_errormessage("用户名或密码错误");
			}
			
		}


		/**
		 * [添加链接]
		 */
		public function insert_hyperlink(){
			$data =  array('hyperlink_name' => $_POST["hyperlink_name"],
							'hyperlink_content' => $_POST['hyperlink_content'],
							'hyperlink_type' => $_POST['hyperlink_type']
			 			  );
			if ($this->nav_model->insert_hyperlink($data)) {
				$this->add();
			} else {
				$this->send_errormessage('添加链接失败');
			}
		}

		/**
		 * 退出
		 */
		public function login_out()
		{
			$session_data = array('user_name' => null,
								  'is_login' => null
			 					);
			$this->session->set_userdata($session_data);//设置session
			$this->index();
		}

		/**
		 * [发送错误信息]
		 */
		public function send_errormessage($message){
			$error_message = array('message' => $message);
			$this->load->view('nav/error.html',$error_message);
		}

		/**
		 * [先跳转到登录页面]
		 */
		public function please_login()
		{
			$this->load->view('nav/pleaselogin.html');
		}
	}
?>