<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?php echo htmlspecialchars($page_title); ?></h3>
          </div>
          <div class="card-body">
            <h4><?php echo htmlspecialchars($member['memberid']); ?>님의 상세 정보 (레벨
              <?php echo htmlspecialchars($member['level']); ?>)</h4>
            <p><strong>이메일:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
            <p><strong>상위 관리자 user_idx:</strong> <?php echo htmlspecialchars($member['parent_user_idx'] ?? '없음'); ?></p>
            <p><strong>수수료율:</strong> <?php echo number_format($member['commission_rate'] * 100 ?? 0, 2); ?>%</p>
            <p><strong>계층 경로:</strong> <?php echo htmlspecialchars($member['lineage_path'] ?? '/'); ?></p>
            <p><strong>가입일:</strong> <?php echo htmlspecialchars(format_date_only($member['created_at'])); ?></p>

            <h5 class="mt-4">재무 요약 (지난 7일)</h5>
            <p><strong>총 수익:</strong> <?php echo number_format($financial_summary['total_gross_revenue'] ?? 0, 2); ?>
            </p>
            <p><strong>총 지출:</strong> <?php echo number_format($financial_summary['total_expenses'] ?? 0, 2); ?></p>
            <p><strong>순이익:</strong> <?php echo number_format($financial_summary['total_net_profit'] ?? 0, 2); ?></p>

            <button type="button" class="btn btn-secondary mt-3" onclick="history.go(-1);">
              <i class="bi bi-arrow-left"></i> 이전으로 돌아가기
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
