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
	<body class="page page-id-03 staff">
		<?php include_once "../common/header.php";?>
		<div id="body" class="registration">
			<h1 class="page_title">직원관리
				<span class="sub_title">(TM 등록)</span>
			</h1>
			<section class="tabs">
				<input id="staff" type="radio" name="tab_item" checked>
				<label class="tab_item" for="staff">
					<div class="img_wrapper"><img src="/assets/images/common/main_icon_02.svg" alt="직원등록"></div>
					<div class="text_wrapper">직원등록</div>
				</label>
				<input id="manager" type="radio" name="tab_item">

				<?php if($_SESSION['isMaster'] == 'Y'){ ?>
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
									<label for="tm-select-manager-id" class="registration_label">TM 관리자</label>
									<select name="tm-select-manager-id" class="registration_text" id="tm-select-manager-id">
									</select>
								</fieldset>
							</div>
						</div>
						<div class="step_02 form-group">
							<h3 class="form-group-title">직원 정보</h3>
							<div class="container">
								<fieldset class="wrapper">
									<label for="tm-staff-name" class="registration_label">이름</label>
									<div class="registration_text">
										<input type="text" id="tm-staff-name" name="tm-staff-name" placeholder="이름을 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="tm-staff-id" class="registration_label">아이디</label>
									<div class="registration_text">
										<input type="text" id="tm-staff-id" name="tm-staff-id" placeholder="아이디를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="tm-staff-password" class="registration_label">비밀번호</label>
									<div class="registration_text">
										<input type="password" id="tm-staff-password" name="tm-staff-password" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="tm-staff-password-confirm" class="registration_label">비밀번호 확인</label>
									<div class="registration_text">
										<input type="password" id="tm-staff-password-confirm" name="tm-staff-password-confirm" placeholder="비밀번호를 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="tm-staff-calculate" class="registration_label">고객당 정산금액</label>
									<div class="registration_text">
										<input type="text" id="tm-staff-calculate" name="tm-staff-calculate" placeholder="정산금액을 입력해주세요.">
									</div>
								</fieldset>
								<fieldset class="wrapper">
									<label for="tm-staff-ip" class="registration_label">아이피</label>
									<div class="registration_text">
										<input type="text" id="tm-staff-ip" name="tm-staff-ip" placeholder="아이피를 입력해주세요.">
									</div>
								</fieldset>
							</div>
						</div>
						<input type="submit" name="submit" value="등록" class="registration_btn">
					</form>
				</div>
				<?php if($_SESSION['isMaster'] == 'Y'){ ?>
					<div class="tab_content" id="manager_content">
						<form id="manager_form" action="../ajax/ajax.userProc.php" method="post">
							<div class="step_01 form-group">
								<h3 class="form-group-title">관리자 정보</h3>
								<div class="container">
									<fieldset class="wrapper">
										<label for="tm-manager-name" class="registration_label">이름</label>
										<div class="registration_text">
											<input type="text" id="tm-manager-name" name="manager_name" placeholder="이름을 입력해주세요.">
										</div>
									</fieldset>
									<fieldset class="wrapper">
										<label for="tm-manager-id" class="registration_label">아이디</label>
										<div class="registration_text">
											<input type="text" id="tm-manager-id" name="manager_id" placeholder="아이디를 입력해주세요.">
										</div>
									</fieldset>
									<fieldset class="wrapper">
										<label for="tm-manager-password" class="registration_label">비밀번호</label>
										<div class="registration_text">
											<input type="password" id="tm-manager-password" name="manager_password" placeholder="비밀번호를 입력해주세요.">
										</div>
									</fieldset>
									<fieldset class="wrapper">
										<label for="tm-manager-password" class="registration_label">비밀번호 확인</label>
										<div class="registration_text">
											<input type="password" id="tm-manager-password-confirm" name="manager_password_confirm" placeholder="비밀번호를 입력해주세요.">
										</div>
									</fieldset>
									<fieldset class="wrapper">
										<label for="tm-manager-ip" class="registration_label">아이피</label>
										<div class="registration_text">
											<input type="text" id="tm-manager-ip" name="manager_ip" placeholder="아이피를 입력해주세요.">
										</div>
									</fieldset>
									<fieldset class="wrapper textarea">
										<label for="tm-manager-memo" class="registration_label">메모</label>
										<div class="registration_text">
											<textarea id="tm-manager-memo" name="manager_memo" placeholder="메모를 입력해주세요."></textarea>
										</div>
									</fieldset>
								</div>
							</div>
							<input type="submit" name="submit" value="등록" class="registration_btn">
						</form>
					</div>
				<?php } ?>
			</section>
		</div>
	</body>
</html>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
document.addEventListener('DOMContentLoaded', function() {

	document.querySelector('#tm-staff-calculate').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // 붙여넣기 시에도 숫자만 허용
    document.querySelector('#tm-staff-calculate').addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        this.value = pastedData.replace(/[^0-9]/g, '');
    });

	addCommasToInput('#tm-staff-calculate');

	// 관리자 목록 로드 이벤트
	document.getElementById('tm-select-manager-id').addEventListener('click', function() {
		loadAdminList('tm-select-manager-id');
	});

	// 페이지 로드 시 관리자 목록 로드
	loadAdminList('tm-select-manager-id');

	// 관리자 폼 제출
	document.getElementById('manager_form').addEventListener('submit', function(event) {
		event.preventDefault();
		console.log('여기 오는지 ㅔㅌ스트')
		
		//tm-manager-id 아이디는 영문 숫자만 입력 할수있고, 특수문자는 유일하게 _만 입력가능
		const tmId = document.getElementById('tm-manager-id').value;
		if (!/^[a-zA-Z0-9_]+$/.test(tmId)) {
			alert('아이디는 영문 숫자만 입력 할수있고, 특수문자는 언더바(_) 만 입력가능합니다.');
			document.getElementById('tm-manager-id').focus();
			return;
		}

		// 유효성 검사
		const validations = [
			{ id: 'tm-manager-name', message: '이름을 입력해주세요.' },
			{ id: 'tm-manager-id', message: '아이디를 입력해주세요.' },
			{ id: 'tm-manager-password', message: '비밀번호를 입력해주세요.' },
			{ id: 'tm-manager-password-confirm', message: '비밀번호를 입력해주세요.' },
			{ id: 'tm-manager-memo', message: '메모를 입력해주세요.' }
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
		const password = document.getElementById('tm-manager-password').value;
		const passwordConfirm = document.getElementById('tm-manager-password-confirm').value;
		if (password !== passwordConfirm) {
			alert('비밀번호가 일치하지 않습니다.');
			document.getElementById('tm-manager-password').focus();
			return;
		}

		// IP 주소 검증
		//const ipAddress = document.getElementById('tm-manager-ip').value;
		//if (ipAddress && !/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddress)) {
		//	alert('아이피 형식이 올바르지 않습니다.');
		//	document.getElementById('tm-manager-ip').focus();
		//	return;
		//}

		// 폼 데이터 전송
		const formData = new FormData(this);
		formData.append('action', 'tmAdminRegister');

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

		//tm-staff-id 아이디는 영문 숫자만 입력 할수있고, 특수문자는 유일하게 _만 입력가능
		const tmId = document.getElementById('tm-staff-id').value;
		if (!/^[a-zA-Z0-9_]+$/.test(tmId)) {
			alert('아이디는 영문 숫자만 입력 할수있고, 특수문자는 언더바(_) 만 입력가능합니다.');
			document.getElementById('tm-staff-id').focus();
			return;
		}

		// 유효성 검사
		const validations = [
			{ id: 'tm-select-manager-id', message: '관리자를 선택해주세요.' },
			{ id: 'tm-staff-name', message: '이름을 입력해주세요.' },
			{ id: 'tm-staff-id', message: '아이디를 입력해주세요.' },
			{ id: 'tm-staff-password', message: '비밀번호를 입력해주세요.' },
			{ id: 'tm-staff-password-confirm', message: '비밀번호를 입력해주세요.' }
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
		const password = document.getElementById('tm-staff-password').value;
		const passwordConfirm = document.getElementById('tm-staff-password-confirm').value;
		if (password !== passwordConfirm) {
			alert('비밀번호가 일치하지 않습니다.');
			document.getElementById('tm-staff-password').focus();
			return;
		}

		// 정산금액 숫자 검증
		const calculateAmount = document.getElementById('tm-staff-calculate').value;
		if (!/^\d{1,3}(,\d{3})*$/.test(calculateAmount)) {
			alert('고객당 정산금액은 숫자만 입력해주세요.');
			document.getElementById('tm-staff-calculate').focus();
			return;
		}

		// IP 주소 검증
		//const ipAddress = document.getElementById('tm-staff-ip').value;
		//if (ipAddress && !/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddress)) {
		//	alert('아이피 형식이 올바르지 않습니다.');
		//	document.getElementById('tm-staff-ip').focus();
		//	return;
		//}

		// 폼 데이터 전송
		const formData = new FormData(this);
		formData.append('action', 'tmStaffRegister');

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