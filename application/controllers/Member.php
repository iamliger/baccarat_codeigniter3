<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('member_model'); // Member 모델 로드

		check_level_access(10, 'login'); // 권한이 없으면 로그인 페이지로 리다이렉트

		// 관리자 로그인 여부 확인 (Admin 컨트롤러와 동일)
		if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
			redirect('login');
		}
	}

	// 회원 목록 - 전체 회원
	public function all()
	{
		$data['page_title'] = '전체 회원 목록';
		$data['members'] = $this->member_model->get_all_members(); // 모든 회원 정보 가져오기

		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view('admin/member/list_all', $data); // 회원 목록 뷰
		$this->load->view('layouts/admin_footer');
	}

	// 회원 상세 정보
	public function detail($memberid = null)
	{
		if ($memberid === null) {
			show_404(); // memberid가 없으면 404 페이지
		}

		$data['member'] = $this->member_model->get_member_by_id($memberid); // 특정 회원 정보 가져오기

		if (empty($data['member'])) {
			show_404(); // 회원 정보가 없으면 404 페이지
		}

		$data['page_title'] = $data['member']['memberid'] . ' 회원 상세';

		// 여기서는 기본 정보 탭만 보여줍니다.
		// 추후 다른 탭(보안, 권한 등)은 AJAX로 로드하거나 별도의 뷰 파일로 분리 가능
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view('admin/member/detail', $data); // 회원 상세 뷰
		$this->load->view('layouts/admin_footer');
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
	private function load_admin_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}
}
