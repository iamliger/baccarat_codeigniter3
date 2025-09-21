<?php
/**
 * 파일: application/views/layouts/admin_sidebar.php
 * 설명: 어드민 대시보드의 좌측 사이드바 메뉴.
 *       현재 페이지의 URI를 기반으로 메뉴 항목을 활성화하고 펼칩니다.
 *       오직 레벨 10 (어드민)에게만 표시됩니다.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// CodeIgniter 인스턴스를 가져옵니다.
$CI = &get_instance();

// 현재 라우팅 정보
$current_class = $CI->router->fetch_class(); // 현재 컨트롤러 클래스 이름 (예: 'Admin', 'Member', 'AdminShopEntity')
$current_method = $CI->router->fetch_method(); // 현재 컨트롤러 메소드 이름 (예: 'dashboard', 'all', 'create')
$current_uri_string = $CI->uri->uri_string(); // 전체 URI 문자열 (예: 'admin/members/all')

// --- 디버그 메시지 (필요시 활성화) ---
// log_message('info', 'admin_sidebar.php - Current URI: ' . $current_uri_string);
// log_message('info', 'admin_sidebar.php - Session Data: ' . print_r($CI->session->userdata(), TRUE));
// ------------------------------------
?>

<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="<?php echo base_url('admin'); ?>" class="brand-link">
      <span class="brand-text fw-light">AdminLTE 4</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
        data-accordion="false" id="navigation">

        <!-- 대시보드 (Admin 컨트롤러의 index/dashboard 메소드) -->
        <li class="nav-item">
          <a href="<?php echo base_url('admin/dashboard'); ?>"
            class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>대시보드</p>
          </a>
        </li>

        <!-- 홈 (요약) 카테고리 -->
        <?php $is_summary_active = (
            $current_class == 'Admin' && strpos($current_method, 'summary_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_summary_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_summary_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-house-door"></i>
            <p>
              홈 (요약)
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/realtime_metrics'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'summary_realtime_metrics') ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-graph-up"></i>
                <p>실시간 지표</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/notification_center'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'summary_notification_center') ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-bell"></i>
                <p>알림센터</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/quick_actions'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'summary_quick_actions') ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-lightning"></i>
                <p>빠른 작업</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- 게임관리 카테고리 -->
        <?php $is_game_active = (
            $current_class == 'Admin' && strpos($current_method, 'game_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_game_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_game_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-controller"></i>
            <p>
              게임관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic1'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'game_logic1') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직1</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic2'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'game_logic2') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직2</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic3'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'game_logic3') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직3</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic4'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'game_logic4') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직4</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/ai_logic_management'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'game_ai_logic_management') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-cpu"></i>
                <p>AI로직관리</p>
              </a></li>
          </ul>
        </li>

        <!-- 회원관리 카테고리 -->
        <?php $is_member_active = (
            $current_class == 'Member' ||
            ($current_class == 'Admin' && strpos($current_method, 'member_') === 0) // Member 컨트롤러 또는 Admin 컨트롤러의 member_로 시작하는 메소드
        ); ?>
        <li class="nav-item <?php echo $is_member_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_member_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-people"></i>
            <p>
              회원관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- 회원 목록 하위 메뉴 -->
            <?php $is_members_list_active = (
                $current_class == 'Member' && (
                    $current_method == 'all' ||
                    $current_method == 'new_members' ||
                    $current_method == 'pending_verification' ||
                    $current_method == 'inactive' ||
                    $current_method == 'sanctioned' ||
                    $current_method == 'withdrawn' ||
                    $current_method == 'tree_view'
                )
            ); ?>
            <li class="nav-item <?php echo $is_members_list_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_members_list_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-lines-fill"></i>
                <p>
                  회원 목록
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/members/all'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'all') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>전체 회원</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/new'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'new_members') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>신규 가입</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/pending_verification'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'pending_verification') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>인증 대기</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/inactive'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'inactive') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>휴면/비활성</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/sanctioned'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'sanctioned') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>제재/차단</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/withdrawn'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'withdrawn') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>탈퇴 회원</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/tree_view'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'tree_view') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-diagram-2"></i>
                    <p>계층 트리 뷰</p>
                  </a></li>
              </ul>
            </li>

            <!-- 회원 상세 하위 메뉴 (detail 메소드만 처리) -->
            <?php $is_member_detail_active = ($current_class == 'Member' && $current_method == 'detail'); ?>
            <li class="nav-item <?php echo $is_member_detail_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_member_detail_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-badge"></i>
                <p>
                  회원 상세
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/basic'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'basic') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>기본 정보</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/hierarchy_settings'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'hierarchy_settings') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>계층/레벨 설정</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/security'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'security') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>보안</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/permissions'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'permissions') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>권한/등급</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/payments'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'payments') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>결제/정산 내역</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/activity_log'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'activity_log') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>활동 로그</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/internal_memo'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'detail' && $CI->uri->segment(4) == 'internal_memo') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>내부 메모/태그</p>
                  </a></li>
              </ul>
            </li>

            <!-- 인증/검증 관리 하위 메뉴 -->
            <?php $is_verification_active = (
                $current_class == 'Member' && strpos($current_method, 'verification_') === 0
            ); ?>
            <li class="nav-item <?php echo $is_verification_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_verification_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-patch-check"></i>
                <p>
                  인증/검증 관리
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/status'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'verification_status') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>이메일/휴대폰 인증 현황</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/kyc'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'kyc_review') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>KYC 심사</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/sanction_history'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'sanction_history') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>제재/해제 이력</p>
                  </a></li>
              </ul>
            </li>

            <!-- 그룹/세그먼트 하위 메뉴 -->
            <?php $is_groups_active = (
                $current_class == 'Member' && strpos($current_method, 'groups_') === 0
            ); ?>
            <li class="nav-item <?php echo $is_groups_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_groups_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-collection"></i>
                <p>
                  그룹/세그먼트
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/groups/create'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'groups_create') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>세그먼트 생성</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/groups/extract'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'groups_extract') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>대상 추출</p>
                  </a></li>
              </ul>
            </li>

            <!-- 포인트/마일리지 하위 메뉴 -->
            <?php $is_points_active = (
                $current_class == 'Member' && strpos($current_method, 'points_') === 0
            ); ?>
            <li class="nav-item <?php echo $is_points_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_points_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-coin"></i>
                <p>
                  포인트/마일리지
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/history'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'points_history') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>적립/차감 내역</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/batch'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'points_batch') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>일괄 지급/회수</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/expiration'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'points_expiration') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>만료 정책</p>
                  </a></li>
              </ul>
            </li>

            <!-- 문의/티켓 하위 메뉴 -->
            <?php $is_inquiries_active = (
                $current_class == 'Member' && strpos($current_method, 'inquiries_') === 0
            ); ?>
            <li class="nav-item <?php echo $is_inquiries_active ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link <?php echo $is_inquiries_active ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-chat-dots"></i>
                <p>
                  문의/티켓
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/inquiries/status'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'inquiries_status') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>미응답/처리중/완료</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/inquiries/template'); ?>"
                    class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'inquiries_template') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>자동응답 템플릿</p>
                  </a></li>
              </ul>
            </li>

            <!-- 탈퇴/복구 관리 메뉴 -->
            <li class="nav-item">
              <a href="<?php echo base_url('admin/member/withdrawal_management'); ?>"
                class="nav-link <?php echo ($current_class == 'Member' && $current_method == 'withdrawal_management') ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-x"></i>
                <p>탈퇴/복구 관리</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- 조직/매장 관리 카테고리 -->
        <?php $is_shop_entities_active = ($current_class == 'AdminShopEntity'); ?>
        <li class="nav-item <?php echo $is_shop_entities_active ? 'menu-open' : ''; ?>">
          <a href="<?php echo base_url('admin/shop_entities'); ?>"
            class="nav-link <?php echo $is_shop_entities_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-diagram-3"></i>
            <p>
              조직/매장 관리
            </p>
          </a>
        </li>

        <!-- 권한/역할 관리 카테고리 -->
        <?php $is_permissions_active = (
            $current_class == 'Admin' && strpos($current_method, 'permissions_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_permissions_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_permissions_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-person-badge"></i>
            <p>
              권한/역할 관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/admin_accounts'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'permissions_admin_accounts') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-fill-gear"></i>
                <p>관리자 계정</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/role_definitions'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'permissions_role_definitions') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-people-fill"></i>
                <p>역할(Role) 정의</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/access_control'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'permissions_access_control') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-shield-check"></i>
                <p>접근 권한</p>
              </a></li>
          </ul>
        </li>

        <!-- 콘텐츠/공지 카테고리 -->
        <?php $is_content_active = (
            $current_class == 'Admin' && strpos($current_method, 'content_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_content_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_content_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-card-text"></i>
            <p>
              콘텐츠/공지
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/content/notices'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'content_notices') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-megaphone"></i>
                <p>공지사항</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/content/banners'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'content_banners') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-easel"></i>
                <p>배너/팝업</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/content/faq'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'content_faq') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-question-circle"></i>
                <p>FAQ/도움말</p>
              </a></li>
          </ul>
        </li>

        <!-- 결제/정산 카테고리 -->
        <?php $is_payments_active = (
            $current_class == 'Admin' && strpos($current_method, 'payments_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_payments_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_payments_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-credit-card"></i>
            <p>
              결제/정산
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/transactions'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'payments_transactions') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-receipt"></i>
                <p>결제 내역/환불</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/deposit_withdrawal_review'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'payments_deposit_withdrawal_review') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-wallet2"></i>
                <p>충전/출금 심사</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/sales_report'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'payments_sales_report') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-bar-chart"></i>
                <p>매출 리포트</p>
              </a></li>
          </ul>
        </li>

        <!-- 로그/감사 카테고리 -->
        <?php $is_logs_active = (
            $current_class == 'Admin' && strpos($current_method, 'logs_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_logs_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_logs_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-journal-text"></i>
            <p>
              로그/감사
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/system'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'logs_system') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-file-earmark-text"></i>
                <p>시스템 로그</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/security'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'logs_security') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-shield-lock"></i>
                <p>보안 로그</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/admin_activity'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'logs_admin_activity') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-workspace"></i>
                <p>관리자 활동 이력</p>
              </a></li>
          </ul>
        </li>

        <!-- 통계/리포트 카테고리 -->
        <?php $is_statistics_active = (
            $current_class == 'Admin' && strpos($current_method, 'statistics_') === 0
        ); ?>
        <li class="nav-item <?php echo $is_statistics_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_statistics_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-graph-up-arrow"></i>
            <p>
              통계/리포트
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/join_churn_analysis'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'statistics_join_churn_analysis') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-plus-fill"></i>
                <p>가입/이탈 분석</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/activity_metrics'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'statistics_activity_metrics') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-activity"></i>
                <p>활성도</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/segment_performance'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'statistics_segment_performance') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-award"></i>
                <p>세그먼트 성과</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/custom_reports'); ?>"
                class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'statistics_custom_reports') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-file-bar-graph"></i>
                <p>커스텀 리포트</p>
              </a></li>
          </ul>
        </li>

        <!-- 시스템 설정 카테고리 -->
        <?php $is_settings_active = ($current_class == 'Settings'); ?>
        <li class="nav-item <?php echo $is_settings_active ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link <?php echo $is_settings_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-gear"></i>
            <p>
              시스템 설정
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/general_policy'); ?>"
                class="nav-link <?php echo ($current_class == 'Settings' && $current_method == 'general_policy') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-journal-bookmark"></i>
                <p>기본 정책 및 인증</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/notification_channels'); ?>"
                class="nav-link <?php echo ($current_class == 'Settings' && $current_method == 'notification_channels') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-app-indicator"></i>
                <p>알림 채널</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/privacy_security'); ?>"
                class="nav-link <?php echo ($current_class == 'Settings' && $current_method == 'privacy_security') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-incognito"></i>
                <p>개인정보/보안</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/integrations'); ?>"
                class="nav-link <?php echo ($current_class == 'Settings' && $current_method == 'integrations') ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-plug"></i>
                <p>통합 설정</p>
              </a></li>
          </ul>
        </li>

        <!-- DB 유지보수 메뉴 -->
        <?php $is_maintenance_active = ($current_class == 'AdminMaintenance'); ?>
        <li class="nav-item <?php echo $is_maintenance_active ? 'menu-open' : ''; ?>">
          <a href="<?php echo base_url('admin/maintenance'); ?>"
            class="nav-link <?php echo $is_maintenance_active ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-tools"></i>
            <p>DB 유지보수</p>
          </a>
        </li>

        <!-- 로그아웃 메뉴 -->
        <li class="nav-item">
          <a href="<?php echo base_url('logout'); ?>" class="nav-link">
            <i class="nav-icon bi bi-box-arrow-right"></i>
            <p>로그아웃</p>
          </a>
        </li>
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->

<!--begin::App Main-->
<main class="app-main">
  <!--begin::App Content Header-->
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0"><?php echo htmlspecialchars($page_title); ?></h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">홈</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($page_title); ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!--end::App Content Header-->

  <!--begin::App Content-->
  <div class="app-content">
    <div class="container-fluid">
      <!-- 여기에 대시보드 본문 내용이 로드됩니다 (admin/dashboard.php 또는 다른 뷰 파일) -->
