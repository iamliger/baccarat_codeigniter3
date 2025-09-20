<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header">
            <h3 class="card-title"><?php echo $page_title; ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <?php if (empty($all_users)): ?>
            <p class="text-center">등록된 회원이 없습니다. 계층 트리를 표시할 수 없습니다.</p>
            <?php else: ?>
            <div class="card p-3 bg-light tree-container">
              <!-- tree-container 클래스 적용 -->
              <?php echo render_user_tree_html($all_users, NULL, 0); ?>
            </div>
            <?php endif; ?>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- 트리 뷰 JavaScript (상태 토글 및 아이콘 변경) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.tree-toggle-btn').forEach(button => {
    button.addEventListener('click', function() {
      const icon = this.querySelector('.tree-toggle-icon');
      if (icon) {
        // 부트스트랩 collapse 컴포넌트의 실제 상태를 확인하여 아이콘 변경
        const targetId = this.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);

        // collapse 이벤트 리스너를 추가하여 상태 변경 시 아이콘도 변경
        targetElement.addEventListener('show.bs.collapse', function() {
          icon.classList.remove('bi-chevron-right');
          icon.classList.add('bi-chevron-down');
        });
        targetElement.addEventListener('hide.bs.collapse', function() {
          icon.classList.remove('bi-chevron-down');
          icon.classList.add('bi-chevron-right');
        });

        // 초기 상태에 따라 아이콘 설정
        if (targetElement.classList.contains('show')) { // 초기에는 show 상태이므로 아래쪽 화살표
          icon.classList.remove('bi-chevron-right');
          icon.classList.add('bi-chevron-down');
        } else {
          icon.classList.remove('bi-chevron-down');
          icon.classList.add('bi-chevron-right');
        }
      }
    });
  });
});
</script>