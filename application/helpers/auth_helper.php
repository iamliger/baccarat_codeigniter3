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
			redirect($redirect_uri); // 로그인 안 되어있으면 로그인 페이지로
		}

		$user_level = get_user_level();
		$user_status = get_user_status();
		$current_uri_string = $CI->uri->uri_string(); // 현재 URI 가져오기

		// 레벨 1 사용자의 경우 승인 대기 페이지로 리다이렉트
		if ($user_level == 1 && $user_status == 'pending') {
			if ($current_uri_string !== 'pending_approval') { // 현재 페이지가 pending_approval이 아니라면 리다이렉트
				redirect('pending_approval');
			}
			return; // 이미 pending_approval 페이지라면 함수 종료
		}

		// 승인되지 않은 레벨 1 이외의 사용자는 서비스 이용 불가
		if ($user_level == 1 && $user_status != 'approved') {
			$CI->session->set_flashdata('error', '계정이 승인되지 않았습니다.');
			redirect('logout'); // 로그아웃 시키고 다시 로그인 페이지로
		}

		if ($user_level < $required_level) {
			// 레벨 2 사용자가 메인 페이지 외 다른 곳으로 가려고 할 때 막음
			if ($user_level == 2 && ($required_level > 2 || $current_uri_string !== '')) { // 루트(메인) 페이지가 아닐 때만 리다이렉트
				if ($current_uri_string !== '') { // 이미 메인 페이지라면 리다이렉트 하지 않음
					$CI->session->set_flashdata('error', '바카라분석기 서비스만 이용 가능합니다.');
					redirect(''); // 메인 페이지로 리다이렉트
				}
			}
			// 레벨 3-9 사용자가 /shop 외 다른 관리자 페이지로 가려고 할 때 막음
			elseif ($user_level >= 3 && $user_level <= 9 && ($required_level == 10 || !str_starts_with($current_uri_string, 'shop'))) { // shop 경로가 아닐 때만 리다이렉트
				if (!str_starts_with($current_uri_string, 'shop')) { // 이미 shop 페이지라면 리다이렉트 하지 않음
					$CI->session->set_flashdata('error', '매장관리자는 /shop 페이지에만 접근 가능합니다.');
					redirect('shop');
				}
			}
			// 그 외 낮은 레벨은 기본 리다이렉트 (Admin 접근 시도 등)
			else {
				$CI->session->set_flashdata('error', '접근 권한이 없습니다.');
				redirect($redirect_uri);
			}
		}
	}
}
