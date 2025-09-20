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
          <div class="card-body p-0">
            <div class="table-responsive">
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
                  <?php if (!empty($child_items)): ?>
                  <?php foreach ($child_items as $child): ?>
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
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <!-- 페이지네이션 또는 추가 버튼 (필요시 추가) -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->