<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI = &get_instance(); // !!! 이 줄을 추가합니다 !!!
?>
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

            <?php echo form_open('shop/' . $CI->router->fetch_method()); // 현재 메소드로 폼 제출
						?>
            <h4>
              <?php
							echo $this->shop_entity_model->get_entity_level_name($target_entity_level);
							?> 정보
            </h4>
            <div class="mb-3">
              <label for="entity_name"
                class="form-label"><?php echo $this->shop_entity_model->get_entity_level_name($target_entity_level); ?>
                이름 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="entity_name" name="entity_name"
                value="<?php echo set_value('entity_name'); ?>" required>
            </div>
            <div class="mb-3">
              <label for="entity_code"
                class="form-label"><?php echo $this->shop_entity_model->get_entity_level_name($target_entity_level); ?>
                코드 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="entity_code" name="entity_code"
                value="<?php echo set_value('entity_code'); ?>" required>
              <div class="form-text">고유한 코드 (예: HQSEOUL01, STOREGN01)</div>
            </div>
            <!-- 조직 레벨과 상위 조직은 자동으로 설정되므로 hidden 필드로 전달 -->
            <input type="hidden" name="entity_level" value="<?php echo htmlspecialchars($target_entity_level); ?>">
            <input type="hidden" name="parent_entity_id"
              value="<?php echo htmlspecialchars($parent_entity_id_for_new_entity); ?>">

            <h4 class="mt-5">해당 <?php echo $this->shop_entity_model->get_entity_level_name($target_entity_level); ?> 관리자
              계정 생성</h4>
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
            <a href="<?php echo base_url('shop'); ?>" class="btn btn-secondary">대시보드로 돌아가기</a>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>