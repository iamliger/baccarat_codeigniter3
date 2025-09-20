<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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

            <div class="alert alert-warning" role="alert">
              <strong>경고:</strong> 이 기능은 데이터베이스의 모든 핵심 데이터를 삭제하고 어드민 계정을 재설정합니다. 프로덕션 환경에서는 절대 사용하지 마십시오!
            </div>

            <h4>데이터베이스 초기화</h4>
            <p>이 버튼을 클릭하면 `users`, `shop_entities`, `shop_financials`, `game_transactions`, `bacaradb`, `3ticket`,
              `4ticket`, `5ticket`, `6ticket`, `clslog`, `baccara_config` 등 모든 핵심 테이블의 데이터가 삭제되고, 어드민 계정(ID: admin, PW:
              123456)과 기본 `baccara_config` 설정이 재시딩됩니다.</p>

            <?php echo form_open('admin/maintenance/reset_database', ['id' => 'db_reset_form']); ?>
            <button type="submit" class="btn btn-danger" id="reset_db_button">
              <i class="bi bi-exclamation-triangle"></i> 데이터베이스 초기화 및 어드민 재설정
            </button>
            <div class="spinner-border text-danger ms-2" role="status" id="loading_spinner" style="display:none;">
              <span class="visually-hidden">로딩 중...</span>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const resetButton = document.getElementById('reset_db_button');
  const loadingSpinner = document.getElementById('loading_spinner');
  const resetForm = document.getElementById('db_reset_form');

  if (resetForm && resetButton && loadingSpinner) {
    resetForm.addEventListener('submit', function(event) {
      if (!confirm('정말로 데이터베이스를 초기화하시겠습니까? 이 작업은 되돌릴 수 없으며, 모든 데이터가 손실됩니다.')) {
        event.preventDefault(); // 확인 취소 시 폼 제출 방지
        return;
      }

      // 제출 버튼 비활성화 및 스피너 표시
      resetButton.disabled = true;
      loadingSpinner.style.display = 'inline-block';
      resetButton.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 초기화 중...';
    });
  }
});
</script>