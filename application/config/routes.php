<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Auth'; // 로그인 여부에 따라 Auth 컨트롤러에서 리다이렉트 처리

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// 인증 및 사용자 관련 라우팅
$route['login'] = 'Auth/login';       // 로그인 폼 및 처리
$route['logout'] = 'Auth/logout';     // 로그아웃
$route['register'] = 'Auth/register'; // 회원가입 폼 및 처리
$route['pending_approval'] = 'Auth/pending_approval'; // 레벨 1 승인 대기 페이지

// 레벨 2 (바카라분석기) 메인 페이지
$route[''] = 'Main'; // localhost:8081/ 접속 시 Main 컨트롤러의 index 메소드

// 레벨 3-9 (매장 관리자) 페이지
$route['shop'] = 'Shop';
$route['shop/dashboard'] = 'Shop/index'; // 대시보드 명시적 추가

// 본사 관리 (레벨 9)
$route['shop/head_office/create'] = 'Shop/head_office_create';
$route['shop/head_office/list'] = 'Shop/head_office_list';

// 부본사 관리 (레벨 8)
$route['shop/sub_head_office/create'] = 'Shop/sub_head_office_create';
$route['shop/sub_head_office/list'] = 'Shop/sub_head_office_list';

// 지사 관리 (레벨 7)
$route['shop/branch_office/create'] = 'Shop/branch_office_create';
$route['shop/branch_office/list'] = 'Shop/branch_office_list';

// 총판 관리 (레벨 6)
$route['shop/agency/create'] = 'Shop/agency_create';
$route['shop/agency/list'] = 'Shop/agency_list';

// 영업장 관리 (레벨 5)
$route['shop/sales_place/create'] = 'Shop/sales_place_create';
$route['shop/sales_place/list'] = 'Shop/sales_place_list';

// 매장 관리 (레벨 4)
$route['shop/store/create'] = 'Shop/store_create';
$route['shop/store/list'] = 'Shop/store/list';

// 매장별 회원 관리 (레벨 3)
$route['shop/member/register'] = 'Shop/member_register';
$route['shop/member/list'] = 'Shop/member_list';

// catch-all shop 라우팅 (위의 명시적 라우팅보다 뒤에 위치하여 오버라이드되지 않도록 함)
$route['shop/(:any)'] = 'Shop/$1';


// 어드민 페이지 (레벨 10)
$route['admin'] = 'Admin/dashboard';
$route['admin/dashboard'] = 'Admin/dashboard';


// Member 컨트롤러 라우팅 (기존 내용 유지)
$route['admin/members/all'] = 'Member/all';
$route['admin/members/new'] = 'Member/new_members';
$route['admin/members/pending_verification'] = 'Member/pending_verification';
$route['admin/members/inactive'] = 'Member/inactive';
$route['admin/members/sanctioned'] = 'Member/sanctioned';
$route['admin/members/withdrawn'] = 'Member/withdrawn';

$route['admin/member/detail/(:any)'] = 'Member/detail/$1';
$route['admin/member/detail/security/(:any)'] = 'Member/detail_security/$1';
$route['admin/member/verification/status'] = 'Member/verification_status';
$route['admin/member/verification/kyc'] = 'Member/kyc_review';
$route['admin/member/verification/sanction_history'] = 'Member/sanction_history';
$route['admin/member/groups/create'] = 'Member/groups_create';
$route['admin/member/groups/extract'] = 'Member/groups_extract';
$route['admin/member/points/history'] = 'Member/points_history';
$route['admin/member/points/batch'] = 'Member/points_batch';
$route['admin/member/points/expiration'] = 'Member/points_expiration';
$route['admin/member/inquiries/status'] = 'Member/inquiries_status';
$route['admin/member/inquiries/template'] = 'Member/inquiries_template';
$route['admin/member/withdrawal_management'] = 'Member/withdrawal_management';

// Admin 컨트롤러의 다른 모든 페이지를 처리 (위의 명시적인 라우팅보다 뒤에 위치)
$route['admin/(:any)'] = 'Admin/$1';

// 환경설정 라우팅 (추후 Settings 컨트롤러에서 처리)
$route['admin/settings/(:any)'] = 'Settings/$1';
