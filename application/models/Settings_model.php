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
			// 설정이 없으면 기본값을 삽입
			$this->db->insert('baccara_config', array('bc_id' => 1));
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
