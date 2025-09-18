<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'security', 'auth_helper')); // auth_helper 로드
		$this->load->library('session');
		$this->load->model('member_model'); // 회원관리 기능에서 필요

		// 레벨 10 (어드민)만 접근 가능
		check_level_access(10, 'login'); // 권한이 없으면 로그인 페이지로 리다이렉트
	}

	public function dashboard()
	{
		$data['page_title'] = '관리자 대시보드';
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('layouts/admin_footer');
	}

	// 다른 Admin 메소드들은 그대로 유지
	// ...
	// AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드 (Member.php에서 복사해옴)
	protected function load_admin_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}
}
