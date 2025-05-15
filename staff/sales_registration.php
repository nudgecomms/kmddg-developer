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
?>
	<body class="page page-id-05 staff">
		<?php include_once "../common/header.php";?>
		<div id="body" class="registration">
			<h1 class="page_title">직원관리
				<span class="sub_title">(영업 등록)</span>
			</h1>
			<section class="tabs">
				<input id="staff" type="radio" name="tab_item" checked>
				<label class="tab_item" for="staff">
					<div class="img_wrapper"><img src="/assets/images/common/main_icon_02.svg" alt="직원등록"></div>
					<div class="text_wrapper">직원등록</div>
				</label>

				<?php if($_SESSION['isMaster'] == 'Y'){ ?>
				<input id="manager" type="radio" name="tab_item">				
				<label class="tab_item" for="manager">
					<div class="img_wrapper"><img src="/assets/images/common/manager.svg" alt="관리자등록"></div>
						<div class="text_wrapper">관리자등록</div>
					</label>
				<?php } ?>
				<div class="tab_content" id="staff_content">
					<form id="staff_form" action="../ajax/ajax.userProc.php" method="post">
						<div class="step_01 form-group">
							<h3 class="form-group-title">담당 관리자</h3>
							<div class="container">
								<fieldset class="wrapper">
									<label for="staffForm-tm-select-manager-id" class="registration_label">TM 관리자</label>
									<select name="staffForm-tm-select-manager-id" class="registration_text" id="staffForm-tm-select-manager-id"></select>
								</fieldset>
								<fieldset class="wrapper">
									<label for="staffForm-sales-select-manager-id" class="registration_label">영업 관리자</label>
									<select name="staffForm-sales-select-manager-id" class="registration_text" id="staffForm-sales-select-manager-id"></select>
								</fieldset>
							</div>
						</div>
						<div class="step_02 form-group">
							<h3 class="form-group-title">직원 정보</h3>
							<div class="container">
								<fieldset class="wrapper">
									<label for="sales-staff-name" class="registration_label">이름</label>
									<div class="registration_text">
										<input type="text" id="sales-staff-name" name="sales-staff-name" placeholder="이름을 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-staff-id"class="registration_label">아이디</label>
									<div class="registration_text">
										<input type="text" id="sales-staff-id" name="sales-staff-id" placeholder="아이디를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-staff-password"class="registration_label">비밀번호</label>
									<div class="registration_text">
										<input type="password" id="sales-staff-password" name="sales-staff-password" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-staff-password"class="registration_label">비밀번호</label>
									<div class="registration_text">
										<input type="password" id="sales-staff-password-confirm" name="sales-staff-password-confirm" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-staff-ip"class="registration_label">아이피</label>
									<div class="registration_text">
										<input type="text" id="sales-staff-ip" name="sales-staff-ip" placeholder="아이피를 입력해주세요.">
									</div>
								</fieldset>
							</div>
						</div>
						<input type="submit" name="submit" value="등록" class="registration_btn">
					</form>
				</div>
				<div class="tab_content" id="manager_content">
					<form id="manager_form" action="../ajax/ajax.userProc.php" method="post">
						<div class="step_01 form-group">
							<h3 class="form-group-title">담당 관리자</h3>
							<div class="container">
								<fieldset class="wrapper">
									<label for="managerForm-sales-select-manager-id" class="registration_label">TM 관리자</label>
									<select name="managerForm-sales-select-manager-id" class="registration_text" id="managerForm-sales-select-manager-id"></select>
								</fieldset>
							</div>
						</div>
						<div class="step_02 form-group">
							<h3 class="form-group-title">관리자 정보</h3>
							<div class="container">
								<fieldset class="wrapper">
									<label for="sales-manager-name" class="registration_label">이름</label>
									<div class="registration_text">
										<input type="text" id="sales-manager-name" name="sales-manager-name" placeholder="이름을 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-manager-id"class="registration_label">아이디</label>
									<div class="registration_text">
										<input type="text" id="sales-manager-id" name="sales-manager-id" placeholder="아이디를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-manager-password"class="registration_label">비밀번호</label>
									<div class="registration_text">
										<input type="password" id="sales-manager-password" name="sales-manager-password" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-manager-password"class="registration_label">비밀번호</label>
									<div class="registration_text">
										<input type="password" id="sales-manager-password-confirm" name="sales-manager-password-confirm" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="sales-manager-ip"class="registration_label">아이피</label>
									<div class="registration_text">
										<input type="text" id="sales-manager-ip" name="sales-manager-ip" placeholder="아이피를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper textarea">
									<label for="sales-manager-textarea" class="registration_label">메모</label>
									<div class="registration_text">
										<textarea id="sales-manager-memo" name="sales-manager-memo" placeholder="메모를 입력해주세요."></textarea>
									</div>
								</fieldset>
							</div>
						</div>
						<input type="submit" name="submit" value="등록" class="registration_btn">
					</form>
				</div>
		</section>
		<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
		<script>
		document.addEventListener('DOMContentLoaded', function() {
		
		// 관리자 목록 로드 이벤트
		//document.getElementById('sales-select-manager-id').addEventListener('click', function() {
		//	loadAdminList('sales-select-manager-id');
		//});

		// 페이지 로드 시 관리자 목록 로드
		loadAdminList('managerForm-sales-select-manager-id');
		loadAdminList('staffForm-tm-select-manager-id');
		loadAdminList('staffForm-sales-select-manager-id', 'BS');

		// 관리자 폼 제출
		document.getElementById('manager_form').addEventListener('submit', function(event) {
			event.preventDefault();
			
			//sales-manager-id 아이디는 영문 숫자만 입력 할수있고, 특수문자는 유일하게 _만 입력가능
			const salesId = document.getElementById('sales-manager-id').value;
			if (!/^[a-zA-Z0-9_]+$/.test(salesId)) {
				alert('아이디는 영문 숫자만 입력 할수있고, 특수문자는 언더바(_) 만 입력가능합니다.');
				document.getElementById('sales-manager-id').focus();
				return;
			}

			// 유효성 검사
			const validations = [
				{ id: 'sales-manager-name', message: '이름을 입력해주세요.' },
				{ id: 'sales-manager-id', message: '아이디를 입력해주세요.' },
				{ id: 'sales-manager-password', message: '비밀번호를 입력해주세요.' },
				{ id: 'sales-manager-password-confirm', message: '비밀번호를 입력해주세요.' },
				{ id: 'sales-manager-memo', message: '메모를 입력해주세요.' }
			];

			for (const validation of validations) {
				const element = document.getElementById(validation.id);
				if (!element.value) {
					alert(validation.message);
					element.focus();
					return;
				}
			}

			// 비밀번호 일치 확인
			const password = document.getElementById('sales-manager-password').value;
			const passwordConfirm = document.getElementById('sales-manager-password-confirm').value;
			if (password !== passwordConfirm) {
				alert('비밀번호가 일치하지 않습니다.');
				document.getElementById('sales-manager-password').focus();
				return;
			}

			// IP 주소 검증
			//const ipAddress = document.getElementById('sales-manager-ip').value;
			//if (ipAddress && !/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddress)) {
			//	alert('아이피 형식이 올바르지 않습니다.');
			//	document.getElementById('sales-manager-ip').focus();
			//	return;
			//}

			// 폼 데이터 전송
			const formData = new FormData(this);
			formData.append('action', 'salesManagerRegister');

			fetch(this.action, {
				method: this.method,
				body: new URLSearchParams(formData)
			})
			.then(response => response.json())
			.then(data => {
				if (data.status === 'success') {
					alert(data.message);
					this.reset();
				} else {
					alert(data.message);
				}
			})
			.catch(error => {
				alert('등록에 실패했습니다. 다시 시도해주세요.');
			});
		});

		// 직원 폼 제출
		document.getElementById('staff_form').addEventListener('submit', function(event) {
			event.preventDefault();

			//sales-staff-id 아이디는 영문 숫자만 입력 할수있고, 특수문자는 유일하게 _만 입력가능
			const tmId = document.getElementById('sales-staff-id').value;
			if (!/^[a-zA-Z0-9_]+$/.test(tmId)) {
				alert('아이디는 영문 숫자만 입력 할수있고, 특수문자는 언더바(_) 만 입력가능합니다.');
				document.getElementById('sales-staff-id').focus();
				return;
			}

			// 유효성 검사
			const validations = [
				{ id: 'staffForm-tm-select-manager-id', message: 'TM 관리자를 선택해주세요.' },
				{ id: 'staffForm-sales-select-manager-id', message: '영업 관리자를 선택해주세요.' },
				{ id: 'sales-staff-name', message: '이름을 입력해주세요.' },
				{ id: 'sales-staff-id', message: '아이디를 입력해주세요.' },
				{ id: 'sales-staff-password', message: '비밀번호를 입력해주세요.' },
				{ id: 'sales-staff-password-confirm', message: '비밀번호를 입력해주세요.' }
			];

			for (const validation of validations) {
				const element = document.getElementById(validation.id);
				if (!element.value) {
					alert(validation.message);
					element.focus();
					return;
				}
			}

			// 비밀번호 일치 확인
			const password = document.getElementById('sales-staff-password').value;
			const passwordConfirm = document.getElementById('sales-staff-password-confirm').value;
			if (password !== passwordConfirm) {
				alert('비밀번호가 일치하지 않습니다.');
				document.getElementById('sales-staff-password').focus();
				return;
			}

			// IP 주소 검증
			//const ipAddress = document.getElementById('sales-staff-ip').value;
			//if (ipAddress && !/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddress)) {
			//	alert('아이피 형식이 올바르지 않습니다.');
			//	document.getElementById('sales-staff-ip').focus();
			//	return;
			//}

			// 폼 데이터 전송
			const formData = new FormData(this);
			formData.append('action', 'salesStaffRegister');

			fetch(this.action, {
				method: this.method,
				body: new URLSearchParams(formData)
			})
			.then(response => response.json())
			.then(data => {

				console.log(data);

				if (data.status === 'success') {
					alert(data.message);
					this.reset();
				} else {
					alert(data.message);
				}
			})
			.catch(error => {

				console.log(error);

				alert('등록에 실패했습니다. 다시 시도해주세요.');
			});
		});
		});
		</script>
	</body>
</html>