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
	<title>Delete Event</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getEventByID = getEventByID($pdo, $_GET['event_id']); ?>
	<div class="container">
        <header>Eventi di Prestigio Database</header>
        <h2>Delete an Event</h2>
        <div class="details details-box">
            <h2>Event Name: <?php echo $getEventByID['event_name']; ?></h2>
            <h2>Event Type: <?php echo $getEventByID['event_type']; ?></h2>
            <h2>Event Coordinator: <?php echo $getEventByID['event_coordinator']; ?></h2>
            <h2>Date Added: <?php echo $getEventByID['date_added']; ?></h2>
        </div>

        <div class="form">
            <form action="core/handleForms.php?event_id=<?php echo $_GET['event_id']; ?>&planner_id=<?php echo $_GET['planner_id']; ?>" method="POST">
                <input type="submit" name="deleteEventBtn" value="Delete">
                <a href="viewEvent.php?planner_id=<?php echo $_GET['planner_id']; ?>">Return to Event List</a>
            </form>
        </div>
    </div>
</body>
</html>
