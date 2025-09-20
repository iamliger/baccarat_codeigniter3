<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminMaintenance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'auth_helper'));
		$this->load->library('session');
		$this->load->model('db_maintenance_model'); // DB 유지보수 모델 로드

		// 레벨 10 (어드민)만 접근 가능
		check_level_access(10, 'login');
	}

	public function index()
	{
		$data['page_title'] = 'DB 유지보수 및 초기화';
		$this->load_admin_view('admin/maintenance/index', $data);
	}

	public function reset_database()
	{
		// POST 요청으로만 실행되도록 제한 (보안 강화)
		if ($this->input->method() !== 'post') {
			$this->session->set_flashdata('error', '잘못된 접근입니다.');
			redirect('admin/maintenance');
		}

		// 실제 초기화 전에 한 번 더 확인
		if ($this->db_maintenance_model->truncate_core_tables()) {
			// 초기화 후 기본 데이터 시딩
			if ($this->db_maintenance_model->seed_initial_data()) {
				$this->session->set_flashdata('success', '데이터베이스가 초기화되고 어드민 계정이 재설정되었습니다. 다시 로그인 해주세요.');
			} else {
				$this->session->set_flashdata('error', '데이터베이스 초기화는 성공했으나 기본 데이터 시딩에 실패했습니다.');
			}
		} else {
			$this->session->set_flashdata('error', '데이터베이스 초기화 중 오류가 발생했습니다.');
		}
		redirect('admin/maintenance');
	}

	// AdminLTE 레이아웃을 포함하여 뷰를 로드하는 헬퍼 메소드
	protected function load_admin_view($view_path, $data = array())
	{
		$this->load->view('layouts/admin_header', $data);
		$this->load->view('layouts/admin_sidebar');
		$this->load->view($view_path, $data);
		$this->load->view('layouts/admin_footer');
	}
}