<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <header>Eventi di Prestigio Database</header>
    <?php $getAllInfoByPlannerID = getPlannerByID($pdo, $_GET['planner_id']); ?>
    
    <form action="core/handleForms.php?planner_id=<?php echo $_GET['planner_id']; ?>" method="POST">
        <div class="form">
            <div class="details planner">
				<span class="title">Add an Event</span>
                <div class="fields">
                    <div class="inputPlanner">
                        <label for="event_name">Event Name</label> 
                        <input type="text" name="event_name" required>
                    </div>
                    <div class="inputPlanner">
                        <label for="event_type">Event Type</label> 
                        <input type="text" name="event_type" required>
                    </div>
                </div>
				<br><br><br><br><br><br>
                <p><input type="submit" name="insertEventBtn"> <a href="index.php">Return to Home</a></p>
            </div>
        </div>
    </form>
</div>
<br><br>
<div class="container">
    <table style="width:100%; margin-top: 50px;">
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Event Type</th>
            <th>Event Coordinator</th>
            <th>Date Added</th>
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
        <?php $getEventByPlanner = getEventByPlanner($pdo, $_GET['planner_id']); ?>
        <?php foreach ($getEventByPlanner as $row) { ?>
            <tr>
                <td><?php echo $row['event_id']; ?></td>	  	
                <td><?php echo $row['event_name']; ?></td>	  	
                <td><?php echo $row['event_type']; ?></td>	  
                <td><?php echo $row['event_coordinator']; ?></td>
                <td><?php echo $row['date_added']; ?></td>
                <td><?php echo $row['last_updated_by']; ?> <br> <?php echo $row['last_update']; ?></td>		
                <td>
					<a href="editEvent.php?event_id=<?php echo $row['event_id']; ?>&planner_id=<?php echo $_GET['planner_id']; ?>">Edit</a>
                    <a href="deleteEvent.php?event_id=<?php echo $row['event_id']; ?>&planner_id=<?php echo $_GET['planner_id']; ?>">Delete</a>
                </td>	  	
            </tr>
        <?php } ?>
    </table>
</div>
    </table>


	




</body>
</html>