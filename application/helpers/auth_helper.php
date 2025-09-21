<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 사용자 로그인 여부를 확인합니다.
 * @return bool 로그인 여부
 */
if (!function_exists('is_logged_in')) {
	function is_logged_in()
	{
		$CI = &get_instance();
		return $CI->session->userdata('logged_in') === TRUE;
	}
}

/**
 * 현재 로그인한 사용자의 레벨을 반환합니다.
 * @return int 사용자 레벨 (로그인되지 않은 경우 0)
 */
if (!function_exists('get_user_level')) {
	function get_user_level()
	{
		$CI = &get_instance();
		return (int)$CI->session->userdata('level');
	}
}

/**
 * 현재 로그인한 사용자의 계정 상태를 반환합니다.
 * @return string 계정 상태 (로그인되지 않은 경우 빈 문자열)
 */
if (!function_exists('get_user_status')) {
	function get_user_status()
	{
		$CI = &get_instance();
		return $CI->session->userdata('status');
	}
}

/**
 * 특정 레벨 이상의 접근 권한을 확인하고, 없으면 리다이렉트합니다.
 * @param int $required_level 필요한 최소 레벨
 * @param string $redirect_uri 권한이 없을 경우 리다이렉트할 URI
 */
if (!function_exists('check_level_access')) {
	function check_level_access($required_level, $redirect_uri = 'login')
	{
		$CI = &get_instance();
		if (!is_logged_in()) {
			redirect($redirect_uri);
		}

		$user_level = get_user_level();
		$user_status = get_user_status();
		$current_uri_string = $CI->uri->uri_string();

		// 레벨 1 사용자의 경우 승인 대기 페이지로 리다이렉트
		if ($user_level == 1 && $user_status == 'pending') {
			if ($current_uri_string !== 'pending_approval') {
				redirect('pending_approval');
			}
			return;
		}

		// 승인되지 않은 레벨 1 이외의 사용자는 서비스 이용 불가
		if ($user_level == 1 && $user_status != 'approved') {
			$CI->session->set_flashdata('error', '계정이 승인되지 않았습니다.');
			redirect('logout');
		}

		if ($user_level < $required_level) {
			// 레벨 2 사용자가 메인 페이지 외 다른 곳으로 가려고 할 때 막음
			if ($user_level == 2 && ($required_level > 2 || $current_uri_string !== '')) {
				if ($current_uri_string !== '') {
					$CI->session->set_flashdata('error', '바카라분석기 서비스만 이용 가능합니다.');
					redirect('');
				}
			}
			// 레벨 3-9 사용자가 /shop 외 다른 관리자 페이지로 가려고 할 때 막음
			// --- 수정 필요 부분 시작 ---
			// str_starts_with 대신 strpos 사용
			elseif ($user_level >= 3 && $user_level <= 9 && ($required_level == 10 || strpos($current_uri_string, 'shop') !== 0)) {
				if (strpos($current_uri_string, 'shop') !== 0) { // 이미 shop 페이지라면 리다이렉트 하지 않음
					$CI->session->set_flashdata('error', '매장관리자는 /shop 페이지에만 접근 가능합니다.');
					redirect('shop');
				}
			}
			// --- 수정 필요 부분 끝 ---
			// 그 외 낮은 레벨은 기본 리다이렉트 (Admin 접근 시도 등)
			else {
				$CI->session->set_flashdata('error', '접근 권한이 없습니다.');
				redirect($redirect_uri);
			}
		}
	}
}

if (!function_exists('translate_user_status')) {
	function translate_user_status($status)
	{
		switch ($status) {
			case 'pending':
				return '대기';
			case 'approved':
				return '승인됨';
			case 'suspended':
				return '정지';
			case 'withdrawn':
				return '탈퇴';
			default:
				return $status; // 정의되지 않은 상태는 그대로 반환
		}
	}
}

if (!function_exists('format_user_level_display')) {
	function format_user_level_display($level)
	{
		return (int)$level;
	}
}

if (!function_exists('format_date_only')) {
	function format_date_only($datetime_str)
	{
		if (empty($datetime_str)) {
			return '';
		}
		// DateTime 객체를 사용하여 안전하게 날짜를 파싱하고 포맷합니다.
		try {
			$date = new DateTime($datetime_str);
			return $date->format('Y-m-d');
		} catch (Exception $e) {
			log_message('error', '날짜 포맷 오류: ' . $e->getMessage() . ' 입력값: ' . $datetime_str);
			return $datetime_str; // 오류 발생 시 원본 문자열 반환 또는 빈 문자열
		}
	}
}

if (!function_exists('generate_pagination_html')) {
	function generate_pagination_html($total_rows, $per_page, $current_page, $base_url, $num_links = 3)
	{
		$CI = &get_instance();
		$CI->load->library('pagination');

		$config = array();
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $num_links;
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link'); // 모든 앵커 태그에 클래스 적용
		$config['next_link'] = '»';
		$config['prev_link'] = '«';

		$CI->pagination->initialize($config);

		return $CI->pagination->create_links();
	}
}

if (!function_exists('render_user_tree_html')) {
	function render_user_tree_html($all_users, $parent_user_idx = NULL, $current_depth = 0)
	{
		$CI = &get_instance();
		if (!isset($CI->shop_entity_model)) {
			$CI->load->model('shop_entity_model');
		}

		$html = '<ul class="tree-view-list">';
		$children_rendered = FALSE;

		foreach ($all_users as $user) {
			// 현재 부모의 직계 자식인지 확인
			$is_child = FALSE;
			if ($parent_user_idx === NULL && (
				$user['parent_user_idx'] === NULL
				|| ($user['parent_user_idx'] == $CI->session->userdata('user_idx') && $user['level'] == 9)
			)) {
				// 최상위 렌더링: admin(level=10) 또는 로그인 admin의 직속 그룹 관리자(level=9)
				if ($user['level'] == 10) {
					$is_child = TRUE;
				} elseif ($user['parent_user_idx'] == $parent_user_idx) {
					$is_child = TRUE;
				}
			} elseif ($parent_user_idx !== NULL && $user['parent_user_idx'] == $parent_user_idx) {
				$is_child = TRUE;
			}

			if ($is_child) {
				$children_rendered = TRUE;

				// 자식 유무 확인
				$has_children = FALSE;
				foreach ($all_users as $potential_child) {
					if ($potential_child['parent_user_idx'] == $user['user_idx']) {
						$has_children = TRUE;
						break;
					}
				}

				// li 클래스 (admin 루트노드면 tree-root-admin 추가)
				$li_class = 'tree-view-item' . ($user['level'] == 10 ? ' tree-root-admin' : '');
				$html .= '<li class="' . $li_class . '">';

				// 토글 버튼 / 스페이서
				if ($has_children && $user['level'] != 10) {
					$html .= '<button class="tree-toggle-btn btn btn-sm btn-link p-0 me-1" '
						. 'type="button" data-bs-toggle="collapse" '
						. 'data-bs-target="#collapseUser' . $user['user_idx'] . '" '
						. 'aria-expanded="true" '
						. 'aria-controls="collapseUser' . $user['user_idx'] . '">'
						. '<i class="bi bi-chevron-right tree-toggle-icon"></i>'
						. '</button>';
				} elseif ($user['level'] != 10) {
					$html .= '<span class="tree-spacer"></span>';
				}

				// 사용자 링크
				$html .= '<a href="' . base_url('admin/member/detail/' . htmlspecialchars($user['memberid'])) . '" '
					. 'class="text-decoration-none text-dark">'
					. '<i class="bi bi-person-fill me-1"></i>'
					. '<strong>' . htmlspecialchars($user['memberid']) . '</strong> '
					. '(' . $CI->shop_entity_model->get_entity_level_name($user['level']) . ' - 레벨 '
					. htmlspecialchars($user['level']) . ')'
					. '</a>';

				// 엔티티 뱃지
				// if (!empty($user['assigned_entity_id']) && $user['level'] != 10) {
				// 	$entity_info = $CI->shop_entity_model->get_entity_by_id($user['assigned_entity_id']);
				// 	if ($entity_info) {
				// 		$html .= ' <span class="badge text-bg-primary ms-2">['
				// 			. htmlspecialchars($entity_info['entity_name']) . ']</span>';
				// 	}
				// }

				// 재귀 렌더링
				if ($has_children) {
					$html .= '<div class="collapse show" id="collapseUser' . $user['user_idx'] . '">';
					$html .= render_user_tree_html($all_users, $user['user_idx'], $current_depth + 1);
					$html .= '</div>';
				}

				$html .= '</li>';
			}
		}

		$html .= '</ul>';
		return $children_rendered ? $html : '';
	}
}