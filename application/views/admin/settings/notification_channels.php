<!-- Content Wrapper. Contains page content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link" href="#general_policy" data-bs-toggle="tab">기본 정책</a></li>
							<li class="nav-item"><a class="nav-link active" href="#notification_channels" data-bs-toggle="tab">알림
									채널</a></li>
							<li class="nav-item"><a class="nav-link" href="#privacy_security" data-bs-toggle="tab">개인정보/보안</a></li>
							<li class="nav-item"><a class="nav-link" href="#integrations" data-bs-toggle="tab">통합 설정</a></li>
						</ul>
					</div><!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane active" id="notification_channels">
								<h3>알림 채널 설정</h3>
								<?php if ($this->session->flashdata('error')): ?>
									<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
								<?php endif; ?>
								<?php if ($this->session->flashdata('success')): ?>
									<div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
								<?php endif; ?>

								<?php echo form_open('admin/settings/notification_channels'); ?>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="email_enabled" name="email_enabled" value="1"
										<?php echo ($notification_channels['email_enabled'] ?? TRUE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="email_enabled">
										이메일 알림 사용
									</label>
								</div>
								<div class="mb-3">
									<label for="email_sender" class="form-label">이메일 발신자 주소</label>
									<input type="email" class="form-control" id="email_sender" name="email_sender"
										value="<?php echo htmlspecialchars($notification_channels['email_sender'] ?? 'no-reply@yourdomain.com'); ?>">
								</div>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="sms_enabled" name="sms_enabled" value="1"
										<?php echo ($notification_channels['sms_enabled'] ?? FALSE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="sms_enabled">
										SMS 알림 사용
									</label>
								</div>
								<div class="form-check mb-3">
									<input class="form-check-input" type="checkbox" id="push_enabled" name="push_enabled" value="1"
										<?php echo ($notification_channels['push_enabled'] ?? FALSE) ? 'checked' : ''; ?>>
									<label class="form-check-label" for="push_enabled">
										푸시 알림 사용
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
