<!-- Content Wrapper. Contains page content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header">
            <h3 class="card-title"><?php echo $page_title; ?></h3>
            <div class="card-tools">
              <a href="<?php echo base_url('admin/shop_entities/create'); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> 새 조직/매장 생성
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger mx-3 mt-3"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success mx-3 mt-3"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <div class="table-responsive">
              <table class="table table-hover table-striped table-bordered" role="table">
                <thead>
                  <tr>
                    <th style="width: 10px" scope="col">ID</th>
                    <th scope="col">이름</th>
                    <th scope="col">코드</th>
                    <th scope="col">레벨</th>
                    <th scope="col">상위 조직</th>
                    <th scope="col">관리자</th> <!-- 관리자 컬럼 추가 -->
                    <th scope="col">활성</th>
                    <th scope="col">생성일</th>
                    <th style="width: 180px" scope="col">액션</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($entities)): ?>
                  <?php foreach ($entities as $entity): ?>
                  <tr class="align-middle">
                    <td><?php echo htmlspecialchars($entity['id']); ?>.</td>
                    <td><?php echo htmlspecialchars($entity['entity_name']); ?></td>
                    <td><?php echo htmlspecialchars($entity['entity_code']); ?></td>
                    <td><?php echo $this->shop_entity_model->get_entity_level_name($entity['entity_level']); ?>
                      (<?php echo htmlspecialchars($entity['entity_level']); ?>)</td>
                    <td><?php echo htmlspecialchars($entity['parent_entity_name'] ?? '없음'); ?></td>
                    <td><?php echo htmlspecialchars($entity['manager_memberid'] ?? '미연결'); ?>
                      (<?php echo format_user_level_display($entity['manager_level'] ?? 0); ?>)</td> <!-- 관리자 정보 표시 -->
                    <td>
                      <span class="badge text-bg-<?php echo ($entity['is_active'] == 1) ? 'success' : 'secondary'; ?>">
                        <?php echo ($entity['is_active'] == 1) ? '활성' : '비활성'; ?>
                      </span>
                    </td>
                    <td><?php echo htmlspecialchars(format_date_only($entity['created_at'])); ?></td>
                    <td class="text-nowrap">
                      <a href="<?php echo base_url('admin/shop_entities/edit/' . $entity['id']); ?>"
                        class="btn btn-sm btn-warning">수정</a>
                      <a href="<?php echo base_url('admin/shop_entities/delete/' . $entity['id']); ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('정말로 이 조직/매장을 삭제하시겠습니까? 하위 조직이나 관리자가 할당되어 있다면 삭제가 실패할 수 있습니다.');">삭제</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                  <tr>
                    <td colspan="9" class="text-center">등록된 조직/매장이 없습니다.</td>
                  </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <!-- 페이지네이션 (필요시 추가) -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>