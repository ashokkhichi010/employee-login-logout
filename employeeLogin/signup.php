<?php 
	// error_reporting(0);
	include "functions.php";
	$mysqli_conn = connectDB();
//------------------		 					signup 					--------------------------------//
	if (isset($_POST['signup'])) {
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$gmailId = $_POST['gmailId'];
		$mobileNo = $_POST['mobileNo'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		if ($password == $confirmPassword) {
			// connectDB();
			$selectCommend = "SELECT `gmail id`,`mobile no` FROM `employee`";
			$ref = mysqli_query($mysqli_conn, $selectCommend);
			$data = null;
			$flag = 0;
			$i = 1;
			while ($row = mysqli_fetch_assoc($ref)) {
				if ($gmailId != $row['gmail id']) {
					if ($mobileNo == $row['mobile no']) {
						$signupError = 'Mobile no already registered';
						$flag = 1;
						break;
					}
				}else {
					$signupError = 'Gmail id already registered';
					$flag = 1;
					break;
				}
			}
			if ($flag == 0) {
				$signupError = insertData($firstName, $lastName, $gmailId, $mobileNo, $password);
			}
		}else {
			$signupError = '! incorrect password please try again.';
		}
	}
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
<!---------			Sign Up			---->
		<form method="post">
			<div id="signup" class="signup">
				<div class="row">
					<div class="col-1"><h2>Sign Up</h2></div>
				</div>
				<div class="row error">
					<div id="signupError" class="col-1">_____________________________________________________________</div>
				</div>
				<div class="row">
					<div class="col-2"><label>First Name : </label></div>
					<div class="col-2"><input type="text" name="firstName" placeholder="First Name" required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Last Name : </label></div>
					<div class="col-2"><input type="text" name="lastName" placeholder="Last Name" required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Gmail Id : </label></div>
					<div class="col-2"><input type="text" name="gmailId" placeholder="Gmail Id" required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Mobile No. : </label></div>
					<div class="col-2"><input type="text" name="mobileNo" placeholder="Mobile No." required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Password : </label></div>
					<div class="col-2"><input type="password" name="password" placeholder="Password" required /></div>
				</div>
				<div class="row">
					<div class="col-2"><label>Confirm Password : </label></div>
					<div class="col-2"><input type="password" name="confirmPassword" placeholder="Confirm Password" required /></div>
				</div>	
				<div class="row">
					<div class="col-1"><input class="submit" type="submit" name="signup" value="Sign Up" /></div>
				</div>	
			</div>
		</form>
	</div>
</center>
<script type="text/javascript" src="js/mainJs.js"></script>
<?php 
	echo '<script type="text/javascript">';
	if ($signupError == 1) {
		echo 'document.getElementById("signupError").innerHTML ="Successfully Registered";';
		echo 'document.getElementById("signupError").style.color = "green";';
	}else{
		echo 'document.getElementById("signupError").innerHTML ="'.$signupError.'";';
		echo 'document.getElementById("signupError").style.color = "red";';
	}
	echo '</script>';
?>
</body>
</html>