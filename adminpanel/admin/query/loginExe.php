<?php 
session_start();
include("../../../conn.php");

// Extract input values from POST
$username = $_POST['username'];
$pass = $_POST['pass'];

// Prepare a query to select admin account information by username and password
$query = "SELECT * FROM admin_acc WHERE admin_user = :username AND admin_pass = :password";
$stmt = $conn->prepare($query);

// Bind input parameters to the prepared statement
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $pass);

// Execute the prepared statement
$stmt->execute();

// Check if a matching row was found
if ($stmt->rowCount() > 0) {
  // Get the admin's information from the first row of the result set
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Create a new session variable to indicate that the admin is logged in
  $_SESSION['admin'] = array(
    'admin_id' => $row['admin_id'],
    'adminnakalogin' => true
  );

  // Set the response to "success"
  $res = array("res" => "success");
} else {
  // Set the response to "invalid"
  $res = array("res" => "invalid");
}

// Return the response as a JSON object
echo json_encode($res);
