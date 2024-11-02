<?php 
session_start(); 
require_once 'core/models.php';
require_once 'core/dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getEventByID = getEventByID($pdo, $_GET['event_id']); ?>
	<div class="container">
	<header>Eventi di Prestigio Database</header>
	
	<form action="core/handleForms.php?event_id=<?php echo $_GET['event_id']; ?>&planner_id=<?php echo $_GET['planner_id']; ?>" method="POST">
		<div class="form">
				<div class="details planner">
					<span class="title">Edit an Event</span>
					<div class="fields">

						<div class="inputPlanner">
							<label for="event_name">Event Name</label> 
							<input type="text" name="event_name"
							value="<?php echo $getEventByID['event_name']; ?>" required>
						</div>

						<div class="inputPlanner">
							<label for="event_type">Event Type</label> 
							<input type="text" name="event_type"
							value="<?php echo $getEventByID['event_type']; ?>" required>
						</div>
					</div>
					<input type="submit" name="editEventBtn"> <a href="viewEvent.php?planner_id=<?php echo $_GET['planner_id']; ?>">View Events</a>
				</div>
		</form>
    </table>
</div>
</body>
</html>
