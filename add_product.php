<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			$query_selectCategory = "SELECT cat_id,cat_name FROM categories";
			$query_selectUnit = "SELECT id,unit_name FROM unit";
			$query_selectManId = "SELECT man_id,man_name FROM manufacturer";
			$result_selectCategory = mysqli_query($con,$query_selectCategory);
			$result_selectUnit = mysqli_query($con,$query_selectUnit);
			$result_selectManId = mysqli_query($con,$query_selectManId);
			$name = $price = $unit = $category = $rdbStock = $description = "";
			$nameErr = $priceErr = $requireErr = $confirmMessage = "";
			$nameHolder = $priceHolder = $descriptionHolder = "";
			if($_SERVER['REQUEST_METHOD'] == "POST") {
				if(!empty($_POST['txtProductName'])) {
					$nameHolder = $_POST['txtProductName'];
					$name = $_POST['txtProductName'];
				}
				if(isset($_POST['cmbManufacturerId'])) {
					$manufacurerid = $_POST['cmbManufacturerId'];
				}
				if(!empty($_POST['txtProductPrice'])) {
					$priceHolder = $_POST['txtProductPrice'];
					$resultValidate_price = validate_price($_POST['txtProductPrice']);
					if($resultValidate_price == 1) {
						$price = $_POST['txtProductPrice'];
					}
					else {
						$priceErr = $resultValidate_price;
					}
				}
				if(isset($_POST['cmbProductUnit'])) {
					$unit = $_POST['cmbProductUnit'];
				}
				if(isset($_POST['cmbProductCategory'])) {
					$category = $_POST['cmbProductCategory'];
				}
				if(empty($_POST['rdbStock'])) {
					$rdbStock = "";
				}
				else {
					if($_POST['rdbStock'] == 1) {
						$rdbStock = 1;
					}
					else if($_POST['rdbStock'] == 2) {
						$rdbStock = 2;
					}
				}
				if(!empty($_POST['txtProductDescription'])) {
					$description = $_POST['txtProductDescription'];
					$descriptionHolder = $_POST['txtProductDescription'];
				}
				if($name != null && $price != null && $unit != null && $category != null && $rdbStock == 1) {
					$rdbStock = 0;
					$query_addProduct = "INSERT INTO products(pro_name,pro_desc,manufacturer_id,pro_price,unit,pro_cat,quantity) VALUES('$name','$description','$manufacurerid','$price','$unit','$category','$rdbStock')";
					if(mysqli_query($con,$query_addProduct)) {
						echo "<script> alert(\"Product Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding Product Failed";
					}
			}
				else if($name != null && $price != null && $unit != null && $category != null && $rdbStock == 2) {
						$query_addProduct = "INSERT INTO products(pro_name,pro_desc,manufacturer_id,pro_price,unit,pro_cat,quantity) VALUES('$name','$description','$manufacurerid','$price','$unit','$category',NULL)";
					if(mysqli_query($con,$query_addProduct)) {
						echo "<script> alert(\"Product Added Successfully\"); </script>";
						header('Refresh:0');
					}
					else {
						$requireErr = "Adding Product Failed";
					}
				}
				else {
					$requireErr = "* All Fields are Compulsory with valid values except Description";
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
	<title> Add Product </title>
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
		<h1>Add Product</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="product:name">Product Name</label> </div>
			<div class="input-box"> <input type="text" id="product:name" name="txtProductName" placeholder="Product Name" value="<?php echo $nameHolder; ?>" required /> </div> <span class="error_message"><?php echo $nameErr; ?></span>
		</li>
		<div class="label-block"> <label for="Manufacturer:id">Manufacturer</label> </div>
		<div class="input-box">
		<select name="cmbManufacturerId" id="Manufacturer:id">
			<option value="" disabled selected>--- Select Manufacturer ---</option>
			<?php while($row_selectManId = mysqli_fetch_array($result_selectManId)) { ?>
			<option value="<?php echo $row_selectManId["man_id"]; ?>"> <?php echo $row_selectManId["man_name"]; ?> </option>
			<?php } ?>
		</select>
			</div>
		<li>
			<div class="label-block"> <label for="product:price">Price</label> </div>
			<div class="input-box"> <input type="text" id="product:price" name="txtProductPrice" placeholder="Price" value="<?php echo $priceHolder; ?>" required /> </div> <span class="error_message"><?php echo $priceErr; ?></span>
		</li>
		<li>
		<div class="label-block"> <label for="product:unit">Unit Type</label> </div>
		<div class="input-box">
		<select name="cmbProductUnit" id="product:unit">
			<option value="" disabled selected>--- Select Unit ---</option>
			<?php while($row_selectUnit = mysqli_fetch_array($result_selectUnit)) { ?>
			<option value="<?php echo $row_selectUnit["id"]; ?>"> <?php echo $row_selectUnit["unit_name"]; ?> </option>
			<?php } ?>
		</select>
		</div>
		</li>
		<li>
		<div class="label-block"> <label for="product:category">Category</label> </div>
		<div class="input-box">
		<select name="cmbProductCategory" id="product:category">
			<option value="" disabled selected>--- Select Category ---</option>
			<?php while($row_selectCategory = mysqli_fetch_array($result_selectCategory)) { ?>
			<option value="<?php echo $row_selectCategory["cat_id"]; ?>"> <?php echo $row_selectCategory["cat_name"]; ?> </option>
			<?php } ?>
		</select>
		</div>
		</li>
		<li>
			<div class="label-block"> <label for="product:stock">Stock Management</label> </div>
			<input type="radio" name="rdbStock" value="1">Enable
			<input type="radio" name="rdbStock" value="2">Disable
		</li>
		<li>
			<div class="label-block"> <label for="product:description">Description</label> </div>
			<div class="input-box"> <textarea type="text" id="product:description" name="txtProductDescription" placeholder="Description"><?php echo $descriptionHolder; ?></textarea> </div>
		</li>
		<li>
			<input type="submit" value="Add Product" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?> </span><span class="confirm_message"> <?php echo $confirmMessage; ?> </span>
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