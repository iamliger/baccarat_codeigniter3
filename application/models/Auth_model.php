<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 사용자 인증을 시도하고, 성공하면 사용자 정보를 반환합니다.
	 */
	public function validate_user($memberid, $password)
	{
		$this->db->where('memberid', $memberid);
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			$user = $query->row_array();
			// password_verify를 사용하여 해시된 비밀번호를 확인합니다.
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
}
