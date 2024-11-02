<?php
session_start(); 
require_once 'core/dbConfig.php';
require_once 'core/models.php';
	
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="styles.css">

	<title>Document</title>
</head>
<body>
	<div class="container">
		<header>Eventi di Prestigio Database</header>
		<p style="text-align:right;">Hi, <?php echo ($_SESSION['username'])."!" ?>
		<a href="core/handleForms.php?logoutAUser=1" style="text-align:right;">Logout</a></p>
		<form action="core/handleForms.php" method="POST">
			<div class="form">
				<div class="details planner">
					<span class="title">Add a Planner</span>
					<br><br>
					<div class="fields">
						<div class="inputPlanner">
							<label for="firstName">First Name</label> 
							<input type="text" name="firstName" required>
						</div>
						<div class="inputPlanner">
							<label for="lastName">Last Name</label> 
							<input type="text" name="lastName" required>
						</div>
						<div class="inputPlanner">
							<label for="contact">Contact Information</label> 
							<input type="text" name="contact" required>
						</div>
						<div class="inputPlanner">
							<label for="email">Email</label> 
							<input type="text" name="email" required>
						</div>
						<div class="inputPlanner">
							<label for="gender">Gender</label> 
							<input type="text" name="gender" required>
						</div>
						
						</div>
					<button input type="submit" name="insertPlannerBtn">Submit</button>
				</div>
			</div>
		</form>
	</div>
	
	<br><br>

	<div class="container">
    <?php $getAllPlanner = getAllPlanner($pdo); ?>
	<span class="title">Planner List</span>
	
	<table>
            <tr>
                <th>Planner ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date Added</th>
				<th>Added By</th>
				<th>Last Updated</th>
                <th>Actions</th>
				
            </tr>

            <?php foreach ($getAllPlanner as $row) { ?>
            <tr>
                <td><?php echo $row['planner_id']; ?></td>
                <td><?php echo $row['planner_first_name']; ?></td>
                <td><?php echo $row['planner_last_name']; ?></td>
                <td><?php echo $row['planner_contact']; ?></td>
                <td><?php echo $row['planner_email']; ?></td>
                <td><?php echo $row['planner_gender']; ?></td>
				<td><?php echo $row['date_added']; ?></td>
				<td><?php echo $row['added_by']; ?></td>
				<td><?php echo $row['last_updated_by']; ?> <br> <?php echo $row['last_update']; ?></td>
                <td>
                    <a href="viewEvent.php?planner_id=<?php echo $row['planner_id']; ?>">View Events</a>
                    <a href="editPlanner.php?planner_id=<?php echo $row['planner_id']; ?>">Edit</a>
                    <a href="deletePlanner.php?planner_id=<?php echo $row['planner_id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
	
    </table>
	</div>
	<br><br>
	<div class="container">
    <?php $getAllUsers = getAllUsers($pdo); ?>
	<span class="title">Users List</span>
    <table>
            <tr>
                <th>User ID</th>
				<th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Added</th>
                				
            </tr>

            <?php foreach ($getAllUsers as $row) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['date_added']; ?></td>
                </tr>
            <?php } ?>
    </table>
	</div>
	<br><br>

	<div class="container">
	<?php $getAllAuditLog = getAllAuditLog($pdo); ?>
	<span class="title">Audit Log</span>
	<table>
            <tr>
                <th>Attribute ID</th>
				<th>Username</th>
                <th>Action</th>
                <th>Table</th>
                <th>Details</th>
                <th>Time</th>				
            </tr>

            <?php foreach ($getAllAuditLog as $row) { ?>
            <tr>
                <td><?php echo $row['update_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['action']; ?></td>
                <td><?php echo $row['table_name']; ?></td>
                <td><?php echo $row['action_details']; ?></td>
                <td><?php echo $row['action_timestamp']; ?></td>
				<?php } ?>
			</tr>
    </table>			

	</div>
</body>
</html>