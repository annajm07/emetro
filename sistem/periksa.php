<?php
if (!defined('_VALID_ACCESS')) {
	header("location: index.php");
	die;
}

session_start();

if (isset($_POST['btn-login'])) {
	$user_email = trim($_POST['user_email']);
	$user_password = trim($_POST['password']);
	$key = "syalim.com";
	$password = md5($user_password . $key . md5($user_password));
	try {
		// cek captcha
		if ($_POST['captcha'] !== $_POST['hasil']) {
			echo "false";
			die();
			// end cek
		}
		$stmt = $db_con->prepare("SELECT * FROM usertb WHERE imel=:email");
		$stmt->execute(array(":email" => $user_email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$count = $stmt->rowCount();

		if ($row['pword'] == $password && $row['status'] == 1) {

			echo "ok"; // log in
			$_SESSION['user_session'] = $row['id_us'];
			$_SESSION['type_session'] = $row['type'];
		} else {

			echo "Email atau Password tidak terdaftar"; // wrong details
		}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}
