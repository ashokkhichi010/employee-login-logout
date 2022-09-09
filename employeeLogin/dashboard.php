<?php 
	session_start();
	date_default_timezone_set("Asia/Kolkata");
	if(!isset($_SESSION['eid'])){
		header('location:/employeeLogin');
	}
	include 'functions.php';
	// error_reporting(0);
	$mysqli_conn = connectDB();
	$eid = $_SESSION['eid']; 
	$displayBtn = 'OUT';
	$date = date('d-M-Y');
	$loginDate = date('Y-m-d');
	$time = date('H:i:s');
//---------------------			-Log Out- 		------------------------------------------------//
	if (isset($_POST['logout']) || isset($_POST['OUT'])) {
		$logoutTime = $time;
		$loginTime = $_SESSION['loginTime'];

		$timeDiffCommend = "SELECT TIMEDIFF('$logoutTime', '$loginTime')";
		$ref = mysqli_query($mysqli_conn, $timeDiffCommend);
		$timeDiff = mysqli_fetch_array($ref);

		$insertCommend = "UPDATE `work`SET `logout time` = '$logoutTime', `totle time` = '$timeDiff[0]' WHERE `login time` = '$loginTime'";
		mysqli_query($mysqli_conn, $insertCommend);
		$displayBtn = 'IN';
		if (isset($_POST['logout'])) {
			unset($_SESSION['eid']);
			header('location:/employeeLogin');
		}
	}
//---------------------			-Log In- 		------------------------------------------------//
	else if (isset($_POST['IN'])) {
		$loginTime = date('H:i:s');
		$_SESSION['loginTime'] = $loginTime;
		$insertCommend = "INSERT INTO `work`(`eid`, `date`, `login time`) VALUES('$eid', '$loginDate', '$loginTime')";
		mysqli_query($mysqli_conn, $insertCommend);
		$displayBtn = 'OUT';
	}
	$selectCommend = "SELECT * FROM `employee` WHERE `eid` ='".$eid."'";
	$ref = mysqli_query($mysqli_conn, $selectCommend);
	$userData = mysqli_fetch_array($ref);
	$fullName = $userData['first name'] ." ". $userData['last name'];
	$fullName = strtoupper($fullName);
	$workingHour = 100;
	$department = $userData['department'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/main-page.css">
</head>
<body>
<center>
	<div class="main-page">
		<div class="row">
			<div class="col-4 sidebar dropdown">☰
				<div class="dropdown-content">
					<a href="userProfile.php">View Profile</a>
					<form method="post"><input type="submit" name="logout" value="Log Out"></form>
				</div>
			</div>
			<div class="col-1"><h2><?php echo $fullName; ?></h2></div>
		</div>
		<div class="row">
			<div class="col-2"><label>Date : </label></div>
			<div class="col-2"><?php echo $date; ?></div>
		</div>		
		<div class="row">
			<div class="col-2"><label>Department : </label></div>
			<div class="col-2"><?php echo $department; ?></div>
		</div>
		<div class="row">
			<div class="col-2"><label> Login Time </label></div>
			<div class="col-2"><label> Logout Time </label></div>
		</div>
		<?php 
			$totleWorkTime = '00:00:00';
			$selectCommend = "SELECT `login time`, `logout time`,`totle time` FROM `work` WHERE `eid` = '$eid' AND `date` = '$loginDate'";
			$ref = mysqli_query($mysqli_conn, $selectCommend);
			while ($workData = mysqli_fetch_array($ref)){ 
				echo '
					<div class="row">
						<div class="col-2"><label>'.$workData["login time"].'</label></div>
						<div class="col-2"><label>'.$workData["logout time"].'</label></div>
					</div>';
					if ($workData['totle time'] != null) {
						$totleWorkTime = addTime($workData['totle time'],$totleWorkTime);
					}
			}
			// echo $totleWorkTime;
			$loginTime = $_SESSION['loginTime'] ;
			$currentWorkingTime = timeDiff($time, $loginTime);
			// echo $currentWorkingTime;
			$totleWorkTime = addTime($totleWorkTime, $currentWorkingTime);
			$_SESSION['totleWorkTime'] = $totleWorkTime;
		?>
		<div class="row">
			<div class="col-2"><label> Totle Working Time </label></div>
			<div class="col-2"><?php echo $totleWorkTime; ?></div>
		</div>
		<form method="post">
			<div id="in" class="row">
				<div class="col-1">
					<?php 
						echo "<input class='in-out submit' type='submit' name='".$displayBtn."' value='".$displayBtn."' />";
					?>
				</div>
			</div>
		</form>
	</div>
</center>
<script type="text/javascript" src="js/mainJs.js"></script>
</body>
</html>
