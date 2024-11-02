<?php  
require_once 'dbConfig.php';


function insertPlanner($pdo, $first_name, $last_name, $contact, $email, $gender, $added_by, $user_id) {

	$sql = "INSERT INTO eventplanner (planner_first_name, planner_last_name, 
		planner_contact, planner_email, planner_gender, added_by, user_id) VALUES (?,?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $contact, $email, $gender, $added_by, $user_id]);

	if ($executeQuery) {
		$update_id = $pdo->lastInsertId();
		insertAuditLog($pdo, $added_by, 'Insert', 'Event Planner', $update_id, 'Added a Planner');
		return true;
	}
}



function updatePlanner($pdo, $first_name, $last_name, $contact, $email, $gender, $last_updated_by, $planner_id, ) {

	$sql = "UPDATE eventplanner
				SET planner_first_name = ?,
					planner_last_name = ?,
					planner_contact = ?, 
					planner_email = ?,
					planner_gender = ?,
					last_updated_by = ?
				WHERE planner_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $contact, $email, $gender, $last_updated_by, $planner_id]);
	
	if ($executeQuery) {
		
		insertAuditLog($pdo, $last_updated_by, 'Update', 'Event Planner', $planner_id, 'Updated a Planner');
		return true;
	}

}


function deletePlanner($pdo, $deleted_by, $planner_id) {
	$deletePlannerEvent = "DELETE FROM events WHERE planner_id = ?";
	$deleteStmt = $pdo->prepare($deletePlannerEvent);
	$executeDeleteQuery = $deleteStmt->execute([$planner_id]);
	
	if ($executeDeleteQuery) {
		$sql = "DELETE FROM eventplanner WHERE planner_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$planner_id]);

		if ($executeQuery) {

			insertAuditLog($pdo, $deleted_by, 'Delete', 'Event Planner', $planner_id, 'Deleted a Planner');
			return true;
		}

	}
	
}


function getAllPlanner($pdo) {
	$sql = "SELECT * FROM eventplanner";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getPlannerByID($pdo, $planner_id) {
	$sql = "SELECT * FROM eventplanner WHERE planner_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$planner_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}


function getEventByPlanner($pdo, $planner_id) {
	
	$sql = "SELECT 
				events.event_id AS event_id,
				events.event_name AS event_name,
				events.event_type AS event_type,
				CONCAT(eventplanner.planner_first_name,' ',eventplanner.planner_last_name) AS event_coordinator,
				events.added_by AS added_by,
				events.last_updated_by AS last_updated_by,
				events.last_update AS last_update,
				events.date_added AS date_added
			FROM events
			JOIN eventplanner ON events.planner_id = eventplanner.planner_id
			WHERE events.planner_id = ? 
			GROUP BY events.event_type;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$planner_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}


function insertEvent($pdo, $event_name, $event_type, $planner_id, $added_by, $user_id) {
	$sql = "INSERT INTO events (event_name, event_type, planner_id, added_by, user_id) VALUES (?,?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$event_name, $event_type, $planner_id, $added_by, $user_id]);
	if ($executeQuery) {
		$update_id = $pdo->lastInsertId();
		insertAuditLog($pdo, $added_by, 'Insert', 'Event Planner', $update_id, 'Added an Event');
		return true;
	}

}

function getEventByID($pdo, $event_id) {
	$sql = "SELECT 
				events.event_id AS event_id,
				events.event_name AS event_name,
				events.event_type AS event_type,
				events.date_added AS date_added,
				CONCAT(eventplanner.planner_first_name,' ',eventplanner.planner_last_name) AS event_coordinator,
				events.added_by AS added_by,
				events.last_updated_by AS last_updated_by,
				events.last_update AS last_update
			FROM events
			JOIN eventplanner ON events.planner_id = eventplanner.planner_id
			WHERE events.event_id = ?;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$event_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateEvent($pdo, $event_name, $event_type, $last_updated_by, $event_id) {
	$sql = "UPDATE events
			SET event_name = ?,
				event_type = ?,
				last_updated_by = ?
			WHERE event_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$event_name, $event_type, $last_updated_by, $event_id]);

	if ($executeQuery) {
		insertAuditLog($pdo, $last_updated_by, 'Update', 'Events', $event_id, 'Updated an Event');
		return true;
	}
}

function deleteEvent($pdo, $deleted_by, $event_id) {

	$sql = "DELETE FROM events WHERE event_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$event_id]);
	if ($executeQuery) {
		insertAuditLog($pdo, $deleted_by, 'Delete', 'Events', $event_id, 'Deleted an Event');
		return true;
	}
}


function insertNewUser($pdo, $username, $first_name, $last_name, $password) {

	$checkUserSql = "SELECT * FROM user_db WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_db (username, first_name, last_name, password) VALUES(?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $first_name, $last_name, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_db WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$userIDFromDB = $userInfoRow['user_id']; 
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Logout successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "Password is invalid, but user exists";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username doesn't exist.";
	}

}


function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_db";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_db WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updateUserInfo($pdo, $first_name, $last_name, $user_id) {
	$sql = "UPDATE user_db 
			SET first_name = ?, 
				last_name = ? 
			WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt) {
		return $stmt->execute([$first_name, $last_name, $user_id]);
	}


}

function insertAuditLog($pdo, $username, $action, $table_name, $update_id, $action_details)
{
  $sql = "INSERT INTO audit_log (username, action, table_name, update_id, action_details) VALUES (?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username, $action, $table_name, $update_id, $action_details]);
}

function getAllAuditLog($pdo)
{
  $sql = "SELECT * FROM audit_log";
  $stmt = $pdo->prepare($sql);
  $executeQuery = $stmt->execute();

  if ($executeQuery) {
    return $stmt->fetchAll();
  }

}
