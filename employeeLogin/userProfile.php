<?php
	session_start();
	if(!isset($_SESSION['eid'])){
		header('location:/employeeLogin');
	}
	include 'functions.php';
	$mysqli_conn = connectDB();
	$eid = $_SESSION['eid'];
	if (isset($_POST['update-user-profile'])) {
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$gender = $_POST['gender'];
		$department = $_POST['department'];
		$updateCommend = "UPDATE `employee` SET `first name` = '$firstName',`last name` = '$lastName',`department` = '$department',`gender`= '$gender' WHERE `eid` = '$eid'";
		mysqli_query($mysqli_conn, $updateCommend);
	}
	if (isset($_POST['change-password'])) {
		if ($userData['password'] == $_POST['oldPassword']) {
			if ($_POST['newPassword'] == $_POST['confirmPassword']) {
				$newPassword = $_POST['newPassword'];
				$updateCommend = "UPDATE `employee` SET `password` = '$newPassword' WHERE `eid` = '$eid'";
				mysqli_query($mysqli_conn, $updateCommend);
			}else{
				$passwordError = 'Invalid Passwords'; 
			}
		}else{
			$passwordError = 'Incorrect password please check again';
		}
	}
	$selectCommend = "SELECT * FROM `employee` WHERE `eid` ='".$eid."'";
	$ref = mysqli_query($mysqli_conn, $selectCommend);
	$userData = mysqli_fetch_array($ref);
	$fullName = $userData['first name'] ." ". $userData['last name'];
	$fullName = strtoupper($fullName);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Profile</title>
	<link rel="stylesheet" type="text/css" href="css/main-page.css">
</head>
<body>
<center>
	<div class="main-page">
		<div class="row">
			<div id="0" class="col-3"><a href="#" name="user-profile" onclick="profile(name)">User Profile</a></div>
			<div id="1" class="col-3"><a href="#" name="update-user-profile" onclick="profile(name)">Update User Profile</a></div>
			<div id="2" class="col-3"><a href="#" name="change-password" onclick="profile(name)">Change Password</a></div>
		</div>
	</div>
	<div id="user-profile" class="main-page">
		<div class="row">
			<div class="col-1"><h2>User Profile</h2></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Name : </label></div>
			<div class="col-2"><?php echo $fullName;?></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Gmail Id : </label></div>
			<div class="col-2"><?php echo $userData['gmail id'];?></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Mobile No. : </label></div>
			<div class="col-2"><?php echo $userData['mobile no'];?></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Department: </label></div>
			<div class="col-2"><?php echo $userData['department'];?></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Gender : </label></div>
			<div class="col-2"><?php echo $userData['gender'];?></div>
		</div>
	</div>
<form method="post">
	<div id="update-user-profile" class="main-page">
		<div class="row">
			<div class="col-1"><h2>Update User Profile</h2></div>
		</div>
		<div class="row">
			<div class="col-2"><label>First Name : </label></div>
			<div class="col-2"><input type="text" name="firstName" value="<?php echo $userData['first name'];?>"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Last Name : </label></div>
			<div class="col-2"><input type="text" name="lastName" value="<?php echo $userData['last name'];?>"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Department : </label></div>
			<div class="col-2"><input type="text" name="department" value="<?php echo $userData['department'];?>"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Gender : </label></div>
			<div class="col-2"><input type="text" name="gender" value="<?php echo $userData['gender'];?>"></div>
		</div>
		<div class="row">
			<div class="col-1"><input class="submit" type="submit" name="update-user-profile" value="Update"></div>
		</div>
	</div>
</form>
<form method="post">
	<div id="change-password" class="main-page">
		<div class="row">
			<div class="col-1"><h2>Change Password </h2></div>
		</div>
		<div class="row error">
			<div id="passwordError" class="col-1"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Old Password :</label></div>
			<div class="col-2"><input type="text" name="oldPassword"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>New Password :</label></div>
			<div class="col-2"><input type="text" name="newPassword"></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Confirm Password :</label></div>
			<div class="col-2"><input type="text" name="confirmPassword"></div>
		</div>
		<div class="row">
			<div class="col-1"><input class="submit" type="submit" name="change-password" value="Save"></div>
		</div>
	</div>
</form>
	<div class="main-page back">
		<div class="row">
			<div class="col-1"><a href="dashboard.php">Back</a></div>
		</div>
	</div>
</center>
<script type="text/javascript" src="js/mainJs.js"></script>
<?php 
	echo "<script type='text/javascript'>";
		echo "
			document.getElementById('passwordError').style.color = 'red';
			document.getElementById('passwordError').innerHTML = '".$passwordError."';
			profile('change-password');
		";
	echo "</script>";
?>
</body>
</html>