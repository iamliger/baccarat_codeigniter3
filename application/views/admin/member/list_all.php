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
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>회원 ID</th>
                    <th>가입일</th>
                    <th>최근 활동</th>
                    <th>상태</th>
                    <th style="width: 150px">액션</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($members)): ?>
                  <?php $idx = 1;
										foreach ($members as $member): ?>
                  <tr>
                    <td><?php echo $idx++; ?>.</td>
                    <td><?php echo htmlspecialchars($member['memberid']); ?></td>
                    <td><?php echo htmlspecialchars($member['dayinfo']); ?></td>
                    <td><?php // TODO: 최근 활동 시간 추가
														?></td>
                    <td><span class="badge text-bg-success">활성</span></td>
                    <td class="text-nowrap">
                      <a href="<?php echo base_url('admin/member/detail/' . $member['memberid']); ?>"
                        class="btn btn-sm btn-info">상세 보기</a>
                      <a href="#" class="btn btn-sm btn-warning">수정</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">등록된 회원이 없습니다.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <!-- 페이지네이션 또는 추가 버튼 -->
            <ul class="pagination pagination-sm m-0 float-end">
              <li class="page-item"><a class="page-link" href="#">«</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
