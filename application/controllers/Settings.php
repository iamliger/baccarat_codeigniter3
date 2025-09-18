<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'security', 'auth_helper'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model('settings_model'); // Settings 모델 로드

		// 레벨 10 (어드민)만 접근 가능
		check_level_access(10, 'login');
	}

	public function index()
	{
		redirect('admin/settings/general_policy'); // 기본 정책 페이지로 리다이렉트
	}

	// 기본 정책 (가입/비밀번호/휴면)
	public function general_policy()
	{
		$data['page_title'] = '기본 정책 설정';
		$setting_data = $this->settings_model->get_config();

		if ($this->input->method() === 'post') {
			// 폼 유효성 검사
			$this->form_validation->set_rules('min_password_length', '최소 비밀번호 길이', 'required|integer|greater_than_equal_to[6]');
			$this->form_validation->set_rules('inactive_days', '휴면 계정 전환 일수', 'required|integer|greater_than_equal_to[30]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
			} else {
				$policy_data = array(
					'min_password_length' => $this->input->post('min_password_length'),
					'inactive_days'       => $this->input->post('inactive_days'),
					'allow_registration'  => $this->input->post('allow_registration') ? TRUE : FALSE
				);
				$setting_data['general_policy'] = json_encode($policy_data);

				if ($this->settings_model->update_config($setting_data)) {
					$this->session->set_flashdata('success', '기본 정책이 성공적으로 업데이트되었습니다.');
				} else {
					$this->session->set_flashdata('error', '기본 정책 업데이트 중 오류가 발생했습니다.');
				}
				redirect('admin/settings/general_policy');
			}
		}

		$data['general_policy'] = json_decode($setting_data['general_policy'], TRUE);

		$this->load_admin_view('admin/settings/general_policy', $data);
	}

	// 알림 채널 (이메일/SMS/푸시)
	public function notification_channels()
	{
		$data['page_title'] = '알림 채널 설정';
		$setting_data = $this->settings_model->get_config();

		if ($this->input->method() === 'post') {
			// 폼 유효성 검사 (예시)
			$this->form_validation->set_rules('email_sender', '이메일 발신자', 'valid_email');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
			} else {
				$channels_data = array(
					'email_enabled' => $this->input->post('email_enabled') ? TRUE : FALSE,
					'email_sender'  => $this->input->post('email_sender'),
					'sms_enabled'   => $this->input->post('sms_enabled') ? TRUE : FALSE,
					'push_enabled'  => $this->input->post('push_enabled') ? TRUE : FALSE,
				);
				$setting_data['notification_channels'] = json_encode($channels_data);

				if ($this->settings_model->update_config($setting_data)) {
					$this->session->set_flashdata('success', '알림 채널 설정이 성공적으로 업데이트되었습니다.');
				} else {
					$this->session->set_flashdata('error', '알림 채널 설정 업데이트 중 오류가 발생했습니다.');
				}
				redirect('admin/settings/notification_channels');
			}
		}

		$data['notification_channels'] = json_decode($setting_data['notification_channels'], TRUE);

		$this->load_admin_view('admin/settings/notification_channels', $data);
	}

	// 개인정보/보안 (마스킹/보존 기간)
	public function privacy_security()
	{
		$data['page_title'] = '개인정보/보안 설정';
		$setting_data = $this->settings_model->get_config();

		if ($this->input->method() === 'post') {
			// 폼 유효성 검사 (예시)
			$this->form_validation->set_rules('pii_retention_days', '개인정보 보존 기간', 'required|integer|greater_than_equal_to[365]');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
			} else {
				$privacy_data = array(
					'mask_pii'           => $this->input->post('mask_pii') ? TRUE : FALSE,
					'pii_retention_days' => $this->input->post('pii_retention_days'),
					'2fa_enabled'        => $this->input->post('2fa_enabled') ? TRUE : FALSE
				);
				$setting_data['privacy_security'] = json_encode($privacy_data);

				if ($this->settings_model->update_config($setting_data)) {
					$this->session->set_flashdata('success', '개인정보/보안 설정이 성공적으로 업데이트되었습니다.');
				} else {
					$this->session->set_flashdata('error', '개인정보/보안 설정 업데이트 중 오류가 발생했습니다.');
				}
				redirect('admin/settings/privacy_security');
			}
		}

		$data['privacy_security'] = json_decode($setting_data['privacy_security'], TRUE);

		$this->load_admin_view('admin/settings/privacy_security', $data);
	}

	// 통합 설정 (API 키/외부 연동)
	public function integrations()
	{
		$data['page_title'] = '통합 설정';
		$setting_data = $this->settings_model->get_config();

		if ($this->input->method() === 'post') {
			// 폼 유효성 검사 (예시)
			$this->form_validation->set_rules('api_key_status', 'API 키 상태', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', validation_errors());
			} else {
				$integrations_data = array(
					'third_party_api_enabled' => $this->input->post('third_party_api_enabled') ? TRUE : FALSE,
					'api_key'                 => $this->input->post('api_key'),
					'api_key_status'          => $this->input->post('api_key_status')
				);
				$setting_data['integrations'] = json_encode($integrations_data);

				if ($this->settings_model->update_config($setting_data)) {
					$this->session->set_flashdata('success', '통합 설정이 성공적으로 업데이트되었습니다.');
				} else {
					$this->session->set_flashdata('error', '통합 설정 업데이트 중 오류가 발생했습니다.');
				}
				redirect('admin/settings/integrations');
			}
		}

		$data['integrations'] = json_decode($setting_data['integrations'], TRUE);

		$this->load_admin_view('admin/settings/integrations', $data);
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
