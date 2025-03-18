<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$categoryName = $categoryDetails = "";
			$categoryNameErr = $requireErr = $confirmMessage = "";
			$categoryNameHolder = $categoryDetailsHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtCategoryName'])) {
					$categoryNameHolder = $_POST['txtCategoryName'];
					$categoryName = $_POST['txtCategoryName'];
				}
				if(!empty($_POST['txtCategoryDetails'])) {
					$categoryDetails = $_POST['txtCategoryDetails'];
					$categoryDetailsHolder = $_POST['txtCategoryDetails'];
				}
				if($categoryName != null) {
					$query_addCategory = "INSERT INTO categories(cat_name,cat_details) VALUES('$categoryName','$categoryDetails')";
					if(mysqli_query($con,$query_addCategory)) {
						echo "<script> alert(\"Category Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding New Category Failed";
					}
				}
				else {
					$requireErr = "* Valid Category Name is required";
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
	<title> Add Category </title>
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
		<h1>Add Category</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="categoryName">Category Name</label> </div>
			<div class="input-box"> <input type="text" id="categoryName" name="txtCategoryName" placeholder="Category Name" value="<?php echo $categoryNameHolder; ?>" required /> </div> <span class="error_message"><?php echo $categoryNameErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="categoryDetails">Details</label> </div>
			<div class="input-box"><textarea id="categoryDetails" name="txtCategoryDetails" placeholder="Details"><?php echo $categoryDetailsHolder; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Add Category" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
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