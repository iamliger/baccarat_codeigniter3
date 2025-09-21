<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminShopEntity extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'security', 'auth_helper'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model(array('shop_entity_model', 'auth_model', 'member_model'));

		// 레벨 10 (어드민)만 접근 가능
		check_level_access(10, 'login');
	}

	// 조직/매장 엔티티 목록
	public function index()
	{
		$data['page_title'] = '조직/매장 관리';
		$data['entities'] = $this->shop_entity_model->get_all_entities();

		$this->load_admin_view('admin/shop_entities/list', $data);
	}

	// 조직/매장 엔티티 생성 폼
	public function create()
	{
		$data['page_title'] = '조직/매장 생성';
		$data['parent_entities'] = $this->shop_entity_model->get_entities_for_dropdown(); // 상위 엔티티 드롭다운

		// --- 수정 필요 부분 시작 ---
		// Shop 컨트롤러에서 전달받은 flashdata 값으로 기본값 설정
		$data['default_entity_level'] = $this->session->flashdata('target_entity_level') ?? '';
		$data['default_parent_entity_id'] = $this->session->flashdata('target_entity_parent_id') ?? '';
		// -----------------------------

		$this->load_admin_view('admin/shop_entities/create', $data);
	}

	// 조직/매장 엔티티 생성 처리
	public function store()
	{
		//log_message('debug', 'AdminShopEntity/store - POST Data: ' . print_r($this->input->post(), TRUE));
		//log_message('debug', 'AdminShopEntity/store - Validation Rules: ' . print_r($this->form_validation->get_rules(), TRUE));
		check_level_access(10, 'login');

		// 폼 유효성 검사
		$this->form_validation->set_rules('entity_name', '조직/매장 이름', 'required|max_length[100]');
		$this->form_validation->set_rules('entity_level', '조직 레벨', 'required|integer|greater_than_equal_to[3]|less_than_equal_to[9]');
		$this->form_validation->set_rules('entity_code', '조직/매장 코드', 'required|max_length[50]|is_unique[shop_entities.entity_code]');
		$this->form_validation->set_rules('parent_entity_id', '상위 조직/매장', 'integer');
		$this->form_validation->set_rules('address', '주소', 'max_length[255]');
		$this->form_validation->set_rules('contact_info', '연락처', 'max_length[100]');

		$this->form_validation->set_rules('manager_memberid', '관리자 아이디', 'required|alpha_dash|min_length[4]|is_unique[users.memberid]'); // alpha_dash로 수정
		$this->form_validation->set_rules('manager_email', '관리자 이메일', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('manager_password', '관리자 비밀번호', 'required|min_length[6]');
		$this->form_validation->set_rules('manager_passconf', '비밀번호 확인', 'required|matches[manager_password]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			// $this->session->set_flashdata('target_entity_level', $this->input->post('entity_level'));
			// $this->session->set_flashdata('target_entity_parent_id', $this->input->post('parent_entity_id'));
			// redirect('admin/shop_entities/create');
			$this->create();
		} else {
			$entity_data = array(
				'entity_name'              => $this->input->post('entity_name'),
				'entity_level'             => $this->input->post('entity_level'),
				'entity_code'              => $this->input->post('entity_code'),
				'parent_entity_id'         => $this->input->post('parent_entity_id'),
				'address'                  => $this->input->post('address'),
				'contact_info'             => $this->input->post('contact_info'),
				'business_registration_no' => $this->input->post('business_registration_no'),
				'is_active'                => $this->input->post('is_active') ? 1 : 0
			);

			// 트랜잭션 시작 (조직 및 관리자 계정 생성이 모두 성공해야 함)
			$this->db->trans_begin();

			if ($this->shop_entity_model->add_entity($entity_data)) {
				$new_entity_id = $this->db->insert_id();

				$manager_memberid = $this->input->post('manager_memberid');
				$manager_email = $this->input->post('manager_email');
				$manager_password = $this->input->post('manager_password');
				$manager_level = $this->input->post('entity_level');

				// --- 상위 관리자 (users.parent_user_idx) 찾기 로직 강화 ---
				$parent_user_idx_for_new_manager = NULL; // 기본값: 부모 없음 (시스템 최상위)

				$parent_entity_id_from_form = $this->input->post('parent_entity_id');

				if ($parent_entity_id_from_form != 0 && $parent_entity_id_from_form !== NULL) {
					// 상위 조직이 있다면, 그 상위 조직의 관리자를 찾아 부모로 설정
					$parent_entity_info = $this->shop_entity_model->get_entity_by_id($parent_entity_id_from_form);
					if ($parent_entity_info && !empty($parent_entity_info['managed_by_user_idx'])) {
						$parent_user_idx_for_new_manager = $parent_entity_info['managed_by_user_idx'];
					} else {
						// 상위 조직은 있지만 관리자가 연결 안 되어 있다면 (또는 관리자 계층의 루트),
						// 현재 로그인한 어드민 (user_idx 1)을 기본 상위 관리자로 설정
						$parent_user_idx_for_new_manager = $this->session->userdata('user_idx'); // 어드민의 user_idx (이 경우 '1')
					}
				} else {
					// 상위 조직이 '없음' (최상위 그룹)인 경우, 어드민을 이 그룹 관리자의 부모로 설정
					$parent_user_idx_for_new_manager = $this->session->userdata('user_idx'); // 어드민의 user_idx (이 경우 '1')
				}
				// ----------------------------------------------------

				if ($this->auth_model->register_user_with_details($manager_memberid, $manager_email, $manager_password, $manager_level, $new_entity_id)) {
					$new_manager_user_idx = $this->db->insert_id();

					$this->member_model->update_user_hierarchy(
						$new_manager_user_idx,
						$manager_level,
						$parent_user_idx_for_new_manager, // 재계산된 부모 user_idx
						0, // 초기 수수료율
						$new_entity_id
					);

					$this->shop_entity_model->update_entity($new_entity_id, array('managed_by_user_idx' => $new_manager_user_idx));

					$this->db->trans_commit();
					$this->session->set_flashdata('success', '조직/매장 및 관리자 계정이 성공적으로 생성되었습니다.');
					redirect('admin/shop_entities');
				} else {
					$this->db->trans_rollback();
					$this->session->set_flashdata('error', '관리자 계정 생성 중 오류가 발생했습니다.');
					redirect('admin/shop_entities/create');
				}
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', '조직/매장 엔티티 생성 중 오류가 발생했습니다.');
				redirect('admin/shop_entities/create');
			}
		}
	}

	// 조직/매장 엔티티 수정 폼
	public function edit($id = null)
	{
		if ($id === null) {
			show_404();
		}

		$entity = $this->shop_entity_model->get_entity_by_id($id);
		if (empty($entity)) {
			show_404();
		}

		$data['page_title'] = $entity['entity_name'] . ' 수정';
		$data['entity'] = $entity;
		// 상위 엔티티 드롭다운 (자기 자신 제외)
		$data['parent_entities'] = $this->shop_entity_model->get_entities_for_dropdown(3, $id);
		$this->load_admin_view('admin/shop_entities/edit', $data);
	}

	// 조직/매장 엔티티 수정 처리
	public function update($id = null)
	{
		check_level_access(10, 'login');

		if ($id === null) {
			show_404();
		}

		$this->form_validation->set_rules('entity_name', '조직/매장 이름', 'required|max_length[100]');
		$this->form_validation->set_rules('entity_level', '조직 레벨', 'required|integer|greater_than_equal_to[3]|less_than_equal_to[9]');
		$this->form_validation->set_rules('entity_code', '조직/매장 코드', 'required|max_length[50]|callback_entity_code_check[' . $id . ']');
		$this->form_validation->set_rules('parent_entity_id', '상위 조직/매장', 'integer');
		$this->form_validation->set_rules('address', '주소', 'max_length[255]');
		$this->form_validation->set_rules('contact_info', '연락처', 'max_length[100]');

		// --- 관리자 계정 연결을 위한 필드 유효성 검사 (기존 관리자 변경 또는 신규 연결) ---
		$this->form_validation->set_rules('managed_by_user_idx', '관리자 계정', 'integer'); // users.user_idx
		// ----------------------------------------------------

		// 자기 자신을 상위 엔티티로 설정하는 것을 방지
		if ($this->input->post('parent_entity_id') == $id) {
			$this->session->set_flashdata('error', '자기 자신을 상위 조직/매장으로 설정할 수 없습니다.');
			redirect('admin/shop_entities/edit/' . $id);
			return;
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			$this->edit($id);
		} else {
			$entity_data = array(
				'entity_name'              => $this->input->post('entity_name'),
				'entity_level'             => $this->input->post('entity_level'),
				'entity_code'              => $this->input->post('entity_code'),
				'parent_entity_id'         => $this->input->post('parent_entity_id'),
				'address'                  => $this->input->post('address'),
				'contact_info'             => $this->input->post('contact_info'),
				'business_registration_no' => $this->input->post('business_registration_no'),
				'is_active'                => $this->input->post('is_active') ? 1 : 0,
				'managed_by_user_idx'      => $this->input->post('managed_by_user_idx') == 0 ? NULL : $this->input->post('managed_by_user_idx') // 관리자 연결
			);

			// 트랜잭션 시작
			$this->db->trans_begin();

			if ($this->shop_entity_model->update_entity($id, $entity_data)) {
				// --- 관리자 계정 정보 (레벨, 할당 엔티티) 업데이트 로직 ---
				$managed_by_user_idx = $this->input->post('managed_by_user_idx');
				$entity_level = $this->input->post('entity_level');

				if ($managed_by_user_idx != 0 && $managed_by_user_idx !== NULL) {
					$manager_user_info = $this->member_model->get_user_by_idx($managed_by_user_idx);
					if ($manager_user_info) {

						$current_entity_info = $this->shop_entity_model->get_entity_by_id($id);
						$parent_user_idx_for_manager = NULL;
						if (!empty($current_entity_info['parent_entity_id'])) {
							$parent_entity_of_current = $this->shop_entity_model->get_entity_by_id($current_entity_info['parent_entity_id']);
							if ($parent_entity_of_current && !empty($parent_entity_of_current['managed_by_user_idx'])) {
								$parent_user_idx_for_manager = $parent_entity_of_current['managed_by_user_idx'];
							}
						} else {
							// 현재 조직이 최상위 조직이라면, 어드민이 부모가 됨.
							$parent_user_idx_for_manager = $this->session->userdata('user_idx'); // 어드민의 user_idx
						}

						$this->member_model->update_user_hierarchy(
							$managed_by_user_idx,
							$entity_level,
							$parent_user_idx_for_manager, // 재계산된 부모 user_idx
							$manager_user_info['commission_rate'],
							$id
						);
						// --- 수정 필요 부분 끝 ---
					}
				}
				// ----------------------------------------------------

				$this->db->trans_commit();
				$this->session->set_flashdata('success', '조직/매장 엔티티가 성공적으로 업데이트되었습니다.');
				redirect('admin/shop_entities');
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', '조직/매장 엔티티 업데이트 중 오류가 발생했습니다.');
				$this->edit($id);
			}
		}
	}

	// 커스텀 유효성 검사: entity_code 중복 체크 (수정 시)
	public function entity_code_check($entity_code, $id)
	{
		$this->db->where('entity_code', $entity_code);
		$this->db->where('id !=', $id);
		$query = $this->db->get('shop_entities');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('entity_code_check', '이미 사용 중인 {field} 입니다.');
			return FALSE;
		}
		return TRUE;
	}

	// 조직/매장 엔티티 삭제 처리
	public function delete($id = null)
	{
		check_level_access(10, 'login');

		if ($id === null) {
			show_404();
		}

		if ($this->shop_entity_model->delete_entity($id)) {
			$this->session->set_flashdata('success', '조직/매장 엔티티가 성공적으로 삭제되었습니다.');
		} else {
			$this->session->set_flashdata('error', '조직/매장 엔티티 삭제 중 오류가 발생했습니다. 하위 조직/매장이 존재할 수 있습니다.');
		}
		redirect('admin/shop_entities');
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