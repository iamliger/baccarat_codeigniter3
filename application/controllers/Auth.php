<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'security', 'auth_helper'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('auth_model', 'settings_model'));
	}

	public function index()
	{
		if (is_logged_in()) {
			$user_level = get_user_level();
			$user_status = get_user_status();

			if ($user_level == 1 && $user_status == 'pending') {
				redirect('pending_approval');
			} elseif ($user_level == 2) {
				redirect('main');
			} elseif ($user_level >= 3 && $user_level <= 9) {
				redirect('shop');
			} elseif ($user_level == 10) {
				redirect('admin');
			} else {
				$this->session->set_flashdata('error', '알 수 없는 사용자 상태입니다.');
				redirect('logout');
			}
		}
		$this->login();
	}

	public function login()
	{
		// $data 변수 초기화 (Undefined variable 에러 방지)
		$data = array();

		if (is_logged_in()) {
			$user_level = get_user_level();
			$user_status = get_user_status();

			if ($user_level == 1 && $user_status == 'pending') {
				redirect('pending_approval');
			} elseif ($user_level == 2) {
				redirect('main');
			} elseif ($user_level >= 3 && $user_level <= 9) {
				redirect('shop');
			} elseif ($user_level == 10) {
				redirect('admin');
			} else {
				$this->session->set_flashdata('error', '알 수 없는 사용자 상태입니다.');
				redirect('logout');
			}
		}

		$settings = $this->settings_model->get_config();
		$login_mode = $settings['login_mode'] ?? 'memberid';
		$memberid_regex = $settings['memberid_regex'] ?? '/^[a-zA-Z0-9_-]+$/'; // 기본값에 구분자 추가

		// 폼 유효성 검사 규칙 설정
		$rules_credential = 'required';
		$credential_label = '아이디';

		if ($login_mode === 'memberid') {
			$rules_credential .= '|regex_match[' . $memberid_regex . ']'; // 정규식에 구분자가 포함되어야 함
			$credential_label = '아이디';
		} elseif ($login_mode === 'email') {
			$rules_credential .= '|valid_email';
			$credential_label = '이메일';
		} elseif ($login_mode === 'both') {
			$credential_label = '아이디 또는 이메일';
			// 'both' 모드에서는 모델에서 유효성 검사를 더 유연하게 처리
			// 여기서는 기본 required만 유지
		}

		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('credential', $credential_label, $rules_credential);
			$this->form_validation->set_rules('password', '비밀번호', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				// POST 요청 시 유효성 검사 실패해도 $data 값들을 뷰에 전달
				$data['login_mode'] = $login_mode;
				$data['credential_label'] = $credential_label;
				$this->load->view('auth/login', $data); // $data 변수 전달
			} else {
				$credential = $this->input->post('credential');
				$password = $this->input->post('password');

				$user = $this->auth_model->validate_user($credential, $password);

				if ($user) {
					$userdata = array(
						'user_idx'  => $user['user_idx'],
						'memberid'  => $user['memberid'],
						'email'     => $user['email'],
						'level'     => $user['level'],
						'status'    => $user['status'],
						'logged_in' => TRUE,
						'assigned_entity_id' => $user['assigned_entity_id']
					);
					$this->session->set_userdata($userdata);

					if ($user['level'] == 1 && $user['status'] == 'pending') {
						redirect('pending_approval');
					} elseif ($user['level'] == 2) {
						redirect('main');
					} elseif ($user['level'] >= 3 && $user['level'] <= 9) {
						redirect('shop');
					} elseif ($user['level'] == 10) {
						redirect('admin');
					} else {
						redirect('logout');
					}
				} else {
					$this->session->set_flashdata('error', '잘못된 ' . $credential_label . ' 또는 비밀번호입니다.');
					redirect('login');
				}
			}
		} else {
			// GET 요청 (로그인 폼 표시)
			$data['login_mode'] = $login_mode;
			$data['credential_label'] = $credential_label;
			$this->load->view('auth/login', $data);
		}
	}

	public function register()
	{
		// $data 변수 초기화 (Undefined variable 에러 방지)
		$data = array();

		if (is_logged_in()) {
			redirect('');
		}

		$settings = $this->settings_model->get_config();
		$allow_registration = (bool)($settings['allow_registration'] ?? TRUE); // 기본값은 허용

		if (!$allow_registration) {
			$this->session->set_flashdata('error', '현재 회원가입이 비활성화되어 있습니다.');
			redirect('login');
		}

		$memberid_regex = $settings['memberid_regex'] ?? '/^[a-zA-Z0-9_-]+$/'; // 기본값에 구분자 추가

		// 비밀번호 규칙 설정 로드
		$min_password_length       = $settings['min_password_length'] ?? 6;
		$requires_uppercase        = (bool)($settings['password_requires_uppercase'] ?? FALSE);
		$requires_lowercase        = (bool)($settings['password_requires_lowercase'] ?? FALSE);
		$requires_number           = (bool)($settings['password_requires_number'] ?? FALSE);
		$requires_special          = (bool)($settings['password_requires_special'] ?? FALSE);

		// 비밀번호 유효성 검사 규칙 생성
		$password_rules = 'required|min_length[' . $min_password_length . ']';
		if ($requires_uppercase) $password_rules .= '|regex_match[/[A-Z]/]';
		if ($requires_lowercase) $password_rules .= '|regex_match[/[a-z]/]';
		if ($requires_number) $password_rules .= '|regex_match[/[0-9]/]';
		if ($requires_special) $password_rules .= '|regex_match[/[^a-zA-Z0-9]/]';


		if ($this->input->method() === 'post') {
			$this->form_validation->set_rules('memberid', '아이디', 'required|regex_match[' . $memberid_regex . ']|min_length[4]|is_unique[users.memberid]'); // 정규식에 구분자가 포함되어야 함
			$this->form_validation->set_rules('email', '이메일', 'required|valid_email|is_unique[users.email]');
			$this->form_validation->set_rules('password', '비밀번호', $password_rules);
			$this->form_validation->set_rules('passconf', '비밀번호 확인', 'required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
				// POST 요청 시 유효성 검사 실패해도 $data 값들을 뷰에 전달
				$data['min_password_length'] = $min_password_length;
				$data['requires_uppercase'] = $requires_uppercase;
				$data['requires_lowercase'] = $requires_lowercase;
				$data['requires_number'] = $requires_number;
				$data['requires_special'] = $requires_special;
				$this->load->view('auth/register', $data); // $data 변수 전달
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
			// GET 요청 (회원가입 폼 표시)
			$data['min_password_length'] = $min_password_length;
			$data['requires_uppercase'] = $requires_uppercase;
			$data['requires_lowercase'] = $requires_lowercase;
			$data['requires_number'] = $requires_number;
			$data['requires_special'] = $requires_special;
			$this->load->view('auth/register', $data);
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}

	public function pending_approval()
	{
		if (!is_logged_in() || get_user_level() != 1 || get_user_status() != 'pending') {
			redirect('login');
		}
		$this->load->view('auth/pending_approval');
	}
}
