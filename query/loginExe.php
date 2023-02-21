<?php
session_start();
include("../conn.php");

// Extract input values from POST
$username = $_POST['username'];
$pass = $_POST['pass'];

// Prepare a query to select examinee information by email and password
$query = "SELECT * FROM examinee_tbl WHERE exmne_email = :email AND exmne_password = :password";
$stmt = $conn->prepare($query);

// Bind input parameters to the prepared statement
$stmt->bindParam(':email', $username);
$stmt->bindParam(':password', $pass);

// Execute the prepared statement
$stmt->execute();

// Check if a matching row was found
if ($stmt->rowCount() > 0) {
  // Get the examinee's information from the first row of the result set
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Create a new session variable to indicate that the examinee is logged in
  $_SESSION['examineeSession'] = array(
    'exmne_id' => $row['exmne_id'],
    'examineenakalogin' => true
  );

  // Set the response to "success"
  $res = array("res" => "success");
} else {
  // Set the response to "invalid"
  $res = array("res" => "invalid");
}

// Return the response as a JSON object
echo json_encode($res);
