<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$CI = &get_instance();

if (!isset($CI->shop_entity_model)) {
    $CI->load->model('shop_entity_model');
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo htmlspecialchars($page_title); ?></h3>
          </div>
          <div class="card-body">
            <!-- 플래시 메시지 출력 (오류 또는 성공) -->
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($this->session->flashdata('error')); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($this->session->flashdata('success')); ?></div>
            <?php endif; ?>

            <!-- 폼 시작: 현재 Shop 컨트롤러의 메소드로 제출됩니다. -->
            <?php echo form_open('shop/' . $CI->router->fetch_method()); ?>

            <h4>
              <!-- 생성될 조직의 레벨 이름 표시 (예: '본사 정보') -->
              <?php echo htmlspecialchars($CI->shop_entity_model->get_entity_level_name($target_entity_level)); ?> 정보
            </h4>

            <!-- 조직/매장 이름 입력 필드 -->
            <div class="mb-3">
              <label for="entity_name" class="form-label">
                <?php echo htmlspecialchars($CI->shop_entity_model->get_entity_level_name($target_entity_level)); ?> 이름
                <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="entity_name" name="entity_name"
                value="<?php echo set_value('entity_name'); ?>" required>
            </div>

            <!-- 조직/매장 코드 입력 필드 -->
            <div class="mb-3">
              <label for="entity_code" class="form-label">
                <?php echo htmlspecialchars($CI->shop_entity_model->get_entity_level_name($target_entity_level)); ?> 코드
                <span class="text-danger">*</span>
              </label>
              <input type="text" class="form-control" id="entity_code" name="entity_code"
                value="<?php echo set_value('entity_code'); ?>" required>
              <div class="form-text">고유한 코드 (예: HQSEOUL01, STOREGN01)</div>
            </div>

            <!-- 조직 레벨 (hidden 필드): 현재 관리자 레벨에 의해 자동으로 결정됩니다. -->
            <input type="hidden" name="entity_level" value="<?php echo htmlspecialchars($target_entity_level); ?>">

            <!-- 상위 조직 ID (hidden 필드): 현재 로그인한 관리자의 assigned_entity_id 입니다. -->
            <input type="hidden" name="parent_entity_id"
              value="<?php echo htmlspecialchars($parent_entity_id_for_new_entity); ?>">

            <!-- 주소 입력 필드 (선택 사항) -->
            <div class="mb-3">
              <label for="address" class="form-label">주소</label>
              <input type="text" class="form-control" id="address" name="address"
                value="<?php echo set_value('address'); ?>">
            </div>

            <!-- 연락처 입력 필드 (선택 사항) -->
            <div class="mb-3">
              <label for="contact_info" class="form-label">연락처</label>
              <input type="text" class="form-control" id="contact_info" name="contact_info"
                value="<?php echo set_value('contact_info'); ?>">
            </div>

            <!-- 사업자 등록번호 입력 필드 (선택 사항) -->
            <div class="mb-3">
              <label for="business_registration_no" class="form-label">사업자 등록번호</label>
              <input type="text" class="form-control" id="business_registration_no" name="business_registration_no"
                value="<?php echo set_value('business_registration_no'); ?>">
            </div>

            <!-- 활성화 여부 체크박스 -->
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                <?php echo (set_value('is_active', 1) == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="is_active">
                활성화
              </label>
            </div>

            <h4 class="mt-5">해당 조직 관리자 계정 생성</h4>

            <!-- 관리자 아이디 입력 필드 (영문, 숫자, '_', '-'만 허용) -->
            <div class="mb-3">
              <label for="manager_memberid" class="form-label">관리자 아이디 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="manager_memberid" name="manager_memberid"
                value="<?php echo set_value('manager_memberid'); ?>" required pattern="[a-zA-Z0-9_-]+"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9_-]/g, '');"
                title="영문, 숫자, 하이픈(-) 또는 언더스코어(_)만 사용 가능합니다.">
              <div class="form-text">새로 생성될 관리자 계정의 아이디 (영문, 숫자, '_', '-'만 가능)</div>
            </div>

            <!-- 관리자 이메일 입력 필드 (올바른 이메일 형식만 허용) -->
            <div class="mb-3">
              <label for="manager_email" class="form-label">관리자 이메일 <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="manager_email" name="manager_email"
                value="<?php echo set_value('manager_email'); ?>" required
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="올바른 이메일 주소 형식을 입력하세요.">
              <div class="form-text">새로 생성될 관리자 계정의 이메일</div>
            </div>

            <!-- 관리자 비밀번호 입력 필드 -->
            <div class="mb-3">
              <label for="manager_password" class="form-label">관리자 비밀번호 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="manager_password" name="manager_password" required>
              <div class="form-text">새로 생성될 관리자 계정의 비밀번호</div>
            </div>

            <!-- 비밀번호 확인 입력 필드 -->
            <div class="mb-3">
              <label for="manager_passconf" class="form-label">비밀번호 확인 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="manager_passconf" name="manager_passconf" required>
            </div>

            <!-- 제출 및 취소 버튼 -->
            <button type="submit" class="btn btn-primary">생성</button>
            <a href="<?php echo base_url('shop'); ?>" class="btn btn-secondary">대시보드로 돌아가기</a>
            <?php echo form_close(); ?>
          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </div><!-- /.col-md-8 -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content -->
