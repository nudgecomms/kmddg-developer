<?php
	include_once __DIR__ . "/../include/session.php";
	include_once __DIR__ . "/../include/header.php";
	include_once __DIR__ . "/../include/db.php";

	$sIsAdmin = isset($_GET['sIsAdmin']) ? $_GET['sIsAdmin'] : '';
	$sIsUseYn = isset($_GET['sIsUseYn']) ? $_GET['sIsUseYn'] : '';
	$search = isset($_GET['search']) ? $_GET['search'] : '';
	
	$loginUserId = $_SESSION['userId'];
	$loginUserIsAdmin = $_SESSION['isAdmin'];
	$loginUserIsMaster = $_SESSION['isMaster'];

	// isAdmin, isMaster 둘다 N 이면 페이지 접속 차단
	if($loginUserIsAdmin == 'N' && $loginUserIsMaster == 'N'){
		echo "<script>alert('관리자 권한이 없습니다.'); history.back();</script>";		
		exit;
	}

	$whereClause = "WHERE team = 'TM' and isDeleted = 'N' ";

	if($loginUserIsMaster == 'Y'){
		$whereClause .= " and isMaster = 'N'";
	}else{
		if($loginUserIsAdmin == 'Y'){
			$whereClause .= " and tmChargeId = '$loginUserId'";
		}else{
			$whereClause .= " and userId = '$loginUserId'";
		}
	}

	if($sIsAdmin != ''){
		$whereClause .= " and isAdmin = '$sIsAdmin'";
	}
	if($sIsUseYn != ''){
		$whereClause .= " and useYn = '$sIsUseYn'";
	}
	if($search != ''){
		$whereClause .= " and (userName like '%$search%' or userId like '%$search%')";
	}

	$totalQuery = "SELECT COUNT(*) as total FROM users $whereClause";
	$totalResult = $pdo->query($totalQuery);
	$totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
	$total = $totalRow['total'];

	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$limit = 10;
	$offset = ($page - 1) * $limit;

	$orderBy = "ORDER BY createdAt DESC";

	$query = "SELECT * FROM users $whereClause $orderBy limit $offset, $limit";
	$result = $pdo->query($query);

	$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	$totalPages = ceil($total / $limit);
?>
	<body class="page page-id-02 staff">
		<?php include_once "../common/header.php";?>
		<?php include_once "../common/del_popup.php";?>
		<div id="body">
			<h1 class="page_title">직원관리
				<span class="sub_title">(TM 리스트)</span>
			</h1>
			<section class="filter_container">
				<div class="button_container">
					<!-- 직원필터 -->
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
						<!-- 직원필터 -->
						<label for="sIsAdmin">전체 직원</label>
						<select name="sIsAdmin" id="sIsAdmin">
							<option value="">전체 직원</option>
							<option value="Y" <?php echo $sIsAdmin == 'Y' ? 'selected' : ''; ?>>관리자</option>
							<option value="N" <?php echo $sIsAdmin == 'N' ? 'selected' : ''; ?>>직원</option>
						</select>
						<!-- 직원필터 end -->
						<!-- 활성화여부 -->
						<label for="sIsUseYn">활성화 여부</label>
						<select name="sIsUseYn" id="sIsUseYn">
							<option value="">활성화 여부</option>
							<option value="Y" <?php echo $sIsUseYn == 'Y' ? 'selected' : ''; ?>>활성화</option>
							<option value="N" <?php echo $sIsUseYn == 'N' ? 'selected' : ''; ?>>비활성화</option>
						</select>
						<!-- 활성화여부 end -->
						<input type="submit" value="적용" />
					</form>
					<!-- 검색 -->
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
						<input type="search" name="search" placeholder="검색어를 입력하세요." value="<?php echo $search; ?>">
						<input type="submit" value="검색" />
					</form>
					<!-- 검색 end -->
				</div>
				<h5 class="total">총 <span class="num"><?php echo $total; ?></span>명</h5>
			</section><!--page_title end-->
			<section class="table_container">
				<table class="tm_staff_table">
					<thead>
						<tr>
							<th class="table-list-checkbox"><input type="checkbox" id="all_checkbox" name="all_checkbox"></th>
							<th class="table-list-date">등록일</th>							
							<th class="table-list-name">이름(ID)</th>
							<th class="table-list-position">직급</th>
							<th class="table-list-tm_manager">TM 관리자</th>
							<!-- <th class="table-list-tm_staff">직원</th> -->
							<th class="table-list-enable">활성화 여부</th>
							<th class="table-list-management">관리</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($rows as $row){ ?>
						<tr>
							<td class="table-list-checkbox"><input type="checkbox" id="checkbox_<?php echo $row['uid']; ?>" name="checkbox" value="<?php echo $row['uid']; ?>"></td>
							<td class="table-list-date"><?php echo $row['createdAt']; ?></td>							
							<td class="table-list-name"><?php echo $row['userName']; ?> (<?php echo $row['userId']; ?>)</td>
							<td class="table-list-position"><?php echo $row['isAdmin'] == 'Y' ? '관리자' : '직원'; ?></td>
							<td class="table-list-tm_manager"><?php echo $row['tmChargeId'] ?? '-'; ?></td>
							<!-- <td class="table-list-tm_staff"><?php echo $row['userId'] ?? '-'; ?></td> -->
							<td class="table-list-enable">
								<input role="switch" type="checkbox" class="useYn-switch" data-uid="<?php echo $row['uid']; ?>" data-userid="<?php echo $row['userId']; ?>" <?php echo $row['useYn'] == 'Y' ? 'checked' : ''; ?>/>
							</td>
							<td class="table-list-management">
								<a href="#" 
									class="img_wrapper edit-link"
									data-uid="<?php echo $row['uid']; ?>" 
									data-username="<?php echo $row['userName']; ?>" 
									data-userid="<?php echo $row['userId']; ?>"
									data-isadmin="<?php echo $row['isAdmin']; ?>"
									data-tmchargeid="<?php echo $row['tmChargeId']; ?>"
									data-team="tm"
								>
									<img src="/assets/images/common/edit.svg" alt="수정">
								</a>
								<a href="#" data-uid="<?php echo $row['uid']; ?>" data-username="<?php echo $row['userName']; ?>" data-userid="<?php echo $row['userId']; ?>" class="img_wrapper delete-link">
									<img src="/assets/images/common/del.svg" alt="삭제">
								</a>
							</td>
						</tr>
						<?php } ?>						
					</tbody>
				</table>
			</section><!--table_container end-->
			<section class="table_bottom">
				<a href="#" class="btn del" id="del_btn">
					<div class="img_wrapper">
						<img src="/assets/images/common/del.svg" alt="del icon">
					</div>
					<div class="text_wrapper">삭제</div>
				</a>
				<?php if($totalPages > 1){ ?>
					<div class="table-pagination">
						<ul class="table-pagination-pages">
							<li><a href="?page=1" alt="first_page"><</a></li>
							<?php for($i = 1; $i <= $totalPages; $i++){ ?>
								<li class="<?php echo $i == $page ? 'active' : ''; ?>">
									<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
								</li>
							<?php } ?>
							<li><a href="?page=<?php echo $totalPages; ?>" alt="last_page">></a></li>
						</ul>
					</div>
				<?php } ?>
				<span class="empty"></span>
			</section><!--bottom end-->
		</div><!--#body end-->

		<!-- popup popup_edit popup_staff popup_staff_tm_manager on -->
		<?php include_once "../common/popup_staff_tm_manager.php"; ?>
	</body>
</html>

<script>	
	document.addEventListener('DOMContentLoaded', function() {
        setupCheckboxHandlers('#all_checkbox', 'input[name="checkbox"]');
		setupDeleteHandlers('.delete-link', '../ajax/ajax.listProc.php', 'listRemove');	
		setupCheckboxDeleteHandlers('#del_btn', '../ajax/ajax.listProc.php', 'listRemove');
		setupUseYnSwitchHandlers('.useYn-switch', '../ajax/ajax.listProc.php', 'updateUseYn');		
		setupEditModal();
	});
</script>