<?php
// CodeIgniter 인스턴스를 뷰에서 직접 가져옵니다.
$CI = &get_instance();
// shop_entity_model을 뷰에서 사용하기 위해 로드합니다. (컨트롤러에서 전달하는 것이 더 권장되나, 뷰에서 필요시 로드)
if (!isset($CI->shop_entity_model)) {
	$CI->load->model('shop_entity_model');
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills d-flex flex-wrap" role="tablist">
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'basic') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/basic'); ?>"
                  role="tab" aria-controls="basic_info"
                  aria-selected="<?php echo ($active_tab == 'basic') ? 'true' : 'false'; ?>">기본 정보</a></li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'hierarchy_settings') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/hierarchy_settings'); ?>"
                  role="tab" aria-controls="hierarchy_settings"
                  aria-selected="<?php echo ($active_tab == 'hierarchy_settings') ? 'true' : 'false'; ?>">계층/레벨 설정</a>
              </li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'security') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/security'); ?>"
                  role="tab" aria-controls="security"
                  aria-selected="<?php echo ($active_tab == 'security') ? 'true' : 'false'; ?>">보안</a></li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'permissions') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/permissions'); ?>"
                  role="tab" aria-controls="permissions"
                  aria-selected="<?php echo ($active_tab == 'permissions') ? 'true' : 'false'; ?>">권한/등급</a></li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'payments') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/payments'); ?>"
                  role="tab" aria-controls="payments"
                  aria-selected="<?php echo ($active_tab == 'payments') ? 'true' : 'false'; ?>">결제/정산 내역</a></li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'activity_log') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/activity_log'); ?>"
                  role="tab" aria-controls="activity_log"
                  aria-selected="<?php echo ($active_tab == 'activity_log') ? 'true' : 'false'; ?>">활동 로그</a></li>
              <li class="nav-item" role="presentation"><a
                  class="nav-link <?php echo ($active_tab == 'internal_memo') ? 'active' : ''; ?>"
                  href="<?php echo base_url('admin/member/detail/' . htmlspecialchars($member['memberid']) . '/internal_memo'); ?>"
                  role="tab" aria-controls="internal_memo"
                  aria-selected="<?php echo ($active_tab == 'internal_memo') ? 'true' : 'false'; ?>">내부 메모/태그</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- 기본 정보 탭 -->
              <div class="tab-pane fade <?php echo ($active_tab == 'basic') ? 'show active' : ''; ?>" id="basic_info"
                role="tabpanel" aria-labelledby="basic_info-tab">
                <h3><?php echo htmlspecialchars($member['memberid']); ?>님의 기본 정보</h3>
                <p><strong>회원 ID:</strong> <?php echo htmlspecialchars($member['memberid']); ?></p>
                <p><strong>이메일:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
                <p><strong>현재 레벨:</strong> <?php echo format_user_level_display($member['level']); ?></p>
                <p><strong>계정 상태:</strong> <?php echo translate_user_status($member['status']); ?></p>
                <p><strong>상위 관리자 User IDX:</strong> <?php echo htmlspecialchars($member['parent_user_idx'] ?? '없음'); ?>
                </p>
                <p><strong>수수료율:</strong> <?php echo htmlspecialchars(($member['commission_rate'] ?? 0) * 100); ?>%</p>
                <p><strong>계층 경로:</strong> <?php echo htmlspecialchars($member['lineage_path'] ?? '/'); ?></p>
                <?php if (!empty($member['assigned_entity_id'])): ?>
                <?php $entity_info = $CI->shop_entity_model->get_entity_by_id($member['assigned_entity_id']); ?>
                <p><strong>할당된 조직/매장 ID:</strong> <?php echo htmlspecialchars($member['assigned_entity_id']); ?></p>
                <p><strong>할당된 조직/매장 이름:</strong>
                  <?php echo htmlspecialchars($entity_info['entity_name'] ?? '알 수 없음'); ?>
                  (<?php echo $CI->shop_entity_model->get_entity_level_name($entity_info['entity_level'] ?? 0); ?>)</p>
                <?php else: ?>
                <p><strong>할당된 조직/매장 ID:</strong> 없음</p>
                <?php endif; ?>
                <p><strong>가입일:</strong> <?php echo htmlspecialchars($member['created_at']); ?></p>
              </div>

              <!-- 계층/레벨 설정 탭 -->
              <div class="tab-pane fade <?php echo ($active_tab == 'hierarchy_settings') ? 'show active' : ''; ?>"
                id="hierarchy_settings" role="tabpanel" aria-labelledby="hierarchy_settings-tab">
                <h3>회원 계층/레벨 설정</h3>
                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php echo form_open('admin/member/update_hierarchy/' . $member['user_idx']); ?>
                <div class="mb-3">
                  <label for="level" class="form-label">사용자 레벨</label>
                  <select class="form-select" id="level" name="level" required>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="<?php echo $i; ?>"
                      <?php echo (set_value('level', $member['level']) == $i) ? 'selected' : ''; ?>>레벨 <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="parent_user_idx" class="form-label">상위 관리자 (user_idx)</label>
                  <select class="form-select" id="parent_user_idx" name="parent_user_idx">
                    <option value="0"
                      <?php echo (set_value('parent_user_idx', $member['parent_user_idx'] ?? 0) == 0) ? 'selected' : ''; ?>>
                      없음 (최상위 관리자)</option>
                    <?php foreach ($potential_parents as $parent): ?>
                    <option value="<?php echo $parent['user_idx']; ?>"
                      <?php echo (set_value('parent_user_idx', $member['parent_user_idx']) == $parent['user_idx']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($parent['memberid']); ?>
                      (<?php echo format_user_level_display($parent['level']); ?>)
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="form-text">선택한 사용자의 상위 관리자를 지정합니다.</div>
                </div>
                <div class="mb-3">
                  <label for="commission_rate" class="form-label">수수료율 (%)</label>
                  <input type="number" step="0.0001" min="0" max="0.9999" class="form-control" id="commission_rate"
                    name="commission_rate"
                    value="<?php echo htmlspecialchars(set_value('commission_rate', $member['commission_rate'] ?? 0)); ?>"
                    required>
                  <div class="form-text">0.0000 (0%) ~ 0.9999 (99.99%) 사이의 소수점 값으로 입력하세요.</div>
                </div>
                <div class="mb-3">
                  <label for="assigned_entity_id" class="form-label">할당된 조직/매장</label>
                  <select class="form-select" id="assigned_entity_id" name="assigned_entity_id">
                    <option value="0"
                      <?php echo (set_value('assigned_entity_id', $member['assigned_entity_id'] ?? 0) == 0) ? 'selected' : ''; ?>>
                      없음</option>
                    <?php foreach ($assignable_entities as $entity): ?>
                    <option value="<?php echo $entity['id']; ?>"
                      <?php echo (set_value('assigned_entity_id', $member['assigned_entity_id']) == $entity['id']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($entity['entity_name']); ?>
                      (<?php echo $CI->shop_entity_model->get_entity_level_name($entity['entity_level']); ?>)
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="form-text">이 사용자가 관리할 조직 또는 매장을 지정합니다. (사용자 레벨과 일치하는 레벨의 조직만 선택 권장)</div>
                </div>
                <button type="submit" class="btn btn-primary">변경 사항 저장</button>
                <?php echo form_close(); ?>
              </div>

              <!-- 보안 탭 (예시) -->
              <div class="tab-pane fade <?php echo ($active_tab == 'security') ? 'show active' : ''; ?>" id="security"
                role="tabpanel" aria-labelledby="security-tab">
                <h3>보안 정보</h3>
                <p><strong>최근 로그인 IP:</strong> 192.168.1.1 (예시)</p>
                <p><strong>2단계 인증:</strong> 미사용 (예시)</p>
              </div>
              <!-- 권한/등급 탭 (예시) -->
              <div class="tab-pane fade <?php echo ($active_tab == 'permissions') ? 'show active' : ''; ?>"
                id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                <h3>권한 및 등급</h3>
                <p><strong>회원 등급:</strong> 일반 회원 (예시)</p>
              </div>
              <!-- 결제/정산 내역 탭 (예시) -->
              <div class="tab-pane fade <?php echo ($active_tab == 'payments') ? 'show active' : ''; ?>" id="payments"
                role="tabpanel" aria-labelledby="payments-tab">
                <h3>결제 및 정산 내역</h3>
                <p>결제 내역 없음 (예시)</p>
              </div>
              <!-- 활동 로그 탭 (예시) -->
              <div class="tab-pane fade <?php echo ($active_tab == 'activity_log') ? 'show active' : ''; ?>"
                id="activity_log" role="tabpanel" aria-labelledby="activity_log-tab">
                <h3>활동 로그</h3>
                <p>로그인: 2025-09-17 10:00:00 (예시)</p>
              </div>
              <!-- 내부 메모/태그 탭 (예시) -->
              <div class="tab-pane fade <?php echo ($active_tab == 'internal_memo') ? 'show active' : ''; ?>"
                id="internal_memo" role="tabpanel" aria-labelledby="internal_memo-tab">
                <h3>내부 메모 및 태그</h3>
                <p>특이 사항 없음 (예시)</p>
              </div>
            </div><!-- /.tab-content -->
          </div><!-- /.card-body -->
          <div class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="history.go(-1);">
              <i class="bi bi-arrow-left"></i> 이전으로 돌아가기
            </button>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Bootstrap 탭 활성화를 위한 JavaScript (필요 없음, PHP로 직접 활성화) -->
<script>
// PHP로 active 클래스를 이미 적용했으므로, 이 JavaScript는 더 이상 필요 없습니다.
// document.addEventListener('DOMContentLoaded', function() {
//   const activeTabId = '<?php echo $active_tab; ?>';
//   const tabElement = document.getElementById(activeTabId + '-tab');
//   if (tabElement) {
//     const tab = new bootstrap.Tab(tabElement);
//     tab.show();
//   }
// });
</script>