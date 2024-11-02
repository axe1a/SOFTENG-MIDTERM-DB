<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
	<title>Eventi di Prestigio - Register</title>
</head>
<body>
<div class="container-reg">
    <header>Eventi di Prestigio Database</header>
    <br>

    

    <form action="core/handleForms.php" method="POST" class="register-form">
        <div class="inputAuth">
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="inputAuth">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required>
        </div>

        <div class="inputAuth">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required>
        </div>

        <div class="inputAuth">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="inputAuth">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </div>
        
        <div class="button-container">
            <input type="submit" name="registerUserBtn" value="Register">
        </div>
    </form>

    <?php if (isset($_SESSION['message'])) { ?>
        <div class="message">        
            <?php echo $_SESSION['message']; ?>
        </div>        
        <?php unset($_SESSION['message']); ?>
    <?php } ?>

</div>
</body>
</html>
