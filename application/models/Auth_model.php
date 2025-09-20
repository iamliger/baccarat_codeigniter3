<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('settings_model');
	}

	/**
	 * 사용자 인증을 시도하고, 성공하면 사용자 정보를 반환합니다.
	 */
	public function validate_user($credential, $password)
	{
		$settings = $this->settings_model->get_config();
		$login_mode = $settings['login_mode'] ?? 'memberid';

		$field = '';
		// 컨트롤러에서 이미 유효성 검사를 했지만, 모델에서도 안전을 위해 기본적인 형식 확인
		if ($login_mode === 'memberid') {
			$field = 'memberid';
		} elseif ($login_mode === 'email') {
			$field = 'email';
		} elseif ($login_mode === 'both') {
			// 'both' 모드에서는 입력된 값이 ID 형식인지 이메일 형식인지 판단
			// 정규식 대신 filter_var를 사용하여 이메일 형식을 우선 검사
			if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
				$field = 'email';
			} else {
				// 이메일 형식이 아니면 memberid로 간주
				$field = 'memberid';
			}
		}

		if ($field === '') {
			return FALSE; // 유효한 로그인 자격 증명 형식이 아님
		}

		$this->db->where($field, $credential);
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			$user = $query->row_array();
			if (password_verify($password, $user['password'])) {
				return $user;
			}
		}
		return FALSE;
	}

	/**
	 * 새로운 사용자를 등록합니다 (초기 레벨 1, 상태 pending).
	 */
	public function register_user($memberid, $email, $password)
	{
		// 비밀번호를 해시하여 저장합니다.
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);

		$data = array(
			'memberid' => $memberid,
			'email'    => $email,
			'password' => $hashed_password,
			'level'    => 1, // 신규 가입은 레벨 1 (승인 대기)
			'status'   => 'pending',
			'created_at' => date('Y-m-d H:i:s')
		);

		return $this->db->insert('users', $data);
	}

	/**
	 * 특정 memberid의 회원 정보를 가져옵니다.
	 */
	public function get_user_by_memberid($memberid)
	{
		$this->db->where('memberid', $memberid);
		$query = $this->db->get('users');
		return $query->row_array();
	}

	/**
	 * 사용자의 레벨 및 상태를 업데이트합니다.
	 */
	public function update_user_status($memberid, $level, $status)
	{
		$data = array(
			'level'  => $level,
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->db->where('memberid', $memberid);
		return $this->db->update('users', $data);
	}

	public function register_user_with_details($memberid, $email, $password, $level, $assigned_entity_id = NULL)
	{
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);

		$data = array(
			'memberid'           => $memberid,
			'email'              => $email,
			'password'           => $hashed_password,
			'level'              => $level,
			'status'             => 'approved', // 조직 관리자는 기본적으로 승인됨으로 시작
			'created_at'         => date('Y-m-d H:i:s'),
			'assigned_entity_id' => $assigned_entity_id
			// parent_user_idx와 lineage_path는 member_model의 update_user_hierarchy에서 처리
		);

		return $this->db->insert('users', $data);
	}
}