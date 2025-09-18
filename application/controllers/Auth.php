<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'security', 'auth_helper'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model('auth_model');
	}

	public function index()
	{
		// 이미 로그인 되어 있다면 레벨에 따라 리다이렉트
		if (is_logged_in()) {
			$user_level = get_user_level();
			$user_status = get_user_status();

			log_message('debug', 'Entering Auth/index. Current URI: ' . $this->uri->uri_string() . ', Session: ' . print_r($this->session->userdata(), TRUE));

			if ($user_level == 1 && $user_status == 'pending') {
				redirect('pending_approval'); // 레벨 1 (승인 대기)
			} elseif ($user_level == 2) {
				redirect('main'); // Main 컨트롤러의 index 메소드로 리다이렉트
			} elseif ($user_level >= 3 && $user_level <= 9) {
				redirect('shop'); // 레벨 3-9 (매장 관리자)
			} elseif ($user_level == 10) {
				redirect('admin'); // 레벨 10 (어드민)
			} else {
				$this->session->set_flashdata('error', '알 수 없는 사용자 상태입니다.');
				redirect('logout');
			}
		}
		// 로그인 되어 있지 않다면 로그인 페이지 로드 (기본)
		$this->login();
	}

	public function login()
	{
		// log_message('debug', 'Auth/login POST Data: ' . print_r($this->input->post(), TRUE));
		// 이미 로그인 되어 있다면 레벨에 따라 리다이렉트 (index()와 동일)
		if (is_logged_in()) {
			$user_level = get_user_level();
			$user_status = get_user_status();

			if ($user_level == 1 && $user_status == 'pending') {
				redirect('pending_approval');
			} elseif ($user_level == 2) {
				// !!! 이 부분을 수정합니다 !!!
				redirect('main'); // Main 컨트롤러의 index 메소드로 리다이렉트
			} elseif ($user_level >= 3 && $user_level <= 9) {
				redirect('shop');
			} elseif ($user_level == 10) {
				redirect('admin');
			} else {
				$this->session->set_flashdata('error', '알 수 없는 사용자 상태입니다.');
				redirect('logout');
			}
		}

		// POST 요청 처리
		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('memberid', '아이디', 'required|alpha_numeric');
			$this->form_validation->set_rules('password', '비밀번호', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				redirect('login');
			} else {
				$memberid = $this->input->post('memberid');
				$password = $this->input->post('password');

				$user = $this->auth_model->validate_user($memberid, $password);

				if ($user) {
					$userdata = array(
						'user_idx'  => $user['user_idx'],
						'memberid'  => $user['memberid'],
						'email'     => $user['email'],
						'level'     => $user['level'],
						'status'    => $user['status'],
						'logged_in' => TRUE
					);
					$this->session->set_userdata($userdata);

					// 로그인 성공 후 레벨에 따른 리다이렉션
					if ($user['level'] == 1 && $user['status'] == 'pending') {
						redirect('pending_approval');
					} elseif ($user['level'] == 2) {
						// !!! 이 부분을 수정합니다 (POST 요청 성공 후 리다이렉션) !!!
						redirect('main'); // Main 컨트롤러의 index 메소드로 리다이렉트
					} elseif ($user['level'] >= 3 && $user['level'] <= 9) {
						redirect('shop');
					} elseif ($user['level'] == 10) {
						redirect('admin');
					} else {
						redirect('logout');
					}
				} else {
					$this->session->set_flashdata('error', '잘못된 아이디 또는 비밀번호입니다.');
					redirect('login');
				}
			}
		} else {
			// GET 요청 (로그인 폼 표시)
			$this->load->view('auth/login');
		}
	}

	public function register()
	{
		// 이미 로그인 되어 있다면 리다이렉트 (회원가입 페이지는 로그인 상태에서 접근 불가)
		if (is_logged_in()) {
			redirect(''); // 메인 페이지로 리다이렉트
		}

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('memberid', '아이디', 'required|alpha_numeric|min_length[4]|is_unique[users.memberid]');
			$this->form_validation->set_rules('email', '이메일', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]');
			$this->form_validation->set_rules('passconf', '비밀번호 확인', 'required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				$this->load->view('auth/register');
			} else {
				$memberid = $this->input->post('memberid');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				if ($this->auth_model->register_user($memberid, $email, $password)) {
					$this->session->set_flashdata('success', '회원가입이 완료되었습니다. 관리자 승인을 기다려주세요.');
					redirect('login');
				} else {
					$this->session->set_flashdata('error', '회원가입 중 오류가 발생했습니다.');
					redirect('register');
				}
			}
		} else {
			$this->load->view('auth/register');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	// 레벨 1 사용자가 로그인했을 때 보여줄 페이지
	public function pending_approval()
	{
		if (!is_logged_in() || get_user_level() != 1 || get_user_status() != 'pending') {
			redirect('login');
		}
		$this->load->view('auth/pending_approval');
	}
}
