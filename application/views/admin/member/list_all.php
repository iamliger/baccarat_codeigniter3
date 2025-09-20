<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header">
            <h3 class="card-title">전체 회원 목록</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover table-striped table-bordered" role="table">
                <thead>
                  <tr>
                    <th style="width: 10px" scope="col">#</th>
                    <th scope="col">회원 ID</th>
                    <th scope="col">이메일</th>
                    <th scope="col">레벨</th>
                    <th scope="col">가입일</th>
                    <th scope="col">상태</th>
                    <th style="width: 180px" scope="col">액션</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($members)): ?>
                  <?php $offset = $this->uri->segment(4); // 현재 오프셋 가져오기 
										?>
                  <?php $display_idx = ($offset ? (($offset / 10) * 10) : 0) + 1; // 페이지 번호가 아닌 실제 인덱스 계산, 루프 외부에서 초기화 
										?>
                  <?php foreach ($members as $member): ?>
                  <!-- $member 변수가 여기부터 정의됨 -->
                  <tr class="align-middle">
                    <td><?php echo $display_idx++; ?>.</td>
                    <td><?php echo htmlspecialchars($member['memberid']); ?></td>
                    <td><?php echo htmlspecialchars($member['email']); ?></td>
                    <td><?php echo format_user_level_display($member['level']); ?></td>
                    <td><?php echo htmlspecialchars(format_date_only($member['created_at'])); ?></td>
                    <td>
                      <span class="btn btn-sm
                                                        <?php
																												if ($member['status'] == 'approved') echo 'text-bg-success';
																												else if ($member['status'] == 'pending') echo 'text-bg-warning';
																												else if ($member['status'] == 'suspended') echo 'text-bg-danger';
																												else if ($member['status'] == 'withdrawn') echo 'text-bg-secondary';
																												else echo 'text-bg-info';
																												?>">
                        <?php echo translate_user_status($member['status']); ?>
                      </span>
                    </td>
                    <td class="text-nowrap">
                      <a href="<?php echo base_url('admin/member/detail/' . $member['memberid']); ?>"
                        class="btn btn-sm btn-info">상세 보기</a>
                      <a href="#" class="btn btn-sm btn-warning">수정</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">등록된 회원이 없습니다.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div> <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <!-- 페이지네이션 링크 출력 -->
            <?php echo $pagination_links; ?>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->