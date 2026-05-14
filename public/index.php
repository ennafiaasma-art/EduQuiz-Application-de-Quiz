<?php
session_start();

if (isset($_SESSION['user'])) {
	if (($_SESSION['user']['role_name'] ?? '') === 'teacher') {
		header('Location: ../src/Views/teacher/dashboard.php');
	} else {
		header('Location: ../src/Views/student/dashboard.php');
	}
	exit;
}

header('Location: ../src/Views/auth/login.php');
exit;