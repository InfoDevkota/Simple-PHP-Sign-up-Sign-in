<?php
//signin.php
include 'connect.php';
include 'header.php';
if(isset($_SESSION ["user_name"]))//Check if user already Sign In?
{
	echo 'You are already signed in, you can <a href="signout.php">Sign Out</a> if you want.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] !='POST')
	{
		/*page called first time so display form and set action to this page. */
		echo '<form method="post" action="">
		Username: <input type="text" name="user_name" />
		<br>
		<br>
		Password: <input type="password" name="user_pass">
		<br>
		<br>
		<input name="submit" type="submit" value="sign in" />
		</form>';
	}
	else
	{
	/* so, the form has been posted, we'll process the data in three steps:
	1. Check the data
	2. Let the user refill the wrong fields (if necessary)
	3. Varify if the data is correct and return the correct response
	*/
	$errors = array(); /* declare the array for later use */
	if(!isset($_POST['user_name']))
	{
		$errors[] = 'The username field must not be empty.';
	}
	if(!isset($_POST['user_pass']))
	{
		$errors[] = 'The password field must not be empty.';
	}
	if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array */
	{
		echo 'Uh-oh.. a couple of fields are not filled in correctly..';
		echo '<ul>';
		foreach($errors as $key => $value)
		{
			echo
			'<li>' . $value . '</li>'; /* this generates a nice error list */
		}
		echo '</ul>';
	}
	else
	{
		//the form has been posted without errors, so save it
		//notice the use of mysqli_real_escape_string, keep everything safe! (SQL Injection)
		//also notice the sha1 function which hashes the password
		$sql = "SELECT id, userName
		FROM user
		WHERE userName = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "'
		AND userPass = '" . sha1($_POST['user_pass']) . "'";
		$result = mysqli_query($conn, $sql);
		if(!$result)
		{
			echo 'Something went wrong while signing in. Please try again later.';
		}
		else
		{
			//the query was successfully executed, there are 2 possibilities
			//1. the query returned data, the user can be signed in
			//2. the query returned an empty result set, the credentials were wrong
			if(mysqli_num_rows($result) == 0)
			{
				echo 'You have supplied a wrong user/password combination. Please try again.';
			}
			else
			{
				//we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
				while ($row = mysqli_fetch_assoc($result))
				{
				$_SESSION["user_id"] = $row['id'];
				$_SESSION["user_name"] = $row['userName'];
				}
				echo 'Welcome, ' . $_SESSION["user_name"] .'. <a href="index.php">Proceed to Your Project</a>.';
			}
		}
	}
	}
}
?>
