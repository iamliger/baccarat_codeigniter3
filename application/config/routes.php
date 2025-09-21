<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Auth'; // 로그인 여부에 따라 Auth 컨트롤러에서 리다이렉트 처리

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// 인증 및 사용자 관련 라우팅
$route['login'] = 'Auth/login';       // 로그인 폼 및 처리
$route['logout'] = 'Auth/logout';     // 로그아웃
//$route['register'] = 'Auth/register'; // 회원가입 폼 및 처리
$route['pending_approval'] = 'Auth/pending_approval'; // 레벨 1 승인 대기 페이지

// 레벨 2 (바카라분석기) 메인 페이지
$route[''] = 'Main'; // localhost:8081/ 접속 시 Main 컨트롤러의 index 메소드

// 레벨 3-9 (매장 관리자) 페이지
$route['shop'] = 'Shop';
$route['shop/dashboard'] = 'Shop/index';

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
// !!! 이 부분이 중요합니다. 기존에 Shop/store/list로 되어 있었다면 Shop/store_list로 변경 !!!
$route['shop/store/list'] = 'Shop/store_list';

// 매장별 회원 관리 (레벨 3)
$route['shop/member/register'] = 'Shop/member_register';
$route['shop/member/list'] = 'Shop/member/list'; // 주의: Shop/member_list로 변경될 수도 있음

// 매장관리자 개별 하위 항목 상세
$route['shop/detail/(:any)'] = 'Shop/detail/$1';

// catch-all shop 라우팅 (위의 명시적 라우팅보다 뒤에 위치하여 오버라이드되지 않도록 함)
$route['shop/(:any)'] = 'Shop/$1';

// 어드민 페이지 (레벨 10)
$route['admin'] = 'Admin/dashboard';
$route['admin/dashboard'] = 'Admin/dashboard';


// Member 컨트롤러 라우팅 (기존 내용 유지)
$route['admin/members/all'] = 'Member/all';
$route['admin/members/all/(:num)'] = 'Member/all/$1';

$route['admin/members/new'] = 'Member/new_members';
$route['admin/members/pending_verification'] = 'Member/pending_verification';
$route['admin/members/inactive'] = 'Member/inactive';
$route['admin/members/sanctioned'] = 'Member/sanctioned';
$route['admin/members/withdrawn'] = 'Member/withdrawn';

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

$route['admin/member/detail/(:any)/(:any)'] = 'Member/detail/$1/$2'; // memberid와 탭 이름을 파라미터로 전달
$route['admin/member/detail/(:any)'] = 'Member/detail/$1'; // 회원 상세

$route['admin/member/update_hierarchy/(:num)'] = 'Member/update_hierarchy/$1'; // 회원 계층 정보 업데이트

// 조직/매장 관리 라우팅 (AdminShopEntity 컨트롤러)
$route['admin/shop_entities'] = 'AdminShopEntity/index';
$route['admin/shop_entities/create'] = 'AdminShopEntity/create';
$route['admin/shop_entities/store'] = 'AdminShopEntity/store';
$route['admin/shop_entities/edit/(:num)'] = 'AdminShopEntity/edit/$1';
$route['admin/shop_entities/update/(:num)'] = 'AdminShopEntity/update/$1';
$route['admin/shop_entities/delete/(:num)'] = 'AdminShopEntity/delete/$1';

// DB 유지보수 라우팅
$route['admin/maintenance'] = 'AdminMaintenance/index';
$route['admin/maintenance/reset_database'] = 'AdminMaintenance/reset_database';

// 회원 계층 트리 뷰
$route['admin/members/tree_view'] = 'Member/tree_view';

// Admin 컨트롤러 라우팅 (나머지 메뉴)
// 홈 (요약)
$route['admin/summary/realtime_metrics'] = 'Admin/summary_realtime_metrics';
$route['admin/summary/notification_center'] = 'Admin/summary_notification_center';
$route['admin/summary/quick_actions'] = 'Admin/summary_quick_actions';

// 게임관리
$route['admin/game/logic1'] = 'Admin/game_logic1';
$route['admin/game/logic2'] = 'Admin/game_logic2';
$route['admin/game/logic3'] = 'Admin/game_logic3';
$route['admin/game/logic4'] = 'Admin/game_logic4';
$route['admin/game/ai_logic_management'] = 'Admin/game_ai_logic_management';

// 권한/역할 관리
$route['admin/permissions/admin_accounts'] = 'Admin/permissions_admin_accounts';
$route['admin/permissions/role_definitions'] = 'Admin/permissions_role_definitions';
$route['admin/permissions/access_control'] = 'Admin/permissions_access_control';

// 콘텐츠/공지
$route['admin/content/notices'] = 'Admin/content_notices';
$route['admin/content/banners'] = 'Admin/content_banners';
$route['admin/content/faq'] = 'Admin/content_faq';

// 결제/정산
$route['admin/payments/transactions'] = 'Admin/payments_transactions';
$route['admin/payments/deposit_withdrawal_review'] = 'Admin/payments_deposit_withdrawal_review';
$route['admin/payments/sales_report'] = 'Admin/payments_sales_report';

// 로그/감사
$route['admin/logs/system'] = 'Admin/logs_system';
$route['admin/logs/security'] = 'Admin/logs_security';
$route['admin/logs/admin_activity'] = 'Admin/logs_admin_activity';

// 통계/리포트
$route['admin/statistics/join_churn_analysis'] = 'Admin/statistics_join_churn_analysis';
$route['admin/statistics/activity_metrics'] = 'Admin/statistics_activity_metrics';
$route['admin/statistics/segment_performance'] = 'Admin/statistics_segment_performance';
$route['admin/statistics/custom_reports'] = 'Admin/statistics_custom_reports';

// 시스템 설정 (Settings 컨트롤러가 담당하는 부분 제외)
$route['admin/settings/notification_channels'] = 'Admin/settings_notification_channels';
$route['admin/settings/privacy_security'] = 'Admin/settings_privacy_security';
$route['admin/settings/integrations'] = 'Admin/settings_integrations';

// Admin 컨트롤러의 다른 모든 페이지를 처리 (위의 명시적인 라우팅보다 뒤에 위치)
$route['admin/(:any)'] = 'Admin/$1';

// 환경설정 라우팅 (추후 Settings 컨트롤러에서 처리)
$route['admin/settings/(:any)'] = 'Settings/$1';