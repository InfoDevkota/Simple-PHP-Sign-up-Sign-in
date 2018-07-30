<?php
	include "connect.php";
	$sql ="CREATE TABLE user(
	  id INT(6) AUTO_INCREMENT PRIMARY KEY,
	  userName VARCHAR(60) NOT NULL unique,
	  userPass VARCHAR(60) NOT NULL)";

	if ($conn->query($sql) === TRUE) {
    		echo "Table 'User' created successfully";
	} else {
    		echo "Error creating table: " . $conn->error;
	}
	$conn->close();
?>
