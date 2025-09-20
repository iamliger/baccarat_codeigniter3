<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills d-flex flex-wrap" role="tablist">
              <li class="nav-item" role="presentation"><a class="nav-link active" href="#general_policy"
                  data-bs-toggle="tab" role="tab" aria-selected="true">기본 정책 및 인증</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#notification_channels"
                  data-bs-toggle="tab" role="tab" aria-selected="false">알림 채널</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#privacy_security" data-bs-toggle="tab"
                  role="tab" aria-selected="false">개인정보/보안</a></li>
              <li class="nav-item" role="presentation"><a class="nav-link" href="#integrations" data-bs-toggle="tab"
                  role="tab" aria-selected="false">통합 설정</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="general_policy" role="tabpanel">
                <h3>기본 정책 및 인증 설정</h3>
                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php echo form_open('admin/settings/general_policy'); ?>
                <h4 class="mt-4">회원 가입/로그인 정책</h4>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="allow_registration" name="allow_registration"
                    value="1" <?php echo ($settings['allow_registration'] ?? TRUE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="allow_registration">
                    회원가입 허용
                  </label>
                </div>
                <div class="mb-3">
                  <label for="login_mode" class="form-label">로그인 방식</label>
                  <select class="form-select" id="login_mode" name="login_mode" required>
                    <option value="memberid"
                      <?php echo (($settings['login_mode'] ?? 'memberid') == 'memberid') ? 'selected' : ''; ?>>아이디로만 로그인
                    </option>
                    <option value="email"
                      <?php echo (($settings['login_mode'] ?? 'memberid') == 'email') ? 'selected' : ''; ?>>이메일로만 로그인
                    </option>
                    <option value="both"
                      <?php echo (($settings['login_mode'] ?? 'memberid') == 'both') ? 'selected' : ''; ?>>아이디 또는 이메일로
                      로그인</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="memberid_regex" class="form-label">아이디 유효성 정규식</label>
                  <input type="text" class="form-control" id="memberid_regex" name="memberid_regex"
                    value="<?php echo htmlspecialchars($settings['memberid_regex'] ?? '^[a-zA-Z0-9_-]+$'); ?>">
                  <div class="form-text">아이디에 허용할 문자 규칙을 정규식으로 입력하세요. (예: 영문, 숫자, _, - 만 허용 `^[a-zA-Z0-9_-]+$`)</div>
                </div>

                <h4 class="mt-4">비밀번호 정책</h4>
                <div class="mb-3">
                  <label for="min_password_length" class="form-label">최소 비밀번호 길이</label>
                  <input type="number" class="form-control" id="min_password_length" name="min_password_length"
                    value="<?php echo htmlspecialchars($settings['min_password_length'] ?? 6); ?>">
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="password_requires_uppercase"
                    name="password_requires_uppercase" value="1"
                    <?php echo ($settings['password_requires_uppercase'] ?? FALSE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="password_requires_uppercase">
                    대문자 필수
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="password_requires_lowercase"
                    name="password_requires_lowercase" value="1"
                    <?php echo ($settings['password_requires_lowercase'] ?? FALSE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="password_requires_lowercase">
                    소문자 필수
                  </label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" id="password_requires_number"
                    name="password_requires_number" value="1"
                    <?php echo ($settings['password_requires_number'] ?? FALSE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="password_requires_number">
                    숫자 필수
                  </label>
                </div>
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="password_requires_special"
                    name="password_requires_special" value="1"
                    <?php echo ($settings['password_requires_special'] ?? FALSE) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="password_requires_special">
                    특수문자 필수
                  </label>
                </div>

                <h4 class="mt-4">기타 정책</h4>
                <div class="mb-3">
                  <label for="inactive_days" class="form-label">휴면 계정 전환 일수</label>
                  <input type="number" class="form-control" id="inactive_days" name="inactive_days"
                    value="<?php echo htmlspecialchars($settings['inactive_days'] ?? 90); ?>">
                </div>
                <button type="submit" class="btn btn-primary">변경 사항 저장</button>
                <?php echo form_close(); ?>
              </div>
              <!-- ... (다른 탭 내용 유지) ... -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>