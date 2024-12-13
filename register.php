<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> 
</head>
<body>

<?php
    session_start();
?>
<form action = "register-submit.php" method = "POST">
    <fieldset>
        <h1>Register</h1>
        <label for = "username"><strong>Username:</strong></label>
        <input type = "text" size = "20" name = "Username" placeholder="Username" required></br>
        <label for = "password"><strong>Password:</strong></label>
        <input type = "password" size = "20" name = "Password" placeholder="Password" required></br>
        <input type = "submit" name ="Submit" value = "Register">
        <p>Already have an account? <a href="login.php">Log in Now!</a></p>
    </fieldset>  
</form>

</body>
</html>