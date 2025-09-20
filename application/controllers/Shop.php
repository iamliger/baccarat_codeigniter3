<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'auth_helper', 'form_helper'));
		$this->load->library(array('session', 'form_validation', 'pagination'));
		// --- 수정 필요 부분 시작 ---
		$this->load->model(array('shop_model', 'member_model', 'settings_model', 'auth_model')); // auth_model 로드
		// --- 수정 필요 부분 끝 ---

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

		$data['current_user_commission_rate'] = $current_user_info['commission_rate'];

		$end_date = date('Y-m-d');
		$start_date = date('Y-m-d', strtotime('-7 days'));

		$data['my_financial_summary'] = $this->shop_model->get_my_financial_summary($current_user_idx, $start_date, $end_date);


		// 2. 하위 라인 정보 가져오기 (매장 관리자 레벨에 따라 바로 아래 레벨의 관리자만 조회)
		// 레벨 3은 레벨 2(일반회원)를 조회, 레벨 4는 레벨 3(매장)을 조회, ..., 레벨 9는 레벨 8(본사)를 조회
		$target_child_level = $current_user_level - 1;

		if ($current_user_level == 3) {
			$data['child_managers_or_members'] = $this->shop_model->get_descendants(
				$current_user_idx,
				$current_user_lineage_path,
				FALSE,
				1,
				2
			);
		} elseif ($current_user_level > 3) {
			$data['child_managers_or_members'] = $this->shop_model->get_descendants(
				$current_user_idx,
				$current_user_lineage_path,
				FALSE,
				$target_child_level,
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

		$data['all_descendants'] = $this->shop_model->get_descendants(
			$current_user_idx,
			$current_user_lineage_path,
			TRUE, // 자기 자신도 포함
			1, // 가장 낮은 레벨 (일반 회원)까지 조회
			$current_user_level - 1 // 자신의 바로 아래 레벨부터 시작하는게 일반적이나, 전체를 보려면 1까지
		);

		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/shop_sidebar', $data);
		$this->load->view('shop/dashboard', $data);
		$this->load->view('layouts/admin_footer', $data);
	}

	private function _load_child_creation_form($page_title, $target_entity_level)
	{
		check_level_access($this->session->userdata('level'), 'shop'); // 현재 관리자 레벨 권한 확인

		$data['page_title'] = $page_title;
		$data['target_entity_level'] = $target_entity_level;
		$data['parent_entity_id_for_new_entity'] = $this->session->userdata('assigned_entity_id'); // 현재 관리자의 조직 ID

		// 폼 유효성 검사 및 처리
		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('entity_name', '조직/매장 이름', 'required|max_length[100]');
			$this->form_validation->set_rules('entity_code', '조직/매장 코드', 'required|max_length[50]|is_unique[shop_entities.entity_code]');

			// 관리자 계정 생성 필드
			$this->form_validation->set_rules('manager_memberid', '관리자 아이디', 'required|alpha_dash|min_length[4]|is_unique[users.memberid]');
			$this->form_validation->set_rules('manager_email', '관리자 이메일', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('manager_password', '관리자 비밀번호', 'required|min_length[6]');
			$this->form_validation->set_rules('manager_passconf', '비밀번호 확인', 'required|matches[manager_password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				$this->load_shop_view('shop/child_create_form', $data); // 폼 다시 로드
			} else {
				$entity_data = array(
					'entity_name'              => $this->input->post('entity_name'),
					'entity_code'              => $this->input->post('entity_code'),
					'entity_level'             => $target_entity_level, // 미리 정해진 레벨
					'parent_entity_id'         => $this->session->userdata('assigned_entity_id'), // 현재 관리자의 조직 ID
					'is_active'                => 1 // 기본적으로 활성
				);

				$this->db->trans_begin();

				if ($this->shop_entity_model->add_entity($entity_data)) {
					$new_entity_id = $this->db->insert_id();

					$manager_memberid = $this->input->post('manager_memberid');
					$manager_email = $this->input->post('manager_email');
					$manager_password = $this->input->post('manager_password');
					$manager_level = $target_entity_level; // 관리자 레벨은 조직 레벨과 동일

					// 상위 관리자의 user_idx는 현재 로그인한 관리자의 user_idx가 됩니다.
					$parent_user_idx_for_new_manager = $this->session->userdata('user_idx');

					if ($this->auth_model->register_user_with_details($manager_memberid, $manager_email, $manager_password, $manager_level, $new_entity_id)) {
						$new_manager_user_idx = $this->db->insert_id();

						$this->member_model->update_user_hierarchy(
							$new_manager_user_idx,
							$manager_level,
							$parent_user_idx_for_new_manager, // 현재 로그인한 관리자가 상위 관리자
							0, // 초기 수수료율
							$new_entity_id
						);

						$this->shop_entity_model->update_entity($new_entity_id, array('managed_by_user_idx' => $new_manager_user_idx));

						$this->db->trans_commit();
						$this->session->set_flashdata('success', $page_title . ' 및 관리자 계정이 성공적으로 생성되었습니다.');
						redirect('shop'); // 대시보드로 돌아가기
					} else {
						$this->db->trans_rollback();
						$this->session->set_flashdata('error', '관리자 계정 생성 중 오류가 발생했습니다.');
						$this->load_shop_view('shop/child_create_form', $data);
					}
				} else {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', '조직/매장 엔티티 생성 중 오류가 발생했습니다.');
					$this->load_shop_view('shop/child_create_form', $data);
				}
			}
		} else {
			// GET 요청 시 폼 로드
			$this->load_shop_view('shop/child_create_form', $data);
		}
	}

	// 레벨 9: 그룹회사 - 본사 관리
	public function head_office_create()
	{
		check_level_access(9, 'shop');
		$this->_load_child_creation_form('본사 등록', 8); // 본사는 레벨 8
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
		$this->_load_child_creation_form('부본사 등록', 7); // 부본사는 레벨 7
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
		$this->_load_child_creation_form('지사 등록', 6); // 지사는 레벨 6
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
		$this->_load_child_creation_form('총판 등록', 5); // 총판은 레벨 5
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
		$this->_load_child_creation_form('영업장 등록', 4); // 영업장은 레벨 4
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
		$this->_load_child_creation_form('매장 등록', 3); // 매장은 레벨 3
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
		// 레벨 3 관리자가 일반회원 (레벨 2)을 생성하는 폼
		$data['page_title'] = '일반 회원 등록';
		$data['target_user_level'] = 2; // 생성할 사용자의 레벨은 2
		$data['target_user_parent_user_idx'] = $this->session->userdata('user_idx'); // 현재 매장 관리자가 상위 관리자
		$data['target_user_assigned_entity_id'] = $this->session->userdata('assigned_entity_id'); // 현재 매장 관리자의 조직 ID

		// 일반 회원 생성 폼 뷰를 로드 (shop/member/register)
		if ($this->input->method() === 'post') {
			// 유효성 검사 및 일반 회원 생성 로직 (AdminShopEntity/store와 유사)
			$this->form_validation->set_rules('memberid', '아이디', 'required|alpha_dash|min_length[4]|is_unique[users.memberid]');
			$this->form_validation->set_rules('email', '이메일', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]');
			$this->form_validation->set_rules('passconf', '비밀번호 확인', 'required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				$this->load_shop_view('shop/member/register', $data); // 폼 다시 로드
			} else {
				$memberid = $this->input->post('memberid');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$this->db->trans_begin();
				if ($this->auth_model->register_user_with_details($memberid, $email, $password, $data['target_user_level'], $data['target_user_assigned_entity_id'])) {
					$new_user_idx = $this->db->insert_id();
					$this->member_model->update_user_hierarchy(
						$new_user_idx,
						$data['target_user_level'],
						$data['target_user_parent_user_idx'],
						0, // 일반 회원은 수수료율 없음
						$data['target_user_assigned_entity_id']
					);
					$this->db->trans_commit();
					$this->session->set_flashdata('success', '일반 회원 계정이 성공적으로 생성되었습니다.');
					redirect('shop/member/list');
				} else {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', '일반 회원 계정 생성 중 오류가 발생했습니다.');
					$this->load_shop_view('shop/member/register', $data);
				}
			}
		} else {
			// GET 요청 시 폼 로드
			$this->load_shop_view('shop/member/register', $data);
		}
	}
	public function member_list()
	{
		check_level_access(3, 'shop');
		$this->_load_child_list_view('회원 목록', 1, 'shop/member/list');
	}

	public function _load_child_list_view($page_title, $target_level, $view_path)
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
			$start_date = date('Y-m-d', strtotime('-7 days'));
			$data['child_financial_summaries'] = $this->shop_model->get_financial_summary_for_users($child_user_idxes, $start_date, $end_date);
		} else {
			$data['child_financial_summaries'] = array();
		}

		$this->load_shop_view($view_path, $data);
	}

	// 매장 관리자 AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_shop_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/shop_sidebar', $data); // $data를 shop_sidebar에도 전달
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer', $data);
	}
}