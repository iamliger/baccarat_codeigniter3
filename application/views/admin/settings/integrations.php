<!-- Content Wrapper. Contains page content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link" href="#general_policy" data-bs-toggle="tab">기본 정책</a></li>
							<li class="nav-item"><a class="nav-link" href="#notification_channels" data-bs-toggle="tab">알림 채널</a></li>
							<li class="nav-item"><a class="nav-link" href="#privacy_security" data-bs-toggle="tab">개인정보/보안</a></li>
							<li class="nav-item"><a class="nav-link active" href="#integrations" data-bs-toggle="tab">통합 설정</a></li>
						</ul>
					</div><!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane active" id="integrations">
								<h3>통합 설정</h3>
								<?php if ($this->session->flashdata('error')): ?>
									<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
								<?php endif; ?>
								<?php if ($this->session->flashdata('success')): ?>
									<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
								<?php endif; ?>

								<?php echo form_open('admin/settings/integrations'); ?>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="third_party_api_enabled"
										name="third_party_api_enabled" value="1"
										<?php echo ($integrations['third_party_api_enabled'] ?? FALSE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="third_party_api_enabled">
										외부 API 연동 사용
									</label>
								</div>
								<div class="mb-3">
									<label for="api_key" class="form-label">주요 API 키</label>
									<input type="text" class="form-control" id="api_key" name="api_key"
										value="<?php echo htmlspecialchars($integrations['api_key'] ?? ''); ?>">
								</div>
								<div class="mb-3">
									<label for="api_key_status" class="form-label">API 키 상태</label>
									<select class="form-select" id="api_key_status" name="api_key_status">
										<option value="active"
											<?php echo (($integrations['api_key_status'] ?? 'active') == 'active') ? 'selected' : ''; ?>>활성
										</option>
										<option value="inactive"
											<?php echo (($integrations['api_key_status'] ?? 'active') == 'inactive') ? 'selected' : ''; ?>>비활성
										</option>
										<option value="revoked"
											<?php echo (($integrations['api_key_status'] ?? 'active') == 'revoked') ? 'selected' : ''; ?>>폐기
										</option>
									</select>
								</div>
								<button type="submit" class="btn btn-primary">저장</button>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
