<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI = &get_instance();
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

            <!-- 폼 시작: 현재 Shop 컨트롤러의 member_register 메소드로 제출됩니다. -->
            <?php echo form_open('shop/member_register'); ?>

            <h4>새 일반 회원 등록</h4>
            <p class="text-muted">
              이 회원은 레벨 <?php echo htmlspecialchars($target_user_level); ?>로 등록되며,
              현재 관리자님의 매장에 할당됩니다.
            </p>

            <!-- 숨김 필드로 레벨, 상위 관리자 user_idx, 할당 조직 ID 전달 -->
            <input type="hidden" name="target_user_level" value="<?php echo htmlspecialchars($target_user_level); ?>">
            <input type="hidden" name="target_user_assigned_entity_id"
              value="<?php echo htmlspecialchars($target_user_assigned_entity_id); ?>">
            <input type="hidden" name="target_user_parent_user_idx"
              value="<?php echo htmlspecialchars($target_user_parent_user_idx); ?>">

            <!-- 회원 아이디 입력 필드 (영문, 숫자, '_', '-'만 허용) -->
            <div class="mb-3">
              <label for="memberid" class="form-label">회원 아이디 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="memberid" name="memberid"
                value="<?php echo set_value('memberid'); ?>" required pattern="[a-zA-Z0-9_-]+"
                oninput="this.value = this.value.replace(/[^a-zA-Z0-9_-]/g, '');"
                title="영문, 숫자, 하이픈(-) 또는 언더스코어(_)만 사용 가능합니다.">
              <div class="form-text">새로 생성될 일반 회원 계정의 아이디 (영문, 숫자, '_', '-'만 가능)</div>
            </div>

            <!-- 이메일 입력 필드 (올바른 이메일 형식만 허용) -->
            <div class="mb-3">
              <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>"
                required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="올바른 이메일 주소 형식을 입력하세요.">
              <div class="form-text">새로 생성될 일반 회원 계정의 이메일</div>
            </div>

            <!-- 비밀번호 입력 필드 -->
            <div class="mb-3">
              <label for="password" class="form-label">비밀번호 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="form-text">최소 6자 이상</div>
            </div>

            <!-- 비밀번호 확인 입력 필드 -->
            <div class="mb-3">
              <label for="passconf" class="form-label">비밀번호 확인 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="passconf" name="passconf" required>
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
