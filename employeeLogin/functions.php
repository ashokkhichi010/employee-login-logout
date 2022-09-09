<?php
	// $serverName = 'localhost';
	// $databaseUser = 'root';
	// $password = '';

	// // $mysqli_conn = mysqli_connect($serverName, $databaseUser, $password);// connectes to the server;
	// // $sqlCommand  = "CREATE DATABASE `employee login`";					// creates the database;
	// $dataBase = 'employee Login';
	// $mysqli_conn = mysqli_connect($serverName, $databaseUser, $password, $dataBase);
	// // $sqlCommand  = "CREATE TABLE `employee`(`eid` INT AUTO_INCREMENT PRIMARY KEY,
	// // 										`first name` varchar(20) NOT NULL,
	// // 										`last name` varchar(20),						// creates the table;
	// // 										`gmail id` varchar(50) UNIQUE NOT NULL,
	// // 										`mobile no` varchar(15) UNIQUE NOT NULL,
	// // 										`password` varchar(100) NOT NULL )"; 
	function connectDB(){
		return mysqli_connect('localhost','root','','employee Login');
	}
	// function insertIntoTable($firstName, $lastName, $gmailId, $mobileNo, $password){
		
	// }
	function insertData($firstName, $lastName, $gmailId, $mobileNo, $password){
		$gmailValidation  = gmailValidation($gmailId);
		$mobileValidation = mobileValidation($mobileNo);
		if ($gmailValidation) {
			if ($mobileValidation) {
				$mysqli_conn = connectDB();
				$sqlCommand = "INSERT INTO `employee`(`first name`,`last name`,`gmail id`,`mobile no`,`password`) VALUES('$firstName','$lastName','$gmailId','$mobileNo','$password')";
				mysqli_query($mysqli_conn, $sqlCommand);
			}else{
				return '! Invalid Mobile No';
			}
		}else{
			return '! Invalid Gmail Id';
		}
		return 1;
	}
	function gmailValidation($gmailId){
		$isValid = filter_var($gmailId, FILTER_VALIDATE_EMAIL);
		if ($isValid) {
			return true;
		}else{
			return false;
		}
	}
	function mobileValidation($mobileNo){
		$options = array(
						'options' => array(
		                					"min_range" => 6300000000,
		                                    "max_range" => 9999999999
		                                    )
		                );
		$isValid = filter_var($mobileNo, FILTER_VALIDATE_INT,$options);

		if($isValid){
			return true;
		}else{
			return false;
		}
	}

	function addTime($time1, $time2){
		$mysqli_conn = connectDB();
		$addTimeCommand = "SELECT ADDTIME('$time1', '$time2')";
		$ref = mysqli_query($mysqli_conn, $addTimeCommand);
		$totleTime = mysqli_fetch_array($ref);
		return $totleTime[0];
	}
	function timeDiff($time1, $time2){
		$mysqli_conn = connectDB();
		$timeDiffCommend = "SELECT TIMEDIFF('$time1', '$time2')";
		$ref = mysqli_query($mysqli_conn, $timeDiffCommend);
		$timeDiff = mysqli_fetch_array($ref);
		return $timeDiff[0];
	}
?>