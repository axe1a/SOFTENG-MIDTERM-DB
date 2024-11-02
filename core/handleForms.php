<?php 
session_start();
require_once 'dbConfig.php'; 
require_once 'models.php';
require_once 'validate.php';

if (isset($_POST['insertPlannerBtn'])) {
	
	$added_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$firstName = sanitizeInput($_POST['firstName']);
	$lastName = sanitizeInput($_POST['lastName']);
	$contact = sanitizeInput($_POST['contact']);
	$email = sanitizeInput($_POST['email']);
	$gender = sanitizeInput($_POST['gender']);
	
	$query = insertPlanner($pdo, $_POST['firstName'], $_POST['lastName'],
	$_POST['contact'], $_POST['email'], $_POST['gender'], $added_by, $user_id);


	if ($query) {
		header("Location: ../index.php");
	}
	else {
		echo "Insertion failed";
	}

}


if (isset($_POST['editPlannerBtn'])) {

	$last_updated_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$firstName = sanitizeInput($_POST['firstName']);
	$lastName = sanitizeInput($_POST['lastName']);
	$contact = sanitizeInput($_POST['contact']);
	$email = sanitizeInput($_POST['email']);
	$gender = sanitizeInput($_POST['gender']);

	$query = updatePlanner($pdo, $_POST['firstName'], $_POST['lastName'], 
	$_POST['contact'], $_POST['email'], $_POST['gender'], $last_updated_by,$_GET['planner_id'], );

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}




if (isset($_POST['deletePlannerBtn'])) {
	$deleted_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$query = deletePlanner($pdo,$deleted_by, $_GET['planner_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Deletion failed";
	}
}




if (isset($_POST['insertEventBtn'])) {

	$added_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$event_name = sanitizeInput($_POST['event_name']);
	$event_type = sanitizeInput($_POST['event_type']);

	$query = insertEvent($pdo, $_POST['event_name'], $_POST['event_type'], $_GET['planner_id'], $added_by, $user_id);

	if ($query) {
		header("Location: ../viewEvent.php?planner_id=" .$_GET['planner_id']);
	}
	else {
		echo "Insertion failed";
	}
}




if (isset($_POST['editEventBtn'])) {
	
	$last_updated_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$event_name = sanitizeInput($_POST['event_name']);
	$event_type = sanitizeInput($_POST['event_type']);

	$query = updateEvent($pdo, $_POST['event_name'], $_POST['event_type'],  $last_updated_by, $_GET['event_id']);

	if ($query) {
		header("Location: ../viewEvent.php?planner_id=" .$_GET['planner_id']);
	}
	else {
		echo "Update failed";
	}

}




if (isset($_POST['deleteEventBtn'])) {
	$deleted_by = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];

	$query = deleteEvent($pdo, $deleted_by, $_GET['event_id']);

	if ($query) {
		header("Location: ../viewEvent.php?planner_id=" .$_GET['planner_id']);
	}
	else {
		echo "Deletion failed";
	}
}




if (isset($_POST['registerUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$first_name = sanitizeInput($_POST['first_name']);
	$last_name = sanitizeInput($_POST['last_name']);
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if (!empty($username) && !empty($first_name) && !empty($last_name) 
		&& !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (validatePassword($password)) {

				$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, sha1($password));

				if ($insertQuery) {
					header("Location: ../login.php");
					exit; // Stop script execution after header redirect
				} else {
					$_SESSION['message'] = "Registration failed. Please try again.";
					header("Location: ../register.php");
					exit;
				}
			} else {
				$_SESSION['message'] = "Password should contain more than 8 characters and contain both uppercase, lowercase, and numbers";
				header("Location: ../register.php");
				exit;
			}
		} else {
			$_SESSION['message'] = "Passwords are not the same!";
			header("Location: ../register.php");
			exit;
		}
	} else {
		$_SESSION['message'] = "Make sure the input fields are not empty.";
		header("Location: ../register.php");
		exit;
	}
}

if (isset($_POST['loginUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);

		if ($loginQuery) {
			header("Location: ../index.php");
			exit;
		} else {
			$_SESSION['message'] = "Invalid username or password.";
			header("Location: ../login.php");
			exit;
		}
	} else {
		$_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
		header("Location: ../login.php");
		exit;
	}
}

if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
	exit;
}

if (isset($_POST['editUserBtn'])) {
	$query = updateUserInfo($pdo, $_POST['first_name'], $_POST['last_name'], 
	 $_GET['user_id']);

	if ($query) {
		header("Location: ../index.php");
	}

	else {
		echo "Edit failed";;
	}

}