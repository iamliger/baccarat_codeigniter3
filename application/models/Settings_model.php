<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * baccara_config 테이블의 설정을 가져옵니다. (bc_id = 1 고정)
	 */
	public function get_config()
	{
		$query = $this->db->get_where('baccara_config', array('bc_id' => 1));
		if ($query->num_rows() == 0) {
			// 설정이 없으면 기본값을 삽입 (INSERT IGNORE 사용)
			// 모든 컬럼의 DEFAULT 값을 지정하거나, 반드시 필요한 컬럼만 지정
			$default_settings = array(
				'bc_id'                       => 1,
				'logic2_enabled'              => 1,
				'memberid_regex'              => '^[a-zA-Z0-9_-]+$',
				'min_password_length'         => 6,
				'password_requires_uppercase' => 0,
				'password_requires_lowercase' => 0,
				'password_requires_number'    => 0,
				'password_requires_special'   => 0,
				'login_mode'                  => 'memberid',
				'id_min_length'               => 4,
				'id_max_length'               => 20,
				'id_allow_underscore'         => 1,
				'password_max_length'         => 30,
				// 나머지 TEXT 필드는 NULL 또는 빈 JSON 문자열
				'general_policy'              => '{}',
				'notification_channels'       => '{}',
				'privacy_security'            => '{}',
				'integrations'                => '{}',
				'logic3_patterns'             => NULL,
				'logic2_patterns'             => NULL,
				'profit_rate'                 => NULL,
				'another_setting'             => NULL,
			);
			$this->db->insert('baccara_config', $default_settings);
			// 다시 쿼리하여 방금 삽입된 레코드 가져오기
			$query = $this->db->get_where('baccara_config', array('bc_id' => 1));
		}
		return $query->row_array();
	}

	/**
	 * baccara_config 테이블의 설정을 업데이트합니다. (bc_id = 1 고정)
	 */
	public function update_config($data)
	{
		// bc_id는 업데이트하지 않습니다.
		unset($data['bc_id']);
		$this->db->where('bc_id', 1);
		return $this->db->update('baccara_config', $data);
	}
}