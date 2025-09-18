<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database(); // 데이터베이스 로드
	}

	/**
	 * 모든 회원 정보를 가져옵니다.
	 * bacaradb 테이블의 memberid를 기준으로 합니다.
	 */
	public function get_all_members()
	{
		// 여기서는 bacaradb 테이블의 모든 컬럼을 가져오지만,
		// 실제 운영에서는 필요한 컬럼만 선택적으로 가져오는 것이 좋습니다.
		$query = $this->db->get('bacaradb');
		return $query->result_array(); // 결과 배열 반환
	}

	/**
	 * 특정 memberid를 가진 회원 정보를 가져옵니다.
	 */
	public function get_member_by_id($memberid)
	{
		$this->db->where('memberid', $memberid);
		$query = $this->db->get('bacaradb');
		return $query->row_array(); // 단일 행 결과 배열 반환
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
}
