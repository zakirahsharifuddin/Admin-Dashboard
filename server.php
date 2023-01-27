<?php

	session_start();

	$user_username = "";
	$user_email = "";
	$user_password = "";
	$errors = array();

	$db = mysqli_connect('localhost', 'root', '', 'penang_flick');
	
	if (isset($_POST['register'])){
		$username = mysqli_real_escape_string($db, $_POST['user_username']);
		$email = mysqli_real_escape_string($db, $_POST['user_email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['user_password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['user_password_2']);
	
			if (empty($user_username)){
				array_push($errors, "Username is required");
			}
			
			if (empty($user_email)){
				array_push($errors, "Email is required");
			}
			
			if (empty($user_password_1)){
				array_push($errors, "Password is required");
			}
			
			if ($user_password_1 != $user_password_2) {
				array_push($errors, "The passwords do not match");
			}
			
			if (count($errors) == 0) {
				$password = md5($user_password_1);
				$sql = "INSERT INTO users (user_username, user_email, password) 
						VALUES ('$user_username', '$user_email', '$user_password')";
				mysqli_query($db,$sql);
				$_SESSION['username'] = $user_username;
					$_SESSION['success'] = "You are now logged in";
					header('location: index.html'); 
			}
	}
	
	if (isset($_POST['login'])) {
		$user_username = mysqli_real_escape_string($db, $_POST['user_username']);
		$user_password = mysqli_real_escape_string($db, $_POST['user_password']);
	
			if (empty($user_username)){
				array_push($errors, "Username is required");
			}
			
			if (empty($user_password)){
				array_push($errors, "Password is required");
			}
			
			if (count($errors) == 0) {
				$password = md5($user_password);
				$query = "SELECT * FROM users WHERE user_username = '$user_username' AND user_password = '$user_password'";
				$result = mysqli_query($db, $query);
				
				if (mysqli_num_rows(mysqli_query($db, $query)) == 1){
					$_SESSION['user_username'] = $user_username;
					$_SESSION['success'] = "You are now logged in";
					header('location: index.html'); 
				}
				else {
				array_push($errors,"Wrong username/password combination");
				// header('location: login.php');
				}
			}
			
	}
	
	
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_sSESSION['user_username']);
		header('location: signin.html');
	}
	
?>