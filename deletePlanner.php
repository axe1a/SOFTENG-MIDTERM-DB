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
	<?php $getPlannerByID = getPlannerByID($pdo, $_GET['planner_id']); ?>
	<div class="container">
        <header>Eventi di Prestigio Database</header>
        <h2>Delete a Planner's Information</h2>
        <div class="details details-box">
            <h2>First Name: <?php echo $getPlannerByID['planner_first_name']; ?></h2>
            <h2>Last Name: <?php echo $getPlannerByID['planner_last_name']; ?></h2>
            <h2>Contact: <?php echo $getPlannerByID['planner_contact']; ?></h2>
            <h2>Email: <?php echo $getPlannerByID['planner_email']; ?></h2>
            <h2>Gender: <?php echo $getPlannerByID['planner_gender']; ?></h2>
            <h2>Date Added: <?php echo $getPlannerByID['date_added']; ?></h2>
        </div>
        
        <div class="form">
            <form action="core/handleForms.php?planner_id=<?php echo $_GET['planner_id']; ?>" method="POST">
                <input type="submit" name="deletePlannerBtn" value="Delete"><a href="index.php">Return to Home</a>
            </form>
        </div>
    </div>
</body>
</html>
