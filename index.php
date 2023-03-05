<?php require("register.class.php") ?>
<?php
	if(isset($_POST['submit'])){
		$user = new RegisterUser($_POST['login'], $_POST['password'],$_POST['confirm_password'],$_POST['email'],$_POST['name']);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="stylesheet" href="styles.css">
	<title>Register form</title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
		<h2>Register form</h2>
		<h4>Both fields are <span>required</span></h4>

		<label>Login</label>
		<input type="text" name="login">

		<label>Password</label>
		<input type="password" name="password">

		<label>Confirm_Password</label>
		<input type="password" name="confirm_password">

		<label>Email</label>
		<input type="email" name="email">

		<label>Name</label>
		<input type="text" name="name">
    	<button type="submit" class="btn" name="submit">Register</button>

		<p class="error"><?php echo @$user->error ?></p>
		<p class="success"><?php echo @$user->success ?></p>
	</form>

</body>
</html>