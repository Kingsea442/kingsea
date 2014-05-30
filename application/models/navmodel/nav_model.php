<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nav_model extends CI_Model{
	
	const TBL_USER = "user";
	const TBL_LINK = "hyperlink";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * [根据用户名和密码在表中查询是否存在]
	 * @param  [string] $user_name     
	 * @param  [string] $user_password 
	 * @return [bool]                
	 */
	public function login_check($user_name,$user_password){
		$user_input = array('user_name' => $user_name, 'user_password' => $user_password);

		$query = $this->db->where($user_input)->get(self::TBL_USER);

		if ($query->num_rows()>0) {
			return true;
		} else {
			return false;
		}
	}

	public function insert_hyperlink($data){
		if ($this->db->insert(self::TBL_LINK,$data)) {
			return true;
		} else {
			return false;
		}
		

	}

	/**
	 * [按类型取出各个网站的内容]
	 * @return [数组] [这里是个二维数组，每个字数组里存的是相应的网站类型]
	 */
	public function get_allhyperlink(){
		$query1 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '百度谷歌', ));
		$query2 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '好资源', ));
		$query3 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '编程开发', ));
		$query4 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '其它', ));
		$query5 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '技术资讯', ));
		$query6 = $this->db->get_where(self::TBL_LINK,array('hyperlink_type' => '影音书生活', ));

		$hyperlink_data = array('baidugoogle' => $query1,
								'resource' => $query2,
								'programe' => $query3,
								'others' => $query4,
								'news' => $query5,
								'movies' => $query6
		 						);

		return $hyperlink_data;

	}

	/**
	 * [取出一条链接内容]
	 * @param  [整型] $hyperlink_id  [链接id]
	 * @return [array]               [查询结果]
	 */
	public function get_onehyperlink($hyperlink_id){
		$query = $this->db->get_where(self::TBL_LINK,array('hyperlink_id' => $hyperlink_id));
		return $query;
	}

	/**
	 * [修改链接数据]
	 * @param  [整型] $hyperlink_id  [链接id]
	 * @param  [数组] $new_hyperlink [链接的就内容]
	 * @return [type]                [description]
	 */
	public function update_hyperlink($hyperlink_id,$new_hyperlink){
		if ($this->db->update(self::TBL_LINK,$new_hyperlink,array('hyperlink_id' => $hyperlink_id))) {
			return true;
		} else {
			return false;
		}
		
	}

	/**
	 * [根据传过来的链接id参数删除相应的链接]
	 * @param  [整型] $hyperlink_id [网站链接id]
	 * @return [bool]               [删除是否成功]
	 */
	public function delete_hyperlink($hyperlink_id)
	{
		if($this->db->delete(self::TBL_LINK,array('hyperlink_id' => $hyperlink_id))){
			return true;
		}else{
			return false;
		}
	}


}


?>
