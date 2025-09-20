<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 영문 계정 상태 값을 한글로 변환합니다.
 * @param string $status_en 영문 계정 상태 (pending, approved, suspended, withdrawn)
 * @return string 한글 계정 상태
 */
if (! function_exists('convert_status_to_ko')) {
	function convert_status_to_ko($status_en)
	{
		switch ($status_en) {
			case 'pending':
				return '대기';
			case 'approved':
				return '승인됨';
			case 'suspended':
				return '정지됨';
			case 'withdrawn':
				return '탈퇴됨';
			default:
				return $status_en; // 정의되지 않은 상태는 그대로 반환
		}
	}
}

/**
 * 계정 상태에 따른 Bootstrap 5 배지(badge) 색상 클래스를 반환합니다.
 * @param string $status_en 영문 계정 상태
 * @return string Bootstrap 5 배지 색상 클래스
 */
if (! function_exists('get_status_badge_class')) {
	function get_status_badge_class($status_en)
	{
		switch ($status_en) {
			case 'pending':
				return 'text-bg-warning';
			case 'approved':
				return 'text-bg-success';
			case 'suspended':
				return 'text-bg-danger';
			case 'withdrawn':
				return 'text-bg-secondary'; // 탈퇴는 회색으로
			default:
				return 'text-bg-info'; // 기본값
		}
	}
}