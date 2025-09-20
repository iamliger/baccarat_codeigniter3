<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop_entity_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_entities($parent_entity_id = null)
	{
		$this->db->select('se.*, pse.entity_name as parent_entity_name, u.memberid as manager_memberid, u.level as manager_level');
		$this->db->from('shop_entities se');
		$this->db->join('shop_entities pse', 'se.parent_entity_id = pse.id', 'left');
		$this->db->join('users u', 'se.managed_by_user_idx = u.user_idx', 'left'); // 관리자 정보 조인
		if ($parent_entity_id !== null) {
			$this->db->where('se.parent_entity_id', $parent_entity_id);
		}
		$this->db->order_by('se.entity_level', 'DESC');
		$this->db->order_by('se.entity_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_entity_by_id($id)
	{
		$this->db->select('se.*, pse.entity_name as parent_entity_name, u.memberid as manager_memberid, u.level as manager_level');
		$this->db->from('shop_entities se');
		$this->db->join('shop_entities pse', 'se.parent_entity_id = pse.id', 'left');
		$this->db->join('users u', 'se.managed_by_user_idx = u.user_idx', 'left'); // 관리자 정보 조인
		$this->db->where('se.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function add_entity($data)
	{
		if (isset($data['parent_entity_id']) && $data['parent_entity_id'] == 0) {
			$data['parent_entity_id'] = NULL;
		}
		if (isset($data['managed_by_user_idx']) && $data['managed_by_user_idx'] == 0) {
			$data['managed_by_user_idx'] = NULL;
		}
		return $this->db->insert('shop_entities', $data);
	}

	public function update_entity($id, $data)
	{
		if (isset($data['parent_entity_id']) && $data['parent_entity_id'] == 0) {
			$data['parent_entity_id'] = NULL;
		}
		if (isset($data['managed_by_user_idx']) && $data['managed_by_user_idx'] == 0) {
			$data['managed_by_user_idx'] = NULL;
		}
		$this->db->where('id', $id);
		return $this->db->update('shop_entities', $data);
	}

	/**
	 * 조직/매장 엔티티를 삭제합니다. (하위 엔티티 존재 여부 확인 필요)
	 * @param int $id 엔티티 ID
	 * @return bool 성공 여부
	 */
	public function delete_entity($id)
	{
		// 하위 엔티티가 있는지 확인
		$this->db->where('parent_entity_id', $id);
		if ($this->db->count_all_results('shop_entities') > 0) {
			// 하위 엔티티가 있다면 삭제 불가 (비즈니스 로직에 따라 변경 가능)
			return FALSE;
		}
		$this->db->where('id', $id);
		return $this->db->delete('shop_entities');
	}

	/**
	 * 조직 레벨에 따른 한글 이름을 반환합니다.
	 */
	public function get_entity_level_name($level)
	{
		$levels = [
			10 => '시스템 관리자',
			9 => '그룹',
			8 => '본사',
			7 => '부본사',
			6 => '지사',
			5 => '총판',
			4 => '영업장',
			3 => '매장',
			2 => '일반회원', // 레벨 2도 여기에서 정의
			1 => '대기회원'  // 레벨 1도 여기에서 정의
		];
		return $levels[$level] ?? '알 수 없음';
	}

	public function get_entities_for_dropdown($min_level = 3, $exclude_id = null)
	{
		$this->db->select('id, entity_name, entity_level');
		$this->db->from('shop_entities');
		$this->db->where('entity_level >=', $min_level);
		// exclude_id는 생성/수정할 엔티티 자신을 상위로 선택하지 못하게 함.
		if ($exclude_id !== null) {
			$this->db->where('id !=', $exclude_id);
		}
		$this->db->order_by('entity_level', 'DESC');
		$this->db->order_by('entity_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
}