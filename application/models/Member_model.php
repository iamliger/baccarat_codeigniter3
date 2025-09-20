<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database(); // 데이터베이스 로드
		$this->load->model('shop_entity_model'); // Shop_entity_model 로드
	}

	/**
	 * 모든 회원 정보를 가져옵니다.
	 */
	public function get_all_members()
	{
		// 이제 bacaradb와의 조인 없이 users 테이블에서만 정보를 가져옵니다.
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_all_members()
	{
		return $this->db->count_all_results('users');
	}

	public function get_all_members_paginated($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->limit($limit, $offset);
		$this->db->order_by('created_at', 'DESC'); // 최신 가입 순으로 정렬
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * 특정 memberid를 가진 회원 정보를 가져옵니다.
	 */
	public function get_member_by_id($memberid)
	{
		// bacaradb와의 조인 없이 users 테이블에서만 정보를 가져옵니다.
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('memberid', $memberid);
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	 * 특정 user_idx를 가진 회원 정보를 가져옵니다.
	 */
	public function get_user_by_idx($user_idx)
	{
		$this->db->select('users.*, bacaradb.dayinfo'); // users의 모든 컬럼과 bacaradb의 dayinfo
		$this->db->from('users');
		$this->db->join('bacaradb', 'users.memberid = bacaradb.memberid', 'left');
		$this->db->where('users.user_idx', $user_idx);
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	 * 상위 관리자로 선택될 수 있는 회원 목록을 가져옵니다 (레벨 3-9).
	 * 현재 수정하려는 사용자를 제외합니다.
	 */
	public function get_potential_parents($exclude_user_idx = null)
	{
		$this->db->select('user_idx, memberid, level');
		$this->db->from('users');
		$this->db->where('level >=', 3); // 매장 관리자 이상
		$this->db->where('level <=', 9); // 매장 관리자 이하 (어드민 제외)
		if ($exclude_user_idx !== null) {
			$this->db->where('user_idx !=', $exclude_user_idx);
		}
		$this->db->order_by('level', 'DESC');
		$this->db->order_by('memberid', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * 사용자 계층 정보 (레벨, 상위 관리자, 수수료율, 계층 경로)를 업데이트합니다.
	 */
	public function update_user_hierarchy($user_idx, $level, $parent_user_idx, $commission_rate, $assigned_entity_id)
	{
		$data = array(
			'level'              => $level,
			'parent_user_idx'    => ($parent_user_idx == 0) ? NULL : $parent_user_idx,
			'commission_rate'    => $commission_rate,
			'assigned_entity_id' => ($assigned_entity_id == 0) ? NULL : $assigned_entity_id,
			'updated_at'         => date('Y-m-d H:i:s')
		);

		// --- lineage_path 생성/업데이트 로직 강화 ---
		$calculated_lineage_path = '/';
		if ($parent_user_idx != 0 && $parent_user_idx !== NULL) { // 상위 관리자가 있는 경우
			$parent = $this->get_user_by_idx($parent_user_idx);
			if ($parent && !empty($parent['lineage_path'])) {
				$calculated_lineage_path = $parent['lineage_path'];
			} else {
				// 상위 관리자가 있지만 lineage_path가 없는 경우, 상위 경로를 다시 계산하거나 오류 처리
				// 여기서는 상위 경로가 없는 경우 일단 자신의 ID만 포함
				$calculated_lineage_path = '/' . $parent_user_idx . '/';
			}
		}
		$data['lineage_path'] = $calculated_lineage_path . $user_idx . '/';
		// ------------------------------------------

		$this->db->where('user_idx', $user_idx);
		return $this->db->update('users', $data);
	}

	// 추후 회원 정보 추가, 수정, 삭제 등의 메소드 추가 예정
	public function add_member($data)
	{
		return $this->db->insert('bacaradb', $data);
	}

	public function update_member($memberid, $data)
	{
		$this->db->where('memberid', $memberid);
		return $this->db->update('bacaradb', $data);
	}

	public function delete_member($memberid)
	{
		$this->db->where('memberid', $memberid);
		return $this->db->delete('bacaradb');
	}

	public function get_assignable_entities($user_level = null)
	{
		$this->db->select('id, entity_name, entity_level');
		$this->db->from('shop_entities');

		if ($user_level !== null) {
			// 사용자 레벨과 조직 레벨 매핑 (예: 사용자 레벨 9는 조직 레벨 9만, 사용자 레벨 8은 조직 레벨 8만)
			// 또는 사용자 레벨 3-9는 해당 레벨 이하의 조직을 관리할 수 있음 등 비즈니스 로직에 따라 조정
			$this->db->where('entity_level', $user_level); // 현재는 사용자 레벨과 조직 레벨이 같다고 가정
		}

		$this->db->order_by('entity_level', 'DESC');
		$this->db->order_by('entity_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_members_for_tree_view()
	{
		$this->db->select('user_idx, memberid, level, parent_user_idx, lineage_path, assigned_entity_id');
		$this->db->from('users');
		$this->db->order_by('lineage_path', 'ASC'); // lineage_path를 기준으로 정렬
		$query = $this->db->get();
		return $query->result_array();
	}
}