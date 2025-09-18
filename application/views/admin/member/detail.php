<!-- Content Wrapper. Contains page content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" href="#basic_info" data-bs-toggle="tab">기본 정보</a></li>
							<li class="nav-item"><a class="nav-link" href="#security" data-bs-toggle="tab">보안</a></li>
							<li class="nav-item"><a class="nav-link" href="#permissions" data-bs-toggle="tab">권한/등급</a></li>
							<li class="nav-item"><a class="nav-link" href="#payments" data-bs-toggle="tab">결제/정산 내역</a></li>
							<li class="nav-item"><a class="nav-link" href="#activity_log" data-bs-toggle="tab">활동 로그</a></li>
							<li class="nav-item"><a class="nav-link" href="#internal_memo" data-bs-toggle="tab">내부 메모/태그</a></li>
						</ul>
					</div><!-- /.card-header -->
					<div class="card-body">
						<div class="tab-content">
							<!-- 기본 정보 탭 -->
							<div class="tab-pane active" id="basic_info">
								<h3><?php echo htmlspecialchars($member['memberid']); ?>님의 기본 정보</h3>
								<p><strong>회원 ID:</strong> <?php echo htmlspecialchars($member['memberid']); ?></p>
								<p><strong>가입일:</strong> <?php echo htmlspecialchars($member['dayinfo']); ?></p>
								<p><strong>바카라 데이터:</strong> <?php echo htmlspecialchars($member['bcdata']); ?></p>
								<p><strong>베이스 테이블:</strong> <?php echo htmlspecialchars($member['basetable']); ?></p>
								<p><strong>패턴 3:</strong> <?php echo htmlspecialchars($member['pattern_3']); ?></p>
								<!-- TODO: 실제 DB 스키마에 따라 필요한 정보 추가 -->
							</div>
							<!-- 보안 탭 (예시) -->
							<div class="tab-pane" id="security">
								<h3>보안 정보</h3>
								<p><strong>최근 로그인 IP:</strong> 192.168.1.1 (예시)</p>
								<p><strong>2단계 인증:</strong> 미사용 (예시)</p>
								<!-- TODO: 실제 보안 정보 데이터 표시 -->
							</div>
							<!-- 권한/등급 탭 (예시) -->
							<div class="tab-pane" id="permissions">
								<h3>권한 및 등급</h3>
								<p><strong>회원 등급:</strong> 일반 회원 (예시)</p>
								<!-- TODO: 실제 권한/등급 데이터 표시 -->
							</div>
							<!-- 결제/정산 내역 탭 (예시) -->
							<div class="tab-pane" id="payments">
								<h3>결제 및 정산 내역</h3>
								<p>결제 내역 없음 (예시)</p>
								<!-- TODO: 실제 결제/정산 데이터 표시 -->
							</div>
							<!-- 활동 로그 탭 (예시) -->
							<div class="tab-pane" id="activity_log">
								<h3>활동 로그</h3>
								<p>로그인: 2025-09-17 10:00:00 (예시)</p>
								<!-- TODO: 실제 활동 로그 데이터 표시 -->
							</div>
							<!-- 내부 메모/태그 탭 (예시) -->
							<div class="tab-pane" id="internal_memo">
								<h3>내부 메모 및 태그</h3>
								<p>특이 사항 없음 (예시)</p>
								<!-- TODO: 실제 내부 메모 데이터 표시 -->
							</div>
						</div><!-- /.tab-content -->
					</div><!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
