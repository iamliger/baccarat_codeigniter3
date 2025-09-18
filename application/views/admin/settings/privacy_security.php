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
							<li class="nav-item"><a class="nav-link active" href="#privacy_security" data-bs-toggle="tab">개인정보/보안</a>
							</li>
							<li class="nav-item"><a class="nav-link" href="#integrations" data-bs-toggle="tab">통합 설정</a></li>
						</ul>
					</div><!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane active" id="privacy_security">
								<h3>개인정보/보안 설정</h3>
								<?php if ($this->session->flashdata('error')): ?>
									<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
								<?php endif; ?>
								<?php if ($this->session->flashdata('success')): ?>
									<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
								<?php endif; ?>

								<?php echo form_open('admin/settings/privacy_security'); ?>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="mask_pii" name="mask_pii" value="1"
										<?php echo ($privacy_security['mask_pii'] ?? TRUE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="mask_pii">
										개인 식별 정보(PII) 마스킹 사용
									</label>
								</div>
								<div class="mb-3">
									<label for="pii_retention_days" class="form-label">개인정보 보존 기간 (일)</label>
									<input type="number" class="form-control" id="pii_retention_days" name="pii_retention_days"
										value="<?php echo htmlspecialchars($privacy_security['pii_retention_days'] ?? 3650); ?>">
								</div>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="2fa_enabled" name="2fa_enabled" value="1"
										<?php echo ($privacy_security['2fa_enabled'] ?? FALSE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="2fa_enabled">
										2단계 인증(2FA) 강제화
									</label>
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
