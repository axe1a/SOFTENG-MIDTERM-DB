<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getPlannerByID = getPlannerByID($pdo, $_GET['planner_id']); ?>
	<div class="container">
		<header>Eventi di Prestigio Database</header>

		<form action="core/handleForms.php?planner_id=<?php echo $_GET['planner_id']; ?>" method="POST">
			<div class="form">
				<div class="details planner">
					<span class="title">Edit a Planner's Information</span>
					<div class="fields">
						<div class="inputPlanner">
							<label for="firstName">First Name</label> 
							<input type="text" name="firstName" 
							value="<?php echo $getPlannerByID['planner_first_name'];?>" required>
							
						</div>
						<div class="inputPlanner">
							<label for="lastName">Last Name</label> 
							<input type="text" name="lastName"
							value="<?php echo $getPlannerByID['planner_last_name'];?>" required>
						</div>
						<div class="inputPlanner">
							<label for="contact">Contact Information</label> 
							<input type="text" name="contact"
							value="<?php echo $getPlannerByID['planner_contact'];?>" required>
						</div>
						<div class="inputPlanner">
							<label for="email">Email</label> 
							<input type="text" name="email"
							value="<?php echo $getPlannerByID['planner_email'];?>" required>
						</div>
						<div class="inputPlanner">
							<label for="gender">Gender</label> 
							<input type="text" name="gender"
							value="<?php echo $getPlannerByID['planner_gender'];?>" required>
						</div>
						<input type="submit" name="editPlannerBtn">
						</div>
				</div>
			</div>
		</form>
	</div>

</body>
</html>
