<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'auth_helper'));
		$this->load->library('session');

		// 레벨 3-9 매장 관리자만 접근 가능
		$user_level = get_user_level();
		if (!is_logged_in() || $user_level < 3 || $user_level > 9) {
			$this->session->set_flashdata('error', '매장관리자만 접근 가능한 페이지입니다.');
			redirect('login');
		}
	}

	public function index()
	{
		$data['page_title'] = '매장 관리자 대시보드';
		// TODO: 매장 관리자를 위한 AdminLTE 테마 레이아웃 또는 다른 테마를 적용할 수 있습니다.
		// 현재는 AdminLTE 레이아웃을 재활용합니다.
		$this->load->view('layouts/admin_header', $data); // AdminLTE 레이아웃 활용
		$this->load->view('layouts/shop_sidebar'); // 매장관리자용 메뉴로 변경 필요 시 Shop_sidebar.php 생성
		$this->load->view('shop/dashboard', $data); // 매장 관리자 대시보드 뷰
		$this->load->view('layouts/admin_footer');
	}

	/// 예시: 레벨 9 그룹회사를 위한 본사 등록 페이지
	public function head_office_create()
	{
		check_level_access(9, 'shop'); // 레벨 9 이상만 접근 가능, 없으면 shop 대시보드로 리다이렉트
		$data['page_title'] = '본사 등록';
		$this->load_shop_view('shop/head_office/create', $data);
	}

	// 예시: 레벨 9 그룹회사를 위한 본사 목록 페이지
	public function head_office_list()
	{
		check_level_access(9, 'shop'); // 레벨 9 이상만 접근 가능
		$data['page_title'] = '본사 목록';
		$this->load_shop_view('shop/head_office/list', $data);
	}

	// 다른 레벨별 기능 메소드들도 유사하게 check_level_access 적용
	public function sub_head_office_create()
	{
		check_level_access(8, 'shop'); // 레벨 8 이상만 접근 가능
		$data['page_title'] = '부본사 등록';
		$this->load_shop_view('shop/sub_head_office/create', $data);
	}

	public function branch_office_create()
	{
		check_level_access(7, 'shop'); // 레벨 7 이상만 접근 가능
		$data['page_title'] = '지사 등록';
		$this->load_shop_view('shop/branch_office/create', $data);
	}

	public function agency_create()
	{
		check_level_access(6, 'shop'); // 레벨 6 이상만 접근 가능
		$data['page_title'] = '총판 등록';
		$this->load_shop_view('shop/agency/create', $data);
	}

	public function sales_place_create()
	{
		check_level_access(5, 'shop'); // 레벨 5 이상만 접근 가능
		$data['page_title'] = '영업장 등록';
		$this->load_shop_view('shop/sales_place/create', $data);
	}

	public function store_create()
	{
		check_level_access(4, 'shop'); // 레벨 4 이상만 접근 가능
		$data['page_title'] = '매장 등록';
		$this->load_shop_view('shop/store/create', $data);
	}

	public function member_register()
	{
		check_level_access(3, 'shop'); // 레벨 3 이상만 접근 가능
		$data['page_title'] = '회원 등록';
		$this->load_shop_view('shop/member/register', $data);
	}

	public function member_list()
	{
		check_level_access(3, 'shop'); // 레벨 3 이상만 접근 가능
		$data['page_title'] = '회원 목록';
		$this->load_shop_view('shop/member/list', $data); // member_list 뷰를 로드하도록 추가
	}


	// 매장 관리자 AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_shop_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/shop_sidebar'); // shop_sidebar 로드
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}
}
