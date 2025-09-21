<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{

	public function __construct()
	{
		parent::__construct(); // !!! 이 줄을 추가해야 합니다 !!!
		$this->load->helper(array('url', 'form', 'security', 'auth_helper'));
		$this->load->library(array('session', 'form_validation', 'pagination')); // Pagination 라이브러리 로드
		$this->load->model(array('member_model', 'shop_entity_model'));

		check_level_access(10, 'login'); // 권한이 없으면 로그인 페이지로 리다이렉트
	}

	// 회원 목록 - 전체 회원
	public function all($page = 1) // $offset 대신 $page로 변경
	{
		$this->load->library('pagination');

		$data['page_title'] = '전체 회원 목록';

		$per_page = 10; // 페이지당 보여줄 항목 수

		// --- 페이지네이션 offset 계산 수정 시작 ---
		$offset = ($page - 1) * $per_page; // 페이지 번호를 실제 DB offset으로 변환
		// --- 페이지네이션 offset 계산 수정 끝 ---

		// 전체 회원 수 가져오기 (페이지네이션을 위해 필요)
		$total_rows = $this->member_model->count_all_members();
		$data['members'] = $this->member_model->get_all_members_paginated($per_page, $offset);

		// 페이지네이션 설정
		$config = array();
		$config['base_url'] = base_url('admin/members/all');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['uri_segment'] = 4; // URI의 4번째 세그먼트 (admin/members/all/페이지번호)
		$config['use_page_numbers'] = TRUE; // 페이지 번호를 사용
		$config['num_links'] = 3; // 현재 페이지 좌우로 표시할 링크 수

		// Bootstrap 5 스타일 적용 (이전 설정 그대로 유지)
		$config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-end">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '«';
		$config['last_link'] = '»';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		$this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links();

		$this->load_admin_view('admin/member/list_all', $data);
	}

	// 회원 상세 정보
	public function detail($memberid = null, $tab = 'basic')
	{
		// --- 디버그 로그 시작 ---
		log_message('debug', 'Member/detail - Called with $memberid: ' . ($memberid ?? 'NULL') . ', $active_tab: ' . ($active_tab ?? 'NULL'));
		// --- 디버그 로그 끝 ---

		if ($memberid === null) {
			show_404();
		}

		$member = $this->member_model->get_member_by_id($memberid);

		if (empty($member)) {
			log_message('error', 'Member/detail - Member not found for memberid: ' . $memberid . ', showing 404.');
			show_404();
		}

		$data['member'] = $member;
		$data['page_title'] = $member['memberid'] . ' 회원 상세';
		$data['potential_parents'] = $this->member_model->get_potential_parents($member['user_idx']);
		$data['assignable_entities'] = $this->member_model->get_assignable_entities($member['level']);
		$data['active_tab'] = $tab;

		$this->load_admin_view('admin/member/detail', $data);
	}

	// 회원 계층 정보 업데이트 처리
	public function update_hierarchy($user_idx)
	{
		check_level_access(10, 'login');

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('level', '레벨', 'required|integer|greater_than_equal_to[1]|less_than_equal_to[10]');
			$this->form_validation->set_rules('parent_user_idx', '상위 관리자', 'integer');
			$this->form_validation->set_rules('commission_rate', '수수료율', 'required|numeric|greater_than_equal_to[0]|less_than[1]');
			$this->form_validation->set_rules('assigned_entity_id', '할당된 조직/매장', 'integer');

			// --- 수정 필요 부분 시작 ---
			// CodeIgniter 3에 alpha_numeric_dash 대신 alpha_dash 규칙을 사용
			// memberid 필드가 폼에 직접 있는 것은 아니지만, 유효성 검사 규칙으로 정의
			$this->form_validation->set_rules('memberid', '회원 아이디', 'alpha_dash');
			// --- 수정 필요 부분 끝 ---

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
			} else {
				$level           = $this->input->post('level');
				$parent_user_idx = $this->input->post('parent_user_idx');
				$commission_rate = $this->input->post('commission_rate');
				$assigned_entity_id = $this->input->post('assigned_entity_id');

				if ($parent_user_idx == $user_idx) {
					$this->session->set_flashdata('error', '자기 자신을 상위 관리자로 설정할 수 없습니다.');
					$member = $this->member_model->get_user_by_idx($user_idx);
					if ($member) {
						redirect('admin/member/detail/' . $member['memberid']);
					} else {
						redirect('admin/members/all');
					}
				}

				if ($this->member_model->update_user_hierarchy($user_idx, $level, $parent_user_idx, $commission_rate, $assigned_entity_id)) {
					$this->session->set_flashdata('success', '회원 계층 정보가 성공적으로 업데이트되었습니다.');
				} else {
					$this->session->set_flashdata('error', '회원 계층 정보 업데이트 중 오류가 발생했습니다.');
				}
			}
		}
		$member = $this->member_model->get_user_by_idx($user_idx);
		if ($member) {
			redirect('admin/member/detail/' . $member['memberid']);
		} else {
			redirect('admin/members/all');
		}
	}

	// 다른 회원관리 기능들의 빈 메소드 (추후 구현)
	public function new_members()
	{
		$data['page_title'] = '신규 가입 회원';
		$this->load_admin_view('admin/member/list_new', $data);
	}
	public function pending_verification()
	{
		$data['page_title'] = '인증 대기 회원';
		$this->load_admin_view('admin/member/list_pending_verification', $data);
	}
	public function inactive()
	{
		$data['page_title'] = '휴면/비활성 회원';
		$this->load_admin_view('admin/member/list_inactive', $data);
	}
	public function sanctioned()
	{
		$data['page_title'] = '제재/차단 회원';
		$this->load_admin_view('admin/member/list_sanctioned', $data);
	}
	public function withdrawn()
	{
		$data['page_title'] = '탈퇴 회원';
		$this->load_admin_view('admin/member/list_withdrawn', $data);
	}

	// 회원 상세 하위 메뉴들 (예시)
	public function detail_security($memberid = null)
	{
		$data['page_title'] = '회원 보안 정보';
		$this->load_admin_view('admin/member/detail_security', $data);
	}
	// ... 나머지 회원 상세 하위 메뉴들도 비슷하게 구현

	// 인증/검증 관리
	public function verification_status()
	{
		$data['page_title'] = '인증 현황';
		$this->load_admin_view('admin/member/verification_status', $data);
	}
	public function kyc_review()
	{
		$data['page_title'] = 'KYC 심사';
		$this->load_admin_view('admin/member/kyc_review', $data);
	}
	public function sanction_history()
	{
		$data['page_title'] = '제재/해제 이력';
		$this->load_admin_view('admin/member/sanction_history', $data);
	}

	// 그룹/세그먼트
	public function groups_create()
	{
		$data['page_title'] = '세그먼트 생성';
		$this->load_admin_view('admin/member/groups_create', $data);
	}
	public function groups_extract()
	{
		$data['page_title'] = '대상 추출';
		$this->load_admin_view('admin/member/groups_extract', $data);
	}

	// 포인트/마일리지
	public function points_history()
	{
		$data['page_title'] = '포인트 내역';
		$this->load_admin_view('admin/member/points_history', $data);
	}
	public function points_batch()
	{
		$data['page_title'] = '포인트 일괄 지급/회수';
		$this->load_admin_view('admin/member/points_batch', $data);
	}
	public function points_expiration()
	{
		$data['page_title'] = '포인트 만료 정책';
		$this->load_admin_view('admin/member/points_expiration', $data);
	}

	// 문의/티켓
	public function inquiries_status()
	{
		$data['page_title'] = '문의/티켓 현황';
		$this->load_admin_view('admin/member/inquiries_status', $data);
	}
	public function inquiries_template()
	{
		$data['page_title'] = '자동응답 템플릿';
		$this->load_admin_view('admin/member/inquiries_template', $data);
	}

	// 탈퇴/복구 관리
	public function withdrawal_management()
	{
		$data['page_title'] = '탈퇴/복구 관리';
		$this->load_admin_view('admin/member/withdrawal_management', $data);
	}

	// AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_admin_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}

	// 어드민용 모든 회원 계층 트리 뷰
	public function tree_view()
	{
		$data['page_title'] = '회원 계층 트리 뷰';
		$data['all_users'] = $this->member_model->get_all_members_for_tree_view();

		$this->load_admin_view('admin/member/tree_view', $data);
	}
}