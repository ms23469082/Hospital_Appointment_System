<?php
session_start();
include "dbcon.php";

if (isset($_POST['name']) && isset($_POST['password'])) {

	function validate($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$uname = validate($_POST['name']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: ../../index.php?error=" . urlencode("Enter the Username!"));
		exit();
	} else if (empty($pass)) {
		header("Location: ../../index.php?error=" . urlencode("Enter the Password!"));
		exit();
	} else {
		// Prepared statement for SQL query
		$sql = "SELECT * FROM users WHERE name=? AND password=?";
		$stmt = mysqli_prepare($dbcon, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if ($row = mysqli_fetch_assoc($result)) {
			// Valid credentials, set session variables
			$_SESSION['user_name'] = $row['user_name'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['id'] = $row['id'];
			header("Location: home.php");
			exit();
		} else {
			// Invalid credentials
			header("Location: ../../index.php?error=" . urlencode("Username or Password is Wrong!"));
			exit();
		}
	}

} else {
	header("Location: ../../index.php");
	exit();
}
?>