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
						<p>매장관리자님, 환영합니다! 레벨 <?php echo get_user_level(); ?>.</p>
						<p>여기에 매장 관리와 관련된 콘텐츠를 배치합니다.</p>
						<div class="alert alert-info" role="alert">
							매장 관리자 전용 기능 (예: 테이블 관리, 정산 내역 확인 등)이 이곳에 표시됩니다.
						</div>
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
