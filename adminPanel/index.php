<?php 
	$mysqli_conn = mysqli_connect('localhost','root','','employee Login');
	function shortEmployeeData($employeeData, $short){
		for ($i = 0; $i < count($employeeData)-1; $i++) { 
			for ($j = $i + 1; $j < count($employeeData) ; $j++) { 
				if ($employeeData[$i][$short] < $employeeData[$j][$short]) {
					$temp[$i] = $employeeData[$i];
					$employeeData[$i] = $employeeData[$j];
					$employeeData[$j] = $temp[$i];
				}
			}
		}
		return $employeeData;
	}
	function getData($selectComment){
		$mysqli_conn = mysqli_connect('localhost','root','','employee Login');
		$i = 0;
		$ref = mysqli_query($mysqli_conn, $selectComment);
		while($row = mysqli_fetch_assoc($ref)){
			$employeeData[$i] = $row;
			$i++;
		}
		return $employeeData;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="css/main-page.css">
</head>
<body>
	<div class="container">
		<div class="main-page all-employees">
			<div class="row">
				<div class="col-1"><h2>All Employees</h2></div>
				<div class="col-4">
				<form method="post">
					<select>
						<option id="Name" name = "Name" onselect="dropdownlist(id)">Name</option>
						<option id="Department" name = "Department" onselect="dropdownlist(id)">Department</option>
						<option id="Joining Date" name = "Joining Date" onselect="dropdownlist(id)">Joining Date</option>
						<option id="Totle Work Time" name = "Totle Work Time" onselect="dropdownlist(id)">Totle Work Time</option>
					</select>
				</form>
				</div>
			</div>
			<div class="row">
				<div class="col-4"><b>Employee Name</b></div>
				<div class="col-4"><b>Department</b></div>
				<div class="col-4"><b>Totle Work Time</b></div>
				<div class="col-4"><b>Joining Date</b></div>
			</div><form method="post">
			<?php
				$i = 0;
				$selectComment = "SELECT * FROM `employee`";
				$ref = mysqli_query($mysqli_conn, $selectComment);
				$employeeData = getData($selectComment);
				$employeeData = shortEmployeeData($employeeData,'department');
				for ($i=0; $i < count($employeeData); $i++) { 
					$fullName = strtoupper($employeeData[$i]['first name'])." ".strtoupper($employeeData[$i]['last name']);
					$department = $employeeData[$i]['department'];
					$totleWorkTime = $employeeData[$i]['totle work time'];
					$joiningDate = $employeeData[$i]['joining date'];
					echo "	<button id='".$employeeData[$i]['eid']."' type='submit' name='selectEmployee' value='".$employeeData[$i]['eid']."'>
						<div class='row row-1'>
							<div class='col-3'>".$fullName."</div>
							<div class='col-4'>".$department."</div>
							<div class='col-4'>".$totleWorkTime."</div>
							<div class='col-4'>".$joiningDate."</div>
						</div></button>
						";
				}
			?></form>
		</div>
		<div class="main-page recent-employee-login">
			<div class="row">
				<div class="col-1"><h2>Recent Employee Login</h2></div>
			</div><form method="post">
			<?php 
				$employeeData = null;
				$selectComment = "SELECT `employee`.*,`work`.* FROM `employee` INNER JOIN `work` ON `employee`.`eid` = `work`.`eid` AND `work`.`logout time` = '00:00:00'";
				$ref = mysqli_query($mysqli_conn,$selectComment);
				$i = 0;
				$flag = 0;
				while($row = mysqli_fetch_assoc($ref)){
					$employeeData[$i] = $row;
					$i++;
					$flag = 1;	// $flag indicats any employee is parsent or not;
				}
				// echo "<pre>";
				// print_r($employeeData);
				// echo "</pre>";
				if($flag == 0){
					echo '<center><h1>Not Parsent any Employee</h1></center>';
				}else {
					$employeeData = shortEmployeeData($employeeData, 'login time');	
					for($i = 0; $i < count($employeeData) ; $i++) {
						$flag = 1;
						$fullName = strtoupper($employeeData[$i]['first name'])." ".strtoupper($employeeData[$i]['last name']);
						$department = $employeeData[$i]['department'];
						$loginTime = $employeeData[$i]['login time'];
						echo "	<button type='submit' name='selectEmployee' value='".$employeeData[$i]['eid']."'>
							<div class='row row-1'>
								<div class='col-3'>".$fullName."</div>
								<div class='col-3'>".$department."</div>
								<div class='col-3'>".$loginTime."</div>
							</div></button>
						";
					}
				}
			?></form>
			<!-- <div class="row">
				<div class="col-1"><h2>Absent Employees</h2></div>
			</div> -->
			
		</div>
		<div class="main-page employee-details">
			<div class="row">
				<div class="col-1"><h2>Employee Details</h2></div>
			</div>
			<?php
				if (!isset($_POST['selectEmployee'])) {
					$_POST['selectEmployee'] = 18;
				}
				if (isset($_POST['selectEmployee'])) {
					$eid = $_POST['selectEmployee'];
					// $eid = 18;
					$selectComment = "SELECT * FROM `employee` WHERE `eid` = '$eid'";
					$employeeData = getData($selectComment);
					$fullName = strtoupper($employeeData[0]['first name']." ".strtoupper($employeeData[0]['last name']));
					$department = $employeeData[0]['department'];
					$gender = $employeeData[0]['gender'];
					$gmailId = $employeeData[0]['gmail id'];
					$mobileNo = $employeeData[0]['mobile no'];
					$joiningDate = $employeeData[0]['joining date'];
					$totleWorkTime = $employeeData[0]['totle work time'];
					$date = date('Y-m-d');
					$selectComment = "SELECT * FROM `work` WHERE `eid` = '$eid' AND `date`= '$date'";
					// $workData = getData($selectComment);
				}
			?>
			<div class="row">
				<div class="col-2">Employee Name</div>
				<div class="col-2"><?php echo $fullName;?></div>
			</div>
			<div class="row">
				<div class="col-2">Department</div>
				<div class="col-2"><?php echo $department;?></div>
			</div>
			<div class="row">
				<div class="col-2">Gender</div>
				<div class="col-2"><?php echo $gender;?></div>
			</div>
			<div class="row">
				<div class="col-2">Gmail Id</div>
				<div class="col-2"><?php echo $gmailId;?></div>
			</div>
			<div class="row">
				<div class="col-2">Mobile No.</div>
				<div class="col-2"><?php echo $mobileNo;?></div>
			</div>
			<div class="row">
				<div class="col-2">Joining Date</div>
				<div class="col-2"><?php echo $joiningDate;?></div>
			</div>
			<div class="row">
				<div class="col-2">Totle Work Time</div>
				<div class="col-2"><?php echo $totleWorkTime;?></div>
			</div>
			<?php
				if (isset($workData)) {
				for ($i=0; $i < count($workData); $i++) { 
					echo "
						<div class='row'>
							<div class='col-2'>".$workData[$i]['login time']."</div>
							<div class='col-2'>".$workData[$i]['logout time']."</div>
						</div>";
				}}
			?>
		</div>
	</div>
	<script type="text/javascript">
		document.getElementById(<?php echo $eid; ?>).style.color = '#8a2be2';
	</script>
</body>
</html>