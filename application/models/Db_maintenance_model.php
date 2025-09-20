<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Db_maintenance_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 핵심 테이블들을 TRUNCATE하여 데이터를 초기화합니다.
	 * (주의: 이 함수는 모든 데이터를 삭제하므로 신중하게 사용해야 합니다!)
	 */
	public function truncate_core_tables()
	{
		// 외래 키 제약 조건 비활성화 (TRUNCATE 시 필요)
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');

		// --- 수정 필요 부분 시작 ---
		// 초기화할 테이블 목록에 'baccara_config'도 포함
		$tables = ['users', 'shop_entities', 'shop_financials', 'game_transactions', '3ticket', '4ticket', '5ticket', '6ticket', 'bacaradb', 'clslog', 'baccara_config'];
		// --- 수정 필요 부분 끝 ---
		foreach ($tables as $table) {
			if ($this->db->table_exists($table)) {
				$this->db->truncate($table);
			}
		}

		// 외래 키 제약 조건 다시 활성화
		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
		return TRUE;
	}

	/**
	 * 어드민 계정 및 baccara_config 기본 설정을 시딩합니다.
	 */
	public function seed_initial_data()
	{
		// 1. 어드민 계정 추가 (비밀번호: 123456)
		$admin_password_hash = password_hash('123456', PASSWORD_BCRYPT);
		$admin_data = array(
			'memberid' => 'admin',
			'password' => $admin_password_hash,
			'email'    => 'admin@example.com',
			'level'    => 10,
			'status'   => 'approved',
			'created_at' => date('Y-m-d H:i:s'),
			'lineage_path' => '/1/' // 어드민의 user_idx가 1이라고 가정
		);
		// 이미 admin 계정이 있다면 업데이트, 없으면 삽입
		$this->db->replace('users', $admin_data);

		// admin 계정의 user_idx를 가져와서 lineage_path 업데이트 (정확성을 위해)
		$admin_user_idx = $this->db->select('user_idx')->get_where('users', array('memberid' => 'admin'))->row_array()['user_idx'];
		$this->db->update('users', array('lineage_path' => '/' . $admin_user_idx . '/'), array('user_idx' => $admin_user_idx));


		// 2. baccara_config 기본 설정 레코드 추가/업데이트 (모든 필드 포함)
		$default_config = array(
			'bc_id'                       => 1,
			'logic2_enabled'              => 1,
			'memberid_regex'              => '/^[a-zA-Z0-9_-]+$/',
			'min_password_length'         => 6,
			'password_requires_uppercase' => 0,
			'password_requires_lowercase' => 0,
			'password_requires_number'    => 0,
			'password_requires_special'   => 0,
			'login_mode'                  => 'memberid',
			'allow_registration'          => 1,
			'id_min_length'               => 4,
			'id_max_length'               => 20,
			'id_allow_underscore'         => 1,
			'password_max_length'         => 30,
			// JSON 필드 기본값
			'general_policy'              => '{}',
			'notification_channels'       => '{}',
			'privacy_security'            => '{}',
			'integrations'                => '{}',
			// 기타 필드는 NULL 또는 기본값
			'logic3_patterns'             => NULL,
			'logic2_patterns'             => NULL,
			'profit_rate'                 => NULL,
			'another_setting'             => NULL,
		);
		$this->db->replace('baccara_config', $default_config);

		return TRUE;
	}
}