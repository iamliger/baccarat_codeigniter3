<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'auth_helper', 'form_helper')); // form_helper 추가
		$this->load->library(array('session', 'form_validation', 'pagination')); // pagination 추가
		$this->load->model(array('shop_model', 'member_model', 'settings_model')); // settings_model 추가

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

		$current_user_idx = $this->session->userdata('user_idx');
		$current_user_level = $this->session->userdata('level');
		$current_user_info = $this->member_model->get_user_by_idx($current_user_idx);
		$current_user_lineage_path = $current_user_info['lineage_path'];

		// 오늘 날짜 및 기간 설정 (예시: 지난 7일)
		$end_date = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-7 days'));

		// 1. 본인의 재무 요약 정보
		$data['my_financial_summary'] = $this->shop_model->get_my_financial_summary($current_user_idx, $start_date, $end_date);
		$data['current_user_commission_rate'] = $current_user_info['commission_rate'];


		// 2. 하위 라인 정보 가져오기 (매장 관리자 레벨에 따라 바로 아래 레벨의 관리자만 조회)
		// 레벨 3은 레벨 2(일반회원)를 조회, 레벨 4는 레벨 3(매장)을 조회, ..., 레벨 9는 레벨 8(본사)를 조회
		$target_child_level = $current_user_level - 1;

		// 특별 예외: 레벨 3은 일반회원(레벨 2)까지 포함
		if ($current_user_level == 3) {
			// 레벨 3 관리자의 하위 일반 회원 (레벨 2)들을 가져옴
			$data['child_managers_or_members'] = $this->shop_model->get_descendants(
				$current_user_idx,
				$current_user_lineage_path,
				FALSE, // 자기 자신 제외
				1, // 일반 회원 (레벨 1, 2)까지 포함
				2
			);
		} elseif ($current_user_level > 3) {
			$data['child_managers_or_members'] = $this->shop_model->get_descendants(
				$current_user_idx,
				$current_user_lineage_path,
				FALSE,
				$target_child_level, // 바로 아래 레벨의 관리자만 조회
				$target_child_level
			);
		} else {
			$data['child_managers_or_members'] = array();
		}


		// 하위 라인의 user_idx 목록 추출 (재무 요약을 위해)
		$child_user_idxes = array_column($data['child_managers_or_members'], 'user_idx');
		if (!empty($child_user_idxes)) {
			$data['child_financial_summaries'] = $this->shop_model->get_financial_summary_for_users($child_user_idxes, $start_date, $end_date);
		} else {
			$data['child_financial_summaries'] = array();
		}

		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/shop_sidebar', $data);
		$this->load->view('shop/dashboard', $data);
		$this->load->view('layouts/admin_footer', $data);
	}

	// 매장 관리자 하위 라인 목록들을 위한 공통 로직
	private function _load_child_list_view($page_title, $target_level, $view_path)
	{
		$current_user_idx = $this->session->userdata('user_idx');
		$current_user_info = $this->member_model->get_user_by_idx($current_user_idx);
		$current_user_lineage_path = $current_user_info['lineage_path'];

		$data['page_title'] = $page_title;
		$data['child_items'] = $this->shop_model->get_descendants(
			$current_user_idx,
			$current_user_lineage_path,
			FALSE,
			$target_level,
			$target_level
		);

		// 재무 요약 데이터 가져오기 (각 하위 항목의 재무 요약)
		$child_user_idxes = array_column($data['child_items'], 'user_idx');
		if (!empty($child_user_idxes)) {
			$end_date = date('Y-m-d');
			$start_date = date('Y-m-d', strtotime('-7 days')); // 기간은 대시보드와 동일하게 설정
			$data['child_financial_summaries'] = $this->shop_model->get_financial_summary_for_users($child_user_idxes, $start_date, $end_date);
		} else {
			$data['child_financial_summaries'] = array();
		}

		$this->load_shop_view($view_path, $data);
	}

	// 레벨 9: 그룹회사 - 본사 관리
	public function head_office_create()
	{
		check_level_access(9, 'shop');
		$data['page_title'] = '본사 등록';
		$this->load_shop_view('shop/head_office/create', $data);
	}
	public function head_office_list()
	{
		check_level_access(9, 'shop');
		$this->_load_child_list_view('본사 목록', 8, 'shop/head_office/list');
	}

	// 레벨 8: 본사 - 부본사 관리
	public function sub_head_office_create()
	{
		check_level_access(8, 'shop');
		$data['page_title'] = '부본사 등록';
		$this->load_shop_view('shop/sub_head_office/create', $data);
	}
	public function sub_head_office_list()
	{
		check_level_access(8, 'shop');
		$this->_load_child_list_view('부본사 목록', 7, 'shop/sub_head_office/list');
	}

	// 레벨 7: 부본사 - 지사 관리
	public function branch_office_create()
	{
		check_level_access(7, 'shop');
		$data['page_title'] = '지사 등록';
		$this->load_shop_view('shop/branch_office/create', $data);
	}
	public function branch_office_list()
	{
		check_level_access(7, 'shop');
		$this->_load_child_list_view('지사 목록', 6, 'shop/branch_office/list');
	}

	// 레벨 6: 지사 - 총판 관리
	public function agency_create()
	{
		check_level_access(6, 'shop');
		$data['page_title'] = '총판 등록';
		$this->load_shop_view('shop/agency/create', $data);
	}
	public function agency_list()
	{
		check_level_access(6, 'shop');
		$this->_load_child_list_view('총판 목록', 5, 'shop/agency/list');
	}

	// 레벨 5: 총판 - 영업장 관리
	public function sales_place_create()
	{
		check_level_access(5, 'shop');
		$data['page_title'] = '영업장 등록';
		$this->load_shop_view('shop/sales_place/create', $data);
	}
	public function sales_place_list()
	{
		check_level_access(5, 'shop');
		$this->_load_child_list_view('영업장 목록', 4, 'shop/sales_place/list');
	}

	// 레벨 4: 영업장 - 매장 관리
	public function store_create()
	{
		check_level_access(4, 'shop');
		$data['page_title'] = '매장 등록';
		$this->load_shop_view('shop/store/create', $data);
	}
	public function store_list()
	{
		check_level_access(4, 'shop');
		$this->_load_child_list_view('매장 목록', 3, 'shop/store/list');
	}

	// 레벨 3: 매장 - 회원 관리
	public function member_register()
	{
		check_level_access(3, 'shop');
		$data['page_title'] = '회원 등록';
		$this->load_shop_view('shop/member/register', $data);
	}
	public function member_list()
	{
		check_level_access(3, 'shop');
		$data['page_title'] = '회원 목록';

		$current_user_idx = $this->session->userdata('user_idx');
		$current_user_info = $this->member_model->get_user_by_idx($current_user_idx);
		$current_user_lineage_path = $current_user_info['lineage_path'];

		// 레벨 3 관리자의 하위 일반 회원 (레벨 1, 2)들을 가져옴
		$data['child_items'] = $this->shop_model->get_descendants(
			$current_user_idx,
			$current_user_lineage_path,
			FALSE, // 자기 자신 제외
			1, // 일반 회원 (레벨 1, 2)까지 포함
			2
		);

		// 재무 요약 데이터 가져오기
		$child_user_idxes = array_column($data['child_items'], 'user_idx');
		if (!empty($child_user_idxes)) {
			$end_date = date('Y-m-d');
			$start_date = date('Y-m-d', strtotime('-7 days'));
			$data['child_financial_summaries'] = $this->shop_model->get_financial_summary_for_users($child_user_idxes, $start_date, $end_date);
		} else {
			$data['child_financial_summaries'] = array();
		}

		$this->load_shop_view('shop/member/list', $data);
	}

	// 개별 하위 관리자 또는 회원의 상세 정보 페이지 (추후 구현)
	public function detail($memberid = null)
	{
		if ($memberid === null) {
			show_404();
		}

		$member = $this->member_model->get_member_by_id($memberid);
		if (empty($member)) {
			show_404();
		}

		$data['page_title'] = $member['memberid'] . ' 하위 상세 정보';
		$data['member'] = $member;

		// 현재 로그인한 매장 관리자가 해당 멤버를 관리하는 하위 라인에 속하는지 확인하는 로직 필요
		$current_user_lineage_path = $this->member_model->get_user_by_idx($this->session->userdata('user_idx'))['lineage_path'];
		if (strpos($member['lineage_path'], $current_user_lineage_path) === FALSE && $member['user_idx'] != $this->session->userdata('user_idx')) {
			$this->session->set_flashdata('error', '해당 회원의 상세 정보를 조회할 권한이 없습니다.');
			redirect('shop'); // 권한 없으면 shop 대시보드로
		}

		// 재무 요약 정보 (선택적)
		$end_date = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-7 days'));
		$data['financial_summary'] = $this->shop_model->get_my_financial_summary($member['user_idx'], $start_date, $end_date);


		$this->load_shop_view('shop/detail', $data);
	}


	// 매장 관리자 AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_shop_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/shop_sidebar', $data);
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer', $data);
	}

	public function get_descendants($parent_user_idx, $parent_lineage_path = null, $include_self = FALSE, $min_level = 1, $max_level = 10)
	{
		// 최상위 관리자의 lineage_path를 먼저 가져옵니다.
		if ($parent_lineage_path === null) {
			$parent_info = $this->db->select('lineage_path')->get_where('users', array('user_idx' => $parent_user_idx))->row_array();
			if (empty($parent_info) || empty($parent_info['lineage_path'])) {
				return array(); // 상위 정보가 없으면 빈 배열 반환
			}
			$parent_lineage_path = $parent_info['lineage_path'];
		}

		$this->db->select('user_idx, memberid, level, status, created_at, parent_user_idx, commission_rate, lineage_path');
		$this->db->from('users');
		$this->db->like('lineage_path', $parent_lineage_path . '%', 'after'); // 하위 라인 조회

		if (!$include_self) {
			$this->db->where('user_idx !=', $parent_user_idx); // 자기 자신 제외
		}

		$this->db->where('level >=', $min_level);
		$this->db->where('level <=', $max_level);

		$this->db->order_by('lineage_path', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * 특정 사용자 목록의 재무 요약 정보를 가져옵니다.
	 * (일별 집계된 shop_financials 테이블을 기반으로)
	 *
	 * @param array $user_idx_list 조회할 user_idx 배열
	 * @param string $start_date 조회 시작 날짜 (YYYY-MM-DD)
	 * @param string $end_date 조회 종료 날짜 (YYYY-MM-DD)
	 * @return array 각 user_idx별 재무 요약 데이터
	 */
	public function get_financial_summary_for_users($user_idx_list, $start_date, $end_date)
	{
		if (empty($user_idx_list)) {
			return array();
		}

		$this->db->select('
            user_idx,
            SUM(gross_revenue) as total_gross_revenue,
            SUM(expenses) as total_expenses,
            SUM(net_profit) as total_net_profit,
            SUM(commission_paid) as total_commission_paid,
            SUM(commission_received) as total_commission_received
        ');
		$this->db->from('shop_financials');
		$this->db->where_in('user_idx', $user_idx_list);
		$this->db->where('report_date >=', $start_date);
		$this->db->where('report_date <=', $end_date);
		$this->db->group_by('user_idx');
		$query = $this->db->get();

		$results = array();
		foreach ($query->result_array() as $row) {
			$results[$row['user_idx']] = $row;
		}
		return $results;
	}

	/**
	 * 특정 사용자 (본인)의 재무 요약 정보를 가져옵니다.
	 */
	public function get_my_financial_summary($user_idx, $start_date, $end_date)
	{
		$this->db->select('
            SUM(gross_revenue) as total_gross_revenue,
            SUM(expenses) as total_expenses,
            SUM(net_profit) as total_net_profit,
            SUM(commission_paid) as total_commission_paid,
            SUM(commission_received) as total_commission_received
        ');
		$this->db->from('shop_financials');
		$this->db->where('user_idx', $user_idx);
		$this->db->where('report_date >=', $start_date);
		$this->db->where('report_date <=', $end_date);
		$query = $this->db->get();
		return $query->row_array();
	}
}