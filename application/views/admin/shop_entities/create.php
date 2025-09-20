<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo $page_title; ?></h3>
          </div>
          <div class="card-body">
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php echo form_open('admin/shop_entities/store'); ?>
            <h4>조직/매장 정보</h4>
            <div class="mb-3">
              <label for="entity_name" class="form-label">조직/매장 이름 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="entity_name" name="entity_name"
                value="<?php echo set_value('entity_name'); ?>" required>
            </div>
            <div class="mb-3">
              <label for="entity_code" class="form-label">조직/매장 코드 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="entity_code" name="entity_code"
                value="<?php echo set_value('entity_code'); ?>" required>
              <div class="form-text">고유한 코드 (예: HQSEOUL01, STOREGN01)</div>
            </div>
            <div class="mb-3">
              <label for="entity_level" class="form-label">조직 레벨 <span class="text-danger">*</span></label>
              <select class="form-select" id="entity_level" name="entity_level" required>
                <?php for ($i = 9; $i >= 3; $i--): ?>
                <option value="<?php echo $i; ?>" <?php echo (set_value('entity_level') == $i) ? 'selected' : ''; ?>>
                  <?php echo $this->shop_entity_model->get_entity_level_name($i); ?> (레벨 <?php echo $i; ?>)
                </option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="parent_entity_id" class="form-label">상위 조직/매장</label>
              <select class="form-select" id="parent_entity_id" name="parent_entity_id">
                <option value="0" <?php echo (set_value('parent_entity_id') == 0) ? 'selected' : ''; ?>>없음 (최상위 그룹)
                </option>
                <?php foreach ($parent_entities as $parent): ?>
                <option value="<?php echo $parent['id']; ?>"
                  <?php echo (set_value('parent_entity_id') == $parent['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($parent['entity_name']); ?>
                  (<?php echo $this->shop_entity_model->get_entity_level_name($parent['entity_level']); ?>)
                </option>
                <?php endforeach; ?>
              </select>
              <div class="form-text">선택하지 않으면 최상위 그룹으로 생성됩니다.</div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">주소</label>
              <input type="text" class="form-control" id="address" name="address"
                value="<?php echo set_value('address'); ?>">
            </div>
            <div class="mb-3">
              <label for="contact_info" class="form-label">연락처</label>
              <input type="text" class="form-control" id="contact_info" name="contact_info"
                value="<?php echo set_value('contact_info'); ?>">
            </div>
            <div class="mb-3">
              <label for="business_registration_no" class="form-label">사업자 등록번호</label>
              <input type="text" class="form-control" id="business_registration_no" name="business_registration_no"
                value="<?php echo set_value('business_registration_no'); ?>">
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                <?php echo (set_value('is_active', 1) == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="is_active">
                활성화
              </label>
            </div>

            <h4 class="mt-5">해당 조직 관리자 계정 생성</h4>
            <div class="mb-3">
              <label for="manager_memberid" class="form-label">관리자 아이디 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="manager_memberid" name="manager_memberid"
                value="<?php echo set_value('manager_memberid'); ?>" required>
              <div class="form-text">새로 생성될 관리자 계정의 아이디</div>
            </div>
            <div class="mb-3">
              <label for="manager_email" class="form-label">관리자 이메일 <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="manager_email" name="manager_email"
                value="<?php echo set_value('manager_email'); ?>" required>
              <div class="form-text">새로 생성될 관리자 계정의 이메일</div>
            </div>
            <div class="mb-3">
              <label for="manager_password" class="form-label">관리자 비밀번호 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="manager_password" name="manager_password" required>
              <div class="form-text">새로 생성될 관리자 계정의 비밀번호</div>
            </div>
            <div class="mb-3">
              <label for="manager_passconf" class="form-label">비밀번호 확인 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="manager_passconf" name="manager_passconf" required>
            </div>

            <button type="submit" class="btn btn-primary">생성</button>
            <a href="<?php echo base_url('admin/shop_entities'); ?>" class="btn btn-secondary">목록으로 돌아가기</a>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>