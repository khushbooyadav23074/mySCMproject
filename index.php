<?php
	include("../includes/config.php");
	session_start();
	if(isset($_SESSION['admin_login'])) {
		if($_SESSION['admin_login'] == true) {
			//select last 5 retialers
			$query_selectRetailer = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id ORDER BY retailer_id DESC LIMIT 5";
			$result_selectRetailer = mysqli_query($con,$query_selectRetailer);
			$query_selectRetailer2 = "SELECT * FROM retailer,area WHERE retailer.area_id=area.area_id ORDER BY retailer_id DESC";
			$result_selectRetailer2 = mysqli_query($con,$query_selectRetailer2);
			//select last 5 manufacturers
			$query_selectManufacturer = "SELECT * FROM manufacturer ORDER BY man_id DESC LIMIT 5";
			$result_selectManufacturer = mysqli_query($con,$query_selectManufacturer);
			$query_selectManufacturer2 = "SELECT * FROM manufacturer ORDER BY man_id DESC";
			$result_selectManufacturer2 = mysqli_query($con,$query_selectManufacturer2);
			//select last 5 products
			$query_selectProducts = "SELECT * FROM products,categories,unit WHERE products.pro_cat=categories.cat_id AND products.unit=unit.id ORDER BY pro_id DESC LIMIT 5";
			$result_selectProducts = mysqli_query($con,$query_selectProducts);
			$query_selectProducts2 = "SELECT * FROM products,categories,unit WHERE products.pro_cat=categories.cat_id AND products.unit=unit.id ORDER BY pro_id DESC";
			$result_selectProducts2 = mysqli_query($con,$query_selectProducts2);
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
	<title>Admin Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../includes/main_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
	<?php include("../includes/header.inc.php"); ?>
	<?php include("../includes/nav_admin.inc.php"); ?>
	<?php include("../includes/aside_admin.inc.php"); ?>

	<div class="main-content">
		<div class="dashboard-header">
			<h1>Admin Dashboard</h1>
		</div>
		<a href="../logout.php"><input type="button" value="Log out" class="submit_button" style="float:right;margin:10px;"></a>	

		<div class="dashboard-stats">
			<div class="stat-card retailers">
				<div class="stat-icon">
					<i class="fas fa-store"></i>
				</div>
				<div class="stat-title">Total Retailers</div>
				<div class="stat-value"><?php echo mysqli_num_rows($result_selectRetailer2); ?></div>
			</div>

			<div class="stat-card manufacturers">
				<div class="stat-icon">
					<i class="fas fa-industry"></i>
				</div>
				<div class="stat-title">Total Manufacturers</div>
				<div class="stat-value"><?php echo mysqli_num_rows($result_selectManufacturer2); ?></div>
			</div>

			<div class="stat-card products">
				<div class="stat-icon">
					<i class="fas fa-box"></i>
				</div>
				<div class="stat-title">Total Products</div>
				<div class="stat-value"><?php echo mysqli_num_rows($result_selectProducts2); ?></div>
			</div>
		</div>

		<div class="data-section">
			<h2 class="section-title">
				<i class="fas fa-store"></i> Recently Added Retailers
			</h2>
			<table class="table_displayData">
				<tr>
					<th>Sr. No.</th>
					<th>Username</th>
					<th>Area Code</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Address</th>
				</tr>
				<?php $i=1; while($row_selectRetailer = mysqli_fetch_array($result_selectRetailer)) { ?>
				<tr>
					<td> <?php echo $i; ?> </td>
					<td> <?php echo $row_selectRetailer['username']; ?> </td>
					<td> <?php echo $row_selectRetailer['area_code']; ?> </td>
					<td> <?php echo $row_selectRetailer['phone']; ?> </td>
					<td> <?php echo $row_selectRetailer['email']; ?> </td>
					<td> <?php echo $row_selectRetailer['address']; ?> </td>
				</tr>
				<?php $i++; } ?>
			</table>
		</div>

		<div class="data-section">
			<h2 class="section-title">
				<i class="fas fa-industry"></i> Recently Added Manufacturers
			</h2>
			<table class="table_displayData">
			<tr>
				<th>Sr. No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Username</th>
			</tr>
			<?php $i=1; while($row_selectManufacturer = mysqli_fetch_array($result_selectManufacturer)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td> <?php echo $row_selectManufacturer['man_name']; ?> </td>
				<td> <?php echo $row_selectManufacturer['man_email']; ?> </td>
				<td> <?php echo $row_selectManufacturer['man_phone']; ?> </td>
				<td> <?php echo $row_selectManufacturer['username']; ?> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		</div>

		<div class="data-section">
			<h2 class="section-title">
				<i class="fas fa-box"></i> Recently Added Products
			</h2>
			<table class="table_displayData">
			<tr>
				<th> Code </th>
				<th> Name </th>
				<th> Price </th>
				<th> Unit </th>
				<th> Category </th>
				<th> Quantity </th>
			</tr>
			<?php $i=1; while($row_selectProducts = mysqli_fetch_array($result_selectProducts)) { ?>
			<tr>
				<td> <?php echo $row_selectProducts['pro_id']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_name']; ?> </td>
				<td> <?php echo $row_selectProducts['pro_price']; ?> </td>
				<td> <?php echo $row_selectProducts['unit_name']; ?> </td>
				<td> <?php echo $row_selectProducts['cat_name']; ?> </td>
				<td> <?php if($row_selectProducts['quantity'] == NULL){ echo "N/A";} else {echo $row_selectProducts['quantity'];} ?> </td>
			</tr>
			<?php $i++; } ?>
		</table>
		</div>
	</div>

	<?php include("../includes/footer.inc.php"); ?>
	<script>
	// Make sure DOM is fully loaded
	document.addEventListener('DOMContentLoaded', function() {
		// Get elements
		const menuToggle = document.querySelector('.menu-toggle');
		const sidebar = document.getElementById('td_aside');
		const overlay = document.querySelector('.sidebar-overlay');

		// Toggle sidebar function
		function toggleSidebar() {
			if (sidebar) {
				sidebar.classList.toggle('active');
				if (overlay) overlay.classList.toggle('active');
			}
		}

		// Add click event to menu toggle
		if (menuToggle) {
			menuToggle.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				toggleSidebar();
			});
		}

		// Close sidebar when clicking outside
		document.addEventListener('click', function(event) {
			if (sidebar && sidebar.classList.contains('active')) {
				if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
					sidebar.classList.remove('active');
					if (overlay) overlay.classList.remove('active');
				}
			}
		});
	});
	</script>
</body>
</html>