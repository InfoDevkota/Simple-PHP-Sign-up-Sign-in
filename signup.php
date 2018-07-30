<?php
	//signup.php
	include 'connect.php';
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
	/*This page is first requested so Display the Form and set action to this page */
	echo '<form method="post" action="">
			Username: <input type="text" name="user_name" />
			<br>
			<br>
			Password: <input type="password" name="user_pass">
			<br>
			<br>
			Password again: <input type="password" name="user_pass_check">
			<br>
			<br>
			E-mail: <input type="email" name="user_email">
			<br>
			<br>
			<input type="submit" value="Sign Up" />
		</form>';
	} else {
		/* so, the form has been posted, we'll process the data in three steps:
		1. Check the data
		2. Let the user refill the wrong fields (if necessary)
		3. Save the data
		*/

		$errors = array(); /* declare the array for later use */

		if(isset($_POST['user_name']))
		{
			if(!ctype_alnum($_POST['user_name']))
			{
				$errors[] = 'The username can only contain letters and digits.';
			}
			if(strlen($_POST['user_name']) > 30)
			{
				$errors[] = 'The username cannot be longer than 30 characters.';
			}
		}
		else
		{
			$errors[] = 'The username field must not be empty.';
		}
		if(isset($_POST['user_pass']))
		{
			if($_POST['user_pass'] != $_POST['user_pass_check'])
			{
				$errors[] = 'The two passwords did not match.';
			}
		}
		else
		{
			$errors[] = 'The password field cannot be empty.';
		}

		if(!empty($errors))
		{
			echo 'Uh-oh.. a couple of fields are not filled in correctly..';
			echo '<ul>';
			foreach($errors as $key => $value)
			{
				echo '<li>' . $value .
				'</li>';
			}
			echo '</ul>';
		}
		else
		{
			$sql = "INSERT INTO
			user(userName, userPass, email)
			VALUES('" . mysqli_real_escape_string($conn, $_POST['user_name']) . "', '" . sha1($_POST['user_pass']) . "', '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "')";
			$result = mysqli_query($conn, $sql);
			if(!$result)
			{
				echo 'Something went wrong while registering. Please try again later.';
			}
			else
			{
				echo 'Successfully registered. You can now <a href="signin.php">Sign In</a>';
			}
		}
	}
?>
