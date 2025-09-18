<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user_level = get_user_level(); // 현재 로그인한 사용자의 레벨 가져오기
?>
<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
	<!--begin::Sidebar Brand-->
	<div class="sidebar-brand">
		<!--begin::Brand Link-->
		<a href="<?php echo base_url('shop'); ?>" class="brand-link">
			<span class="brand-text fw-light">매장 관리 시스템</span>
		</a>
	</div>
	<!--end::Sidebar Brand-->
	<!--begin::Sidebar Wrapper-->
	<div class="sidebar-wrapper">
		<nav class="mt-2">
			<!--begin::Sidebar Menu-->
			<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
				data-accordion="false" id="navigation">

				<!-- 매장 관리자 대시보드 홈 -->
				<li class="nav-item">
					<a href="<?php echo base_url('shop'); ?>" class="nav-link active">
						<i class="nav-icon bi bi-speedometer"></i>
						<p>
							대시보드
						</p>
					</a>
				</li>

				<?php if ($user_level == 9): // 레벨 9 (그룹회사)만 보임 
				?>
					<!-- 레벨 9: 그룹회사 - 본사 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-buildings"></i>
							<p>
								본사 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/head_office/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>본사 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/head_office/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>본사 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 8): // 레벨 8 (본사)만 보임 
				?>
					<!-- 레벨 8: 본사 - 부본사 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-building"></i>
							<p>
								부본사 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/sub_head_office/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>부본사 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/sub_head_office/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>부본사 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 7): // 레벨 7 (부본사)만 보임 
				?>
					<!-- 레벨 7: 부본사 - 지사 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-building-fill-gear"></i>
							<p>
								지사 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/branch_office/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>지사 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/branch_office/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>지사 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 6): // 레벨 6 (지사)만 보임 
				?>
					<!-- 레벨 6: 지사 - 총판 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-shop-window"></i>
							<p>
								총판 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/agency/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>총판 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/agency/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>총판 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 5): // 레벨 5 (총판)만 보임 
				?>
					<!-- 레벨 5: 총판 - 영업장 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-shop"></i>
							<p>
								영업장 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/sales_place/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>영업장 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/sales_place/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>영업장 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 4): // 레벨 4 (영업장)만 보임 
				?>
					<!-- 레벨 4: 영업장 - 매장 관리 -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-store"></i>
							<p>
								매장 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/store/create'); ?>" class="nav-link"><i
										class="nav-icon bi bi-plus-circle"></i>
									<p>매장 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/store/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-list-columns-reverse"></i>
									<p>매장 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($user_level == 3): // 레벨 3 (매장)만 보임 
				?>
					<!-- 레벨 3: 매장 - 회원 관리 (최하위 매장 일반 회원) -->
					<li class="nav-item">
						<a href="#" class="nav-link">
							<i class="nav-icon bi bi-people"></i>
							<p>
								회원 관리
								<i class="nav-arrow bi bi-chevron-right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url('shop/member/register'); ?>" class="nav-link"><i
										class="nav-icon bi bi-person-plus"></i>
									<p>회원 등록</p>
								</a></li>
							<li class="nav-item"><a href="<?php echo base_url('shop/member/list'); ?>" class="nav-link"><i
										class="nav-icon bi bi-person-badge"></i>
									<p>회원 목록</p>
								</a></li>
						</ul>
					</li>
				<?php endif; ?>

				<li class="nav-item">
					<a href="<?php echo base_url('logout'); ?>" class="nav-link">
						<i class="nav-icon bi bi-box-arrow-right"></i>
						<p>로그아웃</p>
					</a>
				</li>
			</ul>
			<!--end::Sidebar Menu-->
		</nav>
	</div>
	<!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
<!--begin::App Main-->
<main class="app-main">
	<!--begin::App Content Header-->
	<div class="app-content-header">
		<!--begin::Container-->
		<div class="container-fluid">
			<!--begin::Row-->
			<div class="row">
				<div class="col-sm-6">
					<h3 class="mb-0"><?php echo $page_title; ?></h3>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-end">
						<li class="breadcrumb-item"><a href="<?php echo base_url('shop'); ?>">홈</a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
					</ol>
				</div>
			</div>
			<!--end::Row-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::App Content Header-->
	<!--begin::App Content-->
	<div class="app-content">
		<!--begin::Container-->
		<div class="container-fluid">
			<!-- 여기에 매장 관리자 페이지 본문 내용이 로드됩니다 (shop/dashboard.php 또는 다른 뷰 파일) -->
