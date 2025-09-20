<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance(); // !!! 이 줄을 추가해야 합니다 !!!
// 필요하다면, 아래 변수들도 shop_sidebar.php처럼 정의하여 active 상태 로직에 활용할 수 있습니다.
$current_method = $CI->router->fetch_method();
$current_class = $CI->router->fetch_class();
$current_uri_string = $CI->uri->uri_string();
?>
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
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

        <!-- 홈 (요약) -->
        <li
          class="nav-item <?php echo ($current_class == 'Admin' && $current_method == 'dashboard') ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo ($current_class == 'Admin' && $current_method == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-house-door"></i>
            <p>
              홈 (요약)
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/realtime_metrics'); ?>" class="nav-link">
                <i class="nav-icon bi bi-graph-up"></i>
                <p>실시간 지표</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/notification_center'); ?>" class="nav-link">
                <i class="nav-icon bi bi-bell"></i>
                <p>알림센터</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/summary/quick_actions'); ?>" class="nav-link">
                <i class="nav-icon bi bi-lightning"></i>
                <p>빠른 작업</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- 게임관리 -->
        <li class="nav-item <?php echo (strpos($current_uri_string, 'admin/game') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/game') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-controller"></i>
            <p>
              게임관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic1'); ?>" class="nav-link"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직1</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic2'); ?>" class="nav-link"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직2</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic3'); ?>" class="nav-link"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직3</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/logic4'); ?>" class="nav-link"><i
                  class="nav-icon bi bi-gear"></i>
                <p>로직4</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/game/ai_logic_management'); ?>" class="nav-link"><i
                  class="nav-icon bi bi-cpu"></i>
                <p>AI로직관리</p>
              </a></li>
          </ul>
        </li>

        <!-- 회원관리 -->
        <li class="nav-item <?php echo (strpos($current_uri_string, 'admin/member') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/member') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-people"></i>
            <p>
              회원관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/members') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/members') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-lines-fill"></i>
                <p>
                  회원 목록
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/members/all'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/all') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>전체 회원</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/new'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/new') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>신규 가입</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/pending_verification'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/pending_verification') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>인증 대기</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/inactive'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/inactive') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>휴면/비활성</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/sanctioned'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/sanctioned') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>제재/차단</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/members/withdrawn'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/withdrawn') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>탈퇴 회원</p>
                  </a></li>

                <li class="nav-item"><a href="<?php echo base_url('admin/members/tree_view'); ?>"
                    class="nav-link <?php echo ($current_uri_string == 'admin/members/tree_view') ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-diagram-2"></i>
                    <p>계층 트리 뷰</p>
                  </a></li>
              </ul>
            </li>
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/member/detail') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-badge"></i>
                <p>
                  회원 상세
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/basic'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/basic') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>기본 정보</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/security'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/security') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>보안</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/permissions'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/permissions') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>권한/등급</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/payments'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/payments') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>결제/정산 내역</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/activity_log'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/activity_log') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>활동 로그</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/detail/internal_memo'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/detail/internal_memo') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>내부 메모/태그</p>
                  </a></li>
              </ul>
            </li>
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/member/verification') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/verification') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-patch-check"></i>
                <p>
                  인증/검증 관리
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/status'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/verification/status') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>이메일/휴대폰 인증 현황</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/kyc'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/verification/kyc') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>KYC 심사</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/verification/sanction_history'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/verification/sanction_history') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>제재/해제 이력</p>
                  </a></li>
              </ul>
            </li>
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/member/groups') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/groups') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-collection"></i>
                <p>
                  그룹/세그먼트
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/groups/create'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/groups/create') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>세그먼트 생성</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/groups/extract'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/groups/extract') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>대상 추출</p>
                  </a></li>
              </ul>
            </li>
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/member/points') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/points') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-coin"></i>
                <p>
                  포인트/마일리지
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/history'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/points/history') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>적립/차감 내역</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/batch'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/points/batch') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>일괄 지급/회수</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/points/expiration'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/points/expiration') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>만료 정책</p>
                  </a></li>
              </ul>
            </li>
            <li
              class="nav-item <?php echo (strpos($current_uri_string, 'admin/member/inquiries') !== FALSE) ? 'menu-open' : ''; ?>">
              <a href="#"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/inquiries') !== FALSE) ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-chat-dots"></i>
                <p>
                  문의/티켓
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo base_url('admin/member/inquiries/status'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/inquiries/status') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>미응답/처리중/완료</p>
                  </a></li>
                <li class="nav-item"><a href="<?php echo base_url('admin/member/inquiries/template'); ?>"
                    class="nav-link <?php echo (strpos($current_uri_string, 'admin/member/inquiries/template') !== FALSE) ? 'active' : ''; ?>"><i
                      class="nav-icon bi bi-dot"></i>
                    <p>자동응답 템플릿</p>
                  </a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/member/withdrawal_management'); ?>"
                class="nav-link <?php echo ($current_uri_string == 'admin/member/withdrawal_management') ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-person-x"></i>
                <p>탈퇴/복구 관리</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- 조직/매장 관리 (새로운 메뉴 추가) -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/shop_entities') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="<?php echo base_url('admin/shop_entities'); ?>"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/shop_entities') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-diagram-3"></i>
            <p>
              조직/매장 관리
            </p>
          </a>
        </li>

        <!-- 권한/역할 관리 -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/permissions') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/permissions') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-person-badge"></i>
            <p>
              권한/역할 관리
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/admin_accounts'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/permissions/admin_accounts') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-fill-gear"></i>
                <p>관리자 계정</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/role_definitions'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/permissions/role_definitions') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-people-fill"></i>
                <p>역할(Role) 정의</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/permissions/access_control'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/permissions/access_control') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-shield-check"></i>
                <p>접근 권한</p>
              </a></li>
          </ul>
        </li>

        <!-- 콘텐츠/공지 -->
        <li class="nav-item <?php echo (strpos($current_uri_string, 'admin/content') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/content') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-card-text"></i>
            <p>
              콘텐츠/공지
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/content/notices'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/content/notices') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-megaphone"></i>
                <p>공지사항</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/content/banners'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/content/banners') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-easel"></i>
                <p>배너/팝업</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/content/faq'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/content/faq') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-question-circle"></i>
                <p>FAQ/도움말</p>
              </a></li>
          </ul>
        </li>

        <!-- 결제/정산 -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/payments') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/payments') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-credit-card"></i>
            <p>
              결제/정산
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/transactions'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/payments/transactions') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-receipt"></i>
                <p>결제 내역/환불</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/deposit_withdrawal_review'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/payments/deposit_withdrawal_review') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-wallet2"></i>
                <p>충전/출금 심사</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/payments/sales_report'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/payments/sales_report') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-bar-chart"></i>
                <p>매출 리포트</p>
              </a></li>
          </ul>
        </li>

        <!-- 로그/감사 -->
        <li class="nav-item <?php echo (strpos($current_uri_string, 'admin/logs') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/logs') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-journal-text"></i>
            <p>
              로그/감사
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/system'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/logs/system') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-file-earmark-text"></i>
                <p>시스템 로그</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/security'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/logs/security') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-shield-lock"></i>
                <p>보안 로그</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/logs/admin_activity'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/logs/admin_activity') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-workspace"></i>
                <p>관리자 활동 이력</p>
              </a></li>
          </ul>
        </li>

        <!-- 통계/리포트 -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/statistics') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/statistics') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-graph-up-arrow"></i>
            <p>
              통계/리포트
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/join_churn_analysis'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/statistics/join_churn_analysis') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-person-plus-fill"></i>
                <p>가입/이탈 분석</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/activity_metrics'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/statistics/activity_metrics') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-activity"></i>
                <p>활성도</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/segment_performance'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/statistics/segment_performance') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-award"></i>
                <p>세그먼트 성과</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/statistics/custom_reports'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/statistics/custom_reports') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-file-bar-graph"></i>
                <p>커스텀 리포트</p>
              </a></li>
          </ul>
        </li>

        <!-- 시스템 설정 -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/settings') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="#"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/settings') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-gear"></i>
            <p>
              시스템 설정
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/general_policy'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/settings/general_policy') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-journal-bookmark"></i>
                <p>기본 정책 및 인증</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/notification_channels'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/settings/notification_channels') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-app-indicator"></i>
                <p>알림 채널</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/privacy_security'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/settings/privacy_security') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-incognito"></i>
                <p>개인정보/보안</p>
              </a></li>
            <li class="nav-item"><a href="<?php echo base_url('admin/settings/integrations'); ?>"
                class="nav-link <?php echo (strpos($current_uri_string, 'admin/settings/integrations') !== FALSE) ? 'active' : ''; ?>"><i
                  class="nav-icon bi bi-plug"></i>
                <p>통합 설정</p>
              </a></li>
          </ul>
        </li>

        <!-- DB 유지보수 (새로운 메뉴 추가) -->
        <li
          class="nav-item <?php echo (strpos($current_uri_string, 'admin/maintenance') !== FALSE) ? 'menu-open' : ''; ?>">
          <a href="<?php echo base_url('admin/maintenance'); ?>"
            class="nav-link <?php echo (strpos($current_uri_string, 'admin/maintenance') !== FALSE) ? 'active' : ''; ?>">
            <i class="nav-icon bi bi-tools"></i>
            <p>DB 유지보수</p>
          </a>
        </li>

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
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0"><?php echo $page_title; ?></h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">홈</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
          </ol>
        </div>
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->
  </div>
  <!--end::App Content Header-->
  <!--begin::App Content-->
  <div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
      <!-- 여기에 대시보드 본문 내용이 로드됩니다 (admin/dashboard.php 또는 다른 뷰 파일) -->