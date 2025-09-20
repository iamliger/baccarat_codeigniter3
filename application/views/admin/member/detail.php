<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills d-flex flex-wrap" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link active" href="#basic_info"
                  data-bs-toggle="tab" role="tab" aria-selected="true">기본 정보</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#hierarchy_settings"
                  data-bs-toggle="tab" role="tab" aria-selected="false">계층/레벨 설정</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#security" data-bs-toggle="tab"
                  role="tab" aria-selected="false">보안</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#permissions" data-bs-toggle="tab"
                  role="tab" aria-selected="false">권한/등급</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#payments" data-bs-toggle="tab"
                  role="tab" aria-selected="false">결제/정산 내역</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#activity_log" data-bs-toggle="tab"
                  role="tab" aria-selected="false">활동 로그</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#internal_memo" data-bs-toggle="tab"
                  role="tab" aria-selected="false">내부 메모/태그</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- 기본 정보 탭 -->
              <div class="tab-pane active" id="basic_info" role="tabpanel">
                <h3><?php echo htmlspecialchars($member['memberid']); ?>님의 기본 정보</h3>
                <p><strong>회원 ID:</strong> <?php echo htmlspecialchars($member['memberid']); ?></p>
                <p><strong>이메일:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
                <p><strong>현재 레벨:</strong> <?php echo format_user_level_display($member['level']); ?></p>
                <p><strong>계정 상태:</strong> <?php echo translate_user_status($member['status']); ?></p>
                <p><strong>상위 관리자 User IDX:</strong> <?php echo htmlspecialchars($member['parent_user_idx'] ?? '없음'); ?>
                </p>
                <p><strong>수수료율:</strong> <?php echo htmlspecialchars(($member['commission_rate'] ?? 0) * 100); ?>%</p>
                <p><strong>계층 경로:</strong> <?php echo htmlspecialchars($member['lineage_path'] ?? '/'); ?></p>
                <!-- --- 수정 필요 부분 시작 --- -->
                <p><strong>할당된 조직/매장 ID:</strong> <?php echo htmlspecialchars($member['assigned_entity_id'] ?? '없음'); ?>
                </p>
                <?php if (!empty($member['assigned_entity_id'])): ?>
                <?php $entity_info = $this->shop_entity_model->get_entity_by_id($member['assigned_entity_id']); ?>
                <p><strong>할당된 조직/매장 이름:</strong>
                  <?php echo htmlspecialchars($entity_info['entity_name'] ?? '알 수 없음'); ?>
                  (<?php echo $this->shop_entity_model->get_entity_level_name($entity_info['entity_level'] ?? 0); ?>)
                </p>
                <?php endif; ?>
                <!-- --- 수정 필요 부분 끝 --- -->
                <p><strong>가입일:</strong> <?php echo htmlspecialchars($member['created_at']); ?></p>
              </div>

              <!-- 계층/레벨 설정 탭 -->
              <div class="tab-pane" id="hierarchy_settings" role="tabpanel">
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
                <!-- --- 수정 필요 부분 시작 --- -->
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
                      (<?php echo $this->shop_entity_model->get_entity_level_name($entity['entity_level']); ?>)
                    </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="form-text">이 사용자가 관리할 조직 또는 매장을 지정합니다. (사용자 레벨과 일치하는 레벨의 조직만 선택 권장)</div>
                </div>
                <!-- --- 수정 필요 부분 끝 --- -->
                <button type="submit" class="btn btn-primary">변경 사항 저장</button>
                <?php echo form_close(); ?>
              </div>

              <!-- ... (나머지 탭 내용 유지) ... -->
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