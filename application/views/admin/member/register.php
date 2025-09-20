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

            <?php echo form_open('shop/member_register'); // 현재 메소드로 폼 제출 
						?>
            <h4>새 일반 회원 등록</h4>
            <p class="text-muted">이 회원은 레벨 <?php echo htmlspecialchars($target_user_level); ?>로 등록되며, 현재 관리자님의 매장에
              할당됩니다.</p>

            <!-- 숨김 필드로 레벨과 할당 조직 ID 전달 -->
            <input type="hidden" name="target_user_level" value="<?php echo htmlspecialchars($target_user_level); ?>">
            <input type="hidden" name="target_user_assigned_entity_id"
              value="<?php echo htmlspecialchars($target_user_assigned_entity_id); ?>">
            <input type="hidden" name="target_user_parent_user_idx"
              value="<?php echo htmlspecialchars($target_user_parent_user_idx); ?>">

            <div class="mb-3">
              <label for="memberid" class="form-label">회원 아이디 <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="memberid" name="memberid"
                value="<?php echo set_value('memberid'); ?>" required>
              <div class="form-text">영문, 숫자, 하이픈(-), 언더스코어(_)만 사용 가능합니다.</div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>"
                required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">비밀번호 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="form-text">최소 6자 이상</div>
            </div>
            <div class="mb-3">
              <label for="passconf" class="form-label">비밀번호 확인 <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="passconf" name="passconf" required>
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