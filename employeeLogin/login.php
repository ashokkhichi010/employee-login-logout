<?php 
	session_start();
	date_default_timezone_set("Asia/Kolkata");
	// error_reporting(0);
	include "functions.php";
	$mysqli_conn = connectDB();
	//------------------		 					Log in 					--------------------------------//
	if(isset($_POST['login'])){
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		$selectCommend = "SELECT `eid`, `password` FROM `employee` WHERE `gmail id` ='".$userName."'";
		$ref = mysqli_query($mysqli_conn, $selectCommend);
		$row = mysqli_fetch_assoc($ref);
		if($row){
			if ($row['password'] == $password) {
				$_SESSION['eid'] = $row['eid'];
				$eid = $row['eid'];
				$date = date('Y-m-d');
				$loginTime = date('H:i:s');
				$_SESSION['loginTime'] = $loginTime;
				$insertCommend = "INSERT INTO `work`(`eid`, `date`, `login time`) VALUES('$eid', '$date', '$loginTime')";
				mysqli_query($mysqli_conn, $insertCommend);
				$selectCommend = "SELECT `totle time` FROM `work` WHERE `eid` = '$eid' AND NOT `date` = '$date'";
				$ref = mysqli_query($mysqli_conn,$selectCommend);
				$totleWorkTime = '00:00:00';
				while($row = mysqli_fetch_assoc($ref)){
					$totleWorkTime = addTime($totleWorkTime , $row['totle time']);
				}
				$updateCommend = "UPDATE `employee` SET `totle work time` = '$totleWorkTime' WHERE `eid` = '$eid'";
				mysqli_query($mysqli_conn, $updateCommend);
				header("location:dashboard.php");
			}else{
				$loginError = 'incorrect password';
			}
		}else{
			$loginError = 'invalid Username';
		}
	}
	mysqli_close($mysqli_conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employee Login</title>
	<link rel="stylesheet" type="text/css" href="css/main-page.css">
</head>
<body>
<center>
	<div class="main-page">
		<div class="row log">
			<a href="login.php" id="log-in" class="col-2 btn submit">Log In</a>
			<a href="signup.php" id="sign-up" class="col-2 btn submit">Sign Up</a>
		</div>
		<!---------			Log In			---->
		<form method="post">
			<div id="login" class="login">
				<div class="row">
					<div class="col-1"><h2>Log In</h2></div>
				</div>
				<div class="row error">
					<div id="loginError" class="col-1">_____________________________________________________________</div>
				</div>
				<div class="row">
					<div class="col-2"><label>User Name :</label></div>
					<div class="col-2"><input type="text" name="userName" placeholder="User Name / Gmail Id" required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Password :</label></div>
					<div class="col-2"><input type="password" name="password" placeholder="Password" required /></div>
				</div>
				<div class="row">
					<div class="col-1"><input class="submit" type="submit" name="login" value="Log In" /></div>
				</div>
			</div>
		</form>
	</div>
<script type="text/javascript" src="js/mainJs.js"></script>
<?php 
	echo '<script type="text/javascript">';

	echo 'document.getElementById("loginError").innerHTML ="'.$loginError.'";';
	echo 'document.getElementById("loginError").style.color = "red";';
	
	echo '</script>';
?>
</body>
</html>