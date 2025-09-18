<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'auth_helper'));
		$this->load->library('session');

		// 레벨 2 이상만 접근 가능. 또는 로그인된 사용자만 접근 가능하도록 조정
		// 여기서는 로그인만 되어있다면 접근 가능하지만, Auth/index에서 레벨 2만 여기로 보내므로 추가적인 레벨 체크는 필요 없을 수 있습니다.
		if (!is_logged_in()) {
			redirect('login');
		}
		// 명시적으로 레벨 2만 허용하려면 (Auth/index와 중복될 수 있음)
		if (get_user_level() != 2) {
			$this->session->set_flashdata('error', '바카라분석기 서비스는 레벨 2 사용자만 이용 가능합니다.');
			redirect('login');
		}
	}

	public function index()
	{
		$data['page_title'] = '바카라 분석기';
		// Tailwind CSS를 적용할 일반 프론트엔드 뷰를 로드합니다.
		// 이 뷰에는 AdminLTE 레이아웃을 사용하지 않습니다.
		$this->load->view('main/baccarat_analyzer', $data);
	}
}
