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
		$this->load_admin_view('admin/dashboard', $data);
	}

	// --- 홈 (요약) 하위 메뉴 ---
	public function summary_realtime_metrics()
	{
		$data['page_title'] = '실시간 지표';
		$this->load_admin_view('admin/summary/realtime_metrics', $data);
	}
	public function summary_notification_center()
	{
		$data['page_title'] = '알림센터';
		$this->load_admin_view('admin/summary/notification_center', $data);
	}
	public function summary_quick_actions()
	{
		$data['page_title'] = '빠른 작업';
		$this->load_admin_view('admin/summary/quick_actions', $data);
	}

	// --- 게임관리 하위 메뉴 ---
	public function game_logic1()
	{
		$data['page_title'] = '로직1 설정';
		$this->load_admin_view('admin/game/logic1', $data);
	}
	public function game_logic2()
	{
		$data['page_title'] = '로직2 설정';
		$this->load_admin_view('admin/game/logic2', $data);
	}
	public function game_logic3()
	{
		$data['page_title'] = '로직3 설정';
		$this->load_admin_view('admin/game/logic3', $data);
	}
	public function game_logic4()
	{
		$data['page_title'] = '로직4 설정';
		$this->load_admin_view('admin/game/logic4', $data);
	}
	public function game_ai_logic_management()
	{
		$data['page_title'] = 'AI 로직 관리';
		$this->load_admin_view('admin/game/ai_logic_management', $data);
	}

	// --- 권한/역할 관리 하위 메뉴 ---
	public function permissions_admin_accounts()
	{
		$data['page_title'] = '관리자 계정';
		$this->load_admin_view('admin/permissions/admin_accounts', $data);
	}
	public function permissions_role_definitions()
	{
		$data['page_title'] = '역할(Role) 정의';
		$this->load_admin_view('admin/permissions/role_definitions', $data);
	}
	public function permissions_access_control()
	{
		$data['page_title'] = '접근 권한';
		$this->load_admin_view('admin/permissions/access_control', $data);
	}

	// --- 콘텐츠/공지 하위 메뉴 ---
	public function content_notices()
	{
		$data['page_title'] = '공지사항';
		$this->load_admin_view('admin/content/notices', $data);
	}
	public function content_banners()
	{
		$data['page_title'] = '배너/팝업';
		$this->load_admin_view('admin/content/banners', $data);
	}
	public function content_faq()
	{
		$data['page_title'] = 'FAQ/도움말';
		$this->load_admin_view('admin/content/faq', $data);
	}

	// --- 결제/정산 하위 메뉴 ---
	public function payments_transactions()
	{
		$data['page_title'] = '결제 내역/환불';
		$this->load_admin_view('admin/payments/transactions', $data);
	}
	public function payments_deposit_withdrawal_review()
	{
		$data['page_title'] = '충전/출금 심사';
		$this->load_admin_view('admin/payments/deposit_withdrawal_review', $data);
	}
	public function payments_sales_report()
	{
		$data['page_title'] = '매출 리포트';
		$this->load_admin_view('admin/payments/sales_report', $data);
	}

	// --- 로그/감사 하위 메뉴 ---
	public function logs_system()
	{
		$data['page_title'] = '시스템 로그';
		$this->load_admin_view('admin/logs/system', $data);
	}
	public function logs_security()
	{
		$data['page_title'] = '보안 로그';
		$this->load_admin_view('admin/logs/security', $data);
	}
	public function logs_admin_activity()
	{
		$data['page_title'] = '관리자 활동 이력';
		$this->load_admin_view('admin/logs/admin_activity', $data);
	}

	// --- 통계/리포트 하위 메뉴 ---
	public function statistics_join_churn_analysis()
	{
		$data['page_title'] = '가입/이탈 분석';
		$this->load_admin_view('admin/statistics/join_churn_analysis', $data);
	}
	public function statistics_activity_metrics()
	{
		$data['page_title'] = '활성도 (DAU/WAU/MAU)';
		$this->load_admin_view('admin/statistics/activity_metrics', $data);
	}
	public function statistics_segment_performance()
	{
		$data['page_title'] = '세그먼트 성과';
		$this->load_admin_view('admin/statistics/segment_performance', $data);
	}
	public function statistics_custom_reports()
	{
		$data['page_title'] = '커스텀 리포트';
		$this->load_admin_view('admin/statistics/custom_reports', $data);
	}

	// --- 시스템 설정 하위 메뉴 ---
	// general_policy는 Settings 컨트롤러에서 다루므로 Admin 컨트롤러에는 추가하지 않습니다.
	// public function settings_general_policy() { ... } // Settings 컨트롤러에 있음
	public function settings_notification_channels()
	{
		$data['page_title'] = '알림 채널 설정';
		$this->load_admin_view('admin/settings/notification_channels', $data);
	}
	public function settings_privacy_security()
	{
		$data['page_title'] = '개인정보/보안 설정';
		$this->load_admin_view('admin/settings/privacy_security', $data);
	}
	public function settings_integrations()
	{
		$data['page_title'] = '통합 설정';
		$this->load_admin_view('admin/settings/integrations', $data);
	}

	// AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_admin_view($view_path, $data = array())
	{
		// --- 디버그 메시지 추가 ---
		// admin_sidebar.php 뷰에 전달되는 데이터 확인
		log_message('debug', 'Admin_sidebar Load - Data passed to views: ' . print_r($data, TRUE));
		log_message('debug', 'Admin_sidebar Load - Current URI String: ' . $this->uri->uri_string());
		// ---------------------------

		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}
}