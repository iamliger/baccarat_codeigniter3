<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#general_policy" data-bs-toggle="tab">기본 정책</a></li>
              <li class="nav-item"><a class="nav-link" href="#notification_channels" data-bs-toggle="tab">알림 채널</a></li>
              <li class="nav-item"><a class="nav-link" href="#privacy_security" data-bs-toggle="tab">개인정보/보안</a></li>
              <li class="nav-item"><a class="nav-link" href="#integrations" data-bs-toggle="tab">통합 설정</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="general_policy">
                <h3>기본 정책 설정</h3>
                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php echo form_open('admin/settings/general_policy'); ?>
                <div class="mb-3">
                  <label for="min_password_length" class="form-label">최소 비밀번호 길이</label>
                  <input type="number" class="form-control" id="min_password_length" name="min_password_length"
                    value="<?php echo htmlspecialchars($general_policy['min_password_length'] ?? 6); ?>">
                </div>
                <div class="mb-3">
                  <label for="inactive_days" class="form-label">휴면 계정 전환 일수</label>
                  <input type="number" class="form-control" id="inactive_days" name="inactive_days"
                    value="<?php echo htmlspecialchars($general_policy['inactive_days'] ?? 90); ?>">
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="allow_registration" name="allow_registration"
                    value="1" <?php echo ($general_policy['allow_registration'] ?? TRUE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="allow_registration">
                    회원가입 허용
                  </label>
                </div>
                <button type="submit" class="btn btn-primary">저장</button>
                <?php echo form_close(); ?>
              </div>
              <!-- 다른 탭 내용은 Settings 컨트롤러에서 해당 메소드로 직접 연결됩니다. -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
