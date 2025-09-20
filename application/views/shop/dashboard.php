<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo $page_title; ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p class="h4">매장관리자님, 환영합니다! <?php echo format_user_level_display($this->session->userdata('level')); ?>.
            </p>
            <p>여기에 매장 관리와 관련된 콘텐츠를 배치합니다.</p>
            <div class="alert alert-info" role="alert">
              매장 관리자 전용 기능 (예: 테이블 관리, 정산 내역 확인 등)이 이곳에 표시됩니다.
            </div>

            <h4 class="mt-4">나의 재무 요약 (지난 7일)</h4>
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3><?php echo number_format($my_financial_summary['total_gross_revenue'] ?? 0, 2); ?></h3>
                    <p>총 수익</p>
                  </div>
                  <div class="icon"><i class="bi bi-currency-dollar"></i></div>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                  <div class="inner">
                    <h3><?php echo number_format($my_financial_summary['total_expenses'] ?? 0, 2); ?></h3>
                    <p>총 지출</p>
                  </div>
                  <div class="icon"><i class="bi bi-cash-stack"></i></div>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-info">
                  <div class="inner">
                    <h3><?php echo number_format($my_financial_summary['total_net_profit'] ?? 0, 2); ?></h3>
                    <p>순이익</p>
                  </div>
                  <div class="icon"><i class="bi bi-graph-up"></i></div>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box text-bg-secondary">
                  <div class="inner">
                    <h3><?php echo number_format($current_user_commission_rate * 100 ?? 0, 2); ?>%</h3>
                    <p>나의 수수료율</p>
                  </div>
                  <div class="icon"><i class="bi bi-percent"></i></div>
                </div>
              </div>
            </div>

            <h4 class="mt-4">나의 하위 라인 재무 요약 (지난 7일)</h4>
            <div class="table-responsive mt-3">
              <table class="table table-hover table-striped table-bordered" role="table">
                <thead>
                  <tr>
                    <th scope="col">회원 ID</th>
                    <th scope="col">레벨</th>
                    <th scope="col">총 수익</th>
                    <th scope="col">총 지출</th>
                    <th scope="col">순이익</th>
                    <th scope="col">수수료율</th>
                    <th scope="col">상세</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($child_managers_or_members)): ?>
                  <?php foreach ($child_managers_or_members as $child): ?>
                  <?php
											$financial_summary = $child_financial_summaries[$child['user_idx']] ?? [];
											$child_gross_revenue = $financial_summary['total_gross_revenue'] ?? 0;
											$child_expenses = $financial_summary['total_expenses'] ?? 0;
											$child_net_profit = $financial_summary['total_net_profit'] ?? 0;
											?>
                  <tr class="align-middle">
                    <td><?php echo htmlspecialchars($child['memberid']); ?></td>
                    <td><?php echo format_user_level_display($child['level']); ?></td>
                    <td><?php echo number_format($child_gross_revenue, 2); ?></td>
                    <td><?php echo number_format($child_expenses, 2); ?></td>
                    <td><?php echo number_format($child_net_profit, 2); ?></td>
                    <td><?php echo number_format($child['commission_rate'] * 100, 2); ?>%</td>
                    <td><a href="<?php echo base_url('shop/detail/' . $child['memberid']); ?>"
                        class="btn btn-sm btn-outline-info">보기</a></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">하위 라인 정보가 없습니다.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <h4 class="mt-5">나의 하위 계층 구조</h4>
            <?php if (empty($all_descendants)): ?>
            <p class="text-center">등록된 하위 라인 또는 회원이 없습니다.</p>
            <?php else: ?>
            <div class="card p-3 bg-light tree-container">
              <?php
								// Shop 관리자 대시보드에서는 자신의 user_idx부터 시작하는 트리를 렌더링
								echo render_user_tree_html($all_descendants, $this->session->userdata('user_idx'), 0);
								?>
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

<!-- Shop 대시보드에도 트리 뷰 JavaScript 포함 -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.tree-toggle-btn').forEach(button => {
    button.addEventListener('click', function() {
      const icon = this.querySelector('.tree-toggle-icon');
      if (icon) {
        const targetId = this.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);

        targetElement.addEventListener('show.bs.collapse', function() {
          icon.classList.remove('bi-chevron-right');
          icon.classList.add('bi-chevron-down');
        });
        targetElement.addEventListener('hide.bs.collapse', function() {
          icon.classList.remove('bi-chevron-down');
          icon.classList.add('bi-chevron-right');
        });

        if (targetElement.classList.contains('show')) {
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