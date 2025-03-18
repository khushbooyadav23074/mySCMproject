<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$unitName = $unitDetails = "";
			$unitNameErr = $requireErr = $confirmMessage = "";
			$unitNameHolder = $unitDetailsHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtUnitName'])) {
					$unitNameHolder = $_POST['txtUnitName'];
					$result = validate_name($_POST['txtUnitName']);
					if($result == 1) {
						$unitName = $_POST['txtUnitName'];
					}
					else{
						$unitNameErr = $result;
					}
				}
				if(!empty($_POST['txtunitDetails'])) {
					$unitDetails = $_POST['txtunitDetails'];
					$unitDetailsHolder = $_POST['txtunitDetails'];
				}
				if($unitName != null) {
					$query_addUnit = "INSERT INTO unit(unit_name,unit_details) VALUES('$unitName','$unitDetails')";
					if(mysqli_query($con,$query_addUnit)) {
						echo "<script> alert(\"Unit Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding New Unit Failed";
					}
				}
				else {
					$requireErr = "* Valid Unit Name is required";
				}
			}
		}
		else {
			header('Location:../index.php');
		}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Add Unit </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../includes/main_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_admin.inc.php");
		include("../includes/aside_admin.inc.php");
	?>
	<div class="main-content">
	<div class="data-section">
		<h1>Add Unit</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="unitName">Unit Name</label> </div>
			<div class="input-box"> <input type="text" id="unitName" name="txtUnitName" placeholder="Unit Name" value="<?php echo $unitNameHolder; ?>" required /> </div> <span class="error_message"><?php echo $unitNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="unitDetails">Details</label> </div>
			<div class="input-box"><textarea id="unitDetails" name="txtunitDetails" placeholder="Details"><?php echo $unitDetailsHolder; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Add Unit" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
		</li>
		</ul>
		</form>
	</div>
</div>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>